<?php
include("includes/connection.php");
include("includes/all_form_check.php");
//include("includes/message.php");
if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }

$category_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'my_category.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	/*if($category_id)
	{
		$ex_cond=" and product_id!='".$product_id."'";
	}*/
	
	$user_msg='';
	if(trim($_POST['category_name'])=='') { $err=1; $obj->add_message("message","Please provide gallery name."); }
	if(trim($_POST['category_status'])=='') { $err=1; $obj->add_message("message","Please provide gallery status."); }

	if(!$err)
	{
		if($category_id)
		{
			$obj->updateData(TABLE_GALLERY_CATEGORY,$_POST,"category_id='".$category_id."'");
			$obj->add_message("message","Custom Gallery updated successfully!");
		}else{
			$_POST['category_uid']=$_SESSION['user']['user_id'];
			$_POST['category_add_date']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_GALLERY_CATEGORY,$_POST);
			$obj->add_message("message","Congratulations!  You've successfully added a new custom gallery!");
		}
		$obj->reDirect($return_url);
	}
}

if($category_id!="")
{
	$data = $obj->selectData(TABLE_GALLERY_CATEGORY,"","category_id='".$category_id."'",1);
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
                    <td height="40" align="left" valign="top"><h1><? if($category_id){?>Edit<? }else{?>Add<? }?> Gallery</h1></td>
                    <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="listall_videos.php">Watch Videos</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_profile.php">Profile</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_document.php">My Documents</a></td>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="my_category.php">Manage Galleries</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="list_video.php">Manage Videos</a></td>
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
				<label>Gallery Name <span class="red">*</span></label>
				<input type="text" name="category_name" id="category_name" class="required" value="<?=$data['category_name']?>" />
				
				<label>Status <span class="red">*</span></label>
				<select name="category_status" id="category_status" style="width:205px;" class="selectbox required">
				<option value="">---Select---</option>
				<option <?php if($data['category_status']=='Active') { echo 'selected="selected"'; } ?> value="Active">Active</option>
				<option <?php if($data['category_status']=='Inactive') { echo 'selected="selected"'; } ?> value="Inactive">Inactive</option>
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
