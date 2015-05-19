<?php
App::uses('AppController', 'Controller');
class PositionsController extends AppController {
	
	public function create() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->loadModel('Position');
			$result = array();
			if ($this->Position->save($data)) {
				$result['result'] = 'success';
				$result['message'] = 'New position has been created.';
			} else {
				$result['result'] 	= 'fail';
				$result['message']	= $this->Position->validationErrors['description'];
			}
			echo json_encode($result);
		}
	}
	
	public function update() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->Position->id = $data['Position']['id'];
			$result = array();
			if ($this->Position->save($data)) {
				$result['result'] = 'success';
				$result['message'] = 'Position has been updated.';
			} else {
				$result['result'] 	= 'fail';
				$result['message']	= $this->Position->validationErrors['description'];
			}
			echo json_encode($result);
		}
	}
	
	public function delete() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->Position->id = $data['Position']['id'];
			
			$this->loadModel('Positionlevel');
			$this->Positionlevel->deleteAll(array(
					'Positionlevel.positions_id =' => $data['Position']['id']
			));
			
			$result = array();
			if ($this->Position->delete()) {
				$result['result'] = 'success';
				$result['message'] = 'Position has been removed.';
				
				
			} else {
				$result['result'] = 'fail';
				$result['message'] = 'Position has fail to remove.';
			}
			echo json_encode($result);
		}
	}
	
	public function searchPosition() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$position = $this->Position->find('all',
					array(
							'conditions' => array('Position.description like' => "%{$data['position']}%"),
							'fields' => array('id', 'description')
					)
			);
			$result = array();
			if ($position) {
				$option = '';
				$count = 0;
				foreach($position as $p) {
					$option .= "<option value='".$p['Position']['id']."'> {$p['Position']['description']} </option>";
					$count++;
				} 
				$result = array('success', $option, $count);
			} else {
				$result = array('fail', 'No Position Found');
			}
			
			echo json_encode($result);
		}
	}
}