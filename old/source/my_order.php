<?php
include("includes/connection.php");
include("includes/all_form_check.php");
//include("includes/message.php");

if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];

$action=$_REQUEST['action'];

if($_POST['submit']=='Proceed')
{
	$package_id=$_POST['package_id'];
	$order_video_oder=$_POST['order_video_oder'];
	$remain=$_POST['remain'];
	$gallery=$_POST['gallery'];
	$no_of_video=count($gallery);
	
	if($no_of_video==0)
	{
		$_SESSION['msg']="Please Choose Videos!";
	}
	else
	{
		if($no_of_video > $remain){
		$_SESSION['msg']="Choose Maximum ".$remain." video!";
		}
	}
	if($_SESSION['msg']=="")
	{ 
		foreach($gallery as $value)
		{
			$videoData['order_video_uid'] = $_SESSION['user']['user_id'];
			$videoData['order_video_oder'] = $order_video_oder;
			$videoData['order_video_package'] = $package_id;
			$videoData['order_video_gallery'] = $value;
			$videoData['order_video_add_date'] = date("Y-m-d H:i:s");
			
			$obj->insertData(TABLE_ORDER_VIDEO,$videoData);
		}
	}
	
}

if($_POST['submit']=='Update')
{
	$package_id=$_POST['package_id'];
	$order_video_oder=$_POST['order_video_oder'];
	$galleries=$_POST['gallery'];
	$gallery_name='';
	$z=1;
	
	$no_of_videos=count($galleries);
	
	if($no_of_videos==0)
	{
		$_SESSION['msg1']="Please Choose Videos!";
	}
	
	if($_SESSION['msg1']=="")
	{ 
		foreach($galleries as $value)
		{
			if($value!=0)
			{
				$video_arr=$obj->selectData(TABLE_GALLERY,"","gallery_id='".$value."'",1);
				$gallery_name.=$z." ) ".$video_arr['gallery_name']."<br/>";
				
				$videoData['order_video_uid'] = $_SESSION['user']['user_id'];
				$videoData['order_video_oder'] = $order_video_oder;
				$videoData['order_video_package'] = $package_id;
				$videoData['order_video_gallery'] = $value;
				$videoData['order_video_add_date'] = date("Y-m-d H:i:s");
				$obj->insertData(TABLE_ORDER_VIDEO,$videoData);
				$z++;
			}
		}
		
		$_SESSION['msg_success']="Thanks for updating!  The following videos have been added to your subscription: <br/><br/>".$gallery_name;
	}
	
}

$order_video_sql=$obj->selectData(TABLE_ORDER_VIDEO,"DISTINCT(order_video_package) as package","order_video_uid='".$user_id."' and order_video_status!='Deleted'");
$package_list='';
while($order_arr=mysql_fetch_array($order_video_sql))
{
	$package_list.=$order_arr['package'].",";
	$subscription_arr[]=$order_arr['package'];// for additional package
}
$package=rtrim($package_list,',');
if($package=="")
{
	$package=0;
}

//print_r($subscription_arr);

$sql=$obj->selectData(TABLE_ORDER,"","order_user='".$_SESSION['user']['user_id']."' and order_status=2 and order_delete<>'Yes' order by order_id desc",2);
$pg_obj=new pagingRecords();
$pg_obj->setPagingParam("g",5,10,1,1);
$getarr=$_GET;
unset($getarr['msg']);
$res=$pg_obj->runQueryPaging($sql,$pageno,$getarr);
$qr_str=$pg_obj->makeLnkParam($getarr,0);
$pageno = 1;
if($_REQUEST['pageno']!="")
{
	$pageno = $_REQUEST['pageno'];
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
	<?php if($_SESSION['msg']<>'') {?>
	selectvideos('<?=$_POST['package_id']?>','<?=$_POST['order_video_oder']?>','<?=$obj->is_completeVideo($_POST['package_id'])?>');
	<?php }?>
	<?php if($_SESSION['msg1']<>'') {?>
	updateVideo('<?=$_POST['package_id']?>','<?=$_POST['order_video_oder']?>');
	<?php }?>
	});

	function selectvideos(package,order,remain)
	{
		jQuery.ajax({
		type: "POST",
		url: "ajax_package_video.php",
		data: "package_id="+package+"&order="+order+"&remain="+remain,
		success: function(msg){
				$('#video').html(msg);
			}
		});
	}
	
	function updateVideo(package_id,order)
	{
		jQuery.ajax({
		type: "POST",
		url: "ajax_update_video.php",
		data: "package_id="+package_id+"&order="+order,
		success: function(msg){
				$('#updatevideo').html(msg);
			}
		});
	}
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
                    <td height="40" align="left" valign="top"><h1>Order</h1></td>
                    <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="listall_videos.php">Watch Videos</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_profile.php">Profile</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_document.php">My Documents</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_category.php">Manage Galleries</a></td>
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
				
				<table width="100%"  border="0" cellpadding="3" cellspacing="2" class="gry_border">
					
						  <? if($pg_obj->totrecord){?>
							<tr align="center" valign="middle">
								<td width="5%" align="center" valign="middle" class="bodytext_title_white"><strong>#</strong></td>
								<td width="30%" align="left" valign="top" class="bodytext_title_white"><strong>Order No/date</strong></td>
								<td align="center"  valign="middle" class="bodytext_title_white"><strong>Order Details</strong></td>
							</tr>
						   <?php }?>
							<? 
					 		 $i=1;
							 while($row=mysql_fetch_array($res)){ 
							?>
                      <tr class="tr_bg">
					  	<td align="center" valign="top" class="box_pink"><?=$i++;?></td>
                        <td align="left" valign="top" class="box_pink"><strong>Order
                          No: </strong><? echo $row['order_id']?>
                          <input type="hidden" name="order_id[]" value="<?=$row['order_id']?>">
                          <br>
                          <strong>Date:</strong>
                          <?php echo date("m/d/y",strtotime($row['order_date']));?><br/><br/>
						 <?php /*?> <strong>Order Status</strong> :<?php echo $obj->get_orderstatus($row['order_status'])?><br/><?php */?>
						  <?php /*?><a href="order_packages.php?od_order=<? echo $row['order_id']?>" rel="shadowbox;width=300;height=200;">View Gallery</a><?php */?>
						  <a href="listall_videos.php?order=<? echo $row['order_id']?>">View Gallery</a>
						  </td>
                        <td height="20" align="center" valign="middle" class="box_pink" >
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>
							  	<table width="100%" border="1" cellspacing="0" cellpadding="3" style="border:1px solid #E693BA; border-collapse:collapse;">
                                  <tr>
                                    <td width="26%" height="22" align="left" class="black_text2"><strong>Subscription</strong></td>
                                    <td width="18%" height="22" align="right" class="black_text2"><strong>Price *</strong></td>
                                  </tr>
                                  <?php
									$res_orderdetails=$obj->selectData(TABLE_ORDER_DETAIL,"","od_order='".$row['order_id']."'");
									$temp_total=0;
									while($product=mysql_fetch_array($res_orderdetails)){
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
									?>
                                  <tr class="tr_bg">
                                    <td align="left" class="black_text2"><? echo $product_name;?></td>
                                    <td align="right" class="black_text2">$<? echo $product['od_price'];?> </td>
                                  </tr>
                                  <?php
									}
								 ?>
								 <tr>
								 	<td align="right" style="padding-right:10px;"><strong>Grand Total</strong></td>
									<td align="right">$<?php echo number_format($temp_total, 2, '.', '')?></td>
								 </tr>
                                </table>
							</td>
                            </tr>
                          </table>
						 </td>
                      </tr>
                      <? }?>
				</table>
				
				</td>
              </tr>
			  <tr>
			  	<td align="left" style="height:15px;"></td>
			  </tr>
			  <tr>
			  	<td align="left">
					<table width="100%"  border="0" cellpadding="3" cellspacing="2" class="gry_border">
					<tr>
						<td align="left" class="home_content">
							<strong>Disclaimer:</strong> *Pre-discount price. Discounts and monthly payment plans are
							managed via our separate billing system. <br/>
							<a href="https://www.thestudiodirector.com/twinklestardancellc/register.jsp" target="_blank">Click this link to access your billing account</a>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			  <tr>
                <td aalign="left" style="height:15px;"></td>
              </tr>
			  <tr>
                <td align="left" valign="top">
					<table width="100%"  border="0" cellpadding="3" cellspacing="2" class="gry_border">
						<?php
							$order_video=$obj->selectData(TABLE_ORDER_VIDEO,"DISTINCT(order_video_package) as package,order_video_oder","order_video_uid='".$user_id."' and order_video_status!='Deleted'");
							while($order_package=mysql_fetch_array($order_video))
							{
								if($obj->is_completeVideo($order_package['package'])!=0)
								{
									$limit=$obj->is_completeVideo($order_package['package']);
						?>
						<tr>
							<td align="left" class="home_content">
								<?php /*?>Your <?php echo $obj->getPackageName($order_package['package']);?> gallery has <?php echo $obj->is_completeVideo($order_package['package']);?> of <?php echo $obj->getPackageQty($order_package['package']);?> videos.<br/> 
								Would you like to select more videos for this gallery now?<?php */?>
								Your <?php echo $obj->getPackageName($order_package['package']);?> gallery currently contains <b><?php echo $obj->alreadySubscribe($order_package['package']);?></b> of the allotted <b><?php echo $obj->getPackageQty($order_package['package']);?></b> videos.<br/> 
								Would you like to select <b><?php echo $obj->is_completeVideo($order_package['package']);?></b> more videos for this gallery now?
								<a href="#" onclick="javascript:selectvideos('<?=$order_package['package']?>','<?=$order_package['order_video_oder']?>','<?=$limit?>')" class="red_link">Yes</a>&nbsp;&nbsp;&nbsp;<a href="listall_videos.php">Not right now</a>
							</td>
						</tr>
						<tr><td style="height:5px;"></td></tr>
						<?php 
								} 
							}
						?>
						<tr>
							<td align="left">
								<?php if(isset($_SESSION['msg'])){?>
								<div style="color:#FF0000;"><?php echo $_SESSION['msg'];?></div>	
								<? 
									unset($_SESSION['msg']);
								}?>
								<div id="video"></div>
							</td>
						</tr>
					</table>
				</td>
              </tr>	
		   <tr>
			<td align="left" style="height:15px;"></td>
		   </tr>
		   <!--==============Additional Package======================-->
		   <? if($obj->hasAdditionalpackorder()!=0) {
		   ?>
		   <tr>
			  	<td align="left" class="home_content">
					<table width="100%"  border="0" cellpadding="3" cellspacing="2" class="gry_border">
						<?php
							$package_sql=$obj->selectData(TABLE_PACKAGE,"","package_status='Active' and package_id IN (".$package.") order by package_id ");	
						?>
						<tr>
							<td height="40" align="left" valign="top" colspan="3" class="top_title"><h1>Additional Subscriptions</h1></td>
						</tr>
						<tr align="center" valign="middle">
							<td width="5%" align="center" valign="middle" class="bodytext_title_white"><strong>#</strong></td>
							<td width="70%" align="left" valign="top" class="bodytext_title_white"><strong>Subscription Name</strong></td>
							<td width="25%"  align="center"  valign="middle" class="bodytext_title_white"></td>
						</tr>
						<? 
						 $i=1;
						while($package_row=mysql_fetch_array($package_sql)){
						
						$addpack_arr =$obj->selectData(TABLE_PACKAGE,"","package_id='".$package_row['package_id']."'",1);
						$pid=explode(',',$addpack_arr['package_additional_id']);
						foreach($pid as $val)
						{
							if(isset($val) && $val<>'')
							{
							if(!in_array($val,$subscription_arr))
							{
								$package_arr =$obj->selectData(TABLE_PACKAGE,"","package_id='".$val."'",1);
						?>
						  <tr class="tr_bg">
							<td align="center" valign="top" class="box_pink"><?=$i++;?></td>
							<td align="left" valign="top" class="box_pink"><strong><?=$package_arr['package_name']?></strong>
							  </td>
							<td height="20" align="center" valign="middle" class="box_pink" >
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
								  <td align="center" valign="middle" class="box_pink">
									<a href="package-detail.php?id=<?=$package_arr['package_id']?>" class="red_link">Add</a>
								  </td>
								</tr>
							  </table>
							 </td>
						  </tr>
                      <? 
					  		}
						  }
						}	
					  }
					  ?>
				</table>
				</td>
			 </tr>
			 <?php }?>
			<!--==============Additional Package End======================-->
		   <tr><td align="left" style="height:15px;"></td></tr>
			  <tr>
			  	<td align="left" class="home_content">
					<table width="100%"  border="0" cellpadding="3" cellspacing="2" class="gry_border">
						<?php
							$package_sql=$obj->selectData(TABLE_PACKAGE,"","package_status='Active' and package_id NOT IN (".$package.") order by package_id ");	
						?>
						<tr>
							<td height="40" align="left" valign="top" colspan="3" class="top_title"><h1>Available Subscriptions</h1></td>
						</tr>
						<tr align="center" valign="middle">
							<td width="5%" align="center" valign="middle" class="bodytext_title_white"><strong>#</strong></td>
							<td width="70%" align="left" valign="top" class="bodytext_title_white"><strong>Subscription Name</strong></td>
							<td width="25%"  align="center"  valign="middle" class="bodytext_title_white"></td>
						</tr>
						<? 
						 $i=1;
						 while($package_row=mysql_fetch_array($package_sql)){ 
						 //$pack_sql=$obj->selectData(TABLE_GALLERY_PERMITION,"","per_user='".$_SESSION['user']['user_id']."' and per_package='".$package_row['package_id']."'");
						 /*if(mysql_num_rows($pack_sql)==0)
						 {	*/
						 	if($package_row['update_package_id']=="")
							{
						?>
                      <tr class="tr_bg">
					  	<td align="center" valign="top" class="box_pink"><?=$i++;?></td>
                        <td align="left" valign="top" class="box_pink"><strong><?=$package_row['package_name']?></strong>
						  </td>
                        <td height="20" align="center" valign="middle" class="box_pink" >
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="center" valign="middle" class="box_pink">
							  	<a href="package-detail.php?id=<?=$package_row['package_id']?>" class="red_link">Add Subscription</a>							  </td>
                            </tr>
                          </table>
						 </td>
                      </tr>
                      <? 
					  		}
					  	/*} */
					  }
					  ?>
					  <!--************************Update videos************************************-->
					  <tr><td colspan="3" style="height:5px;"></td></tr>
					  <?php
					  $updatepackage_sql=$obj->selectData(TABLE_ORDER_VIDEO,"DISTINCT(order_video_package) as package,order_video_oder","order_video_uid='".$user_id."' and order_video_status!='Deleted'");
					  	while($updatepackage_arr=mysql_fetch_array($updatepackage_sql))
						{
								$update_sql=$obj->selectData(TABLE_PACKAGE,"DISTINCT(package_id) as package_id","package_status='Active' and update_package_id LIKE '%,".$updatepackage_arr['package'].",%'");
								while($update_arr=mysql_fetch_array($update_sql))
								{
									$pack_arr =$obj->selectData(TABLE_PACKAGE,"","package_id='".$update_arr['package_id']."'",1);
									if($pack_arr['update_package_id']<>'' && !in_array($pack_arr['package_id'],$subscription_arr) && $pack_arr['package_additional_id']=="")
									{
									
						?>
								<tr class="tr_bg">
									<td align="center" valign="top" class="box_pink"></td>
									<td align="left" valign="top" class="box_pink"><strong><?=$pack_arr['package_name']?></strong></td>
									<td height="20" align="center" valign="middle" class="box_pink" >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
											  <td align="center" valign="middle" class="box_pink">
												<?php /*?><a href="my_order.php?action=update&package_id=<?=$pack_arr['package_id']?>&order=<?=$updatepackage_arr['order_video_oder']?>" onclick="javascript:updateVideo('<?=$pack_arr['package_id']?>','<?=$updatepackage_arr['order_video_oder']?>')" style="cursor:pointer;" class="red_link">Update</a><?php */?>
												<a onclick="javascript:updateVideo('<?=$pack_arr['package_id']?>','<?=$updatepackage_arr['order_video_oder']?>')" style="cursor:pointer;" class="red_link">Update</a>
											  </td>
											</tr>
									    </table>
									 </td>
								  </tr>
						<?php
									}		
								}
						}
					  ?>
					  <tr>
							<td>&nbsp;</td>
							<td align="left" colspan="2">
								<?php if(isset($_SESSION['msg1'])){?>
								<div style="color:#FF0000;"><?php echo $_SESSION['msg1'];?></div>	
								<? 
									unset($_SESSION['msg1']);
								}?>
								<div id="updatevideo"></div>
								<?php if(isset($_SESSION['msg_success'])) {?>
								<div style="color:#AF2998;"><?php echo $_SESSION['msg_success'];?></div>	
								<?php
									unset($_SESSION['msg_success']);
									}	
								?>
							</td>
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
