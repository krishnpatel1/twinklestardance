<?php
//$cs = Yii::app()->getClientScript();
//$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.flexslider.js');
?>
<div class="inner_page">
	<div class="fix">
		<div class="newsletter_info">
			<h2>Blog
				<div class="button2">
					<?php echo CHtml::button('Sign Up', array('onclick' => 'js:openColorBox("' . CController::createUrl("index/joinNewsletter") . '",400,300);return false;', 'class' => 'ajax')); ?>
				</div>
				<div class="text-sub">
					Join our Mailing List for FREE offers and tips on how to grow your studio with Twinkle Bear
				</div>
			</h2>
		</div>
	</div>
	<div class="fix ad-image-wrapper" style="margin-left:auto; margin-right:auto;">
	
		<!-- JavaScript Code for Blog Goes here -->
	
		<!-- start feedwind code --> <script type="text/javascript">
		<!--
		rssmikle_url="http://twinklestardance.blogspot.com/feeds/posts/default?alt=rss";
		rssmikle_frame_width="958";
		rssmikle_frame_height="1200";
		rssmikle_target="_blank";
		rssmikle_font="Arial, Helvetica, sans-serif";
		rssmikle_font_size="12";
		rssmikle_border="off";
		responsive="off";
		rssmikle_css_url="";
		text_align="left";
		autoscroll="off";
		scrollstep="5";
		mcspeed="20";
		sort="New";
		rssmikle_title="off";
		rssmikle_title_bgcolor="#9ACD32";
		rssmikle_title_color="#FFFFFF";
		rssmikle_title_bgimage="http://";
		rssmikle_item_bgcolor="#FFFFFF";
		rssmikle_item_bgimage="http://";
		rssmikle_item_title_length="55";
		rssmikle_item_title_color="#E74888";
		rssmikle_item_border_bottom="on";
		rssmikle_item_description="on";
		rssmikle_item_description_length="150";
		rssmikle_item_description_color="#666666";
		rssmikle_item_date="off";
		rssmikle_timezone="no";
		rssmikle_item_description_tag="on_flexcroll";
		rssmikle_item_podcast="off";
		//-->
		</script> <script type="text/javascript" src="http://widget.feed.mikle.com/js/rssmikle.js"></script>
		<div style="font-size:10px; text-align:right;"><a href="http://feed.mikle.com/" target="_blank" style="color:#CCCCCC;">RSS Feed Widget</a> <!--Please display the above link in your web page according to Terms of Service.--></div>
		<!-- end feedwind code -->
	
		<!-- End JavaScript -->
	
	</div>
</div>
