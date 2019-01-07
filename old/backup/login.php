<?php
include("includes/connection.php");
include("includes/all_form_check.php");
include("includes/message.php");

if(isset($_POST['login_submit']))
{
	$user_msg='';
	if(trim($_POST['user_email'])=='') { $user_msg.='Please provide email address.<br />'; }
	if(trim($_POST['user_password'])=='') { $user_msg.='Please provide password.<br />'; }
	
	if($user_msg=='') 
	{
		if($user_login=$obj->selectData(TABLE_USER,"","user_email='".trim(strtolower($_POST['user_email']))."' and BINARY user_password='".trim($_POST['user_password'])."' and user_status='Active'",1))
		{
			$_SESSION['user']=$user_login;
			$obj->reDirect('myaccount.php');
		}
		else
		{
			$user_msg='Invalid username or password!<br />';
		}
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
                <td height="40" align="left" valign="top" class="top_title"><h1>Login</h1></td>
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
                <td height="15" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="home_content" style="color:#ff0000;"><span class="home_content" style="color:#ff0000;">
                      <? if($user_msg!=""){ echo $user_msg;}?>
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              
			  
			  
              <tr>
                <td align="left" valign="top" height="15"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
					
				<form name="frm" id="frm" method="post" action="" class="contact-form">
                
				<label>Email <span class="red">*</span></label>
				<input type="text" name="user_email" id="user_email" class="required" value="<?=$_POST['user_email']?>" />
				<label>Password <span class="red">*</span></label>
				<input type="password"  name="user_password" id="user_password" class="required" value="<?=$_POST['user_password']?>"/>
				<label style="margin:0 0 5px 200px;"><a href="lost_password.php">Lost passwords?</a></label>
				<label><span class="red">*</span> Required Fields</label>
				<input type="submit" name="login_submit" class="submit" value="Submit" />
				</form>				</td>
              </tr>
			  <!--<tr>
                <td align="left" valign="top" class="home_content">
					
				<label><a href="register.php">New User? Register here</a></label>
				</td>
              </tr>-->
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
