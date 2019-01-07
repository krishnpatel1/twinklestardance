<?php
///////////////////////SITE INFORMATION///////////////////////////
define('SITE_NAME','twinklestardance.com');
define('SITE_NAME_FULL','www.'.SITE_NAME);
define('SITE_TITLE','Twinkle Star Dance');
$title = SITE_TITLE;
define('FOOTER_TEXT','&copy;'.date("Y")." ".SITE_NAME);


////////////////////////////TABLE PREFIX//////////////////////////
define('TPRE','twinklestar_');


/////////////////////DATABASE TABLES//////////////////////////////
define('TABLE_ADMIN',TPRE.'admin');
define('TABLE_COUNTRY',TPRE.'country');
define('TABLE_STATE',TPRE.'state');
define('TABLE_DOWNLOADTYPE',TPRE.'download_type');
define('TABLE_PRODUCT',TPRE.'product');
define('TABLE_PRICELIST',TPRE.'price_list');
define('TABLE_ONLINE_PRODUCT',TPRE.'online_product');
define('TABLE_PACKAGE',TPRE.'package');
define('TABLE_SPECIAL_PACKAGE',TPRE.'special_package');
define('TABLE_VIDEO',TPRE.'video');

define('TABLE_CONTENT',TPRE.'content');
define('TABLE_ORDER',TPRE.'order');
define('TABLE_ORDER_DETAIL',TPRE.'order_details');
define('TABLE_ORDERSTATUS',TPRE.'orderstatus');
////////////////////////////PATH//////////////////////////////////
define('ADMIN','admin/');
define('INCLUDES','includes/');
define('CLASSES','classes/');
define('JS','includes/js/');
define('CSS','css/');
define('CSSA','css/');
define('PRODUCTS','product/');
define('VIDEO','video/');
define('PACKAGE_IMG','package_img/');
define('IMAGES','images/');
define('PHOTOS','photos/');
define('ONLINE_PRODUCT','online_product/');

define('NEWS','news/');
define('FAQP','faqp/');
define('DOCP','docp/');
define('DOCF','docf/');
define('CONTACTP','conp/');
define('CSV','csv/');
define('GI','gi/');


define('NOT_FOUND_IMG','no_image.jpg');
/////////////////////////////Site Title////////////////////////////

define('ADMIN_TITLE','Admin panel '.SITE_NAME);

//////////////////////////////Welcome Text/////////////////////////
define('ADMIN_WELCOME','Welcome To '.SITE_TITLE.' Administrator Panel');
define('USER_WELCOME','Welcome To Content User Panel');

define('MAIL_THANK_YOU',SITE_TITLE.' Team');

define("TIME",time());
define("DAY",date('d',TIME));
define("MONTH",date('F',TIME));
define("YEAR",date('Y',TIME));
define("LAST_MIN_LOG",ini_get('session.gc_maxlifetime')/60);
define("CURRENT_DATE_TIME",date("Y-m-d H:i:s"));
//////////////////////////////Fixed Section/////////////////////////
define('ADMIN_LOGO','<img src="images/logo.png" border="0">');
define('FOOTER_TEXT','&copy; '.YEAR.'. '.SITE_NAME.'. All Rights Reserved.');

////////////////////////////////////Messages////////////////////////
define('INVALID_LOGIN','Please input correct user name and password');
define('PASSWORD_MISMATCH','Password you entered does not match');
define('UPDATE_SUCCESSFULL','Updated successfully');
define('DELETE_SUCCESSFULL','Deleted successfully');
define('ADD_SUCCESSFULL','Successfully added');
define('UPLOAD_SUCCESSFULL','File uploaded successfully');

define(UPDATED, "Record Updated!");
define(INSERTED, "Record Inserted !");
define(ADDED, " Added Successfully !");
define(DELETE, "Record Deleted!");

define('USER_ADDED','New user added');
define('EMAIL_USED','Email address already used');
define('USER_EXIST','Username already taken');
define('REGISTER_SUCCESS',"You have registered successfully. Your account is pending for administrator's approval. After approval we will send you a confirmation mail to activate your account.");
define('LOGIN_SUCCESS',"You have logged in successfully");
define('LOGOUT_SUCCESS',"You have logged out successfully");
define('PASSWORD_CHANGED',"Your password has been changed successfully");
define('PASSWORD_SENT',"Your password sent successfully to your email address");
define('CANNOT_LOGIN',"You can not login now,please try latter..");

define("PAYPAL_PAY_MODE",false);

//Paypal Configuration
if(PAYPAL_PAY_MODE)
{
	define(PAYPAL_URL,'https://www.paypal.com/cgi-bin/webscr');
	define(PAYPAL_BUSINESS_EMAIL,'');
}
else
{
	define(PAYPAL_URL,'https://www.sandbox.paypal.com/cgi-bin/webscr');
	define(PAYPAL_BUSINESS_EMAIL,'demofo_1231836716_biz@gmail.com');
}

?>