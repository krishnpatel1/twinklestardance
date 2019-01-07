<script type="text/javascript">    
    $('iframe').load(function() {
         $("#loading").fadeIn("slow");
    });
</script>
<!-- Preloader -->
<div id="loading"></div>
<h1 style="margin-top:50px;">Recurring Payment History</h1>
<table class="items">
    <tr style="background: #ca3f77; color:#fff; line-height: 15px;">
        <th style="width:5%;">Sr. No.</th>
        <th style="width:35%;">Subscription Name</th>
        <th style="width:8%;">Tender</th>
        <th style="width:7%;">Amount</th>
        <th style="width:10%;">Transaction Time</th>
        <th style="width:35%;">Transaction State</th>
        <!--<th style="width:5%;">Status</th>-->
    </tr>
    <?php
    if ($amPaymentHistory):
        $snI = 1;
        foreach ($amPaymentHistory as $amData):
            ?>
            <tr <?php echo ($snI % 2 == 0) ? '' : 'style="background:#eee;"'; ?>>
                <td><?php echo $snI; ?></td>
                <td style="text-align:left;padding-left: 5px;"><?php echo $amData['SUBSCRIPTION']; ?></td>
                <td><?php echo Yii::app()->params['paymentHistoryTenderType'][$amData["P_TENDER$snI"]]; ?></td>
                <td><?php echo Common::priceFormat($amData["P_AMT$snI"]); ?></td>
                <td><?php echo $amData["P_TRANSTIME$snI"]; ?></td>
                <td style="text-align:left;padding-left: 5px;"><?php echo Yii::app()->params['paymentHistoryTransStates'][$amData["P_TRANSTATE$snI"]]; ?></td>
                <!--<td><?php //echo Yii::app()->params['paymentErrorResponse'][$amData["P_RESULT$snI"]];              ?></td>-->
            </tr>
            <?php
            $snI++;
        endforeach;
    else:
        ?>
        <tr>
            <td colspan="6" style="text-align:left;">No records found!</td>
        </tr>
    <?php endif; ?>
</table>
<script type="text/javascript">

    $(document).ready(function() {
        $("#loading").fadeIn("slow");
    });
</script>