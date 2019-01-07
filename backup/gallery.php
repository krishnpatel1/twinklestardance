<? include("includes/connection.php");
$video_sql=$obj->selectData(TABLE_VIDEO,"","video_status='Active' order by video_id desc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
<script type="text/javascript">var _siteRoot='index.html',_root='index.html';</script>
<script type="text/javascript" src="js/scripts_.js"></script>
<script language="javascript" type="text/javascript">
function showonlyone(thechosenone) {
     $('div[name|="newboxes"]').each(function(index) {
          if ($(this).attr("id") == thechosenone) {
               $(this).show(200);
          }
          else {
               $(this).hide(0);
          }
     });
}
</script>
<style type="text/css">
#showreel-page{
	width:960px;
	float:left;
	}

#showreel-page span{
	width:580px;
	height:331px;
	float:right;
	}
	
#showreel-page .line{
	display:block;
	float:left;
	width:700px;
	height:1px;
	background:#505050;
	margin: 23px 122px;
	}
	
#showreel-page .work{
	width:360px;
	height:390px;
	overflow:auto;
	float:left;
	}
	
#showreel-page .work ul{
	display:block;
	width:340px;
	margin:0;
	padding:0;
	float:left;
	border-right:1px solid #d8d7d7;
	}
	
#showreel-page .work ul li{
	float:left;
	list-style:none;
	width:160px;
	display:block;
	margin:0 10px 10px 0;
	}
	
#showreel-page .work ul li.spacer{
	float:left;
	width:13px;
	display:block;
	}
	
#showreel-page .work ul li img{
	float:left;
	width:160px;
	height:120px;
	}
	
#showreel-page .work ul li p{
	float:left;
	width:309px;
	font:normal 16px/17px "Museo 500";
	color:#e7e7e7;
	margin:15px 0;
	}

#showreel-page .work ul li a{
	font:normal 16px/17px "Museo 500";
	text-decoration:none;
	color:#e7e7e7;
	}
	
#showreel-page .work ul li a:hover{
	text-decoration:underline;
	}
	
</style>
</head>

<body>
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
        <td height="331" align="left" valign="top"><? include("page_includes/slide.php")?></td>
      </tr>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="top">
		<? include("page_includes/banners.php") ?>
		</td>
      </tr>
      <tr>
        <td height="7" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="top" class="top_title"><h1>Sample Videos</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top"><div id="showreel-page">
						
						<span>
							<?
								$i=1;
								while($video_fetch=mysql_fetch_assoc($video_sql))
								{
							?>
							<div name="newboxes" id="newboxes<?=$i?>" <? if($i==1) {?>style="display: block;" <? } else {?> style="display: none;"<? }?>><?=html_entity_decode($video_fetch['video_script']);?></div>
							<? $i++;}?>
						<!--<div name="newboxes" id="newboxes1" style="display: block;"><iframe width="600" height="390" src="http://www.youtube.com/embed/FXoNH2ybh8Y" frameborder="0" allowfullscreen></iframe></div>
						<div name="newboxes" id="newboxes2" style="display: none;"><iframe width="600" height="390" src="http://www.youtube.com/embed/WrfzgDNmPFM" frameborder="0" allowfullscreen></iframe></div>
						<div name="newboxes" id="newboxes3" style="display: none;"><iframe width="600" height="390" src="http://www.youtube.com/embed/U_U5cGUYXU8" frameborder="0" allowfullscreen></iframe></div>
						<div name="newboxes" id="newboxes4" style="display: none;"><iframe width="600" height="390" src="http://www.youtube.com/embed/T9gY8VyJunI" frameborder="0" allowfullscreen></iframe></div>
						<div name="newboxes" id="newboxes5" style="display: none;"><iframe width="600" height="390" src="http://www.youtube.com/embed/H6BDZrnoEwA" frameborder="0" allowfullscreen></iframe></div>-->
						</span>
						
				
						<div class="work" id="flowertabs">
							<ul>
								<?
									$y=1;
									$video_sql2=$obj->selectData(TABLE_VIDEO,"","video_status='Active' order by video_id desc");
									while($video_fetch2=mysql_fetch_assoc($video_sql2))
									{
								?>
								<li><a id="myHeader<?=$y?>" href="javascript:showonlyone('newboxes<?=$y?>');" ><?=$obj->getImageThumb(VIDEO,$video_fetch2['video_image'],'','','100','100','');?></a></li>
								<? $y++; }?>
								<!--<li><a id="myHeader1" href="javascript:showonlyone('newboxes1');" ><img src="images/gallery_img1.jpg" alt="" /></a></li>
								<li><a id="myHeader2" href="javascript:showonlyone('newboxes2');" ><img src="images/gallery_img2.jpg" alt="" /></a></li>
								<li><a id="myHeader3" href="javascript:showonlyone('newboxes3');" ><img src="images/gallery_img3.jpg" alt="" /></a></li>
								<li><a id="myHeader4" href="javascript:showonlyone('newboxes4');" ><img src="images/gallery_img4.jpg" alt="" /></a></li>
								<li><a id="myHeader5" href="javascript:showonlyone('newboxes5');" ><img src="images/gallery_img5.jpg" alt="" /></a></li>-->
							</ul>
						</div>
					</div></td>
              </tr>
            </table>
			</td>
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
