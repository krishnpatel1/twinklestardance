<div class="header" style="height:164px;">
<div class="header_outer">  <div class="header-top"> <a href="index.php" title="twinklestardance.com"><img src="images/logo.jpg" alt="Logo" border="0" class="logo"></a>
    <div class="header-right">
      <p class="super">
        <?php 
		 if(isset($_SESSION['admin']))
		  {
		  print("Welcome, Administrator");
		  ?>
        <span class="separator">|</span><a href="adminhome.php" class="link-logout">Home</a><span class="separator">|</span><a href="logout.php" class="link-logout">Log Out</a>
        <? }?>
      </p>
      <br/>
      <br/>
    </div>
  </div>
  <div class="clear"></div></div>
  <!-- menu start -->
  <!-- menu end -->
<div class="jqueryslidemenu_outer">  
  <div id="myslidemenu" class="jqueryslidemenu">
  <?   if(isset($_SESSION['admin'])){?>
  <ul>
  		<!--<li> <a href="javascript:void(0)">Download Product Management</a>
	   <ul>
	   	  <li> <a href="download_type.php" class="cursor"><span>Product Type Listings</span></a> </li>
		   <li> <a href="product_management.php" class="cursor"><span>Product Listings</span></a> </li> 
		   
       </ul>
      </li>-->
	  <li> <a href="javascript:void(0)">Online Product Management</a>
	   <ul>
			<!--<li> <a href="online_product_management.php" class="cursor"><span>Online Product Management</span></a> </li> -->
			<li> <a href="package_management.php" class="cursor"><span>Package management</span></a> </li>
			<!--<li> <a href="special_package_management.php" class="cursor"><span>Special Package management</span></a> </li>-->
       </ul>
      </li>
	   <li> <a href="javascript:void(0)">Gallery Management</a>
	   <ul>
	   	  <li> <a href="video_management.php" class="cursor"><span>Video Listings</span></a> </li>  
       </ul>
      </li>
	  <li> <a href="javascript:void(0)">Order Management</a>
	   <ul>
	   	  <li> <a href="order.php" class="cursor"><span>Order Listings</span></a> </li>  
       </ul>
      </li>
	  <li> <a href="javascript:void(0)">Settings</a>
        <ul>
		  <li> <a href="content_management.php" class="cursor"><span>Content Manage</span></a></li>
          <li> <a href="change_password.php" class="cursor"><span>Change Password</span></a></li>
		  <li> <a href="change_email.php" class="cursor"><span>Change Email</span></a></li>
        </ul>
      </li> 
	  
    </ul>
	<? }?>

    <div class="clear_menu"></div>
  </div></div>
</div>