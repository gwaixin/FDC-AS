

<?php
App::uses('AppModel', 'Model');

class Employee extends AppModel {

	public $validate = array(
	 	'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Name is required'
        ),
	  'id' => array(
            'rule' => 'notEmpty',
            'message' => 'Employee not found'
         ),
	  'position' => array(
            'rule' => 'notEmpty',
            'message' => 'Invalid position'
         ),
	  'position_level' => array(
            'rule' => 'notEmpty',
            'message' => 'Invalid position level'
         )
    );
}