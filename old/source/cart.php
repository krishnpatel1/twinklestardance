<? 
include("includes/connection.php");
$totrec=count($_SESSION['scart']);
$temp=$_SESSION['scart'];
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1>Cart </h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
					<table align="left" cellpadding="0" cellspacing="0" width="100%">
					<?php
						if($totrec>0)
						{
							$x=1;
							$subtotal=0;
							for($i=0;$i<$totrec;$i++)
							{
								$pro_id=$temp[$i]['productid'];
								$pro_type=$temp[$i]['p_type'];
								$pro_price=$temp[$i]['price'];
								$pro_dw_type=$temp[$i]['dw_type'];
								$pack_type=$temp[$i]['pack_type'];
								$duration=$temp[$i]['duration'];
								if($pro_type=='DW')
								{
									$product_fetch=$obj->selectData(TABLE_PRODUCT,"","prod_id='".$pro_id."' ",1);
									$pro_desc=$product_fetch['prod_title']." - ".$obj->get_downloadType($pro_dw_type)." --$".$pro_price;
								}
								if($pro_type=='P')
								{
									$package_fetch=$obj->selectData(TABLE_PACKAGE,"","package_id='".$pro_id."'",1);
									if($pack_type=='subscription')
									{
										$pro_desc=$package_fetch['package_name']." -- $".$package_fetch['package_price_subscription']." <b>Per Month For</b> ".$package_fetch['package_duration']." Months ";
									}
									if($pack_type=='onetime')
									{
										$pro_desc=$package_fetch['package_name']." -- <b>Pay up front subscription</b> $".$package_fetch['package_price_onetime'];
									}
									
								}
					?>
							<tr><td colspan="2"><?php echo $x++;?> ) &nbsp;<?php echo $pro_desc?></td></tr>
							
					<?php 
							}
					?>
							<tr><td colspan="2" style="height:15px;"></td></tr>
							<tr>
								<td colspan="2" align="left"><b>Due Now</b></td>
							</tr>
					<?php
							$tot_price=0;
							$y=1;
							for($k=0;$k<$totrec;$k++)
							{
								$pro_id=$temp[$k]['productid'];
								$pro_type=$temp[$k]['p_type'];
								$pro_price=$temp[$k]['price'];
								$pro_dw_type=$temp[$k]['dw_type'];
								$pack_type=$temp[$k]['pack_type'];
								$duration=$temp[$k]['duration'];
								
								$tot_price+=$pro_price;
								
								if($pro_type=='DW')
								{
									$product_fetch=$obj->selectData(TABLE_PRODUCT,"","prod_id='".$pro_id."' ",1);
									$pro_desc2=$product_fetch['prod_title']." -- $".$pro_price;
								}
								if($pro_type=='P')
								{
									$package_fetch=$obj->selectData(TABLE_PACKAGE,"","package_id='".$pro_id."'",1);
									if($pack_type=='subscription')
									{
										$pro_desc2=$package_fetch['package_name']."  -- $".$package_fetch['package_price_subscription'];
									}
									if($pack_type=='onetime')
									{
										$pro_desc2=$package_fetch['package_name']." -- $".$package_fetch['package_price_onetime'];
									}
									
								}
						?>
							<tr><td colspan="2"><?=$y++?>. &nbsp;<?=$pro_desc2?></td></tr>							
							
						<?php		
							}
						?>
						<tr>
						  <td colspan="2">_________________________________________________________________________________________________________</td>
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						
						<tr><td colspan="2">Total &nbsp;<span style="margin-left:15px;">$<?=$tot_price?></span></td></tr>
						
						
					<?					
							
					 }
					?>
					</table>
				</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top"><a href="online_packages.php"><img src="images/continue_btn.png" alt="" width="132" height="32" border="0" /></a> &nbsp; <a href="subscription.php"><img src="images/con_order_btn.png" alt="" width="102" height="32" border="0" /></a></td>
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
