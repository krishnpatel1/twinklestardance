<?php
require_once("../includes/connection.php");
adminSecure();
$od_id=$_REQUEST['id'];
$user_id=$_REQUEST['user_id'];
$package_id=$_REQUEST['package_id'];

$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'list_packages.php?user_id'.$user_id;

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	
		if($od_id)
		{
			$package_id=$_POST['package_id'];
			$obj->updateData(TABLE_ORDER_DETAIL,$_POST," od_id='".$od_id."'");
			
			if($_POST['od_package_status']=='Yes')
			{
				$_POST['order_video_status']='Active';
			}
			if($_POST['od_package_status']=='No')
			{
				$_POST['order_video_status']='Inactive';
			}
				
			$obj->updateData(TABLE_ORDER_VIDEO,$_POST,"order_video_package='".$package_id."'");
			
			$obj->add_message("message","Data Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
}

if($od_id!="")
{
	$arr=$obj->selectData(TABLE_ORDER_DETAIL,"","od_id='".$od_id."'",1);
	$data = $obj->selectData(TABLE_PACKAGE,"","package_id='".$arr['od_pro']."'",1);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<script language="javascript">
$(document).ready(function() {
	var prevUrl="<?=$return_url ?>";

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
                <h3 class="icon-head head-promo-catalog">
                  Edit Subscription</h3></td>
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
			  <input type="hidden" name="od_id" value="<?=$od_id?>">
			  <input type="hidden" name="package_id" value="<?=$package_id?>">
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">
                  <?
				  	if(isset($msg) && $msg<>'')
					{
				  ?>
				  <tr class="box-bg">
                    <td width="20%">&nbsp;</td>
                    <td align="left" valign="middle" class="error"><?=$msg?></td>
                  </tr>
				  <? }?>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Name</td>
                    <td align="left" valign="middle" class="bodytext"><?=$data['package_name']?></td>
                  </tr>
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="od_package_status" value="Yes" checked="checked"> Active 
					<input type="radio" name="od_package_status" value="No" <? if($data['od_package_status']=='No'){?>checked="checked"<? } ?>> Inactive
					</td>
                  </tr>
                  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">&nbsp;</td>
                    <td align="left" valign="middle"><input name="btnSubmit" type="submit" class="button" id="btnSubmit" value="Save" />
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

