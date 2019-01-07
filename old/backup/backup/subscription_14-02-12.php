<?php
include("includes/connection.php");
include ("includes/all_form_check.php");
include ("includes/message.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
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
                <td height="40" align="left" valign="top" class="top_title"><h1>Subscription</h1></td>
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
				<form id="billing" name="billing" method="post" action="" class="contact-form1">
                  		  <? if($message1!=""){ echo $message1;}?>
						<label>Studio Name<span class="red">*</span></label><input type="text" name="order_studio_name" value="<?=$_POST['order_studio_name']?>" />
						<label>Owner First Name<span class="red">*</span></label><input type="text" name="order_owner_fname" value="<?=$_POST['order_owner_fname']?>"/>
						<label>Owner Last Name<span class="red">*</span></label><input type="text" name="order_owner_lname" value="<?=$_POST['order_owner_lname']?>"/>
						<label>Primary Contact (if different from above)</label><input type="text" name="order_pri_contact" value="<?=$_POST['order_pri_contact']?>"/>
						<label>Phone</label><input type="text" name="order_ph_no" value="<?=$_POST['order_ph_no']?>"/>
						<label>City</label><input type="text" name="order_city" value="<?=$_POST['order_city']?>"/>
						<label>State</label><input type="text" name="order_state" value="<?=$_POST['order_state']?>"/>
						<label>Zip</label><input type="text" name="order_zip" value="<?=$_POST['order_zip']?>"/>
						<label>Business Phone</label><input type="text" name="order_busines_ph" value="<?=$_POST['order_busines_ph']?>"/>
						<label>Mobile Phone</label><input type="text" name="order_mob_ph" value="<?=$_POST['order_mob_ph']?>"/>
						<label>Business Email</label><input type="text" name="order_business_email" value="<?=$_POST['order_business_email']?>"/>
						<label>Mobile Email</label><input type="text" name="" value=""/>
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						
						  <tr>
							<td><h1>Average Number of Enrolled Students at height of Season </h1></td>
						  </tr>
						  <tr>
							<td><input type="checkbox" name="order_free_sub" value=""/> Free subscription to Dance Informa </td>
						  </tr>
						  <tr>
							<td><input type="checkbox" name="order_send_inf" value="" /> Send me information on how to implement CostumeManager.com </td>
						  </tr>
						  <tr><td>&nbsp;</td></tr>
						</table>

						<label>Opt in to mailing list</label><input type="text" name="order_opt_mail" value="<?=$_POST['order_opt_mail']?>"/>
						<label>Credit Card Number </label><input type="text" name="order_card" value="<?=$_POST['order_card']?>" />
						<label>Expiration Date</label><input type="text" name="order_ex_date" value="<?=$_POST['order_ex_date']?>"/>
						<label>CCV code</label><input type="text" name="order_cvv" value="<?=$_POST['order_cvv']?>"/>
						
						<label>Credit Card Billing Address if different from above:</label><textarea cols="" rows="" name="order_card_bill_add" ><?=$_POST['order_card_bill_add']?></textarea>
						
						<label>Billing Street Address<span class="red">*</span></label><textarea cols="" rows="" name="order_bill_st_add" ><?=$_POST['order_bill_st_add']?></textarea>
						
						<label>Billing City<span class="red">*</span></label><input type="text" name="order_bill_city" value="<?=$_POST['order_bill_city']?>" />
						<label>Billing State<span class="red">*</span></label><input type="text" name="order_bill_state" value="<?=$_POST['order_bill_state']?>" />
						<label>Billing Zip/Postal Code<span class="red">*</span></label><input type="text" name="order_bill_zip" value="<?=$_POST['order_bill_zip']?>" />
						
						<label><span class="red">*</span> Required Fields</label><input type="submit" class="submit" name="confirm_order" value="Submit" />
                                
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
