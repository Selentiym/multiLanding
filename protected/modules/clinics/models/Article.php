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
 */
 
class Article extends UClinicsModuleModel {
	/**
	 * @property array children - an array of Article objects that are children to this one.
	 */
	public $children;
	protected $ParentList;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lib_articles}}';
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
			array('id, name, verbiage, parent_id, level, text, clinic_card, title, keywords, description, show_objects', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'parent' => array(self::BELONGS_TO, 'Article', 'parent_id'),
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
        $sc = $this -> getScenario();
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
				Yii::app()->user->setFlash('duplicateArticle', CHtml::encode('Статья с таким URL уже существует'));
				return false;
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
			case 'createDescendant':
				return $this -> findByPk($_GET['id']);
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

	/**
	 * @param array $triggers consists of pairs ['verbiage' => id_value]
	 * @return mixed
	 */
	public function prepareText($triggers = []) {
		$text = $this -> text;
		$verb = '([a-zA-Z]+)';
		return preg_replace_callback('/(\&lt;|\<)'.$verb.':'.$verb.'(\&gt;|\>)/ui',function($matches) use ($triggers) {
			var_dump($matches);
			$trigger_verb = $matches[2];
			$field = $matches[3];
			/**
			 * @type TriggerParameter $param
			 */
			$param = TriggerParameter::model() -> findByAttributes(['verbiage' => $field]);
			if (!$param) {
				throw new TextException('Could not find TriggerParameter by verbiage "'.$field.'"');
			}
			$param_val = null;
			if ($val_id = $triggers[$trigger_verb]) {
				$param_val = TriggerParameterValue::model() -> findByAttributes(['id_trigger_parameter' => $param -> id, 'id_trigger_value' => $val_id]);
			}
			if ($param_val instanceof TriggerParameterValue) {
				return $param_val -> value;
			}
			return $param -> defaultValue;
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
	public function createDescendantFast() {
		$article = new Article();
		$article -> setScenario('createDescendant');
		$article -> attributes = $this -> attributes;
		$article -> name = $_POST["name"];
		$article -> parent_id = $this -> id;
		$article -> level = (int)$this -> level + 1;
		$article -> id = null;
		$article -> verbiage = null;
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
}
