<?php 
include("../includes/connection.php");
$uid=$_REQUEST['uid'];
if($uid!=0)
{
	$data = $obj->selectData(TABLE_USER,"","user_id='".$uid."'",1);
}
$countries_id=$_REQUEST['countries_id'];
$countrydata=$obj->selectData(TABLE_COUNTRY,"","countries_id='".$countries_id."'",1);
$opt=$countrydata['id'];
if($opt==1)
{
?>
<table align="left">
	<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
	<tr>
		<td width="20%" align="left" valign="middle" class="bodytext"><label>City</label></td>
		<td align="left" valign="middle" class="bodytext"><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>" size="40"/></td>
	</tr>
	<tr>
		<td width="20%" align="left" valign="middle" class="bodytext"><label>Province</label></td>
		<td align="left" valign="middle" class="bodytext"><input type="text" name="user_state" id="user_state" value="<?=$data['user_state']?>" size="40"/></td>
	</tr>
	<tr>
	<td width="20%" align="left" valign="middle" class="bodytext"><label>Postal Code</label></td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_zip" id="user_zip" value="<?=$data['user_zip']?>" size="40"/></td>
	</tr>
</table>
<? }
else if($opt==2)
{
?>
<table align="left">
	<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
	<tr class="box-bg">
		<td width="20%" align="left" valign="middle" class="bodytext">City</td>
	    <td align="left" valign="middle" class="bodytext"><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>" size="40"/></td>
	</tr>
	<tr>
		<td width="20%" align="left" valign="middle" class="bodytext">State/Territory</td>
		<td align="left" valign="middle" class="bodytext"><input type="text" name="user_state" id="user_state" value="<?=$data['user_state']?>" size="40"/></td>
	</tr>
</table>
<? } 
else if($opt==3)
{
?>
<table align="left">
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr class="box-bg">
	<td width="20%" align="left" valign="middle" class="bodytext">Company Name</td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_company" id="user_company" value="<?=$data['user_company']?>" size="40"/></td>
</tr>
<tr>
	<td width="20%" align="left" valign="middle" class="bodytext">Building Name</td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_bulding" id="user_bulding" value="<?=$data['user_bulding']?>" size="40"/></td>
</tr>
<tr>
	<td width="20%" align="left" valign="middle" class="bodytext">Building Number</td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_building_no" id="user_building_no" value="<?=$data['user_building_no']?>" size="40"/></td>
</tr>
<tr>
	<td width="20%" align="left" valign="middle" class="bodytext">Locality</td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_locality" id="user_locality" value="<?=$data['user_locality']?>" size="40"/></td>
</tr>
<tr>
	<td width="20%" align="left" valign="middle" class="bodytext">Post</td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_post" id="user_post" value="<?=$data['user_post']?>" size="40"/></td>
</tr>
<tr>
	<td width="20%" align="left" valign="middle" class="bodytext">Town</td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>" size="40"/></td>
</tr>
<tr>
	<td width="20%" align="left" valign="middle" class="bodytext">Post Code</td>
	<td align="left" valign="middle" class="bodytext"><input type="text" name="user_zip" id="user_zip" value="<?=$data['user_zip']?>" size="40"/></td>
</tr>
</table>
<? } else {?>
<table align="left">
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr  class="box-bg">
	<td width="20%" align="left" valign="middle" class="bodytext">City</td>
	<td lign="left" valign="middle" class="bodytext"><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>" size="40"/></td>
</tr>
<tr>
	<td width="20%" align="left" valign="middle" class="bodytext">State</td>
	<td lign="left" valign="middle" class="bodytext"><input type="text" name="user_state" id="user_state" value="<?=$data['user_state']?>" size="40"/></td>
</tr>
<tr>
<td width="20%" align="left" valign="middle" class="bodytext">Zip / Postal Code</td>
<td lign="left" valign="middle" class="bodytext"><input type="text" name="user_zip" id="user_zip" value="<?=$data['user_zip']?>" size="40"/></td>
</tr>
</table>
<? }?>

