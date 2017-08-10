<?php
//turn on gzip
ini_set('zlib.output_compression', 'On');
ini_set('zlib.output_compression_level', '1');

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
require dirname(__FILE__).'/protected/components/SiteDispatcher.php';
$defConfig = dirname(__FILE__) . '/protected/config/main.php';
try {
    $config = dirname(__FILE__) . '/' . SiteDispatcher::getConfigPath();
} catch (Exception $e) {
    $config = $defConfig;
}
if (!$config) {
    $config = $defConfig;
}
//$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
if (file_exists('debug.pss.php')) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    register_shutdown_function(function($saveTime){
        echo "Время работы скрипта: ".(round((microtime(true)-$saveTime)*100)/100);
    },microtime(true));
}
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
//$arr = require($config);
Yii::createWebApplication($config)->run();