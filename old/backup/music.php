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
          <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1>Music</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
				<?=$obj->putContent(4)?>
				<!--All music in the Twinkle Star Dance program is copyright material.  The music source, title and artist is provided in the choreography video description.<br /><br />
Users must purchase the music in order to stay in compliance with current laws.  TSD will provide editing instructions and resources once proof of purchase has been submitted.  To submit proof of purchase simply forward payment receipt to <a href="mailto:info@twinklestardance.com">info@twinklestardance.com</a>.<br />
<br />
<strong>Community</strong><br />
<br />
&ldquo;The  hardest thing about owning and operating a dance studio is feeling  all alone.&rdquo; <br />
<br />
-Tiffany  Henderson<br />
<br />
The  problem is that it&rsquo;s very hard to be friends with other local  studio owners because they feel threatened by your very presence.   I&rsquo;ve learned the hard way that it&rsquo;s also very hard to be friends  with your customers because they are paying you for a service.  It&rsquo;s  hard to be friends with your employees because you are paying them!   In order to teach well we must form incredibly deep relationships  with our students &ndash; even though most of them will eventually leave  without so much as a &ldquo;thank you&rdquo;.<br />
<br />
These  truths made me feel all alone&hellip;even though I was surrounded by  thousands of happy families and dozens of happy and skilled dance  instructors and administrative staff.
<br />
<br />
Twinkle  Star Dance is not just a place to grab a couple recital choreography  videos or a few tips on how to teach plie to 5 year olds.<br />
<br />
It&rsquo;s  a place to interact with other studio owners all across the country  who are just like you!  It&rsquo;s a community of like-minded dance  teachers who have your best interest at heart.
<br />
<br />
Welcome,  and STAY CONNECTED!<br />
<br />
Message  Board | Chat  with TSD Staff | Facebook  Link | Twitter  Link | LinkedIn Link --></td>
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
