<?php
require_once("../includes/connection.php");
adminSecure();
$down_type_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'download_type.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	
	if($down_type_id)
	{
		$ex_cond=" and down_type_id!='".$down_type_id."'";
	}
	$row_cat=$obj->selectData(TABLE_DOWNLOADTYPE,"","down_type_name='".$obj->filterData($_POST['down_type_name'],0)."' ".$ex_cond." and down_type_status<>'Deleted'",1);
	if($row_cat!=0)
	{
		$err=1;
		$msg ='This Download Type Already exist, please try another.';
	}
	
	if(!$err)
	{
		if($down_type_id)
		{
			$obj->updateData(TABLE_DOWNLOADTYPE,$_POST," down_type_id='".$down_type_id."'");
			$obj->add_message("message","Download Type Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			$_POST['blog_cat_added']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_DOWNLOADTYPE,$_POST);
			$obj->add_message("message","Download Type Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($down_type_id!="")
{
	$data = $obj->selectData(TABLE_DOWNLOADTYPE,"","down_type_id='".$down_type_id."'",1);
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
			down_type_name : {
				required: true
			}
			 					
		},
		messages: {
			down_type_name : {
				required: "Please Enter Download Type !"
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
              <td><img src="images/icon/change_password.gif" alt="Change Password" width="24" height="24" border="0" class="admin_icon"/>
                <h3 class="icon-head head-promo-catalog">
                  <? if($type_id){?>Edit<? }else{?>Add<? }?> Product Type Listings <? if($data['down_type_name']){?>[<?=$data['down_type_name'];?>]<? }?></h3></td>
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
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">
                  <?
				  	if(isset($msg) && $msg<>'')
					{
				  ?>
				  <tr class="box-bg">
                    <td width="20%">&nbsp;</td>
                    <td align="left" valign="middle" class="error"><?=$msg?></td>
                  </tr>
				  <? }?>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Download Type:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="down_type_name" type="text" class="field_gray required" id="down_type_name" value="<?=$data['down_type_name'];?>" size="40"/><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="down_type_status" value="Active" checked="checked"> Active 
					<input type="radio" name="down_type_status" value="Inactive" <? if($data['down_type_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive
					</td>
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

