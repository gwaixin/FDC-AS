<?php

App::uses('AppModel', 'Model');
class Contractlog extends AppModel{
	
	public $useTable = 'contract_logs';
	public  $id;
	
	
	public $validate = array(
			'employees_id' => array(
					'rule' => 'notEmpty',
					'message' => 'Please select employee id'
			),
			'date_start' => array(
				'rule1' => array(	
					'rule' => 'notEmpty',
					'message' => 'Please input date start'
				),
				'rule2' => array(
						'rule' => 'date',
						'message' => 'Please provide valid date start'
				),
				'rule3' => array(
						'rule' => array('dateValidation'),
						'message' => 'Date start must greater than date end'
				)
			),
			'date_end' => array(
				'rule1' => array(	
					'rule' => 'notEmpty',
					'message' => 'Please input date end'
				),
				'rule2' => array(
						'rule' => 'date',
						'message' => 'Please provide valid date end'
				)
			),
			'salary' => array(
				'rule1' => array(	
					'rule' => 'notEmpty',
					'message' => 'Please input valid salary'
				),
				'rule2' => array(
						'rule' => 'numeric',
						'message' => 'salary must be numeric value'
				)
			),
			'deminise' => array(
					'rule' => 'notEmpty',
					'message' => 'Please input you deminise'
			),
			'positions_id' => array(
					'rule' => 'notEmpty',
					'message' => 'Please select position'
			),
			'position_levels_id' => array(
					'rule' => 'notEmpty',
					'message' => 'Please select position level'
			),

	);
	
	public function beforesave($options = array()){
		
		$arrData = $this->data[$this->alias];
		
		if(in_array('document',$arrData)){
			return true;
		}else{
			if($this->data[$this->alias]['document']['error'] == 4){
				$dateId = $this->getDetail($this->id);
				if($dateId){
					$this->data[$this->alias]['document'] = $dateId['Contractlog']['document'];
				}else{
					$this->data[$this->alias]['document'] = '';
				}
			}else{
				$this->uploadPdf();
			}
		}

	
		
	}
	
	public function uploadPdf(){
		
		$tmppath = $this->webroot.'document/';

		$src = $this->data[$this->alias]['document'];
		
		if($src['error'] == 4){
				
			$this->data[$this->alias]['document'] = '';
			return true;
		}
		
		$ext = explode('.',$src['name']);
		
		$FileName = tempnam($tmppath, 'doc').'.'.$ext[1];
		$FileName = str_replace('.tmp', '', $FileName);
		
		if(move_uploaded_file($src['tmp_name'], $FileName)){
			$this->data[$this->alias]['document'] = basename($FileName);
			return true;
		}
		
		return true;
	}
	
	public function dateValidation(){
				
		return date('Y-m-d',strtotime($this->data[$this->alias]['date_start'])) <= date('Y-m-d',strtotime($this->data[$this->alias]['date_end']));
	
	}
	
	public function getDetail($id = null){
		
		return $this->findById($id);
		
	}
	
}