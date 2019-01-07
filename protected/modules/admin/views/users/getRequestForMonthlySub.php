<div id="loading" style="display:none;"></div>
<?php
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . Yii::t('app', 'Studios') . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('index')),
    Yii::t('app', 'Monthly Subscription Requests') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Monthly Subscription Requests') . "<span>&nbsp;</span>")
);
?>

<div class="flash_message">
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'payment-request-grid',
    'dataProvider' => $model,
    //'filter' => $model,
    'columns' => array(
        array(
            'name' => 'package_subscription_id',
            'value' => '$data->packageSubscription->name',
            'header' => 'Subscriptoin'
        ),
        array(
            'name' => 'user_id',
            'value' => '$data->user->studio_name',
            'header' => 'Studio'
        ),
        array(
            'name' => 'duration',
            'value' => 'Yii::app()->params["displayDuration"][$data->duration]',
            'header' => 'Term'
        ),
        array(
            'name' => 'is_admin_approved',
            'type' => 'html',
            'value' => 'Common::displayApprovalImage($data->is_admin_approved)',
            'header' => 'Is Approved',
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'template' => '{approve}{reject}',
            'class' => 'CButtonColumn',
            'header' => Yii::t('inx', 'Actions'),
            'deleteConfirmation' => "Are you sure to approve/reject this request?",
            'buttons' => array
                (
                'approve' => array(
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/approve.png',
                    'url' => 'Yii::app()->createUrl(\'admin/users/getRequestForMonthlySub\', array(\'id\'=>$data->id,\'is_approve\' => 1))',
                    'options' => array(
                        'title' => 'Approve Request',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => 'js:$(this).attr("href")',
                            'beforeSend' => 'function(response){$("#loading").fadeIn("slow");}',
                            'complete' => 'function(response){$("#loading").fadeOut("slow");}',
                            'success' => 'function(response){
                                window.location.reload(true);
                             }',
                            'error' => 'function(response){
                                window.location.reload(true);                                
                            }',
                        ),
                    ),
                ),
                'reject' => array(
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/reject.png',
                    'url' => 'Yii::app()->createUrl(\'admin/users/getRequestForMonthlySub\', array(\'id\'=>$data->id,\'is_approve\' => 2))',
                    'options' => array(
                        'title' => 'Reject Request',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => 'js:$(this).attr("href")',
                            'beforeSend' => 'function(response){$("#loading").fadeIn("slow");}',
                            'complete' => 'function(response){$("#loading").fadeOut("slow");}',
                            'success' => 'function(response){
                                window.location.reload(true);                                
                             }',
                            'error' => 'function(response){
                                window.location.reload(true);                                
                            }',
                        ),
                    ),
                ),
            ),
        )
    ),
));
?>
