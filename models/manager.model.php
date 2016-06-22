<?php
class Manager extends Model
{
    public static function remove_question($question_id)
    {
        $answerModelArr = Answers::find_all_by_question_id($question_id);
            foreach ($answerModelArr as $answerModel) {
                $answerModel->delete();
            }

        //remove questions
        $question = Questions::find_by_id($question_id);
        if ($question->delete()) {
            return true;
        }
        return false;

    }

    public static function remove_test($test_id)
    {
        $test = Tests::find_by_id($test_id);
        $questions = Questions::find_all_by_test_id($test_id);
        foreach ($questions as $num => $question) {
            self::remove_question($question->id);
        }
        $test->delete();

    }

    public static function remove_language($language_id)
    {
        $language = Languages::find_by_id($language_id);
        $tests = Tests::find_all_by_language_id($language_id);
        foreach ($tests as $num => $test) {
                self::remove_test($test->id);
        }
        $language->delete();
    }
}