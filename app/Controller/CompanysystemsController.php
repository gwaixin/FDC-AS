<?php

class CompanysystemsController extends AppController{
	
	var $arrdata = array(
			'name' => '',
			'address' => '',
			'description' => '',
			'date_start' => '',
			'owner' => '',
			'status' => '',
	);
	
	public function index($layout = ''){
		if (!empty($layout)) {
			$this->layout = $layout;
		}
		$action = '';
		$action_delete = '';
		$keyword = '';
		$display = 'display:none';
		
		if (isset($this->params['url']['search'])) {
			$keyword = $this->params['url']['search'];
		}

		if (isset($this->params['url']['action_delete'])){
			$action_delete = $this->params['url']['action_delete'];
		}
		
		if (isset($this->params['url']['action'])){
			$action = $this->params['url']['action'];
		}
		
		if ($action == 'deleted') {
			if (!empty($action_delete)) {
				$condition = array(
						"AND" => array(
								array("status" => 0),
								array("{$action_delete} LIKE" => "%{$keyword}%")
						)
				);
			}else{
				$condition = array('status' => 0);
			}	
			$display = '';
		}elseif (!empty($action) && $action !== 'deleted'){
			$condition = array(
					"AND" => array(
							array("status" => 1),
							array("{$action} LIKE" => "%{$keyword}%")
					)
			);
		}else {	
			$condition = array('status' => 1);
		}	
		
		$this->paginate = array(
				'conditions' => $condition,
				'limit' => 10
		);
		
		$this->set('data', $this->paginate());
		$this->set('action', $action);
		$this->set('keyword', $keyword);
		$this->set('action_by', $action_delete);
		$this->set('display', $display);

	}
	
	public function add(){
		
		$errors = '';
		
		if($this->request->is('post')){

			$this->Companysystem->create();
			
			$data = $this->request->data;
			$data['status'] = 1;
			$this->arrdata = $data;
		
			if($this->Companysystem->save($data)){
				return $this->redirect('/');
			}else{
				$errors = $this->Companysystem->validationErrors;
			}
				
		}
		

		$this->set('data', $this->arrdata);
		$this->set('errors' , $errors);
	}
	
	public function edit($id = null){
		
		if(!$id){
			$this->redirect('/');
		}
		
		$errors = '';
		
		$data = $this->Companysystem->findById($id);
		
		$this->arrdata['name'] = $data['Companysystem']['name'];
		$this->arrdata['address'] = $data['Companysystem']['address'];
		$this->arrdata['description'] = $data['Companysystem']['description'];
		$this->arrdata['date_start'] = $data['Companysystem']['date_start'];
		$this->arrdata['owner'] = $data['Companysystem']['owner'];
		$this->arrdata['status'] = $data['Companysystem']['status'];
		
		if($this->request->is('post')){

			$this->Companysystem->id = $id;
			
			$data = $this->request->data;
			$this->arrdata = $data;
		
			if($this->Companysystem->save($data)){
				return $this->redirect('/');
			}else{
				$errors = $this->Companysystem->validationErrors;
			}
				
		}
		
		
		$this->set('data', $this->arrdata);
		$this->set('errors' , $errors);
	}
	
	public function delete() {
	
		$this->autoRender = false;
	
		if ($this->request->is('post')) {
				
			$id = $this->request->data;
				
			$this->Companysystem->id = $id['dataID'];
	
			$data['status'] = 0;
	
			if ($this->Companysystem->save($data)) {
				echo json_encode(array(
						'success' => 1
				));
			} else {
				echo json_encode(array(
						'success' => 0
				));
			}
				
		}
	
	}
	
}