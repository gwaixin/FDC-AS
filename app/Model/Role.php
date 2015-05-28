<?php


class Role extends AppModel{
	
	public $validate = array(
			'description' => array(
				'rule' => 'notEmpty',
				'message' => 'Please input description'	
			)
	);
	
	
}