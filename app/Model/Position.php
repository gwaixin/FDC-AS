<?php 

App::uses('AppModel', 'Model');
class Position extends AppModel{
 	public $validate = array(
 			'description' => array('rule' => 'notEmpty')
 	);
 	
 	public function updatePos($posId, $stat) {
 		$this->read(null, $posId);
 		$this->set('status', $stat);
 		//$data = array('Position' => array('status' => $stat));
 		if ($this->save()) {
 			return true;
 		}
 	}
}


?>