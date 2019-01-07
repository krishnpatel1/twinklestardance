<?php
Yii::import('zii.widgets.CMenu');
class AdminMenu extends CMenu
{
	public function init()
	{
		parent::init();
		$baseUrl = Yii::app()->baseUrl;
		//p($baseUrl);
		$cs = Yii::app()->getClientScript();
		if(!$cs->isScriptFileRegistered('jquery')){
			Yii::app()->clientScript->registerCoreScript('jquery');
		}

		//$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($baseUrl.'/js/jqueryslidemenu.js');
		$cs->registerCssFile($baseUrl.'/css/jqueryslidemenu.css');
		
	}
}