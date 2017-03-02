/**
 * Created by user on 01.03.2017.
 */
$(document).ready(function(){
    $("form.prettyFormUrl").submit(function(e){
        var url = $(this).attr("data-gen-url");
        var params = $(this).attr("data-params");
        var action = $(this).attr("data-action");
        if ($(this).attr('action') == 'prettyFormUrl') {
            $(this).attr('action', '');
        }
        $.post(url,{data:$(this).serialize(),params:params, action:action}).done(function(data){
            location.href = data;
        });
        e.preventDefault();
        return false;
    });
});