<?php

namespace Config;

$routes = Services::routes();

$routes->get('login_as_client', 'Login_As_Client::index', ['namespace' => 'Login_As_Client\Controllers']);
$routes->get('login_as_client/(:any)', 'Login_As_Client::$1', ['namespace' => 'Login_As_Client\Controllers']);
$routes->post('login_as_client/(:any)', 'Login_As_Client::$1', ['namespace' => 'Login_As_Client\Controllers']);

$routes->get('login_as_client_updates', 'Login_As_Client_Updates::index', ['namespace' => 'Login_As_Client\Controllers']);
$routes->get('login_as_client_updates/(:any)', 'Login_As_Client_Updates::$1', ['namespace' => 'Login_As_Client\Controllers']);
