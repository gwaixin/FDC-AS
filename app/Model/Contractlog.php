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
}