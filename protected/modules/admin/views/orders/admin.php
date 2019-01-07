<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Orders') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Orders') . "<span>&nbsp;</span>")
);
$this->beginWidget('GxActiveForm', array(
    'id' => 'manage-orders-form',
    'enableAjaxValidation' => false,
));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'orders-grid',
    'dataProvider' => $model,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'orderids[]',
                'class' => 'ordercheck'
            ),
            'value' => '$data->id',
        ),
        array(
            'name' => 'user_id',
            'value' => 'ucfirst($data->user->first_name." ".$data->user->last_name)',
            'header' => 'Name'
        ),
        array(
            'name' => 'payment_date',
            'value' => 'date("d/m/Y",strtotime($data->payment_date))',
            'header' => 'Date',
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'value' => 'CHtml::mailto($data->user->email)',
            'header' => 'Email',
            'type' => 'raw'
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => '$data->id',
            'header' => 'Order Number',
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => 'payment_status',
            'type' => 'raw',
            'value' => '$data->getPaymentStatusText()',
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => 'sub_total',
            'type' => 'raw',
            'value' => 'Common::priceFormat($data->sub_total)',
            'header' => 'Sub Total',
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'name' => 'tax',
            'type' => 'raw',
            'value' => 'Common::priceFormat($data->tax)',
            'header' => 'Tax',
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'name' => 'amount_paid',
            'type' => 'raw',
            'value' => 'Common::priceFormat($data->amount_paid)',
            'header' => 'Amount Paid',
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        array(
            'name' => 'user_type',
            'value' => 'Common::getUserTypeAsPerValue($data->user->role_id)',
            'header' => 'User Type',
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => 'payment_type',
            'type' => 'raw',
            'value' => 'isset(Yii::app()->params["paymentMode"][$data->payment_type]) ? Yii::app()->params["paymentMode"][$data->payment_type] : "-"',
            'header' => 'Payment Mode',
            'htmlOptions' => array('style' => 'text-align:left;')
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'header' => Yii::t('inx', 'Actions')
        )
    )
));
if (AdminModule::isAdmin())
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'order-delete', 'class' => 'submitbtnclass'));
$this->endWidget();
?>

<script type="text/javascript">
    $("#order-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one order to perform this action.");
            return false;
        }
    });
</script>