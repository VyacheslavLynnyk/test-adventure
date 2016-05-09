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

        print_r($_POST);
        die();
    }
}