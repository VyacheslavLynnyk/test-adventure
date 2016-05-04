<?php
class Answers extends Model {
    function getId()
    {
        echo "ok<br>";
        $test = Db::find(1);
        print_r($test);
    }

}