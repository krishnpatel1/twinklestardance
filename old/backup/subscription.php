<?php
include("includes/connection.php");
ini_set('session.cookie_secure','1');

$totrec=count($_SESSION['scart']);
$temp=$_SESSION['scart'];

if(FURL != "http://192.168.1.100:82/projects/2012/twinkle_star_dance/codes/"){
	if($_SERVER['SERVER_PORT'] != 443) {
	   header("HTTP/1.1 301 Moved Permanently");
	   header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	   exit();
	}
}
include ("includes/all_form_check.php");
include ("includes/message.php");
if(isset($_SESSION['user']['user_id']))
{
	//$data=$obj->selectData(TABLE_USER,"","user_email='".trim($_SESSION['order']['order_business_email'])."' and user_status<>'Deleted'",1);
	$data=$obj->selectData(TABLE_USER,"","user_id='".$_SESSION['user']['user_id']."'",1);
	
	
	$_POST['order_studio_name'] = $data['user_studio_name'];
	$_POST['order_owner_fname'] = $data['user_first_name'];
	$_POST['order_owner_lname'] = $data['user_last_name'];
	$_POST['order_country'] = $data['user_country'];
	$_POST['order_pri_contact'] = $data['user_primary_contact'];
	$_POST['order_ph_no'] = $data['user_phone'];
	
	$_POST['order_busines_ph'] = $data['user_bussiness_phone'];
	$_POST['order_mob_ph'] = $data['user_mobile_phone'];
	$_POST['order_business_email'] = $data['user_email'];
	$_POST['order_mob_email'] = $data['user_mobile_email'];
	$_POST['order_avg_num'] = $data['user_enroll_student'];
	
	$_POST['order_free_sub'] = $data['user_dance_informa'];
	$_POST['order_send_inf'] = $data['user_custom_manager'];
	$_POST['order_opt_mail'] = $data['user_mailing_list'];
	
	$_SESSION['subscription']['order_street']=$data['user_street'];
	$_SESSION['subscription']['order_city']=$data['user_city'];
	$_SESSION['subscription']['order_state']=$data['user_state'];
	$_SESSION['subscription']['order_zip']=$data['user_zip'];
	$_SESSION['subscription']['order_company']=$data['user_company'];
	$_SESSION['subscription']['order_bulding']=$data['user_bulding'];
	$_SESSION['subscription']['order_building_no']=$data['user_building_no'];
	$_SESSION['subscription']['order_locality']=$data['user_locality'];
	$_SESSION['subscription']['order_post']=$data['user_post'];
	
	$_SESSION['subscription']['order_bill_street']=$data['user_ship_street'];
	$_SESSION['subscription']['order_bill_city']=$data['user_ship_city'];
	$_SESSION['subscription']['order_bill_state']=$data['user_ship_state'];
	$_SESSION['subscription']['order_bill_zip']=$data['user_ship_zip'];
	$_SESSION['subscription']['order_bill_company']=$data['user_ship_company'];
	$_SESSION['subscription']['order_bill_bulding']=$data['user_ship_building'];
	$_SESSION['subscription']['order_bill_building_no']=$data['user_ship_buildingno'];
	$_SESSION['subscription']['order_bill_locality']=$data['user_ship_locality'];
	$_SESSION['subscription']['order_bill_post']=$data['user_ship_post'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
<script language="javascript">
$(document).ready(function(){
$("input[type=submit]").attr("disabled", "disabled");
<?php if($_POST['order_country'])	{?>
		selectFields('<?=$_POST['order_country']?>');
<? } ?>

});

function set_agree()
{
	if(document.getElementById('is_agree').checked==true)
	{
		$("input[type=submit]").removeAttr("disabled");
	}
	else
	{
		$("input[type=submit]").attr("disabled", "disabled");
	}
	
}

function selectFields(val)
{
	jQuery.ajax({
	type: "POST",
	url: "ajax_fields.php",
	data: "countries_id="+val,
	success: function(msg){
			var ss=msg.split('#######')
			$('#field').html(ss[0]);
			$('#fieldbill').html(ss[1]);
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
        <td align="left" valign="top">
		<? include("page_includes/slide.php")?>		</td>
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
								<td><span class="home_content" style="color:#ff0000;"><?=$message1;?></span></td>
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
                                    <td><label>Primary Contact full Name</label></td>
                                    <td><input type="text" name="order_pri_contact" value="<?=$_POST['order_pri_contact']?>"/></td>
                                  </tr>
                                  <tr>
                                    <td><label>Phone</label></td>
                                    <td><input type="text" name="order_ph_no" value="<?=$_POST['order_ph_no']?>"/></td>
                                  </tr>
								  <tr><td colspan="2" style="height:10px;"></td></tr>
								  <tr>
								  	<td colspan="2">
										<div id="field"></div>
									</td>
								  </tr>
								   <tr>
								  	<td><label>Country <span class="red">*</span></label></td>
									<td>
									<select name="order_country" id="order_country" style="width:200px;" onchange="selectFields(this.value)">
										<?php echo $obj->countrySelect($_POST['order_country']); ?>
									</select>
									</td>
								  </tr>
								  <tr><td colspan="2" style="height:10px;"></td></tr>
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
							<td><input type="checkbox" name="order_free_sub" value="" <? if($_POST['order_free_sub']=='Yes') {?> checked="checked" <? }?>/> Free subscription to Dance Informa </td>
						  </tr>
						  <tr>
							<td><input type="checkbox" name="order_send_inf" value="" <? if($_POST['order_free_sub']=='Yes') { echo "checked='checked'"; }?>/> Send me information on how to implement CostumeManager.com </td>
						  </tr>
						  <tr>
							<td><input type="checkbox" name="order_opt_mail" value="" <? if($_POST['order_opt_mail']=='Yes') { echo "checked='checked'"; }?>/> Opt in to mailing list</td>
						  </tr>
						  <tr><td height="15"></td></tr>
						</table></td>
						    </tr>
							  <?php /*?><tr>
							    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
                                    <td width="120"><label>Credit Card Number<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_card" value="<?=$_POST['order_card']?>" onblur="getCreditCardType(this.value);" /></td>
                                  </tr>
								  <tr>
                                    <td><label>Card Type<span class="red">*</span></label></td>
                                    <td> 
									<select name="order_card_type">
										<option value="">Select</option>
										<option value="Visa" <? if($_POST['order_card_type']=='Visa') {?> selected="selected" <? }?>>Visa</option>
										<option value="MasterCard" <? if($_POST['order_card_type']=='MasterCard') {?> selected="selected" <? }?>>MasterCard</option>
										<option value="Discover" <? if($_POST['order_card_type']=='Discover') {?> selected="selected" <? }?>>Discover</option>
										<option value="Amex" <? if($_POST['order_card_type']=='Amex') {?> selected="selected" <? }?>>Amex</option>
									</select>
									</td>
                                  </tr>
								  <tr><td colspan="2" style="height:10px;"></td></tr>
								  <tr>
                                    <td><label>Expiration Date<span class="red">*</span></label></td>
                                    <td>Month <select name="order_ex_month">
										<option value="">Select</option>
										<option value="1" <? if($_POST['order_ex_month']==1) {?> selected="selected" <? }?>>JAN</option>
										<option value="2" <? if($_POST['order_ex_month']==2) {?> selected="selected" <? }?>>FEB</option>
										<option value="3" <? if($_POST['order_ex_month']==3) {?> selected="selected" <? }?>>MAR</option>
										<option value="4" <? if($_POST['order_ex_month']==4) {?> selected="selected" <? }?>>APR</option>
										<option value="5" <? if($_POST['order_ex_month']==5) {?> selected="selected" <? }?>>MAY</option>
										<option value="6" <? if($_POST['order_ex_month']==6) {?> selected="selected" <? }?>>JUN</option>
										<option value="7" <? if($_POST['order_ex_month']==7) {?> selected="selected" <? }?>>JUL</option>
										<option value="8" <? if($_POST['order_ex_month']==8) {?> selected="selected" <? }?>>AUG</option>
										<option value="9" <? if($_POST['order_ex_month']==9) {?> selected="selected" <? }?>>SEP</option>
										<option value="10" <? if($_POST['order_ex_month']==10) {?> selected="selected" <? }?>>OCT</option>
										<option value="11" <? if($_POST['order_ex_month']==11) {?> selected="selected" <? }?>>NOV</option>
										<option value="12" <? if($_POST['order_ex_month']==12) {?> selected="selected" <? }?>>DEC</option>
									</select>
									Year
									<select name="order_ex_year">
									<option value="" >Year</option>	
                                        <? for($year=date('Y');$year<=(date('Y')+20);$year++){?>
										<option <? if($_POST['order_ex_year']==$year) { echo 'selected="selected"'; } ?> value="<?=$year?>">
										<?=$year?>
										</option>
										<? }?>
                                      </select>	
									 
									</td>
                                  </tr>
								  <tr><td colspan="2" style="height:10px;"></td></tr>
								  <tr>
                                    <td><label>CVV code<span class="red">*</span></label></td>
                                    <td><input type="text" name="order_cvv" value="<?=$_POST['order_cvv']?>"/></td>
                                  </tr>
								  
                                </table></td>
						    </tr><?php */?>
							  <tr>
							    <td height="15"></td>
						    </tr>
							  <tr>
							    <td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
							  	<td align="left"><b>Billing Address</b></td>
							  </tr>
							  <tr>
							    <td height="15"></td>
						     </tr>
							  <tr>
								<td><input name="chk_bill" id="chk_bill" type="checkbox" value="" onclick="set_billing();" /> Same as Above Address</label></td>
							  </tr>
							</table>
						</td>
						    </tr>
							  <tr>
							    <td height="15"></td>
						    </tr>
							  <tr>
							    <td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2">
										<div id="fieldbill"></div>
									</td>
								</tr>
								  <tr>
								  	<td colspan="2"><label onclick="popup('terms_condition.php')"><input type="checkbox" name="is_agree" id="is_agree" value="" onclick="set_agree()"/>Agree to Terms</label></td>
								  </tr>
								  <tr><td colspan="2" style="height:10px;"></td></tr>
								  <tr>
                                    <td width="20"></td>
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
		var opt=document.billing.opt.value;
		if(document.getElementById("chk_bill").checked==true)
		{
			
			if(opt==1 || opt==0)
			{
				var street=document.billing.order_street.value;
				var city=document.billing.order_city.value;
				var state=document.billing.order_state.value;
				var zip=document.billing.order_zip.value;
				
				document.billing.order_bill_street.value=street;
				document.billing.order_bill_city.value=city;
				document.billing.order_bill_state.value=state;
				document.billing.order_bill_zip.value=zip;
			}
			if(opt==2)
			{
				var street=document.billing.order_street.value;
				var city=document.billing.order_city.value;
				var state=document.billing.order_state.value;
				
				document.billing.order_bill_street.value=street;
				document.billing.order_bill_city.value=city;
				document.billing.order_bill_state.value=state;
			}
			if(opt==3)
			{
				var comp=document.billing.order_company.value;
				var building=document.billing.order_bulding.value;
				var buliding_no=document.billing.order_building_no.value;
				var locality=document.billing.order_locality.value;
				var post=document.billing.order_post.value;
				var state=document.billing.order_state.value;
				var city=document.billing.order_city.value;
				var zip=document.billing.order_zip.value;
				
				document.billing.order_bill_company.value=comp;
				document.billing.order_bill_bulding.value=building;
				document.billing.order_bill_building_no.value=buliding_no;
				document.billing.order_bill_locality.value=locality;
				document.billing.order_bill_post.value=post;
				document.billing.order_bill_state.value=state;
				document.billing.order_bill_city.value=city;
				document.billing.order_bill_zip.value=zip;
			}
			
		}
		else
		{
			if(opt==1 || opt==0)
			{
				document.billing.order_bill_street.value='';
				document.billing.order_bill_city.value='';
				document.billing.order_bill_state.value='';
				document.billing.order_bill_zip.value='';
			}
			if(opt==2)
			{
				document.billing.order_bill_street.value='';
				document.billing.order_bill_city.value='';
				document.billing.order_bill_state.value='';
			}
			if(opt==3)
			{
				document.billing.order_bill_company.value='';
				document.billing.order_bill_bulding.value='';
				document.billing.order_bill_building_no.value='';
				document.billing.order_bill_locality.value='';
				document.billing.order_bill_post.value='';
				document.billing.order_bill_city.value='';
				document.billing.order_bill_zip.value='';
			}
			
		}	
	}
</script>
</body>
</html>
