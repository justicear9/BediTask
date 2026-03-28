<?php

//Prevent direct access
defined('PLUGINPATH') or exit('No direct script access allowed');

/*
  Plugin Name: Assets Management
  Description: Manage Assets inside RISE CRM.
  Version: 1.0.1
  Requires at least: 3.3
  Author: SketchCode
  Author URL: https://codecanyon.net/user/sketchcode
 */

use App\Controllers\Security_Controller;

app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {
    $instance = new Security_Controller();
    if ($instance->login_user->is_admin) {
        $sidebar_menu["assets"] = array(
            "name" => "assets",
            "url" => "assets_management",
            "class" => "database",
            "position" => 6
        );
    }
    return $sidebar_menu;
});

app_hooks()->add_filter('app_filter_action_links_of_Assets_Management', function ($action_links_array) {
    $action_links_array = array(
        anchor(get_uri("assets_settings"), app_lang("settings")),
        anchor(get_uri("assets_management"), app_lang("assets"))
    );

    return $action_links_array;
});

app_hooks()->add_filter('app_filter_admin_settings_menu', function ($settings_menu) {
    $settings_menu["plugins"][] = array("name" => "assets_management", "url" => "assets_settings");
    return $settings_menu;
});

//installation: install dependencies
register_installation_hook("Assets_Management", function ($item_purchase_code) {
    include PLUGINPATH . "Assets_Management/install/do_install.php";
});

//uninstallation: remove data from database
register_uninstallation_hook("Assets_Management", function () {
    $dbprefix = get_db_prefix();
    $db = db_connect('default');

    $sql_query = "DROP TABLE `" . $dbprefix . "asset_groups`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE `" . $dbprefix . "asset_units`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE `" . $dbprefix . "asset_locations`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE `" . $dbprefix . "assets`;";
    $db->query($sql_query);

    $sql_query = "DROP TABLE `" . $dbprefix . "asset_actions`;";
    $db->query($sql_query);
});

//update plugin
use Assets_Management\Controllers\Assets_Updates;

register_update_hook("Assets_Management", function () {
    $update = new Assets_Updates();
    return $update->index();
});
