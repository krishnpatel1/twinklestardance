<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminCoreController extends GxController {

    public $layout = 'admin';
    public $accessRule = '';
    public $userType = 'admin';
    public $defaultAction = 'admin';

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        //set usertype
        $admin = Yii::app()->admin->getState('admin');
        if (isset($admin['user_type']) && $admin['user_type'] != '') {
            $this->userType = $admin['user_type'];
        }
        $this->accessRule = new UserAccessControll();
    }

    /**
     * The filter method for 'accessControl' filter.
     * This filter is a wrapper of {@link CAccessControlFilter}.
     * To use this filter, you must override {@link accessRules} method.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     */
    public function filterAccessControl($filterChain) {
        $filter = new JVAccessControlFilter;
        $filter->setRules($this->accessRules());
        $filter->filter($filterChain);
    }

    public function getControllerName() {
        return get_class($this);
    }

    public function getModuleId() {
        return $this->accessRule->getModule($this->getModule()->id, 'id');
    }

    public function defaultAccessRules() {
        return array(
            array('allow',
                'actions' => array('*'),
                'users' => array('admin'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function getRole() {
        return AdminModule::getUserRoles();
    }

    public function accessRules($userType = 'admin', $isDefault = false) {
        $user_roles = $this->getRole();

        $omAuthActions = UserRules::model()->findAll("privileges_controller = '" . $this->getControllerName() . "'
		AND module_id = '" . $this->getModuleId() . "' AND role_id IN (" . $user_roles . ")");

        $amAccessRules = array();
        if ($omAuthActions) {
            foreach ($omAuthActions as $model) {
                $amAccessRules[] = array(
                    $model->permission,
                    'actions' => explode(',', $model->privileges_actions),
                    'users' => explode(',', $model->permission_type),
                    'desc' => $model->role_desc,
                );
                // FOR ACCESS DEFAULT ACTIONS TO ALL USERS //
                $amAccessRules[] = array('allow',
                    'actions' => array('login', 'logout', 'forgot', 'error'),
                    'users' => array('*'),
                    'desc' => 'Login and Logout'
                );
                // FOR DENY OTHER ACTIONS FOR UNKNOWN USERS //
                $amAccessRules[] = array('deny',
                    'users' => array('*'),
                );
            }
        } else {
            if ($this->userType == 'admin')
                $amAccessRules = $this->defaultAccessRules();
            else {
                $amAccessRules[] = array('deny',
                    'users' => array('*'),
                );
            }
        }

        return $amAccessRules;
    }

}