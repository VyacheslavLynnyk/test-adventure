<?php

Config::set('site_name', 'Test Adventure');

Config::set('languages', ['ru', 'en']);

// Routers. Router name => method prefix
Config::set('routes', [
    'default' => '',
    'admin' => 'admin_',
]);

Config::set('default_route', 'default');

Config::set('default_language', 'ru');

Config::set('default_controller', 'pages');

Config::set('default_action', 'index');