<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.01.2017
 * Time: 11:57
 */
class UThemeManager extends CThemeManager {

    /**
     * @var string $parentDelimiter used for separating themes in genealogy
     */
    public $parentDelimiter = '/';

    public static $createdThemes = [];
    /**
     * @var CTheme
     */
    private $_lastRenderedTheme;
    public function getTheme($name) {
        if (!isset(self::$createdThemes[$name])) {
            $parents = explode($this -> parentDelimiter, $name);
            $curName = array_pop($parents);
            if (!($curName)) {
                return null;
            }
            $theme = parent::getTheme($curName);
            if ($theme) {
                if ($theme instanceof UTheme) {
                    $theme->setParentString(implode($this->parentDelimiter, $parents));
                }
            } else {
                throw new ThemeException("Could not create theme by id $name");
            }
            self::$createdThemes[$name] = $theme;

        }
        return self::$createdThemes[$name];
    }
    public function getBaseUrl($param = null) {
        if ($param === '__last') {
            return $this -> _lastRenderedTheme -> getBaseUrl();
        }
        if ($param) {
            foreach (self::$createdThemes as $key => $theme) {
                if (preg_match('/'.$param.'$/', $key)) {
                    return $theme -> getBaseUrl;
                }
            }
        }
        return parent::getBaseUrl();
    }
    public function setLastRenderedTheme(CTheme $theme) {
        $this -> _lastRenderedTheme = $theme;
    }
    /*public function setTheme() {

    }*/
}