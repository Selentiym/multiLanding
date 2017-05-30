<?php
class CallTrackerModule extends UWebModule
{
	const targetPrice = 301;
	/**
	 * @var bool $blocked
	 */
	public $blocked = false;
	/**
	 * @var callable $afterImport
	 */
	public $afterImport;
	public $formatNumber;
	/**
	 * @var CallTrackerModule
	 */
	public static $lastInstance;
	public $defaultController = 'CT';
	const requestDelay = 15000;
	const delayTimesTillGarbage = 2;
	/**
	 * @var aEnterFactory
	 */
	private $_enterFactory;
	/**
	 * @var string
	 */
	private $_assetsUrl;
	/**
	 * @var bool defines actions when no cached enter id found.
	 * Since everything happens in CallTracker::init() method,
	 * this attribute is static
	 */
	private static $_mustBeOld = false;
	/**
	 * What will be shown if the carousel is switched off
	 * @var string
	 */
	public $numberWhenBlocked;
	/**
	 * @var aEnter объект захода
	 */
	public $enter;

	public function getAssetsUrl() {
		if ($this->_assetsUrl === null)
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish($this -> basePath.'/assets/');
		return $this->_assetsUrl;
	}

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
				$this -> getId() . '.models.*',
				$this -> getId() . '.components.*',
		));

		self::$lastInstance = $this;

		//call a client-code function to set some non-trivial configurations
		if (is_callable($this -> afterImport)) {
			call_user_func($this -> afterImport, $this);
		}

		aEnterFactory::setModule($this);

		//Если не нужно выдвать номер
		if ($_GET['nonumber'] != 'off') {
			//Если через nonumber ничего не передано и раньше передано не было, то просто проходим
			if (($_GET['nonumber']) || (Yii::app()->request->cookies['nonumber']->value)) {
				//Есть что-то передано через nonumber, то не выдаем номер, а ставим заглушку.
				$this->enter = aEnterFactory::getFactory() -> buildNew();
				$fake = new phNumber();
				$fake->number = 'debugMode!';
				$this->enter->setNumber($fake);
				Yii::app()->request->cookies['id_enter'] = new CHttpCookie('nonumber', 1);
				//Не сохраняем ничего в базу, просто поставили заглушку
				return;
			}
		} else {
			//Если же nonumber четко равен off, то вырубаем заглушку, далее выберется
			//заход+телефон по общим правилам
			unset(Yii::app()->request->cookies['id_enter']);
		}


		//Пытаемся найти заход
		$enter = $this -> lookForEnter();

		if ($this -> blocked) {

			/**
			 * Temporary block
			 */
			$num = new phNumber();
			$num->id = -1;
			$num->number = $this -> numberWhenBlocked;
			$num->short_number = substr(preg_replace('/[^\d]/ui','',$num -> number),-7);
			$enter -> setNumber($num);
			/**
			 * end of temporary block
			 */
		} else {
			$enter = $enter->collectDataFromRequest();
			//Если запись старая или нам это не важно, то выдаем обычный номер
			if ((!self::$_mustBeOld)||(!$enter -> getIsNewRecord())) {
				$num = $enter->obtainNumber();
			} else {
				//Выдаем резервный номер, если не удалось найти старую запись, а она должна быть,
				//чтобы не занимать одним заходом все возможные номера карусели
				$num = current(phNumber::model() -> getReserved());
				if (!$num instanceof aNumber) {
					throw new CallTrackerException('Could not find any reserved phNumber!');
				}
				$enter->setNumber($num);
			}
		}
		$this -> enter = $enter;
	}

	private function saveEnterData(){
		//Не нужно что-либо сохранять о запросах к контреллеру трекера,
		//тк либо они запускаются автоматически если уже был
		//обычный пользовательский заход, либо они служебные
		//и не нужно на них выделять номер и тд и тп
		$c = Yii::app() -> controller;
		if (!Yii::app() -> controller instanceof CTController) {
			//Сохраняем заход
			$this->enter->save();
			//Сохраняем ид захода, чтобы потом не забыть
			$this->setCachedId($this->enter->id);
			$this->loadScripts($this->enter);
		}
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
	 * Завершаем текущий заход
	 */
	public function completeEnter(){
		//Этот заход завершен, забываем его id
		$this -> setCachedId(false);
		$this -> enter -> endOneself();
	}

	/**
	 * @return aEnter
	 */
	private function lookForEnter () {
		return aEnterFactory::getFactory() -> build();
	}

	/**
	 * @param aEnter $enter
	 */
	private function loadScripts(aEnter $enter) {
		if (!Yii::app() -> request -> isAjaxRequest) {
			$url = $this -> getAssetsUrl().'/js/tracker.js';
			//echo "<script src='$url'></script>";
			//Передали на страницу идентификатор захода пользователя
			$trace = $this -> enter -> called ? 'false' : 'true';
			$cs = Yii::app() -> getClientScript();
			$cs -> registerScript($this -> getBaseScriptName().'defineConstants','
				window.callTrackerJS = {};
				callTrackerJS.id_enter = '.$this -> enter -> id.';
				callTrackerJS.delay = '.self::requestDelay.';
				callTrackerJS.traceGoal = '.$trace.';
				callTrackerJS.price = '.self::targetPrice.';
			',CClientScript::POS_BEGIN);
			$cs -> registerScriptFile($url, CClientScript::POS_END);
			$params = $this -> getExperimentNonStatic() -> getParams();
			$cs -> registerScript('sendParams',"
			setTimeout(function(){
			try {
				var counter = window.getYaCounter();
				var yaParams = ". json_encode($params) .";
				console.log(counter);
				counter.params(yaParams);
			} catch(err){}
			},5000);
			",CClientScript::POS_READY);
		}
	}

	/**
	 * Возвращает базовое имя скрипта, чтобы не было конфликтов
	 * при назначении скриптов с одинаковыми именами в разных модулях.
	 * @return string
	 */
	private function getBaseScriptName() {
		return md5($this -> getAssetsUrl());
	}

	/**
	 * @return int
	 */
	public function getCachedId(){
		return Yii::app() -> request -> cookies['id_enter'] -> value;
		return false;
	}

	/**
	 * @param integer $val
	 */
	public function setCachedId($val) {
		Yii::app() -> request -> cookies['id_enter'] = new CHttpCookie('id_enter', $val);
	}

	/**
	 * @return iEnterFactory
	 */
	public function getEnterFactory() {

	}

	/**
	 * На случай, если вдруг не найдется модуля для
	 * инициализации фабрики входов
	 * @return string
	 */
	public static function giveLastInstanceId() {
		return 'tracker';
	}
	public function log($str) {
		$f = fopen($this -> logFileName(),'a+');
		fwrite($f, 'date: '.date('r').'<br/>'.PHP_EOL);
		fwrite($f, '<pre>'.$str.'</pre><br/>'.PHP_EOL);
		fwrite($f, '-----------<br/>'.PHP_EOL);
		fclose($f);
	}
	public function logFileName() {
		return __DIR__ . '/'.$this->getId().'.log';
	}

	/**
	 * @param $id
	 * @param bool $mustBeOld
	 * @return CallTrackerModule
	 */
	public static function useTracker($mustBeOld = false, $id = 'tracker') {
		self::$_mustBeOld = $mustBeOld;
		$mod = Yii::app() -> getModule($id);
		/**
		 * @type CallTrackerModule $mod
		 */
		$mod -> saveEnterData();
	}
	public static function removeGarbage() {
		$enters = aEnterFactory::getFactory() -> giveUnfinished();
		foreach ($enters as $enter) {
			if (!$enter -> checkTimeValidity()) {
				$enter -> endOneself();
			}
		}
	}

	/**
	 * @return CallTrackerModule
	 */
	public static function getLastInstance() {
		return self::$lastInstance;
	}

	/**
	 * @return string
	 */
	public static function getNumber() {
		return self::$lastInstance -> getNumberNonStatic();
	}
	/**
	 * @return string
	 */
	public function getNumberNonStatic() {
		return $this -> enter -> getNumber() -> getNumberString();
	}
	/**
	 * @return string
	 */
	public static function getFormattedNumber() {
		return self::$lastInstance -> getFormattedNumberNonStatic();
	}
	/**
	 * @return string
	 */
	public function getFormattedNumberNonStatic(){
		$seed = $this -> getNumber();
		if (is_callable($this -> formatNumber)) {
			$seed = call_user_func($this -> formatNumber, $seed);
		}
		return $seed;
	}
	/**
	 * @return string
	 */
	public static function getShortNumber() {
		return self::$lastInstance -> getShortNumberNonStatic();
	}
	/**
	 * @return string
	 */
	public function getShortNumberNonStatic() {
		return $this -> enter -> getNumber() -> getShortNumberString();
	}
	public static function getExperiment() {
		return self::$lastInstance -> getExperimentNonStatic();
	}
	public function getExperimentNonStatic() {
		return $this -> enter -> getExperiment();
	}
}