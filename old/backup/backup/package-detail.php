<?php
include("includes/connection.php");
include("includes/message.php");
$package_id=$_REQUEST['id'];
$package_fetch=$obj->selectData(TABLE_PACKAGE,"","package_status='Active' and package_id='".$package_id."'",1);
if($_REQUEST['action']=='addTocart')
{
	$_SESSION['messageClass'] = "errorClass";
	if(trim($_POST['pack_type'])=="") {$obj->add_message("message","Choose Package Type!");}
	if($obj->get_message("message")=="")
	{
		$pack_type=$_POST['pack_type'];
		//$price=$_POST['pack_price'];
		$prod_id=$_POST['id'];
		$p_type=$_POST['p_type'];
		$pack_price_fetch=$obj->selectData(TABLE_PACKAGE,"","package_id='".$prod_id."'",1);
		if($pack_type=='subscription')
		{
			$price=$pack_price_fetch['package_price_subscription'];
			$duration=$pack_price_fetch['package_duration'];
		}
		else
		{
			$price=$pack_price_fetch['package_price_onetime'];
		}
		
		header("Location:add_to_cart.php?prod_id=$prod_id&price=$price&p_type=$p_type&pack_type=$pack_type&duration=$duration");
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

<body>
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
        <td height="331" align="left" valign="top"><? include("page_includes/slide.php")?></td>
      </tr>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="top">
		<? include("page_includes/banners.php") ?>
		</td>
      </tr>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <? if($obj->get_message("message")<>"") { echo $obj->get_message("message");}?>
		  <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1><?=$package_fetch['package_name']?></h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
				<form id="pro_details" name="pro_details" method="post" action="package-detail.php">
				<input type="hidden" name="action" value="addTocart">
				<input type="hidden" name="id" value="<?=$package_id?>">
				<input type="hidden" name="p_type" value="P">
				<div class="package-content">
					<?=html_entity_decode($package_fetch['package_description'])?>	
				<ul>
					<li>
						<input type="radio" name="pack_type" value="subscription">
						STARS monthly payment package <span style="color:red;">$<?=$package_fetch['package_price_subscription']?></span> per month for <?=$package_fetch['package_duration']?> Months
					</li>
					<li>
						<input type="radio" name="pack_type" value="onetime">
						STARS Pay up front package - <span style="color:red;"> $<?=$package_fetch['package_price_onetime']?></span>
					</li>
				</ul>	
				<ul>
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
