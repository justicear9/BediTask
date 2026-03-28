<?php

namespace Config;

$routes = Services::routes();

$assets_management_namespace = ['namespace' => 'Assets_Management\Controllers'];

$routes->get('assets_management', 'Assets_management::index', $assets_management_namespace);
$routes->post('assets_management/(:any)', 'Assets_management::$1', $assets_management_namespace);
$routes->get('assets_management/(:any)', 'Assets_management::$1', $assets_management_namespace);

$routes->get('assets_settings', 'Assets_settings::index', $assets_management_namespace);
$routes->post('assets_settings/(:any)', 'Assets_settings::$1', $assets_management_namespace);
$routes->get('assets_settings/(:any)', 'Assets_settings::$1', $assets_management_namespace);

$routes->get('assets_updates', 'Assets_Updates::index', $assets_management_namespace);
$routes->get('assets_updates/(:any)', 'Assets_Updates::$1', $assets_management_namespace);
