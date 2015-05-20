<?php
App::uses('AppModel', 'Model');
class Positionlevel extends AppModel {
	public $useTable = 'position_levels';
	public $validate = array(
			'description' => array(
				'rule' => 'notEmpty'
			),
			'positions_id' => array(
				'rule' => 'numeric'
			)
	);
	
	public function updateLevelStat($id, $stat) { //Updating Position specific level
		$this->read(null, $id);
		$this->set('status', $stat);
		if ($this->save()) {
			return true;
		}
	}
	
	public function updateLevelStatBy($posId, $stat) {
		//$this->positions_id = $posId;
		$data = array('Positionlevel.status' => $stat);
		if ($this->updateAll($data, array('Positionlevel.positions_id' => $posId))) {
			return true;
		}
	} 
}