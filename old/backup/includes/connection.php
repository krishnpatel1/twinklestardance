<?php 
if(!session_id())
{
	session_start();
}

require_once("configure.php");
require_once("allconfig.php");
require_once(CLASSES."class_db_connect.php");
require_once(CLASSES."class_root_function.php");
require_once(CLASSES."class_common_function.php");
require_once(CLASSES."class_paging.php");
require_once("functions.php");

$obj = new common_function;
global $obj;

$adminD = $obj->selectData(TABLE_ADMIN,"","admin_id='1'",1);
define('ADMIN_EMAIL',$adminD['admin_email']);
define('SITE_EMAIL',"no-reply@sisworknew.com");
?>