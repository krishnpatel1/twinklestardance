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
		
		/*if($_FILES['package_document']['tmp_name'])
		{
			list($fileName2,$error)=$obj->uploadFile('package_document', "../".PACKAGE_IMG, 'gif,jpg,png,jpeg,pdf,doc');
			if($error)
			{
				$msg=$error;
				$err=1;
			}
			else
			{
				$_POST['package_document']=$fileName2;
			}
		}*/
		
	}

	if(!$err)
	{
		if(is_array($_POST['products'])){
			$_POST['package_product_list'] = implode(",",$_POST['products']);
		}else{
			$_POST['package_product_list'] = "";
		}
		
		if(is_array($_POST['gallery_category_ids'])){
			$categories = implode(",",$_POST['gallery_category_ids']);
			$_POST['gallery_category_ids'] = $categories;
		}
		
		if(is_array($_POST['package_additional_id'])){
			$addition_package = implode(",",$_POST['package_additional_id']);
			$_POST['package_additional_id'] = $addition_package;
		}
		
		if(is_array($_POST['update_package_id'])){
			$update_package = implode(",",$_POST['update_package_id']);
			$_POST['update_package_id'] = ",".$update_package.",";
		}else{
			$_POST['update_package_id'] = "";
		}
		
		if($package_id)
		{
			if($_POST['package_additional_id']=='')
			{
				$_POST['package_additional_id']=" ";
			}
			
			isset($_POST['package_additional'])?$is_additional='Yes':$is_additional='No';
			$_POST['package_additional']=$is_additional;
			
			$_POST['date_edited']=CURRENT_DATE_TIME;
			$obj->updateData(TABLE_PACKAGE,$_POST,"package_id='".$package_id."'");
			$obj->add_message("message","Package Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			isset($_POST['package_additional'])?$is_additional='Yes':$is_additional='No';
			$_POST['package_additional']=$is_additional;
			
			$_POST['date_added']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_PACKAGE,$_POST);
			$obj->add_message("message","Subscription Added Successfully!");
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
	
	<?php if($data['package_additional']=='Yes'){?>
		show_additional('<?=$data['package_additional']?>','<?=$data['package_additional_id']?>','<?=$data['package_id']?>');
	<? } ?>
});

function show_additional(is_additional,addition_ids,package_id)
{
	if(document.getElementById("package_additional").checked==true)
	{
		var opt=1;
	}
	else
	{
		var opt=0;
	}
	jQuery.ajax({
	type: "POST",
	url: "ajax_additional_package.php",
	data: "opt="+opt+"&is_additional="+is_additional+"&addition_ids="+addition_ids+"&package_id="+package_id,
	success: function(msg){
			$('#field').html(msg);
		}
	});
}
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
                  <? if($package_id){?>Edit<? }else{?>Add<? }?> Subscription <? if($data['package_title']){?>[<?=$data['package_title'];?>]<? }?></h3></td>
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
						<input name="package_name" type="text" class="field_gray required" id="package_name" value="<?=$data['package_name'];?>" size="60" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Description:</td>
                    <td align="left" valign="middle" class="bodytext">
					 <? 
							require_once(FCKPATH.'/fckeditor.php');
							$oFCKeditor = new FCKeditor('package_description') ;
							$oFCKeditor->BasePath	=FCK_PATH."/" ;
							$oFCKeditor->Height	= 300 ;
							//$oFCKeditor->Width	= 500 ;
							$oFCKeditor->Value	=html_entity_decode($data['package_description']);								
							$oFCKeditor->Create() ; 
					  ?>
					  </td>
                  </tr>
				  
				  
				  <tr>
				  	<td colspan="2"><strong>One Time Pricing</strong></td>
				  </tr>
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Price :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;$&nbsp;<input name="package_price_onetime" type="text"  id="package_price_onetime" class="required digit" value="<?=$data['package_price_onetime'];?>" size="15" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  
					<tr>
				  		<td colspan="2"><strong>Subscription Pricing</strong></td>
				  	</tr>
				  
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Price :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;$&nbsp;<input name="package_price_subscription" type="text" class="required digit"  id="package_price_subscription" value="<?=$data['package_price_subscription'];?>" size="15" />
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Duration :</td>
                    <td align="left" valign="middle" class="bodytext">
						&nbsp;&nbsp;<input name="package_duration" type="text" class="required"  id="package_duration" value="<?=$data['package_duration'];?>" size="15" /> Months<!--Years-->
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				   <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Subscription Image :</td>
                    <td align="left" valign="middle" class="bodytext"><input type="file" name="package_image" /></td>
                  </tr>
				  <? if($data['package_image']!=""){?>
				  <tr class="box-bg">
                          <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                          <td align="left" valign="middle">
						 <?=$obj->getImageThumb(PACKAGE_IMG,$data['package_image'],'','','100','100','../');?></td>
                  </tr>
				  <? }?>
				  
				 <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Delivery Qty :</td>
                    <td align="left" valign="middle" class="bodytext">&nbsp;
						<select name="package_delivery_qty" id="package_delivery_qty" style="width:80px;">
							<option value="">All</option>
							<?php
								for($i=1;$i<=20;$i++)
								{
							?>
							<option value="<?=$i?>" <? if($data['package_delivery_qty']==$i) {?> selected="selected" <? }?>><?=$i?></option>
							<?php }?>
						</select>
					</td>
                  </tr>
				 
				  <tr>
                    <td width="20%" align="left" valign="middle" class="bodytext">Gallery :</td>
                    <td align="left" valign="middle" class="bodytext">
						<?php echo $obj->getGalleryList('gallery_category_ids',$data['gallery_category_ids']);?>
						&nbsp;<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Additional Package:</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="checkbox" name="package_additional" id="package_additional" value="" <? if($data['package_additional']=='Yes') {?> checked="checked" <? }?> onClick="show_additional()">
					</td>
                </tr>
				<tr class="box-bg">
					<td align="left" colspan="2">
						<div id="field"></div>
					</td>
				</tr>
				<tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Only visible to subscribers of:</td>
                    <td align="left" valign="middle" class="bodytext">
						<?php echo $obj->getUpdatePackageList('update_package_id',$data['update_package_id'],$data['package_id']); ?>
					</td>
                </tr>
				<?php /*?><tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Upload Document:</td>
                    <td align="left" valign="middle" class="bodytext">
						<input type="file" name="package_document" />
					</td>
                </tr><?php */?>
				 <?php /*?> <? if($data['package_document']!=""){?>
				  <tr class="box-bg">
                          <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
                          <td align="left" valign="middle">
						  <a href="<?php echo '../'.PACKAGE_IMG.$data['package_document']; ?>" target="_blank"><?php echo $data['package_document'];?></a>
						  </td>
                  </tr>
				  <? }?>
				<tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Enter Document Link:</td>
                    <td align="left" valign="middle" class="bodytext">
						<input name="package_doc_link" type="text"  id="package_doc_link" value="<?=$data['package_doc_link'];?>" size="60" />
					</td>
                </tr><?php */?>
					
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
