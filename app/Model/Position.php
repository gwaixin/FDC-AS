<?php 

App::uses('AppModel', 'Model');
class Position extends AppModel{
 	public $validate = array(
 			'description' => array(
 				'Rule-1' => array(
					'rule' => 'notEmpty',
 					'message' => 'Position description must not be empty.'
				), 'Rule-2' => array(
					'rule'	=> '/^[a-z\d\-_\s]+$/i',
					'message' => 'Position cannot contain special characters.'
 				), 'Rule-3'	=> array(
 					'rule'	=> array('isDescriptionExist'),
 					'message' => 'Description already exist.'
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

 	public function isDescriptionExist() {
 		$conditions = array(
		    'description' => $this->data[$this->alias]['description'],
		    'id <>' => $this->data[$this->alias]['id']
		);
		return !$this->hasAny($conditions);   
 	}
}


?>