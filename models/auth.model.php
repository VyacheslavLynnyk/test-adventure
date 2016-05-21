<?php

class Auth extends Model
{
    protected static $yes = false;

    protected static $user;

    public static function check($login, $pass)
    {
        self::$user = !isset(self::$user) ? Users::find_by_login_mail($login) : self::$user;
        if (empty($login) !== false or !isset(self::$user) ) {
            return false;
        } else {
            $res = (!empty($login) and (self::$user->pass == $pass));
            return $res;
        }
    }

    public static function getLogin()
    {

        return isset(self::$user) ? self::$user->login_mail : $_COOKIE['user'];
    }

    public static function calcId($login)
    {
        self::$user = !isset(self::$user) ? Users::find_by_login_mail($login) : self::$user;
        if (false !== ($res = md5($login.md5('pass')))) {
            return $res;
        } else {
            return false;
        }
    }

    public static function checkLoginActive()
    {
        if (isset($_SESSION['auth']) and  $_SESSION['auth'] === 'set') {
            return true;
        }

        // check cookies set
        if (isset($_COOKIE['user']) and
            isset($_COOKIE['userId'])) {
            $login = $_COOKIE['user'];
            $id = $_COOKIE['userId'];
            self::$user = !isset(self::$user) ? Users::find_by_login_mail($login) : self::$user;
            if ($res = (array_key_exists($login, self::getLogin())
                and $id == self::calcId($login))) {
            }
            return $res;
        } else {
            return false;
        }
    }


    public static function setCookie($login)
    {
        self::$user = !isset(self::$user) ? Users::find_by_login_mail($login) : self::$user;
        $_SESSION['auth'] = 'set';
        setcookie("user", $login, time() + 84000, "/" );
        setcookie("userId",self::calcId($login) , time() + 84000, "/" );
    }


    public static function unsetCookieAuth() {
        self::$user = null;
        unset($_SESSION['auth']);
        setcookie("user", '', 1, "/");
        setcookie("userId", '', 1, "/");

    }


}