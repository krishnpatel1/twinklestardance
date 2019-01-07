<?php
require_once("../includes/connection.php");
adminSecure();
$gallery_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'package_video_management.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	/*if($gallery_id)
	{
		$ex_cond=" and product_id!='".$product_id."'";
	}*/
	
	if(!$err){
		if($_FILES['gallery_image']['tmp_name']){
			list($fileName1,$error)=$obj->uploadFile('gallery_image', "../".GALLERY, 'gif,jpg,png,jpeg');
			if($error){
				$msg=$error;
				$err=1;
			}else{
				$_POST['gallery_image']=$fileName1;
			}
		}
	}

	if(!$err)
	{
		//$categories = implode(",",$_POST['gallery_category_id']);
		//$_POST['gallery_category_id'] = $categories;

		if($gallery_id)
		{
			$gallery_cat=",".implode(',',$_POST['gallery_category_id']).",";
			$_POST['gallery_category_id']=$gallery_cat;
			$_POST['date_edited']=CURRENT_DATE_TIME;
			$obj->updateData(TABLE_GALLERY,$_POST,"gallery_id='".$gallery_id."'");
			$obj->add_message("message","Video Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			//$_POST['gallery_category_id']=implode(',',$_POST['gallery_category_id']);
			$gallery_cat=",".implode(',',$_POST['gallery_category_id']).",";
			$_POST['gallery_category_id']=$gallery_cat;
			$_POST['date_added']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_GALLERY,$_POST);
			$obj->add_message("message","Video Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($gallery_id!="")
{
	$data = $obj->selectData(TABLE_GALLERY,"","gallery_id='".$gallery_id."'",1);
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
                  <? if($gallery_id){?>Edit<? }else{?>Add<? }?> Video</h3></td>
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
                    <td width="20%" align="left" valign="middle" class="bodytext">Video Title:</td>
                    <td align="left" valign="middle" class="bodytext">
					 	<input type="text" name="gallery_name" id="gallery_name" value="<?php echo $data['gallery_name']; ?>" class="required" style="width:300px;" />
					  	&nbsp;<span style="color:#FF0000;">*</span>
					  </td>
                  </tr>
				<tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Image Icon Script:</td>
                    <td align="left" valign="middle" class="bodytext">
					 	<textarea name="image_code" id="image_code" class="required" rows="5" cols="50"><?=$data['image_code']?></textarea>
					  	&nbsp;<span style="color:#FF0000;">*</span>
					  </td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Video Script:</td>
                    <td align="left" valign="middle" class="bodytext">
					 	<textarea name="gallery_code" id="gallery_code" class="required" rows="5" cols="50"><?=$data['gallery_code']?></textarea>
					  	&nbsp;<span style="color:#FF0000;">*</span><br/><br style="line-height:2px;"/>
						<b>Please upload video script of Size <span style="color:#FF0000;">425 X 250 </span></b>
					  </td>
                  </tr>
				   <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Video Description:</td>
                    <td align="left" valign="middle" class="bodytext">
					 	<?php /*?><textarea name="gallery_desc" id="gallery_desc" rows="5" cols="50"><?=$data['gallery_desc']?></textarea><?php */?>
					  <? 
							require_once(FCKPATH.'/fckeditor.php');
							$oFCKeditor = new FCKeditor('gallery_desc') ;
							$oFCKeditor->BasePath	=FCK_PATH."/" ;
							$oFCKeditor->Height	= 300 ;
							$oFCKeditor->Width	= 500 ;
							$oFCKeditor->Value	=html_entity_decode($data['gallery_desc']);								
							$oFCKeditor->Create() ; 
					  ?>
					  </td>
                  </tr>
				   <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Gallery Category:</td>
                    <td align="left" valign="middle" class="bodytext">
						<select name="gallery_category_id[]" multiple="multiple" id="gallery_category_id" class="required" style="width:300px; height:150p;">
					 	<?php echo $obj->getGalleryListSelect($data['gallery_category_id']);?>
						</select>
					  	&nbsp;<span style="color:#FF0000;">*</span>
					  </td>
                  </tr>
				  <?php /*?><tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Video Image :</td>
                    <td align="left" valign="middle" class="bodytext"><input type="file" name="gallery_image" /></td>
                  </tr>
				  <? if($data['gallery_image']!=""){?>
				  <tr class="box-bg">
                          <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                          <td align="left" valign="middle">
						 <?=$obj->getImageThumb(GALLERY,$data['gallery_image'],'','','100','100','../');?></td>
                  </tr>
				  <? }?><?php */?>
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext"> Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="gallery_status" value="Active" checked="checked"> Active 
					<input type="radio" name="gallery_status" value="Inactive" <? if($data['gallery_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive</td>
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
