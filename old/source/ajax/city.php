<?php include("../includes/connection.php");
$state = $_REQUEST['st'];
$fld = $_REQUEST['fld'];
$cid = $_REQUEST['cid'];
if($obj->hasCities($state))
{
?>
<select name="<?=$fld;?>"  class="input_box3" id="<?=$fld;?>" style="width:200px;" validate="required:true">
<?
echo $obj->citySelect($state,$cid);
?>
</select>
<? }else{?>
<input type="text" name="<?=$fld;?>" id="<?=$fld;?>" class="input_box1" validate="required:true" value="<?=$cid;?>"/>
<? }?>