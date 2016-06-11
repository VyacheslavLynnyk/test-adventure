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
            $data['dataTest'][$question->id]['question'] = htmlspecialchars_decode($question->question);
            foreach ($answers as $answer) {
                if (is_numeric($answer->is_true)) {
                    $data['correct'][$test_id][$question->id][$answer->id] = true;
                }
                $data['dataTest'][$question->id][$answer->id] = htmlspecialchars_decode($answer->answer);

            }
        }
        return (isset($data)) ? $data : false;
    }

    public static function evaluate(array $user_answers, $test_id)
    {
        $result = [];
        // Evaluation point
        $point = 1;
        $max_mark = 0;
        if (!isset($test_id) || !is_numeric($test_id)) {
            return false;
        }
        // Get correct answers
        $test_data = self::getTestData($test_id);
        $correct_answers = $test_data['correct'][$test_id];
        $result = [];
        foreach ($correct_answers as $question_num => $answer) {
            // SET Conditions
            if (isset($user_answers[$question_num])) {
                $diff_left = (array_diff_assoc($user_answers[$question_num], $answer));
                $diff_left_count = sizeof(array_diff_assoc($user_answers[$question_num], $answer));
            } else {
                $diff_left = null;
                $diff_left_count = 0;
            }
            
            if (isset($user_answers[$question_num])) {
                $diff_right = array_diff_assoc($answer, $user_answers[$question_num]);
                $diff_right_count = sizeof(array_diff_assoc($answer, $user_answers[$question_num]));
            } else {
                $diff_right = $answer;
                $diff_right_count = sizeof($answer);
            }
//            var_dump($diff_left_count. 'and' . $diff_right_count);
            if ($diff_left_count == 0 && $diff_right_count == 0 ) {
                $result['tasks'][$question_num] = $point;
                // If user set any answer
            } elseif (isset($user_answers[$question_num])
                && sizeof($user_answers[$question_num]) > 0
                && sizeof($answer) >= 2
                // Questions quantity >= 3 , (because -1 needed)
                && sizeof($test_data['dataTest'][$question_num]) > 3
                && $diff_left_count <= 1 && $diff_right_count <= 1
                && ($diff_left_count xor $diff_right_count) ) {
                    $result['tasks'][$question_num] = $point / 2;
//                print_r(sizeof($test_data['dataTest'][$question_num]) - 1);
//                die;
            } else {
                $result['tasks'][$question_num] = 0;
            }
        }

        $result['count'] = sizeof($correct_answers);
        $result['mark'] = array_sum($result['tasks']);
        $result['max_mark'] = $result['count'] * $point;
        $result['pass_percent'] = ($result['max_mark'] != null) ? (round(($result['mark']*100/$result['max_mark']), 1)).'%' : 'Error';
        return $result;

    }
}