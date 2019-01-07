<?php
include("includes/connection.php");
include("includes/all_form_check.php");
include("includes/message.php");

if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }

$user_id=$_SESSION['user']['user_id'];
if($user_id!="")
{
	$data = $obj->selectData(TABLE_USER,"","user_id='".$user_id."'",1);
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
                <td height="40" align="left" valign="top" class="top_title"><h1>My Account</h1></td>
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
				<strong>Welcome, <?=ucfirst($data['user_first_name'].' '.$data['user_last_name']);?></strong>
				<?php /*?><form name="frm" id="frm" method="post" action="" class="contact-form">
                <? if($user_msg!=""){ echo $user_msg;}?>
				<label>Email <span class="red">*</span></label>
				<input type="text" name="user_email" id="user_email" class="required" value="<?=$_POST['user_email']?>" />
				<label>Password <span class="red">*</span></label>
				<input type="text"  name="user_password" id="user_password" class="required" value="<?=$_POST['user_password']?>"/>
				<label><span class="red">*</span> Required Fields</label>
				<input type="submit" name="login_submit" class="submit" value="Submit" />
				</form><?php */?>
				</td>
              </tr>
			  <tr>
                <td align="left" valign="top" height="25"></td>
              </tr>
			  <tr>
					<td align="left" valign="top" class="home_content">
					<table>
						<tr>
							<?php if($data['user_pid']=='0') {?>
							<td align="center" valign="middle" class="acc_btn"><a href="listall_videos.php">Watch Videos</a></td>	
							<?php }?>
							<td align="center" valign="middle" class="acc_btn"><a href="my_profile.php">Profile</a></td>
							<?php if($data['user_pid']=='0') { ?>
							<td align="center" valign="middle" class="acc_btn"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn"><a href="my_document.php">My Document</a></td>
							<td align="center" valign="middle" class="acc_btn"><a href="my_category.php">Manage Galleries</a></td>
							<td align="center" valign="middle" class="acc_btn"><a href="list_video.php">Manage Videos</a></td>
							<?php } else { ?>
							<td align="center" valign="middle" class="acc_btn"><a href="my_video.php">My Videos</a></td>
							<?php } ?>
						</tr>
					</table>
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
