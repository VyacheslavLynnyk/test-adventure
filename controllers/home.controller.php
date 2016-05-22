<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');

    }

    public function test()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0]) && (int)$params[0] == $params[0]) {
            $this->data['content'] = 'Content';
        }
    }

    public function admin_index()
    {
        $this->index();
        return 'home/index';
    }

    
}