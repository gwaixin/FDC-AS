<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	// added the debug toolkit
	// sessions support
	// authorization for login and logut redirect
	
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
		if((!$this->request->is('ajax') && $this->Session->read('Auth.Rights.Privileges') && 
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
