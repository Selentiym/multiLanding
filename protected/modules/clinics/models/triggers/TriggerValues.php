<?php

/**
 * This is the model class for table "{{trigger_values}}".
 *
 * The followings are the available columns in table '{{trigger_values}}':
 * @property integer $id
 * @property integer $trigger_id
 * @property string $verbiage
 * @property string $value
 * @property string $logo
 *
 * @property TriggerValues[] $dependencies
 * @property TriggerValues[] $children
 * @property Triggers $trigger
 */
class TriggerValues extends CTModel {
	public $dependency_array;
	public $children_array;
	private $_triggerParameterValues;
	/**
	 * @return string delimeter the delimeter in searchId string
	 */
	public function delimeter()
	{
		return '_';
	}	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{trigger_values}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trigger_id, value', 'required'),
            array('verbiage',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
            ),
			array('trigger_id', 'numerical', 'integerOnly'=>true),
			array('value, verbiage', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, trigger_id, value, verbiage, dependency_array, children_array, comment', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'trigger' => array(self::BELONGS_TO, 'Triggers', array('trigger_id' => 'id'), 'select' => '*'),
            'dependencies' => array(self::HAS_MANY, 'TriggerValueDependency', ['verbiage_child' => 'verbiage']),
            'children' => array(self::HAS_MANY, 'TriggerValueDependency', ['verbiage_parent' => 'verbiage']),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => CHtml::encode('ID'),
			'trigger_id' => CHtml::encode('Триггер'),
			'value' => CHtml::encode('Значение'),
            'verbiage' => CHtml::encode('Человекопонятный URL'),
		);
	}
	/**
	 * @arg string searchId - the string to be analized
	 * @return array - array which is similar to $_GET[$modelName."searchForm"] structure that is
	 * array(trigger verbiage => trigger value id)
	 */
	public function decodeSearchId($searchId)
	{
		if ($searchId) {
			$verbArray = explode(self::delimeter(), $searchId);
			$criteria = new CDbCriteria;
			$criteria -> addInCondition('verbiage', $verbArray);
			$values = self::model()->findAll($criteria);
			$rez = array();
			if (!empty($values)){
				foreach($values as $value)
				{
					$rez[$value -> trigger -> verbiage] = $value -> id;
				}
			}
			return $rez;
		} else {
			return array();
		}
	}
	/**
	 * @arg array - an array of trigger values' ids to be coded.
	 * @return string - the search id of the specified set of trigger values
	 */
	public function codeSearchId($triggers)
	{
		$criteria = new CDbCriteria();
		$criteria -> addInCondition('id', $triggers);
		$triggers = self::model() -> findAll($criteria);
		$search_id ='';
		if (!empty($triggers)) {
			foreach ($triggers as $trigger) {
				$search_id .= $trigger -> verbiage.'_';
			}
			$modelName = Objects::model() -> getName($_GET["type"]);
			$modelName = (!$modelName) ? 'clinics' : $modelName;
			return $modelName.'?search_id='.substr($search_id, 0, strrpos($search_id, '_'));
		} else {
			return "clinics";
		}
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('trigger_id',$this->trigger_id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	protected function beforeSave()
	{
		if (!$this->verbiage){
			$this->verbiage = str2url($this -> value);
		}
		return parent::beforeSave();
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TriggerValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @param integer $id of the TriggerParameter for which the value is needed
	 * @return TriggerParameterValue|null
	 */
	public function getParameterValue($id) {
		return $this -> getTriggerParameterValuesArray() [$id];
	}
	/**
	 * @param string $verbiage of the TriggerParameter for which the value is needed
	 * @return TriggerParameterValue|null
	 */
	public function getParameterValueByVerbiage($verbiage) {
		$id = TriggerParameter::idByVerbiage($verbiage);
		return $this -> getTriggerParameterValuesArray()[$id];
	}
	/**
	 * @return TriggerParameterValue[]
	 */
	public function getTriggerParameterValuesArray(){
		if (!isset($this -> _triggerParameterValues)) {
			$temp = [];
			foreach ($this->getTriggerParameterValues() as $val) {
				$temp[$val->id_trigger_parameter] = $val;
			}
			$this -> _triggerParameterValues = $temp;
		}
		return $this -> _triggerParameterValues;
	}
	/**
	 * @return TriggerParameterValue[]
	 */
	public function getTriggerParameterValues() {
		return TriggerParameterValue::model() -> findAllByAttributes(['id_trigger_value' => $this -> id]);
	}
	public function afterSave() {
		$data = $_POST["parameters"];
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				$val = $this->getParameterValue($k);
				if (!$val) {
					$val = new TriggerParameterValue();
				}
				$val->id_trigger_parameter = $k;
				$val->value = $v;
				$val->id_trigger_value = $this->id;
				$val->save();
			}
		}
		if ($_POST["submitted"]) {
			//Родителей задаем
			if (empty($this->dependency_array)) {
				$this->dependency_array = [];
			}
			$has = [];
			foreach ($this->dependencies as $d) {
				$has[] = $d->verbiage_parent;
				if (!in_array($d->verbiage_parent, $this->dependency_array)) {
					$d->delete();
				}
			}
			$toAdd = array_diff($this->dependency_array, $has);
			foreach ($toAdd as $verb) {
				$dep = new TriggerValueDependency();
				$dep->verbiage_child = $this->verbiage;
				$dep->verbiage_parent = $verb;
				$dep->save();
			}
			//Детей задаем
			if (empty($this->children_array)) {
				$this->children_array = [];
			}
			$has = [];
			foreach ($this->children as $d) {
				$has[] = $d->verbiage_child;
				if (!in_array($d->verbiage_child, $this->children_array)) {
					$d->delete();
				}
			}
			$toAdd = array_diff($this->children_array, $has);
			foreach ($toAdd as $verb) {
				$dep = new TriggerValueDependency();
				$dep->verbiage_parent = $this->verbiage;
				$dep->verbiage_child = $verb;
				$dep->save();
			}
		}
		parent::afterSave();
	}
}
