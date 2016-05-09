$(function() {
    $( "#tests-menu" ).accordion();

    /* Answer add */
    $( "#add-answer" ).click(function() {
        var newInput ='';
        newInput += '<div class="form-group row">'
        newInput += '<div class="col-sm-2">';
        newInput += '<input type="checkbox" name="answer[]">';
        newInput += '</div>';
        newInput += '<div class="col-sm-10">';
        newInput += '<textarea  class="form-control" name="question"></textarea>';
        newInput +=  '</div>';
        newInput += '</div>';

        $( "#answer-list" ).append(newInput);
    });

    $( "#remove-answer").click(function() {
        if ($("#answer-list div.form-group").length > 1) {
            $("#answer-list div.form-group:last-child").remove();
        }
    });

});/**
 * Created by litter on 04.05.16.
 */
