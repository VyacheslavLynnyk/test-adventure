<?php
class Session
{
    public static function setFlash($messsage)
    {
        $_SESSION['flash_message'] = $messsage;
    }

    public static function flash()
    {
        echo $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
    }

    public static function hasFlash()
    {
        return isset($_SESSION['flash_message']);
    }

    public static function saveData($name, $data)
    {
        $_SESSION['saved_data'][$name] = $data;
    }

    public static function getData($name)
    {
        if (isset($_SESSION['saved_data'][$name])) {
            return $_SESSION['saved_data'][$name];
        } else {
            return false;
        }
    }
}