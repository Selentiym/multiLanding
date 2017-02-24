<?php
/**
 *
 * @var AdminController $this
 */
Yii::app() -> getModule('taskgen') -> giveProjectTree([
    "generateButtons" => 'js:function(branch){
        if (!branch) {return;}
        if (!branch.parent.parent) {return;}
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
                }
            });
        });
        branch.buttonContainer.append(branch.copyButton);
        branch.downloadButton = $("<span>",{
            class:"button download",
            title:"Итеративно копирует всех потомков выбранной в таскгене статьи в потомки данной (редактируемой в этой админке) статьи"
        });
        branch.downloadButton.click(function(){
            $.post("'.$this -> createUrl("admin/copyDescendants").'/?id=" + branch.id,
                        {articleId: '.$model -> id.'}, null,"json"
                    ).done(function(data){
                        if (data.success) {
                            alert("Загрузка успешна!");
                        }
                    });
        });
        branch.buttonContainer.append(branch.downloadButton);
    }'
]);



?>
<div id="taskgenTree"></div>
