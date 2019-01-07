<?php 
	include("includes/connection.php");
	$gallery_id=$_POST['gallery_id'];
	$arr_fetch=$obj->selectData(TABLE_GALLERY,"","gallery_id='".$gallery_id."' and gallery_status='Active'",1);
?>
<div style="width:100%; margin:0 auto 10px 0; text-align:center;">
	<?php echo html_entity_decode($arr_fetch['gallery_code']);?>
</div>
<div style="width:100%; text-align:center;"><?php echo nl2br(html_entity_decode($arr_fetch['gallery_desc']));?></div>