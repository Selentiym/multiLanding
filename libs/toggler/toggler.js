/**
 * Created by user on 02.05.2017.
 */
$(document).ready(function(){
    $('body').on('click','.classToggler', function(){
        $($(this).attr('data-target')).toggleClass($(this).attr('data-class'));
    });
});