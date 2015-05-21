

<?php
App::uses('AppModel', 'Model');

class Employee extends AppModel {

	public $validate = array(
        'employee_id' => array(
            'Rule-1' => array(
                'rule' => '/([a-zA-z]{2,})-([0-9]{5,})/'
            ),
            'Rule-2' => array(
                'rule' => 'isUnique'
            )
        ),
        'company_system_id' => array(
            'rule' => 'notEmpty'
         ),
        'username' => array(
                'Rule-1' => array(
                    'rule' => 'notEmpty',
                    'message' => 'Username must not empty'
                ),
                'Rule-2' => array(
                    'rule' => 'isUnique',
                    'message' => 'Username is already taken',
                )
        ),
        'password' => array(
                'rule' => 'notEmpty',
                'message' => 'Password must empty'
            ),
     	'name' => array(
            'rule' => 'notEmpty'
        ),
        'profile_id' => array(
            'rule' => 'notEmpty'
         ),
        'tin' => array(
            'rule' => '/([0-9]{4,})/',
            'message' => 'Invalid Tin No'
         ),
        'salary' => array(
            'rule' => 'notEmpty'
         ),
        'drug_test' => array(
            'rule' => 'validDrugTest',
            'message' => 'Invalid Drug Test'
         ),
        'pagibig' => array(
            'rule' => '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid Pagibig No'
        ),
        'philhealth' => array(
            'rule' => '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid Philhealth No'
        ),
        'medical' => array(
            'rule' => 'notEmpty',
            'message' => 'Medical result is required'
        ),
        'sss' => array(
            'rule'=> '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid SSS No'
        ),
        'insurance_id' => array(
            'rule'=> '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid Insurance ID'
        ),
        'position_id' => array(
            'rule' => 'notEmpty'
         ),
        'position_level_id' => array(
            'rule' => 'notEmpty'
         ),
        'f_time_in' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time Format'
         ),
        'f_time_out' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time Format'
         ),
        'l_time_in' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time Format'
         ),
        'l_time_out' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time Format'
         ),
        'status' => array(
            'rule' => 'numeric'
        )
    );

    public function validDrugTest($check) {
        $value = $check['drug_test'];
        return strtolower($value) === "passed" || strtolower($value) === "failed";
    }
    public function validStatus($check) {
        $value = $check['status'];
        return strtolower($value) === "active" || strtolower($value) === "inactive";
    }
}