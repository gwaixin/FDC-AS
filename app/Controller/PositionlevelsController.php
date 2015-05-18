<?php

App::uses('AppController', 'Controller');

class PositionlevelsController extends AppController {
	public function create() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->loadModel('Positionlevel');
			if ($this->Positionlevel->save($data)) {
				echo 'success';
			} else {
				echo json_encode($this->Positionlevel->validationErrors['description']);
			}
		}
	}
}
?>