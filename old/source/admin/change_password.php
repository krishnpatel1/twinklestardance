<?php
require_once("../includes/connection.php");
adminSecure();
if(isset($_POST['btnSubmit'])){
	$admin_id		= $_SESSION['admin']['admin_id'];
	$old_password	= $_POST['old_admin_pass'];
	$new_password	= $_POST['admin_pass'];
	$_SESSION['messageClass'] = "error";
	$pass_matched	= $obj->selectData(TABLE_ADMIN,"","admin_id='".$admin_id."' and admin_password='".$old_password."'",1);
	if($pass_matched){
		$ch_pass_arr	= array('admin_password'=>$new_password);
		$obj->updateData(TABLE_ADMIN,$ch_pass_arr,"admin_id='".$admin_id."'");
		$msg = PASSWORD_CHANGED;
		$_SESSION['messageClass'] = "success";
	}else{
		$msg = PASSWORD_MISMATCH;
	}
	$obj->add_message("message",$msg);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<script language="javascript">
$(document).ready(function() {
	var prevUrl="<?=$return_url ?>";
	
	 $("#frm").validate({
		rules: {
			admin_pass: {
				required: true,
			},
			re_admin_pass: {
				required: true,
				equalTo: "#admin_pass"
			}
		},
		messages: {
			re_admin_pass: {
				required: "Repeat New Password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			}
		}
	});
	
	
	$("#btnCancel").click(function(){
			window.location.replace(prevUrl);
	});
});
</script>
</head>
<body id="html-body" class=" adminhtml-promo-catalog-index">
 <?php include('head.php'); ?>
  <div class="middle" id="anchor-content">
    <div id="">
      <div class="content-header">
	  <table width="100%" cellspacing="0">
          <tbody>
            <tr>
              <td><img src="images/icon/change_password.gif" alt="Change Password" width="24" height="24" border="0" class="admin_icon"/>
                <h3 class="icon-head head-promo-catalog"> Change Password</h3></td>
              <td class="form-buttons">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>
	  <div>
        <div id="promo_catalog_grid">
          <div class="grid">
            <div class="hor-scroll">
              <?=$obj->display_message("message");?>
              <form action="" method="post" enctype="multipart/form-data" name="frm" id="frm">
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">
                  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Old
                      Password   :</td>
                    <td align="left" valign="middle" class="bodytext"><input name="old_admin_pass" type="password" class="field_gray required" id="old_admin_pass" size="40" maxlength="50" /></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">New
                      Password   :</td>
                    <td align="left" valign="middle" class="bodytext"><input name="admin_pass" type="password" class="field_gray" id="admin_pass" size="40" maxlength="50" /></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Confirm
                      Password   :</td>
                    <td align="left" valign="middle" class="bodytext"><input name="re_admin_pass" type="password" class="field_gray" id="re_admin_pass" size="40" maxlength="50" /></td>
                  </tr>
                  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">&nbsp;</td>
                    <td align="left" valign="middle">
					  <input name="btnSubmit" type="submit" class="button" id="btnSubmit" value="Save" />
                      <input name="btnCancel" type="button" class="button" id="btnCancel" value="Cancel"/>
                      <span class="bodytext"> </span></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>
</html>