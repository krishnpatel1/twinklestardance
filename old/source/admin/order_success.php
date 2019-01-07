<?php
require_once("../includes/connection.php");
adminSecure();
$chkSelectPackage=$_POST['package_ids'];

$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'package_management.php';

$obj->add_message("message","Order is placed successfully.");
$_SESSION['messageClass'] = 'success';
			
			
/*if($_POST['btnSubmit']=='Order')
{
$package_ids $_POST['package_ids'];

$order_array['order_user'] = $_POST['user_id'];
$order_array['order_date'] = date("Y-m-d H:i:s");
$order_array['order_pay'] = 'Paid';
$order_array['order_sub_total'] = 0;
$order_array['order_total'] = 0;
$order_array['order_status'] = 2;
$order_array['order_delete'] = 'No';

$obj->insertData(TABLE_ORDER,$order_array);
$newOrderId = mysql_insert_id();


if(is_array($package_ids)){
	foreach($package_ids as $key => $value){
		$order_details['od_order'] = $newOrderId;
		$order_details['od_pro_type'] = 'P';
		$order_details['od_price_type'] = 'onetime';
		$order_details['od_pro'] = $value;
		$order_details['od_price'] = 0;
		$order_details['od_payment_status'] = 'Paid';
		$order_details['od_package_status'] = 'Yes';
		$obj->insertData(TABLE_ORDER_DETAIL,$order_details);
	}
}


if(is_array($package_ids)){
	foreach($package_ids as $key => $value){
		$videos = $_POST['videos_'.$value];
		if(is_array($videos)){
			foreach($$videos as $key1 => $value1){
				$order_video['order_video_uid'] = $_POST['user_id'];
				$order_video['order_video_oder'] = $newOrderId;
				$order_video['order_video_package'] = $value;
				$order_video['order_video_gallery'] = $value1;
				$order_video['order_video_status'] = 'Active';
				$order_video['order_video_add_date'] = date("Y-m-d H:i:s");
				$obj->insertData(TABLE_ORDER_VIDEO,$order_video);
			}
		}
	}
}

$obj->reDirect("order_success.php");

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
                <h3 class="icon-head head-promo-catalog">Order Success</h3></td>
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
              <?php /*?><form action="order_package.php" method="post" enctype="multipart/form-data" name="frm" id="frm">
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tableborder_gray">				  
				  <tr>
				    <td align="left" valign="middle" class="bodytext">Select User:</td>
				    <td align="left" valign="middle" class="bodytext">
					<select name="user_id">
						<?= $obj->getUserList();?>
					</select>
					</td>
			      </tr>
				  
				 <?php 
				 if(is_array($chkSelectPackage)){
				 	foreach($chkSelectPackage as $key => $value){
						$videos_array = $_POST['videos_'.$value];
						$data = $obj->selectData(TABLE_PACKAGE,"","package_id='".$value."'",1);
					?>
					<input type="hidden" name="package_ids[]" value="<?= $value;?>">
					<tr>
						<td width="20%" align="left" valign="middle" class="bodytext"><?= $data['package_name']?></td>
						<td align="left" valign="middle" class="bodytext"><?= $obj->getVideoListFromVideoIds($videos_array,$value);?></td>
                    </tr>	
				<?php	}
				 }
				 ?>  
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
                  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">&nbsp;</td>
                    <td align="left" valign="middle"><input name="btnSubmit" type="submit" class="submit" id="btnSubmit" value="Order" /></td>
                  </tr>
                </table>
              </form><?php */?>
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
