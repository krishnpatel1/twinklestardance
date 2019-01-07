<?php 
include ("includes/connection.php");
include ("includes/all_form_check.php");
include ("includes/message.php");
require_once("includes/paypal_pro.inc.php");
$temp=$_SESSION['scart'];
$totrec=count($_SESSION['scart']);

if($totrec)
{
	$od_id=$_REQUEST['od_id'];
	$odetails_sql=$obj->selectData(TABLE_ORDER_DETAIL,"","od_id='$od_id' and od_status='Active'","1");
	
	$firstName =urlencode($_SESSION['order']['order_owner_fname']);
	$lastName =urlencode($_SESSION['order']['order_owner_lname']);
	$creditCardType =urlencode($_SESSION['order']['order_card_type']);
	$creditCardNumber = urlencode($_SESSION['order']['order_card']);
	$expDateMonth =urlencode($_SESSION['order']['order_ex_month']);
	$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
	$expDateYear =urlencode($_SESSION['order']['order_ex_year']);
	$cvv2Number = urlencode($_SESSION['order']['order_cvv']);
	$address1 = urlencode($_SESSION['order']['order_country']);
	//$address2 = urlencode('');
	$city = urlencode($_SESSION['order']['order_bill_city']);
	$state =urlencode($_SESSION['order']['order_bill_state']);
	$zip = urlencode($_SESSION['order']['order_bill_zip']);
	$amount = urlencode($odetails_sql['od_price']);
	$currencyCode="USD";
	$paymentAction = urlencode("Sale");
	
	$profileStartDate = urlencode(date('Y-m-d h:i:s'));
	$billingPeriod = urlencode('Month'); // or "Day", "Week", "SemiMonth", "Year"
	$billingFreq = urlencode(1); // combination of this and billingPeriod must be at most a year
	$initAmt = $amount;
	$failedInitAmtAction = urlencode("ContinueOnFailure");
	$desc = urlencode("Recurring $".$amount);
	$autoBillAmt = urlencode("AddToNextBilling");
	$profileReference = urlencode("Anonymous");
	$methodToCall = 'CreateRecurringPaymentsProfile';
	$nvpRecurring ='&BILLINGPERIOD='.$billingPeriod.'&BILLINGFREQUENCY='.$billingFreq.'&PROFILESTARTDATE='.$profileStartDate.'&INITAMT='.$initAmt.'&FAILEDINITAMTACTION='.$failedInitAmtAction.'&DESC='.$desc.'&AUTOBILLAMT='.$autoBillAmt.'&PROFILEREFERENCE='.$profileReference;
	
	$nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.         $padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;
	
	$paypalPro = new paypal_pro('sdk-three_api1.sdk.com', 'QFZCWN5HZM8VBG7Q', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', FALSE, FALSE );
	$resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
	$ack = strtoupper($resArray["ACK"]);
	
	if($ack!="SUCCESS")
	{
		
	}
	else
	{
		$od['od_payment_status']='Paid';
		$od['profile_id']=$resArray["TRANSACTIONID"];
		$od['arr_str']=serialize($resArray);
		$obj->updateData(TABLE_ORDER_DETAIL,$od,"od_id='$od_id'");
		
		$rec['rec_oid']=$odetails_sql['od_order'];
		$rec['rec_odid']=$pay_id;
		$rec['rec_pid']=$odetails_sql['od_pro'];
		$rec['rec_price']=$odetails_sql['od_price'];
		$rec['rec_crdt']=date("Y-m-d");
		$rec['rec_enddt']=date("Y-m-d");
		$obj->insertData(TABLE_RECURRING,$rec);
		
		$obj->reDirect("thankyou.php");
	}
}
else
{
	$obj->reDirect("online_packages.php");
}		
?>