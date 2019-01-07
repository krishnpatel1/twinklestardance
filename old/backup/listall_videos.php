<?php
include("includes/connection.php");
include("includes/all_form_check.php");
if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];
$order_video_oder=$_REQUEST['order'];
if($order_video_oder!='')
{
	$condition=" and order_video_oder='".$order_video_oder."'";
}
$order_video_sql=$obj->selectData(TABLE_ORDER_VIDEO,"order_video_gallery","order_video_uid='".$user_id."' and order_video_status='Active' ".$condition." order by order_video_gallery");

$gallery_id="";
while($order_video_arr=mysql_fetch_array($order_video_sql))
{
	$gallery_id.=$order_video_arr['order_video_gallery'].",";
}
$gallery_id=rtrim($gallery_id,',');
if($gallery_id=="")
{
	$gallery_id=0;
}

if($_REQUEST['search']!="")
{
	$extra = " and (gallery_name like '%".trim($_REQUEST['search'])."%')"; 
}

/*===============Pagination==================*/

$sql=$obj->selectData(TABLE_GALLERY,"","gallery_id IN (".$gallery_id.") and gallery_status='Active' ".$extra." order by gallery_name",2);
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

/*if(!isset($_SESSION['user'])) { $obj->reDirect('login.php'); }
$user_id=$_SESSION['user']['user_id'];

$sql=$obj->selectData(TABLE_ORDER,"","order_user='".$_SESSION['user']['user_id']."' order by order_id desc",2);
$pg_obj=new pagingRecords();
$pg_obj->setPagingParam("g",5,10,1,1);
$getarr=$_GET;
unset($getarr['msg']);
$res=$pg_obj->runQueryPaging($sql,$pageno,$getarr);
$qr_str=$pg_obj->makeLnkParam($getarr,0);
$pageno = 1;
if($_REQUEST['pageno']!="")
{
	$pageno = $_REQUEST['pageno'];
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
<script language="javascript" type="text/javascript">
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
	width:966px;
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
                    <td height="40" align="left" valign="top"><h1>All Videos</h1></td>
                    <td valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="2">
                        <tr>
							<td align="center" valign="middle" class="acc_btn_sm_select"><a href="listall_videos.php">Watch Videos</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_profile.php">Profile</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_user.php">User</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_order.php">My Subscriptions</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_document.php">My Documents</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="my_category.php">Manage Galleries</a></td>
							<td align="center" valign="middle" class="acc_btn_sm"><a href="list_video.php">Manage Videos</a></td>
						</tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
			  <tr>
                <td align="left" valign="top" class="home_content">
				
				<table width="100%"  border="0" cellpadding="3" cellspacing="2" class="gry_border">
					<tr>
						<td>
							<div id="showreel-page">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td align="center" valign="top">
											<?php
											if($extra=='')
											$video_fetch=$obj->selectData(TABLE_GALLERY,"","gallery_id IN (".$gallery_id.") and gallery_status='Active'".$extra." order by gallery_name LIMIT 1 OFFSET $recno",1);
											else
											$video_fetch=$obj->selectData(TABLE_GALLERY,"","gallery_id IN (".$gallery_id.") and gallery_status='Active'".$extra." order by gallery_name LIMIT 1",1);
											?>
											<div id="video" class="top_box">
												<div style="width:100%; margin:0 auto 10px 0; text-align:center;"><?php echo html_entity_decode($video_fetch['gallery_code']);?></div>
												<div><?php echo nl2br(html_entity_decode($video_fetch['gallery_desc']));?></div>
											</div>					</td>
									  </tr>
									  <tr>
										<td align="left" valign="top">&nbsp;</td>
									  </tr>
									  <tr>
										<td align="left" valign="top" class="gry_box"><table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td align="left" valign="top">
											<form name="f1" action="" method="post">
											<table border="0" cellspacing="0" cellpadding="0">
											  <tr>
												<td align="left" valign="top">
													<input name="search" down_type_name="text" id="search" class="search_input" value=""/>
													<input type="submit" name="submit" value="Search" class="submit">
												</td>
											  </tr>
											</table>
											</form>
											</td>
										  </tr>
										  <tr>
											<td align="left" valign="top" style="height:15px;"></td>
											</tr>
										  <tr>
											<td align="left" valign="top">
												<div class="work" id="flowertabs">
													<ul>
														<?
															$y=1;
															while($video_fetch2=mysql_fetch_assoc($res))
															{
														?>
															<li><a href="javascript:showvideo('<?=$video_fetch2['gallery_id']?>');" ><img src="<?=$video_fetch2['image_code'];?>" width="100"><br/>
																  <?=$obj->short_description($video_fetch2['gallery_name'],25);?>
															  </a></li>
														<? $y++; }?>
													</ul>
												</div>							</td>
										  </tr>
										  
										</table>					</td>
									  </tr>
									  <tr>
										<td align="center"><? echo $pg_obj->pageingHTML;?></td>
									  </tr>
								</table>
							</div>
						</td>
					</tr>
					
						  <?php /*?><? if($pg_obj->totrecord){?>
							<tr align="center" valign="middle">
								<td width="5%" align="center" valign="middle" class="bodytext_title_white"><strong>#</strong></td>
								<td width="95%" align="left" valign="top" class="bodytext_title_white"><strong>Gallery</strong></td>
							</tr>
						   <?php }?>
							<? 
					 		 $i=1;
							 while($row=mysql_fetch_array($res)){
							 	$res_orderdetails=$obj->selectData(TABLE_ORDER_DETAIL,"","od_order='".$row['order_id']."' and od_package_status='Yes' and od_payment_status='Paid'");
								if(mysql_num_rows($res_orderdetails)>0)
								{
										while($product=mysql_fetch_array($res_orderdetails)){ 
										$orderProType = $product['od_pro_type'];
										$orderPriceType = $product['od_price_type'];
										$packageId = $product['od_pro'];
										if($orderProType == "P")
										{
											if($orderPriceType == "onetime"){
												$orderPriceDetails = $obj->selectData(TABLE_PACKAGE,"","package_id='".$packageId."'",1);
												$product_name= $orderPriceDetails['package_name'];
											}else{
												$orderPriceDetails = $obj->selectData(TABLE_PACKAGE,"","package_id='".$packageId."'",1);
												$product_name= $orderPriceDetails['package_name'];
											}
										}
										if($orderProType == "DW")
										{
											$product_name=$obj->get_product($packageId)." -- ".$obj->get_downloadType($product['od_dw_type']);
										}
							?>
										  <tr class="tr_bg">
											<td align="center" valign="top" class="box_pink"><?=$i++;?></td>
											<td align="left" valign="top" class="box_pink">
											<strong><?php echo $product_name;?></strong><br/>
											<?php 
												$category=$obj->selectData(TABLE_PACKAGE,"gallery_category_ids","package_id='".$product['od_pro']."'",1);
												$ids=explode(',',$category['gallery_category_ids']);
												foreach($ids as $value)
												{
													$gallcat_permition=$obj->selectData(TABLE_GALLERY_PERMITION,"","per_category='".$value."' and per_order='".$row['order_id']."' and per_package='".$product['od_pro']."'",1);
													
													$gallcat_arr=$obj->selectData(TABLE_GALLERY_CATEGORY,"","category_id='".$value."'",1);
													//$cat.=$gallcat_arr['category_id'].",";
													if($gallcat_permition['per_status']=='Active')
													{
												?>
												<div class="arrow_link"><a href="package_video.php?id=<?=$gallcat_arr['category_id']?>&order_id=<?=$row['order_id']?>"><?php echo $gallcat_arr['category_name'];?></a></div>
											<?php
													}
												}
											?>
										  </td>
									  </tr>
                      <?php 
					  			} 
							
							}
						}
						//echo rtrim($cat,',');
					  ?><?php */?>
				</table>
				
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
