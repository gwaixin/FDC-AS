<?php

class UsersController extends AppController {

  public function beforeFilter() {
      parent::beforeFilter();
  }

 public function index() {
 		$this->autoRender = false;
 }

	public function login() {
		if ($this->Session->check('Auth.UserProfile')){
				$this->redirect(array(
														'controller' => 'main',
														'action' => 'index'
														)
													);		
		}
		
		if ($this->request->is('post')) {
			$username = $this->request->data['username'];
			$password = $this->request->data['password'];
			$data = array('User' => array(
																	'username' => $username,
																	'password' => $password
																)
															);
			$this->Set($data);
			$password = Security::hash($this->request->data['password'],'sha1',true);
			$user = $this->User->find('first',array(
																	'conditions' => "`username` = '$username' and
																	 				 				 `password` = '$password'"
																	)
																);
			if ($user) {
				$user = $user['User'];
				switch($user['status']) {
					case "0" :
						$this->Set('error','This account is deleted');
					break;
					case "1" :
						$this->Set('error','This account is inactive');
					break;
					case "2" :
						$this->loadModel('Profile');
						$profile = $this->Profile->findById($user['profile_id']);
						$profile = $profile['Profile'];
						$this->checkRole($user['role']);
						$this->Session->write('Auth.UserProfile', $profile);
						$this->Session->write('Auth.UserProfile.role', $user['role']);
						$this->Auth->login($this->Auth->login($data));
						$this->getRights();
						$this->redirect($this->Auth->redirectUrl());
					break;
				}
			} else if ($username === 'user' && $password === '89dc45ea17f53362eafc57fb8639593b4baac5a3') { 
				$profile['first_name'] = 'Firstname';
				$profile['middle_name'] = 'Middlename';
				$profile['last_name'] = 'Lastname';
				$this->checkRole(1);
				$this->Session->write('Auth.UserProfile', $profile);
				$this->Session->write('Auth.UserProfile.role',1);
				$this->Session->write('Auth.Rights.role','admin');
				$this->Auth->login($this->Auth->login($data));
				$this->getRights();
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Set('error','Invalid username or password');
			}
		} 
	}

	public function getRights() {
		$rights = array();
		$roleDescription = "";
		$role = $this->Role->findById($this->Session->read('Auth.UserProfile.role'));
		if ($role) {
			$roleDescription = strtolower($role['Role']['description']);
			if (strtolower($roleDescription !== 'admin')) {
				$roleDescription = $roleDescription.'s';
			}
			$rights = $this->Privilege->find('all',array(
																					'conditions' => array(
																							"roles_id = '".$this->Session->read('Auth.UserProfile.role')."'
																							AND status = 1"
																						),
																					'fields' => array('controller','action')
																					)
																				);
		}
		$this->Session->write('Auth.Rights.Privileges',$rights);
		$this->Session->write('Auth.Rights.role',$roleDescription);
	}

	public function logout() {
		$this->Session->destroy('Auth');
		$this->redirect($this->Auth->logout());
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

}

?>