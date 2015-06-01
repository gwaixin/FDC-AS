<?php

class RolesController extends AppController{
	
	public function index($layout) {
		
		$this->layout = $layout;
		$keyword = '';
		$action = '';
		
		if (isset($this->params['url']['search'])) {
			$keyword = $this->params['url']['search'];
		}
				
		if (isset($this->params['url']['action'])){
			$action = $this->params['url']['action'];
		}
		
		if ($action == 'delete') {
			$condition = array(
					'AND' => array(
							array('status' => 0),
							array('description LIKE' => '%'.$keyword.'%')
					)
			);
			
		} else {	
			$condition = array(
					'AND' => array(
							array('status' => 1),
							array('description LIKE' => '%'.$keyword.'%')
						)			
				);
		}	
		
		$this->paginate = array(
				'conditions' => $condition,
				'limit' => 10
		);
		
		$this->set('data', $this->paginate());
		$this->set('action', $action);
		$this->set('keyword', $keyword);
	}
	
	public function add($layout) {
		
		$this->layout = $layout;
		
		$temp = array(
				'id' => '',
				'description' => '',
				'status' => ''
		);
		
		if ($this->request->is('post')) {
			
			$data = $this->request->data;
			$data['status'] = 1;
			$temp = $data;
			
			if ($this->Role->save($data)) {
				$this->redirect('/admin/roles/');
			} else {
				$errors = $this->Role->validationErrors;
			}
			
		}
		
		$this->set('data', $temp);
		$this->set('errors', $errors);
		
	}
	
	public function edit($layout) {
		
		$errors = '';
		
		$id = $this->request->param('id');

		if (!$id) {
			$this->redirect('/admin/roles');
		}
		
		$this->layout = $layout;

		$data = $this->Role->findById($id);
		
		$temp = array(
				'id' => $data['Role']['id'],
				'description' => $data['Role']['description'],
				'status' => $data['Role']['status']
		);
		
		if ($this->request->is(array('post','put'))) {
			
			$this->Role->id = $id;
			
			$data = $this->request->data;
	
			$temp = $data;
			
			if ($this->Role->save($data)) {
				$this->redirect('/admin/roles');
			} else {
				$errors = $this->Role->validationErrors;
			}
			
		}
		
		$this->set('data', $temp);
		$this->set('errors', $errors);
		
	}
	
	
	public function delete() {
		
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			
			$id = $this->request->data;
			
			$this->Role->id = $id['dataID'];
				
			$data['status'] = 0;

			if ($this->Role->save($data)) {
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