<?php include("../includes/connection.php");
$country = $_REQUEST['con'];
$sid = $_REQUEST['sid'];
$fld = $_REQUEST['fld'];

if($obj->hasStates($country))
{
?>
<select name="<?=$fld;?>" id="<?=$fld;?>" class="input" style="width:225px;" validate="required:true" onchange="citySelect(this.value,'','user_city','city');">
<?
echo  $obj->stateSelect($country,$sid);
?>
</select>
<? }else{?>
<input type="text" name="<?=$fld;?>" id="<?=$fld;?>" class="input" style="width:225px;" validate="required:true" value="<?=$sid;?>"/>
<? }?><span class="red">*</span>
 