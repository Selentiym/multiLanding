<?php

/**
 * This is the model class for table "{{rules}}".
 *
 * The followings are the available columns in table '{{rules}}':
 * @property integer $id
 * @property string $word
 * @property integer $id_tel
 * @property integer $id_price
 * @property integer $id_section
 * @property integer $prior
 *
 * @property Price[] $prices
 * @property Tel $tel
 * @property Section $section
 * @property PriceAssignment[] $assignments
 */
class Rule extends UModel {
	/**
	 * @const USE_RULE - name of the Rule model scenario which corresponds to using one of the rules
	 */
	const USE_RULE = 'useRule';
	/**
	 * @var int[] $prices_input - contains an array of ids of prices to show.
	 */
	public $prices_input;
	/**
	 * @property integer $object_input - contains id of the price or -id of the section
	 */
	public $object_input;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{rules}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('word, id_tel, id_section', 'required'),
			array('id_tel, id_price, id_section', 'numerical', 'integerOnly'=>true),
			array('word', 'length', 'max'=>512),
			array('id, word, id_tel, prices_input, prior', 'safe', 'on'=>'create, update'),
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
				'assignments' => array(self::HAS_MANY, 'PriceAssignment', 'id_rule'),
				'price' => array(self::BELONGS_TO, 'Price', 'id_price'),
				'prices' => array(self::MANY_MANY, 'Price', '{{price_assignments}}(id_rule, id_price)'),
				'section' => array(self::BELONGS_TO, 'Section', 'id_section'),
				'tel' => array(self::BELONGS_TO, 'Tel', 'id_tel'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'word' => 'Word',
			'id_tel' => 'Id Tel',
			'id_price' => 'Id Price',
			'id_section' => 'Id Section',
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
		$criteria->compare('word',$this->word,true);
		$criteria->compare('id_tel',$this->id_tel);
		$criteria->compare('id_price',$this->id_price);
		$criteria->compare('id_section',$this->id_section);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Called before executing the $model -> save() method.
	 * @return bool whether to make database changes
	 */
	public function beforeSave(){
		/**
		 * Set the id_price and id_section parameters from data in $this -> object_input
		 */
		//Если айдишник отрицательный, то ставим номер -id в id_section,
		//иначе id в id_price номер секции price в id_section
		if ($this -> object_input) {
			if ($this -> object_input < 0) {
				$id = - $this -> object_input;
				if (Section::model() -> findByPk($id)) {
					$this -> id_section = $id;
					unset($this -> id_price);
				}
			} elseif ($this -> object_input > 0) {
				$id = $this -> object_input;
				if (Price::model() -> findByPk($id)) {
					$this -> id_price = $id;
					unset($this -> id_section);
				}
			}
		}
		//Первая попытка преотвратить неопределенные атрибуты в релейшене
		if (!$this -> id_price) {
			$this -> id_price = Price::trivialId();
		}
		if (!$this -> id_section) {
			$this -> id_section = Section::trivialId();
			//echo $this -> id_section;
		}
		return parent::beforeSave();
	}
	/**
	 * Sets CustomFlash with information about errors;1
	 */
	public function explainErrors(){
		var_dump($this -> getErrors());
		return;
	}
	/**
	 * Function to be used in ViewModel action to have more flexibility
	 * @arg mixed $arg - the argument populated from the controller.
	 * @arg mixed $external - another arguments
	 *
	 */
	public function customFind($arg = false, $external = false, $scenario = false){
		//set scenario before returning the found record.
		$ret = function($obj){
			global $scenario;
			if (is_a($obj, 'Rule')) {
				if ($scenario) {
					$obj->setScenario($scenario);
				}
			}
			return $obj;
		};
		if ($scenario == self::USE_RULE) {
			$input = $external['utm_term'];
			//Если вдруг потребутся обработка
			$phrase = $input;
			$rules = self::model()->findAll(array('order' => 'prior DESC'));
			foreach ($rules as $rule) {
				if ($rule->check($input)) {
					return $ret ($rule);
				}
			}
			return $ret(array_shift($rules));
		} else {
			return $ret($this -> findByPk($arg));
		}
	}
	/**
	 * @arg string $string - a string that may or may not subject to the this rule
	 * @return bool whether the string corresponds to the rule.
	 */
	public function check($string){
		return preg_match('/'.$this -> word.'/iu',$string);
	}
	public function afterSave() {

		parent::afterSave();
		//массив ИД цен, которые уже присвоены
		$has = CHtml::giveAttributeArray($this -> prices,'id');
		//Массив ИД цен, которые должны получиться.
		$toHave = array_unique($this -> prices_input);
		//ИД цен, которые нужно удалить
		$toDel = array_diff($has, $toHave);
		//ИД цен, которые нужно добавить
		$toAdd = array_diff($toHave, $has);
		//$this -> assignments = PriceAssignment::model() -> findAllByAttributes(array('id_rule' => $this -> id));
		//Удаляем ненужные
		if (!empty($this -> assignments)) {
			foreach ($this->assignments as $assign) {
				if (in_array($assign->id_price, $toDel)) {
					$assign->delete();
				}
			}
		}
		//Добавляем недостающие.
		foreach ($toAdd as $add) {
			$assign = new PriceAssignment();
			$assign -> id_rule = $this -> id;
			$assign -> id_price = $add;
			$assign -> save();
		}
		//Устанавливаем правильные цены на выходе.
		$this -> prices = Price::model() -> findAllByPk($toHave);
	}
}
