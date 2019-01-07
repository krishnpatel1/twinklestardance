<?php
	session_start();
	$totrec=count($_SESSION['scart']);
	//print_r($_SESSION['user']);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="154" align="left" valign="top">
		
		<!--header part start-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="210" height="154" align="left" valign="top"><a href="index.php"><img src="images/logo.jpg" alt="" width="191" height="130" border="0" /></a></td>
            <td width="400" align="left" valign="bottom" class="caption">Effective curriculum and choreography videos<br />
              for dancers ages 2 &shy;-10</td>
            <td align="right" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="35" align="right" valign="top">
				<?php if(!isset($_SESSION['user'])) { ?>
					<table border="0" align="right" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="middle" width="28"><img src="images/login_icon.png" width="22" height="22" alt="" /></td>
						<td align="left" valign="middle" class="top_txt"><a href="login.php">Login</a></td>
					  </tr>
				  </table>
				<?php } else { ?>
					<table border="0" align="right" cellpadding="0" cellspacing="0">
					  <tr>
					  	<td align="left" valign="middle" width="28"><img src="images/account_icon.png" width="22" height="22" alt="" /></td>
						<td align="left" valign="middle" class="top_txt" style="border-right:1px solid #bfbfbf; padding-right:10px"><a href="myaccount.php">My Account</a></td>
						<td width="10" align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle" width="28"><img src="images/login_icon.png" width="22" height="22" alt="" /></td>
						<td align="left" valign="middle" class="top_txt"><a href="logout.php">Logout</a></td>
					  </tr>
				  </table>
				<?php } ?></td>
              </tr>
              <tr>
                <td height="35" align="right" valign="top" class="top_ph"><span>Call us :-</span> +(925) 447-5299</td>
              </tr>
              <tr>
                <td>
				
				<!--follow us and search start-->
				<table border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
				  	<td width="30" align="left" valign="middle"><a href="cart.php"><img src="images/cart_icon.png" alt="" width="24" height="24" /></a></td>
                    <td class="top_txt" style="border-right:1px solid #bfbfbf; padding-right:10px"><?=$totrec?> <? if($totrec>1){?>Items<? } else {?>Item<? }?></td>
					<td width="10">&nbsp;</td>
					<td width="60" height="25" align="right" valign="middle" class="top_txt">Follow Us:</td>
                    <td width="22" align="right" valign="middle"><a href="https://www.facebook.com/TwinkleStarDance" target="_blank"><img src="images/facebook_icon.png" alt="" width="11" height="23" border="0" /></a></td>
                    <td width="40" align="right" valign="middle"><a href="#"><img src="images/twitter_icon.png" alt="" width="30" height="22" border="0" /></a></td>
                    <td width="35" align="right" valign="middle"><a href="#"><img src="images/in_icon.png" width="22" height="22" border="0" /></a></td>
                    <?php /*?><td align="left" valign="middle" class="search"><form id="form1" name="form1" method="post" action="">
                      <input type="text" name="search" onblur="if(this.value=='')this.value='Search Here'" onfocus="if(this.value=='Search Here')this.value='';" value="Search Here" /> <input type="submit" name="Submit" value="Go" />
					  </form></td><?php */?>
                  </tr>
                </table>
				<!--follow us and search end-->				</td>
              </tr>
              <tr>
                <td height="15"></td>
              </tr>
            </table></td>
          </tr>
        </table>
		<!--header part end-->
		
		</td>
      </tr>
	  
      <tr>
        <td height="51" align="left" valign="top">
		
		<!--navigation start-->
		<?php if(!isset($_SESSION['user'])) {?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5" height="51" align="left" valign="top"><img src="images/topmenu_left.jpg" alt="" width="5" height="51" /></td>
            <td align="left" valign="top" class="topmenu_bg">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="130" align="center" valign="middle"><a href="index.php">Home Page</a></td>
                <td width="2" align="left" valign="top"><img src="images/topmenu_devider.jpg" alt="" width="2" height="51" /></td>
                <td align="center" valign="middle"><a href="about.php">About Tiffany Henderson</a></td>
                <td width="2" align="left" valign="top"><img src="images/topmenu_devider.jpg" alt="" width="2" height="51" /></td>
                <td width="130" align="center" valign="middle"><a href="online_packages.php">Our Subscriptions</a></td>
                <td width="2" align="left" valign="top"><img src="images/topmenu_devider.jpg" alt="" width="2" height="51" /></td>
                <td width="120" align="center" valign="middle"><a href="music.php">Music</a></td>
                <td width="2" align="left" valign="top"><img src="images/topmenu_devider.jpg" alt="" width="2" height="51" /></td>
                <td width="120" align="center" valign="middle"><a href="pricing.php">Pricing</a></td>
                <td width="2" align="left" valign="top"><img src="images/topmenu_devider.jpg" alt="" width="2" height="51" /></td>
                <td width="120" align="center" valign="middle"><a href="terms.php">Terms</a></td>
                <td width="2" align="left" valign="top"><img src="images/topmenu_devider.jpg" alt="" width="2" height="51" /></td>
                <td width="130" align="center" valign="middle"><a href="contact_us.php">Contact Us</a></td>
              </tr>
            </table>
			</td>
            <td width="5" align="right" valign="top"><img src="images/topmenu_right.jpg" alt="" width="5" height="51" /></td>
          </tr>
        </table>
		<?php }?>
		<!--navigation end-->
		
		</td>
      </tr>
	 
    </table>