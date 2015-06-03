
<?php

App::uses('AppController', 'Controller');
App::uses('Component', 'Controller');

class MainController extends AppController {

	public function index() {
		if($this->Session->read('Auth')) {
			$this->redirect(array(
												'controller' => $this->Session->read('Auth.Rights.role')
												)
											);
		}
	}

}