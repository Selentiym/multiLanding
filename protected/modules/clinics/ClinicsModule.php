<?php
class ClinicsModule extends UWebModule {
	public $defaultController = 'admin';
	/**
	 * @var iCommentPool|null
	 */
	public $clinicsComments = null;
	/**
	 * @var iCommentPool|null
	 */
	public $doctorsComments = null;
	/**
	 * @var string[] stores already rendered parameters, has to be
	 * refreshed when a new trigger set is taken
	 */
	private $_rendered = [];
	public function init()
	{
		parent::init();
		$config = include(__DIR__ . '/config.php');
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			$this -> getId().'.models.*',
			$this -> getId().'.models.triggers.*',
			$this -> getId().'.components.*',
		));
		$this -> clinicsComments = $this -> getAttribute('clinicsComments');
		$this -> doctorsComments = $this -> getAttribute('doctorsComments');
		require_once(self::getBasePath().'/components/Helpers.php');
		$this -> setComponents($config['components']);
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
	 * @param array $triggers
	 * @param string $order
	 * @param int $limit
	 * @param CDbCriteria|null $criteria
	 * @return mixed
     */
	public function getClinics (array $triggers, $order = 'rating', $limit = -1, CDbCriteria $criteria = null) {
		$order = $triggers['sortBy'];
		if (!$criteria instanceof CDbCriteria) {
			$criteria = new CDbCriteria();
		}
		$criteria->with = 'prices';
		return $this -> getObjects('clinics',$triggers,$order,$limit,$criteria);
	}
	public function getArticles (array $triggers, $order = 'rating', $limit = -1, CDbCriteria $criteria = null) {
		$copy = $triggers;
		unset($copy['area']);
		unset($copy['district']);
		unset($copy['metro']);
		unset($copy['street']);
		unset($copy['orderBy']);
		if (count($copy) == 0) {
			return Article::model() -> root() -> findAllByAttributes(['id_type' => Article::getTypeId('text')]);
		}
		return $this -> getObjects('Article',$triggers,$order,$limit,$criteria);
	}
	/**
	 * @param string $class
	 * @param array $triggers consisting of pairs ['trigger_verbiage' => 'trigger_value_verbiage']
	 * or of pairs ['trigger_verbiage' => 'trigger_value_id']
	 * @param string $order
	 * @param int $limit
	 * @param CDbCriteria $criteria additional criteria to be filtered by
	 * @return $class[] that correspond to the specified condition
	 */
	protected function getObjects($class,array $triggers, $order = 'rating', $limit = -1, CDbCriteria $criteria = null) {
		$triggers = array_map(function($val){
			if ((int) $val) {
				return $val;
			}
			$t = TriggerValues::model() -> findByAttributes(['verbiage' => $val]);
			if ($t instanceof TriggerValues) {
				return $t->id;
			}
			return $val;
		}, $triggers);
		if ($triggers['metro']) {
			$triggers['metro'] = [$triggers['metro']];
		}
		return $class::model() -> userSearch($triggers, $order, $limit, $criteria)['objects'];
	}



	/**
	 * This functions exists to ensure that all the needed classes have been loaded
	 * @param string $class
	 * @retrun $class
	 */
	public function getClassModel($class){
		return $class::model();
	}
	public function getRules() {
		return [
			'<moduleClinics:(clinics)>' => '<moduleClinics>/admin/index',
			'<moduleClinics:(clinics)>/admin' => '<moduleClinics>/admin/index',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>PricelistCreate/<id:\d+>' => '<moduleClinics>/admin/PricelistCreate',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Pricelists/<id:\d+>' => '<moduleClinics>/admin/Pricelists',
			'<moduleClinics:(clinics)>/admin/PricelistDelete/<id:\d+>' => '<moduleClinics>/admin/PricelistDelete',
			'<moduleClinics:(clinics)>/admin/PricelistUpdate/<id:\d+>' => '<moduleClinics>/admin/PricelistUpdate',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>' => '<moduleClinics>/admin/Models',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Filters' => '<moduleClinics>/admin/Filters',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FilterCreate' => '<moduleClinics>/admin/FilterCreate',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Create' => '<moduleClinics>/admin/ObjectCreate',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>ExportCsv' => '<moduleClinics>/admin/ExportCsv',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>ImportCsv' => '<moduleClinics>/admin/ImportCsv',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldsGlobal' => '<moduleClinics>/admin/FieldsGlobal',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldCreateGlobal' => '<moduleClinics>/admin/FieldCreateGlobal',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Fields/<id:\d+>' => '<moduleClinics>/admin/Fields',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldsCreate/<id:\d+>' => '<moduleClinics>/admin/FieldsCreate',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>FieldsUpdate/<id:\d+>' => '<moduleClinics>/admin/FieldsUpdate',
			'<moduleClinics:(clinics)>/admin/FieldUpdateGlobal/<id:\d+>' => '<moduleClinics>/admin/FieldUpdateGlobal',
			'<moduleClinics:(clinics)>/admin/FieldDeleteGlobal/<id:\d+>' => '<moduleClinics>/admin/FieldDeleteGlobal',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Delete/<id:\d+>' => '<moduleClinics>/admin/ObjectDelete',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)>Update/<id:\d+>' => '<moduleClinics>/admin/ObjectUpdate',


			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)><modelClass:(Price)><act:(Update|Delete|Create)>/<id:\d+>' => '<moduleClinics>/admin/<modelClass><act>',
			'<moduleClinics:(clinics)>/admin/<modelClass:(Price|PriceBlock)><act:(Update|Delete|Create)>/<id:\d+>' => '<moduleClinics>/admin/<modelClass><act>',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)><modelClass:(Price)><act:(Create)>' => '<moduleClinics>/admin/<modelClass><act>',
			'<moduleClinics:(clinics)>/admin/<modelClass:(Price|PriceBlock)><act:(Create)>' => '<moduleClinics>/admin/<modelClass><act>',
			'<moduleClinics:(clinics)>/admin/<modelName:(clinics|doctors)><modelClass:(Price)>List' => '<moduleClinics>/admin/<modelClass>List',

			'<moduleClinics:(clinics)>/admin/triggerRequest/<verbiage:\w+>' => '<moduleClinics>/admin/triggerRequest',

			'<moduleClinics:(clinics)>/admin/<modelClass:(TriggerParameter)><act:(List|Create|Update|Delete)>/<id:\d+>' => '<moduleClinics>/admin/<modelClass><act>',
		];
	}

	/**
	 * @param CDbCriteria|null $criteria
	 * @return Article[]
	 */
	public function getRootArticles(CDbCriteria $criteria = null) {
		if (!$criteria) {
			$criteria = new CDbCriteria();
			$criteria -> compare('id_type', Article::getTypeId('text'));
		}
		$criteria -> addCondition('level = 0 OR parent_id = 0 OR parent_id IS NULL');
		return Article::model() -> findAll($criteria);
	}

	/**
	 * @param string $class = 'doctors'|'clinics'
	 * @return iCommentPool
	 */
	public function getObjectsReviewsPool($class) {
		if (in_array($class,['clinics','doctors'])) {
			$name = $class . 'Comments';
			return $this -> $name;
		}
		return null;
	}
	public function _isAllowedToEvaluate($name) {
		return in_array($name, ['clinicsComments','doctorsComments']) || parent::_isAllowedToEvaluate($name);
	}

	/**
	 *
	 */
	public function averagePrice($triggers) {
		if ($v = $triggers['research']) {
			$prices = [ObjectPrice::model() -> findByAttributes(['verbiage' => $v])];
		} else {
			$prices = [];
			if ($triggers['mrt']) {
				$prices = array_merge($prices, ObjectPrice::model() -> findAllByAttributes(['id_type' => PriceType::getId('mrt')]));
			}
			if ($triggers['kt']) {
				$prices = array_merge($prices, ObjectPrice::model() -> findAllByAttributes(['id_type' => PriceType::getId('kt')]));
			}
			if (empty($prices)) {
				$prices = ObjectPrice::model() -> findAll();
			}
		}
		$c = 0;
		$sum = 0;
		foreach ($prices as $p) {
			foreach ($p -> values as $value) {
				$sum += $value -> value;
				$c ++;
			}
		}
		if ($c == 0) {
			return 0;
		}
		return round($sum / $c);
	}
	public function renderParameter ($triggers, $trigger_verb, $field){
		$rendered = $this -> _rendered;
		if (!isset($rendered)) {
			$rendered = [];
		}
		if (!isset($rendered[$trigger_verb][$field])) {
			$rendered[$trigger_verb][$field] = Article::renderParameter($triggers, $trigger_verb, $field);
		}
		return $rendered[$trigger_verb][$field];
	}
	public function refreshRendered($newArr = []){
		$this -> _rendered = $newArr;
	}
}
