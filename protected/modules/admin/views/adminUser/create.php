<?php
$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage Web Users', 'url'=>array('admin')),
);
?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<h1>
<?php echo Yii::t("messages", 'Create Web User'); ?>
</h1>

 

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>