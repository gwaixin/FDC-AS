<?php
App::uses('AppController', 'Controller');
class PositionsController extends AppController {
	
	public function create() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->loadModel('Position');
			if ($this->Position->save($data)) {
				echo 'success';
			} else {
				echo json_encode($this->Position->validationErrors['description']);
			}
		}
	}
}