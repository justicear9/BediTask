<?php

namespace App\Controllers;

class Updates extends Security_Controller {

    /** @var string Last cURL / transport error for logging (non-download requests). */
    private string $lastLicenseTransportError = '';

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
    }

    private function _license_remote_bypass_enabled(): bool {
        return rise_skip_fairsketch_license();
    }

    /**
     * Hostname sent to FairSketch (no port). Matches typical purchase registration.
     */
    private function _verification_domain(): string {
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        if ($host !== '' && $host[0] === '[' && preg_match('/^\[([^\]]+)\](?::\d+)?$/', $host, $m)) {
            return $m[1];
        }

        return preg_replace('/:\d+$/', '', $host);
    }

    private function _default_app_update_url(): string {
        return (string) (config('Rise')->app_settings_array['app_update_url'] ?? 'https://releases.fairsketch.com/rise/');
    }

    /**
     * @return string[]
     */
    private function _parse_license_response_lines(string $body): array {
        $body = trim($body);
        if ($body === '') {
            return [];
        }
        $parts = preg_split('/\s*<br\s*\/?>\s*|\s*\R+/i', $body, -1, PREG_SPLIT_NO_EMPTY);

        return is_array($parts) ? array_map('trim', $parts) : [];
    }

    private function _network_unreachable_message(): string {
        $msg = "Could not reach the update server (https://releases.fairsketch.com). Check PHP cURL/OpenSSL, firewall, and DNS. ";
        if ($this->lastLicenseTransportError !== '') {
            log_message('error', 'Updates transport: ' . $this->lastLicenseTransportError);
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                $msg .= 'Detail: ' . $this->lastLicenseTransportError . ' ';
            }
        }
        $msg .= 'See application logs for more.';

        return $msg;
    }

    function index() {

        $updates_info = $this->_get_updates_info();

        $view_data['supported_until'] = null;
        $view_data['has_support'] = false;
        $view_data['license_error'] = "";

        if ($updates_info->error) {
            $view_data['license_error'] = $updates_info->error;
        } else {

            $supported_until = $this->_get_support_info();

            if ($supported_until && strlen($supported_until) == 10) {
                $view_data['supported_until'] = format_to_date($supported_until, false);

                $now = get_my_local_time();

                $diff_seconds = strtotime($supported_until) - strtotime($now);

                if ($diff_seconds > 0) {
                    $view_data['has_support'] = true;
                }
            }
        }

        $view_data['installable_updates'] = $updates_info->installable_updates;
        $view_data['downloadable_updates'] = $updates_info->downloadable_updates;
        $view_data['current_version'] = $updates_info->current_version;

        $item_purchase_code = get_setting("item_purchase_code");
        if ($item_purchase_code) {
            $view_data['last4_digits_of_purchase_code'] = substr($item_purchase_code, -4);
        }

        $view_data['installation_disabled'] = get_setting("disable_installation") ? true : false;

        return $this->template->rander("updates/index", $view_data);
    }

    private function _curl_get_contents($url, $download = false) {
        $this->lastLicenseTransportError = '';

        if (!function_exists('curl_init')) {
            $this->lastLicenseTransportError = 'PHP cURL extension is not loaded.';

            return $download ? array("data" => "", "file_name" => "") : false;
        }

        $ch = curl_init();
        $file_name = "";
        $file_data = "";

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/plain'));

        if ($download) {

            // Extract filename from headers
            curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $header) use (&$file_name) {
                if (preg_match('/^Content-Disposition:.*filename="([^"]+)"/i', $header, $matches)) {
                    $file_name = $matches[1];
                }
                return strlen($header);
            });

            // Stream each chunk 
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $chunk) use (&$file_data) {
                $file_data .= $chunk;  // append chunk 
                return strlen($chunk);
            });
        } else {

            curl_setopt($ch, CURLOPT_HEADER, 0);
        }

        $data = curl_exec($ch);
        $errno = curl_errno($ch);
        $cerr = curl_error($ch);
        curl_close($ch);

        if ($errno !== 0) {
            $this->lastLicenseTransportError = "cURL {$errno}: {$cerr}";
        }

        if ($download) {
            if ($errno !== 0) {
                return array("data" => "", "file_name" => "");
            }

            return array("data" => $file_data, "file_name" => $file_name);
        }

        if ($errno !== 0 || $data === false) {
            return false;
        }

        return $data;
    }

    private function _get_release_contents($url, $download = false) {
        $curl_data = $this->_curl_get_contents($url, $download);

        //try with file_get_contents 
        if ($curl_data === false || ($download === false && $curl_data === '')) {
            try {
                $ctx = stream_context_create(array(
                    'http' => array('timeout' => 90),
                    'ssl' => array('verify_peer' => true, 'verify_peer_name' => true),
                ));
                $curl_data = @file_get_contents($url, false, $ctx);
                if ($curl_data === false) {
                    $err = error_get_last();
                    if (is_array($err) && isset($err['message'])) {
                        $this->lastLicenseTransportError = $this->lastLicenseTransportError ?: $err['message'];
                    }
                }
            } catch (\Exception $e) {
                log_message("error", $e->getMessage());
                $this->lastLicenseTransportError = $this->lastLicenseTransportError ?: $e->getMessage();
                $curl_data = null;
            }
        }

        return $curl_data;
    }

    private function _get_support_info() {

        if ($this->_license_remote_bypass_enabled()) {
            return null;
        }

        $url = $this->_get_verification_url("update", 1);

        return $this->_get_release_contents($url);
    }

    private function _get_updates_info() {

        ini_set('max_execution_time', 180);

        $current_version = get_setting("app_version");

        $local_updates_dir = get_setting("updates_path");

        $error = "";
        $next_installable_version = "";
        $none_installed_versions = array();
        $installable_updates = array();
        $downloadable_updates = array();

        $disable_installation = get_setting("disable_installation");
        if ($disable_installation) {

            $error = "You've disabled the license for this site.";
        } else if ($this->_license_remote_bypass_enabled()) {
            // Local host (127.0.0.1, localhost, ::1) or RISE_DEV_LICENSE: no FairSketch request.
        } else {

            $purchase_code = trim((string) get_setting("item_purchase_code"));
            if ($purchase_code === '') {
                $error = "No purchase code is saved. Add your RISE purchase code in Settings, then open Updates again.";
            } else {

                $url = $this->_get_verification_url("update");
                $releases_raw = $this->_get_release_contents($url);

                if ($releases_raw === false || $releases_raw === null || $releases_raw === '') {
                    $error = $this->_network_unreachable_message();
                } else {

                    $lines = $this->_parse_license_response_lines((string) $releases_raw);
                    $first = $lines[0] ?? '';

                    if ($first === 'verification_failed') {
                        $domain = $this->_verification_domain();
                        $error = "License verification failed. Confirm your purchase code, ensure this installation URL is registered for that code (domain sent: {$domain}, without port), and that the code is not already in use on another site.";
                    } else {

                        foreach ($lines as $version) {
                            if ($version === '' || $version === 'verification_failed') {
                                continue;
                            }
                            if (version_compare($version, $current_version) > 0) {
                                if (!$next_installable_version) {
                                    $next_installable_version = $version;
                                }
                                $none_installed_versions[] = $version;
                            }
                        }

                        foreach ($none_installed_versions as $version) {

                            $matching_files = glob($local_updates_dir . $version . '*.zip');
                            if (!empty($matching_files)) {
                                $installable_updates[] = $version;
                            } else {
                                $downloadable_updates[] = $version;
                            }
                        }
                    }
                }
            }
        }

        $info = new \stdClass();
        $info->current_version = $current_version;
        $info->error = $error;
        $info->none_installed_versions = $none_installed_versions;
        $info->installable_updates = $installable_updates;
        $info->downloadable_updates = $downloadable_updates;
        $info->next_installable_version = $next_installable_version;
        return $info;
    }

    function download_updates($version = "") {

        $local_updates_dir = get_setting("updates_path");

        // Look for any .zip file that starts with the version number
        $matching_files = glob($local_updates_dir . $version . '*.zip');
        if (!empty($matching_files)) {

            echo json_encode(array("success" => true, 'message' => "File already exists"));
        } else {

            ini_set('max_execution_time', 300); //300 seconds 

            $download_url = $this->_get_verification_url("download", 0, $version);

            //get updates from remote
            $new_update = $this->_get_release_contents($download_url, true);

            $data = get_array_value($new_update, 'data');
            $file_name = get_array_value($new_update, 'file_name');
            if (!($new_update && $data && $file_name)) {
                echo json_encode(array("success" => false, 'message' => "Sorry, Version - $version download has been failed!"));
                exit();
            }

            $update_zip = $local_updates_dir . $file_name;

            //crate updates folder if required
            if (!is_dir($local_updates_dir)) {
                if (!@mkdir($local_updates_dir)) {
                    echo json_encode(array("success" => false, 'message' => "Permission denied: $local_updates_dir directory is not writeable! Please set the writeable permission to the directory"));
                    exit();
                }
            }

            if (file_put_contents($update_zip, $data)) {
                echo json_encode(array("success" => true, 'message' => "Downloaded version-" . $version));
            } else {
                echo json_encode(array("success" => false, 'message' => $version . " - Download failed!"));
            }
        }
    }

    function do_update($version = "", $file_hash = "", $acknowledged = 0) {
        ini_set('max_execution_time', 300); //300 seconds 
        if (!$version || !$file_hash) {
            echo json_encode(array("success" => false, 'message' => app_lang("something_went_wrong")));
            exit();
        }

        //check the sequential updates
        $updates_info = $this->_get_updates_info();
        if ($updates_info->next_installable_version != $version) {
            echo json_encode(array("success" => false, 'message' => "Please install the version - $updates_info->next_installable_version first!"));
            exit();
        }


        $local_updates_dir = get_setting("updates_path");

        if (!class_exists('ZipArchive')) {
            echo json_encode(array("success" => false, 'message' => "Please install the ZipArchive php extension in your server."));
            exit();
        }

        $zip = new \ZipArchive;
        $update_file = $local_updates_dir . $version . "-" . $file_hash . '.zip';
        $zip->open($update_file);

        $executeable_file = "";

        $env_checker_file = "env_checker.php";
        $removeable_env_checker_file_path = "";
        if ($zip->locateName($env_checker_file) !== false) {
            file_put_contents($env_checker_file, $zip->getFromName($env_checker_file));
            $removeable_env_checker_file_path = $env_checker_file;
            $check_result = include($env_checker_file);
            if (get_array_value($check_result, "response_type") == "success") {
                //can update...
            } else if ($acknowledged != "1" && get_array_value($check_result, "response_type") == "acknowledgement_required") {
                unlink($removeable_env_checker_file_path); //remove the env checker file
                echo json_encode(array("response_type" => "acknowledgement_required", 'message' => get_array_value($check_result, "message")));
                exit();
            } else if (get_array_value($check_result, "response_type") == "error") {
                unlink($removeable_env_checker_file_path); //remove the env checker file
                echo json_encode(array("response_type" => "error", 'message' => get_array_value($check_result, "message")));
                exit();
            }
        }


        for ($i = 0; $i < $zip->numFiles; $i++) {
            $file_info_array = $zip->statIndex($i);
            $file_name = get_array_value($file_info_array, "name");
            $dir = dirname($file_name);

            if (substr($file_name, -1, 1) == '/') {
                continue;
            }

            //create new directory if it's not exists
            if (!is_dir('./' . $dir)) {
                mkdir('./' . $dir, 0755, true);
            }

            //overwrite the existing file
            if (!is_dir('./' . $file_name)) {
                $contents = $zip->getFromIndex($i);
                //execute command if required
                if ($file_name == 'execute.php') {
                    $executeable_file = $file_name;
                }
                file_put_contents($file_name, $contents);
            }
        }

        $zip->close();

        //has an executeable file. run it.
        if ($executeable_file) {
            include($executeable_file);
            unlink($executeable_file); //delete the file for security purpose and it's not required to keep in root directory
        }

        if ($removeable_env_checker_file_path) {
            unlink($removeable_env_checker_file_path); //remove the env checker file
        }

        //remove the zip
        if (is_file($update_file)) {
            unlink($update_file);
        }

        echo json_encode(array("response_type" => "success", 'message' => "Version - $version installed successfully!"));
    }

    function systeminfo() {
        phpinfo();
    }

    private function _get_verification_url($type = "", $details = 0, $version = "") {
        $item_purchase_code = get_setting("item_purchase_code");
        $app_update_url = get_setting("app_update_url");
        if ($app_update_url === '' || $app_update_url === null) {
            $app_update_url = $this->_default_app_update_url();
        }

        if (!$version) {
            $version = get_setting("app_version");
        }

        $item_purchase_code = urlencode(trim((string) $item_purchase_code));
        $domain = rawurlencode($this->_verification_domain());
        $url = rtrim((string) $app_update_url, '/') . "/?api_version=2&type=$type&code=" . $item_purchase_code . "&domain=" . $domain . "&version=" . $version;
        if ($details) {
            $url .= "&details=1";
        }

        if ($type === "disable_installation") {
            $url .= "&app_verification_key=" . rawurlencode((string) get_setting("app_verification_key"));
        }

        return $url;
    }

    function verify() {
        if ($this->_license_remote_bypass_enabled()) {
            $this->Settings_model->save_setting("app_verification_key", rise_build_local_app_verification_key());
            app_redirect("Updates");
        }

        $url = $this->_get_verification_url("install");
        $verification = trim((string) $this->_get_release_contents($url));

        if ($verification === '' || !str_starts_with($verification, 'verified')) {
            $msg = "Sorry, we are unable to verify your license.";
            if (trim((string) get_setting("item_purchase_code")) === '') {
                $msg = "No purchase code is saved. Add your code in Settings first.";
            } else if ($verification === false || $verification === '') {
                $msg = $this->_network_unreachable_message();
            } else {
                $msg .= " Domain sent: " . $this->_verification_domain() . ". Confirm it matches your license registration.";
            }
            $this->session->setFlashdata("error_message", $msg);
            app_redirect("Updates");
        }

        $app_verification_key = substr($verification, 8);
        $this->Settings_model->save_setting("app_verification_key", $app_verification_key);

        app_redirect("Updates");
    }

    function disable_installation() {
        $url = $this->_get_verification_url("disable_installation");
        $disabled = $this->_get_release_contents($url);

        if ($disabled == "disabled") {
            $this->Settings_model->save_setting("app_verification_key", "");
            $this->Settings_model->save_setting("disable_installation", "1");

            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, 'message' => "License switch limit reached. Please contact Support or buy a new license to continue."));
        }
    }

    function enable_installation() {
        if ($this->_license_remote_bypass_enabled()) {
            $this->Settings_model->save_setting("app_verification_key", rise_build_local_app_verification_key());
            $this->Settings_model->save_setting("disable_installation", "0");
            echo json_encode(array("success" => true));
            exit();
        }

        $url = $this->_get_verification_url("enable_installation");
        $verification = trim((string) $this->_get_release_contents($url));

        if ($verification === '' || !str_starts_with($verification, 'verified')) {
            $msg = "We’re unable to verify your license. Please make sure this purchase code is not being used on another site.";
            if (trim((string) get_setting("item_purchase_code")) === '') {
                $msg = "No purchase code is saved. Add your code in Settings first.";
            } else if ($verification === false || $verification === '') {
                $msg = $this->_network_unreachable_message();
            } else {
                $msg .= " Domain sent: " . $this->_verification_domain() . ".";
            }
            echo json_encode(array("success" => false, 'message' => $msg));
            exit();
        }

        $app_verification_key = substr($verification, 8);
        $this->Settings_model->save_setting("app_verification_key", $app_verification_key);
        $this->Settings_model->save_setting("disable_installation", "0");

        echo json_encode(array("success" => true));
    }
}

/* End of file Updates.php */
/* Location: ./app/controllers/Updates.php */