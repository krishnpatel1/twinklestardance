<?php
include("includes/connection.php");
include("includes/all_form_check.php");
include("includes/message.php");
if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];

if(isset($_POST['login_submit']))
{
	$user_msg='';
	if(trim($_POST['user_first_name'])=='') { $user_msg.='Please provide first name.<br />'; }
	if(trim($_POST['user_last_name'])=='') { $user_msg.='Please provide last name.<br />'; }
	if(trim($_POST['user_last_name'])=='') { $user_msg.='Please provide last name.<br />'; }
	if(trim($_POST['user_studio_name'])=='') { $user_msg.='Please provide Studio Name.<br />'; }
	if(!isEmail(trim($_POST['user_email']))) { $user_msg.='Please provide proper email address.<br />'; }
	if($obj->selectData(TABLE_USER,"","user_id!='$user_id' and user_email='".trim($_POST['user_email'])."' and user_status<>'Deleted'",1)) { $user_msg.='Email address already exists.<br />'; }
	if(trim($_POST['user_password'])=='') { $user_msg.='Please provide password.<br />'; }
	if(trim($_POST['user_phone'])=='') { $user_msg.='Please provide phone.<br />'; }
	if(trim($_POST['user_add_1'])=='') { $user_msg.='Please provide address 1.<br />'; }
	//if(trim($_POST['user_state'])=='') { $user_msg.='Please provide State.<br />'; }
	if(trim($_POST['user_country'])=='') { $user_msg.='Please provide country.<br />'; }
	//if(trim($_POST['user_city'])=='') { $user_msg.='Please provide city.<br />'; }
	//if(trim($_POST['user_zip'])=='') { $user_msg.='Please provide zip.<br />'; }
	
	if($_POST['opt']==1 || $_POST['opt']==0)
	{
		if(trim($_POST['user_city'])=="") {$obj->add_message("message","Please Provide City Name!");}
		if(trim($_POST['user_state'])=="") {$obj->add_message("message","Please Provide Province Name!");}
		if(trim($_POST['user_zip'])=="") {$obj->add_message("message","Please Provide Postal Code!");}
	}
	if($_POST['opt']==2)
	{
		if(trim($_POST['user_city'])=="") {$obj->add_message("message","Please Provide City Name!");}
		if(trim($_POST['user_state'])=="") {$obj->add_message("message","Please Provide State/Territory!");}
	}
	if($_POST['opt']==3)
	{
		if(trim($_POST['order_company'])=="") {$obj->add_message("message","Please Provide Company Name Should Not Be Blank!");}
		if(trim($_POST['order_bulding'])=="") {$obj->add_message("message","Please Provide Building Name !");}
		if(trim($_POST['order_building_no'])=="") {$obj->add_message("message","Please Provide Builidig Number!");}
		if(trim($_POST['order_locality'])=="") {$obj->add_message("message","Please Provide Owner Locality !");}
		if(trim($_POST['order_post'])=="") {$obj->add_message("message","Please Provide Post Name!");}
		if(trim($_POST['order_city'])=="") {$obj->add_message("message","Please Provide Town Name!");}
		if(trim($_POST['order_zip'])=="") {$obj->add_message("message","Please Provide Post Code Should Not Be Blank!");}
	}
	
	
	if($_FILES['user_pic']['tmp_name'])
	{
		list($fileName1,$error)=$obj->uploadFile('user_pic', USER_IMG , 'gif,jpg,png,jpeg');
		if($error)
		{
			$user_msg.=$error;
		}
		else
		{
			$_POST['user_pic']=$fileName1;
		}
	}
	
	if($user_msg=='') {
		$_POST['user_mod_date']=date("Y-m-d H:i:s");
		$obj->updateData(TABLE_USER,$_POST," user_id='".$user_id."'");
		$_SESSION['user_msg']='You have successfully updated your profile.';
		$obj->reDirect('my_profile.php');
	}	
	else {
		$_SESSION['user_msg']=$user_msg;
	}
}

if($user_id!="")
{
	$data = $obj->selectData(TABLE_USER,"","user_id='".$user_id."'",1);
	$_POST['user_country']=$data['user_country'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
<style type="text/css">
.home_content img{border:0!important;}
</style>
<script language="javascript">
	$(document).ready(function(){
		//$("#frm").validate();
		<?php if($_POST['user_country']){?>
		selectFields('<?=$_POST['user_country']?>');
	<? } ?>
	});
</script>
<script language="javascript">
	function selectFields(val)
	{
	jQuery.ajax({
	type: "POST",
	url: "ajax_profilefields.php",
	data: "countries_id="+val,
	success: function(msg){
			$('#field').html(msg);
		}
	});
	}
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
                <td height="40" align="left" valign="top" class="top_title">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="40"><h1>My Profile</h1></td>
                      <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<?php if($data['user_pid']=='0') { ?>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="listall_videos.php">Watch Videos</a></td>
							<? }?>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="my_profile.php">Profile</a></td>
							<?php if($data['user_pid']=='0') { ?>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_document.php">My Documents</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_category.php">Manage Galleries</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="list_video.php">Manage Videos</a></td>
							<?php } else { ?>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_video.php">My Videos</a></td>
							<?php } ?>
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
                <td align="left" valign="top" class="home_content">
					
				<form name="frm" id="frm" method="post" action="" class="contact-form" enctype="multipart/form-data">
                <div style="color:#ff0000; padding:0 0 10px 0"><? if($_SESSION['user_msg']!=""){ echo $_SESSION['user_msg']; unset($_SESSION['user_msg']); }?></div>
				<label>First Name <span class="red">*</span></label>
				<input type="text" name="user_first_name" id="user_first_name" class="required" value="<?=$data['user_first_name']?>" />
				
				<label>Last Name <span class="red">*</span></label>
				<input type="text" name="user_last_name" id="user_last_name" class="required" value="<?=$data['user_last_name']?>" />
				
				<label>Studio Name <span class="red">*</span></label>
				<input type="text" name="user_studio_name" id="user_studio_name" class="required" value="<?=$data['user_studio_name']?>" />
				
				<label>Email <span class="red">*</span></label>
				<input readonly="" type="text" name="user_email" id="user_email" class="required" value="<?=$data['user_email']?>" />
				
				<label>Password <span class="red">*</span></label>
				<input type="password"  name="user_password" id="user_password" class="required" value="<?=$data['user_password']?>"/>
				
				<label>Phone <span class="red">*</span></label>
				<input type="text" name="user_phone" id="user_phone" class="required" value="<?=$data['user_phone']?>" />
				
				<label>Address 1 <span class="red">*</span></label>
				<textarea name="user_add_1" id="user_add_1" class="required"><?=$data['user_add_1']?></textarea>
				
				<label>Address 2 <span class="red"></span></label>
				<textarea name="user_add_2" id="user_add_2"><?=$data['user_add_2']?></textarea>
				
				<label>Country <span class="red">*</span></label>
				<select name="user_country" id="user_country" style="width:205px;" class="selectbox required" onchange="selectFields(this.value)">
				<option value="">---Select---</option>
				<?=$obj->countrySelect($data['user_country'])?>
				</select>
				<br /><br />
				<span id="field">
				</span>
				<?php /*?><label>State <span class="red">*</span></label>
				<input type="text" name="user_state" id="user_state" class="required" value="<?=$data['user_state']?>" />
				<label>City <span class="red">*</span></label>
				<input type="text" name="user_city" id="user_city" class="required" value="<?=$data['user_city']?>" />
				
				<label>Zip <span class="red">*</span></label>
				<input type="text" name="user_zip" id="user_zip" class="required" value="<?=$data['user_zip']?>" /><?php */?>
				
				<label>Upload Profile Image</label>
				<input type="file" name="user_pic" style="margin:0 0 10px 0" /><br/>
				<? if($data['user_pic']!=""){?>
				<div style="margin:0 10px 10px 200px; float:left; width:100%">
					<?php /*?><img src="<?=USER_IMG.$data['user_pic']?>" height="100" width="100"><?php */?>
					<?php echo $obj->getImageThumb(USER_IMG,$data['user_pic'],'','','100','100','');?>
				</div> <? }?>
				<label>Social Media Link</label>
				<input type="text" name="user_media_link" id="user_media_link" class="required" value="<?=$data['user_media_link']?>" />
				<label><span class="red">*</span> Required Fields</label>
				<input type="submit" name="login_submit" class="submit" value="Submit" />
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
