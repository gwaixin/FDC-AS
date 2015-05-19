<?php
App::uses('AppModel', 'Model');
class Positionlevel extends AppModel {
	public $useTable = 'position_levels';
	public $validate = array(
			'description' => array(
				'rule' => 'notEmpty'
			),
			'positions_id' => array(
				'rule' => 'numeric'
			)
	);
}