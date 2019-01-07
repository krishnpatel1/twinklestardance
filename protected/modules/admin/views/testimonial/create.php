<?php
/* @var $this TestimonialController */
/* @var $model Testimonial */


$this->breadcrumbs = array(
    "<font>&nbsp;</font>Testimonial<span>&nbsp;</span>" => array('class' => 'two', 'url' => array('admin')),
    Yii::t('app', 'Create') => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>".Yii::t('app', 'Create')."<span>&nbsp;</span>")
);

?>

<h1>Create Testimonial</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>