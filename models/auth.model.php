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
            $res = (!empty($login) and (self::$user->pass == crypt($pass, 'mySalt')));
            return $res;
        }
    }

    public static function getRole($loginPost = null)
    {
        if (isset($user) || isset($_COOKIE['user']) || isset($loginPost)) {
            $login = isset($_COOKIE['user']) ? $_COOKIE['user'] : $loginPost;
            self::$user = !isset(self::$user) ? Users::find_by_login_mail($login) : self::$user;
            return self::$user->role;
        }

        return false;
    }

    public static function setUser()
    {
        if (!isset($user)) {
            self::$user = ($login = $_COOKIE['user']) ? Users::find_by_login_mail($login) : false;
        }
    }

    public static function getLogin()
    {
        if  (!isset($user)) {
            self::setUser();
        }
        return (self::$user) ? self::$user->login_mail : false;
    }

    public static function getUserId()
    {
        if  (!isset($user)) {
            self::setUser();
        }
        return (self::$user) ? self::$user->id: false;
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
        if (isset($_SESSION['auth']) and  $_SESSION['auth'] === 'set' and isset($_COOKIE['user'])) {
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
        setcookie("user", $login, time() + 8400, "/" );
        setcookie("userId",self::calcId($login) , time() + 8400, "/" );
    }


    public static function unsetCookieAuth() {
        self::$user = null;
        unset($_SESSION['auth']);
        setcookie("user", '', 1, "/");
        setcookie("userId", '', 1, "/");
    }

    public static function security() {
        // Check users role
        if (self::checkLoginActive() == false) {
            Router::redirect('auth/index');
        }
        if (self::getRole() != 'admin') {
            throw new Exception('Error 404! Page not found.');
        }
    }

}