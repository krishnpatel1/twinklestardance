<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-rules-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'role_desc'); ?>
		<?php echo $form->textField($model,'role_desc',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'role_desc'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'role_id'); ?>
		<?php $rowSet = UserRole::model()->findAll('is_publish=1');
			$dataRules = array('0'=>'Select');
			foreach($rowSet as $row) {
				$dataRules[$row->id] = $row->role_name;
 			}
		?>
		<?php echo $form->dropDownList($model, 'role_id', $dataRules)?>
		<?php echo $form->error($model,'role_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'module_id'); ?>
		
		<?php $rowSet = Module::model()->findAll('is_publish=1');
			$dataModules = array('0'=>'Select');
			foreach($rowSet as $row) {
				$dataModules[$row->id] = $row->module_code;
				$module = $row->module_code;
				$ControllerList[$module] = UserAccessControll::getControllersList($module); 
				foreach ($ControllerList[$module]['controllers'] as $controller) {
					$dataController[$module][$controller['name']] = $controller['name']; 
					$ActionListData[$module][$controller['name']] = UserAccessControll::getDefinedActionList($module,$controller['name']); 
				}
 			}
		?>
		<?php echo $form->dropDownList($model, 'module_id', $dataModules, array('onchange'=>'loadControllerList(this)')) ?>
		<?php echo $form->error($model,'module_id'); ?>
	</div>

	<div class="row">
		
		
		<?php echo $form->labelEx($model,'privileges_controller'); ?>
		<?php echo $form->dropDownList($model, 'privileges_controller', array('0'=>'--Select Controller--'), array('onChange'=>'loadActions(this)'))?>
		<?php echo $form->error($model,'privileges_controller'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'privileges_actions'); ?>
		<!--   <div id="action_list_div"></div> -->
		<?php echo $form->listBox($model, 'privileges_actions', array('0'=>'--Select Actions--'), array('multiple'=>'mulitple', 'style'=> 'width: 150px; height: 100px;'))?>
		<?php // echo $form->textField($model,'privileges_actions',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'privileges_actions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'permission'); ?>
		<?php echo $form->dropDownList($model, 'permission', array(1=>'Allow', 0=>'Disallow'))?>
		<?php //echo $form->textField($model,'permission',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'permission'); ?>
	</div>

	<?php echo $form->hiddenField($model,'permission_type',array('size'=>60,'maxlength'=>255)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">
	var objAccess = <?php echo CJSON::encode($ControllerList); ?>;
	var objActions = <?php echo CJSON::encode($ActionListData); ?>;
	var objModules = <?php echo CJSON::encode($dataModules); ?>;
	
	var obAct;
	var obContr;
	function loadControllerList(selected)
	{
		if(selected.value) var sel = selected.value;
		else var sel =  selected.val();
		if(objModules[sel] == 'admin') {
			$('#UserRules_permission_type').val('admin');
		}else if(objModules[sel] == 'member') {
			$('#UserRules_permission_type').val('member');
		}else if(objModules[sel] != '0') {
			$('#UserRules_permission_type').val('');
		}else {
			$('#UserRules_permission_type').val('*');
		}
		
		var  curOption="<option value='0'>--Select Controller--</option>";
		$('#UserRules_privileges_controller').html('');
		if(sel>0) { 
		obContr = (eval('objAccess.'+ objModules[sel]+'.controllers')); //alert(objModules[selected.value]);
			$.each(obContr, function(key, value) {
				var s = '';
				if(value.name=='<?php echo ($model->privileges_controller)?>') var s = 'selected="selected"';
				curOption+="<option value='" + value.name + "' "+ s +">" + value.name + "</option>"
			});
		}

		//alert(curOption);
		$('#UserRules_privileges_controller').append(curOption);
	}
	var selActions = <?php echo json_encode(explode(',',$model->privileges_actions))?>;
	function loadActions(selected)
	{
		if(selected.value) var sel = selected.value;
		else var sel =  selected.val();
		
		$('#UserRules_privileges_actions').html('');
		obAct = (eval('objActions.'+ objModules[$('#UserRules_module_id').val()]+'.'+sel)); //alert(objModules[selected.value]);
		var  curOption="<option value='0'>--Select Actions--</option>";
		
		$.each(obAct, function(key, value) {
			var s = '';
			if(jQuery.inArray(value,selActions)>=0) s='selected="selected"';
			else s='';
			curOption+= "<option value='" + value + "' "+s+">" + value + "</option>";
		});
		$('#UserRules_privileges_actions').append(curOption);
	}

	<?php if(isset($_GET['id'])) { ?>
		loadControllerList($('#UserRules_module_id option:selected'));
		loadActions($('#UserRules_privileges_controller option:selected'));
	<?php } ?>
</script>
	
</div><!-- form -->