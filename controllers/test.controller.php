<?php
class TestController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        if (Auth::checkLoginActive() == false) {
            Router::redirect('auth/index');
        }
        if (Auth::getRole() != 'admin' && App::getRouter()->getMethodPrefix() == 'admin_') {
            throw new Exception('Error 404! Page not found.');
        }

        // Get data for left menu panel
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');
    }

    public function index()
    {


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
        return 'test/index';
    }

    public function start()
    {
        // Get true answers

        $params = App::getRouter()->getParams();
        if (!isset($params[0]) or (int)$params[0] != $params[0]) {
            Router::redirect('test/index');
        }

        $test_data = Tests::getTestData($params[0]);
        $this->data['dataTest'] = $test_data['dataTest'];
    }

    public function language()
    {
        $params = App::getRouter()->getParams();
        if (!isset($params[0]) || !is_numeric($params[0])) {
            Router::redirect('test/index');
        }
        $this->data['test_name'] = Tests::find_by_id($params[0])->test;
        $this->data['test_id'] = $params[0];
    }

    public function end()
    {
        if (isset($_POST['end_test']) && isset($_POST['test_id'])) {
            if (!is_numeric($_POST['test_id'])) {
                Router::redirect(test/index);
            }
            $user_answers = (is_array($_POST['user_answers'])) ? $_POST['user_answers'] : [] ;
            $test_id = (int) $_POST['test_id'];
//Just test
            $test_data = Tests::getTestData($test_id);
            $correct_answers = $test_data['correct'][$test_id];
            $this->data['true'] = $correct_answers;

            $history = new History();
            $history->user_id = '';
            $history->language_id = '';
            $history->test_id = '';
            $history->questioin_count = '';
            $history->archive_answers = '';
            $history->test_time = '';
            $history->pass_percent = '';
            $history->is_passed = '';
            $this->data['result'] = Tests::evaluate($user_answers, $test_id);
        }
    }
}