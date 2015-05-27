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
				$this->redirect('/');
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
			$this->redirect('/');
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
				$this->redirect('/');
			}else{
				$errors = $this->Privilege->validationErrors;
			}
		}
		
		$this->set('temp', $temp);
		$this->set('errors', $errors);
		$this->set('roles', $roles);
		
	}
	
	public function privlegeList(){
		
		
		
	}
	
	
}