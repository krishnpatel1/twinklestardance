<?php
	include("includes/connection.php");
	$od_order=$_REQUEST['od_order'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
body{margin:0; padding:0; font:normal 13px/16px Arial, Helvetica, sans-serif; color:#000;}
h1{font:bold 22px/18px Arial, Helvetica, sans-serif; color:#e94685;}
a{font:bold 13px/16px Arial, Helvetica, sans-serif; color:#757575; text-decoration:none; padding:0 0 10px 10px; float:left; background:url(images/arrow.jpg) 0 5px no-repeat;}
a:hover{text-decoration:none; color:#e94685;}
</style>

</head>

<body <?php if(!isset($_SESSION['user'])) {?>style="background:#fff url(images/bg.jpg) left top repeat-x;"<?php } ?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td height="40" align="left" valign="middle" class="top_title" style="padding-left:5px; border-bottom:1px dashed #757575;"><h1>Gallery</h1></td>
	</tr>
	<tr><td style="height:10px;"></td></tr>
	<tr>
	  <td align="left"><table align="left" cellpadding="0" cellspacing="0">
        <?php
					$order_sql=$obj->selectData(TABLE_ORDER_DETAIL,"","od_order='$od_order' and od_payment_status='Paid'");
					if(mysql_num_rows($order_sql)>0)
					{
						$sql=$obj->selectData(TABLE_ORDER_DETAIL,"","od_order='$od_order' and od_package_status='Yes' and od_payment_status='Paid' order by od_id desc");
						$norowa=mysql_num_rows($sql);
						if($norowa>0)
						{
						$i=1;
						while($data=mysql_fetch_array($sql))
						{
				?>
        <tr>
          <td align="left" style="padding-left:5px;"><?php echo $obj->get_catName($data['od_pro'],$od_order)?></td>
        </tr>
        <tr>
          <td style="height:10px;"></td>
        </tr>
        <?php } } else {?>
		<tr>
          <td align="left" style="padding-left:5px;">Sorry, this gallery has been deactivated by Twinkle Star Dance™ Admin.  If you believe this is a mistake, please email info@twinklestardance.com or call (925) 447-5299.</td>
        </tr>
        <tr>
          <td style="height:10px;"></td>
        </tr>
		<?php 
			} 
		 }
		 else
		 {
		 ?>
		 <tr>
          <td align="left" style="padding-left:5px;">No Record !</td>
        </tr>
        <tr>
          <td style="height:10px;"></td>
        </tr>
		 <?php
		 }
		
		?>
      </table></td>
	</tr>
</table>
</body>
</html>