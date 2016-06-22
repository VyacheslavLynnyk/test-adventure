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

    public function __destructe()
    {

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
        $can_start = Session::getData('start_test');
        if (!isset($can_start) || $can_start != 'can_start='.$params[0]) {
            Router::redirect('test/language/'.$params[0]);
        }

        if (Auth::getRole() != 'admin') {
            // Check attempts
            $user_statistic = Statistics::find_by_user_id_and_test_id(Auth::getUserId(), $params[0], ['order' => 'pass_date desc']);
            if ($user_statistic) {
                $attempt = $user_statistic->attempts;
                $pass_date = $user_statistic->pass_date;
            } else {
                $attempt = Config::get('attempt_in_day');
            }
            if ($attempt <= 0) {
                $getDate = Date('Y-m-d');
                $pass_date = date('Y-m-d', strtotime($pass_date));
                if ($pass_date >= $getDate) {
                    Session::setFlash('У Вас закончились попытки');
                    Router::redirect('test/denied');
                    exit();
                }
            }
            Session::saveData('user_attempts', $attempt - 1);
        } else {
            Session::saveData('user_attempts', 777);
        }
        // Get Task questions and answers
        $test_data = Tests::getTestData($params[0]);
        $can_start = Session::saveData('start_test', null);
        $this->data['dataTest'] = $test_data['dataTest'];
        $this->data['startTime'] = microtime('get_as_float');

        $test_id = (int) $params[0];

        $statistics = new Statistics();
        $statistics->user_id = Auth::getUserId();
        $statistics->test_id = $test_id;
        $statistics->language_id = Tests::find_by_id($test_id)->language_id;
        $statistics->max_mark = '0';
        $statistics->mark = '0';
        $statistics->is_passed = 0;
        $statistics->attempts = Session::getData('user_attempts');
        $statistics_id = $statistics->save();

        Session::saveData('statistics_id_started', $statistics->id);
    }

    public function language()
    {
        $params = App::getRouter()->getParams();
        if (!isset($params[0]) || !is_numeric($params[0])) {
            Router::redirect('test/index');
        }
        $this->data['test_name'] = Tests::find_by_id($params[0])->test;
        $this->data['test_id'] = $params[0];
        Session::saveData('start_test', 'can_start='.$params[0]);
    }

    public function end()
    {
        Session::saveData('start_test', null);
        if (isset($_POST['end_test']) && isset($_POST['test_id'])) {
            if (!is_numeric($_POST['test_id'])) {
                Router::redirect(test/index);
            }
            $user_answers = (isset($_POST['user_answers']) && is_array($_POST['user_answers'])) ? $_POST['user_answers'] : [] ;
            $test_id = (int) $_POST['test_id'];
        //Just test
            if (isset($_POST['timer']) && is_numeric($_POST['timer'])) {
                $cuttent_time = microtime('get_as_float') ;
                $test_time = round($cuttent_time - $_POST['timer'], 1);
            } else {
                $test_time = null;
            }

            $test_data = Tests::getTestData($test_id);
            $correct_answers = $test_data['correct'][$test_id];
            $this->data['true'] = $correct_answers;

            // get results
            $test_result = Tests::evaluate($user_answers, $test_id);

            // save in statistics
            $statistics_id = Session::getData('statistics_id_started');
            Session::saveData('statistics_id_started', null);

            $statistics = Statistics::find_by_id($statistics_id);
            $statistics->question_count = $test_result['count'];
            $statistics->archive_answers = serialize($user_answers);
            $statistics->test_time = $test_time;
            $statistics->max_mark = $test_result['max_mark'];
            $statistics->mark = $test_result['mark'];
            $statistics->is_passed = 0;
            if ( (($statistics->mark/$statistics->max_mark) *100) >= 80) {
                $statistics->is_passed = 1;
                ++$statistics->attempts;
            }
            $test_result['is_passed'] = $statistics->is_passed;

            $statistics->save();
            Session::saveData('result', $test_result);
            Router::redirect('test/result');
            exit;
        }
        //Router::redirect('test/index');
        exit;
    }

    public function result()
    {
        if (Session::getData('result')) {
            $this->data['result'] = Session::getData('result');
            $this->data['attempts'] = Session::getData('user_attempts');
            Session::saveData('user_attempts', null);
        } else {
            Router::redirect('test/index');
        }
    }

    public function denied()
    {

    }
}