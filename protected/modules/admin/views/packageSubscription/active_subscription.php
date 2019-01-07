<head>
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />
</head>

<?php

$_SESSION['display_subscription'] = 0;

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'package-subscription-grid',
    'dataProvider' => $model,
    'columns' => array(
        array(
            'header' => Yii::t("messages", 'Sr. No.'),
            'value' => '++$row',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'name' => 'studio_name',
            'value' => '$data["order"]["user"]["studio_name"]',
            'visible'     => ($user_type > 1) ? false : true,
            'header' => 'Studio Name',
            'htmlOptions' => array('style' => 'width:25%;')
        ),
        array(
            'name' => 'package_subscription_id',
            'value' => '$data["packageSubscription"]["name"]',
            'header' => 'Subscription Description',
            'htmlOptions' => array('style' => 'width:25%;')
        ),
        array(
            'name' => 'amount',
            'value' => 'Common::priceFormat($data["amount"])',
            'header' => 'Amount',
            'htmlOptions' => array('style' => 'width:5%;text-align:right;')
        ),
       array(
            'name' => 'payment_type',
            'value' => 'isset(Yii::app()->params["paymentMode"][$data["order"]["payment_type"]]) ? Yii::app()->params["paymentMode"][$data["order"]["payment_type"]] : "-"',
            'header' => 'Payment Mode',
            'htmlOptions' => array('style' => 'text-align:left;')
        ),
        array(
            'name' => 'expiry_date',
            'value' => 'date(Yii::app()->params["defaultDateFormat"],strtotime($data["expiry_date"]))',
            'header' => 'Expire On',
            'htmlOptions' => array('style' => 'width:10%;text-align:center;')
        ),
        array(
            'name' => 'Term',
            'value' => 'Yii::app()->params[\'displayDuration\'][$data["duration"]]',
            'header' => 'Term',
            'htmlOptions' => array('style' => 'width:5%;text-align:center;')
        ),
       array(
            'header'      => 'Action',
            'type'        => 'raw',
            'visible'     => ($user_type > 1) ? true : false,
            'htmlOptions' => array('style' => 'max-width:80px;width:80px;'),
            'value'       =>function($data)
            {
                return CHtml::button('Cancel', array('class' => 'sub_btn','id' => 'cancel_sub', 'name' => $data["id"],'attr_id' => $data["id"]));
               
            },   
        ),
        array(
            'header'      => 'Action',
            'type'        => 'raw',
            'visible'     => ($user_type > 1) ? true : false,
            'htmlOptions' => array('style' => 'max-width:80px;width:80px;'),
            'value'       =>function($data)
            {
                return CHtml::button('Update', array('class' => 'sub_btn','id' => 'update_sub', 'name' => $data["id"],'attr_id' => $data["id"]));
               
            },   
        ),
    )
));

?>

<script type="text/javascript">
$(document).ready(function()
{
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

    //$("#update_sub").click(function() 
    $('#update_sub').live('click', function () 
    {
        var orderID = $(this).attr('attr_id');

        var actionURL = "<?php echo Yii::app()->getBaseUrl(true) . '/renewSubscription/makePayment?orderID='; ?>"+orderID;
        window.open(actionURL, '_blank');
    });
});
     

          /*$.colorbox({
                       html:'<div class="modal-content"><div class="modal-header"><h4 class="modal-title">Cancel Subscription</h4></div><div class="modal-body"><p>Are you want cancel subscription ?</p></div><div class="modal-footer"><button type="button" class="btn btn-default" id="confirm_cancel" attr_id='+orderID+'>Yes</button><button type="button" class="btn btn-default" id="close_btn">Cancel</button></div></div>'
                   }); */

          /*$("#confirm_cancel").click(function() 
          {
              $.ajax({
                url: actionURL,
                type: 'POST',
                data:{'orderID':+orderID},
                //dataType: 'html',
                success: function (result) 
                {
                   $.colorbox.close();
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
          });*/
   

</script>

