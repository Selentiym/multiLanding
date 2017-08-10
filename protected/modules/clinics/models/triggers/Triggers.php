<?php

/**
 * This is the model class for table "{{triggers}}".
 *
 * The followings are the available columns in table '{{triggers}}':
 * @property integer $id
 * @property string $name
 * @property string $verbiage
 * @property string $type
 * @property string $logo
 * @property int $id_parent
 * @property bool $showIfNullParent
 *
 * @property Triggers $parent
 * @property Triggers[] $children
 * @property TriggerValues[] $trigger_values
 */
class Triggers extends CTModel {
	use tTriggersStandard;
	public static $types = [
		'DropDownTrigger' => 'Списком',
		'TickTrigger' => 'Галочками',
		'ButtonTrigger' => 'Кнопкой',
		'HiddenTrigger' => 'Спрятанный',
	];

	public function instantiate($attributes) {
		$className = $attributes['type'];
		$loaded = @class_exists($className);
		if ($loaded) {
			return new $className(null);
		}
		$defautlName = current(array_flip(self::$types));
		return new $defautlName(null);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{triggers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, verbiage', 'required'),
			array('name, verbiage', 'length', 'max'=>255),
            array('verbiage',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
            ),
			array('logo', 'file', 'types'=>'jpg, jpeg, gif, png', 'maxSize' => 1048576, 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, verbiage, type, id_parent, showIfNullParent', 'safe'),
		);
	}
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this -> isNewRecord)
			{
				if (Triggers::model() -> exists('verbiage=:verb',array(':verb' => $this -> verbiage)))
				{
					new CustomFlash('warning','Triggers','VerbiageExists','Триггер с таким латинским наименованием уже существует.', true);
					return false;
				}
				return true;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'trigger_values' => array(self::HAS_MANY, 'TriggerValues', array('trigger_id' => 'id'), 'select' => '*'),
            'parameters' => array(self::HAS_MANY, 'TriggerParameter', 'id_trigger'),
			'parent' => array(self::BELONGS_TO, 'Triggers', 'id_parent'),
			'children' => array(self::HAS_MANY, 'Triggers', 'id_parent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => CHtml::encode('ID'),
			'name' => CHtml::encode('Название'),
            'verbiage' => CHtml::encode('Обозначение (латинскими буквами)'),
			'logo' => CHtml::encode('Логотип'),
			'showIfNullParent' => CHtml::encode('Активен при не выбранном родителе'),
		);
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
		$criteria->compare('name',$this->name,true);
        $criteria->compare('verbiage',$this->verbiage,true);
		$criteria->compare('logo',$this->logo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Triggers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/* CUSTOM FUNCTIONS*/
	/**
	 * @return Triggers[]
	 */
	public static function topLevel() {
		$criteria = new CDbCriteria();
		$criteria -> addCondition('id_parent IS NULL OR id_parent = 0');
		return self::model() -> findAll($criteria);
	}

	public function FolderKey()
	{
		return 'verbiage';
	}
	public function showValues($empty = false, $formName = 'clinicsSearchForm', $selected = false) {
		if ($empty) {
			echo "<option value=''>";
			echo $this -> name;
			echo "</option>";
		}
		foreach ($this -> trigger_values as $val) {
			$sel = '';
			if ($selected == $val -> id) {
				$sel = 'selected = "selected"';
			}
			echo "<option {$sel} value='{$val -> id}'>{$val -> value}</option>";
		} 
		Yii::app() -> getClientScript() -> registerScript("select".$this -> verbiage,"
			$('#".$this -> verbiage."Select option[value=\'".$_POST[$formName][$this -> verbiage]."\']').attr('selected','selected');
		",CClientScript::POS_END);
	}
	public function showBinary($fromPage = array(), $htmlOptions = array(), $modelName = 'clinics', $formName='SearchForm'){
		$htmlOptions['type'] = 'checkbox';
		if (!$htmlOptions['name']) {
			$htmlOptions['name'] = $modelName.$formName.'['.$this -> verbiage.']';
		}
		if (!$htmlOptions['id']) {
			$htmlOptions['id'] = $modelName.$formName.'['.$this -> verbiage.']';
		}
		$val = current($this -> trigger_values);
		if ($val) {
			if ($fromPage[$this -> verbiage] == $val -> id) {
				$htmlOptions['checked'] = 'checked';
			}
			$htmlOptions['value'] = $val -> id;
			echo CHtml::tag('input',$htmlOptions);
			echo $val -> value;
		}
	}

	/**
	 * @param array $data contains ALL information about the form
	 * @param array $htmlOptions htmlOptions for the element
	 * @param array $dopParameters additional parameters that may differ from trigger to trigger
	 * @return null|string
	 */
	public function getHtml(&$data = [], $htmlOptions = [], $dopParameters = []){
		$name = $htmlOptions['name'] ? $htmlOptions['name'] : $this -> verbiage;
		$id = $htmlOptions['id'] ? $htmlOptions['id'] : $this -> verbiage;
		$htmlOptions = array_merge($htmlOptions, $dopParameters);
		unset($htmlOptions['noChildren']);
		$options = [];
		$p = $this -> parent;
		if ((!$data[$p->verbiage])&&($p)) {
			if (!$this -> showIfNullParent) {
				if (!isset($htmlOptions['disabled'])) {
					$htmlOptions['disabled'] = 'disabled';
				}
			}
		}
		if (!$htmlOptions['disabled']) {
			if (($p) && ($data[$p->verbiage])) {
				$cr = new CDbCriteria();
				$cr->compare('verbiage_parent', $data[$p->verbiage]);
				$cr->together = 'child';
				$cr->with = 'child';
				//$cr -> ('child.id_trigger='.$this -> id);
				$dep = TriggerValueDependency::model()->findAll($cr);
				$options = [];
				foreach ($dep as $d) {
					$tv = $d->child;
					$a = $tv -> attributes;
					if ($tv -> trigger_id == $this -> id) {
						$options[] = $tv;
					}
				}
			} else {
				$options = $this->trigger_values;
			}
		}
		$children = $this -> getChildrenHtml($data, $id);
		if ($dopParameters['noChildren']) {
			$children = '';
		}
		return CHtml::DropDownListChosen2(
			$name,
			$id,
			CHtml::listData($options,'verbiage','value'),
			//$htmlOptions['disabled'] ? [] : CHtml::listData($this -> trigger_values,'verbiage','value'),
			$htmlOptions,
			$data[$this -> verbiage] ? [$data[$this -> verbiage]] : [],
			$dopParameters,
			true
		) . $children;
	}

	/**
	 * @param $elementId
	 * @return string html of children
	 */
	public function getChildrenHtml(&$data, $elementId) {
		$verbs = [];
		$html = '';
		foreach ($this -> children as $child) {
			$verbs[] = $child -> verbiage;
			/**
			 * @type Triggers $child
			 */
			$options = ['placeholder' => $child -> name,'empty_line' => true, 'class' => 'trigger_select'];
			$html .= $child -> getHtml($data,$options);
		}
		$params = [
			'url' => $this -> getModule() -> createUrl('admin/triggerRequest',['verbiage' => $this -> verbiage]),
			'verbiage' => $this -> verbiage,
			'childrenVerbs' => $verbs,
			'parentVerb' => $this -> parent ? $this -> parent -> verbiage : false,
			'elementId' => $elementId
		] + $this -> loadJavascripts();
		$this -> getModule() -> registerJSFile('js/triggers.js',CClientScript::POS_BEGIN);
		Yii::app() -> getClientScript() -> registerScript('trigger'.$this -> verbiage,'
			new Trigger('.CJavaScript::encode($params).');
		',CClientScript::POS_END);
		return $html;
	}
	public function loadJavascripts(){
		return [
			'beforeDataUpdate' => 'js:function(){

			}',
			'dataUpdate' => 'js:function(data){
				//alert("update");
				this.element.html(data.html);
				this.element.removeAttr("disabled");
				//this.element.trigger("change");
				this.element.select2();
			}',
			'afterDataUpdate' => 'js:function(){

			}'
		];
	}
	/**
	 * @param $object - to be checked
	 * @param array $values of the trigger that are selected
	 * @param array $cached some data that may be useful for all the triggers in common
	 * @return bool
	 */
	//public function checkObject($object, $values = [], $cached = []);
	/*public function generateImageFolderUrl($seed = NULL)
	{
		if (!isset($seed))
		{
			if (isset($this -> verbiage))
			{
				return Yii::app()->basePath.'/../images/triggers/' . $this -> verbiage . '/';
			} else {
				return false;
			}
		} else {
			return Yii::app()->basePath.'/../images/triggers/' . $seed . '/';
		}
	}*/
	public function objectClassForFileFolder(){
		return 'Triggers';
	}

	public function customFind($id = null){
		switch($this -> getScenario()) {
			case 'dumpValues':
				return $this -> findByAttributes(['verbiage' => $_GET['verbiage']]);
				break;
			default:
				return parent::customFind($id);
				break;
		}
	}
	public function dumpValues() {
		$data = $_POST;
		$toArg = [$data['parent'] => $data['newVal']];
		$options = ['placeholder' => $this -> name,'empty_line' => true, 'class' => 'trigger_select'];

		echo json_encode(['html' => $this -> getHtml($toArg,$options,['noChildren' => true])] + $this -> dumpExtraValues());
	}
	public function dumpExtraValues() {
		return [];
	}
	public static function triggerHtml($verbiage, &$triggers, $htmlOptions = [], $dopOptions = []){
		$t = self::model() -> with('parent','children') -> findByAttributes(['verbiage' => $verbiage]);
		/**
		 * @type Triggers $t
		 */
		$htmlOptions = array_merge(['class' => 'trigger_select'],$htmlOptions);
		$dopOptions = array_merge(['noChildren' => true, 'placeholder' => $t -> name,'empty_line' => true], $dopOptions);
		return $t -> getHtml($triggers,$htmlOptions,$dopOptions);
		//
	}
}
