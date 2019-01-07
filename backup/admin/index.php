<?php
include("../includes/connection.php");
if(isset($_SESSION['admin'])||!isset($_SESSION['admin_request_page']))
{
	$_SESSION['admin_request_page']="adminhome.php";
}

$_SESSION['messageClass'] = 'error';
if(isset($_POST['btnSignIn']) && $_POST['btnSignIn']=='Login')
{
	$admin_user_name=$_POST['username'];
	$admin_password=$_POST['password'];
	$admin_login=$obj->selectData(TABLE_ADMIN,"","BINARY admin_username='".$admin_user_name."' and BINARY admin_password='".$admin_password."' and admin_status='Active'",1);
	if($admin_login)
	{
		$_SESSION['admin']=$admin_login;
		$_SESSION['ADMINTYPE']='A';
		$_SESSION['messageClass'] = 'success';
	}
	else
	{
		$obj->add_message("message","Invalid Login Details!");
	}

}
if(isset($_SESSION['admin']))
{
	$obj->reDirect($_SESSION['admin_request_page']);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php
include('common_head.php');
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#frmLogin").validate({
		rules: {
			username: {
				required: true
			},
			password: {
				required: true
			}
		},
		messages: {
			
			username: {
				required: "username required"
			},
			password: {
				required: "provide password"
			}
		}
	});
});
</script>
</head>
<body id="html-body" class=" adminhtml-promo-catalog-index">
 <?php include('head.php'); ?>
  <div class="middle" id="anchor-content">
    <div id="promo_catalog_grid">
      
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td align="center" valign="middle" ><table width="50%" border="0" cellspacing="2" cellpadding="0" align="center" style="margin-top:40px;">
  <tr>
    <td align="left" valign="middle" class="login_head"><strong>Admin Control Panel </stong></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><form name="frmLogin" id="frmLogin" method="post" action=""><table width="100%" border="0" cellspacing="3" cellpadding="3" class="box">
  <tr>
    <td colspan="2" align="left" valign="top"><?=$obj->display_message("message");?></td>
    </tr>
  <tr>
    <td width="25%" align="right" valign="top"> <label for="login" >User Name:</label></td>
    <td align="left" valign="top"><input name="username" type="text" class="required-entry input-text" id="login" size="35"></td>
  </tr>
  <tr>
    <td align="right" valign="top"><label for="passwd">Password: </label></td>
    <td align="left" valign="top"><input name="password" type="password" class="required-entry input-text"  id="passwd" size="35"></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><input name="btnSignIn" type="submit" id="btnSignIn" value="Login" class="submit"></td>
  </tr>
</table></form></td>
  </tr>
</table></td>
  </tr>
</table>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>
