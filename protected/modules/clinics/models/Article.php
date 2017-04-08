<?php

/**
 * This is the model class for table "{{articles}}" - it describes a standard Article
 *
 * The followings are the available columns in table '{{articles}}':
 * @property integer $id
 * @property string $name
 * @property string $verbiage
 * @property integer $parent_id
 * @property integer $level
 * @property string $text
 * @property string $description
 * @property integer $id_type
 * @property integer $id_taskgen
 * @property string $triggers
 *
 * @property ArticleResearch[] $researches
 */
 
class Article extends BaseModel {
	const PRICE_VERBIAGE = 'research';
	public static $types = [
		1 => 'text',
		2 => 'service',
		3 => 'dynamic',
		4 => 'commercial'
	];
	/**
	 * @property array children - an array of Article objects that are children to this one.
	 */
	public $children;
	protected $ParentList;
	public $research_input = [];
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lib_articles}}';
	}

	/**
	 * @param integer $id
	 * @return string
	 */
	public static function getTypeName($id){
		return self::$types[$id];
	}

	/**
	 * @param string $name
	 * @return integer
	 */
	public static function getTypeId($name) {
		return array_flip(self::$types)[$name];
	}
	public function beforeDelete() {
		if (parent::beforeDelete()) {
			$criteria = new CDbCriteria;
			$criteria -> compare('parent_id', $this -> id);
			if (self::model () -> find($criteria)) {
				new CustomFlash('error','Aricle','Delete','HasDecendants','Нельзя удалить статью, которая имеет потомков. Сначала удалите все дочерние статьи.',true);
				echo 'Нельзя удалить статью, которая имеет потомков. Сначал удалите все дочерние статьи.';
				return false;
			}
			return true;
		}
		return false;
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, verbiage, text, show_objects', 'required', 'except' => 'createDescendant'),
			array('parent_id, level', 'required'),
            array('verbiage',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
            ),
			array('parent_id, level, show_objects', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('verbiage, clinic_card', 'length', 'max'=>50),
            array('title', 'length', 'max'=>255),
            array('keywords, description', 'length', 'max'=>2000),
			array('id, name, verbiage, parent_id, level, text, clinic_card, title, keywords, description, show_objects, id_parent, id_type, research_input, id_taskgen', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'parent' => array(self::BELONGS_TO, 'Article', 'parent_id'),
			'researches' => array(self::HAS_MANY, 'ArticleResearch', 'id_article')
		);
	}

	public function scopes(){
		return array(
			'root' => array('condition' => 'parent_id = 0'),
			'uncategorized' => array('condition' => 'parent_id IS NULL'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'show_objects' => 'Показывать ли под статьей карточки клиник',
			'name' => CHtml::encode('Название'),
			'verbiage' => CHtml::encode('Человекопонятный URL'),
			'category' => CHtml::encode('Категория (пункт бокового меню)'),
            'menu_sublevel' => CHtml::encode('Уровень подменю (боковое)'),
			'text' => CHtml::encode('Текст'),
            'clinic_card' => CHtml::encode('Визитка клиники'),
            'title' => CHtml::encode('Title'),
			'keywords' => CHtml::encode('Keywords'),
			'description' => CHtml::encode('Description'),
			'parent_id' => CHtml::encode('Статья-родитель'), //ссылка на статью, в которую вложена данная
			'level' => CHtml::encode('Уровень статьи'), //уровень в иерархической структуре статей 0 - раздел медицины.
			'trigger_value_id' => CHtml::encode('Значение триггеров для поиска подходящих клиник')
		);
	}
	public function getParentList() {
		if (!isset($this -> ParentList)) {
			$this -> ParentList = $this -> GiveParentList($this);
		}
		return $this -> ParentList;
	}
    public function beforeSave() {
		$post_arr = $_POST;
		$sc = $this -> getScenario();
		if (($sc == 'create')||($sc == 'update')) {
			//triggers
			if (!empty($post_arr['triggers_array'])) {
				$triggers = implode(';', $post_arr['triggers_array']);
				$this -> triggers = $triggers;//substr($triggers, 0, strrpos($triggers, ';'));
			} else {
				$this -> triggers = '';
			}
		}
		if ($sc != 'createDescendant') {
			$criteria = new CDbCriteria;

			// prevent app from saving an article with existing URL
			if (!$this->isNewRecord) {
				$criteria->condition = 'id <> :id';
				$criteria->params = array(':id' => $this->id);
			}

			// check for duplicates by URL
			$dups = self::model()->findByAttributes(array('verbiage' => $this->verbiage), $criteria);

			if ($dups) {
				if ($dups -> id != $this -> id) {
					Yii::app()->user->setFlash('duplicateArticle' . $this->verbiage, CHtml::encode('Статья с URL ' . $this->verbiage . ' уже существует'));
					return false;
				}
			}
		}
        return parent::beforeSave();
    }
    
    public function giveTemporaryCriteria(){
		$criteria = new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('verbiage',$this->verbiage,true);
		//$criteria->compare('parent_id',$this->parent_id, true);
		$criteria->compare('text',$this->text,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('clinic_card',$this->clinic_card,true);
        $criteria->compare('keywords',$this->keywords,true);
        $criteria->compare('description',$this->description,true);
		return $criteria;
	}
	// this is standard function for searching
	public function search()
	{
		$criteria = $this -> giveTemporaryCriteria();
		$criteria -> compare('level',0);
		
		
		//$criteria=new CDbCriteria;
		
		
		$roots = self::model() -> findAll($criteria);
		$articles = array();
		
		$criteria = $this -> giveTemporaryCriteria();
		
		foreach($roots as $root){
			$articles = array_merge($articles, $root -> giveTree($criteria) );
		}
		//print_r($articles);
		/*$criteria=new CDbCriteria;
		
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('verbiage',$this->verbiage,true);
		$criteria->compare('parent_id',$this->parent_id, true);
		$criteria->compare('text',$this->text,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('clinic_card',$this->clinic_card,true);
        $criteria->compare('keywords',$this->keywords,true);
        $criteria->compare('description',$this->description,true);*/
		
		/*return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
		$prov = new CArrayDataProvider($articles);
		$prov -> setPagination(array(
			'pageSize' => 100,
		));
		$pag = $prov -> getPagination();
		$prov -> getData();
		if (!isset($_GET["page"])) {
			$pag -> setCurrentPage($pag -> getPageCount() - 1);
			//$_GET["page"] = $pag -> getPageCount() - 1;
		}
		return $prov;
	}

	/**
	 * @param CDbCriteria $criteria
	 * @return array - an array of Article Objects that are children to the specified one
	 */
	public function giveChildren(CDbCriteria $criteria = NULL){
		if (!$criteria) {
			$criteria = new CDbCriteria;
		}
		if ((!isset($this -> children))||(empty($this -> children))) {
			//$criteria = new CDbCriteria;
			$criteria -> compare('parent_id',$this -> id);
			$this -> children = self::model() -> findAll($criteria);
		}
		return $this -> children;
	}

	/**
	 * @param CDbCriteria $criteria
	 * @return array - all articles that lie lower than this one and are related to it
	 */
	public function giveTree(CDbCriteria $criteria){
		$rez = array($this);
		$children = $this -> giveChildren(clone $criteria);
		foreach( $children as $child) {
			$rez = array_merge($rez,$child -> giveTree(clone $criteria));
		}
		return $rez;
	}
	/*
	gives a list of all child articles
	*/
	/**
	 * @param string $id
	 * @param bool|false $count
	 * @return array
     */
	public function GiveArticlesById($id = '0', $count = false) {
		$command = Yii::app() -> db -> createCommand();
		
		$command -> select = 'id, verbiage, name';
		$command -> from = '{{articles}}';
		$command -> where = 'parent_id=:pid';
		$command -> order = 'name ASC';
		$command -> bindValue(':pid', $id, PDO::PARAM_STR);
		
		$reader = $command -> query();
		if ($count) 
		{
			$countCommand = Yii::app() -> db -> createCommand("SELECT COUNT(*) FROM `tbl_articles` WHERE `parent_id`=:pid");
		}
		$articles = array();
		foreach($reader as $value)
		{
			$article = $value;
			if ($count)
			{
				$countCommand -> bindValue(':pid', $value['id'], PDO::PARAM_STR);
				//$countCommand = Yii::app() -> db -> createCommand("SELECT COUNT(*) FROM `tbl_articles` WHERE `parent_id`='".$value['id']."'");
				$article['c'] = $countCommand -> queryScalar();
				//$rez = $countCommand -> execute();
				
			} else {
				$article['c'] = 0;
			}
			$article['name'] = ucfirst($article['name']);
			$articles[] = $article;
		}
		
		return $articles;
	}
	public function GenerateUrl()
	{
		$url = Yii::app() -> baseUrl;
		foreach ($this -> getParentList() as $parent)
		{
			$url .= '/'.$parent['verbiage'];
		}
		return $this -> verbiage;
		//return $url.'/'.$this -> verbiage;
	}
	//generates JSON object with article ids of given level
	public function GenerateParentList($level)
	{
		if ($level==-1)
		{
			return CJSON::encode(array(  
				'no'=>true,
			)); 
		} else {
			$criteria = new CDbCriteria;
			
			$criteria -> select = 'id, name';
			$criteria -> condition = 'level=:lev';
			$criteria -> order = 'name DESC';
			$criteria -> params = array(':lev' => $level);
			$parentList = CHtml::listData(Article::model()->findAll($criteria),'id','name');
			//$parentList = Article::model()->findAll($criteria);
			$ret = '';
			foreach ($parentList as $id => $name)
			{
				$ret .= CHtml::tag('option', array('value' => $id), CHtml::encode($name));
			}
			return CJSON::encode(array('parentList' => $ret));
		}
	}
	//function that generates an array of possible levels of an article
	public function getLevelArray()
	{
		$command = ClinicsModule::getLastInstance()->getDbConnection()->createCommand('SELECT MAX(`level`) FROM '.$this -> tableName());
		$max_level = $command -> queryScalar();
		$levelArray[0] = 'Корневая статья';
		for ($i = 1; $i <= $max_level + 1; $i++)
		{
			$levelArray[$i] = $i;
		}
		return $levelArray;
	}
	public function giveChild($verb){
		$criteria = new CDbCriteria;
		$criteria -> compare('parent_id' , $this -> id);
		$criteria -> compare('verbiage' , $verb);
		return self::model() -> find($criteria);
	}
	//Give article information
	public function giveArticleContent($verbiage_array)
	{
		$rez = array();
		if (is_array($verbiage_array)) {
			//print_r($verbiage_array);
			$art = false;
			foreach(array_filter(array_map('trim',$verbiage_array)) as $verb) {
				if ($art) {
					$art = $art -> giveChild($verb);
				} else {
					$art = self::model() -> findByAttributes(array('verbiage' => $verb));
				}
			}
			//$rez['article'] = self::model() -> findByAttributes(array('verbiage' => $verbiage));
			$rez['article'] = $art;
			$rez['children'] = self::model() -> GiveArticlesById($rez['article']['id'], false);
			//$rez['parents'] = self::model() -> GiveParentList($rez['article'], $rez['article']['id']);
		} else {
			echo "incorrect verbiage";
		}
		return $rez;
	}
    // this is standard function for getting a model of the current class
	/**
	 * @return static
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	//Give parent list
	public function GiveParentList($article = false, $id = -1)
	{
		$parents = array();
		if (!$article){
			$article = self::model() -> findByPk($id);
		}
		if (!$article){
			return array();
		}
		$par_id = $article['parent_id'];
		for ($i = $article['level'] - 1; $i >= 0; $i--)
		{
			$cur = self::model() -> findByPk($par_id);
			$parents[$i] = array('verbiage' => $cur['verbiage'], 'name' => $cur['name']);
			$par_id = $cur['parent_id'];
		}
		$parents[-1] = array('name' => 'Библиотека', 'vebiage' => '');
		return $parents;
	}
	public function giveModifyedText(){
		//$string = "какая-то там диагностика чего-то там";
		$string = $this -> text;
		$url = Yii::app() -> baseUrl.'/clinics/';
		//$text = 'Контакты диагностических медицинских центров, где Вы можете пройти <span style="font-weight:bold">МРТ, КТ, УЗИ</span> или другие виды диагностики представлены в разделе <a style="color:rgb(0,138,196)" href="'.Yii::app() -> baseUrl.'/">ДИАГНОСТИКА…</a>
		$text = 'Подобрать оптимальный диагностический МРТ и/или КТ центр по параметрам, Вы можете в нашем <a href="'.$url.'">каталоге клиник...</a>';

		$rez1 = preg_replace("!(диагностика?)!iu","<a href=".$url.">\\1</a> <div style='display:inline;font-size:10px;'>(".$text.")</div> ",$string);
		
		
		
		//Достали все картинки в matches[0]
		preg_match_all('/(<img [^<>]*>)/',$rez1,$matches, PREG_PATTERN_ORDER);
		
		$repl = array_merge(array($this -> title),array_filter(array_map('trim',explode(',',$this -> keywords))));
		foreach($matches[0] as $img) {
			$was[] = $img;
			if(!($to_repl = current($repl))){
				reset($repl);
				$to_repl = current($repl);
			}
			//$will[] = preg_replace('/^<img((?!alt=)[^<>]*)(alt=[^<>]*)?((?!alt=)[^<>]*)>$/','<img\\1alt="'.$repl.'"\\3/>',$img);
			//$temp = preg_replace('/^<img((?!alt=)[^<>]*)(alt=[^<>]*)?((?!alt=)[^<>]*)>$/','\\1\\2\\3\\4<img\\1alt="'.$repl.'"\\3/>',$img);
			$temp = preg_replace('/(alt=(\'|\")[^<>]*\\2)/','',$img);
			$will[] = str_replace('/>','alt="'.$to_repl.'"/>',$temp);
			next($repl);
		}
		//print_r($was);
		//echo "<br/>";
		//print_r($will);
		$rez2 = str_replace($was, $will,$rez1);
		$url = '#';
		$text = 'Подобрать оптимального врача по параметрам, Вы можете в нашем <a href ="'.$url.'">каталоге врачей...</a>';
		$rez = preg_replace("!(Специализация врачей)!iu","<a href=".$url.">\\1</a> <div style='display:inline;font-size:10px;'>(".$text.")</div> ",$rez2);
		
		
		/*if (!preg_match('/\<img((?!alt=).)*alt="(.+)"((?!alt=).)*\>/',$temp,$matches)) {
			$temp2 = preg_replace('/<img(.*)src="([^"]*)"((?!alt).)(alt="")?(.*)\/\>/', '<img \\1 src="\\2" \\3 alt="\\2" \\5 />', $temp);
		}*/
		return $rez;
	}

	/**
	 * @param string $arg
	 * @return static
	 */
	public function customFind($arg = null){
		switch($this -> getScenario()){
			case 'preview':
				$this -> attributes = $_POST['Article'];
				return $this;
				break;
			case 'view':
				return $this -> findByAttributes(['verbiage' => $_GET['verbiage']]);
				break;
			case 'createDescendant':
				return $this -> findByPk($_GET['id']);
				break;
			case 'copyDescendants':
				return $this -> findByPk($_POST["articleId"]);
				break;
			case 'search':
				$this -> attributes = $_GET[get_class($this)];
				return $this;
				break;
			default:
				if (!$arg) {
					return $this;
				} else {
					return $this -> findByPk($arg);
				}
				break;
		}
	}
	public static function prepareTriggers($triggers) {
		return array_map(function($verb){
			return ['verbiage' => $verb, 'id' => TriggerValues::model() -> findByAttributes(['verbiage' => $verb]) -> id];
		},$triggers);
	}
	/**
	 * @param array $triggers consists of pairs ['trigger_verbiage' => 'trigger_value_verbiage']
	 * @param string $text
	 * @return mixed
	 */
	public function prepareTextByVerbiage($triggers = [], $text = '') {
		$triggers = self::prepareTriggers($triggers);
		return $this -> prepareText($triggers, $text);
	}

	public static function renderParameter ($triggers, $trigger_verb, $field){

		//Нашли id выбранного пользователем значения параметра
		$val_id = $triggers[$trigger_verb];

		if ($trigger_verb == 'metro') {
			if ($field != 'value') {
				return '';
			}
			if (!$val_id['verbiage']) {
				return '';
			}
			$m = Metro::model() -> findByPk($val_id['verbiage']);
			if (!$m) {return '';}
			return $m -> name;
		}
		//Чтобы меньше дергать базу, кэшируем
		static $prices;
		if (!isset($prices)) {
			foreach (ObjectPrice::model() -> findAll() as $price) {
				$prices[$price -> verbiage] = $price;
			}
		}
		//Если нужно рендерить параметр конкретного исследования,
		// то названием триггера будет исследование.
		if ($price = $prices[$trigger_verb]) {
			if ($field == 'min') {
				$min = false;
				$priceMin = false;
				foreach ($price -> values as $value) {
					if (($value -> value < $min)||(!$priceMin)) {
						$priceMin = $price;
						$min = $value -> value;
					}
				}
				return $min;
			}
			return '';
		}

		//Если речь об исследовании, то особый алгоритм
		if ($trigger_verb == self::PRICE_VERBIAGE) {
			//Ищем цену
			if (!$val_id['verbiage']) {
				return '';
			}
			$price = $prices[$val_id['verbiage']];
			if (!$price) {
				return '';
			}
			//Рендерим значение
			if ($field == 'value') {
				return $price->name;
			} elseif ($field == 'count') {
				$num = count(Yii::app() -> getModule('clinics') -> getClinics(['research' => $price -> verbiage,'city' => $triggers['city']['verbiage']]));
				if (($num % 10 == 1)&&($num != 11)) {
					return $num.' клиники';
				} else {
					return $num.' клиник';
				}
			} elseif ($field == 'nameVin') {
				if ($price -> nameVin) {
					return $price -> nameVin;
				}
				return $price -> name;
			} elseif ($field == 'nameRod') {
				if ($price -> nameRod) {
					return $price -> nameRod;
				}
				return $price -> name;
			}
		}

		//Если поле тупо value, то нужно отобразить само значение параметра
		if ($field == 'value') {
			$val = TriggerValues::model() -> findByPk($val_id['id']);
			if ($val instanceof TriggerValues) {
				return $val -> value;
			} else {
				return '';
				//throw new TextException("Could not find trigger value by id {$val_id['id']}");
			}
		}

		/**
		 * @type TriggerParameter $param
		 */
		//Дошли до параметра. Ищем в базе параметр по verbiage, взятом из field
		$param = TriggerParameter::model() -> findByAttributes(['verbiage' => $field]);
		if (!$param) {
			return '';
			//throw new TextException('Could not find TriggerParameter by verbiage "'.$field.'"');
		}
		$param_val = null;
		if ($val_id['id']) {
			$param_val = TriggerParameterValue::model() -> findByAttributes(['id_trigger_parameter' => $param -> id, 'id_trigger_value' => $val_id['id']]);
		}
		if ($param_val instanceof TriggerParameterValue) {
			return $param_val -> value;
		}
		return $param -> defaultValue;
	}
	/**
	 * @param array $triggers consists of pairs ['verbiage' => [verbiage => verbiage, id => id]]
	 * @param string $text
	 * @return mixed
	 */
	public function prepareText($triggers = [], $text = '') {
		if (!$text) {
			$text = $this->text;
		}
		$verb = '([a-zA-Z0-9\-_]+)';
		$opening = '(\&lt;|\<)';
		$closing = '(\&gt;|\>)';
		$singleParameter = $opening.$verb.':'.$verb.$closing;


		//if <district:value> :text-text endif;
		$text = preg_replace_callback("/if\s*$opening$verb(\=|:)$verb$closing:((.|\s)*)endif;/ui",function($matches) use ($triggers){
			//Получили название триггера и поле, которое отображать
			$trigger_verb = $matches[2];
			var_dump($matches);
			if ($matches[3] == ':') {
				$field = $matches[4];
				try {
					$param = Article::renderParameter($triggers, $trigger_verb, $field);
				} catch (TextException $e) {
					$param = '';
				}
				if (!$param) {
					return '';
				}
			} elseif ($matches[3] == '=') {
				$valVerb = $matches[4];
				if (!empty($triggers[$trigger_verb])) {
					$val = $triggers[$trigger_verb]['verbiage'];
				}
				if ($valVerb != $val) {
					return '';
				}
			} else {
				return '';
			}
			return $matches[6];

		},$text);

//		$text = preg_replace_callback('/if:\s*'.$singleParameter.'((.|\s)*)endif;/uim',function($matches) use ($renderParameter){
//			//Получили название триггера и поле, которое отображать
//			$trigger_verb = $matches[2];
//			$field = $matches[3];
//			try {
//				$param = $renderParameter($trigger_verb, $field);
//			} catch (TextException $e) {
//				$param = '';
//			}
//			if (!$param) {
//				return '';
//			}
//			return $matches[5];
//		},$text);

		return preg_replace_callback('/'.$singleParameter.'/ui',function($matches) use ($triggers){
			//var_dump($matches);
			return Article::renderParameter($triggers, $matches[2], $matches[3]);
		},$text);
	}

	/**
	 * @return array
	 */
	public function dumpForProject(){
		$arr = array('id' => $this -> id, 'name' => $this -> name, 'extra' => [
			'hasChildren' => (Article::model() -> countByAttributes(['parent_id' => $this -> id]) > 0),
		]);
		return $arr;
	}

	/**
	 * @return Article
	 */
	public function cloneToChild(){
		$article = new Article();
		$article -> attributes = $this -> attributes;
		$article -> name = $_POST["name"];
		$article -> parent_id = $this -> id;
		$article -> level = (int)$this -> level + 1;
		$article -> id = null;
		$article -> verbiage = null;
		return $article;
	}
	public function createDescendantFast() {
		$article = $this -> cloneToChild();
		$article -> setScenario('createDescendant');
		if (!$article -> save()) {
			$rez['success'] = false;
			$err = $article -> getErrors();
		} else {
			$rez['success'] = true;
			$rez['id'] = $article -> id;
		}
		$rez["dump"] = $article -> dumpForProject();
		echo json_encode($rez);
		return $article;
	}
	public function copyDescendants(){
		$mod = Yii::app() -> getModule('taskgen');
		/**
		 * @type TaskGenModule $mod
		 * @type Task $t
		 */
		$t = Task::model() -> findByPk($_GET["id"]);
		$this -> copyChildrenFromTaskgen($t);
	}

	/**
	 * @param Task $t
	 */
	public function copyChildrenFromTaskgen(Task $t){
		/**
		 * @type Task $t
		 */
		foreach($t -> children as $task){
			$temp = $task -> dumpText();
			$article = $this -> cloneToChild();
			$article -> text = $temp['text'];
			$article -> description = $temp['description'];
			$article -> name = $task -> name;
			$article -> verbiage = str2url($task -> name);
			$article -> id_taskgen = $task -> id;
			if ($article -> save()) {
				$article->copyChildrenFromTaskgen($task);
			}
		}

	}
	public function readData($data) {
		if (!$this -> parent_id) {
			$this -> parent_id = 0;
		}
	}
	public function afterSave() {
		if (in_array($this -> getScenario(), ['update', 'create'])) {
			$data = $this -> research_input;
			$hasObjects = [];
			$has = [];
			foreach ($this -> researches as $research) {
				$hasObjects[$research -> verbiage_research] = $research;
				$has[] = $research -> verbiage_research;
			}
			$toAdd = array_diff($data, $has);
			$toDel = array_diff($has, $data);
			foreach ($toAdd as $verb) {
				$a = new ArticleResearch();
				$a -> id_article = $this -> id;
				$a -> verbiage_research = $verb;
				$a -> save();
			}
			foreach ($toDel as $verb) {
				$hasObjects[$verb] -> delete();
			}
		}
	}
	/**
	 * @param mixed[] $search a search array that specifies what is being searched
	 * @return boolean true if this object satisfies searching criteria and false if not
	 * (unlike search function this one should be overridden in every descendant and
	 * contains options that are specific)
	 */
	public function SFilter($search) {
		unset($search['mrt']);
		unset($search['kt']);
		unset($search['metro']);
		if ($res = $search['research']) {
			if (!ArticleResearch::model() -> findByAttributes(['id_article' => $this -> id,'verbiage_research' => $res])) {
				return false;
			}
			unset($search['research']);
		}
		return parent::SFilter($search);
	}
	public function getReadyToDisplay() {
		return;
	}
}
