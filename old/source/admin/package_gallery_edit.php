<?php
require_once("../includes/connection.php");
adminSecure();
$category_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'package_gallery_management.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	/*if($category_id)
	{
		$ex_cond=" and product_id!='".$product_id."'";
	}*/
	
	if(!$err){
		if($_FILES['category_image']['tmp_name']){
			list($fileName1,$error)=$obj->uploadFile('category_image', "../".GALLERY, 'gif,jpg,png,jpeg');
			if($error){
				$msg=$error;
				$err=1;
			}else{
				$_POST['category_image']=$fileName1;
			}
		}
	}

	if(!$err)
	{
		if($category_id)
		{
			$obj->updateData(TABLE_GALLERY_CATEGORY,$_POST,"category_id='".$category_id."'");
			$obj->add_message("message","Gallery Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			$_POST['category_add_date']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_GALLERY_CATEGORY,$_POST);
			$obj->add_message("message","Gallery Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($category_id!="")
{
	$data = $obj->selectData(TABLE_GALLERY_CATEGORY,"","category_id='".$category_id."'",1);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<script language="javascript">
$(document).ready(function() {
	var prevUrl="<?=$return_url ?>";
	$("#frm").validate();	

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
                  <? if($category_id){?>Edit<? }else{?>Add<? }?> Gallery</h3></td>
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
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Name:</td>
                    <td align="left" valign="middle" class="bodytext">
					 	<input type="text" name="category_name" id="category_name" class="required" value="<?php echo $data['category_name']; ?>" />
					  	&nbsp;<span style="color:#FF0000;">*</span>
					  </td>
                  </tr>
				
				  
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext"> Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="category_status" value="Active" checked="checked"> Active 
					<input type="radio" name="category_status" value="Inactive" <? if($data['category_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive</td>
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
