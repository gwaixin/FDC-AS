<?php

App::uses('AppController', 'Controller');

class PositionlevelsController extends AppController {
	public function create() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			//$this->loadModel('Positionlevel');
			
			$result = array();
			
			if ($this->Positionlevel->save($data)) {
				$result['result'] = 'success';
				$result['message'] = 'New position level has been created.';
			} else {
				$result['result'] 	= 'fail';
				$result['message']	= $this->Positionlevel->validationErrors['description'];
			}
			echo json_encode($result);
		}
	}
	
	public function search() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data['Positionlevel'];
					$join = array( 
				array(
				'table' => 'Positions',
						'conditions' => array('Positions.id = Positionlevel.positions_id')
				)
			);
			$positionLvl = $this->Positionlevel->find('all',
					array(
							'fields' 		=> array('Positionlevel.id', 'Positionlevel.description', 'Positionlevel.positions_id', 'Positions.description'),
							'joins'			=> $join,
							'conditions' 	=> array(
									//'Positionlevel.positions_id =' => $data['positions_id'],
									'Positionlevel.description like' => "%{$data['description']}%",
									'Positionlevel.status = 2'
							)
					)
			);
			
			$result = array();
			if ($positionLvl) {
				$option = '';
				$count = 0;
				$pLevel = array();
				foreach($positionLvl as $p) {
					$option .= "<option value='".$p['Positionlevel']['id']."'>{$p['Positionlevel']['description']} : {$p['Positions']['description']}</option>";
					$count++;
					$pLevel[$p['Positionlevel']['id']] = array($p['Positionlevel']['description'], $p['Positionlevel']['positions_id']);
				} 
				$result = array('success', $option, $count, $pLevel);
			} else {
				$result = array('fail', 'No Position Found');
			}
			
			echo json_encode($result);
		}
	}
	
	public function update() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->Positionlevel->id = $data['Positionlevel']['id'];
			$result = array();
			if ($this->Positionlevel->save($data)) {
				$result['result'] = 'success';
				$result['message'] = 'Position has been updated.';
			} else {
				$result['result'] 	= 'fail';
				$result['message']	= $this->Positionlevel->validationErrors['description'];
			}
			echo json_encode($result);
		} 
	}
	
	public function delete() {
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			
			$posLvlId = $data['Positionlevel']['id'];
			
			$this->loadModel('Employee');
			
			$result = array();
			if ($this->Positionlevel->updateLevelStat($posLvlId, 0)) {
				$result['result'] = 'success';
				$result['message'] = 'Position has been removed.';
			} else {
				$result['result'] = 'fail';
				$result['message'] = 'Position has fail to remove.';
			}
			echo json_encode($result);
		}
	}
}
?>