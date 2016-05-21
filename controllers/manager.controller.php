<?php

class ManagerController extends Controller
{
    // Get data from DB to left panel
    public function app_test_menu($language_name = null, $test_name = null)
    {
        $this->data['languages'] = Languages::find('all');
        $this->data['tests'] = Tests::find('all');
    }

    public function admin_index()
    {
        $this->app_test_menu();
    }

    public function admin_save_test()
    {
        $this->app_test_menu();

        // Save from POST to DB Language and Test (test name)
        if (isset($_POST['save_test']) && $_POST['save_test'] == 'save') {
            if (($_POST['set_language'] != null || $_POST['add_language'] != null) && $_POST['test_name'] != null) {

                if ($_POST['add_language'] != null) {
                    // Save into Languages
                    $languageModel = new Languages();
                    $languageModel->language = htmlspecialchars_decode(trim($_POST['add_language']));

                    if ($languageModel->save() == false) {
                        Session::setFlash('Ошибка при создании теста!');
                    }
                }

                // Save into Tests
                $testModel = new Tests();
                $testModel->test = htmlspecialchars_decode(trim($_POST['test_name']));
                $testModel->language_id = isset($languageModel->id) ? $languageModel->id : (int)$_POST['set_language'];

                if ($testModel->save() == false) {
                    Session::setFlash('Ошибка при создании теста!');
                } else {
                    Session::setFlash('Название теста сохранено успешно!');

                    $this->app_test_menu();
                    Session::saveData('test_id', $testModel->id);
                }
            } else {
                Session::setFlash('Fill up all needed fields');
                Router::redirect('admin/manager/index');
            }

        } elseif (isset($_POST['save_test']) && $_POST['save_test'] =='save_question') {

            // Save question and answer
            if ($_POST['question'] != null && $_POST['answer'][0] != null && (Session::getData('test_id') != null)) {
                $test_id = Session::getData('test_id');
                $question = htmlspecialchars_decode(trim($_POST['question']));
                $answers_true = (array) $_POST['answer_true'];
                $answers = (array) $_POST['answer'];

                $this->app_save_test($test_id, $answers, $answers_true, $question);
            }
        } else {
            Session::setFlash('Fill up all needed fields');
            Router::redirect('admin/manager/index');
        }
    }

    public function admin_edit_test()
    {
        $params = App::getRouter()->getParams();
        if (sizeof($params) > 0) {
            $this->data['params'] = implode('/', $params);

            $testModel = Tests::find_by_id($params[0]);

            if (isset($_POST['test_name']) && $_POST['test_name'] != null) {
                $testModel->test = htmlspecialchars_decode(trim($_POST['test_name']));
                $testModel->save();
            }
            $this->data['test_name'] = $testModel->test;
            // Get all questions
            if (!isset($params[1])) {
                $this->data['questions'] = Questions::find_all_by_test_id($testModel->id);
            }
            if (isset($params[1]) && (int) $params[1] !== null) {
                if (isset($_POST['question']) && $_POST['question'] != null && $_POST['answer'][0] != null) {
                    $test_id = $params[0];
                    $question = htmlspecialchars_decode(trim($_POST['question']));
                    $question_id = $params[1];
                    $answers_true = (array) $_POST['answer_true'];
                    $answers = (array) $_POST['answer'];

                    $this->app_save_test($test_id, $answers, $answers_true, $question, $question_id);
                }

                $this->data['current_question'] = Questions::find_by_id($params[1]);
                $this->data['answers'] = Answers::find_all_by_question_id($params[1]);
            }
        } else {
            Router::redirect('admin/manager/index');
        }

        $this->app_test_menu();
    }


    /**
     * @param $test_id
     * @param $answers
     * @param $answers_true
     * @param $question
     * @param null $question_id
     * @return bool
     */
    protected function app_save_test($test_id, $answers, $answers_true, $question, $question_id = null)
    {
        if ($question_id != null) {
            $questionModel = Questions::find_by_id($question_id);
            //remove old answers
            $answerModelArr = Answers::find_all_by_question_id($question_id);
            foreach ($answerModelArr as $answerModel) {
                $answerModel->delete();
            }
        } else {
            $questionModel = new Questions();
        }

        $questionModel->question = $question;
        $questionModel->test_id = $test_id;
        $questionModel->save();

        foreach ( $answers as $key => $answer) {
            if ($answer == null) {
                continue;
            }
            $answerModel = new Answers();
            $answerModel->answer = htmlspecialchars_decode(trim($answer));
            $answerModel->is_true = (in_array($key, $answers_true)) ? $key : null;
            $answerModel->question_id = $questionModel->id;
            $answerModel->save();
        }
    }



    public function admin_delete_test() 
    {
        return 'manager/admin_edit_test';
    }

    public function admin_edit_language()
    {
        $params = App::getRouter()->getParams();

        if (sizeof($params) > 0) {
            $this->data['params'] = implode('/', $params);

            $languageModel = Languages::find_by_id($params[0]);

            if (isset($_POST['language_name']) && $_POST['language_name'] != null) {
                $languageModel->language = htmlspecialchars_decode(trim($_POST['language_name']));
                $languageModel->save();
            }
            $this->data['language_name'] = $languageModel->language;
            // Get all questions
//        if (!isset($params[1])) {
//            $this->data['test'] = Questions::find_all_by_question_id($languageModel->id);
//        }
//        if (isset($params[1]) && (int) $params[1] !== null) {
//            if (isset($_POST['question']) && $_POST['question'] != null && $_POST['answer'][0] != null) {
//                $test_id = $params[0];
//                $question = htmlspecialchars_decode(trim($_POST['question']));
//                $question_id = $params[1];
//                $answers_true = (array) $_POST['answer_true'];
//                $answers = (array) $_POST['answer'];
//
//                $this->app_save_test($test_id, $answers, $answers_true, $question, $question_id);
//            }
//
//            $this->data['current_question'] = Questions::find_by_id($params[1]);
//            $this->data['answers'] = Answers::find_all_by_question_id($params[1]);
//        }
        }else {
        Router::redirect('admin/manager/index');
    }

        $this->app_test_menu();
    }
}