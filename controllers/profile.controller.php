<?php

class ProfileController extends Controller
{
    public function index()
    {
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');

        $login = Auth::getLogin();
        $user = Users::find_by_login_mail($login);

        if (!isset($user)) {
            Router::redirect('auth/index');
            exit;
        }

        // Gets Post profile data
        if (isset($_POST['profile-save'])) {

            $user->full_name = htmlentities($_POST['full-name']);
            $user->phone = htmlentities($_POST['phone']);
            
            $id = $user->id;
            // Get crop and save our avatar image
            $save_path = ROOT . '/webroot/images/avatars/'.md5($id);
            if ($avatar = Images::file_catch('avatar', $save_path)) {
                $avatar_ext = pathinfo($avatar, PATHINFO_EXTENSION);
                $save_path .= '.' . $avatar_ext;
                $save_url =  str_replace(ROOT.'/webroot', '', $save_path);
                Images::$expected_height = 400;
                Images::$expected_width = 400;
                Images::crop_to_fit($avatar, $save_path);
                $user->photo_path = $save_url;
            }
            $user->save();
        }
        
        $this->data['full-name'] = $user->full_name;
        $this->data['phone'] = $user->phone;
        $this->data['avatar'] = $user->photo_path;
        $this->data['role'] = $user->role;

    }


    // ALL PROFILES
    public function admin_index()
    {
        Auth::security();

        $this->data['users'] = Users::all();

    }

    public function admin_save_changes()
    {
        if (isset($_POST['changed']) && isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
            if ($_POST['user_id'] <= 0) {
                exit;
            }
            $user_id = (int) $_POST['user_id'];
            $user = Users::find_by_id($user_id);

            $role = strip_tags(trim($_POST['role']));
            if (isset($role) && $user->role != $role) {
                $user->role =  $role;
            }

            $active = (isset($_POST['active'])) ? strip_tags(trim($_POST['active'])) : 0;
            if ($user->active != $active) {
                $user->active = $active;
            }
            if ($user->save()) {
                echo 'Сохранено успешно';
            } else {
                echo 'Ошибка';
            }

        }
        exit;
    }
}