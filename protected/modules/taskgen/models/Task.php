<?php

/**
 * This is the model class for table "{{task}}".
 *
 * The followings are the available columns in table '{{task}}':
 * @property integer $id
 * @property string $name
 * @property integer $id_author
 * @property integer $id_editor
 * @property integer $id_pattern
 * @property integer $id_parent
 * @property string $created
 * @property integer $id_text
 * @property integer $toPay
 * @property integer $min_length
 * @property integer $max_length

 *
 * The followings are the available model relations:
 * @property Text[] $texts
 * @property Text[] $notAcceptedTexts
 * @property Text $currentText
 * @property Text $currentlyWrittenText
 * @property Text $rezult
 * @property Task $parent
 * @property Task[] $children
 */
class Task extends TaskGenModel {
	const MIN_UNIQUE = 90;
	const MAX_NOSEA = 9;
	//const MAX_NUCL_WORD = 4;
	const MAX_WORD = 4;
	const crossCheckNum = 3;

	/**
	 * @var array[] $phrases массив ключевых фраз при создании/изменении модели
	 */
	public $phrases = array();
	/**
	 * @var string $input_search - данные из textarea при добавлении ключевых фраз
	 */
	public $input_search;
	/**
	 * @var string $input_search - данные из textarea по кластеру
	 */
	public $keystring;
	/**
	 * @var bool $notifyAuthorFlag
	 */
	public $notifyAuthorFlag = false;
	/**
	 * @var int $toTextRedirect
	 */
	public $toTextRedirect;
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{task}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_editor, id_pattern, name', 'required'),
			array('id, id_author, id_editor, id_pattern, id_text', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_author, id_editor, id_pattern, created, id_text, name, min_length, max_length', 'safe', 'on'=>'search'),
			array('id_author, id_pattern, phrases, name, min_length, max_length', 'safe', 'on'=>'create'),
			array('id_author, id_pattern, phrases, name, min_length, max_length', 'safe', 'on'=>'generate'),
			array('input_search, keystring', 'safe', 'on'=>'addKeywords'),
			array('*', 'safe', 'on'=>'copyAll'),
		);
	}

	/**
	 * @inherited
	 */
	public function CommentId() {
		return 1;
	}
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'notAcceptedTimes' => array(self::STAT, 'Text', 'id_task', 'condition' => 'accepted=0'),
			'notAcceptedTexts' => array(self::HAS_MANY, 'Text', 'id_task', 'condition' => 'accepted=0'),
			'notAcceptedTextsNum' => array(self::STAT, 'Text', 'id_task', 'condition' => 'accepted=0'),
			'texts' => array(self::HAS_MANY, 'Text', 'id_task', 'order' => 'updated DESC'),
			'currentText' => array(self::HAS_ONE, 'Text', 'id_task', 'order' => 'updated DESC'),
			'currentlyWrittenText' => array(self::HAS_ONE, 'Text', 'id_task', 'condition' => 'handedIn = 0', 'order' => 'updated DESC'),
			'rezult' => array(self::BELONGS_TO, 'Text', 'id_text'),
			'parent' => array(self::BELONGS_TO, 'Task', 'id_parent'),
			'children' => array(self::HAS_MANY, 'Task', 'id_parent'),
		);
		//Строчка +parent::relations() делает эту модель комментируемой.
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'id_author' => 'Id Author',
			'id_editor' => 'Id Editor',
			'id_pattern' => 'Id Pattern',
			'created' => 'Created',
			'id_text' => 'Id Text',
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_author',$this->id_author);
		$criteria->compare('id_editor',$this->id_editor);
		$criteria->compare('id_pattern',$this->id_pattern);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('id_text',$this->id_text);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @inherit
	 */
	public function readData($data){
		//Создает задание тот, кто сейчас залогинен
		$this -> id_editor = Yii::app() -> user -> getId();
		//В дальнейшем будет древовидная структура
		$this -> id_parent = $data['parentId'];
    }
	public function scopes(){
		return array(
			'root' => array('condition' => 'id_parent = 0'),
			'uncategorized' => array('condition' => 'id_parent IS NULL'),
		);
	}
	public function beforeSave() {
		//Хочу оповестить автора о присвоении ему задания.
		if ($this -> id_author) {
			$this -> notifyAuthorFlag = $this -> DBModel() -> id_author != $this -> id_author;
		}
		if ($this -> getScenario() == 'move') {
			if ($toMove = Task::model() -> findByPk($_GET['where'])) {
				$this->id_parent = $toMove -> id;
			}
		}
		return parent::beforeSave();
	}

	protected function afterSave(){
		//Вызываем после получения id.
		$this -> notifyAuthorAboutAssign();

		if (!empty($this -> phrases['text'])) {
			foreach ($this->phrases['text'] as $key => $phr) {
				if (!($this -> phrases['changed'][$key])) {
					continue;
				}
				$kp = new Keyphrase();
				$kp->id_task = $this->id;
				$kp->phrase = $phr;
				$kp->direct = $this->phrases ['strict'][$key];
				$kp->morph = $this->phrases ['morph'][$key];
				$kp->freq = $this->phrases ['freq'][$key];
				$kp->tag = $this->phrases ['tag'][$key];
				if (!$kp->save()) {
					$temp = $kp->getErrors();
				}
			}
		}
		//Удаляем ненужные записи
		if (count($this -> phrases['toDel']) > 0) {
			$crit = new CDbCriteria();
			$crit->addInCondition('id', $this->phrases['toDel']);
			Keyphrase::model() -> deleteAll($crit);
		}
		/**
		 * Добавление поисковых фраз из textarea
		 */
		$ar = preg_split("/\r\n/", $this -> input_search);
		array_map(function($el){
			$temp = array_map('trim',preg_split("/\t/",trim($el)));
			if ($temp[0]) {
				$phr = new SearchPhrase('create');
				$phr -> attributes = array(
						'phrase' => $temp[0],
						'baseFreq' => $temp[3],
						'phraseFreq' => $temp[4],
						'directFreq' => $temp[5],
						'id_task' => $this -> id
				);
				 if ($phr -> save()) {
					 echo '';
				 } else {
					 $err = $phr -> getErrors();
				 }
			}
			return false;
		},$ar);
		/**
		 * Добавление "библиотеки" ключевых слов, тоже из textarea
		 */
		//Получили список кластеризованных слов.
		array_map(function($el){
			$temp = array_map('trim',preg_split("/\t/",trim($el)));
			$key = new Keyword();
			$key -> num = $temp[1];
			$key -> word = $temp[0];
			//Стараемся не сохранять стопы и прочий мусор
			if (trim(arrayString::removeRubbishFromString($key -> word))) {
				$this->addKey($key);
			}
		},array_map('trim',preg_split("/\r\n/",$this -> keystring)));
		return parent::afterSave();
	}
	public function customFind($arg = false) {
		if ($arg) {
			if (($this->scenario == 'view')||($this -> scenario == 'make')) {
				return $this -> findByPk($arg);
			}
			if ($this -> getScenario() == 'move') {
				//Чтобы прошло сохранение.
				$_POST['Task'] = [];
			}
		}
		if ($this -> getScenario() == 'deleteGroup') {
			return self::model();
		}
		return $this -> findByPk($arg);
	}

	/**
	 * @return string - a link to the task
	 */
	public function show(){
		return CHtml::link($this -> name, Yii::app() -> createUrl('task/view',['arg' => $this -> id]));
	}


	public function dumpForProject(){
		$text = $this -> currentText;
		/**
		 * @type Text $text
		 */
		$name = '';
		$arr = array('id' => $this -> id, 'name' => $this -> name, 'extra' => [
				'handedIn' => $text -> handedIn,
				'QHandedIn' => $text -> QHandedIn,
				'accepted' => $text -> accepted,
				'hasChildren' => (Task::model() -> countByAttributes(['id_parent' => $this -> id]) > 0),
				'comment' => $this -> comment
		]);
		return $arr;
	}
}
