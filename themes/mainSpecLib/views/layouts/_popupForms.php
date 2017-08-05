<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.08.2017
 * Time: 14:12
 */

Yii::app() -> getClientScript() -> registerScript('initiate_popup_forms','
    $(".signUpForm #phone").mask("+7(999)999-99-99");
    $(".signUpButton").attr("data-target","#signUpFormModal").attr("data-toggle","modal").attr("data-keyboard","true");
    $(".signUpButton").modal({
        keyboard:true,
        show:false,
        focus:true
    });
    $("form.signUpForm").submit(function(e){
    var toSubmit = $(this).find("[type=\'submit\']");
    toSubmit.attr("disabled",true);
    toSubmit.addClass("loading");
    var toAlert = true;
    setTimeout(function () {
        if (toAlert) {
            toSubmit.attr("disabled",false);
            toSubmit.removeClass("loading");
            alert("По какой-то причине ответ от сервера не пришел. Проверьте интернет-соединение и попробуйте еще раз, пожалуйста.");
        }
    }, 10000);
    try {
		if (typeof yaCounter != "undefined") {
			yaCounter.reachGoal("formSent");
		}
	} catch (err) {
		console.log(err);
	}
    $.get("'.$this -> createUrl('/form/submit').'",$(this).serialize()).done(function(date){
        alert("Ваша заявка успешно принята!");
    }).fail(function(){
        alert("Возникла ошибка при отправке. Пожалуйста, попробуйте еще раз или воспользуйтесь одним из указанных телефонных номеров.");
    }).always(function () {
        toAlert = false;
        toSubmit.attr("disabled",false);
        toSubmit.removeClass("loading");
    });
    return false;
});
',CClientScript::POS_READY);

?>
<div class="modal fade" id="signUpFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mainColor" id="exampleModalLabel">Оставить заявку на исследование</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="signUpForm" id="signUpForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Имя:</label>
                        <input type="text" class="form-control" id="recipient-name" name="name" placeholder="Введите имя">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-control-label">Телефон:</label>
                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Введите номер телефона">
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn">Записаться</button>
                </div>
            </form>
        </div>
    </div>
</div>

