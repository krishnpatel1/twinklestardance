<?php
/* Package Management Page */
require_once("../includes/connection.php");
adminSecure();
$extra='';

unset($_SESSION['vids']);
unset($_SESSION['p_ids']);
unset($_SESSION['pack_type']);

if(isset($_POST['btnDelete'])){
	if(is_array($_POST['chkSelect'])){
		foreach($_POST['chkSelect'] as $chbx){
			$deleteStatus = $obj->updateData(TABLE_PACKAGE,array('package_status'=>'Deleted'),"package_id='".$chbx."'");
		}
		$affectedRow = mysql_affected_rows();
		
		if($affectedRow > 1)
			$rows = 'Records';
		else
			$rows = 'Record';
			
		if($deleteStatus){
			$obj->add_message("message",$affectedRow.' '.$rows.' '.DELETE_SUCCESSFULL);
		}
	}
	$obj->reDirect($_SERVER['REQUEST_URI']);
}


if($_REQUEST['search_package_name']<>'')
{
	$extra .= "and package_name='".$_REQUEST['search_package_name']."'"; 
}
//echo $extra;
$sql=$obj->selectData(TABLE_PACKAGE,"","package_status<>'Deleted' ".$extra." and package_additional_id='' and update_package_id='' order by package_id desc",2);
$pg_obj=new pagingRecords();
$pg_obj->setPagingParam("g",5,200,1,1);
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

function validate_proceed(chackboxname)
{

	if( $("input[id="+chackboxname+"]").is(':checked'))
	{
		return true;
	}
	else
	{
		alert("Please select at least one package to proceed");
	    return false;
	}
}
</script>

<script>
function toggleChecked(status) {
	$("input[name='chkSelectPackage[]']").each( function() {
	$(this).attr("checked",status);
	})
}
</script>
<style>
.none {
	border:none !important;
}
</style>
</head>
<body id="html-body" class="adminhtml-promo-catalog-index">
<?php include('head.php'); ?>
<div class="middle" id="anchor-content">
  <div>
    <div class="content-header">
      <table width="100%" cellspacing="0">
        <tbody>
          <tr>
            <td><!--<img src="images/icon/product.gif" alt="" width="24" height="24" border="0" class="admin_icon"/>-->
              <h3 class="icon-head head-promo-catalog">Packages List For Order
              </h3></td>
            <td class="form-buttons"><?php /*?><img src="images/add.gif" align="absmiddle"><a href="package_edit.php?package_id=<?=$package_id?>" class="bodytext_bold_link">Add Subscription</a><?php */?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div>
      <div id="promo_catalog_grid">
        <?=$obj->display_message("message");?>
        <?php /*?><div>
          <form name="frmSearch" method="get" action="">
            <input type="hidden" name="id" value="<?=$prod_id?>">
            <div style="font-size:12px; font-weight:bold;">Search by Subscription Name</div>
            Search:&nbsp;
            <input type="text" name="search_package_name" >
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="btnSearch" id="btnSearch" type="submit" value="Search">
          </form>
        </div><?php */?>
        <div class="grid">
          <div class="hor-scroll">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%"  border="0" cellpadding="5" cellspacing="0" class="bodytext">
                    <form name="form1" method="get" action="all_gallery.php">
                      <? if($pg_obj->totrecord){?>
                      <tr align="center" valign="middle">
                        <th width="50" align="center" valign="middle" class="bodytext_title_white"><input type="checkbox" onclick="toggleChecked(this.checked)"></th>
						<th width="100" align="center" valign="middle" class="bodytext_title_white">Subscription Image</th>
                        <th width="437" align="center" valign="middle" class="bodytext_title_white">Subscription Name</th>
                        <th width="200" align="center" valign="middle" class="bodytext_title_white">Price</th>
                      </tr>
                      <?php }?>
                      <?
							 $i=1;
							 while($data=mysql_fetch_assoc($res)){
							 $pa_id=$data['package_id'];
							?>
                      <tr align="left" valign="top" class="box-bg">
                        <td align="center" valign="middle">
						<input name="chkSelectPackage[]" id="chkSelect2" type="checkbox" value="<?=$data['package_id'];?>" class="checkboxstyle"></td>
						<td align="center" valign="middle"> <?=$obj->getImageThumb(PACKAGE_IMG,$data['package_image'],'','','100','100','../');?></td>
                        <td align="center" valign="middle"><?=$data['package_name']?></td>
                        <td align="left" valign="middle" style="padding-left:15px;">
							<input type="radio" name="pack_type_<?=$pa_id?>" value="onetime" checked="checked">&nbsp;<b>Paid in Full</b>&nbsp;&nbsp;&nbsp;
							$<?= number_format($data['package_price_onetime'],2)?><br/><br/>
							<input type="radio" name="pack_type_<?=$pa_id?>" value="subscription">&nbsp;<b>Monthly Plan</b>&nbsp;&nbsp;&nbsp;
							$<?= number_format($data['package_price_subscription'],2)?><br/><br/>
						</td>
                      </tr>
                      <?
						}
						?>
                      <tr align="left" valign="top" class="box-bg">
                        <td colspan="3" align="left" valign="middle"><? echo $pg_obj->pageingHTML;?> &nbsp;</td>
                        <td width="110" align="left" valign="middle"><input name="btnProceed" id="btnProceed" type="submit" class="submit" value="Proceed" onClick="return validate_proceed('chkSelect2');" /></td>
                      </tr>
                    </form>
                  </table></td>
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
