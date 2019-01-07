<?php
Yii::import('zii.widgets.CMenu');
class FrontMenu extends CMenu
{
	public function init()
	{
		parent::init();
		$baseUrl = Yii::app()->baseUrl;
		//p($baseUrl);
		$cs = Yii::app()->getClientScript();

		$this->htmlOptions['id'] = 'menu';
		//$cs->registerScriptFile($baseUrl.'/js/jquery.js');
		$cs->registerCoreScript('jquery');
		//$cs->registerScriptFile($baseUrl.'/js/jqueryslidemenu.js');
		$cs->registerCssFile($baseUrl.'/css/dropdown.css');

	}
}