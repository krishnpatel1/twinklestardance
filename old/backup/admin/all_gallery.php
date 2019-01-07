<?php
require_once("../includes/connection.php");
adminSecure();
$chkSelectPackage=$_REQUEST['chkSelectPackage'];
if(is_array($chkSelectPackage)){
	foreach($chkSelectPackage as $key => $value)
	{ 
		$pack_type[$value]=$_REQUEST['pack_type_'.$value];
	}
}
$p_type=serialize($pack_type);
$p_type=unserialize(stripslashes($p_type));

$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'package_management.php';


if($chkSelectPackage == ""){
	$chkSelectPackage = $_SESSION['p_ids'];
	$p_type=$_SESSION['pack_type'];
	$p_type=unserialize(stripslashes($p_type));
	
	//echo '<pre>';
	//print_r($_SESSION['vids']);
}

//print_r($p_type);

/*if($_POST['btnSubmit']=='Save')
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
		
		if(is_array($_POST['gallery_category_ids'])){
			$categories = implode(",",$_POST['gallery_category_ids']);
			$_POST['gallery_category_ids'] = $categories;
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
			$obj->add_message("message","Subscription Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}*/

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
<script language="javascript">
function selectCheckAll(chackboxname,value)
{
	$("input[id="+chackboxname+"]").attr('checked',value);
}

function validate_proceed(chackboxname,obj)
{
return true;
	var chk = $("input[id="+chackboxname+"]:checked").length;
	
	if( $("input[id="+chackboxname+"]").is(':checked'))
	{
		if(chk <= 2){
			return true;
		} else {
			alert("You can select at most 2 videos!");
	   		return false;
		}	
	
	}
	else
	{
		alert("Please select at least one package to proceed");
	    return false;
	}
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
                <h3 class="icon-head head-promo-catalog">Select Videos Under Packages</h3></td>
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
              <form action="order_package.php" method="post" enctype="multipart/form-data" name="frm" id="frm">
			  <input type="hidden" name="p_type" value='<?=serialize($p_type)?>'>
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">				  
				 <?php /*?><tr>
				    <td align="left" valign="middle" class="bodytext">Gallery Included :</td>
				    <td align="left" valign="middle" class="bodytext"><?php echo $obj->getGalleryList('gallery_category_ids',$data['gallery_category_ids']);?></td>
			      </tr><?php */?>
				  
				 <?php 
				 if(is_array($chkSelectPackage)){
				 	foreach($chkSelectPackage as $key => $value){ 
						
						$data = $obj->selectData(TABLE_PACKAGE,"","package_id='".$value."'",1);
						//echo $p_type[$value];
						if($p_type[$value]=='onetime')
						{
							$price=$data['package_price_onetime'];
						}
						if($p_type[$value]=='subscription')
						{
							$price=$data['package_price_subscription'];
						}
						
					?>
					<input type="hidden" name="package_ids[]" value="<?= $data['package_id']?>">
					<tr>
                    <td width="20%" align="left" valign="middle" class="bodytext"><?= $data['package_name']?>
					<br><br>
					<label style="float:left; font-weight:600; cursor: pointer;"><input type="checkbox" onclick="toggleChecked<?= $value?>(this.checked)"> Select / Deselect All</label>
					<script>
					function toggleChecked<?= $value?>(status) {
						$("input[name='videos_<?= $value?>[]']").each( function() {
						$(this).attr("checked",status);
						})
					}
					</script>
					</td>
                    <td align="left" valign="middle" class="bodytext">
						<?= $obj->getVideoListFromPackage($value,$_SESSION['vids']);?></td>
                    <td align="left" valign="middle" class="bodytext">$<?= number_format($price,2)?></td>
				  </tr>	
				<?php	}
				 }
				 ?>  
                  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle"><input name="btnSubmit" type="submit" class="submit" id="btnSubmit" value="Proceed" /></td>
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
