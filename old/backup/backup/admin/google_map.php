<?php
require_once("../includes/connection.php");
adminSecure();
$_SESSION['messageClass'] = "error";
if(isset($_POST['btnSubmit']))
{
	
	if($_FILES['gImage']['tmp_name'])
	{
		list($fileName1,$error)=$obj->uploadFile('gImage', "../".GI, 'gif,jpg,png,bmp');
		if($error)
		{
			$msg=$error;
			$err=1;
			$obj->add_message("message",$msg);
		}
		else
		{
			$_POST['google_image'] = $fileName1;
			$obj->updateData(TABLE_GOOGLE_MAP,$_POST,"google_id='1'");
			$msg=UPDATE_SUCCESSFULL;
			$_SESSION['messageClass'] = "success";
			$obj->add_message("message",$msg);
		}
	}

}

$googleD = $obj->selectData(TABLE_GOOGLE_MAP,"","google_id ='1'",1);
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
			google_address: {
				required: true
			},
			gImage: {
				required: true
			}						
		},
		messages: {
			google_address: {
				required: "Please enter the address"
			},
			gImage: {
				required: "Please select an image"
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
                <h3 class="icon-head head-promo-catalog">Goole Map Details</h3></td>
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
                    <td width="20%" align="left" valign="middle" class="bodytext">Map Address </td>
                    <td align="left" valign="middle" class="bodytext">
                    <input name="google_address" type="text" class="field_gray" id="google_address" value="<?=$googleD['google_address'];?>" size="40" maxlength="50" />
                   </td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Map 
                      Image  :</td>
                    <td align="left" valign="middle" class="bodytext"><input type="file" name="gImage" /></td>
                  </tr>
				  <? if($googleD['google_image']!=""){?>
				  <tr class="box-bg">
                          <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                          <td align="left" valign="middle">
						 <?=$obj->getImageThumb(GI,$googleD['google_image'],'','','100','100','../');?>					  </td>
                  </tr>
				  <? }?>
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