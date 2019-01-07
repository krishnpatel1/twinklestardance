<?php
include("includes/connection.php");
include("includes/message.php");
$prod_id=$_REQUEST['id'];
$product_fetch=$obj->selectData(TABLE_PRODUCT,"","prod_status='Active' and prod_id=".$prod_id." order by prod_title ",1);
if($_REQUEST['action']=='addTocart')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['dw_type'])=="") {$obj->add_message("message","Choose Download Type!");}
	if($obj->get_message("message")=="")
	{
		$dw_type=$_POST['dw_type'];
		$prod_id=$_POST['id'];
		$p_type=$_POST['p_type'];
		
		$price_fetch=$obj->selectData(TABLE_PRICELIST,"","price_status='Active' and price_product='".$prod_id."' and price_download_type='".$dw_type."'",1);
		$price=$price_fetch['price'];
		
		header("Location:add_to_cart.php?prod_id=$prod_id&price=$price&p_type=$p_type&dw_type=$dw_type");
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
            <? if($obj->get_message("message")<>"") { echo $obj->get_message("message");}?>
		  <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1><?php echo $product_fetch['prod_title'];?></h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
				<form id="pro_details" name="pro_details" method="post" action="product-detail.php">
				<input type="hidden" name="action" value="addTocart">
				<input type="hidden" name="id" value="<?=$prod_id?>">
				<input type="hidden" name="p_type" value="DW">
				<? if($message1!=""){ echo $message1;}?>
				<div class="package-content">
				<p><?php echo html_entity_decode($product_fetch['prod_desc']);?> </p>
				
				<ul>
					<?
						$price_sql=$obj->selectData(TABLE_PRICELIST,"","price_status='Active' and  price_product='".$product_fetch['prod_id']."' order by price_id desc");
						while($price_fetch=mysql_fetch_assoc($price_sql))
						{
					?>
						<li>
							<input type="radio" name="dw_type" value="<?=$price_fetch['price_download_type']?>">
							<strong>Price for <?=$obj->get_downloadType($price_fetch['price_download_type'])?>:</strong> <span>$<?=$price_fetch['price']?></span>
						</li>
					<? }?>
					<li>&nbsp;</li>
					<!--<li><a href="subscription.php"><img src="images/download_btn.png" alt="" border="0" style="border:0px solid " /></a></li>-->
					<li><input type="image" src="images/button1.png" name="add_to_cart" value="Submit"></li>
				</ul>
				</div>
				</form>
				</td>
              </tr>
            </table>
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
