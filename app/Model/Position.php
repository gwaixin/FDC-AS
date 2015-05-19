<?php 

App::uses('AppModel', 'Model');
class Position extends AppModel{
 	public $validate = array(
 			'description' => array('rule' => 'notEmpty')
 	);
}


?>