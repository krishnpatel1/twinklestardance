<?php
require_once("../includes/connection.php");
adminSecure();
$package_id=$_REQUEST['package_id'];
$doc_id=$_REQUEST['doc_id'];

$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'package_document.php?id='.$package_id;

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	if(!$err)
	{
		if($_FILES['doc_package_document']['tmp_name'])
		{
			list($fileName2,$error)=$obj->uploadFile('doc_package_document', "../".PACKAGE_IMG, 'gif,jpg,png,jpeg,pdf,doc');
			if($error)
			{
				$msg=$error;
				$err=1;
			}
			else
			{
				$_POST['doc_package_document']=$fileName2;
			}
		}
		
	}
	if(!$err)
	{
		if($doc_id)
		{
			$obj->updateData(TABLE_PACKAGE_DOCUMENT,$_POST,"doc_id='".$doc_id."'");
			$obj->add_message("message","Document Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			
			$_POST['doc_package_id']=$_REQUEST['id'];
			$_POST['doc_add_date']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_PACKAGE_DOCUMENT,$_POST);
			$obj->add_message("message","Document Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($doc_id!="")
{
	$data = $obj->selectData(TABLE_PACKAGE_DOCUMENT,"","doc_id='".$doc_id."'",1);
	$doc_title=$data['doc_title'];
	$package_id=$data['doc_package_id'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<script language="javascript">
$(document).ready(function() {
	var prevUrl="<?=$return_url ?>";
	$("#frm").validate({
		rules: {
			down_type_id: {
				required: true
			},
			package_title:{
				required:true
			},
			package_price: {
				required: true,
				number: true
			}
								
		},
		messages: {
			down_type_id: {
				required: "Please Select Download Type"
			},
			package_title: {
				required: "Please enter the title"
			},
			package_price: {
				required: "Please enter Price",
				number: "Please enter digits only" 
			}
		}
	});	

	$("#btnCancel").click(function(){
			window.location.replace(prevUrl);
	});
	$("#frm").validate();

});


</script>

</head>
<body id="html-body" class=" adminhtml-promo-catalog-index">
 <?php include('head.php'); ?>
  <div class="middle" id="anchor-content">
    <div id="">
      <div class="content-header">
        <table width="100%" cellspacing="0">
          <tbody>
            <tr>
              <td><img src="images/icon/change_password.gif" alt="Change Password" width="24" height="24" border="0" class="admin_icon"/>
                <h3 class="icon-head head-promo-catalog">
                  <? if($doc_id){?>Edit<? }else{?>Add<? }?> Document <? if($data['doc_title']){?>[<?=$data['doc_title'];?>]<? }?></h3></td>
              <td class="form-buttons">&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div>
        <div id="promo_catalog_grid">
          <div class="grid">
            <div class="hor-scroll">
              <?=$obj->display_message("message");?>
              <form action="" method="post" enctype="multipart/form-data" name="frm" id="frm">
			   <input type="hidden" name="id" value="<?=$package_id?>">
			    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">
					<tr class="box-bg">
						<td align="left" valign="middle" class="bodytext">Document / Link Title:</td>
						<td align="left" valign="middle" class="bodytext">
							<input name="doc_title" type="text" class="field_gray required"  id="doc_title" value="<?=$data['doc_title'];?>" size="60" />
						</td>
					</tr>
					<tr class="box-bg">
						<td align="left" valign="middle" class="bodytext">Upload Document:</td>
						<td align="left" valign="middle" class="bodytext">
							<input type="file" name="doc_package_document" />
						</td>
					</tr>
					  <? if($data['package_document']!=""){?>
					  <tr class="box-bg">
							  <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
							  <td align="left" valign="middle">
							  <a href="<?php echo '../'.PACKAGE_IMG.$data['doc_package_document']; ?>" target="_blank"><?php echo $data['doc_package_document'];?></a>
							  </td>
					  </tr>
					  <? }?>
					<tr class="box-bg">
						<td align="left" valign="middle" class="bodytext">Enter Document Link:</td>
						<td align="left" valign="middle" class="bodytext">
							<input name="doc_package_link" type="text"  id="doc_package_link" value="<?=$data['doc_package_link'];?>" size="60" />
						</td>
					</tr>
						
					  <tr class="box-bg">
						<td align="left" valign="middle" class="bodytext">Package Status  :</td>
						<td align="left" valign="middle" class="bodytext">
						<input type="radio" name="doc_status" value="Active" checked="checked"> Active 
						<input type="radio" name="doc_status" value="Inactive" <? if($data['doc_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive</td>
					  </tr>
					  <tr class="box-bg">
						<td align="left" valign="middle" class="bodytext">&nbsp;</td>
						<td align="left" valign="middle"><input name="btnSubmit" type="submit" class="button" id="btnSubmit" value="Save" />
						  <input name="btnCancel" type="button" class="button" id="btnCancel" value="Cancel"/>
						  <span class="bodytext"> </span></td>
					  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>
</html>
