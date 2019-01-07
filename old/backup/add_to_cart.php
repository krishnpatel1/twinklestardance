<?
session_start();
include("includes/connection.php");
/*if(isset($_POST['prod_id']))
{
	$prod_id=$_POST['prod_id'];
	$qty=$_REQUEST['qty'];
}*/
$prod_id=$_REQUEST['prod_id'];
$gallery=$_REQUEST['gallery'];
$price=$_REQUEST['price'];
$p_type=$_REQUEST['p_type'];
$dw_type=$_REQUEST['dw_type'];
$pack_type=$_REQUEST['pack_type'];
$duration=$_REQUEST['duration'];

$qty=1;

$mFlag=0;
if(is_array($_SESSION['scart']))
{
	$cart=$_SESSION['scart'];
	$totrec=count($_SESSION['scart']);
	$temp=$_SESSION['scart'];
	
	/*for($i=0;$i<=$totrec;$i++)
	{
		$productid=$cart[$i]['productid'];
		if($productid==$prod_id)
		{	
				$mFlag=1;
				$var=$i;	
		}
	}
	
	if($mFlag==1)
	{
		$cart[$var]['qty']=$cart[$var]['qty']+$qty;
	}
	else
	{*/
	$newcart['productid']=$prod_id;
	$newcart['gallery']=$gallery;
	$newcart['p_type']=$p_type;
	$newcart['price']=$price;
	$newcart['pack_type']=$pack_type;
	$newcart['duration']=$duration;
	$newcart['dw_type']=$dw_type;
	//$prod_detail = $obj->selectData(TABLE_PRODUCT,"","prod_id='".$prod_id."'",1);
	//$priceVal = $prod_detail['prod_price'];
	
	//$newcart['productprice']=$priceVal;
	//$newcart['qty']=$qty;
	$cart[]=$newcart;
	
	//}
}
else
{
	$cart=array();
	$newcart['productid']=$prod_id;
	$newcart['gallery']=$gallery;
	$newcart['p_type']=$p_type;
	$newcart['price']=$price;
	$newcart['pack_type']=$pack_type;
	$newcart['duration']=$duration;
	$newcart['dw_type']=$dw_type;
	//$prod_detail = $obj->selectData(TABLE_PRODUCT,"","prod_id='".$prod_id."'",1);
	//$priceVal = $prod_detail['prod_price'];
	//$offerActive = false;
	
	//$newcart['productprice']=$priceVal;
	//$newcart['qty']=$qty;
	//$newcart['qty']=$qty;
	$cart[]=$newcart;
	$_SESSION['scart']=$cart;
}
	unset($_SESSION['scart']);
	$_SESSION['scart']=$cart;
	$record=count($_SESSION['scart']);
	$_SESSION['record']=$record;
	
	$sum=0;
	$totrec=count($_SESSION['scart']);
	$temp=$_SESSION['scart'];

   $obj->reDirect('confirmation.php');
?>