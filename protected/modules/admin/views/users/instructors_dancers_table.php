<?php
$ssUserType = Common::getUserTypeAsPerValue($_REQUEST['user_type']);
$this->breadcrumbs = array(
    $ssUserType => array('class' => 'display active two', 'label' => "<font>&nbsp;</font>" . $ssUserType . "<span>&nbsp;</span>")
);

if ($_REQUEST['user_type'] == Yii::app()->params['user_type']['instructor']) {
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/users/list/'.$_REQUEST['user_type'])), 
        array('label' => Yii::t('app', 'Add Instructors'), 'url' => Yii::app()->createUrl("admin/users/addEditInstructorsDancers", array('user_type' => $_REQUEST['user_type']))),        
    );
}
else{
    $this->menu = array(
        array('label' => Yii::t('app', 'Switch to tile view'), 'url' => array('/user/users/list/'.$_REQUEST['user_type'])),
    );    
}
?>
<div class="middle">
    <div class="fix videos">
        
        <h1>Search instructors</h1>
<?php
        $model = new Users;
        $users_ar=Yii::app()->getRequest()->getParam('Users');
        
$form=$this->beginWidget('CActiveForm', array(
    'action'=>array('/user/users/table/'.$_REQUEST['user_type']),
    'method'=>'get',
)); ?>

    <div class="row row-spaced">
        <label class="inline" for="Users_name">First name</label>
        <?php echo CHtml::textField('Users[name]', $users_ar['name'], array('maxlength'=>255)); ?>        
    </div>        
    <div class="row row-spaced">
        <?php echo $form->label($model,'last_name',array('class'=>'inline')); ?>        
        <?php echo CHtml::textField('Users[last_name]', $users_ar['last_name'], array('maxlength'=>255)); ?>        
    </div>        
    <div class="row row-spaced">
        <?php echo $form->label($model,'email',array('class'=>'inline')); ?>        
        <?php echo CHtml::textField('Users[email]', $users_ar['email'], array('maxlength'=>255)); ?>        
    </div>        
    

    <div class="row row-spaced buttons">
        <?php echo CHtml::submitButton('Search',array('class' => 'submitbtnclass')); ?>
    </div>

<?php $this->endWidget(); 
                
        $this->beginWidget('GxActiveForm', array(
    'id' => 'manage-classes-form',
    'enableAjaxValidation' => false,
));
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'classes-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(    
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'deleteids[]',
                'class' => 'ordercheck'
            ),
            'value' => '$data->id',
        ),
		'first_name',
        'last_name',
        'email',
		array(
            //'class' => 'CButtonColumn',
            //'template' => '{update}',
            //'header' => Yii::t('inx', 'Actions')
            'name' => 'Actions',
            'type' => 'raw',
            'value' => '"<span style=\'text-align:center;display:block;width:100%;\'>".CHtml::link(CHtml::image(Yii::app()->request->baseUrl.\'/images/update.png\'), $this->grid->controller->createUrl("users/addEditInstructorsDancers", array("id" => $data->id, "user_type" => $data->user_type)), array(\'title\' => \'Edit Instructor\'))."</span>"',
            
        )
	
    )
));

if (AdminModule::isStudioAdmin()) 
    echo GxHtml::submitButton(Yii::t('app', 'Delete'), array('id' => 'users-delete', 'class' => 'submitbtnclass'));
$this->endWidget();
        ?>
      
        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript">
    $("#users-delete").click(function() {
        if ($('input:checkbox:checked').length > 0) {
            return confirm("Are you sure you want to delete?");
        } else {
            alert("Please select at least one order to perform this action.");
            return false;
        }
    });
</script>