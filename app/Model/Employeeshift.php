<?php
App::uses('AppModel', 'Model');

class Employeeshift extends AppModel {
	public $useTable = 'employee_shifts';
	
	public $validate = array(
			'ftime_in' => array(
				'rule' => 'time',//array('validateTime'),
				'message' => 'Invalid Time format'
			), 'ftime_out' => array(
				'rule' => 'time',//array('validateTime'),
				'message' => 'Invalid Time format'
			), 'ltime_in' => array(
				'rule' => 'time',//array('validateTime'),
				'message' => 'Invalid Time format'
			), 'ltime_out' => array(
				'rule' => 'time',//array('validateTime'),
				'message' => 'Invalid Time format'
			), 'description' => array(
				'rule' => 'notEmpty',
				'message'	=> 'Description must not be empty.'
			)
			
	);
	
	/*private function verifyTimeFormat($value) {
		if (!empty($value)) {
			$pattern1 = '/^(0?\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/';
			$pattern2 = '/^(0?\d|1[0-2]):[0-5]\d\s(am|pm)$/i';
			return preg_match($pattern1, $value) || preg_match($pattern2, $value);
		} else {
			return false;
		}
	}*/

	public function updateStat($id, $stat) { //Updating Specific Shift
		$this->read(null, $id);
		$this->set('status', $stat);
		if ($this->save()) {
			return true;
		} else {
			return 'false';
		}
	}


}
?>