<?php

class RolesController extends AppController{
	
	public function index(){
		
		$this->layout = 'main';

		$data = $this->Role->find('all',array(
				'conditions' => array('status' => 1)
		));
		
		$this->set('data',$data);
	}
	
	public function add(){
		
		$this->layout = 'main';
		
		$temp = array(
				'id' => '',
				'description' => '',
				'status' => ''
		);
		
		if($this->request->is('post')){
			
			$data = $this->request->data;
			$data['status'] = 1;
			$temp = $data;
			
			if($this->Role->save($data)){
				$this->redirect('/roles');
			}else{
				$errors = $this->Role->validationErrors;
			}
			
		}
		
		$this->set('data', $temp);
		$this->set('errors', $errors);
		
	}
	
	public function edit($id = null){
		
		$errors = '';
		
		if(!$id){
			$this->redirect('/roles');
		}
		
		$this->layout = 'main';

		$data = $this->Role->findById($id);
		
		$temp = array(
				'id' => $data['Role']['id'],
				'description' => $data['Role']['description'],
				'status' => $data['Role']['status']
		);
		
		if($this->request->is(array('post','put'))){
			
			$this->Role->id = $id;
			
			$data = $this->request->data;
	
			$temp = $data;
			
			if($this->Role->save($data)){
				$this->redirect('/roles');
			}else{
				$errors = $this->Role->validationErrors;
			}
			
		}
		
		$this->set('data', $temp);
		$this->set('errors', $errors);
		
	}
	
	
	public function delete(){
		
		$this->autoRender = false;
		
		if($this->request->is('post')){
			
			$id = $this->request->data;
			
			$this->Role->id = $id['dataID'];
				
			$data['status'] = 0;

			if($this->Role->save($data)){
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