<?php 
include ("includes/connection.php");
include ("includes/all_form_check.php");
include ("includes/message.php");
$temp=$_SESSION['scart'];
$totrec=count($_SESSION['scart']);
if($totrec)
{
	$_POST['order_date'] = date("Y-m-d H:i:s");
	//$_POST['order_key'] = $obj->get_order_key();

	///////////////////////////////////Order Insert////////////////////////////
	$_POST = array_merge($_POST,$_SESSION['order']);
	$obj->insertData(TABLE_ORDER,$_POST);
	$newOrderId = mysql_insert_id();

		$sum=0;
		for($i=0;$i<$totrec;$i++)
		{
			$pro_id=$temp[$i]['productid'];
			$pro_type=$temp[$i]['p_type'];
			$pro_price=$temp[$i]['price'];
			$pro_dw_type=$temp[$i]['dw_type'];
			$pack_type=$temp[$i]['pack_type'];
			$duration=$temp[$i]['duration'];
			//$proD=$obj->selectData(TABLE_PRODUCT." as p, ".TABLE_PRODUCT_PRICE." as pp, ".TABLE_SIZE." as s","","p.pro_status<>'Deleted' and p.pro_id=pp.pp_pro and pp.pp_id='".$pro_id."' and s.size_status='Active' and s.size_id=pp.pp_size",1,"pp.pp_pro","p.pro_added desc");
			//$proD=$obj->selectData(TABLE_PRODUCT,"","prod_status='Active' and prod_id='".$pro_id."'",1);			
			/////////////////////Order Details/////////////////////
			$arrOD['od_order']          = $newOrderId;
			$arrOD['od_pro']            = $pro_id;
			$arrOD['od_pro_type']       = $pro_type;
			$arrOD['od_price']          = $pro_price;
			$arrOD['od_dw_type']        = $pro_dw_type;
			$arrOD['od_price_type']     = $pack_type;
			$arrOD['od_duration']       = $duration;
			
			$obj->insertData(TABLE_ORDER_DETAIL,$arrOD);
						
			$tot=$pro_price;
			$tot=number_format($tot, 2, '.', '');
			$sum=number_format($sum+$tot,2, '.', '');
		}
		
	///////////////////////////Order Total Update///////////////////////////////////////	
	$arrODU['order_sub_total'] = $sum;
	$arrODU['order_total']     = $sum;
	
	$obj->updateData(TABLE_ORDER,$arrODU,"order_id='".$newOrderId."'");
	
	/////////////////////////////////Empty Cart//////////////////////
	//unset($_SESSION['scart']);
	//$_SESSION['order'] = "";

	$_SESSION['pay_amount'] = $arrODU['order_total'];
	$_SESSION['pay_id']     = $newOrderId;
	//$_SESSION['pay_key']    = $_POST['order_key'];
	$_POST = "";
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
									</tr>
									<tr class="wht_box">
									  <td align="left" valign="middle"><strong>Street Address<span class="prc_txt">*</span></strong></td>
									  <td align="center" valign="middle"><strong>:</strong></td>
									  <td align="left" valign="middle">'.$order_detail['order_bill_st_add'].'</td>
									</tr>
									<tr class="wht_box">
									  <td align="left" valign="middle"><strong>State</strong></td>
									  <td align="center" valign="middle"><strong>:</strong></td>
									  <td align="left" valign="middle">'.$order_detail['order_bill_state'].'</td>
									</tr>
									<tr class="wht_box">
									  <td align="left" valign="middle"> <strong>City</strong> </td>
									  <td align="center" valign="middle"><strong>:</strong></td>
									  <td align="left" valign="middle">'.$order_detail['order_bill_city'].'</td>
									</tr>
									<tr class="wht_box">
									  <td align="left" valign="middle"><strong>Post Code </strong></td>
									  <td align="center" valign="middle"><strong>:</strong></td>
									  <td align="left" valign="middle">'.$order_detail['order_bill_zip'].'</td>
									</tr>
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
			$message .= $mailFormat;
			$message .= "Thank You<br><br>".MAIL_THANK_YOU;
			
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
		$obj->reDirect("thankyou.php");
}
else
{
	$obj->reDirect("online_packages.php");
}		
?>