<?php
require_once("../includes/connection.php");
adminSecure();
if($_REQUEST['id']) $id=$_REQUEST['id'];
else $id=1;

if($_POST['Submit'])
{
	$obj->updateData(TABLE_CONTENT,$_POST,"content_id='".$id."'");
	$msg='Content Updated!';
}

$sql=$obj->selectData(TABLE_CONTENT,"","content_id='".$id."'",1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
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
              <h3 class="icon-head head-promo-catalog">Basic Content Management</h3></td>
              <td class="form-buttons">&nbsp;</td>
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
						<form name="form1" id="form1" method="post" action="<?=$_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
						<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="bodytext">
						<? if($msg){?>
						<tr class="tr_bg">
						<td height="25" align="left" valign="middle" class="blk_textLftPadding">
						<span class="error">
						<?=$msg?>
						</span></td>
						</tr>
						<? }?>
						<tr class="tr_bg">
						<td align="left" valign="bottom" class="black_text2"><b>Page Name :</b></td>
						</tr>
						<tr class="tr_bg">
						<td height="30" align="left" valign="top" class="blk_textLftPadding">
						<select name="pagename"  class="input" id="client_type" style="width:200px" onChange="javascript:window.location.href='content_management.php?id='+this.value">
							<?=$obj->selectContent("",$id)?>
						</select>
						 </td>
						</tr>
						<tr class="tr_bg">
						<td align="left" valign="bottom" class="black_text2"><b>Page Content :</b></td>
						</tr>
						<tr class="tr_bg">
						<td height="25" align="left" valign="top" class="black_text2"><? 
						require_once(FCKPATH.'/fckeditor.php');
						$oFCKeditor = new FCKeditor('content_description') ;
						$oFCKeditor->BasePath	=FCKPATH."/" ;
						$oFCKeditor->Height	= 500 ;
						$oFCKeditor->Width	= 800 ;
						$oFCKeditor->Value	=html_entity_decode($sql['content_description']);								
						$oFCKeditor->Create() ; ?></td>
						</tr>
						<tr class="tr_bg">
						<td height="25" align="left" valign="top" class="black_text2">&nbsp;</td>
						</tr>
						<tr class="tr_bg">
						<td height="40" align="center" valign="middle" class="blk_textLftPadding"><input type="submit" name="Submit" value="Update" class="submit"></td>
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
</body>
</html>