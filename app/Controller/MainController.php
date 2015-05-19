
<?php

App::uses('AppController', 'Controller');
App::uses('Component', 'Controller');

class MainController extends AppController {

	public function index() {
		$this->layout = 'main';
	}

}