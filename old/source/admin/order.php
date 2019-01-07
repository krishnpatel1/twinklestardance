<?php
require_once("../includes/connection.php");
adminSecure();
/*  delete data   */
if($_POST['delete_order']=='Delete')
{	
	if(count($_POST['chkDel'])>0) 
	{
		$ids=implode(',',$_POST['chkDel']);
		$arrOS['order_delete'] = 'Yes';
		$obj->updateData(TABLE_ORDER,$arrOS,"order_id in (".$ids.")");
		
		/*------------------------------------*/
		$query=$obj->selectData(TABLE_ORDER_DETAIL,"od_pro","od_order in (".$ids.")");
		while($array=mysql_fetch_array($query))
		{
			$arrPK['order_video_status'] = 'Inactive';
			$obj->updateData(TABLE_ORDER_VIDEO,$arrPK,"order_video_package='".$array['od_pro']."'");
		}
		
		/*------------------------------------*/
		
		$arrODS['od_status'] = 'Deleted';
		$obj->updateData(TABLE_ORDER_DETAIL,$arrODS,"od_order in (".$ids.")");
		
		$_SESSION['admin_msg']=DELETE_SUCCESSFULL;
	}
}	
if($_POST['update_order']=='Update')
{	
	if(count($_POST['order_status'])>0)
	{
		$cnt=count($_POST['order_status']);
		for($i=0; $i<$cnt; $i++)
		{
			$stat=$_POST['order_status'][$i];
			$oid=$_POST['order_id'][$i];
			$obj->updateData(TABLE_ORDER,array("order_status"=>$stat),"order_id='".$oid."'");
			$_SESSION['admin_msg']=UPDATE_SUCCESSFULL;
		}
	}
	else
	 	$_SESSION['admin_msg']='Please check atleast one checkbox!';
		
		$obj->reDirect($_SERVER['REQUEST_URI']);
}
////////////////////////////////////////////////////////////////////////////////
			
$condition="1";

if($_REQUEST['status']!="")	$condition.=" and a.order_status='".$_REQUEST['status']."'";

if(!empty($_REQUEST['invoiceno']))	$condition.=" and a.order_id='".$_REQUEST['invoiceno']."'";
if(!empty($_REQUEST['fromdate']))	$condition.=" and a.order_date >='".$_REQUEST['fromdate']." 00:00:00'";
if(!empty($_REQUEST['todate']))		$condition.=" and a.order_date <='".$_REQUEST['todate']." 23:59:59'";

$condition.=" and a.order_delete='No'";

$condition.=" order by a.order_id desc";

$pg_obj=new pagingRecords();
$sql=$obj->selectData(TABLE_ORDER." as a","",$condition,2);
$pg_obj->setPagingParam("d",5,10,1,1);
$getarr=array("fromdate"=>$_REQUEST['fromdate'],"todate"=>$_REQUEST['todate'],"status"=>$_REQUEST['status'],"invoiceno"=>$_REQUEST['invoiceno']);
$res=$pg_obj->runQueryPaging($sql,$pageno,$getarr);
$qr_str=$pg_obj->makeLnkParam($getarr,0);
//pre($pg_obj);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<? include("common_js.php");?>
<script type="text/javascript" src="../js/jquery/datepicker.js"></script>
<script language="javascript">
<!--

function popCalendar(id){ var idd='#'+id;
	jQuery(function() {
		jQuery(idd).datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			showButtonPanel: false,
			stepMonths:1,
			closeText:'Select Date'
		});
	});
}
function docId(id){
	return document.getElementById(id);
}

function clearform()
{
	
	$('#invoiceno').val('');
	$('#todate').val('');
	$('#fromdate').val('');
	$('#status').val('');
}
//-->
</script>
</head>
<body id="html-body" class=" adminhtml-promo-catalog-index">
<?php include('head.php'); ?>
<div class="middle" id="anchor-content">
  <div>
    <div class="content-header">
      <table width="100%" cellspacing="0">
        <tbody>
          <tr>
            <td><!--<img src="images/icon/product.gif" alt="" width="24" height="24" border="0" class="admin_icon"/>-->
              <h3 class="icon-head head-promo-catalog">Orders</h3></td>
            <td class="form-buttons">&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div>
      <div id="promo_catalog_grid">
        <?=$obj->display_message("message");?>
        <div> </div>
        <div class="grid">
          <div class="hor-scroll">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><form name="form1" action="" method="post">
                    <table width="100%" border="0" cellspacing="1" cellpadding="2" class="tableborder_gray">
                      <? if($_SESSION['admin_msg']){?>
                      <tr class="tr_bg">
                        <td height="25" colspan="7" align="left" valign="top" class="red_text"><span class="error"><? echo $_SESSION['admin_msg']; unset($_SESSION['admin_msg']);?></span></td>
                      </tr>
                      <? }?>
                      <tr>
                        <td height="25" align="left" valign="middle"  colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                              <td height="20" colspan="2" align="left" >Search Order </td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="right" >&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2" align="right"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                                  <tr>
                                    <td width="11%" align="right" class="bodytext">Order No&nbsp;&nbsp;</td>
                                    <td width="8%" class="body_text"><input name="invoiceno" id="invoiceno" type="text" size="10" class="input" value="<?=$_REQUEST['invoiceno']?>"></td>
                                    <td width="12%" align="right" class="bodytext">From Date&nbsp;</td>
                                    <td width="12%" align="left" valign="middle" class="bodytext"><input name="fromdate" id="fromdate" type="text" size="10" value="<? echo $_REQUEST['fromdate']?>" class="input" onClick="popCalendar(this.id)"></td>
                                    <td width="11%" align="right" class="bodytext">To Date &nbsp;</td>
                                    <td width="13%" class="bodytext"><input name="todate" id="todate" value="<? echo $_REQUEST['todate']?>" type="text" size="10" class="input" onClick="popCalendar(this.id)"></td>
                                    <td width="12%" align="right" class="bodytext"><span class="HD2dark">Status</span>&nbsp;&nbsp;</td>
                                    <td width="21%" class="bodytext"><select name="status" id="status">
                                        <option value="">All</option>
                                        <?=$obj->orderStatusList($_REQUEST['status'])?>
                                      </select>
                                    </td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center" ><input type="submit" name="Submit" value="Search" class="button">
                                &nbsp;
                                <input type="button" name="Submit" value="Reset" class="button" onClick="clearform();">
                                &nbsp;
                                <input type="button" name="showall" value="Show All" class="button" onClick="javascript:parent.location.href='order.php'"></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td width="15%" height="20" align="left" valign="top" class="bodytext_title_white">Order No/date</td>
                        <td width="25%" align="left" valign="top" class="bodytext_title_white">User Details </td>
                        <td width="45%" align="center"  valign="middle" class="bodytext_title_white">Order Details</td>
                        <td width="11%" align="center"  valign="middle" class="bodytext_title_white">Order Status </td>
                        <td width="5%" align="center"  valign="middle" class="bodytext_title_white">Delete</td>
                      </tr>
                      <? 
					  while($row=mysql_fetch_array($res)){ 
								$userD = $obj->selectData(TABLE_USER,"","user_id='".$row['order_user']."'",1);
								  ?>
                      <tr class="tr_bg">
                        <td align="left" valign="top" class="black_text2"><strong>Order
                          No: </strong><? echo $row['order_id']?>
                          <input type="hidden" name="order_id[]" value="<?=$row['order_id']?>">
                          <br>
                          <strong>Date:</strong><br>
                          <?php echo $row['order_date']?></td>
                        <td align="left" valign="top" class="black_text2"><span class="HD2dark"> 
						  <?=$userD['user_email']?>
						  <br/>
						  <?=$row['order_owner_fname']." ".$row['order_owner_lname']?>
						  <br/>
						  Studio Name: <?=$row['order_studio_name'];?>
						  <br/>
						  Phone: <?=$row['order_ph_no'];?>
						  <br/>
						  Business Email: <?=$row['order_business_email'];?>
						  <br/>
						  
                          <span class="HD2dark"><strong>Billing Address:</strong></span><br>
						  <?=$obj->billingInfo($row['order_id'])?>
                        </td>
                        <td height="20" align="center" valign="middle" ><table width="100%" border="0" cellspacing="1" cellpadding="0">
                            <tr>
                              <td ><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                  <tr>
                                    <td width="26%" height="22" align="left" class="black_text2"><strong>Product</strong></td>
                                    <td width="18%" height="22" align="right" class="black_text2"><strong>Price</strong></td>
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
								 	<td align="right" style="padding-right:10px;">Grand Total</td>
									<td align="right" style="padding-right:10px;">$<?php echo number_format($temp_total, 2, '.', '')?></td>
								 </tr>
                                </table></td>
                            </tr>
                          </table></td>
                        <td height="20" align="center" valign="top" >
						<select name="order_status[]" class="input">
                            <?=$obj->orderStatusList($row['order_status'])?>
                          </select></td>
                        <td height="20" align="center" valign="top"><input type="checkbox" name="chkDel[]" value="<?=$row['order_id']?>"></td>
                      </tr>
                      <? }?>
                      <tr class="tr_bg">
                        <td height="25" colspan="3" align="left" valign="top" class="black_text"><?=$pg_obj->pageingHTML?></td>
                        <td height="25" align="center" valign="top" class="black_text"><input type="submit" name="update_order" value="Update" class="submit" onClick="javascript:return confirm('Are you sure want to update orders?');"></td>
                        <td align="center" valign="middle"><span class="black_text">
                          <input type="submit" name="delete_order" value="Delete" class="submit" onClick="javascript:return confirm('Are you sure want to delete orders?');">
                          </span>&nbsp;</td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('footer.php'); ?>
<script language="javascript">
jQuery(function() {
		jQuery('#fromdate').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			showButtonPanel: false,
			stepMonths:1,
			closeText:'Select Date'
		});
	});
jQuery(function() {
		jQuery('#todate').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			showButtonPanel: false,
			stepMonths:1,
			closeText:'Select Date'
		});
	});	
</script>
</body>
</html>
