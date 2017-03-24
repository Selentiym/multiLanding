<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.02.2017
 * Time: 21:08
 */
class TaskGenModule extends UWebModule {

    public function init(){
        parent::init();
        // import the module-level models and components
        $this->setImport(array(
            $this -> getId() . '.models.*',
            $this -> getId() . '.models.strings.*',
            $this -> getId() . '.components.*',
        ));
    }


    public function giveProjectTree(array $config = []){
        Yii::app() -> getClientScript() -> registerScript('jsNamespaceForTaskGenModule','
            TaskGenModule = {};
            TaskGenModule.baseAssets = "'.$this -> _assetsPath.'";
            TaskGenModule.baseUrl = "'.Yii::app() -> baseUrl.'/'.$this -> getId().'/";
        ',CClientScript::POS_BEGIN);
        $this -> registerJSFile('/js/treeCustom.js',CClientScript::POS_BEGIN);
        $defaultConfig = [
                "id" => "taskgenTree",
                "clickHandler" => "js:function(e){
                        if (!e) {
                            return false;
                        } else {
                            e.preventDefault();
                            return false;
                        }
                    }",
                "toHref" => "js:function(){
                        if (this.id) {
                            return '#';
                        }
                    }",
                "generateButtons" => "js:function(){
                        return;
                    }",
                "generatePanel" => "js:function(tree){  return;}"
            ];
        $config = CMap::mergeArray($defaultConfig, $config);
        Yii::app() -> controller -> widget('application.extensions.tree.Tree', [
            "url" => $this -> createUrl('task/children'),
            "config" => $config
        ]);
    }
    /**
     * @param array $config
     */
    public function giveProjectTree2(array $config = []){
        Yii::app() -> getClientScript() -> registerCoreScript('jquery');
        Yii::app() -> getClientScript() -> registerCss('asd','.square {display:block; width:20px; height:20px; background:#123; margin:10px;}');
        $this -> registerCssFile('/css/tree.css');
        Yii::app() -> getClientScript() -> registerScript('jsNamespaceForTaskGenModule','

            TaskGenModule = {};
            TaskGenModule.baseAssets = "'.$this -> _assetsPath.'";
            TaskGenModule.baseUrl = "'.Yii::app() -> baseUrl.'/'.$this -> getId().'/";
        ',CClientScript::POS_BEGIN);
        $this -> registerJSFile('/js/underscore.js',CClientScript::POS_BEGIN);
        $this -> registerJSFile('/js/tree.js',CClientScript::POS_END);
        $this -> registerJSFile('/js/jquery.cookie.js',CClientScript::POS_END);
        Yii::app() -> getClientScript() -> registerScript('structure','
        var tree = new TreeStructure("'.addslashes($this -> createUrl('task/children')).'",{clickHandler: function(e){
            if (!e) {
                return false;
            } else {
                e.preventDefault();
                return false;
            }
        },
        toHref: function(){
            if (this.id) {
                return "#";
            }
        },
        //generateButtons: addButtons,
        generateButtons: function(branch){
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
        },
        //generatePanel: genControlPanel
        generatePanel: function(tree){  return;}
        });
        ',CClientScript::POS_READY);
    }
}