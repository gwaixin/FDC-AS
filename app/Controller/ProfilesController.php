<?php

class ProfilesController extends AppController{
	
	public $components = array('RequestHandler','Paginator');
	
	public $helpers  = array('Html', 'Form');
	
	protected $imgpath = null; //image path
	
	
	/**
	 * list of profile
	 */
	public function index(){
		$this->layout = 'main';
		$this->Paginator->settings = array(
					'limit' => 8, 
				);
		$data = $this->Paginator->paginate('Profile');

		$this->set(compact('data'));
	}
	
	public function profile_register(){
		
		$this->layout = 'main';
		$errors = '';
		
		$data = array(
				'first_name' => '',
				'last_name' => '',
				'middle_name' => '',
				'birthdate' => '',
				'contact' => '',
				'facebook' => '',
				'picture' => '',
				'email' => '',
				'gender' => '',
				'address' => '',
				'contact_person' => '',
				'contact_person_no' => '',
				'signature' => '',
		);
		
		if($this->request->is('post')){
			
			$this->Profile->create();
			
			$row = $this->request->data;
			
			$data = array(
					'first_name' => $row['first_name'],
					'last_name' => $row['last_name'],
					'middle_name' => $row['middle_name'],
					'birthdate' => $row['birthdate'],
					'contact' => $row['contact'],
					'facebook' => $row['facebook'],
					'picture' => $row['Profile']['picture'],
					'email' => $row['email'],
					'gender' => $row['gender'],
					'address' => $row['address'],
					'contact_person' => $row['contact_person'],
					'contact_person_no' => $row['contact_person_no'],
					'signature' => $row['Profile']['signature']
			);

			if($this->Profile->save($data)){
				return $this->redirect('/');
			}else{
				$errors = $this->Profile->validationErrors;
			}
			
			
		}

		$this->set('data', $data);
		$this->set('errors', $errors);
		
	}
	
	public function profile_update($id = null){
		$this->layout = 'main';
		$errors = '';
		
		if(!$id){
			return $this->redirect('/');
		}
		
		$data = array(
				'first_name' => '',
				'last_name' => '',
				'middle_name' => '',
				'birthdate' => '',
				'contact' => '',
				'facebook' => '',
				'picture' => '',
				'email' => '',
				'gender' => '',
				'address' => '',
				'contact_person' => '',
				'contact_person_no' => '',
				'signature' => '',
		);
		
		$data = $this->Profile->findById($id);
		
		if($data){
			
			if($this->request->is(array('post','put'))){
				$this->Profile->id = $id;
				
				$row = $this->request->data;
				
				$ext = $row['Profile']['picture']['type'];
				
				$this->Profile->mode = 1;	
				
				$data = array(					
						'Profile' =>array(
							'first_name' => $row['first_name'],
							'last_name' => $row['last_name'],
							'middle_name' => $row['middle_name'],
							'birthdate' => $row['birthdate'],
							'contact' => $row['contact'],
							'facebook' => $row['facebook'],
							'email' => $row['email'],
							'gender' => $row['gender'],
							'address' => $row['address'],
							'contact_person' => $row['contact_person'],
							'contact_person_no' => $row['contact_person_no'],
						)
				);

				
				if ($row['Profile']['picture']['error'] != 4) {
					$data['Profile']['picture'] = $row['Profile']['picture'];
				}
				
				if($row['Profile']['signature']['error'] != 4){
					$data['Profile']['signature'] = $row['Profile']['signature'];
				}
				
				if($this->Profile->save($data)){
					return $this->redirect('/');
				}else{
					$errors = $this->Profile->validationErrors;	
				}
				$this->Session->setFlash(__('Unable to update your post'));	
			}
			
			$imgPic = $data['Profile']['picture'];
			$imgPic = (is_array($imgPic))? array_shift($array) : $imgPic;
			$data['Profile']['picture'] = ($imgPic)? $this->webroot.'upload/'.$imgPic : $this->webroot.'img/emptyprofile.jpg' ;

			$this->set('errors', $errors);
			
		}else{
			return $this->redirect('/');
		}

		$this->set('data',$data);
		
	}
	
	public function delete(){
		
		$this->autoRender = false;
			
		if($this->request->is('post')){
			
			$data = $this->request->data;
			$dataImg = $this->Profile->findById($data['dataID']);
			if($this->Profile->delete($data['dataID'])){
				$file = new File(WWW_ROOT .'upload/'.$dataImg['Profile']['picture'], false, 0777);
				$file->delete();
				echo '1';
			}
		}

	}
	
	public function view(){
		
		$this->autoRender = false;		
		
		if($this->request->is('ajax')){
			
			$data = $this->request->data;
			
			$result = $this->Profile->findById($data['dataId']);
			
			echo json_encode($result);
		
		}
		
		
	}
	
}