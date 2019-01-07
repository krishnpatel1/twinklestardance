<?php 
include("includes/connection.php");
$data = $obj->selectData(TABLE_USER,"","user_id='".$_SESSION['user']['user_id']."'",1);
$countries_id=$_REQUEST['countries_id'];
$countrydata=$obj->selectData(TABLE_COUNTRY,"","countries_id='".$countries_id."'",1);
$opt=$countrydata['id'];
if($opt==1)
{
?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>City</label></td>
<td><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>"/></td>
</tr>
<tr>
	<td><label>Province</label></td>
	<td><input type="text" name="user_state" id="user_state" value="<?=$data['user_state']?>"/></td>
</tr>
<tr>
<td><label>Postal Code</label></td>
<td><input type="text" name="user_zip" id="user_zip" value="<?=$data['user_zip']?>"/></td>
</tr>
<? }
else if($opt==2)
{
?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>City</label></td>
<td><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>"/></td>
</tr>
<tr>
	<td><label>State/Territory</label></td>
	<td><input type="text" name="user_state" id="user_state" value="<?=$data['user_state']?>"/></td>
</tr>
<? } 
else if($opt==3)
{
?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>Company Name</label></td>
	<td><input type="text" name="user_company" id="user_company" value="<?=$data['user_company']?>"/></td>
</tr>
<tr>
	<td><label>Building Name</label></td>
	<td><input type="text" name="user_bulding" id="user_bulding" value="<?=$data['user_bulding']?>"/></td>
</tr>
<tr>
	<td><label>Building Number</label></td>
	<td><input type="text" name="user_building_no" id="user_building_no" value="<?=$data['user_building_no']?>"/></td>
</tr>
<tr>
	<td><label> Locality</label></td>
	<td><input type="text" name="user_locality" id="user_locality" value="<?=$data['user_locality']?>"/></td>
</tr>
<tr>
	<td><label>Post</label></td>
	<td><input type="text" name="user_post" id="user_post" value="<?=$data['user_post']?>"/></td>
</tr>
<tr>
	<td><label>Town</label></td>
	<td><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>"/></td>
</tr>
<tr>
	<td><label>Post Code</label></td>
	<td><input type="text" name="user_zip" id="user_zip" value="<?=$data['user_zip']?>"/></td>
</tr>
<? } else {?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>City</label></td>
<td><input type="text" name="user_city" id="user_city" value="<?=$data['user_city']?>"/></td>
</tr>
<tr>
	<td><label>State</label></td>
	<td><input type="text" name="user_state" id="user_state" value="<?=$data['user_state']?>"/></td>
</tr>
<tr>
<td><label>Zip / Postal Code</label></td>
<td><input type="text" name="user_zip" id="user_zip" value="<?=$data['user_zip']?>"/></td>
</tr>
<? }?>
