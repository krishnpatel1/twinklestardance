<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Email-Template</title>
	<style>
	 	body{
			font-family: Roboto, sans-serif;
			margin: 0;
		}
		table, th, td {
		    border: 2px solid #fff;
		    border-collapse: collapse;
		}
		th, td {
		    padding: 0;
		    text-align: center;
		}
		th {
			background-color: #f4b2d1;
			color: #fff;
			font-weight: bold;
			font-size: 14px;
			padding: 5px 0;
		}
		tr{
			background-color: #f2f2f2;
			font-size: 12px;
		}
		table{
			margin-top: 20px;
		}
		.btn-view {
			background-color: transparent; 
			background-color: #f4b2d1; 
			color: #fff; 
			border: none;
			padding: 3px 15px; 
			border-radius: 4px; 
			margin: 5px 0;
		}
		p{
			color: #6d6d6d;
			font-size: 16px;
			font-weight: normal;
			margin-top: 15px;
			text-align: left;
		}
		h1{
			font-weight: bold;
			font-size: 25px;
			text-align: left;
		}
		.fix-table {
		    width: 640px;
		    text-align: center;
		    margin: 0 auto;
		}
		.header{
			height: 100px;
			width: 100%;
			text-align: center;
			background-color: #f8f8f8;
		}
		.header img{
			margin: 20px 0;
		}
	</style>
  </head>
  <body>
  	<div class="header">
  	 <!-- <a href="#"><img src="<?php //echo Yii::app()->baseUrl . '/images/header-logo.png'; ?>" height="auto" width="auto" alt="image"></a> -->
  	  <a href="#"><img src="http://inheritxdev.net/twinklestardance/twinklestardance_qa/images/header-logo.png" height="auto" width="auto" alt="image"></a> 
  	</div>
	<div class="fix-table">
	  	<h1>Hello Dancers Inc!</h1>
	  	<p>One or more subscription plans are set to expire soon. Please review your subscription plan's expiration dates.</p>  
		<table style="width:640px; margin: 0 auto;">
			<tr>
			 	<th>Sr. No.</th>
				<th>Subscription Description</th> 
				<th>Amount</th>
				<th>Payment Mode</th>
				<th>Expire On</th>
				<th>Term</th>
			</tr>
			<tr>
				<td>1</td>
				<td>The Little Mermaid - Recital Choreography</td>
				<td>$599.00</td>
				<td>Yearly Payment</td>
				<td>12/02/2018</td>
				<td>Yearly</td>
		 	</tr>
		 	<tr>
				<td>2</td>
				<td>Twinkle Star Dance Now</td>
				<td>$699.00</td>
				<td>Yearly Payment</td>
				<td>12/03/2018</td>
				<td>Yearly</td>
		 	</tr>
		 	<tr>
				<td>3</td>
				<td>Cinderella - Recital Choreography</td>
				<td>$799.00</td>
				<td>Yearly Payment</td>
				<td>12/02/2018</td>
				<td>Yearly</td>
		 	</tr>
		</table>
		<p>Regards,<br>Twinkle Star Dance</p>
	  </div>
  	</body>
</html>
