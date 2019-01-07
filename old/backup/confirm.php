<?php 
include ("includes/connection.php");
if(FURL != "http://192.168.1.100:82/projects/2012/twinkle_star_dance/codes/"){
	if($_SERVER['SERVER_PORT'] != 443) {
	   header("HTTP/1.1 301 Moved Permanently");
	   header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	   exit();
	}
}
//include ("includes/all_form_check.php");
//include ("includes/message.php");
//require_once("includes/paypal_pro.inc.php");
$temp=$_SESSION['scart'];
$totrec=count($_SESSION['scart']);
if(count($_SESSION['scart'])>0)
{
	$_POST['order_date'] = date("Y-m-d H:i:s");
	//$_POST['order_key'] = $obj->get_order_key();
	/***** Create User if not exist *****/
	if(!isLogged()){
		$userData = array();
		$userData['user_first_name'] = $_SESSION['order']['order_owner_fname'];
		$userData['user_last_name'] = $_SESSION['order']['order_owner_lname'];
		$userData['user_studio_name'] = $_SESSION['order']['order_studio_name'];
		
		$userData['user_primary_contact'] = $_SESSION['order']['order_pri_contact'];
		$userData['user_bussiness_phone'] = $_SESSION['order']['order_busines_ph'];
		$userData['user_mobile_phone'] = $_SESSION['order']['order_mob_ph'];
		$userData['user_mobile_email'] = $_SESSION['order']['order_mob_email'];
		$userData['user_enroll_student'] = $_SESSION['order']['order_avg_num'];
		$userData['user_dance_informa'] = $_SESSION['order']['order_free_sub'];
		$userData['user_custom_manager'] = $_SESSION['order']['order_send_inf'];
		$userData['user_mailing_list'] = $_SESSION['order']['order_opt_mail'];
		
		$userData['user_company'] = $_SESSION['order']['order_company'];
		$userData['user_bulding'] = $_SESSION['order']['order_bulding'];
		$userData['user_building_no'] = $_SESSION['order']['order_building_no'];
		$userData['user_locality'] = $_SESSION['order']['order_locality'];
		$userData['user_post'] = $_SESSION['order']['order_post'];
		$userData['user_country'] = $_SESSION['order']['order_country'];
		$userData['user_street'] = $_SESSION['order']['order_street'];
		$userData['user_city'] = $_SESSION['order']['order_city'];
		$userData['user_state'] = $_SESSION['order']['order_state'];
		$userData['user_zip'] = $_SESSION['order']['order_zip'];
		
		$userData['user_ship_company'] = $_SESSION['order']['order_bill_company'];
		$userData['user_ship_building'] = $_SESSION['order']['order_bill_bulding'];
		$userData['user_ship_buildingno'] = $_SESSION['order']['order_bill_building_no'];
		$userData['user_ship_locality'] = $_SESSION['order']['order_bill_locality'];
		$userData['user_ship_post'] = $_SESSION['order']['order_bill_post'];
		$userData['user_ship_state'] = $_SESSION['order']['order_bill_state'];
		$userData['user_ship_street'] = $_SESSION['order']['order_bill_street'];
		$userData['user_ship_city'] = $_SESSION['order']['order_bill_city'];
		$userData['user_ship_zip'] = $_SESSION['order']['order_bill_zip'];
		
		
		$userData['user_phone'] = $_SESSION['order']['order_ph_no'];
		$userData['user_email'] = $_SESSION['order']['order_business_email'];
		$userData['user_password'] = generatePassword(10);
		$userData['user_reg_date'] = date("Y-m-d H:i:s");
		
		if(!$obj->selectData(TABLE_USER,"","user_email='".trim($_SESSION['order']['order_business_email'])."' and user_status<>'Deleted'",1)) 
		{ 
			$obj->insertData(TABLE_USER,$userData);
			//$userId = mysql_insert_id();
			$_SESSION['userId'] = mysql_insert_id();
			$userId = $_SESSION['userId'];
			
			/** Send password to the user **/
			$messageUser = "Dear ".$userData['user_first_name']." ".$userData['user_last_name'].",<br><br>Your account has beed created successfully. Your account credential are the following:<br />"; 
			$messageUser .= "Email : ".$userData['user_email']."<br />";
			$messageUser .= "Password : ".$userData['user_password']."<br />";
			$messageUser .= "Thank You<br><br>".MAIL_THANK_YOU;
			
			$bodyUser     = $obj->mailBody($messageUser);
			$toUser       = $userData['user_email'];
			$fromSite     = SITE_EMAIL;
			$subjectUser  = "Login Details  - ".MAIL_THANK_YOU;
			$obj->sendMail($toUser, $subjectUser,$bodyUser,$fromSite,"Twinkle Star Dance",$type);
			/** End of send password to the user **/
			//$user_login=$obj->selectData(TABLE_USER,"","user_id='".$userId."'",1);
			//$_SESSION['user']=$user_login;
		}
	}else{
		$userId = $_SESSION['user']['user_id'];
		$_SESSION['userId'] = $_SESSION['user']['user_id'];
		/*=============EDIT USER DATA=====================*/
		$userData = array();
		$userData['user_first_name'] = $_SESSION['order']['order_owner_fname'];
		$userData['user_last_name'] = $_SESSION['order']['order_owner_lname'];
		$userData['user_studio_name'] = $_SESSION['order']['order_studio_name'];
		
		$userData['user_primary_contact'] = $_SESSION['order']['order_pri_contact'];
		$userData['user_bussiness_phone'] = $_SESSION['order']['order_busines_ph'];
		$userData['user_mobile_phone'] = $_SESSION['order']['order_mob_ph'];
		$userData['user_mobile_email'] = $_SESSION['order']['order_mob_email'];
		$userData['user_enroll_student'] = $_SESSION['order']['order_avg_num'];
		$userData['user_dance_informa'] = $_SESSION['order']['order_free_sub'];
		$userData['user_custom_manager'] = $_SESSION['order']['order_send_inf'];
		$userData['user_mailing_list'] = $_SESSION['order']['order_opt_mail'];
		
		$userData['user_company'] = $_SESSION['order']['order_company'];
		$userData['user_bulding'] = $_SESSION['order']['order_bulding'];
		$userData['user_building_no'] = $_SESSION['order']['order_building_no'];
		$userData['user_locality'] = $_SESSION['order']['order_locality'];
		$userData['user_post'] = $_SESSION['order']['order_post'];
		$userData['user_country'] = $_SESSION['order']['order_country'];
		$userData['user_street'] = $_SESSION['order']['order_street'];
		$userData['user_city'] = $_SESSION['order']['order_city'];
		$userData['user_state'] = $_SESSION['order']['order_state'];
		$userData['user_zip'] = $_SESSION['order']['order_zip'];
		
		$userData['user_ship_company'] = $_SESSION['order']['order_bill_company'];
		$userData['user_ship_building'] = $_SESSION['order']['order_bill_bulding'];
		$userData['user_ship_buildingno'] = $_SESSION['order']['order_bill_building_no'];
		$userData['user_ship_locality'] = $_SESSION['order']['order_bill_locality'];
		$userData['user_ship_post'] = $_SESSION['order']['order_bill_post'];
		$userData['user_ship_state'] = $_SESSION['order']['order_bill_state'];
		$userData['user_ship_street'] = $_SESSION['order']['order_bill_street'];
		$userData['user_ship_city'] = $_SESSION['order']['order_bill_city'];
		$userData['user_ship_zip'] = $_SESSION['order']['order_bill_zip'];
		
		
		$userData['user_phone'] = $_SESSION['order']['order_ph_no'];
		$userData['user_email'] = $_SESSION['order']['order_business_email'];
		
		$obj->updateData(TABLE_USER,$userData," user_id='".$userId."'");
		/*===========================================*/
	}
	
	/**** End of create user section ****/
	

	///////////////////////////////////Order Insert////////////////////////////
	$_POST = array_merge($_POST,$_SESSION['order']);
	$_POST['order_user'] = $userId;
	
	$obj->insertData(TABLE_ORDER,$_POST);
	$newOrderId = mysql_insert_id();

		$sum=0;
		for($i=0;$i<$totrec;$i++)
		{
			$pro_id=$temp[$i]['productid']; //Package ID
			$pro_type=$temp[$i]['p_type'];
			$pro_price=$temp[$i]['price'];
			$pro_dw_type=$temp[$i]['dw_type'];
			$pack_type=$temp[$i]['pack_type'];
			$duration=$temp[$i]['duration'];
					
			/////////////////////Order Details/////////////////////
			$arrOD['od_order']          = $newOrderId;
			$arrOD['od_pro']            = $pro_id; //Package ID
			$arrOD['od_pro_type']       = $pro_type;
			$arrOD['od_price']          = $pro_price;
			$arrOD['od_dw_type']        = $pro_dw_type;
			$arrOD['od_price_type']     = $pack_type;
			$arrOD['od_duration']       = $duration;
			
			$obj->insertData(TABLE_ORDER_DETAIL,$arrOD);
						
			$tot=$pro_price;
			$tot=number_format($tot, 2, '.', '');
			$sum=number_format($sum+$tot,2, '.', '');
			
			if($pack_type != 'subscription'){
				$total=$pro_price;
				$sum1=number_format($sum1+$total,2, '.', '');
			}
			else
			{
				$sum1=$sum1+$sum;
			}
			
		}
		
	///////////////////////////Order Total Update///////////////////////////////////////	
	$arrODU['order_sub_total'] = $sum;
	$arrODU['order_total']     = $sum;
	
	$obj->updateData(TABLE_ORDER,$arrODU,"order_id='".$newOrderId."'");

	$_SESSION['pay_amount'] = $arrODU['order_total'];
	$_SESSION['pay_id']     = $newOrderId;
	
	$obj->reDirect("paypal.php");
}
else
{
	$obj->reDirect("online_packages.php");
}		
?>