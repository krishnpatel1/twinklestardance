<?php
include("includes/connection.php");
include("includes/all_form_check.php");
//include("includes/message.php");

if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];

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

$sql=$obj->selectData(TABLE_USER,"","user_pid='$user_id' and user_status<>'Deleted'".$extra."  order by user_first_name desc",2);
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
					<td height="40" align="left" valign="top"><h1>User</h1></td>
				    <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="listall_videos.php">Watch Videos</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_profile.php">Profile</a></td>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_document.php">My Documents</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_category.php">Manage Galleries</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="list_video.php">Manage Videos</a></td>
						</tr>
                      </table></td>
				  </tr>
				</table>
				</td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top">
				<table width="733">
				<tr>
				<td width="610"><?=$obj->display_message("message");?></td>
				<td width="111" align="right"><a href="user_edit.php" class="red_link">Add New User</a></td>
				</tr>
				</table>
				
				</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
				
				<!--Via phone (925) 447-5299<br /><br />
				Via email: <a href="mailto:info@twinklestardance.com">info@twinklestardance.com</a><br /><br />
				Via facebook:  <a href="https://www.facebook.com/pages/Twinkle-Star-Dance-Program/244317095622502" target="_blank">https://www.facebook.com/pages/Twinkle-Star-Dance-Program/244317095622502</a>-->				</td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              
			  
			  
              
			  
			  <tr>
                <td align="left" valign="top" class="home_content">
				
				<table width="100%"  border="0" cellpadding="3" cellspacing="2" class="gry_border">
					
						<form name="form1" method="post" action="">
						  <? if($pg_obj->totrecord){?>
							<tr align="center" valign="middle">
							  
							  <th width="49" align="center" valign="middle" class="bodytext_title_white">#</th>
							  <th width="150" align="left" valign="middle" class="bodytext_title_white">Name</th>
							  <th width="300" align="left" valign="middle" class="bodytext_title_white">Contacts</th>
							  <?php /*?><th width="300" align="left" valign="middle" class="bodytext_title_white">Address</th><?php */?>
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
							<tr align="left" valign="top">
							  <td align="center" valign="top" class="box_pink"><?=$i++; ?></td>
							  <td align="left" valign="top" style="font-weight:bold;" class="box_pink">
							  <?php // echo $obj->getImageThumb(USER_IMG,$data['user_image'],'','','100','100','../');?>
							  <?=$name; ?>							  </td>
							  <td align="left" valign="top" class="box_pink">
							  	<b>E</b> :&nbsp;<?=$data['user_email'];?><br/>
								<b>P</b> :&nbsp;<?=$data['user_phone'];?><br/>
							  </td>
							  <?php /*?><td align="left" valign="middle" class="box_pink">
							  	<?=$data['user_add_1'];?><br/>
								<span style="font-size:11px; font-weight:bold;">City:</span>&nbsp;<?=$data['user_city'];?><br/>
								<span style="font-size:11px; font-weight:bold;">State:</span>&nbsp;<?=$data['user_state'];?><br/>
								<span style="font-size:11px; font-weight:bold;">Zip/Postal Code:</span>&nbsp;<?=$data['user_zip'];?><br/>
							  </td><?php */?>
							  <td align="center" valign="middle" class="box_pink"><?=$data['user_status'];?></td>
							  <td align="center" valign="middle" class="box_pink"><a href="user_edit.php?id=<?=$data['user_id'];?>&return_url=<?=urlencode($_SERVER['REQUEST_URI']);?>" class="bodytext_link">Edit</a></td>
							  <td align="center" valign="middle" class="box_pink"><input name="chkSelect[]" id="chkSelect1" type="checkbox" value="<?=$data['user_id'];?>" class="checkboxstyle"></td>
							</tr>
							<?
							}
							?>
							<tr align="left" valign="top">
							  <td colspan="5" align="left" valign="middle"><? echo $pg_obj->pageingHTML;?> &nbsp;</td>
							  <td align="center" valign="middle"><? if($pg_obj->totrecord){?>
						      <input name="btnDelete" id="btnDelete" type="submit" class="submit" value="Delete" onClick="return validate_delete('chkSelect1');" /><? }?></td>
							</tr>
						  </form>
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
