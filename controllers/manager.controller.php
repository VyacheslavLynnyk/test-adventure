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

                $testModel->language_id = isset($languageModel->id) ? $languageModel->id :Languages::find('last')->id;

                //TEST var_dump
                $this->data['var_dump'] .= '$testModel->language_id = '. $testModel->language_id . '<br>';

                if ($testModel->save() == false) {
                    Session::setFlash('Ошибка при создании теста!');
                } else {
                    Session::setFlash('Название теста сохранено успешно!');

                    $this->data['languages'] = Languages::find('all');
                    $this->data['tests'] = Tests::find('all');
                }

            } else {
                Session::setFlash('Fill up all needed fields');
                Router::redirect('admin/manager/index');
            }

        } elseif (isset($_POST['save_test']) && $_POST['save_test'] =='save_question') {

        } else {
            Session::setFlash('Fill up all needed fields');
            Router::redirect('admin/manager/index');
        }
    }
}