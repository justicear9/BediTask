<?php

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
  Plugin Name: Login as Client
  Description: Login as client from admin portal inside RISE CRM.
  Version: 1.0.1
  Requires at least: 3.3
  Author: ClassicCompiler
  Author URL: https://codecanyon.net/user/classiccompiler
 */

//install dependencies
register_installation_hook("Login_As_Client", function ($item_purchase_code) {
    include PLUGINPATH . "Login_As_Client/install/do_install.php";
});

//uninstallation: remove data from database
register_uninstallation_hook("Login_As_Client", function () {
    $dbprefix = get_db_prefix();
    $db = db_connect('default');

    $sql_query = "DELETE FROM `" . $dbprefix . "settings` WHERE `" . $dbprefix . "settings`.`setting_name`='login_as_client_item_purchase_code';";
    $db->query($sql_query);

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "login_as_client`;";
    $db->query($sql_query);
});

//update plugin
use Login_As_Client\Controllers\Login_As_Client_Updates;

register_update_hook("Login_As_Client", function () {
    $update = new Login_As_Client_Updates();
    return $update->index();
});

use App\Controllers\Security_Controller;

//add login link button in client contacts list
app_hooks()->add_action('app_hook_layout_main_view_extension', function () {
    $instance = new Security_Controller(false);
    $view_data["login_user"] = $instance->login_user;
    echo view("Login_As_Client\Views\helper_js", $view_data);
});
