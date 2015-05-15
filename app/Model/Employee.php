

<?php
App::uses('AppModel', 'Model');

class Employee extends AppModel {

	public $validate = array(
        'employee_id' => array(
            '/^[0-9-]{6,}+$/','isUnique'
         ),
     	'name' => array(
            'rule' => 'notEmpty'
        ),
	  'profile_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Employee not found'
         ),
      'tin' => array(
            'rule' => '/^[0-9]{4,}+$/',
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
            'rule' => '/^[0-9-]+$/',
            'message' => 'Invalid Pagibig'
        ),
       'philhealth' => array(
            'rule' => '/^[0-9-]+$/',
            'message' => 'Invalid Phil Health'
        ),
       'medical' => array(
            'rule' => 'notEmpty',
            'message' => 'Medical is required'
        ),
       'sss' => array(
            'rule'=> '/^[0-9-]+$/',
            'message' => 'Invalid SSS No.'
        ),
       'insurance_id' => array(
            'rule'=> '/^[0-9-]+$/',
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
            'rule' => array('minLength',5),
            'message' => 'Invalid Time'
         ),
      'f_time_out' => array(
            'rule' => array('minLength',5),
            'message' => 'Invalid Time'
         ),
      'l_time_in' => array(
            'rule' => array('minLength',5),
            'message' => 'Invalid Time'
         ),
      'l_time_out' => array(
            'rule' => array('minLength',5),
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