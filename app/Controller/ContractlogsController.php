<?php

class ContractlogsController extends AppController{
	
	public $components = array('RequestHandler','Paginator');
	
	public $helpers  = array('Html', 'Form');
	
	public function index(){
		

		$this->layout = 'main';
		$errors = '';
		
		$this->loadModel('Employee');
		$this->loadModel('Position');
		$this->loadModel('Positionlevel');
		
		$empId = $this->Employee->find('list', array(
				'fields' => array('id','employee_id')
		));
		
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));
		
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));
		
		$positionlevel = $this->Positionlevel->find('list', array(
				'fields' => array('id', 'description')
		));
	
		$this->set('empId', $empId);
		$this->set('position', $position);
		$this->set('positionlevel', $positionlevel);
		
		
		if($this->request->is('post')){
			
			$this->Contractlog->create();
			
			$row = $this->request->data;
			$currentContract = $this->Contractlog->findByEmployees_id($row['employees_id']);
			$data = array(
					'employees_id' => $row['employees_id'],
					'description' => $row['description'],
					'date_start' => $row['date_start'],
					'date_end' => $row['date_end'],
					'document' => $row['Contractlog']['document'],
					'salary' => $row['salary'],
					'deminise' => $row['deminise'],
					'term' => $row['term'],
					'positions_id' => $row['positions_id'],
					'position_levels_id' => $row['position_levels_id'],
					'status' => 1,
			);
			if($this->Contractlog->save($data)){
				
				$lastid = $this->Contractlog->getLastInsertId();
				if($currentContract){
					$data = array(
							'status' => 0
					);
					$this->Contractlog->updateAll(
							array('status' => 0),
							array(
								'id <>' => $lastid,
								'employees_id' => $currentContract['Contractlog']['employees_id'],
							));

				}
					
				return $this->redirect('/');
			}
			
			$errors = $this->Contractlog->validationErrors;
		}
		
		$this->set('errors',$errors);
	}
	
	public function update($id = null){
		
		$this->layout = 'main';
		
		$errors = '';
		
		$this->loadModel('Employee');
		$this->loadModel('Position');
		$this->loadModel('Positionlevel');
		
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}
		
		
		$empId = $this->Employee->find('list', array(
				'fields' => array('id','employee_id')
		));
		
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));
		
		$positionlevel = $this->Positionlevel->find('list', array(
				'fields' => array('id', 'description')
		));
		
		$this->set('empId', $empId);
		$this->set('position', $position);
		$this->set('positionlevel', $positionlevel);
		
		$detail = $this->Contractlog->getDetail($id);
		
		$data = array(
				'employees_id' => $detail['Contractlog']['employees_id'],
				'description' => $detail['Contractlog']['description'],
				'date_start' => $detail['Contractlog']['date_start'],
				'date_end' => $detail['Contractlog']['date_end'],
				'document' => $detail['Contractlog']['document'],
				'salary' => $detail['Contractlog']['salary'],
				'deminise' => $detail['Contractlog']['deminise'],
				'term' => $detail['Contractlog']['term'],
				'positions_id' => $detail['Contractlog']['positions_id'],
				'position_levels_id' => $detail['Contractlog']['position_levels_id'],
		);
		
		$this->Contractlog->id = $detail['Contractlog']['id'];
		
		if($this->request->is(array('post','put'))){
				
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
					'positions_id' => $row['positions_id'],
					'position_levels_id' => $row['position_levels_id'],
					'status' => 1,
			);
		
			$this->Contractlog->id = $id;
			
			if($this->Contractlog->save($data)){
				$this->redirect('/');
			}else{
				$errors = $this->Contractlog->validationErrors;
			}
		}
		
		$this->set('errors',$errors);
		$this->set('data',$data);
		
	}
	
	public function list_contract(){
		
		$this->layout = 'main';

		$this->set('data', $this->Contractlog->find('all'));
		
		
	}
	
	
	public  function delete(){
		
		$this->autoRender = false;
		
		if($this->request->is('post')){
			$data = $this->request->data;
			$dataImg = $this->Contractlog->findById($data['dataID']);
			$this->Contractlog->delete($data['dataID']);
		}
		
	}
	
	public function GetPosition(){
		
		$this->loadModel('Position');
		$this->loadModel('Positionlevel');
		
		$this->autoRender = false;
		
		if($this->request->is('ajax')){
			
			$data = $this->request->data;
			
			if($data['mode'] == 0){
				
				$result = $this->Positionlevel->findById($data['id']);
				if(empty($result)){
					$result = 0;
				}
	
			}else{
				
				$result = $this->Positionlevel->findById($data['id']);
				if(!empty($result)){
					$result = $this->Position->findById($result['Positionlevel']['positions_id']);
				}else{
					$result = 0;
				}
				
			}

			echo json_encode($result);
		}

	}
	
}