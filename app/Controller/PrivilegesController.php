<?php


class PrivilegesController extends AppController {
	
	
	public function index(){
		
		$errors = '';
		
		$this->layout = 'main';
		
		$this->loadModel('Role');
		
		$roles = $this->Role->find('list',array(
				'fields' => array('id','description')
		));
		
				
		$temp = array(
			'roles_id' => '',
			'controller' => '',
			'action' => '',
			'description' => '',
			'status' => ''					
		);
		
		if($this->request->is('post')){
			
			$this->Privilege->create();
			
			$row = $this->request->data;

			$temp = $row;
			
			if($this->Privilege->save($row)){
				$this->redirect('/privileges/privilege_list');
			}else{
				$errors = $this->Privilege->validationErrors;
			}	
		}
		
		$this->set('temp', $temp);
		$this->set('errors', $errors);
		$this->set('roles', $roles);
		
	}
	
	public function edit($id = null){
		
		
		$errors = '';
		
		$this->layout = 'main';
	
		$this->loadModel('Role');
		
		
		if(!$id){
			$this->redirect('/ privileges/privilege_list');
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
				$this->redirect('/privileges/privilege_list');
			}else{
				$errors = $this->Privilege->validationErrors;
			}
		}
		
		$this->set('temp', $temp);
		$this->set('errors', $errors);
		$this->set('roles', $roles);
		
	}
	
	public function privilege_list($page = null){
		
		$this->layout = 'main';
		
		$keyword = '';
		$action = '';
		$conditions = '';
		
		
		try {
			$this->paginate();
		} catch (NotFoundException $e) {
			$this->redirect('/privileges/privilege_list');
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
				$conditions = array('Privilege.'.$action.' LIKE' => '%'.$keyword.'%');
			}elseif ($action == 'roles'){
				$conditions = array('rl.description LIKE' => '%'.$keyword.'%');
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
	
	
	public function delete(){
		
		$this->autoRender = false;

		if($this->request->is('post')){
			
			$data = $this->request->data;
			
			if($this->Privilege->delete($data['dataID'])){
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