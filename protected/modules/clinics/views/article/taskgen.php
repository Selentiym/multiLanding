<?php
/**
 *
 * @var AdminController $this
 */
Yii::app() -> getModule('taskgen') -> giveProjectTree([
    "generateButtons" => 'js:function(branch){
        if (!branch) {return;}
        if (!branch.parent.parent) {return;}
        var $idContainer = $("#id_taskgen");
        createStatuses(branch);
        branch.copyButton = $("<span>",{
            class: "copy_to_author button",
            title: "Загрузить задание"
        });
        branch.copyButton.click(function(){
            $.post(TaskGenModule.baseUrl + "task/getText/" + branch.id, function(){}, "JSON").done(function(data){
                var str = String(data.text);
                if (confirm("Вы, действительно, хотите заменить текст в окне редактора?")) {
                    tinyMCE.activeEditor.setContent(str);
                    $("#description").val(data.description);
                    $idContainer.val(branch.id);
                }
            });
        });
        branch.buttonContainer.append(branch.copyButton);
        branch.downloadButton = $("<span>",{
            class:"button download",
            title:"Итеративно копирует всех потомков выбранной в таскгене статьи в потомки данной (редактируемой в этой админке) статьи"
        });
        var textToCheck = "I am fully aware of the consequences of my actions";
        branch.downloadButton.click(function(){
        if (prompt("Вы собираетесь рекурсивно скопировать структуру и тексты статей из модуля написания текстов на сайт. Процесс лавиннообразный и необратимый, повторный запуск итеративного копирования может привести к непредвиденным результатам, а также к нарушении структуры статей на сайте. Использовать кнопку с особой осторожностью. Не использовать, если не уверены. Чтобы запустить процедуру копирования, введите в строке текст \'"+textToCheck+"\'") == textToCheck) {
            alert("Копирование запущено, может занять некоторое время, если загружается много статей.");
            $.post("'.$this -> createUrl("admin/copyDescendants").'/?id=" + branch.id,
                        {articleId: '.$model -> id.'}, null,"json"
                    ).done(function(data){
                        $idContainer.val(branch.id);
                        if (data.success) {
                            alert("Загрузка успешна!");
                        }
                    });
                    } else {
                        alert("Копирование НЕ запущено.");
                    }
        });
        branch.buttonContainer.append(branch.downloadButton);
    }'
]);



?>
<div id="taskgenTree"></div>
