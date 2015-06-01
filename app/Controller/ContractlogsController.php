<?php

class ContractlogsController extends AppController{
	
	public $components = array('RequestHandler','Paginator');
	
	public $helpers  = array('Html', 'Form');
	
	public function index() {
		

		$this->layout = 'main';
		
		$this->autoRender = false;
		
		$errors = '';
		$requestData = '';
		$lastid = 0;

		$this->loadModel('Position');
		$this->loadModel('Positionlevel');
		
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));
		
		$positionlevel = $this->Positionlevel->find('list', array(
				'fields' => array('id', 'description')
		));

		if ($this->request->is('ajax')) {
			
			$this->Contractlog->create();
			
			$row = $this->request->data;
			
			$currentContract = $this->Contractlog->findByEmployees_id($row['Contractlog']['id']);
			$data = array(
					'employees_id' => $row['Contractlog']['id'],
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
			
			$this->__checkEmployeeStatus($row['Contractlog']['id']);
			
			if ($this->Contractlog->save($data)) {
				
				$lastid = $this->Contractlog->getLastInsertId();
				if ($currentContract) {
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
				$row['contract_id'] = $lastid;
				$this->__updateEmpContract($row['Contractlog']['id'], $row);
			} else {
				$errors = array(
						'success' => 1,
						'ErrMessage' => $this->Contractlog->validationErrors
							
				);
			}
		}
		
		$Returndata = array(
				'errors' => $errors,
				'data' => $this->ContractDetail($row['Contractlog']['id'], $lastid)
				
		); 
	
		echo json_encode($Returndata);
	}
	
	/**
	 * Update Contract employee
	 * @param string $id
	 */
	public function update($id = null) {
		
		$this->layout = 'main';
		
		$errors = '';
		
		$this->loadModel('Employee');
		$this->loadModel('Position');
		$this->loadModel('Positionlevel');
		
		if (!$id) {
			return $this->redirect('/');
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
		
		if (!$detail) {
			return $this->redirect('/');
		}
		
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
		
		if ($this->request->is(array('post','put'))) {
				
			$row = $this->request->data;
		
			$data = array(
					'employees_id' =>  $detail['Contractlog']['employees_id'],
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
			
			$this->__checkEmployeeStatus($detail['Contractlog']['employees_id']);
			
			if ($this->Contractlog->save($data)) {
				
				$row['contract_id'] = $id;
				$this->__updateEmpContract($detail['Contractlog']['employees_id'], $row);
				$this->redirect('/');
			} else {
				$errors = $this->Contractlog->validationErrors;
			}
		}
		
		$this->set('errors',$errors);
		$this->set('data',$data);
		
	}
	
	/**
	 * list of employee contract history
	 * @param string $id = table id 
	 */
	public function employee($id = null) {
		
		if (!$id) {
			$this->redirect('/');
		}
		
		$this->loadModel('Employee');
		$this->loadModel('position');
		$this->loadModel('Positionlevel');
		$this->layout = 'main';
		
		$keyword = '';
		$action = '';
		$condition = '';
		
		
		if (isset($this->params['url']['action'])) {
			$action = $this->params['url']['action'];
		}
		
		if (isset($this->params['url']['search'])) {
			$keyword = $this->params['url']['search'];
		}
		
		if (!empty($action) && !empty($keyword)) {
			
			if ($action == 'position') {
				$condition = ' AND post.description LIKE '.'"%'.$keyword.'%"';
			} else {
				$condition = ' AND Contractlog.'.$action.' LIKE '.'"%'.$keyword.'%"';
			}		
			
		}
		
		$res = $this->ContractDetail($id,'','limit',10 , $condition);
		
		
		$this->set('action', $action);
		$this->set('search', $keyword);
		
		$this->set('data', $res);
		$this->set('id', $id);
		
		
	}
	
	/*
	 * delete contract
	 */
	public  function delete() {
		
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$data = $this->Contractlog->findById($data['dataID']);
			$this->Contractlog->delete($data['dataID']);
		}
		
	}	
	
	/*
	 * Ajax request view
	 * of Contract
	 */
	public function view() {
		
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			
			$data = $this->request->data;
			list($id, $emp) = explode(':', $data['dataid']);
			
			$detail = $this->ContractDetail($id, $emp);
			
			echo json_encode($detail);
		}
		
	}
	
	/**
	 * Get Current Contract Detail of Employeed
	 * @param string $id = employee id
	 * @param string $emp = Contract Id 
	 * @return unknown
	 */
	public function ContractDetail($id = null, $contID = null, $index = '' , $limit = '', $options = null) {

		if (!$contID) {
			$condition = array('Contractlog.employees_id = '.$id.$options);
		} else {
			$condition = array("Contractlog.employees_id = '{$id}' AND Contractlog.id = '{$contID}'");
		}
	
		$options = array(
					array(
							'table' => 'employees',
							'type' => 'LEFT',
							'alias' => 'emp',
							'conditions' => array('emp.id = Contractlog.employees_id')
					),
					array(
							'table' => 'positions',
							'alias' => 'post',
							'type' => 'LEFT',
							'conditions' => array('post.id = Contractlog.positions_id')
					),
					array(
							'table' => 'position_levels',
							'alias' => 'postlevel',
							'type' => 'LEFT',
							'conditions' => array('postlevel.id = Contractlog.position_levels_id')
					)
		);
			
		$this->paginate = array(
				$index => $limit,
				'joins' => $options,
				'conditions' => $condition,
				'order' => 'Contractlog.id ASC',
				'fields' => array(
						'emp.id',
						'emp.employee_id',
						'Contractlog.id',
						'Contractlog.employees_id',
						'Contractlog.description',
						'Contractlog.date_start',
						'Contractlog.date_end',
						'Contractlog.document',
						'Contractlog.salary',
						'Contractlog.deminise',
						'Contractlog.term',
						'Contractlog.status',
						'post.description',
						'postlevel.description',
				)
		);
		
		return $this->paginate();
		
	}
	
	/*
	 * Get Position / Position level by mode 
	 * 1 For Position
	 * 2 For Position level ex: JUNIOR, MIDDLE and Senior
	 * 
	 * Ajax request
	 */
	public function GetPosition() {
		
		$this->loadModel('Position');
		$this->loadModel('Positionlevel');
		
		$this->autoRender = false;
		
		if ($this->request->is('ajax')) {
			
			$data = $this->request->data;
			
			if ($data['mode'] == 0) {
				
				$result = $this->Positionlevel->find('list',array(
						'fields' => array('id', 'description'),
						'conditions' => array('positions_id' => $data['id'])
				));
				if (empty($result)) {
					$result = 0;
				}
	
			} else {
				
				$result = $this->Positionlevel->findById($data['id']);
				if (!empty($result)) {
					$result = $this->Position->find('list',array(
							'fields' => array('id','description'),
							'conditions' => array('id' => $result['Positionlevel']['positions_id'])
					));
				} else {
					$result = 0;
				}
				
			}

			echo json_encode($result);
		}

	}
	
	/**
	 * Update Employee Contract 
	 * @param string $id = id table
	 * @param unknown $row = request data array
	 * @return boolean
	 */
	public function __updateEmpContract($id = null, $row = array()){
		
		$this->loadModel('Employee');
		
		$this->Employee->id = $id;
		$data = array(
				'position_id' => $row['positions_id'],
				'position_level_id' => $row['position_levels_id'],
				'current_contract_id' => $row['contract_id'],
		);
		if ($this->Employee->save($data)) {
			return true;
		}
		
		return false;
		
	}
	/**
	 * Check status of employee if ACTIVE or INACTIVE
	 * @param string $id = Employee id
	 * @return boolean
	 */
	public function __checkEmployeeStatus($id = null) {
		
		$this->loadModel('Employee');
		
		$data = $this->Employee->findById($id);
		
		if ($data['Employee']['status'] == 1 ) {
			//$this->Contractlog->validationErrors['message'] = "Cannot add contract employee inactive";
			return $this->Contractlog->invalidate('id', 'Cannot add contract employee is inactive');
		}
		
		return true;
	}
}