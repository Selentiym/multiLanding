<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.01.2017
 * Time: 11:48
 */
$base = Yii::app() -> theme -> baseUrl;
$url = $base.'/js/main.js';
Yii::app() -> getClientScript() -> registerScriptFile($url, CClientScript::POS_BEGIN);
?>
<div>asd</div>
<a href="<?php echo $url; ?>">js</a>
<?php echo $base; ?>
