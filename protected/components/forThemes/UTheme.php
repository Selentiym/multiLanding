<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.01.2017
 * Time: 9:45
 */
class UTheme extends CTheme {
    private $_parentString = '';
    /**
     * @var CTheme $_parentTheme
     */
    private $_parentTheme;

    /**
     * @param string $str string identifier of the parent theme
     */
    public function setParentString($str) {
        $this -> _parentString = $str;
    }

    /**
     * @return CTheme
     * @throws ThemeException
     */
    public function getParentTheme() {
        if (!isset($this -> _parentTheme)) {
            $this -> _parentTheme = Yii::app() -> themeManager -> getTheme($this -> _parentString);
        }
        return $this -> _parentTheme;
    }

    public function getName() {
        if ($del = Yii::app() -> themeManager -> parentDelimiter) {
            return $this->_parentString . $del . parent::getName();
        }
        return parent::getName();
    }

    /**
     * @param CController $controller
     * @param string $viewName
     * @return string
     */
    public function getViewFile($controller, $viewName) {
        $file = parent::getViewFile($controller, $viewName);
        if (!$file) {
            $parent = $this -> getParentTheme();
            if ($parent instanceof CTheme) {
                $file = $parent->getViewFile($controller, $viewName);
            }
        }
        return $file;
    }
}