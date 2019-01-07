<!--<div id="mygalone" class="svw">
		  <ul>
			  <li><img src="images/header_img1.jpg" alt="" /></li>
			  <li><img src="images/header_img2.jpg" alt="" /></li>
			  <li><img src="images/header_img3.jpg" alt="" /></li>
			  <li><img src="images/header_img4.jpg" alt="" /></li>
		  </ul>
		</div>-->
<div id="header">
<?php if(!isset($_SESSION['user'])) {?><div class="wrap">
   <div id="slide-holder">
			
	<div id="slide-runner">
		<a href=""><img id="slide-img-1" src="images/header_img5.jpg" class="slide" alt="" /></a>
		<a href="online_packages.php"><img id="slide-img-2" src="images/header_img1.jpg" class="slide" alt="" /></a>
		<a href=""><img id="slide-img-3" src="images/header_img3.jpg" class="slide" alt="" /></a>
		<a href=""><img id="slide-img-4" src="images/header_img4.jpg" class="slide" alt="" /></a>
		<div id="slide-controls">
     	<p id="slide-nav"></p>
   		</div>
	</div>
  
	<!--content featured gallery here -->
   </div>
   <script type="text/javascript">
    if(!window.slider) var slider={};slider.data=[{"id":"slide-img-1","client":"nature beauty","desc":"nature beauty photography"},{"id":"slide-img-2","client":"nature beauty","desc":"add your description here"},{"id":"slide-img-3","client":"nature beauty","desc":"add your description here"},{"id":"slide-img-4","client":"nature beauty","desc":"add your description here"}];
   </script>
  </div><?php }?></div>
