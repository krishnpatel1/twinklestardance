<?php

class UserAccessControll
{
	public function __construct()
	{

	}
	public function getModule($moduleKey, $field='')
	{
		$moduleObj = new Module();
		$moduleData = $moduleObj->find('module_code = ? AND is_publish = 1', array($moduleKey));
		if($field!='' && isset($moduleData->$field)) {
			return $moduleData->$field;
		}
		 
		return $moduleData->attributes;
	}
	public function getControllersList($moduleKey='',$withActions=false)
	{
		$app = Yii::app();
		//$moduleList = array_keys($app->getModules());.
		$moduleList = array_keys($app->getModules());

		if(in_array($moduleKey,$moduleList)) {
			$module = $app->getModule($moduleKey);
			if ($handle = opendir($module->getControllerPath())) {
				/* This is the correct way to loop over the directory. */
				while (false !== ($file = readdir($handle))) {
					if(strstr($file,'Controller.php')) {
						$controller['name'] = str_ireplace('.php', '', $file);
						if($withActions) {
							//Yii::import('application.modules.'.$moduleKey.'.controllers.'.$controller['controller'],true);
							//$methods = get_class_methods($controller['controller']);
							$controller['actions'] = $this-> getActionRuleList($moduleKey,$controller['name']); //$methods;
						}
						$array[] = $controller;
					}
				}
				closedir($handle);
			}
			return array('module'=>$this->getModule($moduleKey), 'controllers'=>$array);
		}
		return false;
	}

	public function getActionRuleList($moduleKey='', $ControllerId='')
	{
		if($ControllerId!='') {
			Yii::import('application.modules.'.$moduleKey.'.controllers.'.$ControllerId,true);
			$classObj = new $ControllerId('');
			$accessRules = $classObj->defaultAccessRules();
			return $accessRules;
		}
		return false;
	}
	public function getDefinedActionList($moduleKey='', $ControllerId='')
	{
		//p($ControllerId,0 );
		if($ControllerId!='') {
			Yii::import('application.modules.'.$moduleKey.'.controllers.'.$ControllerId,true);
			$classObj = new $ControllerId('');
			$accessRules = array();
			if(method_exists($classObj, 'defaultAccessRules')) {
				$accessRules = $classObj->defaultAccessRules();
			}
			$actions = array();
			foreach($accessRules as $rules) {
				if(isset($rules['actions']))
				$actions = array_merge( $actions, $rules['actions']);
			}
			return $actions;
		}
		return false;
	}
	public function getRoleByModule($Module, $select='')
	{
		$obj = new UserRole();
		$data = $obj->find('role_type = ? AND parent_id=0 AND is_publish = 1', array($Module['module_code']));
		if($select!='' && $data->$select!='')
		return $data->$select;
		else
		return $data->attributes;
			
	}
	public function buildByModule($modType='admin')
	{
		$collection = $this->getControllersList($modType,true);
		
		foreach ($collection['controllers'] as $controller) {
			foreach($controller['actions'] as $action) {
				if(isset($action['actions'])) {

					$actionStr = ((isset($action['actions']))?implode(',',$action['actions']):'');
					$userStr 	= ((isset($action['users']))?implode(',',$action['users']):'');
					$permission = ((isset($action[0]))?$action[0]:'');
					$desc = ((isset($action['desc']))?$action['desc']:'');

					$model=UserRules::model()->find("module_id='".$collection['module']['id']."'
						AND role_id='".$this->getRoleByModule($collection['module'], 'id')."' 
						AND privileges_controller='".$controller['name']."'
						AND privileges_actions='".$actionStr."'
						AND permission='".$permission."'
					");
					//AND permission_type='".$userStr."'
					if (empty($model)) {
						$model = new UserRules();
					}
					$model->module_id 				= $collection['module']['id'];
					$model->role_id 				= $this->getRoleByModule($collection['module'], 'id');
					$model->privileges_controller	= $controller['name'];
					$model->privileges_actions 		= $actionStr;
					$model->permission_type 		= $userStr;
					$model->permission 				= $permission;
					$model->role_desc 				= $desc;
					$model->save(true);
				}
			}
		}
	}
}