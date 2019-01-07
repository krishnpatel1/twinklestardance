<?php
include("includes/connection.php");
$package_id=$_POST['package_id'];
$order=$_POST['order'];
$remain=$_POST['remain'];
?>
<form name="f1" id="f1" action="" method="post">
<input type="hidden" name="package_id" value="<?=$package_id?>">
<input type="hidden" name="order_video_oder" value="<?=$order?>">
<input type="hidden" name="remain" value="<?=$remain?>">
<table align="left" cellpadding="0" cellspacing="0" width="100%">
<?php
	$gallery_cat=$obj->selectData(TABLE_PACKAGE,"","package_id='".$package_id."'",1);
	$catid=explode(",",$gallery_cat['gallery_category_ids']);
	//print_r($catid);
	$cat='';
	foreach($catid as $val)
	{
		$sql=$obj->selectData(TABLE_GALLERY,"distinct(gallery_id),gallery_name","gallery_category_id LIKE '%,".$val.",%' and gallery_status='Active' order by gallery_name");
		while($arr=mysql_fetch_array($sql))
		{
			$cat.=$arr['gallery_id'].",";
		}
	}
	$string_cat=substr($cat,0,-1);
	$cat_arr=array_unique(explode(",",$string_cat));
	foreach($cat_arr as $value)
	{
		$videofetch=$obj->selectData(TABLE_GALLERY,"","gallery_id='".$value."' and gallery_status='Active'",1);
	?>
	<tr>
		<td align="left" class="home_content">
		<input type="checkbox" name="gallery[]" value="<?=$videofetch['gallery_id']?>">&nbsp;<?=$videofetch['gallery_name']?>
	  </td>
	</tr>
	<?php	
		}
	?>
	<tr>
		<td align="left" valign="top">
			<input type="submit" name="submit" value="Proceed" class="submit">
		</td>
	</tr>
</table>
</form>