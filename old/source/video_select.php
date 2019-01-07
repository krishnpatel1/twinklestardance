<?php
include("includes/connection.php");
$prod_id=$_REQUEST['prod_id'];
$price=$_REQUEST['price'];
$p_type=$_REQUEST['p_type'];
$dw_type=$_REQUEST['dw_type'];
$pack_type=$_REQUEST['pack_type'];
$duration=$_REQUEST['duration'];

/*---------package delivery qty---------*/
if($p_type=='P')
{
	$deliveryqty_fetch=$obj->selectData(TABLE_PACKAGE,"","package_id='".$prod_id."'",1);
	$pack_delivery_qty=$deliveryqty_fetch['package_delivery_qty'];
	if($pack_delivery_qty!=0)
	{
		$pd_qty=$pack_delivery_qty;
	}
	else
	{
		$pd_qty="All";
	}
	
}
/*---------------------------------*/
if($_POST['submit']=='Proceed')
{
	$msg="";
	$prod_id=$_REQUEST['prod_id'];
	$price=$_REQUEST['price'];
	$p_type=$_REQUEST['p_type'];
	$dw_type=$_REQUEST['dw_type'];
	$pack_type=$_REQUEST['pack_type'];
	$duration=$_REQUEST['duration'];
	$delivery_qty=$_REQUEST['pack_delivery_qty'];
	$gallery=$_REQUEST['gallery'];
	$no_of_video=count($gallery);
	$limit=$delivery_qty;
	
	if($no_of_video==0)
	{
		$msg="Please Choose Videos!";
	}
	else
	{
		
		if($limit!=0 && $no_of_video > $limit){
		$msg="Choose Maximum ".$limit." videos!";
		}
	}
	
	if($msg=="")
	{
		
		$gallery=implode(",",$gallery);
		header("Location:add_to_cart.php?prod_id=$prod_id&gallery=$gallery&price=$price&p_type=$p_type&pack_type=$pack_type&duration=$duration");
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
</head>

<body <?php if(!isset($_SESSION['user'])) {?>style="background:#fff url(images/bg.jpg) left top repeat-x;"<?php } ?>>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="205" align="left" valign="top">
	<? include("page_includes/header.php")?>
	</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  align="left" valign="top"><? include("page_includes/slide.php")?></td>
      </tr>
       <?php if(!isset($_SESSION['user'])) {?>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
	  <?php }?>
      <tr>
        <td align="left" valign="top">
		<? include("page_includes/banners.php") ?>
		</td>
      </tr>
       <?php if(!isset($_SESSION['user'])) {?>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
	  <?php }?>
      <tr>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td align="left" valign="top">
			<form name="f1" action="video_select.php" method="post">
			<input type="hidden" name="prod_id" value="<?=$prod_id?>">
			<input type="hidden" name="price" value="<?=$price?>">
			<input type="hidden" name="p_type" value="<?=$p_type?>">
			<input type="hidden" name="dw_type" value="<?=$dw_type?>">
			<input type="hidden" name="pack_type" value="<?=$pack_type?>">
			<input type="hidden" name="duration" value="<?=$duration?>">
			<input type="hidden" name="pack_delivery_qty" value="<?=$pack_delivery_qty?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1>Select Videos</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
			  <tr>
                <td align="left" valign="top" class="home_content"><strong>Your Twinkle Star Dance Choreography subscription begins with <?php echo $pd_qty;?> videos of your choice. Please make your selections now by clicking in the box next to each video that you would like to add to your gallery and then click Proceed.</strong></td>
              </tr>
			  <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
			  <?php if($msg<>"") { ?>
			  <tr><td><span class="home_content" style="color:#ff0000;"><?php echo $msg;?></span></td></tr>
			  <?php }?>
			  <?php
			  	if($p_type=='DW')
				{
					$product_fetch=$obj->selectData(TABLE_PRODUCT,"","prod_id='".$prod_id."' ",1);
					$pro_desc2=$product_fetch['prod_title']." -- $".$price;
				}
				if($p_type=='P')
				{
					$package_fetch=$obj->selectData(TABLE_PACKAGE,"","package_id='".$prod_id."'",1);
					$pro_desc2=$package_fetch['package_name'];
				}
			  ?>
              <tr>
			  	<td align="left" class="home_content">
					<?php echo $pro_desc2;?></td>
			  </tr>
			  <tr>
			  	<td align="left">
					<table align="left" cellpadding="0" cellspacing="0" width="100%">
						<?php
							$gallery_cat=$obj->selectData(TABLE_PACKAGE,"","package_id='".$prod_id."'",1);
							$catid=explode(",",$gallery_cat['gallery_category_ids']);
							//print_r($catid);
							$cat='';
							foreach($catid as $val)
							{
								//echo $val;
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
						
					</table>
				</td>
			  </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">
					<input type="submit" name="submit" value="Proceed" class="submit">
				</td>
              </tr>
            </table>
			</form>
			</td>
			<td width="7" align="left" valign="top">&nbsp;</td>
            <td width="240" align="left" valign="top"><? include("page_includes/right.php")?></td>
          </tr>
        </table>
		</td>
		
      </tr>
             <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
    </table>
	
	</td>
  </tr>
  <tr>
    <td height="80" align="left" valign="top" class="footer">
	<?php include("page_includes/footer.php"); ?>
	</td>
  </tr>
</table>
</body>
</html>