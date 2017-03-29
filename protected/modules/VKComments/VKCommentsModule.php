<?php
class VKCommentsModule extends UWebModule implements iCommentPool{
	use tAssets;
	/**
	 * @var string $bankConfig a string to be used in Yii::app() -> getComponent to get
	 * the database connection to the pool with VkAccount's
	 */
	public $bankConfig;
	/**
	 * @var int
	 */
	public $pageSize = 5;
	public function init() {
		parent::init();
		//Необходимо для работы VKAPI
		require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');

		$this -> _assetsPath = Yii::app() -> getAssetManager() -> publish($this -> getBasePath() . '/assets');

		$this->setImport(array(
			$this -> getId().'.models.*',
			//'VKComments.components.*',
		));
		$temp = $this -> getAttribute('bankConfig');
		if (!($temp instanceof CDbConnection)) {
			$temp = Yii::app() -> getComponent($temp);
		}
		if (!($temp instanceof CDbConnection)) {
			throw new CDbException("Could not establish connection in module ". get_class($this));
		}
		VKAccount::setDbConnection($temp);
	}

	private function registerClient(){
		$cs = Yii::app() -> getClientScript();
		$cs -> registerScriptFile("http://vk.com/js/api/openapi.js",CClientScript::POS_BEGIN);
		$this -> registerJSFile('/js/functions.js',CClientScript::POS_END);
		$this -> registerCSSFile('/css/custom.css');
		$this -> registerCSSFile('/css/vk_lite.css');
		$this -> registerCSSFile('/css/vk_page.css');
		$this -> registerCSSFile('/css/widget_comments.css');
		$params = [
			'baseUrl' => $this -> createUrl('')
		];
		$cs -> registerScript('createVKNamespace','
			window.VKCommentsModule = '.json_encode($params).';
		',CClientScript::POS_BEGIN);
		Yii::app() -> getClientScript() -> registerScript('loadVkApi','
			VK.init({
				apiId: 5711487
			});
			var logged;
		', CClientScript::POS_READY);
		$cs -> registerScript('vkForm',"
		VK.Auth.getLoginStatus(function(data){
			var button = $('.show_input');
			if (data.session) {
				button.parent().remove();
				VK.Api.call('users.get', {user_ids:data.session.mid, fields:'domain, photo_50'}, function(userData){
					console.log(userData);
					if (userData.response.length) {
						var user = userData.response[0];
						$('.vk_avatar_round_small').attr('src',user.photo_50);
						var url = 'http://vk.com/';
						if (user.domain) {
							url += user.domain;
						} else {
							url += 'id' + user.uid;
						}
						$('.vk_avatar_link').attr('href',url);
						$('.wcomments_form').show();
						$('.VkIdHidden').val(user.uid);
					} else {
						alert('Ошибка авторизации');
					}
				});
			} else {
				button.click(function(){
					var params = {
						client_id:5711487,
						redirect_uri:window.location.host + window.location.pathname,
						response_type:'token'
					};
					location.href = 'https://oauth.vk.com/authorize?'+$.param(params);
				});
			}
		});
		",CClientScript::POS_READY);
	}

	/**
	 * @param integer $id of the object
	 * @param CDbCriteria $criteria
	 * @return string the html of the widget
	 */
	public function showObjectCommentsWidget($id, CDbCriteria $criteria = null){
		$comments = $this -> getComments($id, $criteria);
		return $this -> showCommentsWidget($comments, $id);
	}

	/**
	 * @param Comment[] $comments
	 * @param integer $object_id where to add new reviews
	 * @return mixed|string
	 */
	public function showCommentsWidget($comments, $object_id){
		$ids = CHtml::giveAttributeArray($comments,'id');
		//Регистрируем основные скрипты
		$this -> registerClient();
		$widgetId = 'vkComments'.substr(md5(implode($ids)),0,10);
		return Yii::app() -> getController() -> renderPartial($this -> getId() . '.views._mainWidget',[
			'comments' => $comments,
			'ids' => $ids,
			'id' => $widgetId,
			'object_id' => $object_id
		],true);
		//
	}
	/**
	 * @param integer $id of the object whose comments to get
	 * @param CDbCriteria|null $criteria
	 * @return Comment[]
	 */
	public function getComments($id,CDbCriteria $criteria = null){
		Comment::setModule($this);
		if (!$criteria instanceof CDbCriteria) {
			$criteria = new CDbCriteria();
			$criteria -> order = 'created ASC';
			$criteria -> compare('approved',1);
		}
		$criteria -> compare('id_object', $id);
		return Comment::model() -> findAll($criteria);
	}

	/**
	 * @param integer $id
	 * @return VkAccount
	 */
	public function getAccount($id){
		return VKAccount::model() -> findByPk($id);
	}

	/**
	 * @param $id
	 * @return array|mixed|null
	 */
	public function getComment($id) {
		return Comment::model() -> findByPk($id);
	}
	/**
	 * @return VKAccount
	 */
	//abstract public function getRandomAccount();

	/**
	 * @param string $name
	 * @return bool
	 */
	public function _isAllowedToEvaluate($name) {
		return parent::_isAllowedToEvaluate($name) || in_array($name, ['bankConfig']);
	}

	/**
	 * @return array|bool
	 */
	public function randomPerson() {
		$vk = getjump\Vk\Core::getInstance()->apiVersion('5.5');
		$temp = current($vk->request('users.get', [
				'user_ids' => [rand(1000000,1000000*100)],
				"fields" => "photo_50, domain"
		])->getResponse());
		if ($temp -> deactivated) {
			return $this -> randomPerson();
		}
		return $temp;
	}
	/**
	 * @param integer $objectId
	 * @param string $text
	 * @param mixed[] $else
	 * @return Comment
	 */
	public function addComment($objectId, $text, $else) {
		$c = new Comment();
		$c -> text = $text;
		$c -> id_object = $objectId;
		$c -> attributes = $else;
		$c -> save();
		return $c;
	}

	/**
	 * @param Comment $c
	 * @param $objectId
	 * @param $text
	 * @param $else
	 * @return Comment
	 */
	public function updateComment(Comment $c, $objectId, $text, $else) {
		$c -> text = $text;
		$c -> id_object = $objectId;
		$c -> attributes = $else;
		$c -> save();
		return $c;
	}

	/**
	 * @param Comment $comment
	 * @return bool
	 */
	public function deleteComment(Comment $comment) {
		return $comment -> delete();
	}
	/**
	 * @param Comment $model
	 * @return string html of the form
	 */
	public function commentForm(Comment $model = null){
		if (!$model) {
			$model = new Comment();
		}
		$acc = Yii::app() -> getController() -> renderPartial($this -> getId() . '.views.VKAccount',['model' => $model -> getAccount()],true);
		return Yii::app() -> getController() -> renderPartial($this -> getId() . '.views._form',['model' => $model, 'mod' => $this, 'acc' => $acc],true);
		//$this ->  -> renderPartial();
	}
	//public function render
}
