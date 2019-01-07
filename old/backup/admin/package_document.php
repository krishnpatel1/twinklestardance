<?php
require_once("../includes/connection.php");
adminSecure();

$package_id=$_REQUEST['id'];
/*  delete data   */
if(isset($_POST['btnDelete']))
{
	if(is_array($_POST['chkSelect']))
	{
		foreach($_POST['chkSelect'] as $chbx)
		{
			$deleteStatus = $obj->updateData(TABLE_PACKAGE_DOCUMENT,array('doc_status'=>'Deleted'),"doc_id='".$chbx."'");
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
/*   / delete data   */

$sql=$obj->selectData(TABLE_PACKAGE_DOCUMENT,"","doc_status<>'Deleted' and doc_package_id='".$package_id."' order by doc_id desc",2);

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
              <h3 class="icon-head head-promo-catalog">Document Listings</h3></td>
              <td class="form-buttons"><img src="images/add.gif" align="absmiddle"><a href="package_document_edit.php?package_id=<?=$package_id?>" class="bodytext_bold_link">Add Document</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div>
        <div id="promo_catalog_grid">
        <?=$obj->display_message("message");?>
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
							  <th width="150" align="center" valign="middle" class="bodytext_title_white">Title</th>
							  <th width="250" align="center" valign="middle" class="bodytext_title_white">Document</th>
							  <th width="90" align="center" valign="middle" class="bodytext_title_white">Added</th>
							  <th width="90" align="center" valign="middle" class="bodytext_title_white">Status</th>
							  <th width="90" align="center" class="bodytext_title_white">Edit</th>
							  <th width="110" align="center" class="bodytext_title_white"><input name="chkSelectAll" type="checkbox" value="0" onclick='selectCheckAll("chkSelect1",this.checked);' class="checkboxstyle" /></th>
							</tr>
						   <?php }?>
							<?
							 $i=1;
							 while($data=mysql_fetch_assoc($res)){
							?>
							<tr align="left" valign="top" class="box-bg">
							  <td align="left" valign="middle">
							  	<?=$i++; ?>
							  </td>
							  <td align="center" valign="middle"><?=$data['doc_title']?></td>
							  <td align="center" valign="middle">
							  	<a href="<?php echo '../'.PACKAGE_IMG.$data['doc_package_document']; ?>" target="_blank"><?php echo $data['doc_package_document'];?></a><br/>
								<?php echo $data['doc_package_link'];?>
							  </td>
							  <td align="center" valign="middle"><?=$data['doc_add_date'];?></td>
							  <td align="center" valign="middle"><?=$data['doc_status'];?></td>
							  <td align="center" valign="middle"><a href="package_document_edit.php?doc_id=<?=$data['doc_id'];?>&return_url=<?=urlencode($_SERVER['REQUEST_URI']);?>&package_id=<?=$package_id?>" class="bodytext_link">Edit</a></td>
							  <td align="center" valign="top"><input name="chkSelect[]" id="chkSelect1" type="checkbox" value="<?=$data['doc_id'];?>" class="checkboxstyle"></td>
							</tr>
							<?
							}
							?>
							<tr align="left" valign="top" class="box-bg">
							  <td colspan="6" align="left" valign="middle"><? echo $pg_obj->pageingHTML;?> &nbsp;</td>
							  <td align="right"><? if($pg_obj->totrecord){?><input name="btnDelete" id="btnDelete" type="submit" class="submit" value="Delete" onClick="return validate_delete('chkSelect1');" /><? }?></td>
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