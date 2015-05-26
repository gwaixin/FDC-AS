<?php

App::uses('AppModel', 'Model');
class Privilege extends AppModel {
	
	public $validate = array(
			'roles_id' => array(
					'rule' => 'notEmpty',
					'message' => 'Please select role'
			),
			'controller' => array(
					'rule' => 'notEmpty',
					'message' => 'Please input validate controller,must not be empty'
			),
			'action' => array(
					'rule' => 'notEmpty',
					'message' => 'Please input validate action,must not be empty'
			),
			'status' => array(
					'rule' => 'notEmpty',
					'message' => 'Please select status'
			)
	);
	
}