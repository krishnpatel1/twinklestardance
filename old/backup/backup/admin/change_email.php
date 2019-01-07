<?php
require_once("../includes/connection.php");
adminSecure();
$_SESSION['messageClass'] = "error";
if(isset($_POST['btnSubmit'])){
	$admin_id		= $_SESSION['admin']['admin_id'];
	$_SESSION['messageClass'] = "success";
	
	$obj->updateData(TABLE_ADMIN,$_POST,"admin_id='".$admin_id."'");
	$msg=UPDATE_SUCCESSFULL;
	
	$obj->add_message("message",$msg);
}

$admin_details=$obj->selectData(TABLE_ADMIN,"","admin_id='".$_SESSION['admin']['admin_id']."'",1);
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
			admin_email: {
				required: true,
				email: true
			}
		},
		messages: {
			admin_email: {
				required: "Enter a valid email address.",
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
                <h3 class="icon-head head-promo-catalog"> Change Email</h3></td>
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
                    <td width="20%" align="left" valign="middle" class="bodytext">Email Address   :</td>
                    <td align="left" valign="middle" class="bodytext"><input name="admin_email" type="text" class="admin_email" id="admin_email" size="40" maxlength="50" value="<?php echo $admin_details['admin_email']?>" /></td>
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