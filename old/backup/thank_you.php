<?php 
include("includes/connection.php");
$temp=$_SESSION['scart'];
$totrec=count($_SESSION['scart']);
		$newOrderId = $_SESSION['pay_id'];
		$rr['od_payment_status']='Paid';
		$obj->updateData(TABLE_ORDER_DETAIL,$rr,"od_order='$newOrderId'");
		$rr2['order_status']='2';
		$obj->updateData(TABLE_ORDER,$rr2,"order_id='$newOrderId'");
		$trans_id = $resArray["TRANSACTIONID"];
		$pammount = $currencyCode.$resArray['AMT'];
		
		$user_login=$obj->selectData(TABLE_USER,"","user_id='".$_SESSION['userId']."'",1);
		$_SESSION['user']=$user_login;
		
		/*===============Permition=====================*/
		for($i=0;$i<$totrec;$i++)
		{
		$pro_id=$temp[$i]['productid'];	
		$category=$obj->selectData(TABLE_PACKAGE,"gallery_category_ids","package_id='".$pro_id."'",1);
		$ids2=explode(',',$category['gallery_category_ids']);
			
				foreach($ids2 as $value2)
				{
					$perdata['per_user']=$_SESSION['userId'];
					$perdata['per_order']=$newOrderId;
					$perdata['per_package']=$pro_id;
					$perdata['per_add_date']=date("Y-m-d H:i:s");
					
					$gallcat_arr=$obj->selectData(TABLE_GALLERY_CATEGORY,"","category_id='".$value2."'",1);
					$perdata['per_category']=$gallcat_arr['category_id'];
					
					$obj->insertData(TABLE_GALLERY_PERMITION,$perdata);
				}
		}
		/*===============================================*/
		for($y=0;$y<$totrec;$y++)
		{
			$package_id = $temp[$y]['productid'];
			$gallery_id = explode(",",$temp[$y]['gallery']);
			$order = $newOrderId;
			
				foreach($gallery_id as $val)
				{
					$videoData['order_video_uid'] = $_SESSION['userId'];
					$videoData['order_video_oder'] = $order;
					$videoData['order_video_package'] = $package_id;
					$videoData['order_video_gallery'] = $val;
					$videoData['order_video_add_date'] = date("Y-m-d H:i:s");
					
					$obj->insertData(TABLE_ORDER_VIDEO,$videoData);
				}
			
		}
		
		/*--------------------------Send Mail----------------------------------------*/
		$order_detail = $obj->selectData(TABLE_ORDER,"","order_id='".$newOrderId."'",1);
		
		$mailFormat ='<table align="left" cellpadding="0" cellspacing="0" width="100%" border="0">
						<tr><td style="height:10px;"></td></tr>
						<tr><td align="left"><b>Billing Information :</b></td></tr>
						<tr><td style="height:10px;"></td></tr>
						<tr><td style="border-bottom:1px solid #13B7B7;"></td></tr>
						<tr><td style="height:10px;"></td></tr>
						<tr>
							<td align="left">
								<table width="99%" border="0" cellspacing="1" cellpadding="4" class="gray_box1">
									<tr class="wht_box">
									  <td width="204" align="left" valign="middle"><strong>First
										  name</strong></td>
									  <td align="center" valign="middle"><strong>:</strong></td>
									  <td width="439" align="left" valign="middle">'.$order_detail['order_owner_fname'].'</td>
									</tr>
									<tr class="wht_box">
									  <td align="left" valign="middle"><strong>Last Name<span class="prc_txt">*</span></strong></td>
									  <td align="center" valign="middle"><strong>:</strong></td>
									  <td align="left" valign="middle">'.$order_detail['order_owner_lname'].'</td>
									</tr>';
									$data=$obj->selectData(TABLE_COUNTRY,"","countries_id='".$order_detail['order_country']."'",1);
									$opt=$data['id'];
									if($opt==1)
									{
										$mailFormat.='<tr class="wht_box">
										  <td align="left" valign="middle"><strong>City</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_city'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"><strong>Province</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_state'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>Postal Code</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_zip'].'</td>
										</tr>
										';
									}
									else if($opt==2)
									{
										$mailFormat.='<tr class="wht_box">
										  <td align="left" valign="middle"><strong>City</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_city'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"><strong>State/Territory</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_state'].'</td>
										</tr>
										';
									}
									else if($opt==3)
									{
										$mailFormat.='<tr class="wht_box">
										  <td align="left" valign="middle"><strong>Company Name</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_company'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"><strong>Building Name</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_bulding'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>Building Number</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_building_no'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>Locality</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_locality'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>Post</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_post'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>Town</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_city'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>Post Code</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_zip'].'</td>
										</tr>
										';
									}
									else
									{
										$mailFormat.='<tr class="wht_box">
										  <td align="left" valign="middle"><strong>Postal Code</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_zip'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"><strong>City</strong></td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_city'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>State</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_state'].'</td>
										</tr>
										<tr class="wht_box">
										  <td align="left" valign="middle"> <strong>Postal Code/Zip</strong> </td>
										  <td align="center" valign="middle"><strong>:</strong></td>
										  <td align="left" valign="middle">'.$order_detail['order_bill_zip'].'</td>
										</tr>
										';	
									}
									$mailFormat.='
								  </table>
							</td>
						</tr>
						<tr><td style="height:10px;"></td></tr>
						<tr><td align="left"><b>Shopping Cart :</b></td></tr>
						<tr><td style="height:10px;"></td></tr>
						<tr><td style="border-bottom:1px solid #13B7B7;"></td></tr>
						<tr><td style="height:10px;"></td></tr>
						<tr>
							<td align="left">
								<table width="100%" border="0" cellspacing="1" cellpadding="4">
									<tr class="grn_box">
									  <td width="260" align="center" valign="top">Product Name</td>
									  <td width="70" align="center" valign="top"><strong>Price</strong></td>
									  </tr>';
										$temp_total=0;
										$orderPD = $obj->selectData(TABLE_ORDER_DETAIL,"","od_order='".$order_detail['order_id']."'");
										while($product = mysql_fetch_array($orderPD)){
										
										$orderProType = $product['od_pro_type'];
										$orderPriceType = $product['od_price_type'];
										$packageId = $product['od_pro'];
										if($orderProType == "P"){
											if($orderPriceType == "onetime"){
												$orderPriceDetails = $obj->selectData(TABLE_PACKAGE,"","package_id='".$packageId."'",1);
												$product_name= $orderPriceDetails['package_name'];
												$orderPrice = $orderPriceDetails['package_price_onetime'];
												$orderPriceHtml = $orderPrice;
											}else{
												$orderPriceDetails = $obj->selectData(TABLE_PACKAGE,"","package_id='".$packageId."'",1);
												$product_name= $orderPriceDetails['package_name'];
												$orderPriceDuration = $orderPriceDetails['package_duration'];
												$orderPrice = $orderPriceDetails['package_price_subscription'];
												$orderPriceHtml = $orderPrice." /Month For ".$orderPriceDuration." Months";
											}
										}
										if($orderProType == "DW"){
												$product_name=$obj->get_product($packageId)." -- ".$obj->get_downloadType($product['od_dw_type']);
												//$orderPriceHtml=$product['od_price'];
												$orderPrice=$product['od_price'];
										}
										$temp_total+=$product['od_price'];	
										
									 	$mailFormat .= '<tr class="wht_box">
									  <td align="left" valign="top"><strong>'.$product_name.'</strong></td>
									  <td align="center" valign="top"><span class="prc_txt"><strong>$'.$product['od_price'].'</strong></span></td>
									  </tr>';
										}
								   $mailFormat .= '<tr class="grn_box">
									  <td colspan="5" align="right" valign="middle"><strong>Sub Total :</strong></td>
									  <td colspan="5" align="left" valign="middle"><strong>$ '.number_format($temp_total, 2, '.', '').'</strong></td>
									  </tr>
								  </table>
							</td>
						</tr>
					</table>
			';
		  	$message = "Dear ".$order_detail['order_owner_fname']." ".$order_detail['order_owner_lname'].",<br><br>Thank you for submitting order. Please check the order invoice details below:"; 
			//$message .= $mailFormat;
			$message .= "Thank you for subscribing to Twinkle Star Dance! <br/>";
			$message .= "Your custom galleries have been established and you may view them here. <a href='listall_videos.php'>Click Here </a><br/>";
			$message .= "You may also download our quick user guide here. <a href='#'>Download</a><br/>";
			$message .= "Finally, we’ll be in touch soon to touch base and to inform you of our next teleseminar where you’ll hear helpful tips and tricks.";
			$message .= "In the meantime, if you have any questions, feel free to shoot us an email at info@twinklestardance.com or call (925) 447-5299.<br/>";
			$message .= "<br/>Tiffany Henderson – Founder";
			//$message .= "Thank You<br><br>".MAIL_THANK_YOU;
			
			$body     = $obj->mailBody($message);
			$to       = $order_detail['order_business_email'];
			$from     = SITE_EMAIL;
			$subject  = "Congratulatuion for your order #  - ".MAIL_THANK_YOU;
			$obj->sendMail($to, $subject,$body,$from,"Twinkle Star Dance",$type);
			
			$amessage = "Dear Administrator,<br><br>A new order was submitted today./ Please check the details below :";
			$amessage .= $mailFormat;
			
			$amessage .= "Thank You<br><br>".MAIL_THANK_YOU;
			$body  = $obj->mailBody($amessage);
			
			$toa       = ADMIN_EMAIL;
			$obj->sendMail($toa, $subject,$body,$from,"Twinkle Star Dance",$type);
		/*-----------------------------End---------------------------------------*/
		unset($_SESSION['scart']);
		$_POST = "";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
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
          <tr><td colspan="2" style="color:#ff0000;"><?php echo $_SESSION['L_LONGMESSAGE0'];?></td></tr>
		  <tr><td colspan="2" style="height:10px;"></td></tr>	
		  <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title">
					<h1>Thank you for subscribing to Twinkle Star Dance! </h1>
				</td>
              </tr>
			  <tr>
			  	<td class="home_content">
						<table align="left" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="2" align="left"><b> We’ve processed your first payment for the following subscription(s):</b></td>
							</tr>
						<?php
							$pay_id=$_SESSION['pay_id'];
							$odetails_sql=$obj->selectData(TABLE_ORDER_DETAIL,"","od_order='$pay_id' and od_status='Active'","");
							$tot_price=0;
							$y=1;
							$stat=0;
							while($odetails_row=mysql_fetch_array($odetails_sql))
							{
								$pro_id=$odetails_row['od_pro'];
								$pro_type=$odetails_row['od_pro_type'];
								$pro_price=$odetails_row['od_price'];
								$pro_dw_type=$odetails_row['od_dw_type'];
								$pack_type=$odetails_row['od_price_type'];
								$duration=$odetails_row['od_duration'];
								
								$tot_price+=$pro_price;
								
								if($pro_type=='DW')
								{
									$product_fetch=$obj->selectData(TABLE_PRODUCT,"","prod_id='".$pro_id."' ",1);
									$pro_desc2=$product_fetch['prod_title']." -- $".$pro_price;
								}
								if($pro_type=='P')
								{
									$package_fetch=$obj->selectData(TABLE_PACKAGE,"","package_id='".$pro_id."'",1);
									if($pack_type=='subscription')
									{
										$pro_desc2=$package_fetch['package_name']."  -- $".$package_fetch['package_price_subscription'];
									}
									if($pack_type=='onetime')
									{
										$pro_desc2=$package_fetch['package_name']." -- $".$package_fetch['package_price_onetime'];
									}
									
								}
								?>
								<tr>
									<td colspan="1">
									<?=$y++?>. &nbsp;<?=$pro_desc2?>
									</td>
									<td>
									<?php /*?><?php if($odetails_row['od_payment_status']=='Unpaid') { $stat=1; ?>
									<a href="paypal_pro_rec.php?od_id=<?=$odetails_row['od_id'];?>"><strong>Pay Now</strong></a>
									<?php } else { echo '<strong>Paid</strong>'; } ?><?php */?>
									</td>
								</tr>							
								<?php	
								
							}
						?>
						<tr>
						  <td colspan="2">________________________________________________________________________________________________________</td>
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr><td colspan="2">Total amount processed in this transaction was &nbsp;&nbsp;<span style="margin-left:15px;">$<?=$tot_price?></span></td></tr>
						<tr>
							<td colspan="2">
								If you’ve elected the monthly plan, you may  view your monthly account ledger 
								<a href="https://www.thestudiodirector.com/twinklestardancellc/register.jsp" target="_blank">here</a>
							</td>
						</tr>
						<?					
						 if($stat==0)
						 {
							unset($_SESSION['scart']);
							$_SESSION['order'] = "";
						 }
						 
						?>
					</table>
				</td>
			  </tr>
			  <tr><td style="height:15px;"></td></tr>
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