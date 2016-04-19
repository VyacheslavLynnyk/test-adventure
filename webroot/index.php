<?php

define('DS', DIRECTORY_SEPARATOR);

define('ROOT', dirname(dirname(__FILE__)));

define('WEBROOT', $_SERVER['SERVER_NAME'].str_replace('/webroot/index.php', '', $_SERVER['SCRIPT_NAME']));

define('REL_URL', str_replace('/webroot/index.php', '', $_SERVER['SCRIPT_NAME']));

require_once ROOT . DS . 'lib' . DS . 'init.php';

$router = new Router($_SERVER['REQUEST_URI']);
echo "<pre>";
print_r('Route:' . $router->getRoute(). PHP_EOL);
print_r('Lang:' . $router->getLanguage(). PHP_EOL);
print_r('Controller:' . $router->getController(). PHP_EOL);
print_r('Action:' . $router->getAction(). PHP_EOL);
print_r($router->getParams());
echo "</pre>";