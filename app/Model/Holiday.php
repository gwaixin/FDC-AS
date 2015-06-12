<?php
class Holiday extends AppModel {
	public $validate = array(
		'date'	=> array(
			'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Date must not be empty',
				'allowEmpty' => false
            ),
            'checkDate' => array(
            	'rule' => array('checkDate'),
            	'message' => 'Invalid format for date'
            )
		),
		'description'	=> array(
			'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Description of the holiday must not be empty',
				'allowEmpty' => false
            )
		),
		'rate'	=>array(
			'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Rate must not be empty',
				'allowEmpty' => false
            ),
            'checkRate' => array(
            	'rule' => array('checkRate'),
            	'message' => 'Invalid format of rate'
            )
		),
		'recurring' => array(
			'valid' => array(
                'rule' => array('inList', array('0', '1','2')),
                'message' => 'Please enter a valid occurence of the holiday',
                'allowEmpty' => false
            )

		)


	);

	public function checkRate($check){
		$value = array_values($check);
        $value = $value[0];
		if(preg_match('/^\d{0,1}\.\d{0,2}$/', $value) || preg_match('/^[0-9]*$/', $value)) return true;
	}

	public function checkDate($check) {
		$value = array_values($check);
        $value = $value[0];
		return preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $value);
	}
}