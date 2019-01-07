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
        <td height="331" align="left" valign="top">
		<? include("page_includes/slide.php")?>		</td>
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
                  		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <? if($message1!=""){ ?>
							  <tr>
								<td><span class="<?=$messageClass1?>"><?=$message1;?></span></td>
							  </tr>
							  <? }?>
							  <tr>
								<td height="15"></td>
							  </tr>
							  <tr>
								<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="25" valign="top"><label><span class="red">*</span> Required Fields</label></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="120"><label>Studio Name<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_studio_name" value="<?=$_POST['order_studio_name']?>" /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Owner First Name<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_owner_fname" value="<?=$_POST['order_owner_fname']?>"/></td>
                                  </tr>
                                  <tr>
                                    <td><label>Owner Last Name<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_owner_lname" value="<?=$_POST['order_owner_lname']?>"/></td>
                                  </tr>
                                  <tr>
                                    <td><label>Primary Contact<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_pri_contact" value="<?=$_POST['order_pri_contact']?>"/></td>
                                  </tr>
                                  <tr>
                                    <td><label>Phone</label></td>
                                    <td><input type="text" name="order_ph_no" value="<?=$_POST['order_ph_no']?>"/></td>
                                  </tr>
                                  <tr>
                                    <td><label>City</label></td>
                                    <td><input type="text" name="order_city" id="order_city" value="<?=$_POST['order_city']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>State</label></td>
                                    <td><input type="text" name="order_state" id="order_state" value="<?=$_POST['order_state']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>Zip</label></td>
                                    <td><input type="text" name="order_zip" id="order_zip" value="<?=$_POST['order_zip']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>Business Phone<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_busines_ph" value="<?=$_POST['order_busines_ph']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>Mobile Phone</label></td>
                                    <td><input type="text" name="order_mob_ph" value="<?=$_POST['order_mob_ph']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>Business Email<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_business_email" value="<?=$_POST['order_business_email']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>Mobile Email</label></td>
                                    <td><input type="text" name="order_mob_email" value="<?=$_POST['order_mob_email']?>"/></td>
                                  </tr>
								  <tr>
								    <td><label>Average Number of <br />
							        Enrolled Students at height of Season</label></td>
								    <td><input type="text" name="order_avg_num" value="<?=$_POST['order_avg_num']?>"/></td>
							      </tr>
                                </table></td>
							  </tr>
							  <tr>
							    <td height="10"></td>
						    </tr>
							  <tr>
							    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
						
						  
						  <tr>
							<td><input type="checkbox" name="order_free_sub" value=""/> Free subscription to Dance Informa </td>
						  </tr>
						  <tr>
							<td><input type="checkbox" name="order_send_inf" value="" /> Send me information on how to implement CostumeManager.com </td>
						  </tr>
						  <tr><td height="15"></td></tr>
						</table></td>
						    </tr>
							  <tr>
							    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="120"><label>Opt in to mailing list</label></td>
                                    <td><input type="text" name="order_opt_mail" value="<?=$_POST['order_opt_mail']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>Credit Card Number<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_card" value="<?=$_POST['order_card']?>" /></td>
                                  </tr>
								  <tr>
                                    <td><label>Expiration Date<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_ex_date" value="<?=$_POST['order_ex_date']?>"/></td>
                                  </tr>
								  <tr>
                                    <td><label>CCV code<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_cvv" value="<?=$_POST['order_cvv']?>"/></td>
                                  </tr>
                                </table></td>
						    </tr>
							  <tr>
							    <td height="15"></td>
						    </tr>
							  <tr>
							    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td><input name="chk_bill" id="chk_bill" type="checkbox" value="" onclick="set_billing();" /> Same as Above Address</label></td>
						  </tr>
						</table></td>
						    </tr>
							  <tr>
							    <td height="15"></td>
						    </tr>
							  <tr>
							    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="120"><label>Billing Street Address<span class="red">*</span></label></td>
                                    <td><textarea cols="" rows="" name="order_bill_st_add" ><?=$_POST['order_bill_st_add']?></textarea></td>
                                  </tr>
                                  <tr>
                                    <td><label>Billing City<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_bill_city" id="order_bill_city" value="<?=$_POST['order_bill_city']?>" /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Billing State<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_bill_state" id="order_bill_state" value="<?=$_POST['order_bill_state']?>" /></td>
                                  </tr>
                                  <tr>
                                    <td><label>Billing Zip/Postal Code<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_bill_zip" id="order_bill_zip" value="<?=$_POST['order_bill_zip']?>" /></td>
                                  </tr>
								  <tr>
                                    <td></td>
                                    <td><input type="submit" class="submit" name="confirm_order" value="Submit" /></td>
                                  </tr>
                                </table></td>
						    </tr>
							  <tr>
							    <td>&nbsp;</td>
						    </tr>
							</table>
				</form></td>
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
<script language="javascript">
	function set_billing()
	{
		if(document.getElementById("chk_bill").checked==true)
		{
			document.billing.order_bill_city.value=document.billing.order_city.value;
			document.billing.order_bill_state.value=document.billing.order_state.value;
			document.billing.order_bill_zip.value=document.billing.order_zip.value;
		}
		else
		{
			document.billing.order_bill_city.value    = '';
			document.billing.order_bill_state.value    = '';
			document.billing.order_bill_zip.value = '';
		}	
	}
</script>
</body>
</html>
