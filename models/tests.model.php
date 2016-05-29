<?php
class Tests extends Model
{
    public static function getTestData($test_id)
    {
        $data['correct'] = [];
        $data['dataTest'] = [];

        $questions = Questions::find_all_by_test_id($test_id);
        foreach ($questions as $question) {
            $answers = Answers::find('all', ["conditions" => ["question_id = ?", $question->id]]);

            $data['dataTest']['test_id'] = $test_id;
            $data['dataTest'][$question->id]['question'] = htmlentities($question->question);
            foreach ($answers as $answer) {
                if (is_numeric($answer->is_true)) {
                    $data['correct'][$test_id][$question->id][$answer->id] = true;
                }
                $data['dataTest'][$question->id][$answer->id] = nl2br(htmlentities($answer->answer));

            }
        }
        return (isset($data)) ? $data : false;
    }

    public static function evaluate(array $user_answers, $test_id)
    {
        $result = [];
        // Evaluation point
        $point = 1;
        if (!isset($test_id) || !is_numeric($test_id)) {
            return false;
        }
        // Get correct answers
        $test_data = self::getTestData($test_id);
        $correct_answers = $test_data['correct'][$test_id];
        $result = [];
        foreach ($correct_answers as $question_num => $answer) {
            $diff_left = array_diff_assoc($user_answers[$question_num], $answer);
            $diff_left_count = sizeof(array_diff_assoc($user_answers[$question_num], $answer));
            $diff_righ = array_diff_assoc($answer, $user_answers[$question_num]);
            $diff_righ_count = sizeof(array_diff_assoc($answer, $user_answers[$question_num]));

            if ($diff_left_count == 0 && $diff_righ_count == 0 ) {
                $result['tasks'][$question_num] = $point;
            } elseif (($diff_left_count <= 1 && $diff_righ_count <= 1)
                    && ($diff_left_count xor $diff_righ_count)
                    && sizeof($answer) > 0) {
                $result['tasks'][$question_num] = $point / 2;
            } else {
                $result['tasks'][$question_num] = 0;
            }
        }

        $result['count'] = sizeof($correct_answers);
        $result['mark'] = array_sum($result['task']);
        $result['pass'] = ($result['mark']*100/$result['count']).'%';
        return $result;

    }
}