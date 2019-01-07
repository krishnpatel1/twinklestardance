<?php
if (substr(phpversion(),0,1) != '6')
    error_reporting(E_ALL);
else
    error_reporting(E_ALL & ~E_STRICT);  

function p($obj, $f=1)
{
	print "<pre>";
	print_r($obj);
	print "</pre>";
	if($f==1) die;
}
 	
// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
require_once($yii);
require_once(dirname(__FILE__).'/protected/web/JVWebApplication.php');
Yii::createApplication('JVWebApplication',$config)->run();
