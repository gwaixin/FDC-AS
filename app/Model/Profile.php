<?php

class Profile extends AppModel{
	
	public $validate = array(
			'first_name' => array(
					'rule' => 'notEmpty',
					'message' => 'Please provide a valid First name.'
			),
			'last_name' => array(
					'rule' => 'notEmpty',
					'message' => 'Please provide a valid Last name.'
			),
			'email' => array(
					'rule' => array('email', true),
					'message' => 'Please provide a valid email address.'
			),
			'facebook' => array(
					'rule' => array('email', true),
					'message' => 'Please provide a valid email address.'
			),
			'contact' => array(
					'min_length' => array(
							'rule' => array('minLength', '12'),
							'message' => 'Contact number must have a mimimum of 12 characters'
					)
			),
			'contact_person_no' => array(
					'min_length' => array(
							'rule' => array('minLength', '12'),
							'message' => 'Contact person number must have a mimimum of 12 characters'
					)
			),
				
	);
	
	
}