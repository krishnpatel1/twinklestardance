<?php
include("includes/connection.php");
include("includes/all_form_check.php");
include("includes/message.php");

if(isset($_POST['login_submit']))
{
	$user_msg='';
	if(trim($_POST['user_first_name'])=='') { $user_msg.='Please provide first name.<br />'; }
	if(trim($_POST['user_last_name'])=='') { $user_msg.='Please provide last name.<br />'; }
	if(trim($_POST['user_email'])=='') { $user_msg.='Please provide email address.<br />'; }
	if(!isEmail(trim($_POST['user_email']))) { $user_msg.='Please provide proper email address.<br />'; }
	if($obj->selectData(TABLE_USER,"","user_email='".trim($_POST['user_email'])."' and user_status<>'Deleted'",1)) { $user_msg.='Email address already exists.<br />'; }
	if(trim($_POST['user_password'])=='') { $user_msg.='Please provide password.<br />'; }
	if(trim($_POST['user_phone'])=='') { $user_msg.='Please provide phone.<br />'; }
	if(trim($_POST['user_add_1'])=='') { $user_msg.='Please provide address 1.<br />'; }
	if(trim($_POST['user_country'])=='') { $user_msg.='Please provide country.<br />'; }
	if(trim($_POST['user_city'])=='') { $user_msg.='Please provide city.<br />'; }
	if(trim($_POST['user_zip'])=='') { $user_msg.='Please provide zip.<br />'; }
	
	if($user_msg=='') {
		$_POST['user_reg_date']=date("Y-m-d H:i:s");
		$_POST['user_mod_date']=date("Y-m-d H:i:s");
		$com_id=$obj->insertData(TABLE_USER,$_POST);
		$_SESSION['user_msg']='You have successfully registered to our website.';
		$obj->reDirect('register.php');
	}	
	else {
		$_SESSION['user_msg']=$user_msg;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
<script language="javascript">
	$(document).ready((function){
		$("#frm").validate();
	});
</script>
</head>

<body <?php if(!isset($_SESSION['user'])) {?>style="background:#fff url(images/bg.jpg) left top repeat-x;"<?php } ?>>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="205" align="left" valign="top">
	<? include("page_includes/header.php")?>
	</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  align="left" valign="top"><? include("page_includes/slide.php")?></td>
      </tr>
       <?php if(!isset($_SESSION['user'])) {?>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
	  <?php }?>
      <tr>
        <td align="left" valign="top">
		<? include("page_includes/banners.php") ?>
		</td>
      </tr>
       <?php if(!isset($_SESSION['user'])) {?>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
	  <?php }?>
      <tr>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1>Register</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
				
				<!--Via phone (925) 447-5299<br /><br />
				Via email: <a href="mailto:info@twinklestardance.com">info@twinklestardance.com</a><br /><br />
				Via facebook:  <a href="https://www.facebook.com/pages/Twinkle-Star-Dance-Program/244317095622502" target="_blank">https://www.facebook.com/pages/Twinkle-Star-Dance-Program/244317095622502</a>-->				</td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              
			  
			  
              <tr>
                <td align="left" valign="top" class="home_content">
					
				<form name="frm" id="frm" method="post" action="" class="contact-form">
                <? if($_SESSION['user_msg']!=""){ echo $_SESSION['user_msg']; unset($_SESSION['user_msg']); }?>
				<br />
				<label>First Name <span class="red">*</span></label>
				<input type="text" name="user_first_name" id="user_first_name" class="required" value="<?=$_POST['user_first_name']?>" />
				
				<label>Last Name <span class="red">*</span></label>
				<input type="text" name="user_last_name" id="user_last_name" class="required" value="<?=$_POST['user_last_name']?>" />
				
				<label>Email <span class="red">*</span></label>
				<input type="text" name="user_email" id="user_email" class="required" value="<?=$_POST['user_email']?>" />
				
				<label>Password <span class="red">*</span></label>
				<input type="password"  name="user_password" id="user_password" class="required" value="<?=$_POST['user_password']?>"/>
				
				<label>Phone <span class="red">*</span></label>
				<input type="text" name="user_phone" id="user_phone" class="required" value="<?=$_POST['user_phone']?>" />
				
				<label>Address 1 <span class="red">*</span></label>
				<textarea name="user_add_1" id="user_add_1" class="required"><?=$_POST['user_add_1']?></textarea>
				
				<label>Address 2 <span class="red"></span></label>
				<textarea name="user_add_2" id="user_add_2"><?=$_POST['user_add_2']?></textarea>
				
				<label>Country <span class="red">*</span></label>
				<select name="user_country" id="user_country" style="width:205px;" class="selectbox required">
				<option value="">---Select---</option>
				<?=$obj->countrySelect($_POST['user_country'])?>
				</select>
				<br /><br />
				<label>City <span class="red">*</span></label>
				<input type="text" name="user_city" id="user_city" class="required" value="<?=$_POST['user_city']?>" />
				
				<label>Zip <span class="red">*</span></label>
				<input type="text" name="user_zip" id="user_zip" class="required" value="<?=$_POST['user_zip']?>" />
				
				<label><span class="red">*</span> Required Fields</label>
				<input type="submit" name="login_submit" class="submit" value="Submit" />
				</form>
				</td>
              </tr>
			  
            </table>
			</td>
            <td width="7" align="left" valign="top">&nbsp;</td>
            <td width="240" align="left" valign="top"><? include("page_includes/right.php")?></td>
          </tr>
        </table>
		</td>
      </tr>
             <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
    </table>
	
	</td>
  </tr>
  <tr>
    <td height="80" align="left" valign="top" class="footer">
	<?php include("page_includes/footer.php"); ?>
	</td>
  </tr>
</table>
</body>
</html>
