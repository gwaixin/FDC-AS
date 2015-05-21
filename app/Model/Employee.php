

<?php
App::uses('AppModel', 'Model');

class Employee extends AppModel {

	public $validate = array(
        'employee_id' => array(
            'Rule-1' => array(
                'rule' => '/[0-9a-zA-Z-]{5,}/'
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
            'rule' => '/[0-9]{4,}/',
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
            'rule' => 'ValidCode',
            'message' => 'Invalid Pagibig No'
        ),
        'philhealth' => array(
            'rule' => 'ValidCode',
            'message' => 'Invalid Philhealth No'
        ),
        'medical' => array(
            'rule' => 'notEmpty',
            'message' => 'Medical result is required'
        ),
        'sss' => array(
            'rule'=> 'ValidCode',
            'message' => 'Invalid SSS No'
        ),
        'insurance_id' => array(
            'rule'=> 'ValidCode',
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
        'status' => array(
            'rule' => 'numeric'
        )
    );
    
    public function ValidCode($check) {
       foreach($check as $key => $value) {
        $value = $check[$key];       
       }
        return preg_match('/[0-9]{5,}/', $value) || preg_match('/[0-9-]{6,}/', $value);
    }
    public function validDrugTest($check) {
        $value = $check['drug_test'];
        return strtolower($value) === "passed" || strtolower($value) === "failed";
    }
    public function validStatus($check) {
        $value = $check['status'];
        return strtolower($value) === "active" || strtolower($value) === "inactive";
    }
}