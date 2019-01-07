<?php
require_once("../includes/connection.php");
adminSecure();
$user_id=$_REQUEST['user_id'];

$order_res=$obj->selectData(TABLE_ORDER,"","order_user='".$user_id."' and order_status=2",1);
						
$sql=$obj->selectData(TABLE_ORDER_DETAIL,"distinct(od_pro) as package_id,od_id,od_package_status","od_order='".$order_res['order_id']."'",2);

$pg_obj=new pagingRecords();
$pg_obj->setPagingParam("g",5,20,1,1);
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
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
<style>
.none {
	border:none !important;
}
</style>
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
              <h3 class="icon-head head-promo-catalog">Subscription List</h3></td>
              <td class="form-buttons">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div>
        <div id="promo_catalog_grid">
        <?=$obj->display_message("message");?>
		  	<?php /*?><div>
				<form name="frmSearch" method="get" action="">
					<div style="font-size:12px; font-weight:bold;">search by User Name</div>
					Search:&nbsp;<input name="search" type="text" class="field_gray" id="search" value="" size="20" maxlength="50" />
					<input name="btnSearch" id="btnSearch" type="submit" value="Search">
				</form>
			</div><?php */?>
          <div class="grid">
            <div class="hor-scroll">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="left" valign="top">
					<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="bodytext">
					
						<form name="form1" method="post" action="">
						  <? if($pg_obj->totrecord){?>
							<tr align="center" valign="middle">
							  
							  <th width="49" align="left" valign="middle" class="bodytext_title_white">#</th>
							  <th width="350" align="center" valign="middle" class="bodytext_title_white">Subscription Name</th>
							  <th width="100" align="center" valign="middle" class="bodytext_title_white">Status</th>
							  <th width="100" align="center" class="bodytext_title_white">Edit</th>
							</tr>
						   <?php }?>
							<?
							$i=1;
							 while($data=mysql_fetch_assoc($res)){
								$package_res=$obj->selectData(TABLE_PACKAGE,"","package_id='".$data['package_id']."'",1);
							?>
							<tr align="left" valign="top" class="box-bg">
							  <td align="left" valign="middle"><?=$i++; ?></td>
							  <td align="center" valign="middle" style="font-weight:bold;">
							  <?=$package_res['package_name']?>
							  </td>
							  <td align="center" valign="middle"><?=$data['od_package_status'];?></td>
							  <td align="center" valign="middle">
							  	<a href="listpackage_edit.php?id=<?=$data['od_id']?>&user_id=<?=$user_id?>&package_id=<?=$data['package_id']?>&return_url=<?=urlencode($_SERVER['REQUEST_URI']);?>" class="bodytext_link">Edit</a><br/>
							  </td>
							</tr>
							<?
							}
							?>
							<tr align="left" valign="top" class="box-bg">
							  <td colspan="4" align="left" valign="middle"><? echo $pg_obj->pageingHTML;?> &nbsp;</td>
							  <?php /*?><td align="right"><? if($pg_obj->totrecord){?><input name="btnDelete" id="btnDelete" type="submit" class="submit" value="Delete" onClick="return validate_delete('chkSelect1');" /><? }?></td><?php */?>
							</tr>
							</form>
						  </table>
						
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
</body>
</html>