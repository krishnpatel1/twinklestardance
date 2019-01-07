<?php
include("includes/connection.php");
include("includes/all_form_check.php");
//include("includes/message.php");

if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];

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
	$(document).ready((function){
		$("#frm").validate();
	});
</script>
<script language="javascript">
function selectCheckAll(chackboxname,value)
{
	$("input[id="+chackboxname+"]").attr('checked',value);

}

function validate_delete(chackboxname)
{

	if( $("input[id="+chackboxname+"]").is(':checked'))
	{
		return confirm("Are you sure you want to delete?");
	}
	else
	{
		alert("Please select at least one record to delete");
	    return false;
	}
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
                <td height="40" align="left" valign="top" class="top_title"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="40" align="left" valign="top"><h1>My Document</h1></td>
                    <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="listall_videos.php">Watch Videos</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_profile.php">Profile</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="my_document.php">My Documents</a></td>
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
							  <th align="left" valign="middle" class="bodytext_title_white">Subscription</th>
							  <th width="350" align="center" valign="middle" class="bodytext_title_white">Document</th>
							</tr>
						   <?php }?>
							<?
							 $i=1;
							 while($row=mysql_fetch_array($res)){ 
							 /*===============================================*/
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
											}else{
												$orderPriceDetails = $obj->selectData(TABLE_PACKAGE,"","package_id='".$packageId."'",1);
												$product_name= $orderPriceDetails['package_name'];
												
											}
										}
										if($orderProType == "DW"){
												$product_name=$obj->get_product($packageId)." -- ".$obj->get_downloadType($product['od_dw_type']);
										}
							 /*===============================================*/
							 
							?>
							<tr align="left" valign="top">
							  <td align="left" valign="middle" class="box_pink"><? echo $product_name;?></td>
							  	<?php
									$document_sql=$obj->selectData(TABLE_PACKAGE_DOCUMENT,"","doc_package_id='".$packageId."' and doc_status='Active'");
									if(mysql_num_rows($document_sql)>0)
									{
								?>
							  <td align="center" valign="middle" class="box_pink">
							  		<table align="left" cellpadding="0" cellspacing="0">
										<?php
											while($document_arr=mysql_fetch_array($document_sql))
											{
										?>
										<tr>
											<td align="left">
												<? if($document_arr['doc_package_document']<>''){?>
												<a href="<?php echo PACKAGE_IMG.$document_arr['doc_package_document']; ?>" target="_blank"><?php echo $document_arr['doc_package_document'];?></a>&nbsp;&nbsp;
												<? }
												   if($document_arr['doc_package_link']<>''){ ?>
												   <a href="<?php echo $document_arr['doc_package_link']; ?>" target="_blank"><?php echo $document_arr['doc_package_link'];?></a>
												 <?php
												   }	
												?>
											</td>
										</tr>
										<? }?>
									</table>
							  </td>
							  	<?php } else {?>
								 <td align="center" valign="middle" class="box_pink">
							  		No Document
							 	 </td>
								<?php }?>	
							</tr>
							<?
								}
							}
							?>
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
