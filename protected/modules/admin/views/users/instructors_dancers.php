<?php
$ssUserType = Common::getUserTypeAsPerValue($_REQUEST['user_type']);
$this->breadcrumbs = array(
    $ssUserType => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . $ssUserType . "<span>&nbsp;</span>")
);

if ($_REQUEST['user_type'] == Yii::app()->params['user_type']['instructor']) {
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to list view'), 'url' => array('/user/users/table/'.$_REQUEST['user_type'])),   
    );
}
?>
<div class="middle">
    <div class="fix videos">
        <?php
        if ($_REQUEST['user_type'] == Yii::app()->params['user_type']['instructor']) {
            $ssLinkName = "<span>" . CHtml::image(Yii::app()->request->baseUrl . "/images/icon/add.png") . "</span><font>Add $ssUserType</font>";
            echo CHtml::link($ssLinkName, Yii::app()->createUrl("admin/users/addEditInstructorsDancers", array('user_type' => $_REQUEST['user_type'])), array("class" => "block add"));
        }
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view_instructors_dancers',
            'template' => '{items}{pager}'
        ));
        ?>
        <div class="clear"></div>
    </div>
</div>