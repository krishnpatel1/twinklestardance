<?php
require_once("../includes/connection.php");
adminSecure();
$sp_package_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'special_package_management.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	if($sp_package_id)
	{
		$ex_cond=" and sp_package_id!='".$sp_package_id."'";
	}
	if(!$err)
	{
		if($_FILES['sp_package_image']['tmp_name'])
		{
			list($fileName1,$error)=$obj->uploadFile('sp_package_image', "../".PACKAGE_IMG, 'gif,jpg,png,jpeg');
			if($error)
			{
				$msg=$error;
				$err=1;
			}
			else
			{
				$_POST['sp_package_image']=$fileName1;
			}
		}
		
	}

	if(!$err)
	{
		if(is_array($_POST['packages'])){
			$_POST['sp_package_list'] = implode(",",$_POST['packages']);
		}else{
			$_POST['sp_package_list'] = "";
		}
		if($sp_package_id)
		{
			$_POST['date_edited']=CURRENT_DATE_TIME;
			$obj->updateData(TABLE_SPECIAL_PACKAGE,$_POST,"sp_package_id='".$sp_package_id."'");
			$obj->add_message("message","Package Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			$_POST['date_added']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_SPECIAL_PACKAGE,$_POST);
			$obj->add_message("message","Subscription Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($sp_package_id!="")
{
	$data = $obj->selectData(TABLE_SPECIAL_PACKAGE,"","sp_package_id='".$sp_package_id."'",1);
	$sp_package_title=$data['sp_package_title'];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<script>
$(document).ready(function(){
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
                  <? if($sp_package_id){?>Edit<? }else{?>Add<? }?> Subscription <? if($data['sp_package_title']){?>[<?=$data['sp_package_title'];?>]<? }?></h3></td>
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
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">

				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription
                      Title  :</td>
                    <td align="left" valign="middle" class="bodytext">
						<input name="sp_package_name" type="text" class="field_gray required" id="sp_package_name" value="<?=$data['sp_package_name'];?>" size="40" maxlength="50" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Description:</td>
                    <td align="left" valign="middle" class="bodytext">
					 <? 
							require_once(FCKPATH.'/fckeditor.php');
							$oFCKeditor = new FCKeditor('sp_package_description') ;
							$oFCKeditor->BasePath	=FCK_PATH."/" ;
							$oFCKeditor->Height	= 300 ;
							$oFCKeditor->Width	= 500 ;
							$oFCKeditor->Value	=html_entity_decode($data['sp_package_description']);								
							$oFCKeditor->Create() ; 
					  ?>
					  </td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription:</td>
                    <td align="left" valign="middle" class="bodytext">
					<?php 
					/* FETCH ALL ACTIVE PACKAGES */
					$fetchPackagesQuery = $obj->selectData(TABLE_PACKAGE,"","package_status='Active'");
					while($packageData = mysql_fetch_array($fetchPackagesQuery)):
						$packageListArr = explode(",",$data['sp_package_list']);
					?>
						<input type="checkbox" name="packages[]" <?php if(in_array($packageData['package_id'],$packageListArr)):?> checked="checked" <?php endif;?> value="<?php echo $packageData['package_id']?>"><?php echo $packageData['package_name']?><br />
					<?php endwhile; ?>
					
					  </td>
                  </tr>
				  <tr>
				  	<td colspan="2"><strong>One time Pricing</strong></td>
				  </tr>
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Price :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;$&nbsp;<input name="sp_package_price_onetime" type="text"  id="sp_package_price_onetime" class="required" value="<?=$data['sp_package_price_onetime'];?>" size="15" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  
				<tr>
				  		<td colspan="2"><strong>Subscription Pricing</strong></td>
				  	</tr>
				  
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Price :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;$&nbsp;<input name="sp_package_price_subscription" type="text" class="required"  id="sp_package_price_subscription" value="<?=$data['sp_package_price_subscription'];?>" size="15" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Duration :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;&nbsp;&nbsp;&nbsp;<input name="sp_package_duration" type="text" class="required"  id="sp_package_duration" value="<?=$data['sp_package_duration'];?>" size="15" /> Months
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
					<tr>
				  		<td colspan="2">&nbsp;</td>
				  	</tr>
					<tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Image :</td>
                    <td align="left" valign="middle" class="bodytext"><input type="file" name="sp_package_image" /></td>
                  </tr>
				  <? if($data['sp_package_image']!=""){?>
				  <tr class="box-bg">
                          <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                          <td align="left" valign="middle">
						 <?=$obj->getImageThumb(PACKAGE_IMG,$data['sp_package_image'],'','','100','100','../');?></td>
                  </tr>
				  <? }?>
					
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Subscription Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="sp_package_status" value="Active" checked="checked"> Active 
					<input type="radio" name="sp_package_status" value="Inactive" <? if($data['sp_package_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive</td>
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
