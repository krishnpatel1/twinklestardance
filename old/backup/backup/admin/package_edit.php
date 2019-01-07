<?php
require_once("../includes/connection.php");
adminSecure();
$package_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'package_management.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	if($package_id)
	{
		$ex_cond=" and package_id!='".$package_id."'";
	}
	if(!$err)
	{
		if($_FILES['package_image']['tmp_name'])
		{
			list($fileName1,$error)=$obj->uploadFile('package_image', "../".PACKAGE_IMG, 'gif,jpg,png,jpeg');
			if($error)
			{
				$msg=$error;
				$err=1;
			}
			else
			{
				$_POST['package_image']=$fileName1;
			}
		}
		
	}

	if(!$err)
	{
		if(is_array($_POST['products'])){
			$_POST['package_product_list'] = implode(",",$_POST['products']);
		}else{
			$_POST['package_product_list'] = "";
		}
		
		if($package_id)
		{
			$_POST['date_edited']=CURRENT_DATE_TIME;
			$obj->updateData(TABLE_PACKAGE,$_POST,"package_id='".$package_id."'");
			$obj->add_message("message","Package Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			$_POST['date_added']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_PACKAGE,$_POST);
			$obj->add_message("message","Package Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($package_id!="")
{
	$data = $obj->selectData(TABLE_PACKAGE,"","package_id='".$package_id."'",1);
	$package_title=$data['package_title'];
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
                  <? if($package_id){?>Edit<? }else{?>Add<? }?> Package <? if($data['package_title']){?>[<?=$data['package_title'];?>]<? }?></h3></td>
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
                    <td width="20%" align="left" valign="middle" class="bodytext">Package
                      Title  :</td>
                    <td align="left" valign="middle" class="bodytext">
						<input name="package_name" type="text" class="field_gray required" id="package_name" value="<?=$data['package_name'];?>" size="60" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				 <?php /*?> <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Product:</td>
                    <td align="left" valign="middle" class="bodytext">
					  <?php 
						$fetchProductQuery = $obj->selectData(TABLE_ONLINE_PRODUCT,"","product_status='Active'");
						while($productData = mysql_fetch_array($fetchProductQuery)):
							$productListArr = explode(",",$data['package_product_list']);
						?>
							<input type="checkbox" name="products[]" <?php if(in_array($productData['product_id'],$productListArr)):?> checked="checked" <?php endif;?> value="<?php echo $productData['product_id']?>"><?php echo $productData['product_name']?><br />
						<?php endwhile; ?>
					</td>
                  </tr><?php */?>
				  
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Package Description:</td>
                    <td align="left" valign="middle" class="bodytext">
					 <? 
							require_once(FCKPATH.'/fckeditor.php');
							$oFCKeditor = new FCKeditor('package_description') ;
							$oFCKeditor->BasePath	=FCK_PATH."/" ;
							$oFCKeditor->Height	= 300 ;
							$oFCKeditor->Width	= 500 ;
							$oFCKeditor->Value	=html_entity_decode($data['package_description']);								
							$oFCKeditor->Create() ; 
					  ?>
					  </td>
                  </tr>
				  
				  
				  <tr>
				  	<td colspan="2"><strong>One Time Pricing</strong></td>
				  </tr>
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Package Price :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;$&nbsp;<input name="package_price_onetime" type="text"  id="package_price_onetime" class="required" value="<?=$data['package_price_onetime'];?>" size="15" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  
					<tr>
				  		<td colspan="2"><strong>Subscription Pricing</strong></td>
				  	</tr>
				  
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Package Price :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;$&nbsp;<input name="package_price_subscription" type="text" class="required"  id="package_price_subscription" value="<?=$data['package_price_subscription'];?>" size="15" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Package Duration :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;&nbsp;<input name="package_duration" type="text" class="required"  id="package_duration" value="<?=$data['package_duration'];?>" size="15" /> Months<!--Years-->
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				<tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Package Image :</td>
                    <td align="left" valign="middle" class="bodytext"><input type="file" name="package_image" /></td>
                  </tr>
				  <? if($data['package_image']!=""){?>
				  <tr class="box-bg">
                          <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                          <td align="left" valign="middle">
						 <?=$obj->getImageThumb(PACKAGE_IMG,$data['package_image'],'','','100','100','../');?></td>
                  </tr>
				  <? }?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
					
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Package Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="package_status" value="Active" checked="checked"> Active 
					<input type="radio" name="package_status" value="Inactive" <? if($data['package_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive</td>
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
