<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.02.2017
 * Time: 18:09
 */
trait tAssets {
    abstract public function getAssetsPath();
    /**
     * @param string $file
     * @param int $pos
     * @param array $options
     */
    public function registerJSFile($file, $pos = null, $options = []){
        $addr = $this -> getAssetsPath().'/'.$file;
        Yii::app() -> getClientScript() -> registerScriptFile($this -> getAssetsPath().'/'.$file,$pos,$options);
    }
    /**
     * @param string $file
     * @param string $media
     */
    public function registerCSSFile($file, $media = null){
        $name = $this -> getAssetsPath().'/'.$file;
        Yii::app() -> getClientScript() -> registerCssFile($name,$media);
    }
}