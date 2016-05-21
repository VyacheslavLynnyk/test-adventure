<?php

class AuthController extends Controller {

    public function index()
    {
        $this->login();
        $this->setNoLayout(1);
        return 'auth/index';
    }

    public function login()
    {
        if (false !== Auth::checkLoginActive()){
            Router::redirect('home/index');
        }

        if (isset($_POST['login']) && $_POST['login'] != null
            && isset($_POST['pass']) && $_POST['pass']) {

            $posts['login']  = htmlentities($_POST['login']);
            $posts['pass']  = htmlentities($_POST['pass']);

            $errors = [
                'login'=>'',
                'pass'=>''
            ];

            if (empty($posts['login'])) {
                $errors['login'] = "Не заполнено поле \"login\"";
            }
            if (empty($posts['pass'])) {
                $errors['pass'] = "Не заполнено поле \"password\"";
            }
            if (!empty($errors['login']) or !empty($errors['pass'])){
                Session::setFlash($errors['login'] . '<br>' . $errors['pass']);
            } else {

                if (false !== Auth::check($posts['login'], $posts['pass'])) {
                    Auth::setCookie($posts['login']);
                    Router::redirect('home/index');
                    exit;
                }
            }
        }

    }

    public function logout()
    {
        Auth::unsetCookieAuth();
        Router::redirect('home/index');
        exit;
    }
}