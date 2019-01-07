<?php 
include("includes/connection.php");
$countries_id=$_REQUEST['countries_id'];
$data=$obj->selectData(TABLE_COUNTRY,"","countries_id='".$countries_id."'",1);
$opt=$data['id'];
if($opt==1)
{
?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>Street Address<span class="red">*</span></label></td>
	<td><input type="text" name="order_street" id="order_street" value="<?=$_SESSION['subscription']['order_street']?>"/></td>
</tr>
<tr>
	<td><label>City<span class="red">*</span></label></td>
	<td><input type="text" name="order_city" id="order_city" value="<?=$_SESSION['subscription']['order_city']?>"/></td>
</tr>
<tr>
	<td><label>Province<span class="red">*</span></label></td>
	<td><input type="text" name="order_state" id="order_state" value="<?=$_SESSION['subscription']['order_state']?>"/></td>
</tr>
<tr>
<td><label>Postal Code<span class="red">*</span></label></td>
<td><input type="text" name="order_zip" id="order_zip" value="<?=$_SESSION['subscription']['order_zip']?>"/></td>
</tr>
<? }
else if($opt==2)
{
?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>Street Address<span class="red">*</span></label></td>
	<td><input type="text" name="order_street" id="order_street" value="<?=$_SESSION['subscription']['order_street']?>"/></td>
</tr>
<tr>
	<td><label>City<span class="red">*</span></label></td>
<td><input type="text" name="order_city" id="order_city" value="<?=$_SESSION['subscription']['order_city']?>"/></td>
</tr>
<tr>
	<td><label>State/Territory<span class="red">*</span></label></td>
	<td><input type="text" name="order_state" id="order_state" value="<?=$_SESSION['subscription']['order_state']?>"/></td>
</tr>
<? } 
else if($opt==3)
{
?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>Company Name<span class="red">*</span></label></td>
	<td><input type="text" name="order_company" id="order_company" value="<?=$_SESSION['subscription']['order_company']?>"/></td>
</tr>
<tr>
	<td><label>Building Name<span class="red">*</span></label></td>
	<td><input type="text" name="order_bulding" id="order_bulding" value="<?=$_SESSION['subscription']['order_bulding']?>"/></td>
</tr>
<tr>
	<td><label>Building Number<span class="red">*</span></label></td>
	<td><input type="text" name="order_building_no" id="order_building_no" value="<?=$_SESSION['subscription']['order_building_no']?>"/></td>
</tr>
<tr>
	<td><label> Locality<span class="red">*</span></label></td>
	<td><input type="text" name="order_locality" id="order_locality" value="<?=$_SESSION['subscription']['order_locality']?>"/></td>
</tr>
<tr>
	<td><label>Post<span class="red">*</span></label></td>
	<td><input type="text" name="order_post" id="order_post" value="<?=$_SESSION['subscription']['order_post']?>"/></td>
</tr>
<tr>
	<td><label>State<span class="red">*</span></label></td>
	<td><input type="text" name="order_state" id="order_state" value="<?=$_SESSION['subscription']['order_state']?>"/></td>
</tr>
<tr>
	<td><label>Town<span class="red">*</span></label></td>
	<td><input type="text" name="order_city" id="order_city" value="<?=$_SESSION['subscription']['order_city']?>"/></td>
</tr>
<tr>
	<td><label>Post Code<span class="red">*</span></label></td>
	<td><input type="text" name="order_zip" id="order_zip" value="<?=$_SESSION['subscription']['order_zip']?>"/></td>
</tr>
<? } else {?>
<input type="hidden" name="opt" id="opt" value="<?=$opt?>"/>
<tr>
	<td><label>Street Address<span class="red">*</span></label></td>
	<td><input type="text" name="order_street" id="order_street" value="<?=$_SESSION['subscription']['order_street']?>"/></td>
</tr>
<tr>
	<td><label>City<span class="red">*</span></label></td>
<td><input type="text" name="order_city" id="order_city" value="<?=$_SESSION['subscription']['order_city']?>"/></td>
</tr>
<tr>
	<td><label>State<span class="red">*</span></label></td>
	<td><input type="text" name="order_state" id="order_state" value="<?=$_SESSION['subscription']['order_state']?>"/></td>
</tr>
<tr>
<td><label>Zip / Postal Code<span class="red">*</span></label></td>
<td><input type="text" name="order_zip" id="order_zip" value="<?=$_SESSION['subscription']['order_zip']?>"/></td>
</tr>
<? }?>
#######
<?php
if($opt==1)
{
?>
<tr>
	<td><label>Street Address<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_street" id="order_bill_street" value="<?=$_SESSION['subscription']['order_bill_street']?>"/></td>
</tr>
<tr>
	<td><label>City<span class="red">*</span></label></td>
<td><input type="text" name="order_bill_city" id="order_bill_city" value="<?=$_SESSION['subscription']['order_bill_city']?>"/></td>
</tr>
<tr>
	<td><label>Province<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_state" id="order_bill_state" value="<?=$_SESSION['subscription']['order_bill_state']?>"/></td>
</tr>
<tr>
<td><label>Postal Code<span class="red">*</span></label></td>
<td><input type="text" name="order_bill_zip" id="order_bill_zip" value="<?=$_SESSION['subscription']['order_bill_zip']?>"/></td>
</tr>
<? }
else if($opt==2)
{
?>
<tr>
	<td><label>Street Address<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_street" id="order_bill_street" value="<?=$_SESSION['subscription']['order_bill_street']?>"/></td>
</tr>
<tr>
	<td><label>City<span class="red">*</span></label></td>
<td><input type="text" name="order_bill_city" id="order_bill_city" value="<?=$_SESSION['subscription']['order_bill_city']?>"/></td>
</tr>
<tr>
	<td><label>State/Territory<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_state" id="order_bill_state" value="<?=$_SESSION['subscription']['order_bill_state']?>"/></td>
</tr>
<? } 
else if($opt==3)
{
?>
<tr>
	<td><label>Company Name<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_company" id="order_bill_company" value="<?=$_SESSION['subscription']['order_bill_company']?>"/></td>
</tr>
<tr>
	<td><label>Building Name<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_bulding" id="order_bill_bulding" value="<?=$_SESSION['subscription']['order_bill_bulding']?>"/></td>
</tr>
<tr>
	<td><label>Building Number<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_building_no" id="order_bill_building_no" value="<?=$_SESSION['subscription']['order_bill_building_no']?>"/></td>
</tr>
<tr>
	<td><label> Locality<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_locality" id="order_bill_locality" value="<?=$_SESSION['subscription']['order_bill_locality']?>"/></td>
</tr>
<tr>
	<td><label>Post<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_post" id="order_bill_post" value="<?=$_SESSION['subscription']['order_bill_post']?>"/></td>
</tr>
<tr>
	<td><label>State<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_state" id="order_bill_state" value="<?=$_SESSION['subscription']['order_bill_state']?>"/></td>
</tr>
<tr>
	<td><label>Town<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_city" id="order_bill_city" value="<?=$_SESSION['subscription']['order_bill_city']?>"/></td>
</tr>
<tr>
	<td><label>Post Code<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_zip" id="order_bill_zip" value="<?=$_SESSION['subscription']['order_bill_zip']?>"/></td>
</tr>
<? } else {?>
<tr>
	<td><label>Street Address<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_street" id="order_bill_street" value="<?=$_SESSION['subscription']['order_bill_street']?>"/></td>
</tr>
<tr>
	<td><label>City<span class="red">*</span></label></td>
<td><input type="text" name="order_bill_city" id="order_bill_city" value="<?=$_SESSION['subscription']['order_bill_city']?>"/></td>
</tr>
<tr>
	<td><label>State<span class="red">*</span></label></td>
	<td><input type="text" name="order_bill_state" id="order_bill_state" value="<?=$_SESSION['subscription']['order_bill_state']?>"/></td>
</tr>
<tr>
<td><label>Zip / Postal Code<span class="red">*</span></label></td>
<td><input type="text" name="order_bill_zip" id="order_bill_zip" value="<?=$_SESSION['subscription']['order_bill_zip']?>"/></td>
</tr>
<? }?>
