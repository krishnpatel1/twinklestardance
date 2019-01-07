<?php
require_once("../includes/connection.php");
adminSecure();
$video_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'video_management.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	/*if($video_id)
	{
		$ex_cond=" and product_id!='".$product_id."'";
	}*/
	
	if(!$err)
	{
		if($_FILES['video_image']['tmp_name'])
		{
			list($fileName1,$error)=$obj->uploadFile('video_image', "../".VIDEO, 'gif,jpg,png,jpeg');
			if($error)
			{
				$msg=$error;
				$err=1;
			}
			else
			{
				$_POST['video_image']=$fileName1;
			}
		}
		
	}

	if(!$err)
	{
		if($video_id)
		{
			$obj->updateData(TABLE_VIDEO,$_POST,"video_id='".$video_id."'");
			$obj->add_message("message","Video Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			$_POST['video_add_date']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_VIDEO,$_POST);
			$obj->add_message("message","Video Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($video_id!="")
{
	$data = $obj->selectData(TABLE_VIDEO,"","video_id='".$video_id."'",1);
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
			video_title:{
				required:true
			},
			video_script:{
				required:true
			}
								
		},
		messages: {
			video_title:{
				required: "Please Enter Video Title !"
			},
			video_script: {
				required: "Please Enter Video Script !"
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
                <h3 class="icon-head head-promo-catalog">
                  <? if($video_id){?>Edit<? }else{?>Add<? }?> Video</h3></td>
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
				    <td align="left" valign="middle" class="bodytext">Video Title : </td>
				    <td align="left" valign="middle" class="bodytext"><input type="text" name="video_title" value="<?=$data['video_title']?>"></td>
			      </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Video Script:</td>
                    <td align="left" valign="middle" class="bodytext">
					 	<textarea name="video_script" id="video_script" rows="5" cols="50"><?=$data['video_script']?></textarea>
					  	&nbsp;<span style="color:#FF0000;">*</span><br/><br style="line-height:2px;"/>
						<b>Please upload video script of Size <span style="color:#FF0000;">425 X 250 </span></b>
						
						</td>
                  </tr>
				  
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Video Image :</td>
                    <td align="left" valign="middle" class="bodytext"><input type="file" name="video_image" /></td>
                  </tr>
				  <? if($data['video_image']!=""){?>
				  <tr class="box-bg">
                          <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                          <td align="left" valign="middle">
						 <?=$obj->getImageThumb(VIDEO,$data['video_image'],'','','100','100','../');?></td>
                  </tr>
				  <? }?>
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Product Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="video_status" value="Active" checked="checked"> Active 
					<input type="radio" name="video_status" value="Inactive" <? if($data['video_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive</td>
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
