<?php

Yii::import('application.models.User._base.BaseUserRulesMenu');
function getRecursiveTree()
{

}
class UserRulesMenu extends BaseUserRulesMenu
{
	public $menuList = array();
	public $current_parent_id = 0;



	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function getAllowedMenu($module, $parent_id)
	{
		switch (strtolower($module)) {
			case 'admin':
				$role_ids = AdminModule::getUserRoles();
				break;
			case 'customer':
				$role_ids = CustomerModule::getUserRoles();
				break;
			case 'front':
				$role = UserRole::model()->find('role_type = \'front\'');
				if($role) {
					if($role->parent_id!=0) $role_ids = implode(',', array($role->id,$role->parent_id));
					else $role_ids =  $role->id;
				}
				else $role_ids = -1;
				break;
		}

		if(trim($role_ids)=='') {
			$role_ids = "''";
		}

		$criteria = new CDbCriteria();
		$criteria->condition = " id IN (".$role_ids.") AND is_publish=1 ";

		$modelRole = UserRole::model()->findAll($criteria);
		$role_idAr = array();
		foreach ($modelRole as $role) {
			$role_idAr[] = $role->id;
		}

		$role_ids = implode(',',$role_idAr);
		if(trim($role_ids)=='') {
			$role_ids = "''";
		}

		$criteria = new CDbCriteria();
		$criteria->condition = " rule.role_id IN (".$role_ids.") AND module.module_code='".$module."'
			AND t.parent_id = '".$parent_id."'
			AND t.is_active=1 ";
		$criteria->order = 't.position ASC';
		$data =  UserRulesMenu::model()->with(array('module','rule'))->findAll($criteria);
		return $data;
		//$model = UserRole::model()->findAll();
	}
	public function createTree($module='admin', $index=0, $level=0, $menuList=array())
	{
		$data = $this->getAllowedMenu($module, $this->current_parent_id);
		if(count($data)>0) {
			foreach ($data as $row) {
				$this->menuList[] =  array('label'=>$row->label, 'url'=> array($row->url), 'level'=>$level, 'id'=>$row->id, 'parent_id'=>$row->parent_id);
				$this->current_parent_id = $row->id;
				$index++;
				$this->createTree($module, $index, $level+1);
			}
		}
	}

	public function getMenuItems($module='admin')
	{
		$this->createTree($module);
		$childs = array();
		$tree = array();

		$items = $this->menuList;

		$childs = array();
		foreach($items as &$item) 		$childs[$item['parent_id']][] = &$item;
		unset($item);

		foreach($items as &$item) 		if (isset($childs[$item['id']]))  		$item['items'] = $childs[$item['id']];
		unset($item);

		if(isset($childs[0])) {
			$tree = $childs[0];
		}
                /////////////////////////
		$temparr = array();
                foreach($tree as $key=>$item){
                    $temparr[$key]  =   $item;
                    if($item['label'] == "Packages" || $item['label'] == "Subscriptions"){
                        $ssType = ($item['label'] == "Packages") ? "Package" : "Subscription";
                        $temparr[$key]['url'][0] = str_replace("twinklestardance","",Yii::app()->createUrl('admin/packageSubscription/index',array('type'=>$ssType)));
                    }
                    if($item['label'] == "Instructors" || $item['label'] == "Dancers"){
                        $snUserType = ($item['label'] == "Instructors") ? Yii::app()->params['user_type']['instructor'] : Yii::app()->params['user_type']['dancer'];
                        $temparr[$key]['url'][0] = str_replace("twinklestardance","",Yii::app()->createUrl('admin/users/listInstructorsDancers',array('user_type'=>$snUserType)));
                    }
                }
                /////////////////////////
                //p($temparr);
		return array('items'=> $temparr);
	}
}