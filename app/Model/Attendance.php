<?php
App::uses('AppModel', 'Model');

class Attendance extends AppModel {
	
	public $validate = array(
		'f_time_in' => array(
			'rule' => 'time',
			'message' => 'Must input valid time format.'
		), 'f_time_out' => array(
			'rule' => 'time',
			'message' => 'Must input valid time format.'
		), 'l_time_in' => array(
			'rule' => 'time',
			'message' => 'Must input valid time format.'
		), 'l_time_out' => array(
			'rule' => 'time',
			'message' => 'Must input valid time format.'
		)
	);
	
	private function timeRule() {
		return ;
	}
	
}
?>