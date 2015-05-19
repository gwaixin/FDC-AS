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
				'fields' => array('id','employee_id')
		));
		
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));
	
		$this->set('empId', $empId);
		$this->set('position', $position);
		
		if($this->request->is('post')){
			
			$this->Contractlog->create();
			
			$row = $this->request->data;

			$data = array(
					'employees_id' => $row['employees_id'],
					'description' => $row['description'],
					'date_start' => $row['date_start'],
					'date_end' => $row['date_end'],
					'document' => $row['Contractlog']['document'],
					'salary' => $row['salary'],
					'deminise' => $row['deminise'],
					'term' => $row['term'],
					'position' => $row['position'],
					'status' => 1,
			);

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