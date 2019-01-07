<?php
$ssInstructorAddEdit = ($model->id > 0) ? ucfirst($model->first_name.' '.$model->last_name) : Yii::t('app', 'Add');
$ssUserType = Common::getUserTypeAsPerValue($_REQUEST['user_type']);
$this->breadcrumbs = array(
    "<font>&nbsp;</font>" . $ssUserType . "<span>&nbsp;</span>" => array('class' => 'two', 'url' => CController::createUrl("users/listInstructorsDancers", array('user_type' => $user_type))),
    $ssInstructorAddEdit => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . $ssInstructorAddEdit . "<span>&nbsp;</span>")
);

$this->renderPartial('_formAddEdit', array(
    'model' => $model,
    'amResult' => $amResult,
    'amSelected' => $amSelected,
    'omModelTrans' => $omModelTrans
));
?>