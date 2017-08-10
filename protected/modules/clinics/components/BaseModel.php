<?php

/**
 * Class BaseModel
 * @property string $external_link
 * @property string $name
 * @property ObjectPriceValue[] $priceValues
 *
 * @property ObjectPriceValue[] $prices
 * @property ObjectPriceValue[] $allPrices
 *
 * It is a ancestor of all models that should be searched by triggers
 */
abstract class BaseModel extends CTModel {
	/**
	 * @var TriggerValues
	 */
	private $allTriggerValues;
	/**
	 * @param integer PAGE_SIZE - number of objects on a single page
	 */
	const PAGE_SIZE = 18;
	/**
	 * @var array SFields specific fields. Those will not be taken into account in the default search function.
	 */
	public $SFields = array('metro','research','submitted','price','street','sortBy');//,'speciality');
	/**
	 * @var integer type. Stores id of the object's type.
	 */
	public $type = 1;

	/**
	 * @var ObjectPriceValue[]
	 */
	protected $_priceValues;
	/** лишняя функция.
	 * @param array search a search array that specifies what is being searched
	 * @param array objects an array of object which are to be filtered according to search options
	 * @return array of model object that fit the search options
	 * (unlike search function this one is overriden in every doughter class and contains options that are specific)
	 */
	public function init()
	{
		parent::init();
		$num = Objects::model() -> getNumber(get_class($this));
		if ($num) {
			$this -> type = $num;
		}
	}
	public function relations() {
		$blocks = Yii::app() -> params['priceBlocks'];
		$specSiteAddition = '';
		if (!empty($blocks)) {
			$specSiteAddition = ' and priceForList.id_block IN ('.implode(',',$blocks).')';
		}
		return [
			'prices' => [self::HAS_MANY, 'ObjectPriceValue', 'id_object', 'with' => ['price' => ['alias' => 'priceForList']], 'condition' => 'priceForList.object_type = ' . Objects::getNumber(get_class($this)).$specSiteAddition],
			'allPrices' => [self::HAS_MANY, 'ObjectPriceValue', 'id_object', 'with' => ['price' => ['alias' => 'priceForList']], 'condition' => 'priceForList.object_type = ' . Objects::getNumber(get_class($this))],
			'priceLink' => [self::HAS_ONE, 'ObjectPriceValue','id_object','with' => ['price' => ['together' => true]], 'condition' => 'price.object_type = ' . Objects::getNumber(get_class($this)).' AND pr.id_price=:pid'],
			'toCountPrices' => [self::HAS_MANY, 'ObjectPriceValue','id_object','condition' => 'toCountPrices.id_price IN (:pids)'],
			'news' => [self::HAS_MANY, 'News', 'id_object', 'condition' => 'object_type = ' . Objects::getNumber(get_class($this)), 'order' => 'published DESC'],
			'triggerValues' => [self::MANY_MANY, 'TriggerValues', '{{'.$this -> getNormalizedClassName() .'_trigger_assignments}}(id_object,id_trigger_value)'],
			'triggerLinks' => [self::HAS_MANY, $this->getNormalizedClassName().'TriggerAssignment','id_object'],
		];
	}
	private static function addSeparatedFieldCondition($field,CDbCriteria $criteria, $id){
		$criteria -> addCondition("$field LIKE '%;$id;%' OR $field LIKE '%;$id' OR $field LIKE '$id;%' OR $field = '$id'");
		return $criteria;
	}
	public function setAliasedCondition($search, CDbCriteria $criteria = null, $alias = ''){
		$search = array_filter($search);
		$join = '';
		$i = 0;
		$className = $this -> getNormalizedClassName();
		$conds = [];
		foreach ($search as $key => $option) {
			++$i;
			//если поле не относится к особым, тогда сохраняем условие на него.
			if (!in_array($key, $this -> SFields)) {
				if (trim($option) != "") {
					$name = "`trig$i`";
					$join .= " LEFT JOIN `{{{$className}_trigger_assignments}}` $name  ON `t`.`id` = $name.`id_object` AND $name.`id_trigger_value` = $option";
					$conds[] = "$name.`id` is not null";
					//$criteria -> addCondition('triggerLinks.id_trigger_value = '.$option);
				}
			}
		}
		$criteria -> join = $criteria -> join . $join;
		if (!empty($conds)) {
			$criteria -> addCondition(implode(' AND ', $conds));
		}
		if ($search['metro']) {
			foreach ($search['metro'] as $m) {
				$criteria = self::addSeparatedFieldCondition($alias.'metro_station',$criteria, trim($m));
			}
		}
	}
	/**
	 * @param array $search a search array that specifies what is being searched
	 * @param string $order - a field to be ordered by
	 * @param integer $limit - a limit of objects to be found
	 * @param CDbCriteria $initialCrit
	 * @param bool $strictResearch
	 * @return array the resulting clinics
	 */
	public function UserSearch($search,$order='rating',$limit=-1, CDbCriteria $initialCrit = null, $strictResearch = false) {
		$criteria = $this -> prepareForUserSearch($search,$order,$limit, $initialCrit);
		$objects_filtered = $this -> model() -> findAll($criteria);
		//Поиск с другим исследованием
		if (($search['research'])&&(count($objects_filtered)==0)&&(!$strictResearch)) {
			//Далее будет использована для поиска по другому исследованию
			$price = ObjectPrice::model() -> findByAttributes(['verbiage' => $search['research']]);
//			$search['research'] = ;
			/**
			 * @type ObjectPrice $price
			 */
			if ($price -> id_replace_price) {
				//$search['research'] = $price->replacement;
				//$saveCrit = $this->SFilter($search, $saveCrit, $order);
				$params = $criteria -> params;
				if ($params[':pid']) {
					$params[':pid'] = $price -> id_replace_price;
				}
				$criteria -> params = $params;
				$objects_filtered = $this->model()->findAll($criteria);
			}
		}
		$rez['objects'] = $objects_filtered;
		return $rez;
		//
	}
	/**
	 * @param array $search a search array that specifies what is being searched
	 * @param string $order - a field to be ordered by
	 * @param integer $limit - a limit of objects to be found
	 * @param CDbCriteria $initialCrit
	 * @param bool $strictResearch
	 * @return int number of clinics that apply to the condition
	 */
	public function UserCount($search,$order='rating',$limit=-1, CDbCriteria $initialCrit = null, $strictResearch = false) {
		$criteria = $this -> prepareForUserSearch($search,$order,$limit, $initialCrit);
		$num = $this -> model() -> count($criteria);
		//Поиск с другим исследованием
		if (($search['research'])&&($num==0)&&(!$strictResearch)) {
			//Далее будет использована для поиска по другому исследованию
			$price = ObjectPrice::model() -> findByAttributes(['verbiage' => $search['research']]);
//			$search['research'] = ;
			/**
			 * @type ObjectPrice $price
			 */
			if ($price -> id_replace_price) {
				//$search['research'] = $price->replacement;
				//$saveCrit = $this->SFilter($search, $saveCrit, $order);
				$params = $criteria -> params;
				if ($params[':pid']) {
					$params[':pid'] = $price -> id_replace_price;
				}
				$criteria -> params = $params;
				$num = $this->model()->count($criteria);
			}
		}
		return $num;
	}
	/**
	 * @param array $search a search array that specifies what is being searched
	 * @param string $order - a field to be ordered by
	 * @param integer $limit - a limit of objects to be found
	 * @param CDbCriteria $initialCrit
	 * @return CDbCriteria to search clinics that fit the $search
	 */
	 private function prepareForUserSearch(&$search,$order='rating',$limit=-1, CDbCriteria $initialCrit = null) {
		//Если поле сортировки не задано, сортируем по рейтингу
		if ((!$order)&&($order !== false)) {
			$order='rating';
		}
		if (is_a($initialCrit, 'CDbCriteria')) {
			$criteria = $initialCrit;
		} else {
			$criteria = new CDbCriteria();
		}

		//По цене будет отдельная сортировка
		if (!in_array($order, array('priceUp','priceDown'))&&($order)) {
			if ($criteria -> order) {
				$criteria -> order .= ", $order DESC";
			} else {
				$criteria->order = $order . ' DESC';
			}
		}
		self::setAliasedCondition($search, $criteria,'');

		$criteria = $this -> SFilter($search, $criteria, $order);
 		return $criteria;
	}

	/** лишняя функция.
	 * @param array $search a search array that specifies what is being searched
	 * @param array $objects an array of object which are to be filtered according to search options
	 * @return array - an array of model object that fit the search options
	 * (unlike search function this one is overriden in every doughter class and contains options that are specific)
	 */
	/*public function customSearch($search, $objects)
	{
		//Чтобы не было проблем при ненаследовнии.
		return $objects;
	}*/
	/**
	 * @param mixed[] $search a search array that specifies what is being searched
	 * @param CDbCriteria $criteria
	 * @param string $order
	 * @return CDbCriteria
	 */
	public function SFilter($search, $criteria, $order = '')
	{
		//фильтруем по станциям метро и районам. В родителе, потому что у всех есть эти поля.
		/*if ($search['metro'] != 0) {
			$ok &= (!($search['metro']))||((in_array($search['metro'], array_map('trim', explode(';', $this->metro_station)))));
		}*/
		if (!$search['research'] instanceof ObjectPrice) {
			$price = ObjectPrice::model() -> findByAttributes(['verbiage' => $search['research']]);
		} else {
			$price = $search['research'];
		}
		if ($price) {
			if (empty($criteria -> with)) {
				$criteria -> with = ['priceLink'=>['alias' => 'pr','select' => false]];
			} else {
				$criteria -> with = array_merge($criteria -> with,['priceLink'=>['alias' => 'pr','select' => false]]);
			}
			$criteria -> together = true;
			if (empty($criteria -> params)) {
				$criteria -> params = [];
			}
			$criteria->params = array_merge($criteria -> params, [':pid' => $price->id]);
			$criteria -> addCondition('pr.value IS NOT NULL');
			//$criteria -> order = 'pr.value desc';
		}
		return $criteria;
		//TODO implement mrt or kt search via triggers
	}
	/**
	 * Tansforms data into correct encoding and writes it to a file.
	 */
	public function my_fputcsv($file, $array, $separator) {
		foreach ($array as $key => $string) {
			$array[$key] = mb_convert_encoding($string, $this -> exportFileEncoding, $this -> codeFileEncoding);
		}
		fputcsv($file, $array, $separator);
	}
	public function my_fgetcsv($file, $number, $separator) {
		$array = fgetcsv($file, $number, $separator);
		if (is_array($array))
		{
			foreach ($array as $key => $string) {
				$array[$key] = mb_convert_encoding($string, $this -> codeFileEncoding, $this -> exportFileEncoding);
			}
			return $array;
		} else {
			return false;
		}
	}
	/**
	 * @param array fields - default fields (default - present in the database) that are to be exported
	 * @return exported csv file
	 */
	public function ExportCsv($fields,$prices)
	{
		header('Content-type: text/csv; charset=windows-1251');
		$filename = "php://output";
		//echo $filename;
		header('Content-Disposition: attachment; filename="'.get_class($this).'-export-' . date('YmdHi') .'.csv"');//*/
		$objects = $this->findAll();
		//Базовые поля.
		//$fields = $this -> fields;
		
		//Поля, добавленные через админку.
		$criteria = new CDbCriteria;
		$criteria -> compare('object_type', Objects::model() -> getNumber(get_class($this)));
		$customFields = CHtml::listData(Fields::model()->findAll($criteria), 'id','title');
		//Названия всех экспортируемых полей.
		if ((is_array($customFields))&&(is_array($fields))&&(is_array($prices))) {
			$names = array_merge(array_values($fields), array_values($customFields), array_values($prices));
		} elseif((is_array($customFields))&&(is_array($fields))) {
			$names = array_merge(array_values($fields), array_values($customFields));
		} elseif(is_array($fields)) {
			$names = array_values($fields);
		} else {
			$names = Array();
		}
		if ($file = fopen($filename, 'w'))
		{
			$this -> my_fputcsv($file, $names,";");
			foreach($objects as $object)
			{
				/**
				 * @type BaseModel $object
				 */
				$current_object_array = Array();
				foreach($fields as $key => $v)
				{
					switch($key)
					{
						case 'district':
							$distr_arr = $object -> giveDistrNames();
							$current_object_array[] = implode(",", $distr_arr);
						break;
						case 'triggers':
							$trigger_arr = CHtml::listData($object -> giveTriggerValuesObjects(),'id','value');
							$current_object_array[] = implode(",", $trigger_arr);
						break;
						case 'metro_station':
							$metro_arr = $object -> giveSubwayNames();
							$current_object_array[] = implode(",", $metro_arr);
						break;
						default:
						//echo $key."<br/>";
						$current_object_array[] = $object -> $key;
					}
				}


				foreach($customFields as $key => $v)
				{
					$criteria = new CDbCriteria();					
					$criteria -> compare('object_id', $object -> id);
					$criteria -> compare('field_id', $key);
					$field = FieldsValue::model() -> find($criteria);
					if (($field)&&($field -> value)) 
					{
						$current_object_array[] = $field -> value;
					} else {
						$current_object_array[] = '';
					}
				}
				//Экспорт всех запрошенных цен клиники.
				$has = CHtml::listData($object -> prices,'name','price');
				//print_r($has);
				foreach($prices as $priceName) {
					//echo $has[$priceName].'<br/>';
					$current_object_array[] = $has[$priceName];
				}
				$this -> my_fputcsv($file, $current_object_array, ";");
				//break;//удалить!
			}
			fclose($file);
			return true;
			//$this -> disableProfilers();
			
		} else {
			throw new Exception("Export File does not open.");
			return false;
		}
	}
	//import data function. $handle is a handle to a csv-encoded file to be analyzed
	public function ImportCsv($handle = false, $fields = Array (), $prices = array())
	{
		//echo "start";
		if ($handle)
		{
			$firstline = $this -> my_fgetcsv($handle, 2000, ';');
			//Получили массив <название в файле экспорта> => <поле в таблице>
			//$fields = array_flip($this -> fields);
			$fields = array_flip($fields);
			$keys = array_keys($fields);
			$prices = array_values($prices);
			//Получили список id-шников нестандартных полей, использованных в файле.
			$customFieldsIds = Array();
			foreach ($firstline as $key)
			{
				/*it was: if (!in_array($key, $keys))
				{
					
					$field = Fields::model() -> findByAttributes(array('title' => $key,'object_type' => Objects::model() -> getNumber(get_class($this))));
					//Сохраняем id-шник, если поняли, что это за поле.
					if ($field) 
					{
						$customFieldsIds[] = $field -> id;
					} else {
						$customFiledsIds[] = -1;
					}
				}*/
				
				if (!in_array($key, $keys))
				{
					//Если ключа нет в массиве стандартных полей, то ищем его сначала среди цен.
					if (in_array($key,$prices)) {
						$prices_keys [] = $key;
					} else {
						$field = Fields::model() -> findByAttributes(array('title' => $key,'object_type' => Objects::model() -> getNumber(get_class($this))));
						//Сохраняем id-шник, если поняли, что это за поле.
						if ($field) 
						{
							$customFieldsIds[] = $field -> id;
						} else {
							$customFiledsIds[] = -1;
						}
					}
				}
			}
			while(($line = $this -> my_fgetcsv($handle, 2000, ';')) !== false)
			{
				//Пробегаемся по всем стандартным ключам, расположенным в начале.
				//print_r($line);
				reset($line);
				reset($customFieldsIds);
				$customFields = Array();
				$toAddPrices = Array();
				foreach ($firstline as $key)
				{
					//Если поле стандартное, тогда добавляем его как атрибут модели клиника. $object_arr - массив будущих атрибутов модели клиника
					//echo "<br/>".($key);
					
					if (in_array(trim($key), $keys))
					{
						
						switch ($fields[($key)])
						{
							case 'district':
								$distr_ids = $this -> giveDistrictIdsByNameString(current($line));
								
								$object_arr['district'] = implode(';', $distr_ids);
							break;
							case 'triggers':
								$trigger_ids = $this -> giveTriggersByNameString(current($line));
								$object_arr['triggers'] = implode(';',$trigger_ids);
							break;
							case 'metro_station':
								$metro_ids = $this -> giveSubwayIdsByNameString(current($line));
								$object_arr['metro_station'] = implode(";", $metro_ids);
							break;
							default:
								$object_arr[$fields[($key)]] = current($line);
								//echo "<br/>".$fields[($key)];
								
						}
						if(next($line)===false)
						{
							break;
						}
					} else {//Если же поле не стандартное, то сохраняем его значение в массив, где ключ - id-шник поля.
						//Проверяем сначала не является ли поле ценой
						if (in_array(trim($key),$prices_keys)) {
							$toAddPrices[$key] = current($line);
						} else {
							$id = current($customFieldsIds);
							if ($id != -1)
							{
								$customFields[$id] = current($line);
							}
							next($customFieldsIds);
							
						}
						if(next($line)===false)
						{
							break;
						}
					}
				}
				//Заносим данные в базу.
				//Если не существует объекта с таким verbiage
				//print_r($object_arr);
				//print_r($firstline);
				//echo "123";
				//return;
				if (!$this -> findByAttributes(array('verbiage' => $object_arr['код'])))
				{
					$modelName = get_class($this);
					$object = new $modelName();
					$object -> attributes = $object_arr;
					if ($object_arr['logo']) {
						$object -> logo = $object_arr['logo'];
					}
					
					
					//Сохраняем объект
					if ($object -> save())
					{
						//echo $clinic -> id;
						$id = $object -> id;
						//Устанавливаем значения кастомных полей.
						foreach($customFields as $fid => $value)
						{
							$fields_assign = new FieldsValue();
							$fields_assign -> object_id = $id;
							$fields_assign -> field_id = $fid;
							$fields_assign -> value = $value;
							//stopped here
							if (strlen($value)>0)
							{
								if (!$fields_assign -> save())
								{
									//echo "not saved";
									new CustomFlash('warning', 'FieldsValue', 'NotSaved'.$fields_assign -> object_id.'_'.$fields_assign -> field_id, 'Поле '.$modelName == 'clinics'? 'клиники' : 'доктора'.' с номером '.$fields_assign -> object_id. ' и значением '.$fields_assign -> value. ' не добавлено.');
									//print_r($fields_assign -> getErrors());
								}
							}
						}
						//Добавляем цены.
						foreach($toAddPrices as $priceName => $priceValue){
							$price = new Pricelist;
							$price -> object_type = Objects::model() -> getNumber(get_class($this));
							$price -> object_id = $object -> id;
							$price -> name = $priceName;
							$price -> price = $priceValue;
							if (!$price -> save()) {
								echo $price -> name." ".$price -> object_id." not saved<br/>";
							}
						}
					} else {
						$errors[$object -> name] = $object -> getErrors();
					}
				} else {
					$exist[] = $object_arr['код'];
					//echo "exists";
				}
				//break;
			}
			//fclose($handle);
			if (!empty($exist))
			{
				Yii::app() -> user -> setFlash('clinicExists', 'Объекты с адресами:<br/>'.implode("<br/>",$exist)." - уже есть в базе данных.");
			}
			if (!empty($errors))
			{
				$string = CHtml::encode("При импорте возникли следующие ошибки:")."<br/>";
				foreach ($errors as $name => $errors)
				{
					$string .= CHtml::encode("Объект с названием ".$name.":")."<br/>";
					$content = "";
					foreach($errors as $field => $error)
					{
						$content .= CHtml::tag('li', array() ,"Поле: ".$field.", ошибка: ".implode(", ",$error));
					}
					$string .= CHtml::tag('ol',array(),$content);
				}//*/
				Yii::app() -> user -> setFlash('errorsWhileImporting',$string);
			}else {
				Yii::app()->user->setFlash('successfull'.$modelName.'Import', 'Список объектов успешно импортирован.');
			}
		}
		return true;
	}
	public function giveDistrictIdsByNameString($NameString)
	{
		$names = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("name", $names);
		return array_keys(CHtml::listData(Districts::model()->findAll($criteria), 'id','name'));//костыль. переписать

	}
	public function giveSubwayIdsByNameString($NameString)
	{
		$names = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("name", $names);
		return array_keys(CHtml::listData(Metro::model()->findAll($criteria), 'id','name'));//костыль. переписать
	}
	public function giveTriggersByNameString($NameString)
	{
		$trigger_values = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("value", $trigger_values);
		return array_keys(CHtml::listData(TriggerValues::model()->findAll($criteria), 'id','value'));//костыль. переписать
	}
	/*
	* Common function
	*/
	public function giveIdsByNameString($NameString, $model)
	{
		$names = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("name", $names);
		return array_keys(CHtml::listData($model -> findAll($criteria), 'id','name'));//костыль. переписать
	}
	/**
	 * Делает так, что массив объектов $objectClass, который привязан через таблицу
	 * стал равен массиву, айди которого находятся в $ids
	 *
	 * @param array $ids - an ids array of objects to be assigned to the this object
	 * @param string $objectClass - the name of the class of objects which correspond to the linking table record
	 * @param string $propertyName - the name of relational property that contains the array of objects
	 * @param string $PK - the name of the PrimaryKey property for this object
	 * @param string $PK_name - the name of the PrimaryKey in the linking table fo "big" objects
	 * @param string $PK_small - the name of the PrimaryKey property for objects to be saved
	 * @param string $PK_small_name - the name of the PrimaryKey in the linking table for "small" objects
	 */
	public function SavePropertyArrayChanges($ids, $objectClass, $propertyName, $PK, $PK_name, $PK_small, $PK_small_name) {
		//Получаем то, что было
		$start_ids = CHtml::giveAttributeArray($this -> $propertyName, $PK_small);
		$ids = empty($ids) ? [] : $ids;
		//находим то, чего нет в конечном массиве.
		$to_del = array_diff($start_ids, $ids);
		//находим то, что нужно добавить
		$to_add = array_diff($ids, $start_ids);
		//print_r($to_add);
		//удаляем ненужное.
		$criteria = new CDbCriteria();
		$criteria -> compare($PK_name, $this -> $PK);
		$criteria -> addInCondition($PK_small_name, $to_del);
		if (!empty($to_del)) {
			$objectClass::model() -> deleteAll($criteria);
		}
//		Yii::app() -> end();
		//Добавляем нужное
		foreach($to_add as $id) {
			$model = new $objectClass;
			$model -> $PK_name = $this -> $PK;
			$model -> $PK_small_name = $id;
			//var_dump($model);
			if (!$model -> save()) {
				print_r($model -> getErrors());
			}
			
		}
	}
	public function beforeSave(){
		if (parent::beforeSave()) {
			try {
				if (!$this -> map_coordinates) {
					$this -> parseCoords();
				}
			}
			catch (HttpException $e) {
				new CustomFlash('Warning','clinics','no coords','Координаты не найдены!',true);
			}
			catch (Exception $e) {}
			//Пытаемся найти ближайшее метро.
			try {
				//throw new Exception('no way to find nearest metro');
				if ($this -> map_coordinates) {
					if (!$this -> metro_station) {
						$this -> parseMetros();
					}
					if (!$this -> getFirstTriggerValueString('district')) {
						$this -> parseDistricts();
					}
				}
			} catch (Exception $e) {}
			$dups = $this -> findAllByAttributes(['verbiage' => $this -> verbiage]);
			$e = false;
			if (count($dups) > 2) {
				$e = true;
			}elseif (count($dups) == 1) {
				$e = current($dups) -> id != $this -> id;
			}
			if ($e) {
				$this->addError('verbiage', 'Атрибут "' . $this->getAttributeLabel('verbiage') . '" должен быть уникальным!');
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
	public function parseDistricts(){
		list($lat, $long) = $this -> getCoordinates();
		$name = giveDistrictByCoords($lat, $long);
		$distr = TriggerValues::model() -> findByAttributes(['value' => $name]);
		if ($distr instanceof TriggerValues) {
			$this -> addTriggerValue($distr -> id);
		}
	}
	public function parseCoords() {
		$coords = getCoordinates($this->getFullAddress());
		$this->map_coordinates = $coords['lat'] . ', ' . $coords['long'];
	}
	public function parseMetros() {
		list($lat, $long) = $this -> getCoordinates();
		$metros = giveMetroNamesArrayByCoords($lat, $long);
		$criteria = new CDbCriteria();
		$criteria->addInCondition('name', $metros);
		$criteria->compare('city',$this -> getFirstTriggerValue('area') -> verbiage);
		$met = Metro::model()->findAll($criteria);
		//var_dump(Html::listData($met,'id','id'));
		$this->metro_station = implode(';', Html::listData($met, 'id', 'id'));
	}
	public function afterSave($noPrices = false) {
		parent::afterSave();
		if (($this -> getScenario() != 'noPrices')&&(!$noPrices)) {
			ob_start();
			$this -> savePrices();
			ob_end_clean();
		}
		//triggers
		//not good that $_POST is hardcoded
		$this->SavePropertyArrayChanges($_POST['triggers_array'], static::model()->getNormalizedClassName() . 'TriggerAssignment', 'triggerValues', 'id', 'id_object', 'id', 'id_trigger_value');
	}
	public function preparePrices($prices){
		$mrt = array();
		$kt = array();
		$other = array();
		foreach($prices as $price){
			if (stripos($price -> name,'МРТ')!==false){
				$mrt[$price -> name] = $price -> price;
			} elseif (stripos($price -> name,'КТ')!==false){
				$kt[$price -> name] = $price  -> price;
			} else {
				$other[$price -> name] = $price -> price;
			}
		}
		asort($mrt);
		asort($kt);
		asort($other);
		return array_merge($mrt,$kt,$other);
	}
	/**
	 * @return array[TriggerValues[]]
	 */
	public function giveTriggerValuesObjects() {
		if (!isset($this -> allTriggerValues)) {
			foreach ( $this -> getRelated('triggerValues', false, ['with' => 'trigger']) as $obj) {
				/**
				 * @type TriggerValues $obj
				 */
				if (!$this -> allTriggerValues[$obj -> trigger -> verbiage]) {
					$this -> allTriggerValues[$obj -> trigger -> verbiage] = [];
				}
				$this -> allTriggerValues[$obj -> trigger -> verbiage][] = $obj;
			}
		}
		return $this -> allTriggerValues;
	}
	public function giveTriggerValuesUnstructured(){
		$rez = [];
		if (!empty($structured = $this -> giveTriggerValuesObjects())) {
			foreach ($structured as $vals) {
				$rez = array_merge($rez, $vals);
			}
		}
		return $rez;
	}
	public function giveMrtPrices() {
		return array_filter($this -> getPriceValues(), function($pr) {
			/**
			 * @type ObjectPriceValue $pr
			 */
			return $pr -> price -> id_type == PriceType::getId("mrt");
		});
	}
	public function giveKtPrices() {
		return array_filter($this -> getPriceValues(), function($pr) {
			/**
			 * @type ObjectPriceValue $pr
			 */
			return $pr -> price -> id_type == PriceType::getId("kt");
		});
	}

	/**
	 * @return ObjectPriceValue|bool
	 */
	public function giveMinMrtPrice() {
		$obj = false;
		$min = 0;
		foreach ($this -> giveMrtPrices() as $pr) {
			
			if (($pr -> price < $min) || (!$obj)) {
				$min = $pr -> price;
				$obj = $pr;
			}
		}
		return $obj;
	}
	public function giveMinKtPrice() {
		$obj = false;
		$min = 0;
		foreach ($this -> giveKtPrices() as $pr) {
			
			if (($pr -> price < $min) || (!$obj)) {
				$min = $pr -> price;
				$obj = $pr;
			}
		}
		return $obj;
	}

	/**
	 * @var BaseGoogleDocApiHelper $api - api to get data from.
	 * @return bool - whether the import was successful.
	 */
	public static function importFromGoogleDoc(GoogleDocApiHelper $api){
		if ($api -> success) {
			$entries = $api -> giveData() -> getEntries();
			//echo get_class(current($entries));
			$count = 0;
			$num = 0;
			$total = count($entries);
			foreach($entries as $entry){
				if (!is_a($entry,'Google\Spreadsheet\ListEntry')) {
					continue;
					$count ++;
				}

				$clinicLine = $entry -> getValues();
				if ($clinicLine['название'] == 'comment') {
					continue;
				}

				if (!$clinicLine['рейтинг']) {
					$clinicLine['рейтинг'] = $total - $num;
				}
				$num ++;
				//Получаем клинику из строки, с уже заданными параметрами.
				$clinic = $api -> clinicFromLine($clinicLine);
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param string|null $arg
	 * @return static
	 */
	public function customFind($arg = null){
		switch($this -> getScenario()){
			case 'view':
				return $this -> findByAttributes(['verbiage' => $_GET['verbiage']]);
				break;
			case 'model' :
				return static::model();
				break;
			case 'comments':
				return $this -> findByPk($_GET['id']);
				break;
			case 'id':
				return $this -> findByPk($_GET['id']);
				break;
			default:
				return static::model();
				break;
		}
	}

	/**
	 * @param integer $id of the price whose value is returned
	 * @param bool $refresh
	 * @return null|ObjectPriceValue
	 */
	public function getPriceValue($id,$refresh = false) {
		return $this -> getPriceValuesArray($refresh)[$id];
	}

	/**
	 * @return ObjectPriceValue[]
	 */
	public function getPriceValues($all = false) {
		if ($all) {
			return $this -> allPrices;
		}
		return $this -> prices;
	}

	/**
	 * @param bool $refresh
	 * @return ObjectPriceValue[]
	 */
	public function getPriceValuesArray($refresh = false){
		if ((!isset($this -> _priceValues))||$refresh) {
			$this -> _priceValues = [];
			foreach($this -> getPriceValues() as $val){
				$this -> _priceValues[$val -> id_price] = $val;
			}
		}
		return $this -> _priceValues;
	}

	/**
	 * @return string
     */
	public function getUrl() {
		return  Yii::app() -> controller -> createUrl('/home/modelView',['verbiage' => $this -> verbiage, 'modelName' => get_class($this),'area' => $this -> getFirstTriggerValue('area') -> verbiage],null,false,true);
	}

	/**
	 * @return float[] latitude=широта longitude=долгота St. Petersburg <=> [59,30]
	 */
	public function getCoordinates() {
		return array_map(function($data){
			return (float)trim($data);
		},explode(',',$this -> map_coordinates));
	}

	/**
	 * @param string $verbiage of the trigger
	 * @return TriggerValues[]
	 */
	public function getTriggerValues($verbiage){
		$temp = $this -> giveTriggerValuesObjects()[$verbiage];
		if (!is_array($temp)) {
			$temp = [];
		}
		return $temp;
	}

	/**
	 * @param string $verbiage of the trigger
	 * @return TriggerValues
	 */
	public function getFirstTriggerValue($verbiage){
		return current($this -> getTriggerValues($verbiage));
	}

	/**
	 * @param string $verbiage
	 * @return string
	 */
	public function getFirstTriggerValueString($verbiage){
		$temp = $this -> getFirstTriggerValue($verbiage);
		if (!$temp) {
			return '';
		}
		return $temp -> value;
	}
	/**
	 * @param string $verbiage
	 * @return string
	 */
	public function getConcatenatedTriggerValueString($verbiage, $delimiter = ', '){
		return implode($delimiter, CHtml::giveAttributeArray($this -> getTriggerValues($verbiage), 'value'));
	}

	/**
	 * @return string
	 */
	public function getSortedMetroString() {
		$ids = array_filter(array_map('trim',explode(';',$this -> metro_station)));
		$c = new CDbCriteria();
		$c -> addInCondition('id',$ids);
		$metros = Metro::model() -> findAll($c);
		list($lat, $long) = $this -> getCoordinates();
		usort($metros,function($m1, $m2) use ($lat, $long){
			/**
			 * @type Metro $m1
			 * @type Metro $m2
			 */
			return $m1 -> distanceFrom($lat, $long) - $m2 -> distanceFrom($lat, $long);
		});
		return CHtml::giveStringFromArray(array_map(function($d)use($lat, $long){
			return $d -> display($lat,$long);
		}, $metros),', ');
	}
	public function savePrices() {
		if (!$this -> external_link) {
			return false;
		}
		$fromSite = $this -> parsePrices();
		if (!$fromSite) {
			return false;
		}
		$allPrices = ObjectPrice::model() -> findAllByAttributes(['object_type' => Objects::getNumber(get_class($this))]);
		$enc = "utf-8";
		foreach ($allPrices as $price) {
			/**
			 * @type ObjectPrice $price
			 */
//			if ($this -> getPriceValue($price -> id)) {
//				echo "Price ".$price -> name. " already exists, continue <br/>";
//			}
			//Создали массив альясов для цены
			$toRun = array_filter(array_map(function($key)use($enc){
						return mb_strtolower(trim($key),$enc);
					},explode(';',$price -> name2)));
			//Добавили в массив альясов само название
			array_unshift($toRun,mb_strtolower($price -> name, $enc));
			$p = false;
			foreach ($toRun as $key) {
				if ($fromSite[$key]) {
					$p = $fromSite[$key];
					if ($p > 0) {
						break;
					}
				}
			}
			//Обновляем цену, если нашли ее
			if ($p) {
				//$obj = new ObjectPriceValue('noUpdateIfDup');
				//Мы хотим обновлять цену, если она была уже установлена
				$obj = new ObjectPriceValue();
				$obj->id_object = $this->id;
				$obj->id_price = $price -> id;
				$obj->value = $p;
				if (!$obj -> save()) {
					$err = $obj -> getErrors();
					var_dump($err);
				} else {
					echo $price->name." saved, value=".$obj -> value."<br/>";
				}
			}
		}
		return true;
	}
	public function parsePrices(){
		//static $rez;
		$rez = [];
		if (!$this -> external_link) {
			return [];
		}
		if (!$rez) {
			require_once(Yii::getPathOfAlias('application.components.simple_html_dom') . '.php');
			$html = @file_get_html($this -> external_link);
			if (!$html) {
				return [];
			}
			$enc = "utf-8";
			$rez = [];
			$lines = $html -> find('.price-table tr');
			foreach ($lines as $line) {
				$str = $line -> innerText();
				$arr = array_map('strip_tags',explode('</a>',$str));
				$arr[1]=preg_replace('/[^\d]/','',$arr[1]);
				$key = $arr[0];
				$val = $arr[1];
				$rez[mb_strtolower(trim($key),$enc)] = $val;
			}
		}
		return $rez;
	}

	/**
	 * @param CDbCriteria $criteria
	 * @return Comment[]
	 */
	public function getApprovedComments(CDbCriteria $criteria = null) {
		if (!$criteria) {
			$criteria = new CDbCriteria();
		}
		$criteria -> compare('approved',1);
		return $this -> getModule() -> getObjectsReviewsPool('clinics') -> getComments($this -> id, $criteria);
	}
	public function getFullAddress() {
		$text = $this -> getFirstTriggerValueString('prigorod');
		if (!$text) {
			$text = $this -> getFirstTriggerValueString('area');
		}
		if ($text) {
			return $text . ', ' . $this->address;
		} else {
			return $this -> address;
		}
	}

	/**
	 * @return string
	 */
	public function getNormalizedClassName(){
		static $translate = [
			'clinics' => 'clinics',
			'doctors' => 'doctors',
			'Service' => 'clinics',
			'Article' => 'article',
		];
		return $translate[get_class($this)];
	}

	/**
	 * @return TriggerAssignment
	 */
	public function getTriggerAssignmentModel(){
		$className = $this -> getNormalizedClassName().'TriggerAssignment';
		return $className::model();
	}

	public function addTriggerValue($id){
		$assign = $this -> getTriggerAssignmentModel();
		$assign -> setIsNewRecord(true);
		$assign -> id_object = $this -> id;
		$assign -> id_trigger_value = $id;
		$assign -> save();
	}

	/**
	 * @param BaseModel $model
	 * @param array $post_arr
	 */
	public function FillFieldsFromArray($model, $post_arr) {
		$model->attributes=$post_arr[get_class($this)];
		//additional fields
		if (isset($post_arr[get_class($this)]['Additional']) && !empty($post_arr[get_class($this)]['Additional'])) {
			$model -> additional = $post_arr[get_class($this)]['Additional'];
		}
	}
}