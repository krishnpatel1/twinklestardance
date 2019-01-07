<?php
include("includes/connection.php");
include("includes/all_form_check.php");
//include("includes/message.php");
if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }

$assign_video_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'list_video.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	/*if($assign_video_id)
	{
		$ex_cond=" and product_id!='".$product_id."'";
	}*/
	
	$user_msg='';
	
	if(trim($_POST['assign_video'])=='') { $err=1; $obj->add_message("message","Please Select Video Name."); }
	if(trim($_POST['assign_video_name'])=='') { $err=1; $obj->add_message("message","Please Enter A Name."); }
	//if($_POST['assign_video_category']=='') { $err=1; $obj->add_message("message","Please Select Gallery Name."); }
	if(empty($_POST['assign_video_category'])) { $err=1; $obj->add_message("message","Please Select Gallery Name."); }
	if(trim($_POST['assign_video_ststus'])=='') { $err=1; $obj->add_message("message","Please Select Video Status."); }
	
	/*if($assign_video_id)
	{
		$ex_cond=" and assign_video_id!='".$assign_video_id."'";
	}
	$row_video=$obj->selectData(TABLE_ASSIGN_VIDEO,"","assign_video_category='".$_POST['assign_video_category']."' and assign_video='".$_POST['assign_video']."'".$ex_cond." and  assign_video_status<>'Deleted'",1);
	if($row_video!=0)
	{
		$err=1;
		$obj->add_message("message","This Data already exist, please Try Another.");
	}
*/
	if(!$err)
	{
		if($assign_video_id)
		{
			$_POST['assign_video_category']=",".implode(',',$_POST['assign_video_category']).",";
			$_POST['assign_video_status']=$_REQUEST['assign_video_ststus'];
			$obj->updateData(TABLE_ASSIGN_VIDEO,$_POST,"assign_video_id='".$assign_video_id."'");
			$obj->add_message("message","Video Updated Successfully!");
		}else{
			$_POST['assign_video_category']=",".implode(',',$_POST['assign_video_category']).",";
			$_POST['assign_video_uid']=$_SESSION['user']['user_id'];
			$_POST['assign_video_date']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_ASSIGN_VIDEO,$_POST);
			$obj->add_message("message","Video Assigned Successfully!");
		}
		$obj->reDirect($return_url);
	}
}

if($assign_video_id!="")
{
	$data = $obj->selectData(TABLE_ASSIGN_VIDEO,"","assign_video_id='".$assign_video_id."'",1);
}
else {
	$data=$_POST;
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
                <td height="40" align="left" valign="top" class="top_title"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="40" align="left" valign="top"><h1><? if($assign_video_id){?>Edit<? }else{?>Add<? }?> Video</h1></td>
                    <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="listall_videos.php">Watch Videos</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_profile.php">Profile</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_document.php">My Documents</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_category.php">Manage Galleries</a></td>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="list_video.php">Manage Videos</a></td>
						</tr>
                    </table></td>
                  </tr>
                </table></td>
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
                <td height="15" align="left" valign="top"></td>
              </tr>
              
			  
			  
              <tr>
                <td align="left" valign="top" class="home_content">
					
				<form name="frm" id="frm" method="post" action="" class="contact-form">
                <div style="color:#ff0000; padding:0 0 10px 0; margin:0;"><?=$obj->display_message("message");?></div>
				<label>Select Video<span class="red">*</span></label>
				<select name="assign_video" id="assign_video" style="width:205px;" class="selectbox required">
					<option value="">---Select---</option>
					<?
						$ordervideo_res=$obj->selectData(TABLE_ORDER_VIDEO,"","order_video_uid='".$_SESSION['user']['user_id']."' and order_video_status='Active' order by order_video_gallery");
						while($ordervideo_arr=mysql_fetch_array($ordervideo_res))
						{
							$video_arr=$obj->selectData(TABLE_GALLERY,"","gallery_id='".$ordervideo_arr['order_video_gallery']."'",1);
					?>
						<option value="<?=$video_arr['gallery_id']?>" <? if($data['assign_video']==$video_arr['gallery_id']) {?> selected="selected" <? }?>><?=$video_arr['gallery_name']?></option>
					<?			
						}
					?>
				</select>
				<label>Video Name <span class="red">*</span></label>
				<input type="text" name="assign_video_name" id="assign_video_name" class="required" value="<?=$data['assign_video_name']?>" />
				<label>Gallery <span class="red">*</span></label>
				<select name="assign_video_category[]" id="assign_video_category" multiple="multiple" style="width:205px; margin:0 0 10px 0; border:1px solid #a8a8a8;">
					<?=$obj->getGalleryUserSelect($data['assign_video_category'])?>
				</select>
				<label>Status <span class="red">*</span></label>
				<select name="assign_video_ststus" id="assign_video_ststus" style="width:205px;" class="selectbox required">
					<option value="">---Select---</option>
					<option <?php if($data['assign_video_status']=='Active') { echo 'selected="selected"'; } ?> value="Active">Active</option>
					<option <?php if($data['assign_video_status']=='Inactive') { echo 'selected="selected"'; } ?> value="Inactive">Inactive</option>
				</select>
				
				
				<label><span class="red">*</span> Required Fields</label>
				<input type="submit" name="btnSubmit" class="submit" value="Save" />
				</form>
				</td>
              </tr>
			  
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
