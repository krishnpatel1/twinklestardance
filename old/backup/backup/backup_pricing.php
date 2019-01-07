<?php
include("includes/connection.php");
$package_sql=$obj->selectData(TABLE_PACKAGE,"","package_status='Active'".$extra." order by package_name ");
/*------------------Paging----------------------*/
/*$pg_obj=new pagingRecords();
$pg_obj->setPagingParam("g",5,10,1,1);
$getarr=$_GET;
unset($getarr['msg']);
$res=$pg_obj->runQueryPaging($package_sql,$pageno,$getarr);
$qr_str=$pg_obj->makeLnkParam($getarr,0);
$pageno = 1;
if($_REQUEST['pageno']!="")
{
	$pageno = $_REQUEST['pageno'];
}*/
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
        <td align="left" valign="top">
		<? include("page_includes/slide.php")?>
		</td>
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
                <td height="40" align="left" valign="top" class="top_title"><h1>Pricing</h1></td>
              </tr>
              <tr>
                <td height="15" align="left" valign="top"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="home_content">
					<?php /*?><?=$obj->putContent(5)?><?php */?>
					<div class="package-content">
						<?
							$i=1;
							while($data=mysql_fetch_assoc($package_sql)){
							if($data['package_price_subscription']<>0)
							{
					 	 		echo $i++." ) ". $data['package_name']." monthly payment package <span>$".$data['package_price_subscription']."</span> per month for ".$data['package_duration']." months.";
						 ?>
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  <?
					  		}
							
							if($data['package_price_onetime']<>0)
							{
								echo $i++." ) ".$data['package_name']." Pay up front package - <span>$".$data['package_price_onetime']."</span>";
					  ?>
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  <? 
					  		} 
					  
					  }
					  ?>
					  <!--======================Special Package=============================-->
					  
					  <?
					  		$sppackage_sql=$obj->selectData(TABLE_SPECIAL_PACKAGE,"","sp_package_status='Active' order by sp_package_name");
							$y=$i;
							while($datasp=mysql_fetch_assoc($sppackage_sql)){
							if($datasp['sp_package_price_subscription']<>0)
							{
					 	 		echo $y++." ) ". $datasp['sp_package_name']." monthly payment package <span>$".$datasp['sp_package_price_subscription']."</span> per month for ".$datasp['sp_package_duration']." months.";
						 ?>
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  <?
					  		}
							
							if($datasp['sp_package_price_onetime']<>0)
							{
								echo $y++." ) ".$datasp['sp_package_name']." Pay up front package - <span>$".$datasp['sp_package_price_onetime']."</span>";
					  ?>
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  <? 
					  		} 
					  
					  }
					  ?>
					  <!--===========================End====================================-->
					  <!--3) Twinkle Babies and Twinkle Stars <strong>Recital  Choreography</strong> monthly payment package <span>$99.99</span> per month for 24 months
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  4) Twinkle Babies and Twinkle Stars <strong>Recital  Choreography</strong> Pay up front package - <span>$1899</span>
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  5) Twinkle Babies and Twinkle Stars <strong>Curriculum + Recital Choreography</strong> monthly payment package - <span>$139</span> for 24 months.
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  6) Twinkle Babies and Twinkle Stars <strong>Curriculum + Recital Choreography</strong> Pay up front package - <span>$2899</span>
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  7) ShowSTARS&trade; <strong>curriculum and choreography</strong> monthly payment package <span>$99.99</span> per month for 24 months
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul><br />
					  8) ShowSTARS&trade; <strong>curriculum and choreography</strong> Pay up front package - <span>$1899</span>
					  <ul>
						<li><a href="#"><img src="images/add_to_cart.png" alt="" width="96" height="23" border="0" style="border:0; float:none" /></a></li>
					  </ul>-->
				  </div>
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
