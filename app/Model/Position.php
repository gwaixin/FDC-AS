<?php 

App::uses('AppModel', 'Model');
class Position extends AppModel{
 	public $validate = array(
 			'description' => array(
 				'Rule-1' => array(
					'rule' => 'notEmpty',
 					'message' => 'Position description must not be empty.'
				), 'Rule-2' => array(
					'rule'	=> 'alphaNumeric',
					'message' => 'Position cannot contain special characters.'
 				)
 			)
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