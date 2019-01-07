<?php include("../includes/connection.php");
$state_id = $_REQUEST['sid'];
$fld = $_REQUEST['fld'];
$state_fetch=$obj->selectData(TABLE_STATE,"state_abbv","state_id='".$state_id."'",1);
$stateAV =  $state_fetch['state_abbv'];
?>
<select name="<?=$fld;?>" id="<?=$fld;?>" style="width:200px;">
<option value="">--Select--</option>
<?=$obj->select_zip_city($stateAV,$zip_id);?>
</select>
