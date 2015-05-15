<?php
App::uses('AppModel', 'Model');

class Attendance extends AppModel {
	
	public $validate = array(
		'f_time_in' => array(
			'rule' 		=> '(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})',
			'message' 	=> 'Must input valid time format.'
		), 'f_time_out' => array(
			'rule' 		=> '(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})',
			'message' 	=> 'Must input valid time format.'
		), 'l_time_in' => array(
			'rule' 		=> '(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})',
			'message' 	=> 'Must input valid time format.'
		), 'l_time_out' => array(
			'rule' 		=> '(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})',
			'message' 	=> 'Must input valid time format.'
		)
	);
	
	private function validateTime() {
		return ;
	}
	
}
?>