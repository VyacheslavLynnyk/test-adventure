<?php
class TestController extends Controller
{
    public function index()
    {
        $questionModel = Questions::find_by_id('16');
        $questionModel->question = $questionModel->question.'-1';
        $questionModel->save();
        echo   $questionModel->question;



    }
}