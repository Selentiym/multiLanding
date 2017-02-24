<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.01.2017
 * Time: 9:58
 */
class UWebModule extends \CWebModule implements iCallFunc {

    use tAssets;

    protected $_dbConnection;
    protected $_assetsPath;

    public $filesPath = 'files/';

    protected static $_lastInstances;

    public $dbConfig;

    use tCallFunc;

    public function init() {
        $n = get_called_class();
        self::$_lastInstances[$n] = $this;
        //$p = $this -> getBasePath();
        $this -> _assetsPath = Yii::app() -> getAssetManager() -> publish($this -> getBasePath() . '/assets');
        Yii::app() -> getUrlManager() -> addRules($this -> getRules());
    }

    /**
     * @return static
     */
    public static function getLastInstance() {
        $n = get_called_class();
        return self::$_lastInstances[$n];
    }

    /**
     * @return CDbConnection
     * @throws AccessException
     * @throws CDbException
     */
    public function getDbConnection() {
        if (!$this -> _dbConnection) {
            $temp = $this -> getAttribute('dbConfig');
            if (!($temp instanceof CDbConnection)) {
                $temp = Yii::app() -> getComponent($temp);
            }
            if (!($temp instanceof CDbConnection)) {
                throw new CDbException("Could not establish connection in module ". get_class($this));
            }
            $this -> _dbConnection = $temp;
        }
        return $this -> _dbConnection;
    }

    /**
     * @param string $name
     * @return bool
     */
    function _isAllowedToEvaluate($name) {
        return ($name == 'dbConfig');
    }

    /**
     * @return string
     */
    public function getAssetsPath(){
        return $this -> _assetsPath;
    }

    /**
     * @param string $route route relative to this module. Must look like <controller>/<action>
     * @param array $params
     * @param null $ampersand
     * @return string
     */
    public function createUrl ($route, $params = [], $ampersand = null) {
        return Yii::app() -> urlManager -> createUrl($this -> getId() . '/' . $route, $params, $ampersand);
    }

    /**
     * @return array configuration to be populated to UrlManager::addRules
     */
    public function getRules(){
        return [];
    }
}