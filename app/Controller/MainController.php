
<?php

App::uses('AppController', 'Controller');
App::uses('Component', 'Controller');

class MainController extends AppController {

	public function redirectToPage($action) {
		$this->autoRender = false;
		$this->redirect(array(
													'controller' => 'main',
													'action' => $action										
												)
											);
	}

	public function validUser() {
		$user = false;
		$this->loadModel('Profile');
		$profile = $this->Profile->findById($this->Session->read('fdc_ID'));
		if ($profile) {
			$user = $profile['Profile'];
		}
		return $user;
	}

	public function index() {
			$this->layout = 'main';
			$profile = $this->validUser();
			if ($profile) {
				$name = $profile['first_name']." ".$profile['middle_name']." ".$profile['last_name'];
				$data = array(
										'title_for_layout' => 'Home',
										'name' => $name
									);
				$this->Set($data);
			} else {
				$this->redirectToPage('login');
			}
	}

	public function login() {
		if (!$this->validUser()) {
			$username = '';
			$password = '';
			$data = array(
									'username' => $username,
									'password' => $password
								);
			if ($this->request->is('post')) {
				if ($this->request->is('post')) {
					$this->loadModel('Employee');
					$username = $this->request->data['username'];
					$password = $this->request->data['password'];
					$this->Employee->set(array(
																		'username' => $username,
																		'password' => $password
																	)
																);
					if ($this->Employee->validates()) {
						$password = hash('sha1',$this->request->data['password']);
						$loggedin = $user = $this->Employee->find('first',array(
						 																	'conditions' => array("username = '$username' and password = '$password'")
						 																)
						 														);
						if ($loggedin) {
							$this->Session->write('fdc_ID',$loggedin['Employee']['profile_id']);
							$this->redirectToPage('index');
						} else {
							$this->Session->setFlash(_('Invalid Employee ID or Password'));
						}
					} else {
						$this->Session->setFlash(_('Username and Password are required'));
					}
				}
			}
			if ($this->request->data) {
				$this->set($this->request->data);
			} else {
				$this->set($data);
			}
		} else {
				$this->redirectToPage('index');
		}
	}

	public function logout() {
		$this->Session->destroy('fdc_ID');
		$this->redirectToPage('login');
	}

}