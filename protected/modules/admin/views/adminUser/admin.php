<?php 
$this->breadcrumbs=array(
	'User'=>array('admin'),
	'Manage',
);
	$user_id=Yii::app()->getUser()->getId();
	
	$this->menu = array(
			array('label'=>'Create Web User', 'url'=>array('create')),
		);		
 
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('user-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>
<h1>Manage Web Users </h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php
$template = '{update}{delete}';
if($this->userType=='admin')
	$template = '{update} {delete}'; 
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'beforeAjaxUpdate'=>'function(id, options){
		var strUrl = options.url;
		var regex = /id=([0-9]+)&/;
		if(regex.test(strUrl) == true) {
			var ar = strUrl.match(regex);
			if(ar[1]){
				if(ar[1] == '.Yii::app()->admin->id.') {
					alert("You can not delete your own account!");
					return false;
				}
			}
		}
		
	}',
	'columns'=>array(
		'id',
			array(	
				'name'=>'user_type',
				//'header'=>Yii::t("messages", 'Vendor'),
				'value'=>'AdminUser::getUserType($data->user_type)',
		 
				'filter'=> AdminUser::getDefinedUserType(),//GxHtml::listDataEx($model,'user_type'),
				),
		'username',
		//'user_type',
        'firstname',
		'lastname',
		//'email',
				
				array(
			'name' => 'email',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->email), "mailto:".CHtml::encode($data->email))',
		),
		//'is_active',
				array(
					'name'=>'is_active',
					'filter'=> array('1'=>'Active','0'=>'Inactive'), 
					'type' => 'html',
					'value'=> 'CHtml::tag("div",  array("style"=>"text-align: center" ) , CHtml::tag("img", array( "src" => UtilityHtml::getStatusImage(GxHtml::valueEx($data, \'is_active\')))))',
		),
		//'created_at',
		//'updated_at',
		/*
		'password',		
		'logdate',
		'lognum',
		'extra',
		*/
		array(			
			'class'=>'CButtonColumn',
			'header'=>'Action',	
			'htmlOptions'=>array('width'=>'75px'),
	    	'template'=>'{update}{delete}  {Change Password}',
			'buttons'=>array
			(
				'Change Password' => array(   
			     		'imageUrl'=>Yii::app()->request->baseUrl.'/images/change-password-icon.png',
			         	'url'=>'Yii::app()->createUrl(\'admin/adminUser/change\', array(\'id\'=>$data->id))',
				),
			),
		),
	),
)); ?>
