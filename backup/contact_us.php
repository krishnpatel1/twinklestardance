<?php
include("includes/connection.php");
include("includes/all_form_check.php");
include("includes/message.php");
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

<body>
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
        <td height="331" align="left" valign="top"><? include("page_includes/slide.php")?></td>
      </tr>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="top">
		<? include("page_includes/banners.php") ?>
		</td>
      </tr>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1>Contact Us</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
					<?=$obj->putContent(2)?>
				<!--Via phone (925) 447-5299<br /><br />
				Via email: <a href="mailto:info@twinklestardance.com">info@twinklestardance.com</a><br /><br />
				Via facebook:  <a href="https://www.facebook.com/pages/Twinkle-Star-Dance-Program/244317095622502" target="_blank">https://www.facebook.com/pages/Twinkle-Star-Dance-Program/244317095622502</a>-->				</td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td height="25" align="left" valign="top" class="home_content"><strong>Contact Form</strong></td>
              </tr>
			  <tr>
			  	<td class="home_content">Thank you for visiting our website. Please fill out the following form to request information about our products and services or to provide feedback about our site. When you are finished, click the 'Submit' button to send us your message. You will see a confirmation below.</td>
			  </tr>
			  <tr><td>&nbsp;</td></tr>
              <tr>
                <td align="left" valign="top" class="home_content">
					
				<form name="frm" id="frm" method="post" action="" class="contact-form">
                  		<? if($message1!=""){ echo $message1;}?>
						<label>First Name<span class="red">*</span></label><input type="text" name="cust_fname" id="cust_fname" class="required" value="<?=$_POST['cust_fname']?>" />
						<label>Last Name<span class="red">*</span></label><input type="text"  name="cust_lname" id="cust_lname" class="required" value="<?=$_POST['cust_lname']?>"/>
						<label>Email<span class="red">*</span></label><input type="text" name="cust_email" id="cust_email" value="<?=$_POST['cust_email']?>" class="required"/>
						<label>Phone</label><input type="text" name="cust_phone" id="cust_phone" value="<?=$_POST['cust_phone']?>"/>
						<label>Subject</label><input type="text" name="subject" id="subject" value="<?=$_POST['subject']?>" />
						<label>Message</label><textarea cols="" rows="" name="cust_message" id="cust_message"><?=$_POST['cust_message']?></textarea>
						<label><span class="red">*</span> Required Fields</label><input type="submit" name="cust_send" class="submit" value="Submit" />
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
