<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 18:03
 */
class Tree extends CInputWidget {
    use tAssets;

    public $url;
    public $config;

    private $_assetsDir;

    private static $num = 0;

    public function init(){
        $dir = dirname(__FILE__) . '/assets/';
        $this->_assetsDir = Yii::app()->assetManager->publish($dir);
        self::$num ++;
    }

    public function run() {
        $config = $this -> config;
        $defaultConfig = [
            'id' => 'tree'.self::$num,
            "clickHandler" =>  "js:function(e){
                if (!e) {
                    return false;
                } else {
                    e.preventDefault();
                    return false;
                }
            }",
            "toHref" => 'js:function(){
                if (this.id) {
                    return "#";
                }
            }',
            "generateButtons" => 'js:function(branch){
                if (!branch) {return;}
                if (!branch.parent.parent) {return;}
                branch.copyButton = $("<span>",{
                    class: "copy_to_author button",
                    title: "Загрузить задание"
                });
            }',
            'generateControlPanel' => 'js:function(){
                return false;
            }'
        ];
        $config = CMap::mergeArray($defaultConfig,$config);
        Yii::app() -> getClientScript() -> registerCoreScript('jquery');
        Yii::app() -> getClientScript() -> registerCss('stylesForTreeStructure','.square {display:block; width:20px; height:20px; background:#123; margin:10px;}');
        $this -> registerCssFile('/css/tree.css');
        Yii::app() -> getClientScript() -> registerScript('jsNamespaceForTreeWidget','
            Tree = {};
            Tree.baseAssets = "'.$this -> getAssetsPath().'";
        ',CClientScript::POS_BEGIN);

        $this -> registerJSFile('/js/underscore.js',CClientScript::POS_BEGIN);
        $this -> registerJSFile('/js/tree.js',CClientScript::POS_END);
        $this -> registerJSFile('/js/jquery.cookie.js',CClientScript::POS_END);
        $config['elementId'] = $config['id'];
        unset($config['id']);
        Yii::app() -> getClientScript() -> registerScript('TreeStructure'.$config["elementId"],'
        window.'.$config["elementId"].' = new TreeStructure("'.addslashes($this -> url).'",'.CJavaScript::encode(array_filter($config)).');
        ',CClientScript::POS_READY);
        if ($config["elementId"] == "tree".self::$num) {
            echo "<div id='{$config['elementId']}'></div>";
        }
    }
    public function getAssetsPath() {
        return $this -> _assetsDir;
    }
}

