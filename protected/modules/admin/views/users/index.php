<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Studios') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . Yii::t('app', 'Studios') . "<span>&nbsp;</span>")
);
if (Yii::app()->user->hasFlash('success')):
    ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<div style="float:right;">
    <?php echo CHtml::link('List requests for monthly subscription', array('users/getRequestForMonthlySub'),array('style' => 'color:blue;text-decoration:underline;')); ?>
</div>
<div class="middle">
    <div class="fix videos">        
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'search-form',
            'enableAjaxValidation' => false,
        ));
        echo $form->textField($model, 'q') . '&nbsp;';
        echo GxHtml::submitButton(Yii::t('app', 'Search'));
        $this->endWidget();

        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $model->search(),
            'itemView' => '_view',
            'template' => '{items}{pager}'
        ));
        ?>
        <div class = "clear"></div>
    </div>
</div>
