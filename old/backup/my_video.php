<? include("includes/connection.php");
if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];
if($user_id!="")
{
	$data = $obj->selectData(TABLE_USER,"","user_id='".$user_id."'",1);
}

$user_cat=$data['user_cat'];
$parent_user=$data['user_pid'];
if($user_cat!="")
{
	$gallery_cat=explode(',',$user_cat);
	
	for($i=0;$gallery_cat[$i]!='';$i++)
	{
		//$gallcat_permition=parent::selectData(TABLE_GALLERY_PERMITION,"","per_category='".$value."' and per_user='".$parent_user."' and per_package='".$val."'",1);
		/*if($gallcat_permition['per_status']=='Active')*/
		
		$video_sql=$obj->selectData(TABLE_ASSIGN_VIDEO,"DISTINCT(assign_video) AS video_list","assign_video_category like '%,".$gallery_cat[$i].",%' and assign_video_status='Active'");	
		while($video_fetch=mysql_fetch_array($video_sql))
		{
			$videos.=$video_fetch['video_list'].",";
		}
	}
	$videos=rtrim($videos,',');
	$video_arr=explode(',',$videos);
	$uniqueVal=array_unique($video_arr);
	$assign_videos=implode(',',$uniqueVal);
	//print_r($va);
	if($assign_videos=='') { $assign_videos=0; }
	/*$video_sql=$obj->selectData(TABLE_ASSIGN_VIDEO,"GROUP_CONCAT(assign_video) AS video_list","assign_video_category in ($user_cat) and assign_video_status='Active'",1);
	$assign_dvideos=$video_sql['video_list'];
	if($assign_videos=="") { $assign_videos=0; }*/
	
}
else
{
	$assign_videos=0;
}


//$myvideo_sql=$obj->selectData(TABLE_GALLERY,"","gallery_id in ($assign_videos) and gallery_status='Active' order by gallery_id desc");
//echo mysql_num_rows($myvideo_sql);

if($_REQUEST['search']!="")
{
	$extra .= "and (gallery_name like '%".trim($_REQUEST['search'])."%')"; 
}

/*===============Pagination==================*/
$sql=$obj->selectData(TABLE_GALLERY,"","gallery_id in ($assign_videos) and gallery_status='Active' ".$extra." order by gallery_name",2);
$pg_obj=new pagingRecords();
$pg_obj->setPagingParam("g",5,10,1,1);
$getarr=$_GET;
unset($getarr['msg']);
$res=$pg_obj->runQueryPaging($sql,$pageno,$getarr);
$qr_str=$pg_obj->makeLnkParam($getarr,0);
$pageno = 1;
$recno=0;
if($_REQUEST['pageno']!="")
{
	$pageno = $_REQUEST['pageno'];
	if($pageno==1)
	{
		$recno=0;
	}
	else
	{
		$recno+=($pageno*10)-10;
	}
}
/*==========================================*/
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
function showvideo(val)
{
	jQuery.ajax({
	type: "POST",
	url: "ajax_video.php",
	data: "gallery_id="+val,
	success: function(msg){
			$('#video').html(msg);
		}
	});
	location.href='#top';
	
}
</script>
<style type="text/css">
.gry_box{background:#f2f2f2; border:1px solid #d7d5d6; padding:10px;} 
#showreel-page{
	width:980px;
	float:left;
}

#showreel-page span{
	font:normal 13px/18px Arial, Helvetica, sans-serif;
	color:#666666;
	width:100%;
	margin:0 auto;
}

#showreel-page .top_box{
	font:normal 13px/18px Arial, Helvetica, sans-serif;
	color:#666666;
	width:100%;
	margin:0 auto;
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
	width:100%;
	float:left;
}
	
#showreel-page .work ul{
	display:block;
	width:100%;
	margin:0;
	padding:0;
	float:left;
}
	
#showreel-page .work ul li{
	float:left;
	list-style:none;
	width:149px;
	display:block;
	margin:0 10px 10px 0;
	text-align:center;
	min-height:160px;
}
	
#showreel-page .work ul li.spacer{
	float:left;
	width:13px;
	display:block;
}
	
#showreel-page .work ul li img{
	float:left;
	width:149px;
	height:120px;
	text-align:center;
}
	
#showreel-page .work ul li p{
	float:left;
	width:309px;
	font:normal 16px/17px "Museo 500";
	color:#df3f7e;
	margin:15px 0;
	text-align:center;
}

#showreel-page .work ul li a{
	font:normal 13px/18px Arial, Helvetica, sans-serif;
	text-decoration:none;
	color:#df3f7e;
	text-align:center;
	float:left;
}
	
#showreel-page .work ul li a:hover{
	text-decoration:underline;
}
	
</style>
</head>

<body <?php if(!isset($_SESSION['user'])) {?>style="background:#fff url(images/bg.jpg) left top repeat-x;"<?php } ?>>
<a name="top" id="top"></a><table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
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
                <td height="40" align="left" valign="top" class="top_title"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="40" align="left" valign="top"><h1>My Videos</h1></td>
                    <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_profile.php">Profile</a></td>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="my_video.php">My Videos</a></td>
						</tr>
                      </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top"><div id="showreel-page">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" valign="top">
								<?php
								 //$video_fetch=$obj->selectData(TABLE_GALLERY,"","gallery_category_id LIKE '%,".$gallery_category_id.",%' and gallery_status='Active'".$extra." order by gallery_name LIMIT 1 OFFSET $recno",1);
								$video_fetch=$obj->selectData(TABLE_GALLERY,"","gallery_id in ($assign_videos) and gallery_status='Active'".$extra." order by gallery_name LIMIT 1 OFFSET $recno",1);
								?>
								<div id="video" class="top_box">
									<div style="width:100%; margin:0 auto 10px 0; text-align:center;"><?php echo html_entity_decode($video_fetch['gallery_code']);?></div>
									<div><?php echo nl2br(html_entity_decode($video_fetch['gallery_desc']));?></div>
								</div>
							</td>
					  </tr>
					 
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td class="gry_box"><form name="f1" action="" method="post">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input name="search" down_type_name="text" id="search" class="search_input" value=""/><input type="submit" name="submit" class="submit" value="Search"></td>
                          </tr>
                          <tr>
                            <td style="height:15px;"></td>
                          </tr>
                          <tr>
                            <td><div class="work" id="flowertabs">
							<ul>
								<?
									$y=1;
									//$video_sql2=$obj->selectData(TABLE_GALLERY,"","gallery_id in ($assign_videos) and gallery_status='Active' order by gallery_id desc");
									while($video_fetch2=mysql_fetch_assoc($res))
									{
								?>
								<li><a href="javascript:showvideo('<?=$video_fetch2['gallery_id']?>');">
								<img src="<?=$video_fetch2['image_code'];?>" width="100"><br/>
								<?=$obj->short_description($video_fetch2['gallery_name'],25);?>
								</a></li>
								<? $y++; }?>
								
							</ul>
						</div></td>
                          </tr>
                        </table></form></td>
					  </tr>
					</table></div></td>
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
