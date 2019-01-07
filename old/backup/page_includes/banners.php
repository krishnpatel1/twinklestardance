<script type="text/JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<?php if(!isset($_SESSION['user'])) {?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="240" height="80" align="left" valign="top">
				<? if($_SESSION['user']['user_pid']<>0){?>
				<a href="nopackage.php" rel="shadowbox;width=400;height=200;"><img src="images/subscription.jpg" alt="" width="240" height="80" border="0" /></a>
				<? } else {?>
				<a href="online_packages.php"><img src="images/subscription.jpg" alt="" width="240" height="80" border="0" /></a>
				<? }?>
			</td>
            <td align="left" valign="top">&nbsp;</td>
            <td width="240" align="left" valign="top"><a href="gallery.php"><img src="images/sample_video.jpg" alt="" width="240" height="80" border="0" /></a></td>
            <td align="left" valign="top">&nbsp;</td>
            <td width="240" align="left" valign="top"><img src="images/live_chat.jpg" alt="" width="240" height="80" border="0" onclick="MM_openBrWindow('//t1.phplivesupport.com/tsd2013/phplive.php?d=0','livechat','width=500,height=400')" style="cursor:pointer;" /></td>
			<td align="left" valign="top">&nbsp;</td>
            <td width="240" align="left" valign="top"><a href="community.php"><img src="images/community.jpg" alt="" width="240" height="80" border="0" /></a></td>
          	<?php /*?><td><a href="order_packages.php" rel="shadowbox;width=500;height=400;">View Packages</a></td><?php */?>
		  </tr>
</table>
<?php }?>
