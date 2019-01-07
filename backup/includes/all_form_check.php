<?php 
 ///////////////////////////////////Forgot Password//////////////////////////////////
if(isset($_POST['ForgotPass']))
{
	$_SESSION['messageClass'] = 'errorClass';
	
	if(trim($_POST['user_email_id'])=="")
	{
		$obj->add_message("message","Email-ID Should Not Be Blank!");
	}
	else
	{
		if(!$obj->check_email_address(trim($_POST['user_email_id']))) {$obj->add_message("message","Email Should Be Valid!");}
	}
	if($obj->get_message("message")=="")
	{
		$user = emailUsed(trim($_POST['user_email_id']));		
		if($user)
		{
		
			$user_id   = $user['user_email'];
			$user_pass = $user['password'];
			//$user_pass = $obj->retrievePass($user['password']);
		
			$obj->add_message("message","Your new password is successfully sent to your email address!");
			
			$forgot_password_mail  = "Dear ".$user['user_first_name']."<br><br>";
			$forgot_password_mail .= "Your Password Is : ".$user_pass;
			$forgot_password_mail .= "<br><br>Thank You<br>".MAIL_THANK_YOU;
			
			$body = $obj->mailBody($forgot_password_mail);
			
			    $to = $_POST['user_email_id'];
				$from = SITE_EMAIL;
				$subject = "Forgot Password - ".MAIL_THANK_YOU;
				
				$obj->sendMail($to, $subject,$body,$from,"User",$type);
				$_SESSION['messageClass'] = 'successClass';
		}
		else
		{
			$obj->add_message("message","Please insert correct email address!");
		}
		
	}
	
}
///////////////////////////////End Of Forgot Password/////////////////////////////////////
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////Login/////////////////////////////////////
if($_REQUEST['loginCheck']=='Login')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['user_name'])=="") {$obj->add_message("login_msg","Username Should Not Be Blank!");}
	if(trim($_POST['password'])=="") {$obj->add_message("login_msg","Password Should Not Be Blank!");}
	if($obj->get_message("login_msg")=="")
	{
		$user_name = $_POST['user_name'];
		$user_pass = $_POST['password'];
					
		$obj->add_message("login_msg",userLogin($user_name,$user_pass));
		$obj->reDirect($_SERVER['REQUEST_URI']);
	}
	else
	{
		$obj->add_message("login_msg","Invalid Login Details!");
	}
	$obj->reDirect($_SERVER['REQUEST_URI']);
	
}
///////////////////////////////End Of Login/////////////////////////////////////
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////User Registration/////////////////////////////////////

if($_REQUEST['userReg']=='Submit')
{
	$_SESSION['messageClass'] = "errorClass";
		
	if(trim($_POST['user_first_name'])=="") {$obj->add_message("message","First Name Should Not Be Blank!");}
	if(trim($_POST['user_last_name'])=="") {$obj->add_message("message","Last Name Should Not Be Blank!");}
	if(trim($_POST['user_gender'])=="") {$obj->add_message("message","Please Choose Gender!");}
	if(trim($_POST['user_add_1'])=="") {$obj->add_message("message","Address 1 Should Not Be Blank!");}
	
	if(trim($_POST['user_country'])=="") {$obj->add_message("message","Country Should Not Be Blank!");}
	if(trim($_POST['user_state'])=="") {$obj->add_message("message","State Should Not Be Blank!");}
	if(trim($_POST['user_city'])=="") {$obj->add_message("message","City Should Not Be Blank!");}
	if(trim($_POST['user_zip'])=="") {$obj->add_message("message","Postcode Should Not Be Blank!");}
	
	if(trim($_POST['user_email'])=="") {$obj->add_message("message","Email Should Not Be Blank!");} else{
	if(!isEmail(trim($_POST['user_email']))) {$obj->add_message("message","Please Enter A Valid Email!");} }
	if(emailUsed(trim($_POST['user_email']))) {$obj->add_message("message","This Email IS Already Exist!");}
	
	//if(trim($_POST['user_company'])=="") {$obj->add_message("signup_message","Company Name Should Not Be Blank!");}

	//if(trim($_POST['username'])=="") {$obj->add_message("signup_message","User Name Should Not Be Blank!");}
	
	if(trim($_POST['user_pass'])=="") {$obj->add_message("message","Password Should Not Be Blank!");}
	if(trim($_POST['user_repass'])=="") {$obj->add_message("message","Retype Password Should Not Be Blank!");}
	if(trim($_POST['user_pass'])!=trim($_POST['user_repass'])) {$obj->add_message("message","Password & Confirm Password Mismatch!");}
		
	if($obj->get_message("message")=="")
	{
		$user_exist = emailUsed($_POST['user_email']);
		if($user_exist)
		{
			$obj->add_message("signup_message","Email-Id You Have Enetered Is Alrady Been Used!");
		}
		else
		{
	
			$newUser=array();
			$newUser['user_first_name']=$_REQUEST['user_first_name'];
			$newUser['user_middle_name']=$_REQUEST['user_middle_name'];
			$newUser['user_last_name']=$_REQUEST['user_last_name'];
			$newUser['user_email']=$_REQUEST['user_email'];
			$newUser['user_add_1']=$_REQUEST['user_add_1'];
			$newUser['user_add_2']=$_REQUEST['user_add_2'];
			$newUser['user_city']=$_REQUEST['user_city'];
			$newUser['user_state']=$_REQUEST['user_state'];
			$newUser['user_country']=$_REQUEST['user_country'];
			$newUser['user_zip']=$_REQUEST['user_zip'];
			$newUser['user_phone']=$_REQUEST['user_phone'];
			$newUser['user_gender']=$_REQUEST['user_gender'];
			$newUser['password']=$_REQUEST['user_pass'];
			$newUser['user_reg_date']=date("Y-m-d h:i:s");
			
			if($_FILES['user_image']['tmp_name'])
			{
				list($fileName1,$error)=$obj->uploadFile('user_image',USER_IMG, 'gif,jpg,png,jpeg');
				if($error)
				{
					$msg=$error;
					$err=1;
				}
				else
				{
					$_POST['user_image']=$fileName1;
					$newUser['user_image']=$fileName1;
				}
			}
			
			$row=$obj->insertData(TABLE_USER,$newUser);
			
			//$_SESSION['user'] = $newUser;
			//$_SESSION['user']['user_id'] = mysql_insert_id();
			
			////////////////////////////////////MAIL FUNCTIONALITY/////////////////////////////////////////
			
			if(is_numeric($_POST['user_state'])){ $uState = $obj->get_state($_POST['user_state']);}else{ $uState = $_POST['user_state'];}
			$regMailFormat = '<div class="cont_wrapperInner">
                    <table width="100%" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="left" valign="top">First Name:</td>
                        <td align="left" valign="top">'.$_POST['user_first_name'].'</td>
                      </tr>
					  <tr>
                        <td align="left" valign="top">Middle Name:</td>
                        <td align="left" valign="top">'.$_POST['user_middle_name'].'</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">Last Name:</td>
                        <td align="left" valign="top">'.$_POST['user_last_name'].'</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">E-Mail Address:</td>
                        <td align="left" valign="top">'.$_POST['user_email'].'</td>
                      </tr>
                    </table>
                  </div>
					<div class="captionTitle">
					<div><strong>Your Address</strong></div>
					</div>
					<div class="cont_wrapperInner">
					<table width="100%" border="0" cellpadding="2" cellspacing="2">
					  <tr>
						<td width="150" align="left" valign="top"> Address 1:</td>
						<td align="left" valign="top">'.$_POST['user_add_1'].'</td>
					  </tr>
					  <tr>
						<td align="left" valign="top">State/Province:</td>
						<td align="left" valign="top">'.$obj->get_state($_POST['user_state']).'</td>
					  </tr>
					  <tr>
						<td align="left" valign="top">City:</td>
						<td align="left" valign="top">'.$_POST['user_city'].'</td>
					  </tr>
					  <tr>
						<td align="left" valign="top">Postcode:</td>
						<td align="left" valign="top">'.$_POST['user_zip'].'</td>
					  </tr>
					</table>
					</div>
					<div class="captionTitle">
					<div><strong>Your Contact Information</strong></div>
					</div>
					<div class="cont_wrapperInner">
					<table width="100%" border="0" cellpadding="2" cellspacing="2">
					  <tr>
						<td width="150" align="left" valign="top">Telephone Number:</td>
						<td align="left" valign="top">'.$_POST['user_phone'].'</td>
					  </tr>
					</table>
					</div>';
			
			$message = "Dear ".$_POST['user_first_name']." ,<br><br>Thank you for regisering with us. Please <a href='".FURL."login.php'>Click Here<a/> to login into the site and continue your shopping with us.<br><br> Email ID :".$_POST['user_email']."<br>Password :".$_POST['user_pass']."<br><br>"; 
		  
 			$message .= "Thank You<br><br>".MAIL_THANK_YOU;
 			
			$body     = $obj->mailBody($message);
			$to       = $_POST['user_email'];
			$from     = SITE_EMAIL;
			$subject  = "Thank you for registering with us - ".MAIL_THANK_YOU;
			$obj->sendMail($to, $subject,$body,$from,"Hot Campus Buzz",$type);
			
			$amessage  = "Dear Administrator,<br><br>A new user has registered today. Please check the details below :<br><br>";
			$amessage .= $regMailFormat;
			
			$subject   = $_POST['user_first_name']." has registered today - ".MAIL_THANK_YOU;
			$amessage .= "<br><br>Thank You<br>".MAIL_THANK_YOU;
			$body  = $obj->mailBody($amessage);
			
			$toa       = ADMIN_EMAIL;
			$obj->sendMail($toa, $subject,$body,$from,"Hot Campus Buzz",$type);
			//$obj->add_message("message","Congratulation! You Have Registered Successfully.");
			$obj->add_message("login_msg","Congratulation! You Have Registered Successfully.");
			$_SESSION['messageClass'] = "successClass";
			$_POST = "";
			$obj->reDirect("login.php");
			
		}
	}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////Update Profile/////////////////////////////////////

if($_REQUEST['editprofile']=='UPDATE')
{
	$_SESSION['messageClass'] = "errorClass";
		
	if(trim($_POST['user_first_name'])=="") {$obj->add_message("message","First Name Should Not Be Blank!");}
	if(trim($_POST['user_last_name'])=="") {$obj->add_message("message","Last Name Should Not Be Blank!");}
	if(trim($_POST['user_gender'])=="") {$obj->add_message("message","Gender Should Not Be Blank!");}
	if(trim($_POST['user_add_1'])=="") {$obj->add_message("message","Address 1 Should Not Be Blank!");}
	if(trim($_POST['user_country'])=="") {$obj->add_message("message","Country Should Not Be Blank!");}
	if(trim($_POST['user_state'])=="") {$obj->add_message("message","State Should Not Be Blank!");}
	if(trim($_POST['user_city'])=="") {$obj->add_message("message","City Should Not Be Blank!");}
	if(trim($_POST['user_zip'])=="") {$obj->add_message("message","Postcode Should Not Be Blank!");}
	if(trim($_POST['user_email'])=="") {$obj->add_message("message","Email Should Not Be Blank!");}
	if(!isEmail(trim($_POST['user_email']))) {$obj->add_message("message","Please Enter A Valid Email!");}
	if(trim($_POST['user_pass'])=="") {$obj->add_message("message","Password Should Not Be Blank!");}
		
	if($obj->get_message("message")=="")
	{
		//$user_exist = emailUsed($_POST['user_email']);
		$user_exist=$obj->selectData(TABLE_USER,"","user_email='".$_POST['user_email']."' and user_id!=".$_SESSION['user']['user_id']." and user_status!='Deleted'",1);
		if($user_exist)
		{
			$obj->add_message("signup_message","Email-Id You Have Enetered Is Alrady Been Used!");
		}
		else
		{
	
			$newUser=array();
			$newUser['user_first_name']=$_REQUEST['user_first_name'];
			$newUser['user_middle_name']=$_REQUEST['user_middle_name'];
			$newUser['user_last_name']=$_REQUEST['user_last_name'];
			$newUser['user_gender']=$_REQUEST['user_gender'];
			$newUser['user_add_1']=$_REQUEST['user_add_1'];
			$newUser['user_add_2']=$_REQUEST['user_add_2'];
			$newUser['user_country']=$_REQUEST['user_country'];
			$newUser['user_state']=$_REQUEST['user_state'];
			$newUser['user_city']=$_REQUEST['user_city'];
			$newUser['user_zip']=$_REQUEST['user_zip'];
			$newUser['user_phone']=$_REQUEST['user_phone'];
			$newUser['user_email']=$_REQUEST['user_email'];
			$newUser['password']=$_REQUEST['user_pass'];
			
			$newUser['user_mod_date']=date("Y-m-d h:i:s");
			
			if($_FILES['user_image']['tmp_name'])
			{
				list($fileName1,$error)=$obj->uploadFile('user_image',USER_IMG, 'gif,jpg,png,jpeg');
				if($error)
				{
					$msg=$error;
					$err=1;
				}
				else
				{
					$_POST['user_image']=$fileName1;
					$newUser['user_image']=$fileName1;
				}
			}
			
			$row=$obj->updateData(TABLE_USER,$newUser," user_id='".$_SESSION['user']['user_id']."'");
		
						
			$obj->add_message("message","Profile Updated Successfully.");
			$_SESSION['messageClass'] = "successClass";
			$_POST = "";
			$obj->reDirect("my_profile.php");
			
		}
	}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
////////////////////////////////////////Newsletter Subscription//////////////////////////

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Register')
{
	$_SESSION['messageClass'] = 'errorClass';
	if(trim($_POST['user_first_name'])=="") {$obj->add_message("message","First Name Should Not Be Blank!");}
	if(trim($_POST['user_last_name'])=="") {$obj->add_message("message","Last Name Should Not Be Blank!");}
	if(trim($_POST['user_email'])=="") {$obj->add_message("message","Email Should Not Be Blank!");}
	if(!$obj->check_email_address(trim($_POST['user_email']))) {$obj->add_message("message","Email Should Be Valid!");}
	if(emailUsed($_POST['user_email'])){$obj->add_message("message","Please provide an unique email-id!");}
	
	if($obj->get_message("message")=="")
	{
		$inv_id = $obj->retrievePass($_REQUEST['invId']);
		$_POST['user_inv_id'] = $inv_id;
		$_POST['user_reg_date'] = CURRENT_DATE_TIME;
		$sqlIS = $obj->insertData(TABLE_USER,$_POST);
		$_SESSION['current_user_id'] = mysql_insert_id();
		
		if($inv_id)
		{
			$arrIRA['inv_join_date'] = CURRENT_DATE_TIME;
			$arrIRA['inv_join_status'] = 'Accept';
			$obj->updateData(TABLE_INVITATION,$arrIRA,"inv_id='".$inv_id."'");
		}
		
		$_SESSION['inviter_name']  = $_POST['user_first_name']." ".$_POST['user_last_name'];
		$_SESSION['inviter_fname'] = $_POST['user_first_name'];
		$_SESSION['inviter_lname'] = $_POST['user_last_name'];
		$_SESSION['inviter_email'] = $_POST['user_email'];
		
		$obj->add_message("message","You Have Successfully Registered!");
		$_SESSION['messageClass'] = 'successClass';
		$obj->reDirect("invitations.php");		
	}

}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////Customer Contact Us/////////////////////////////////////
if(isset($_POST['cust_send']))
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['cust_fname'])=="") {$obj->add_message("message","First Name Should Not Be Blank!");}
	if(trim($_POST['cust_lname'])=="") {$obj->add_message("message","Last Name Should Not Be Blank!");}
	if(trim($_POST['cust_email'])=="") {$obj->add_message("message","Email Should Not Be Blank!");}else{
	if(!$obj->check_email_address(trim($_POST['cust_email']))) {$obj->add_message("message","Email Should Be Valid!");}}
	
	if($obj->get_message("message")=="")
	{
		$contact_message  = "<b>".$_POST['cust_fname']."</b>, has contact you. Please view the details below.<br><br>";
		$contact_message .= "Name: ".$_POST['cust_fname']." ".$_POST['cust_lname']."<br>";
		$contact_message .= "Email : ".$_POST['cust_email']."<br>";
		$contact_message .= "Phone No : ".$_POST['cust_phone']."<br>";
		$contact_message .= "Subject : ".$_POST['subject']."<br>";
		$contact_message .= "Message    : ".$_POST['cust_message']."<br>";
					
		$contact_message .="<br><br>Thank You<br>".MAIL_THANK_YOU;
		
		$body = $obj->mailBody($contact_message);
		
		$from = SITE_EMAIL;
		$to   = ADMIN_EMAIL;
		$subject = "Contact Us - ".MAIL_THANK_YOU;
		
		$obj->sendMail($to,$subject,$body,$from,"Admin",$type);
		$_SESSION['messageClass'] = "successClass";	
		$obj->add_message("message","We have successfully received your request. We will contact you soon.!");
	}
}
///////////////////////////////Post Comments//////////////////////////////////////
if(isset($_POST['replyComment']) && $_POST['replyComment']=='Reply')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['comment'])=="") {$obj->add_message("message","Reply Should Not Be Blank!");}
	if($obj->get_message("message")=="")
	{
			$newComment=array();
			$newComment['comment']=$_POST['comment'];
			$newComment['blog_id']=$_POST['blog_id'];
			$newComment['user_id']=$_SESSION['user']['user_id'];
			$newComment['comment_add_date']=date("Y-m-d h:i:s");
			
			$row=$obj->insertData(TABLE_BLOGCOMMENT,$newComment);
						
			$obj->add_message("message","Comment Posted Successfully.");
			$_SESSION['messageClass'] = "successClass";
			$_POST = "";
			$obj->reDirect("index.php");
	}
}

//++++++++++++++++++++++++++++++++++++++++END++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////Post Hot Spot Comments//////////////////////////////////////
if(isset($_POST['hotComment']) && $_POST['hotComment']=='Post')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['spot_comment'])=="") {$obj->add_message("message","Comment Should Not Be Blank!");}
	//if(trim($_POST['spot_comment'])=="") {$obj->add_message("message","Comment Should Not Be Blank!");}
	if($obj->get_message("message")=="")
	{
			$spot_id=$_POST['spot_id'];
			$type_id=$_POST['type_id'];
			$newComment=array();
			$newComment['spot_comment']=$_POST['spot_comment'];
			$newComment['spot_id']=$_POST['spot_id'];
			$newComment['is_like']=$_POST['is_like'];
			$newComment['user_id']=$_SESSION['user']['user_id'];
			$newComment['comment_add_date']=date("Y-m-d h:i:s");
			
			$row=$obj->insertData(TABLE_SPOTCOMMENT,$newComment);
						
			$obj->add_message("message","Comment Posted Successfully.");
			$_SESSION['messageClass'] = "successClass";
			$_POST = "";
			//$obj->reDirect("post_comment.php?id=$spot_id");
			$obj->reDirect("hotspot.php?type_id=$type_id");
	}
}

//++++++++++++++++++++++++++++++++++++++++END++++++++++++++++++++++++++++++++++++++++++++++++

if(isset($_POST['btnSubmitRequest']))
{

	$_SESSION['messageClass'] = 'errorClass';
	if(trim($_POST['inv_first_name1'])=="") {$obj->add_message("message","First Name 1 Should Not Be Blank!");}
	if(trim($_POST['inv_last_name1'])=="") {$obj->add_message("message","Last Name 1 Should Not Be Blank!");}
	if(trim($_POST['inv_email1'])=="") {$obj->add_message("message","Email 1 Should Not Be Blank!");}
	if(!$obj->check_email_address(trim($_POST['inv_email1']))) {$obj->add_message("message","Email 1 Should Be Valid!");}
	
	if(trim($_POST['inv_first_name2'])=="") {$obj->add_message("message","First Name 2 Should Not Be Blank!");}
	if(trim($_POST['inv_last_name2'])=="") {$obj->add_message("message","Last Name 2 Should Not Be Blank!");}
	if(trim($_POST['inv_email2'])=="") {$obj->add_message("message","Email 2 Should Not Be Blank!");}
	if(!$obj->check_email_address(trim($_POST['inv_email2']))) {$obj->add_message("message","Email 2 Should Be Valid!");}
	
	if(trim($_POST['inv_first_name3'])=="") {$obj->add_message("message","First Name 3 Should Not Be Blank!");}
	if(trim($_POST['inv_last_name3'])=="") {$obj->add_message("message","Last Name 3 Should Not Be Blank!");}
	if(trim($_POST['inv_email3'])=="") {$obj->add_message("message","Email 3 Should Not Be Blank!");}
	if(!$obj->check_email_address(trim($_POST['inv_email3']))) {$obj->add_message("message","Email 3 Should Be Valid!");}
	
	
	$_SESSION['site_name'] = SITE_NAME;
	$_SESSION['site_url']  = SITE_TITLE;
	
	if($obj->get_message("message")=="")
	{
		$_POST['inv_req_date'] = CURRENT_DATE_TIME;
		for($i=1;$i<=3;$i++)
		{
			$arrIU['inv_user_id'] = $_SESSION['current_user_id'];
			if($_POST['inv_first_name'.$i]!="" && $_POST['inv_last_name'.$i]!="" && $_POST['inv_email'.$i]!="")
			{
				
				if(invUsed($_POST['inv_email'.$i])){$obj->add_message("message","Email-id [".$_POST['inv_email'.$i]."] is already requested!");}
				$arrIU['inv_first_name'] = $_POST['inv_first_name'.$i];
				$arrIU['inv_last_name']  = $_POST['inv_last_name'.$i];
				$arrIU['inv_email']      = $_POST['inv_email'.$i];
				$sqlIS = $obj->insertData(TABLE_INVITATION,$arrIU);
				$_SESSION['inv_req_id'] = mysql_insert_id();
				
				$_SESSION['user_fname'] = $_POST['inv_first_name'.$i];
				$_SESSION['user_lname'] = $_POST['inv_last_name'.$i];
				$_SESSION['user_name'] = $_POST['inv_first_name'.$i]." ".$_POST['inv_last_name'.$i];
				$_SESSION['user_email'] = $_POST['inv_email'.$i];
				
				$body = $obj->mail_content($_SESSION);

				$subject = $_SESSION['current_user_name'].' invited you to join '.SITE_NAME;
				$obj->sendMail($arrIU['inv_email'],$subject,$body,$_SESSION['user_email'],SITE_NAME,$type);
			}
		}
		
		$obj->add_message("message","Your invitation is successfully sent to the specified users!");
		$_SESSION['messageClass'] = 'successClass';
		$obj->reDirect("thank_you.php");		
	}

}
////////////////////////////////////Shipping Address//////////////////////////////////////

if(isset($_POST['confirm_order']))
{
	$_SESSION['messageClass'] = 'errorClass';
	if(trim($_POST['order_studio_name'])=="") {$obj->add_message("message","Studio Name Should Not Be Blank!");}
	if(trim($_POST['order_owner_fname'])=="") {$obj->add_message("message","Owner First Name Should Not Be Blank!");}
	if(trim($_POST['order_owner_lname'])=="") {$obj->add_message("message","Owner Last Name Should Not Be Blank!");}
	if(trim($_POST['order_pri_contact'])=="") {$obj->add_message("message","Owner Primary Contact Should Not Be Blank!");}
	if(trim($_POST['order_busines_ph'])=="") {$obj->add_message("message","Owner Business Phone Should Not Be Blank!");}
	if(trim($_POST['order_business_email'])=="") {$obj->add_message("message","Business Email Should Not Be Blank!");}
	if(!$obj->check_email_address(trim($_POST['order_business_email']))) {$obj->add_message("message","Business Email Should Be Valid!");}
	
	if(trim($_POST['order_card'])=="") {$obj->add_message("message","Credit Card Number Should Not Be Blank!");}
	if(trim($_POST['order_ex_date'])=="") {$obj->add_message("message","Card Expiry Date Should Not Be Blank!");}
	if(trim($_POST['order_cvv'])=="") {$obj->add_message("message","Credit Card CVV Should Not Be Blank!");}
	

	if(trim($_POST['order_bill_st_add'])=="") {$obj->add_message("message","Billing Street Address Should Not Be Blank!");}
	if(trim($_POST['order_bill_city'])=="") {$obj->add_message("message","Billing City Should Not Be Blank!");}
	if(trim($_POST['order_bill_state'])=="") {$obj->add_message("message","Billing State Should Not Be Blank!");}
	if(trim($_POST['order_bill_zip'])=="") {$obj->add_message("message","Billing Zip Should Not Be Blank!");}
	
	if($obj->get_message("message")=="")
	{
		$_SESSION['order'] = $_POST;
		$_SESSION['messageClass'] = 'successClass';
		$obj->reDirect("confirm.php");
	}
}
///////////////////////////////Post Event//////////////////////////////////////
if(isset($_POST['post_event']) && $_POST['post_event']=='Post')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['event_title'])=="") {$obj->add_message("message","Event Title Should Not Be Blank!");}
	if(trim($_POST['event_date'])=="") {$obj->add_message("message","Event Date Should Not Be Blank!");}
	if(trim($_POST['event_time'])=="") {$obj->add_message("message","Event Time Should Not Be Blank!");}
	if(trim($_POST['event_desc'])=="") {$obj->add_message("message","Event Description Should Not Be Blank!");}
	
	if($obj->get_message("message")=="")
	{
			$newComment=array();
			$newComment['event_title']=$_POST['event_title'];
			$newComment['event_date']=$_POST['event_date'];
			$newComment['event_time']=$_POST['event_time'];
			$newComment['event_location']=$_POST['event_location'];
			$newComment['event_desc']=$_POST['event_desc'];
			$newComment['user_id']=$_SESSION['user']['user_id'];
			$newComment['event_add_date']=date("Y-m-d h:i:s");
			
			$row=$obj->insertData(TABLE_EVENT,$newComment);
						
			$obj->add_message("message","Event Posted Successfully.");
			$_SESSION['messageClass'] = "successClass";
			$_POST = "";
			$obj->reDirect("events.php");
	}
}

//++++++++++++++++++++++++++++++++++++++++END++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////Post Event Comments//////////////////////////////////////
if(isset($_POST['eventComment']) && $_POST['eventComment']=='Post')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['ecomment'])=="") {$obj->add_message("message","Comment Should Not Be Blank!");}
	if($obj->get_message("message")=="")
	{
			$newComment=array();
			$newComment['ecomment']=$_POST['ecomment'];
			$newComment['event_id']=$_POST['event_id'];
			$newComment['user_id']=$_SESSION['user']['user_id'];
			$newComment['ecomment_add_date']=date("Y-m-d h:i:s");
			
			$row=$obj->insertData(TABLE_EVENTCOMMENT,$newComment);
						
			$obj->add_message("message","Comment Posted Successfully.");
			$_SESSION['messageClass'] = "successClass";
			$_POST = "";
			$obj->reDirect("events.php");
	}
}

//++++++++++++++++++++++++++++++++++++++++END++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////Post Hot Spot//////////////////////////////////////
if(isset($_POST['post_hotspot']) && $_POST['post_hotspot']=='Post')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['type_id'])=="") {$obj->add_message("message","Type Should Not Be Blank!");}
	if(trim($_POST['state_id'])=="") {$obj->add_message("message","State Should Not Be Blank!");}
	if(trim($_POST['zip_id'])=="") {$obj->add_message("message","Zip Should Not Be Blank!");}
	if(trim($_POST['spot_name'])=="") {$obj->add_message("message","Spot Name Should Not Be Blank!");}
	if(trim($_POST['spot_desc'])=="") {$obj->add_message("message","Description Should Not Be Blank!");}
	
	if($obj->get_message("message")=="")
	{
			$newComment=array();
			$id=$_POST['type_id'];
			$newComment['type_id']=$_POST['type_id'];
			$newComment['state_id']=$_POST['state_id'];
			$newComment['zip_id']=$_POST['zip_id'];
			$newComment['spot_name']=$_POST['spot_name'];
			$newComment['spot_desc']=$_POST['spot_desc'];
			$newComment['user_id']=$_SESSION['user']['user_id'];
			
			
			if($_FILES['spot_image']['tmp_name'])
			{
				list($fileName1,$error)=$obj->uploadFile('spot_image',SPOT_IMG, 'gif,jpg,png,jpeg');
				if($error)
				{
					$msg=$error;
					$err=1;
				}
				else
				{
					$_POST['spot_image']=$fileName1;
					$newComment['spot_image']=$fileName1;
				}
			}
			
			if($_POST['spot_id'])
			{
				//$_POST['spot_mod_date']=CURRENT_DATE_TIME;
				//$obj->updateData(TABLE_HOTSPOT,$_POST," spot_id='".$spot_id."'");
				$newComment['spot_mod_date']=date("Y-m-d h:i:s");
				$row=$obj->updateData(TABLE_HOTSPOT,$newComment," spot_id='".$_POST['spot_id']."'");
				$obj->add_message("message","HotSpot Updated Successfully!");
				$_SESSION['messageClass'] = 'success';
			}
			else
			{
				$newComment['spot_add_date']=date("Y-m-d h:i:s");
				$row=$obj->insertData(TABLE_HOTSPOT,$newComment);
				$obj->add_message("message","Hot Spot Posted Successfully.");
				$_SESSION['messageClass'] = "successClass";
				$_POST = "";
			}
			$obj->reDirect("hotspot.php?type_id=".$id);
	}
}

//++++++++++++++++++++++++++++++++++++++++END++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////Post Blog//////////////////////////////////////
if(isset($_POST['post_blog']) && $_POST['post_blog']=='Post')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['blogcat_id'])=="") {$obj->add_message("message","Blog Category Should Not Be Blank!");}
	if(trim($_POST['blog_title'])=="") {$obj->add_message("message","Blog Title Should Not Be Blank!");}
	if(trim($_POST['blog_detail'])=="") {$obj->add_message("message","Description Should Not Be Blank!");}
	
	if($obj->get_message("message")=="")
	{
			$newComment=array();
			$id=$_POST['type_id'];
			$newComment['blogcat_id']=$_POST['blogcat_id'];
			$newComment['blog_title']=$_POST['blog_title'];
			$newComment['blog_detail']=$_POST['blog_detail'];
			$newComment['posted_by']=$_SESSION['user']['user_id'];
			$newComment['blog_add_date']=date("Y-m-d H:i:s");
			
			if($_FILES['blog_image']['tmp_name'])
			{
				list($fileName1,$error)=$obj->uploadFile('blog_image',BLOG_IMG, 'gif,jpg,png,jpeg');
				if($error)
				{
					$msg=$error;
					$err=1;
				}
				else
				{
					$_POST['blog_image']=$fileName1;
					$newComment['blog_image']=$fileName1;
				}
			}
			
			$row=$obj->insertData(TABLE_BLOG,$newComment);
						
			$obj->add_message("message","Your Blog Has Been Posted Successfully.");
			$_SESSION['messageClass'] = "successClass";
			$_POST = "";
			$obj->reDirect("index.php");
	}
}

//++++++++++++++++++++++++++++++++++++++++END++++++++++++++++++++++++++++++++++++++++++++++++

?>