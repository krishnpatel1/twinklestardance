<?php
require_once("../includes/connection.php");
adminSecure();
$price_id=$_REQUEST['id'];
$prod_id=$_REQUEST['prod_id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'price_list.php?id='.$prod_id;

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	if($price_id)
	{
		$price=$obj->selectData(TABLE_PRICELIST,"","price_download_type='".$obj->filterData($_POST['down_type_id'],0)."'  and  price_status<>'Deleted' and price_product='".$prod_id."' and price_id!='".$price_id."'",1);
		if($price!=0)
		{
			$err=1;
			$obj->add_message("message","This Data Already Exist, please Try Another.");
		}
	}
	else
	{
		$price=$obj->selectData(TABLE_PRICELIST,"","price_download_type='".$obj->filterData($_POST['down_type_id'],0)."'  and  price_status<>'Deleted' and price_product='".$prod_id."'",1);
		if($price!=0)
		{
			$err=1;
			$obj->add_message("message","This Data Already Exist, please Try Another.");
		}
	}
	if(!$err)
	{
		if($price_id)
		{
			$_POST['price_product']=$prod_id;
			$_POST['price_download_type']=$_REQUEST['down_type_id'];
			$_POST['price']=$_REQUEST['price'];
			$obj->updateData(TABLE_PRICELIST,$_POST,"price_id='".$price_id."'");
			$obj->add_message("message","Price Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
			//$obj->reDirect($return_url);
		}else{
			$_POST['price_add_date']=CURRENT_DATE_TIME;
			$_POST['price_product']=$prod_id;
			$_POST['price_download_type']=$_REQUEST['down_type_id'];
			$_POST['price']=$_REQUEST['price'];
			$obj->insertData(TABLE_PRICELIST,$_POST);
			$obj->add_message("message","Price Added Successfully!");
			$_SESSION['messageClass'] = 'success';
			//$obj->reDirect($return_url);
		}
		$obj->reDirect($return_url);
	}
}

if($price_id!="")
{
	$data = $obj->selectData(TABLE_PRICELIST,"","price_id='".$price_id."'",1);
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
			down_type_id:{
				required:true
			},
			price: {
				required: true,
				number: true
			}
		},
		messages: {
			down_type_id:{
				required:"Please Select Download Type"
			},
			price: {
				required: "Please Enter Price",
				number: "Please enter digits only"
			}
		}
	});	

	$("#btnCancel").click(function(){
			window.location.replace(prevUrl);
	});
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
              <td><img src="images/icon/all_user.gif" alt="" width="24" height="24" border="0" class="admin_icon"/>
                <h3 class="icon-head head-promo-catalog">
                  <? if($price_id){?>Edit<? }else{?>Add<? }?> Price</h3></td>
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
              <form action="" method="post" name="frm" id="frm">
                <input type="hidden" name="prod_id" value="<?=$prod_id?>">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Product Type  :&nbsp;<span style="color:#FF0000;">*</span></td>
                    <td align="left" valign="middle" class="bodytext">
						<select name="down_type_id" id="down_type_id" style="width:200px;" validate="required:true">
							<option value="">--Select--</option>
							<?=$obj->select_downloadType($data['price_download_type'])?>
						</select>
					</td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Price :&nbsp;<span style="color:#FF0000;">*</span></td>
                    <td align="left" valign="middle" class="bodytext">
						<input type="text" name="price" id="price" value="<?=$data['price']?>">	
					</td>
                  </tr>
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Price Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="price_status" value="Active" checked="checked"> Active 
					<input type="radio" name="price_status" value="Inactive" <? if($data['price_status']=='Inactive'){?>checked="checked"<? } ?>>Inactive</td>
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
