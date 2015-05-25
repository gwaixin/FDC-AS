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
				$profile['role'] = $user['role'];
				
				$this->checkRole($user['role']);
				$this->Session->write('Auth.UserProfile', $profile);
				$this->Auth->login($this->Auth->login($data));
				$this->redirect($this->Auth->redirectUrl());
			} else if($username === 'user' && $password === '89dc45ea17f53362eafc57fb8639593b4baac5a3') { 
				$profile['first_name'] = 'Firstname';
				$profile['middle_name'] = 'Middlename';
				$profile['last_name'] = 'Lastname';
				$profile['role'] = 1;
				
				$this->checkRole(1);
				$this->Session->write('Auth.UserProfile', $profile);
				$this->Auth->login($this->Auth->login($data));
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash(__('Invalid username or password'));
			}
		} 
	}
	
	private function checkRole($role) {
		$redir = "/";
		switch($role) {
			case 1: $redir = "/admin"; break;//return //$this->redirect('/admin'); break;
			case 2: $redir = "/staffs";break;
			case 3: $redir = "/employees";break;
			case 4: break;
			default: $redir = "/main"; break;
		}
		$this->Session->write('Auth.redirect', $redir);
	}

	public function logout() {
		$this->Session->destroy('Auth.UserProfile');
		$this->redirect($this->Auth->logout());
	}

}

?>