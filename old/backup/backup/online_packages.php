<?php
include("includes/connection.php");
$package_sql=$obj->selectData(TABLE_PACKAGE,"","package_status='Active' order by package_id ",2);
/*------------------Paging----------------------*/
$pg_obj=new pagingRecords();
$pg_obj->setPagingParam("g",5,10,1,1);
$getarr=$_GET;
unset($getarr['msg']);
$res=$pg_obj->runQueryPaging($package_sql,$pageno,$getarr);
$qr_str=$pg_obj->makeLnkParam($getarr,0);
$pageno = 1;
if($_REQUEST['pageno']!="")
{
	$pageno = $_REQUEST['pageno'];
}
/*------------------------------------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dance Training Videos, Dance Lesson Plans | Livermore, CA</title>
<?php include("page_includes/common.php"); ?>
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
                <td height="40" align="left" valign="top" class="top_title"><h1>Twinkle Star Dance Video Packages</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?
						while($data=mysql_fetch_assoc($res)){
					?>
					<tr>
						<td align="left" valign="top" class="product_list"><?=$obj->getImageThumb(PACKAGE_IMG,$data['package_image'],'','','125','173','');?> <strong><?=$data['package_name']?></strong><br /><?=$obj->short_description(html_entity_decode($data['package_description']),100)?><br />
						<a href="package-detail.php?id=<?=$data['package_id']?>">Read More...</a>
						</td>
					</tr>
					<? }?>
                </table>
				</td>
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
