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

        // Save from POST to DB Language and Test (test name)
        if (isset($_POST['save_test']) && $_POST['save_test'] == 'save') {
            if (($_POST['set_language'] != null || $_POST['add_language'] != null) && $_POST['test_name'] != null) {

                // TEST var_dump
                $this->data['var_dump'] = ((bool) $_POST['set_language'] != null) .'('.$_POST['set_language'] . ')|';
                $this->data['var_dump'] .= ((bool) $_POST['add_language'] != null) .'('.$_POST['add_language'] . ')|' ;
                $this->data['var_dump'] .= ((bool) $_POST['test_name'] != null).'('.$_POST['test_name'] . ')<br>';

                if ($_POST['add_language'] != null) {
                    // Save into Languages
                    $languageModel = new Languages();
                    $languageModel->language = htmlspecialchars_decode(trim($_POST['add_language']));

                    //TEST var_dump
                    $this->data['var_dump'] .= '$languageModel->language = '. $languageModel->language . '<br>';

                    if ($languageModel->save() == false) {
                        Session::setFlash('Ошибка при создании теста!');
                    }
                }

                // Save into Tests
                $testModel = new Tests();
                $testModel->test = htmlspecialchars_decode(trim($_POST['test_name']));

                //TEST var_dump
                $this->data['var_dump'] .= '$testModel->test = '. $testModel->test . '<br>';

                $testModel->language_id = isset($languageModel->id) ? $languageModel->id : (int)$_POST['set_language'];

                //TEST var_dump
                $this->data['var_dump'] .= '$testModel->language_id = '. $testModel->language_id . '<br>';

                if ($testModel->save() == false) {
                    Session::setFlash('Ошибка при создании теста!');
                } else {
                    Session::setFlash('Название теста сохранено успешно!');

                    $this->data['languages'] = Languages::find('all');
                    $this->data['tests'] = Tests::find('all');

                    Session::saveData('test_id', $testModel->id);
                }

            } else {
                Session::setFlash('Fill up all needed fields');
                Router::redirect('admin/manager/index');
            }

        } elseif (isset($_POST['save_test']) && $_POST['save_test'] =='save_question') {
            if ($_POST['question'] != null && $_POST['answer'][0] != null && (Session::getData('test_id') != null)) {


                //TEST var_dump
                $this->data['var_dump'] = $_POST['answer_true'];
//                $this->data['var_dump'] .= '$_POST[answer_true][1] = '. $_POST['answer_true'][1] . '<br>';
//                $this->data['var_dump'] .= '$_POST[answer_true][2] = '. $_POST['answer_true'][2] . '<br>';
//                $this->data['var_dump'] .= '$_POST[answer_true][3] = '. $_POST['answer_true'][3] . '<br>';

                $questionModel = new Questions();
                $questionModel->question = htmlspecialchars_decode(trim($_POST['question']));
                $questionModel->test_id = Session::getData('test_id');
                $questionModel->save();

                $answer_true = (array) $_POST['answer_true'];
                foreach ( $_POST['answer'] as $key => $answer) {
                    $answerModel = new Answers();
                    $answerModel->answer = htmlspecialchars_decode(trim($answer));
                    $answerModel->is_true = (in_array($key, $answer_true)) ? $key : null;
                    $answerModel->question_id = $questionModel->id;
                    if ($answerModel->save() == false) {
                        Session::setFlash('Ошибка при создании теста!');
                    } else {
                        Session::setFlash('Вопрос сохранен!');
                    }
                    //Router::redirect('admin/manager/index');
                }

            }
        } else {
            Session::setFlash('Fill up all needed fields');
            Router::redirect('admin/manager/index');
        }
    }
}