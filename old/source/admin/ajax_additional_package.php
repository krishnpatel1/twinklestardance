<?php 
include("../includes/connection.php");
$opt=$_REQUEST['opt'];
$is_additional=$_REQUEST['is_additional'];
$addition_ids=$_REQUEST['addition_ids'];
$package_id=$_REQUEST['package_id'];
if($opt==1 || $is_additional=='Yes')
{
?>
<tr class="box-bg">
	<td width="25%" align="left" valign="middle" class="bodytext">Additional Subscription :</td>
	<td width="75%" align="left" valign="middle" class="bodytext">
		<?php echo $obj->getAdditionalPackageList('package_additional_id',$addition_ids,$package_id);?>
		&nbsp;<span style="color:#FF0000;">*</span>
	</td>
</tr>
<?php }?>
