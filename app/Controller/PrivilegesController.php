<?php


class PrivilegesController extends AppController {
	
	
	public function index($layout){
	
		$this->layout = $layout;
	
		$keyword = '';
		$action = '';
		$conditions = '';
	
	
		try {
			$this->paginate();
		} catch (NotFoundException $e) {
			$this->redirect('/admin/privileges/');
		}
	
		$this->Privilege->recursive = 0;
		if($this->request->is('get')){
				
			$data = $this->request->data;
				
			if(isset($this->params['url']['action'])){
				$action = $this->params['url']['action'];
			}
				
			if(isset($this->params['url']['search'])){
				$keyword = $this->params['url']['search'];
			}
				
				
			if(!empty($action) && $action !== 'roles'){
				$conditions = array(
						'AND' => array(
								array("Privilege.{$action} LIKE" => "%{$keyword}%"),
								array("Privilege.status " => 1)
						)
				);
			}elseif ($action == 'roles'){
				$conditions = array(
						'AND' => array(
								array("rl.description LIKE" => "%{$keyword}%"),
								array("Privilege.status" => 1)
						)
				);
			}else{
				$conditions = array('Privilege.status = 1');
			}
				
			$this->set('action' , $action);
			$this->set('search' , $keyword);
		}
	
	
		$this->paginate = array(
				'conditions' => $conditions,
				'joins' => array(
						array(
								'table' => 'roles',
								'type' => 'LEFT',
								'alias' => 'rl',
								'conditions' => array('rl.id = Privilege.roles_id'),
						)
				),
				'fields' => array(
						'rl.description',
						'Privilege.id',
						'Privilege.roles_id',
						'Privilege.controller',
						'Privilege.action',
						'Privilege.description',
						'Privilege.action',
						'Privilege.status'
	
				),
				'limit' => 10
		);
	
		$this->set('data', $this->paginate() );
		$this->set('action' , $action);
		$this->set('search' , $keyword);
	
	}
	
	public function add($layout){
		
		$errors = '';
		
		$this->layout = $layout;
		
		$this->loadModel('Role');
		
		$roles = $this->Role->find('list',array(
				'fields' => array('id','description')
		));
		
				
		$temp = array(
			'roles_id' => '',
			'controller' => '',
			'action' => '',
			'description' => ''				
		);
		
		if($this->request->is('post')){
			
			$this->Privilege->create();
			
			$row = $this->request->data;
			$row['status'] = 1;
			
			$temp = $row;
			
			if($this->Privilege->save($row)){
				$this->redirect('/admin/privileges/');
			}else{
				$errors = $this->Privilege->validationErrors;
			}	
		}
		
		$this->set('temp', $temp);
		$this->set('errors', $errors);
		$this->set('roles', $roles);
		
	}
	
	public function edit($layout){
		
		$errors = '';
		
		$this->layout = $layout;
	
		$this->loadModel('Role');
		
		$id = $this->request->params['id'];
		if(!$id){
			$this->redirect('/admin/privileges/');
		}
		
		$roles = $this->Role->find('list',array(
				'fields' => array('id','description')
		));
		
		$data = $this->Privilege->findById($id);
		
		$temp = array(
				'roles_id' => $data['Privilege']['roles_id'],
				'controller' => $data['Privilege']['controller'],
				'action' => $data['Privilege']['action'],
				'description' => $data['Privilege']['description'],
				'status' => $data['Privilege']['status']
		);
		
		if($this->request->is('post')){
				
			$this->Privilege->id = $id;
				
			$row = $this->request->data;
		
			$temp = $row;
				
			if($this->Privilege->save($row)){
				$this->redirect('/admin/privileges/');
			}else{
				$errors = $this->Privilege->validationErrors;
			}
		}
		
		$this->set('temp', $temp);
		$this->set('errors', $errors);
		$this->set('roles', $roles);
		
	}
			
	public function delete(){
		
		$this->autoRender = false;

		if($this->request->is('post')){
			
			$id = $this->request->data;
			
			$this->Privilege->id = $id['dataID'];
			
			$data['status'] = 0;
			
			
			if($this->Privilege->save($data)){
				echo json_encode(array(
						'success' => 1		
				));
			}else{
				echo json_encode(array(
						'success' => 0
				));
			}
			
		}
		
	}
	
	
}