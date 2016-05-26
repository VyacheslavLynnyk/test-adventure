<?php
class TestController extends Controller
{
    public function index()
    {

    }

    public function start()
    {
        // Get true answers
        $this->data['testArray'] = [];
        $params = App::getRouter()->getParams();
        if (!isset($params[0]) or (int)$params[0] != $params[0]) {
            Router::redirect('test/index');
        }
        $questions = Questions::find_all_by_test_id($params[0]);
        foreach ($questions as $question) {
            $answers = Answers::find('all', ["conditions" => ["question_id = ? AND is_true >= 0", $question->id]]);
            $this->data['a'][] = $answers;
            foreach ($answers as $answer){
                $this->data['testArray'][$params[0]][$question->id][$answer->id] = true;
            }
        }
        $this->data['testArray'];
    }
}