<?php include("../includes/connection.php");
$state = $_REQUEST['st'];
$fld = $_REQUEST['fld'];
$cid = $_REQUEST['cid'];
if($obj->hasCities($state))
{
?>
<select name="<?=$fld;?>"  class="input" id="<?=$fld;?>" style="width:306px;" validate="required:true">
<?
echo $obj->citySelect($state,$cid);
?>
</select>
<? }else{?>
<input type="text" name="<?=$fld;?>" id="<?=$fld;?>" class="input" style="width:300px;" validate="required:true" value="<?=$cid;?>"/>
<? }?><span class="red">*</span>