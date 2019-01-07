<?php

$this->breadcrumbs = array(
    Yii::t('app', 'My Account') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'My Account') . "<span>&nbsp;</span>")
);
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'orders-grid',
    'dataProvider' => $model,
    'columns' => array(
        array(
            'header' => Yii::t("messages", 'Sr. No.'),
            'value' => '++$row',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'name' => 'package_subscription_id',
            'value' => '$data->packageSubscription->name',
            'header' => 'Description',
            'htmlOptions' => array('style' => 'width:25%;')
        ),
        array(
            'name' => 'amount',
            'value' => 'Common::priceFormat($data->amount)',
            'header' => 'Amount',
            'htmlOptions' => array('style' => 'width:5%;text-align:right;')
        ),
//        array(
//            'name' => 'amount',
//            'value' => 'Common::priceFormat($data->order->amount_paid)',
//            'header' => 'Paid Amount',
//            'htmlOptions' => array('style' => 'width:5%;text-align:right;')
//        ),
        array(
            'name' => 'payment_type',
            'value' => 'isset(Yii::app()->params["paymentMode"][$data->order->payment_type]) ? Yii::app()->params["paymentMode"][$data->order->payment_type] : "-"',
            'header' => 'Payment Mode',
            'htmlOptions' => array('style' => 'text-align:left;')
        ),
        array(
            'name' => 'payment_date',
            'value' => 'date(Yii::app()->params["defaultDateFormat"],strtotime($data->order->payment_date))',
            'header' => 'Paid On',
            'htmlOptions' => array('style' => 'width:10%;text-align:center;')
        ),
        array(
            'name' => 'expiry_date',
            'value' => 'date(Yii::app()->params["defaultDateFormat"],strtotime($data->expiry_date))',
            'header' => 'Expiration Date',
            'htmlOptions' => array('style' => 'width:10%;text-align:center;')
        ),
        array(
            'name' => 'Term',
            'value' => 'Yii::app()->params[\'displayDuration\'][$data->duration]',
            'header' => 'Term',
            'htmlOptions' => array('style' => 'width:5%;text-align:center;')
        ),
        array(
            'name' => 'notes',
            'value' => '$data->order->notes',
            'header' => 'Notes',
            'htmlOptions' => array('style' => 'width:25%;')
        ),
        array(
            'name' => 'payment_status',
            'value' => 'Yii::app()->params["displayamPaymentStatus"][$data->order->payment_status]',
            'header' => 'Payment Status',
            'htmlOptions' => array('style' => 'width:5%;text-align:center;')
        ),
        array(
            'header'      => 'Action',
            'type'        => 'raw',
            'htmlOptions' => array('style' => 'max-width:80px;width:80px;'),
            'value'       =>function($data)
            {
               if($data["is_deleted"] == 0)
               {
                  return CHtml::button('Cancel', array('class' => 'sub_btn','id' => 'cancel_sub', 'name' => $data["id"],'attr_id' => $data["id"]));
               }
               else
               {
                  return 'Canceled'; 
               }
            },   
        )
    /*
      array(
      'header' => 'Action',
      'class' => 'CButtonColumn',
      'template' => '{view}',
      'buttons' => array
      (
      'view' => array(
      'imageUrl' => Yii::app()->request->baseUrl . '/images/checked.png',
      'url' => '"javascript:void(0);"',
      'options' => array('title' => 'Success payment'),
      ),
      ),
      ), */
    )
));
?>

<script type="text/javascript">
    
    $('#cancel_sub').live('click', function ()
    {
          var confirm_cancel = confirm("Are you want cancel subscription ?");

          var actionURL = "<?php echo CController::createUrl('/user/subscription/cancel'); ?>";

          if(confirm_cancel == true)
          {
             var orderID = $(this).attr('attr_id');

             $.ajax({
                url: actionURL,
                type: 'POST',
                data:{'orderID':+orderID},
                //dataType: 'html',
                success: function (result) 
                {
                   if(result == 1)
                   {
                      alert('Subscription has been canceled successfully.....');
                   }
                   else
                   {
                      alert('Error while cancel subscription....');
                   }
                   location.reload();
                }
              });
          }
    });

</script>