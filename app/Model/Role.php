<?php


class Role extends AppModel{
	
	public $validate = array(
			'description' => array(
				'rule1' => array(	
						'rule' => 'notEmpty',
						'message' => 'Please input description'	
					)
				),
				'rule2' => array(
						'rule' => '[a-zA-Z0-9]',
						'message' => 'Please input description'
				)
	);
	
	
}