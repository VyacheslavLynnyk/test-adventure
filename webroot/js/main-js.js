$(function() {
    $( "#tests-menu" ).accordion();

    /* Answer add */
    $( "#add-answer" ).click(function() {
        var newInput = '';
        newInput += '<div class="form-group row">'
        newInput += '<div class="col-sm-1">';
        newInput += '<input type="checkbox" name="answer[]">';
        newInput += '</div>';
        newInput += '<div class="col-sm-11">';
        newInput += '<textarea  class="form-control" name="question"></textarea>';
        newInput +=  '</div>';
        newInput += '</div>';

        $( "#answer-list" ).append(newInput);

        $("#remove-answer").show();

    });

    $( "#remove-answer" ).click(function() {
        var answerList = $("#answer-list div.form-group");
        if (answerList.length > 1) {
            $("#answer-list div.form-group:last-child").remove();
        }
        if (answerList.length <= 2) {
            $("#remove-answer").hide();
        }
    });

});/**
 * Created by litter on 04.05.16.
 */
