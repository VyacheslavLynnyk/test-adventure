<?php

class ManagerController extends Controller
{
    public function index()
    {
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');

    }
    
}