<?php

class ClinicsModule extends UWebModule
{
	private $_assetsPath;
	private static $_lastInstance;

	public function init()
	{
		$config = include(__DIR__ . '/config.php');
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'clinics.models.*',
			'clinics.components.*',
		));
		require_once(self::getBasePath().'/components/Helpers.php');
		$this -> setComponents($config['components']);
		$this -> _assetsPath = Yii::app() -> getAssetManager() -> publish($this -> getBasePath() . '/assets');
		self::$_lastInstance = $this;
	}

	/**
	 * @return static
	 */
	public static function getLastInstance() {
		return self::$_lastInstance;
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	/**
	 * @param string $file
	 * @param int $pos
	 * @param array $options
	 */
	public function registerJSFile($file, $pos = null, $options = []){
		Yii::app() -> getClientScript() -> registerScriptFile($this -> _assetsPath.'/'.$file,$pos,$options);
	}
	/**
	 * @param string $file
	 * @param string $media
	 */
	public function registerCSSFile($file, $media = null){
		$name = $this -> _assetsPath.'/'.$file;
		Yii::app() -> getClientScript() -> registerCssFile($name,$media);
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
}
