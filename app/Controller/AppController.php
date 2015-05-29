<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $components = array(
		'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'main12321312', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
						'authError' => 'You must be logged in to view this page.',
						'loginError' => 'Invalid Username or Password entered, please try again.',
						'authenticate' => array(
				    'Form' => array(
				     'fields' => array(
				      'username' => 'username', //Default is 'username' in the userModel
				      'password' => 'password'
				     )
				    )
					)
        ), 'Cookie'
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->loadModel('Role');
		$this->loadModel('Privilege');
		if((!$this->request->is('ajax') && 
				strtolower($this->params['controller']) !== 'employees' && 
				strtolower($this->params['controller']) !== 'main') || 
				strtolower($this->params['action']) === 'employee_lists') {
			$this->RestrictPage();
		}
	}

	public function RestrictPage() {
		if (strtolower($this->params['controller']) !== 'users' && 
				!(strtolower($this->Session->read('Auth.Rights.role')) === strtolower($this->params['controller']) &&
				strtolower($this->params['action']) === 'index')) {
			if (!$this->isAccessible() && $this->Session->read('Auth.Rights.role') !== 'admin') {
				$mainPage = $this->webroot.$this->Session->read('Auth.Rights.role');
				$this->redirect(array('controller' => $mainPage));
			}
		}
	}

	public function isAccessible() {
		$flag = false;
		foreach($this->Session->read('Auth.Rights.Privileges') as $right) {
			if (strtolower($right['Privilege']['controller']) === strtolower($this->params['controller']) &&
				strtolower($right['Privilege']['action']) === strtolower($this->params['action'])) {
				$flag = true;
				break;
			}
		}
		return $flag;
	}
	
}
