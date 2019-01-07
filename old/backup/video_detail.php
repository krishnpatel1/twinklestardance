<? include("includes/connection.php");
if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];
$gallery_id=$_REQUEST['id'];
$video_fetch=$obj->selectData(TABLE_GALLERY,"","gallery_id='".$gallery_id."' and gallery_status='Active'",1);
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
	width:685px;
	height:331px;
	float:right;
	font:normal 12px/16px Arial, Helvetica, sans-serif;
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
                <td height="40" align="left" valign="top" class="top_title"><h1><?=$video_fetch['gallery_name'];?></h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top"><div id="showreel-page">
						
						<span>
							<?=$video_fetch['gallery_desc'];?>
						</span>
						<div class="work1" id="flowertabs">
							<img src="<?=$video_fetch['image_code'];?>" width="250" height="250">
						</div>
					</div>
				</td>
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
