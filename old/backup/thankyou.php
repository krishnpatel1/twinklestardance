<?php
include("includes/connection.php");
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
          <tr><td colspan="2" style="color:#ff0000;"><?php echo $_SESSION['L_LONGMESSAGE0'];?></td></tr>
		  <tr><td colspan="2" style="height:10px;"></td></tr>	
		  <tr>
            <td align="left" valign="top">
			<?php
				if($_SESSION['is_success']=='SUCCESS')
				{
				
			  ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title">
					<h1>Thank you for subscribing to Twinkle Star Dance! </h1>
				</td>
              </tr>
			  <tr>
			  	<td class="home_content">
						<table align="left" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="2" align="left"><b> We’ve processed your first payment for the following subscription(s):</b></td>
							</tr>
						<?php
							$pay_id=$_SESSION['pay_id'];
							$odetails_sql=$obj->selectData(TABLE_ORDER_DETAIL,"","od_order='$pay_id' and od_status='Active'","");
							$tot_price=0;
							$y=1;
							$stat=0;
							while($odetails_row=mysql_fetch_array($odetails_sql))
							{
								$pro_id=$odetails_row['od_pro'];
								$pro_type=$odetails_row['od_pro_type'];
								$pro_price=$odetails_row['od_price'];
								$pro_dw_type=$odetails_row['od_dw_type'];
								$pack_type=$odetails_row['od_price_type'];
								$duration=$odetails_row['od_duration'];
								
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
								<tr>
									<td colspan="1">
									<?=$y++?>. &nbsp;<?=$pro_desc2?>
									</td>
									<td>
									<?php /*?><?php if($odetails_row['od_payment_status']=='Unpaid') { $stat=1; ?>
									<a href="paypal_pro_rec.php?od_id=<?=$odetails_row['od_id'];?>"><strong>Pay Now</strong></a>
									<?php } else { echo '<strong>Paid</strong>'; } ?><?php */?>
									</td>
								</tr>							
								<?php	
								
							}
						?>
						<tr>
						  <td colspan="2">________________________________________________________________________________________________________</td>
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr><td colspan="2">Total amount processed in this transaction was &nbsp;&nbsp;<span style="margin-left:15px;">$<?=$tot_price?></span></td></tr>
						<tr>
							<td colspan="2">
								If you’ve elected the monthly plan, you may  view your monthly account ledger 
								<a href="https://www.thestudiodirector.com/twinklestardancellc/register.jsp" target="_blank">here</a>
							</td>
						</tr>
						<?					
						 if($stat==0)
						 {
							unset($_SESSION['scart']);
							$_SESSION['order'] = "";
						 }
						 
						?>
					</table>
				</td>
			  </tr>
			  <tr><td style="height:15px;"></td></tr>
            </table>
			<?php 
			
				}
				else
				{
				?>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr><td align="left">We’re sorry, the payment was not processed successfully.  Please try again.</td></tr>
				</table>
				<?php	
				}
			?>
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
