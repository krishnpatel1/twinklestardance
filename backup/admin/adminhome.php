<?php
require_once("../includes/connection.php");
adminSecure();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php require_once("common_head.php");?>
</head>
<body id="html-body" class=" adminhtml-promo-catalog-index">
 <?php include('head.php'); ?>
  <div class="middle" id="anchor-content">
    <div id="promo_catalog_grid">
      <?=$obj->display_message("message");?>
	  <div class="box padd"><center><h1>Welcome to Admin Panel Of <?=SITE_NAME;?> </h1></center></div>
    </div>
  </div>  
 <?php include('footer.php'); ?>
</body>
</html>