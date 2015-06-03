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
		$this->RestrictPage();
	}

	public function RestrictPage() {
		$url = split('/',$this->here);
		$url = $url[1];
		if ($this->Session->read('Auth.UserProfile')) {
			if($url !== $this->Session->read('Auth.Rights.role') && $url !== 'users' &&
				 $url !== 'main' && !$this->request->is('ajax')) {
				$this->redirect('/'.$this->Session->read('Auth.Rights.role'));
			}
		}
	}
	
}
