<?php

/**
 * This is the model class for table "{{rule}}".
 *
 * The followings are the available columns in table '{{rule}}':
 * @property integer $id
 * @property string $verbiage
 * @property integer $negative
 * @property integer $num
 * @property integer $active
 * @property string $expression
 * @property integer $id_object
 * @property integer $id_object_type
 *
 * @property Article article
 * @property RuleTrigger[] triggerValues
 */
class ArticleRule extends UClinicsModuleModel implements iRule
{
	private $_triggers;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{rule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verbiage, num, id_object, id_object_type', 'required'),
			array('negative, num, active, id_object, id_object_type', 'numerical', 'integerOnly'=>true),
			array('expression', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, verbiage, negative, num, active, expression, id_object, id_object_type', 'safe', 'on'=>'search'),
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
			'article' => [self::BELONGS_TO,'Article','id_object'],
			'triggerValues' => [self::HAS_MANY,'RuleTrigger','id_rule']
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'verbiage' => 'Verbiage',
			'negative' => 'Negative',
			'num' => 'Num',
			'active' => 'Active',
			'expression' => 'Expression',
			'id_object' => 'Id Object',
			'id_object_type' => 'Id Object Type',
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
		$criteria->compare('verbiage',$this->verbiage,true);
		$criteria->compare('negative',$this->negative);
		$criteria->compare('num',$this->num);
		$criteria->compare('active',$this->active);
		$criteria->compare('expression',$this->expression,true);
		$criteria->compare('id_object',$this->id_object);
		$criteria->compare('id_object_type',$this->id_object_type);
		$criteria->order='active DESC, num ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function customFind($id = null) {
		switch ($this -> getScenario()) {
			case 'list':
				$this -> id_object_type = $_GET["type"];
				return $this;
				break;
			case 'update':
				return $this -> findByPk($_GET['id']);
				break;
			default:
				if ($id) {
					return $this -> findByPk($id);
				}
				return $this;
				break;
		}
	}
	public function readData($data){
		$this -> id_object_type = $data['type'];
	}

	/**
	 * @return RuleTrigger[]
	 */
	public function getTriggers(){
		if (!isset($this -> _triggers)) {
			$this -> _triggers = [];
			foreach ($this -> triggerValues as $val) {
				$this -> _triggers[$val -> triggerVerbiage] = $val;
			}
		}
		return $this -> _triggers;
	}
	public function afterSave(){
		$data = $_POST;
		if ($data['submitButton']) {
			unset($data['submitButton']);
			unset($data['ArticleRule']);
			$data = array_filter($data);
			$has = array_map(function($d){return $d->valueVerbiage;},$this -> getTriggers());
			$toAdd = array_diff_key($data,$has);
			$toDel = array_diff_key($has, $data);
			$toChange = array_intersect_key($data, $has);
			foreach ($toAdd as $k => $val) {
				$link = new RuleTrigger();
				$link -> id_rule = $this -> id;
				$link -> triggerVerbiage = $k;
				$link -> valueVerbiage = $val;
				$link -> save();
			}
			$triggers = $this -> getTriggers();
			foreach ($toDel as $k => $trash) {
				$triggers[$k] -> delete();
			}
			foreach ($toChange as $k => $val) {
				if ($val != $triggers[$k] -> valueVerbiage) {
					$triggers[$k]->valueVerbiage = $val;
					$triggers[$k]->save();
				}
			}
		}
		return parent::afterSave();
	}
	public function applyTriggers($args) {
		$triggers = $this -> getTriggers();
//		foreach ($args as $key => $val) {
//			if ($triggers[$key] -> valueVerbiage != $val) {
//				return false xor $this -> negative;
//			}
//		}
		foreach ($triggers as $key => $val) {
			if ($val -> valueVerbiage != $args[$key]) {
				return false xor $this -> negative;
			}
		}
		return true xor $this -> negative;
	}

	/**
	 * @param mixed[] $args
	 * @param array $cached
	 * @return bool
	 */
	public function apply($args, &$cached = []){
		if (!$this -> expression) {
			return $this->applyTriggers($args);
		} else {
			$ev = new ArticleRuleExpressionEvaluator($args, $this);
			$ev -> setExpression($this -> expression);
			try {
				return $ev->evaluate();
			} catch (ExpressionException $e) {
				return false;
			}
		}
	}

	/**
	 * @param string $typeName
	 * @param mixed[] $triggers
	 * @return Article[]
	 * @throws Exception
	 */
	public static function getAllArticles($typeName, $triggers, $stopOnFirst = false){
		$id = Article::getTypeId($typeName);
		if (!$id) {
			throw new Exception("There is no type of articles called $typeName.");
		}
		$c = new CDbCriteria();
		$c -> compare('id_object_type', $id);
		$c -> compare('active', 1);
		$c -> order = 'num ASC';
		$rez = [];
		foreach (ArticleRule::model() -> findAll($c) as $rule) {
			/**
			 * @type ArticleRule $rule
			 */
			if ($rule -> apply($triggers)) {
				$rez[] = $rule -> article;
				if ($stopOnFirst) {
					break;
				}
			}
		}
		return $rez;
	}

	/**
	 * @param string $typeName
	 * @return Article|bool
	 * @throws Exception
	 */
	public static function getArticle($typeName){
		$rez = self::getAllArticles($typeName, $_GET, true);
		return current($rez);
	}

	protected function getDbType() {
		return 'article';
	}
}
