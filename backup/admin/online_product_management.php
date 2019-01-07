<?php
/* Online Product management Page */
require_once("../includes/connection.php");
adminSecure();
$extra='';

if(isset($_POST['btnDelete'])){
	if(is_array($_POST['chkSelect'])){
		foreach($_POST['chkSelect'] as $chbx){
			$deleteStatus = $obj->updateData(TABLE_ONLINE_PRODUCT,array('product_status'=>'Deleted'),"product_id='".$chbx."'");
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

if($_REQUEST['search_product_name']<>'')
{
	$extra .= "and product_name like '%".$_REQUEST['search_product_name']."%'"; 
}
//echo $extra;
$sql=$obj->selectData(TABLE_ONLINE_PRODUCT,"","product_status<>'Deleted' ".$extra." order by product_id desc",2);
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
<body id="html-body" class="adminhtml-promo-catalog-index">
<?php include('head.php'); ?>
<div class="middle" id="anchor-content">
  <div>
    <div class="content-header">
      <table width="100%" cellspacing="0">
        <tbody>
          <tr>
            <td><!--<img src="images/icon/product.gif" alt="" width="24" height="24" border="0" class="admin_icon"/>-->
              <h3 class="icon-head head-promo-catalog">Online Product List
              </h3></td>
            <td class="form-buttons"><img src="images/add.gif" align="absmiddle"><a href="online_product_edit.php?product_id=<?=$product_id?>" class="bodytext_bold_link">Add Package</a></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div>
      <div id="promo_catalog_grid">
        <?=$obj->display_message("message");?>
        <div>
          <form name="frmSearch" method="get" action="">
            <input type="hidden" name="id" value="<?=$prod_id?>">
            <div style="font-size:12px; font-weight:bold;">Search by Product Name</div>
            Search:&nbsp;
            <input type="text" name="search_product_name" >
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="btnSearch" id="btnSearch" type="submit" value="Search">
          </form>
        </div>
        <div class="grid">
          <div class="hor-scroll">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%"  border="0" cellpadding="5" cellspacing="0" class="bodytext">
                    <form name="form1" method="post" action="">
                      <? if($pg_obj->totrecord){?>
                      <tr align="center" valign="middle">
                        <th width="49" align="left" valign="middle" class="bodytext_title_white">#</th>
                        <th width="200" align="center" valign="middle" class="bodytext_title_white">Product Name</th>
                        <th width="158" align="center" valign="middle" class="bodytext_title_white">Added</th>
                        <th width="100" align="center" valign="middle" class="bodytext_title_white">Status</th>
                        <th width="100" align="center" class="bodytext_title_white">Edit</th>
                        <th width="110" align="center" class="bodytext_title_white"><input name="chkSelectAll" type="checkbox" value="0" onclick='selectCheckAll("chkSelect1",this.checked);' class="checkboxstyle" /></th>
                      </tr>
                      <?php }?>
                      <?
							 $i=1;
							 while($data=mysql_fetch_assoc($res)){
							?>
                      <tr align="left" valign="top" class="box-bg">
                        <td align="left" valign="middle"><?=$i++; ?></td>
                        <td align="center" valign="middle"><?=$data['product_name']?>
                        </td>
                        <td align="center" valign="middle"><?=$data['date_added'];?></td>
                        <td align="center" valign="middle"><?=$data['product_status'];?></td>
                        <td align="center" valign="middle"><a href="online_product_edit.php?id=<?=$data['product_id']?>&return_url=<?=urlencode($_SERVER['REQUEST_URI']);?>" class="bodytext_link">Edit</a></td>
                        <td align="center" valign="top"><input name="chkSelect[]" id="chkSelect1" type="checkbox" value="<?=$data['product_id'];?>" class="checkboxstyle"></td>
                      </tr>
                      <?
							}
							?>
                      <tr align="left" valign="top" class="box-bg">
                        <td colspan="5" align="left" valign="middle"><? echo $pg_obj->pageingHTML;?> &nbsp;</td>
                        <td align="left" valign="middle"><? if($pg_obj->totrecord){?>
                          <input name="btnDelete" id="btnDelete" type="submit" class="submit" value="Delete" onClick="return validate_delete('chkSelect1');" />
                          <? }?></td>
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
