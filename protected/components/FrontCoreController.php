<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontCoreController extends GxController
{
	public $layout='main';

	public function init()
	{
		parent::init();
	}
	
}