<?php


class Contractlog extends AppModel{
	
	public $useTable = 'contract_logs';
	
	public $validate = array(
			'employee_id' => array(
					'rule' => 'notEmpty',
					'message' => 'Please select employee id'
			),
			'date_start' => array(
				'rule1' => array(	
					'rule' => 'notEmpty',
					'message' => 'Please input date start'
				),
				'rule2' => array(
						'rule' => 'date',
						'message' => 'Please provide valid date start'
				)
			),
			'date_end' => array(
				'rule1' => array(	
					'rule' => 'notEmpty',
					'message' => 'Please input date end'
				),
				'rule2' => array(
						'rule' => 'date',
						'message' => 'Please provide valid date end'
				)
			),
			'salary' => array(
				'rule1' => array(	
					'rule' => 'notEmpty',
					'message' => 'Please input valid salary'
				),
				'rule2' => array(
						'rule' => 'numeric',
						'message' => 'salary must be numeric value'
				)
			),
			'deminise' => array(
					'rule' => 'notEmpty',
					'message' => 'Please input you deminise'
			),
			'position' => array(
					'rule' => 'notEmpty',
					'message' => 'Please select position'
			),

	);
	
	public function beforesave($options = array()){
		
		$tmppath = $this->webroot.'document/';
		
		$src = $this->data[$this->alias]['document'];
		
		$ext = explode('.',$src['name']);

		$FileName = tempnam($tmppath, 'doc').'.'.$ext[1];
		$FileName = str_replace('.tmp', '', $FileName);
	
		if(move_uploaded_file($src['tmp_name'], $FileName)){
			$this->data[$this->alias]['document'] = basename($FileName);
			return true;
		}
		
		return false;
		
	}
	
	
}