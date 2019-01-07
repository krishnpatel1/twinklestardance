<?php
require_once("../includes/connection.php");
adminSecure();

/*  delete data   */
if(isset($_POST['btnDelete']))
{
	if(is_array($_POST['chkSelect']))
	{
		foreach($_POST['chkSelect'] as $chbx)
		{
			$deleteStatus = $obj->updateData(TABLE_USER,array('user_status'=>'Deleted'),"user_id='".$chbx."'");
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

if($_REQUEST['search']!="")
{
	$extra .= "and (user_first_name like '%".trim($_REQUEST['search'])."%')"; 
}


$sql=$obj->selectData(TABLE_USER,"","user_status<>'Deleted'".$extra."  order by user_first_name desc",2);

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
              <h3 class="icon-head head-promo-catalog">User Listings</h3></td>
              <td class="form-buttons"><img src="images/add.gif" align="absmiddle"><a href="user_edit.php" class="bodytext_bold_link">Add
                  User</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div>
        <div id="promo_catalog_grid">
        <?=$obj->display_message("message");?>
		  	<div>
				<form name="frmSearch" method="get" action="">
					<div style="font-size:12px; font-weight:bold;">search by User Name</div>
					Search:&nbsp;<input name="search" type="text" class="field_gray" id="search" value="" size="20" maxlength="50" />
					<input name="btnSearch" id="btnSearch" type="submit" value="Search">
				</form>
			</div>
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
							  <th width="150" align="center" valign="middle" class="bodytext_title_white">Name</th>
							  <th width="300" align="center" valign="middle" class="bodytext_title_white">Contacts</th>
							  <th width="300" align="center" valign="middle" class="bodytext_title_white">Address</th>
							  <th width="100" align="center" valign="middle" class="bodytext_title_white">Registration Date</th>
							  <th width="100" align="center" valign="middle" class="bodytext_title_white">Status</th>
							  <th width="37" align="center" class="bodytext_title_white">Edit</th>
							  <th width="110" align="center" class="bodytext_title_white"><input name="chkSelectAll" type="checkbox" value="0" onclick='selectCheckAll("chkSelect1",this.checked);' class="checkboxstyle" /></th>
							</tr>
						   <?php }?>
							<?
							$i=1;
							 while($data=mysql_fetch_assoc($res)){
							 $name=$data['user_first_name']." ".$data['user_last_name'];
							 $state = $obj->selectData(TABLE_STATE,"","state_id='".$data['user_state']."'",1);
							?>
							<tr align="left" valign="top" class="box-bg">
							  <td align="left" valign="middle"><?=$i++; ?></td>
							  <td align="center" valign="middle" style="font-weight:bold;">
							  <?=$obj->getImageThumb(USER_IMG,$data['user_image'],'','','100','100','../');?><br/>
							  <?=$name; ?>
							  </td>
							  <td align="left" valign="middle">
							  	<b>E</b> :&nbsp;<?=$data['user_email'];?><br/>
								<b>P</b> :&nbsp;<?=$data['user_phone'];?><br/>
							  </td>
							  <td align="left" valign="middle">
							  	<?=$data['user_add_1'];?><br/>
								<span style="font-size:11px; font-weight:bold;">City:</span>&nbsp;<?=$data['user_city'];?><br/>
								<span style="font-size:11px; font-weight:bold;">State:</span>&nbsp;<?=$state['state_title'];?><br/>
								<span style="font-size:11px; font-weight:bold;">Zip:</span>&nbsp;<?=$data['user_zip'];?><br/>
							  </td>
							  <td align="center" valign="middle"><?=$data['user_reg_date'];?></td>
							  <td align="center" valign="middle"><?=$data['user_status'];?></td>
							  <td align="center" valign="middle"><a href="user_edit.php?id=<?=$data['user_id'];?>&return_url=<?=urlencode($_SERVER['REQUEST_URI']);?>" class="bodytext_link">Edit</a></td>
							  <td align="center" valign="top"><input name="chkSelect[]" id="chkSelect1" type="checkbox" value="<?=$data['user_id'];?>" class="checkboxstyle"></td>
							</tr>
							<?
							}
							?>
							<tr align="left" valign="top" class="box-bg">
							  <td colspan="7" align="left" valign="middle"><? echo $pg_obj->pageingHTML;?> &nbsp;</td>
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