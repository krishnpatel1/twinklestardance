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
                <td height="40" align="left" valign="top" class="top_title"><h1>About Tiffany Henderson</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
				<?=$obj->putContent(1)?>
				<!--<img src="images/about_img.jpg" alt="" /><strong>Who does Tiffany Henderson think she is?</strong>  Above all? Experienced.  She's the successful owner of seven Tiffany's Dance Academy locations with over 2500 students and enrollment of over 4000.  She produces four Nutcracker's each December, a professional dance performance each January in San Francisco and her 300 performing company dancers participate in 4 convention competitions and a Nationals competition each season.  Oh yeah, she also still teaches 15 hours a week and produces 25 annual recitals during the first two weeks of June each year. She's a regular guest speaker at Dance Teacher Summit, DanceLife Conference, Danceteacherweb Conference and contributor to Dance Teacher magazine, DanceStudioOwner.com and Dance Informa Magazine and Owner/Director of Tiffany's Dance Academy's seven California locations.  She was born in the San Francisco Bay Area in 1973 and has had a rich and exciting career as a professional Jazz Dancer. In 1992 she was awarded a one-year scholarship to the renowned Tremaine Dance Center in Hollywood.  At the completion of her scholarship she performed as the Tremaine Scholarship Show Featured Dancer.  She continued her professional studies at the prestigious School of Dance at the University of Arizona, where she graduated Magna Cum Laude with a B.F.A. in Dance in 1997. Tiffany's career highlights include: performances with Quinn/Williams Jazz at the 1995 Jazz Dance World Congress in Nagoya, Japan; the 1996 Jazz World Congress at Washington's Kennedy Center for the Performing Arts; the opening of the International Theatre School in Amsterdam, Holland in 1997 and at Symphony Hall in Phoenix, Arizona. She was also a member of Zohar Dance Company, has performed in many industrial shows, including the Microsoft Global Summit and American Greeting Cards, and was a soloist with La JAZDANZ of Louisiana, a company she was instrumental in bringing to the Amador Theatre in Pleasanton. Tiffany is now extremely excited to share her Twinkle Star DanceT curriculum with studio owners worldwide.--></td>
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
