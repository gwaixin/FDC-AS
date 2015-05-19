<?php

class ContractlogsController extends AppController{
	
	public $components = array('RequestHandler','Paginator');
	
	public $helpers  = array('Html', 'Form');
	
	public function index(){
		

		$this->layout = 'main';
		$errors = '';
		
		$this->loadModel('Employee');
		$this->loadModel('Position');
		
		
		$empId = $this->Employee->find('list', array(
				'fields' => array('employee_id','employee_id')
		));
		
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));
	
		$this->set('empId', $empId);
		$this->set('position', $position);
		
		if($this->request->is('post')){
			
			$this->Contractlog->create();
			
			$data = $this->request->data;

		/* 	$data = array(
					'employees_id' => $reqdata['employees_id'],
					'description' => $reqdata['description'],
					'date_start' => $reqdata['date_start'],
					'date_end' => $reqdata['date_end'],
// 					'document' => $reqdata['document'],
					'salary' => $reqdata['salary'],
					'deminise' => $reqdata['deminise'],
					'term' => $reqdata['term'],
					'position' => $reqdata['position'],
					'status' => 1,
			);
			 */
			if($this->Contractlog->save($data)){
				return $this->redirect('/');
			}
			
			$errors = $this->Contractlog->validationErrors;
		}
		
		$this->set('errors',$errors);
	}
	
	public function update(){
		
	}
	
}