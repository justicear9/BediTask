<?php

namespace Assets_Management\Controllers;

class Assets_management extends \App\Controllers\Security_Controller {

    protected $Assets_model;
    protected $Asset_groups_model;
    protected $Asset_units_model;
    protected $Asset_locations_model;
    protected $Asset_actions_model;

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
        $this->Assets_model = new \Assets_Management\Models\Assets_model();
        $this->Asset_groups_model = new \Assets_Management\Models\Asset_groups_model();
        $this->Asset_units_model = new \Assets_Management\Models\Asset_units_model();
        $this->Asset_locations_model = new \Assets_Management\Models\Asset_locations_model();
        $this->Asset_actions_model = new \Assets_Management\Models\Asset_actions_model();
    }

    /* load assets view */

    function index() {
        return $this->template->rander("Assets_Management\Views\assets\index");
    }

    /* load asset add/edit modal */

    function modal_form() {
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Assets_model->get_one($this->request->getPost('id'));
        $view_data['units_dropdown'] = $this->Asset_units_model->get_dropdown_list(array("title"));
        $view_data['groups_dropdown'] = $this->Asset_groups_model->get_dropdown_list(array("title"));

        $locations = $this->Asset_locations_model->get_details()->getResult();
        $locations_dropdown = array("" => "-");

        if ($locations) {
            foreach ($locations as $location) {
                $locations_dropdown[$location->id] = $location->title;
            }
        }

        $view_data['locations_dropdown'] = $locations_dropdown;

        return $this->template->view('Assets_Management\Views\assets\modal_form', $view_data);
    }

    /* insert or update an asset */

    function save() {
        $id = $this->request->getPost('id');

        //check duplicate asset code, if found then show an error message
        if ($this->Assets_model->is_asset_code_exists($this->request->getPost('asset_code'), $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang('assets_duplicate_asset_code')));
            exit();
        }

        $this->validate_submitted_data(array(
            "id" => "numeric",
            "asset_code" => "required",
            "asset_name" => "required"
        ));

        $now = get_current_utc_time();

        $asset_code = $this->request->getPost('asset_code');
        $quantity = $this->request->getPost('quantity');
        $unit_price = $this->request->getPost('unit_price');
        $group_id = $this->request->getPost('group_id');
        $location_id = $this->request->getPost('location_id');
        $series = $this->request->getPost('series');
        $description = $this->request->getPost('description');

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "assets_management");
        $new_files = unserialize($files_data);

        $data = array(
            "asset_code" => $asset_code,
            "asset_name" => $this->request->getPost('asset_name'),
            "quantity" => $quantity,
            "unit_id" => $this->request->getPost('unit_id'),
            "group_id" => $group_id ? $group_id : 0,
            "location_id" => $location_id ? $location_id : 0,
            "series" => $series ? $series : '',
            "purchase_date" => $this->request->getPost('purchase_date'),
            "warranty_period" => $this->request->getPost('warranty_period'),
            "unit_price" => $unit_price,
            "depreciation" => $this->request->getPost('depreciation'),
            "supplier_name" => $this->request->getPost('supplier_name'),
            "supplier_phone" => $this->request->getPost('supplier_phone'),
            "supplier_address" => $this->request->getPost('supplier_address'),
            "description" => $description
        );

        if ($id) {
            $asset_info = $this->Assets_model->get_one($id);
            $timeline_file_path = get_setting("timeline_file_path");

            $new_files = update_saved_files($timeline_file_path, $asset_info->files, $new_files);
        }

        $data["files"] = serialize($new_files);

        if (!$id) {
            $data["added_by"] = $this->login_user->id;
            $data["created_date"] = $now;
        }

        $save_id = $this->Assets_model->ci_save($data, $id);
        if ($save_id) {

            //save a copy of newly added asset data for inventory history
            if (!$id) {
                $action_data = array(
                    "action_code" => $asset_code,
                    "asset_id" => $save_id,
                    "quantity" => $quantity,
                    "cost" => $quantity * $unit_price,
                    "action_type" => "new",
                    "opening_stock" => 0,
                    "closing_stock" => $quantity,
                    "description" => $description,
                    "added_by" => $this->login_user->id,
                    "action_time" => $now
                );

                $this->Asset_actions_model->ci_save($action_data);
            }
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* delete an asset */

    function delete() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');

        $model_info = $this->Assets_model->get_one($id);

        if ($model_info->added_by != $this->login_user->id) {
            app_redirect("forbidden");
        }

        if ($this->Assets_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
        }
    }

    /* list of assets, prepared for datatable  */

    function list_data() {
        $list_data = $this->Assets_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of asset list table */

    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Assets_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    /* prepare a row of asset list table */

    private function _make_row($data) {
        $title = anchor(get_uri("assets_management/view/" . $data->id), $data->asset_name);
        $original_price = $data->quantity * $data->unit_price;

        $action = modal_anchor(get_uri("assets_management/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('assets_edit_asset'), "data-post-id" => $data->id))
                . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('assets_delete_asset'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("assets_management/delete"), "data-action" => "delete-confirmation"));

        return array(
            anchor(get_uri("assets_management/view/" . $data->id), $data->id),
            anchor(get_uri("assets_management/view/" . $data->id), $data->asset_code),
            $title,
            $data->asset_group_name,
            $data->asset_unit_name,
            format_to_date($data->purchase_date, false),
            $data->total_allocation ? $data->total_allocation : 0,
            $data->quantity - $data->total_allocation,
            to_currency($original_price),
            $action
        );
    }

    /* upload a post file */

    function upload_file() {
        upload_file_to_temp();
    }

    /* check valid file for asset */

    function validate_assets_file() {
        $file_name = $this->request->getPost("file_name");
        if (!is_valid_file_to_upload($file_name)) {
            echo json_encode(array("success" => false, 'message' => app_lang('invalid_file_type')));
            exit();
        }

        if (is_image_file($file_name)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('please_upload_valid_image_files')));
        }
    }

    function file_preview($id = "", $key = "") {
        if ($id) {
            validate_numeric_value($id);
            $asset_info = $this->Assets_model->get_one($id);
            $files = unserialize($asset_info->files);
            $file = get_array_value($files, $key);

            $file_name = get_array_value($file, "file_name");
            $file_id = get_array_value($file, "file_id");
            $service_type = get_array_value($file, "service_type");

            $view_data["file_url"] = get_source_url_of_file($file, get_setting("timeline_file_path"));
            $view_data["is_image_file"] = is_image_file($file_name);
            $view_data["is_iframe_preview_available"] = is_iframe_preview_available($file_name);
            $view_data["is_google_preview_available"] = is_google_preview_available($file_name);
            $view_data["is_viewable_video_file"] = is_viewable_video_file($file_name);
            $view_data["is_google_drive_file"] = ($file_id && $service_type == "google") ? true : false;
            $view_data["is_iframe_preview_available"] = is_iframe_preview_available($file_name);

            return $this->template->view("Assets_Management\Views\assets\\file_preview", $view_data);
        } else {
            show_404();
        }
    }

    /* load asset details view */

    function view($asset_id = 0) {
        validate_numeric_value($asset_id);

        if ($asset_id) {
            $asset_info = $this->Assets_model->get_details(array("id" => $asset_id))->getRow();

            if ($asset_info) {
                $view_data['asset_info'] = $asset_info;
                $view_data["asset_id"] = $asset_id;

                //depreciation value
                $date = get_today_date();
                //60 seconds * 60 minutes * 24 hours * avg days in a month
                $month = (strtotime($date) - strtotime($asset_info->purchase_date)) / (60 * 60 * 24 * 30.42);
                $depreciation_per_month = ($asset_info->unit_price * $asset_info->quantity) / $asset_info->depreciation;
                $depreciation_value = $month * $depreciation_per_month;
                $view_data["depreciation_value"] = to_currency($depreciation_value);

                //residual value
                $view_data["residual_value"] = to_currency($asset_info->unit_price * $asset_info->quantity - $depreciation_value);

                return $this->template->rander("Assets_Management\Views\assets\\view", $view_data);
            } else {
                show_404();
            }
        }
    }

    /* load add modal for asset actions */

    function action_modal_form() {
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        $id = $this->request->getPost("id");
        $asset_id = $this->request->getPost("asset_id");
        $view_data["asset_id"] = $asset_id;
        $view_data["action_type"] = $this->request->getPost("action_type");

        //prepare assign to list
        $assigned_to_dropdown = array("" => "- " . app_lang("user") . " -") + $this->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", array("deleted" => 0, "user_type" => "staff"));

        $view_data['user_dropdown'] = $assigned_to_dropdown;
        $Asset_action_last_id = $this->Asset_actions_model->get_asset_action_last_id(array("asset_id" => $asset_id));

        $view_data['model_info'] = $this->Asset_actions_model->get_one($id);
        $view_data['asset_info'] = $this->Assets_model->get_details(array("id" => $asset_id))->getRow();
        $view_data['last_asset_action_info'] = $this->Asset_actions_model->get_one($Asset_action_last_id);
        $view_data['broken_asset_amonut'] = $this->Asset_actions_model->get_broken_asset_amonut();

        return $this->template->view('Assets_Management\Views\assets\actions\modal_form', $view_data);
    }

    /* insert an action */

    function save_action() {
        $id = $this->request->getPost('id');

        //check duplicate asset code, if found then show an error message
        if ($this->Asset_actions_model->is_action_code_exists($this->request->getPost('action_code'), $id)) {
            echo json_encode(array("success" => false, 'message' => app_lang('assets_duplicate_action_code')));
            exit();
        }

        $this->validate_submitted_data(array(
            "asset_id" => "required|numeric",
            "action_type" => "required",
            "action_code" => "required",
            "quantity" => "required"
        ));

        $asset_id = $this->request->getPost('asset_id');
        $action_type = $this->request->getPost('action_type');
        $receiver_id = $this->request->getPost('receiver_id');
        $provider_id = $this->request->getPost('provider_id');
        $quantity = $this->request->getPost('quantity');
        $cost = $this->request->getPost('cost');
        $opening_stock = $this->request->getPost('opening_stock');
        $now = get_current_utc_time();

        $asset_info = $this->Assets_model->get_one($asset_id);

        if ($action_type == "allocation" || $action_type == "report_lost" || $action_type == "liquidation") {
            $closing_stock = $opening_stock - $quantity;
        } else if ($action_type == "revoke") {
            $closing_stock = $opening_stock + $quantity;
        } else if ($action_type == "additional") {
            $closing_stock = $opening_stock + $quantity;
            $cost = $quantity * $asset_info->unit_price;
        } else if ($action_type == "broken" || $action_type == "warranty") {
            $closing_stock = $opening_stock;
        }

        $data = array(
            "action_code" => $this->request->getPost('action_code'),
            "asset_id" => $asset_id,
            "action_type" => $action_type,
            "quantity" => $quantity,
            "cost" => $cost,
            "action_location" => $this->request->getPost('action_location'),
            "receiver_id" => $receiver_id ? $receiver_id : 0,
            "provider_id" => $provider_id ? $provider_id : 0,
            "opening_stock" => $opening_stock,
            "closing_stock" => $closing_stock,
            "description" => $this->request->getPost('description')
        );

        if (!$id) {
            $data["added_by"] = $this->login_user->id;
            $data["action_time"] = $now;
        }

        $save_id = $this->Asset_actions_model->ci_save($data, $id);
        if ($save_id) {
            if ($action_type == "allocation") {
                $allocation_data["total_allocation"] = $asset_info->total_allocation + $quantity;
                $this->Assets_model->ci_save($allocation_data, $asset_id);
            } else if ($action_type == "revoke") {
                $allocation_data["total_allocation"] = $asset_info->total_allocation - $quantity;
                $this->Assets_model->ci_save($allocation_data, $asset_id);
            } else if ($action_type == "additional") {
                $allocation_data["quantity"] = $asset_info->quantity + $quantity;
                $this->Assets_model->ci_save($allocation_data, $asset_id);
            } else if ($action_type == "report_lost" || $action_type == "liquidation") {
                $allocation_data["quantity"] = $asset_info->quantity - $quantity;
                $this->Assets_model->ci_save($allocation_data, $asset_id);
            }

            echo json_encode(array("success" => true, "data" => $this->_inventory_history_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    /* load inventory history view */

    function inventory_history($asset_id) {
        $view_data["asset_id"] = $asset_id;

        return $this->template->view("Assets_Management\Views\assets\inventory_history", $view_data);
    }

    /* list of inventory history, prepared for datatable  */

    function inventory_history_list_data($asset_id) {
        $list_data = $this->Asset_actions_model->get_details(array("asset_id" => $asset_id))->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_inventory_history_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of inventory history list  table */

    private function _inventory_history_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Asset_actions_model->get_details($options)->getRow();
        return $this->_inventory_history_make_row($data);
    }

    /* prepare a row of inventory history list table */

    private function _inventory_history_make_row($data) {
        return array(
            $data->action_code,
            app_lang("assets_$data->action_type"),
            $data->quantity,
            $data->opening_stock,
            $data->closing_stock,
            $data->cost ? to_currency($data->cost) : 0,
            format_to_datetime($data->action_time, false)
        );
    }

    /* get selected user allocation value */

    function get_selected_user_allocation_value() {
        $user_id = $this->request->getPost('user_id');
        $asset_id = $this->request->getPost('asset_id');

        $options = array(
            "user_id" => $user_id,
            "asset_id" => $asset_id
        );

        $value = $this->Asset_actions_model->get_allocation_value($options);

        echo json_encode(array("success" => true, "info" => $value ? $value : 0));
    }

}

/* End of file Assets.php */
/* Location: ./plugins/Assets_Management/Controllers/Assets.php */