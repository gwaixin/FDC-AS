<?php
App::uses('AppModel', 'Model');

class Companysystem extends AppModel{

	public $useTable = 'company_systems';
	
	public $validate = array(
			'name' => array(
				'rule' => 'notEmpty',
				'message' => 'Please input valid name'	
			
			),
			'address' => array(
					'rule' => 'notEmpty',
					'message' => 'Please input valid address'
			),
			'date_start' => array(
					'rule' => 'date',
					'message' => 'Please provide valid date start'
			),
			'owner' => array(
					'rule' => 'notEmpty',
					'message' => 'Please input valid address'
			)
	);

}
