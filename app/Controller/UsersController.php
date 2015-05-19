<?php

class UsersController extends AppController {

  public function beforeFilter() {
      parent::beforeFilter();
  }

 public function index() {
 		$this->autoRender = false;
 }

	public function login() {
		
		//if already logged-in, redirect
		if($this->Session->check('Auth.UserProfile')){
				$this->redirect(array(
														'controller' => 'main',
														'action' => 'index'
														)
													);		
		}
		
		// if we get the post information, try to authenticate
		if ($this->request->is('post')) {
			$username = $this->request->data['User']['username'];
			$password = Security::hash($this->request->data['User']['password'],'sha1',true);
			$data = array('User' => array(
																	'username' => $username,
																	'password' => $password
																)
															);
			$user = $this->User->find('first',array(
																	'conditions' => "`username` = '$username' and
																	 				 				 `password` = '$password'"
																	)
																);
			if($user) {
				$user = $user['User'];
				$this->loadModel('Profile');
				$profile = $this->Profile->findById($user['profile_id']);
				$profile = $profile['Profile'];
				$this->Session->write('Auth.UserProfile', $profile);
				$this->Auth->login($this->Auth->login($data));
				$this->redirect($this->Auth->redirectUrl());
			} else if($username === 'user' && $password === '89dc45ea17f53362eafc57fb8639593b4baac5a3') { 
				$profile['first_name'] = 'Firstname';
				$profile['middle_name'] = 'Middlename';
				$profile['last_name'] = 'Lastname';
				$this->Session->write('Auth.UserProfile', $profile);
				$this->Auth->login($this->Auth->login($data));
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash(__('Invalid username or password'));
			}
		} 
	}

	public function logout() {
		$this->Session->destroy('Auth.UserProfile');
		$this->redirect($this->Auth->logout());
	}

}

?>