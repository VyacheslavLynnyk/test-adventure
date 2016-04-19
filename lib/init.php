<?php

require_once(ROOT.DS.'configs'.DS.'config.php');

function __autoload($class_name)
{
    $lib_path = ROOT . DS . 'lib' . DS . strtolower($class_name) . '.class.php';
    $controller_path = ROOT . DS . 'controllers' . DS . str_replace('controller', '', strtolower($class_name)) . '.controller.php';
    $models_path = ROOT . DS . 'models' . DS . strtolower($class_name) . 'class.php';

    if (file_exists($lib_path)) {
        require_once $lib_path;
    } elseif (file_exists($controller_path)) {
        require_once $controller_path;
    } elseif (file_exists($models_path)) {
        require_once $models_path;
    } else {
        Throw NEW Exception('Error. Page ' . $class_name . ' not found!');
    }
}
