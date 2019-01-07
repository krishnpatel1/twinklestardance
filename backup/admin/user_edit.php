<?php
require_once("../includes/connection.php");
adminSecure();
$user_id=$_REQUEST['id'];
$return_url=urldecode($_REQUEST['return_url']);
$return_url=$return_url?$return_url:'user_management.php';

if($_POST['btnSubmit']=='Save')
{
	$_SESSION['messageClass'] = 'error';
	$data=$obj->filterData_array($_POST);
	if($user_id)
	{
		$ex_cond=" and user_id!='".$user_id."'";
	}
	$row_email=$obj->selectData(TABLE_USER,"","user_email='".$obj->filterData($_POST['user_email'],0)."' ".$ex_cond." and  user_status<>'Deleted'",1);
	if($row_email!=0)
	{
		$err=1;
		$msg ='This Email already exist, please Try Another.';
	}
	if(!$err)
	{
		if($_FILES['user_image']['tmp_name'])
		{
			list($fileName1,$error)=$obj->uploadFile('user_image', "../".USER_IMG, 'gif,jpg,png,jpeg');
			if($error)
			{
				$msg=$error;
				$err=1;
			}
			else
			{
				$_POST['user_image']=$fileName1;
			}
		}
		
	}
	if(!$err)
	{
		if($user_id)
		{
			$_POST['user_mod_date']=CURRENT_DATE_TIME;
			$obj->updateData(TABLE_USER,$_POST," user_id='".$user_id."'");
			$obj->add_message("message","User Updated Successfully!");
			$_SESSION['messageClass'] = 'success';
		}else{
			$_POST['user_reg_date']=CURRENT_DATE_TIME;
			$obj->insertData(TABLE_USER,$_POST);
			$obj->add_message("message","User Added Successfully!");
			$_SESSION['messageClass'] = 'success';
		}
		$obj->reDirect($return_url);
	}
}

if($user_id!="")
{
	$data = $obj->selectData(TABLE_USER,"","user_id='".$user_id."'",1);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
<script language="javascript" type="text/javascript">
function stateSelect(con,sid,fld,fl)
{ 
 //alert('hi');
$.ajax({ 
   type: "POST",
   url: "../ajax/state_user.php",
   data: "con="+con+"&sid="+sid+"&fld="+fld,
     success: function(msg){
      $('#'+fl).html(msg);
	 //alert(fl); 
	  citySelect('0','','user_city','city');
	 }
 });
} 			
function citySelect(st,cid,fld,fl)
{  
$.ajax({
   type: "POST",
   url: "../ajax/city_user.php",
   data: "st="+st+"&fld="+fld+"&cid="+cid,
   	  success: function(msg){
      $('#'+fl).html(msg);
	 }
 });
}
</script>
<script language="javascript">
$(document).ready(function() {
	var prevUrl="<?=$return_url ?>";
	$("#frm").validate({
		rules: {
			user_first_name: {
				required: true
			},
			 user_add_1: {
				required: true
			},
			user_email: {
				required: true,
				email: true
			},
			user_country:{
				required:true
			},
			user_state:{
				required:true
			},
			user_city:{
				required:true
			},
			 user_phone:{
				required: true,
				digits: true
			},
			user_zip:{
				required: true
			},
			password:{
				required: true
			}						
		},
		messages: {
			user_first_name: {
				required: "Please enter First Name"
			},
			user_add_1: {
				required: "Please enter the Address"
			},
			user_email: {
				required: "Please enter Email ID",
				email: "Enter Proper Email ID"
			},
			user_country:{
				required:"Please Select Country !"
			},
			user_state:{
				required:"Please Select State"
				},
			user_city:{
				required:"Please Enter City"
			},	
			user_phone: {
				required: "Please enter Phone No.",
				digits: "Please enter digits only" 
			},
			user_zip:{
				required: "Please Enter Zip."
			},
			password:{
				required: "Please Enter Password."
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
                  <? if($product_id){?>Edit<? }else{?>Add<? }?> User <? if($data['user_first_name']){?>[<?=$data['user_first_name'];?>]<? }?></h3></td>
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
                    <td width="20%" align="left" valign="middle" class="bodytext">First Name:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="user_first_name" type="text" class="field_gray" id="user_first_name" value="<?=$data['user_first_name'];?>" size="40"/><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Last Name:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="user_last_name" type="text" class="field_gray" id="user_last_name" value="<?=$data['user_last_name'];?>" size="40"/></td>
                  </tr>
				  <tr>
				  	<td align="left" valign="middle" class="bodytext">Gender</td>
					<td align="left" valign="middle" class="bodytext">
						<select name="user_gender" id="user_gender">
							<option>--Select--</option>
							<option value="Male" <? if($data['user_gender']=='Male'){ ?> selected="selected"<? }?>>Male</option>
							<option value="Female" <? if($data['user_gender']=='Female'){ ?>selected="selected"<? }?>>Female</option>
						</select>
					</td>
				  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Email:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="user_email" type="text" class="field_gray" id="user_email" value="<?=$data['user_email'];?>" size="40"/><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Phone:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="user_phone" type="text" class="field_gray" id="user_phone" value="<?=$data['user_phone'];?>" size="40"/><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Address 1:</td>
                    <td align="left" valign="middle" class="bodytext"><textarea name="user_add_1" id="user_add_1" rows="3" cols="50"><?=$data['user_add_1'];?></textarea><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Address 2:</td>
                    <td align="left" valign="middle" class="bodytext"><textarea name="user_add_2" id="user_add_2" rows="3" cols="50"><?=$data['user_add_2'];?></textarea></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Country:</td>
                    <td align="left" valign="middle" class="bodytext" id="state">
						<select name="user_country"  id="user_country" onChange="stateSelect(this.value,'<?=$data['user_country'];?>','user_state','user_state')" class="input" style="width:230px;">
								<?=$obj->countrySelect($data['user_country'])?>
						</select>
						<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">State:</td>
                    <td align="left" valign="middle" class="bodytext" id="user_state">
						<? 
							if($obj->hasStates($data['user_country']))
							{ 
								
							?>
							<select name="user_state" id="user_state" class="input" style="width:206px;" validate="required:true">
							<?
							echo  $obj->stateSelect($data['user_country'],$data['user_state']);
							?>
							</select>
							<? }else{?>
							<select name="user_state" id="user_state" class="input" style="width:230px;" validate="required:true">
								<option value="">--Select--</option>
							</select>
							<? }?>
						<span style="color:#FF0000;">*</span>
					</td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">City:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="user_city" type="text" class="field_gray" id="user_city" value="<?=$data['user_city'];?>" size="40"/><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Zip:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="user_zip" type="text" class="field_gray" id="user_zip" value="<?=$data['user_zip'];?>" size="40"/><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">Password:</td>
                    <td align="left" valign="middle" class="bodytext"><input name="password" type="password" class="field_gray" id="password" value="<?=$data['password'];?>" size="40"/><span style="color:#FF0000;">*</span></td>
                  </tr>
				  <tr class="box-bg">
                    <td width="20%" align="left" valign="middle" class="bodytext">User Image :</td>
                    <td align="left" valign="middle" class="bodytext"><input type="file" name="user_image" /></td>
                  </tr>
				  <? if($data['user_image']!=""){?>
				  <tr class="box-bg">
					  <td height="30" align="left" valign="top" class="blacktxt_bold">&nbsp;</td>
					  <td align="left" valign="middle">
					 <?=$obj->getImageThumb(USER_IMG,$data['user_image'],'','','100','100','../');?>
					 </td>
                  </tr>
				  <? }?>
				  <tr class="box-bg">
                    <td align="left" valign="middle" class="bodytext">Status  :</td>
                    <td align="left" valign="middle" class="bodytext">
					<input type="radio" name="user_status" value="Active" checked="checked"> Active 
					<input type="radio" name="user_status" value="Inactive" <? if($data['user_status']=='Inactive'){?>checked="checked"<? } ?>> Inactive
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

