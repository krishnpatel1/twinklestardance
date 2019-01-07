<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td align="left" valign="top">
	<a href="index.php">Home</a> | 
	<a href="download_product.php">Products</a> | 
	<a href="contact_us.php">Contact Us</a> | 
	<?php if(!isset($_SESSION['user'])) { ?>
	<a href="login.php">Login</a>
	<?php } else { ?>
	<a href="myaccount.php">My Account</a> | 
	<a href="logout.php">Logout</a>
	<?php } ?>
	</td>
	<td align="right" valign="top">Copyright &copy; 2012</td>
  </tr>
</table>
