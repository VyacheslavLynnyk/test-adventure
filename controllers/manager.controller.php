<?php

class ManagerController extends Controller
{

    public function admin_index()
    {
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');

    }

    public function admin_save_test()
    {
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');

//        Router::redirect('admin/manager/save-test');
//        exit();
        if (isset($_POST['save_tests']) && $_POST['save_tests'] =='save_tests') {
            if (($_POST['set_language'] == null && $_POST['add_language'] == null) || $_POST['test_name'] == null) {
                Session::setFlash('Fill up all needed fields');
                Router::redirect('admin/manager/index');
            } else {
                Session::setFlash('Test name has been saved');

                
            }
            print_r($_POST);
        } elseif (isset($_POST['save_tests']) && $_POST['save_tests'] =='save_question') {

        }
    }
}