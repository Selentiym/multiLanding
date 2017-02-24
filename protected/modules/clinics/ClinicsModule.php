<?php

class ClinicsModule extends UWebModule
{
	public $defaultController = 'admin';

	public function init()
	{
		parent::init();
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
	 * @param array $triggers consisting of pairs ['trigger_verbiage' => 'trigger_value_verbiage']
	 * or of pairs ['trigger_verbiage' => 'trigger_value_id']
	 * @param string $order
	 * @param int $limit
	 * @param CDbCriteria $criteria additional criteria to be filtered by
	 * @return clinics[] that correspond to the specified condition
	 */
	public function getClinics(array $triggers, $order = 'rating', $limit = -1, CDbCriteria $criteria = null) {
		$triggers = array_map(function($val){
			if ((int) $val) {
				return $val;
			}
			$t = TriggerValues::model() -> findByAttributes(['verbiage' => $val]);
			return $t -> id;
		}, $triggers);
		return clinics::model() -> userSearch($triggers, $order, $limit, $criteria)['objects'];
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

			'<moduleClinics:(clinics)>/admin/<modelClass:(TriggerParameter)><act:(List|Create|Update|Delete)>/<id:\d+>' => '<moduleClinics>/admin/<modelClass><act>',
		];
	}
}
