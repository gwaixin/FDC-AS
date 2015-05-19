

<?php
App::uses('AppModel', 'Model');

class Employee extends AppModel {

	public $validate = array(
        'employee_id' => array(
            'Rule-1' => array(
                 'rule' => '/([0-9]{2,})-([0-9]{2,})/'
            ),
            'Rule-2' => array(
                'rule' => 'isUnique'
            )
        ),
        'username' => array(
                'rule' => 'notEmpty',
                'message' => 'Username must not empty'
            ),
        'password' => array(
                'rule' => 'notEmpty',
                'message' => 'Password must not empty'
            ),
     	'name' => array(
            'rule' => 'notEmpty'
        ),
        'profile_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Employee not found'
         ),
        'tin' => array(
            'rule' => '/([0-9]{4,})/',
            'message' => 'Invalid Tin No'
         ),
        'salary' => array(
            'rule' => 'notEmpty',
            'message' => 'Salary is required'
         ),
        'drug_test' => array(
            'rule' => 'validDrugTest',
            'message' => 'Drug Test is required'
         ),
        'pagibig' => array(
            'rule' => '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid Pagibig'
        ),
        'philhealth' => array(
            'rule' => '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid Phil Health'
        ),
        'medical' => array(
            'rule' => 'notEmpty',
            'message' => 'Medical is required'
        ),
        'sss' => array(
            'rule'=> '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid SSS No.'
        ),
        'insurance_id' => array(
            'rule'=> '/([0-9]{2,})-([0-9]{2,})/',
            'message' => 'Invalid Insurance ID'
        ),
        'position_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Invalid position'
         ),
        'position_level_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Invalid position level'
         ),
        'f_time_in' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time'
         ),
        'f_time_out' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time'
         ),
        'l_time_in' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time'
         ),
        'l_time_out' => array(
            'rule' => '/([0-9]{1}):([0-9]{2}) AM|PM/',
            'message' => 'Invalid Time'
         ),
        'status' => array(
            'rule' => 'numeric',
            'message' => 'Invalid Status'
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