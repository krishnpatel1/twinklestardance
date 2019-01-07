<?php
/* Online Product Add/Edit Page*/
require_once("../includes/connection.php");
adminSecure();
$product_id = $_REQUEST['id'];
$return_url = urldecode($_REQUEST['return_url']);
$return_url = $return_url?$return_url:'online_product_management.php';

if($_POST['btnSubmit']=='Save'){

	$_SESSION['messageClass'] = 'error';
	$data = $obj->filterData_array($_POST);
	if($product_id){
		$ex_cond = " and product_id!='".$product_id."'";
	}
	
	if(!$err){
		if($_FILES['product_image']['tmp_name']){
			list($fileName1,$error) = $obj->uploadFile('product_image', "../".ONLINE_PRODUCT, 'gif,jpg,png,jpeg');
			if($error){
				$msg = $error;
				$err = 1;
			}else{
				$_POST['product_image'] = $fileName1;
			}
		}
	}
	
	if(!$err){
		if($product_id){
			$_POST['date_edited'] = CURRENT_DATE_TIME;
			$obj->updateData(TABLE_ONLINE_PRODUCT,$_POST,"product_id='".$product_id."'");
			$obj->add_message("message","Online Product Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			$_POST['date_added'] = CURRENT_DATE_TIME;
			$obj->insertData(TABLE_ONLINE_PRODUCT,$_POST);
			$obj->add_message("message","Online Product Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
	
}
if($product_id!=""){
	$data = $obj->selectData(TABLE_ONLINE_PRODUCT,"","product_id='".$product_id."'",1);
	$productName = $data['product_name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<script>
$(document).ready(function(){
	$("#frm").validate();
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
                <? if($product_id){?>
                Edit
                <? }else{?>
                Add
                <? }?>
                Download Product
                <? if($data['product_title']){?>
                [
                <?=$data['product_title'];?>
                ]
                <? }?>
              </h3></td>
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
                  <td width="20%" align="left" valign="middle" class="bodytext">Product
                    Title  :</td>
                  <td align="left" valign="middle" class="bodytext"><input name="product_name" type="text" class="field_gray required" id="product_name" value="<?=$data['product_name'];?>" size="40" maxlength="50" />
                    &nbsp;<span style="color:#FF0000;">*</span> </td>
                </tr>
                <tr class="box-bg">
                  <td width="20%" align="left" valign="middle" class="bodytext">Product Description:</td>
                  <td align="left" valign="middle" class="bodytext"><? 
							require_once(FCKPATH.'/fckeditor.php');
							$oFCKeditor = new FCKeditor('product_description') ;
							$oFCKeditor->BasePath	=FCK_PATH."/" ;
							$oFCKeditor->Height	= 300 ;
							$oFCKeditor->Width	= 500 ;
							$oFCKeditor->Value	=html_entity_decode($data['product_description']);								
							$oFCKeditor->Create() ; 
					  ?>
                     </td>
                </tr>

                <tr class="box-bg">
                  <td width="20%" align="left" valign="middle" class="bodytext">Product Image :</td>
                  <td align="left" valign="middle" class="bodytext"><input type="file" name="product_image" /></td>
                </tr>
                <? if($data['product_image']!=""){?>
                <tr class="box-bg">
                  <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                  <td align="left" valign="middle"><?=$obj->getImageThumb(ONLINE_PRODUCT,$data['product_image'],'','','100','100','../');?></td>
                </tr>
                <? }?>
                <tr class="box-bg">
                  <td align="left" valign="middle" class="bodytext">Product Status  :</td>
                  <td align="left" valign="middle" class="bodytext"><input type="radio" name="product_status" value="Active" checked="checked">
                    Active
                    <input type="radio" name="product_status" value="Inactive" <? if($data['product_status']=='Inactive'){?>checked="checked"<? } ?>>
                    Inactive</td>
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
