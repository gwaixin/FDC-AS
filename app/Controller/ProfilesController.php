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
		
		$this->layout = 'profile';
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

			$row = $this->request->data;
			
			$this->Profile->create();
			$this->imgpath = '';
			
			$data = array(
					'first_name' => $row['first_name'],
					'last_name' => $row['last_name'],
					'middle_name' => $row['middle_name'],
					'birthdate' => $row['birthdate'],
					'contact' => $row['contact'],
					'facebook' => $row['facebook'],
					'picture' => $this->Profile->resize($row['Profile']['picture'], 250, 250),
					'email' => $row['email'],
					'gender' => $row['gender'],
					'address' => $row['address'],
					'contact_person' => $row['contact_person'],
					'contact_person_no' => $row['contact_person_no'],
					'signature' => $this->Profile->resize($row['Profile']['signature'], 250, 250),
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
		$this->layout = 'profile';
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
				
				if(empty($row['Profile']['picture']['name'])){
					$imgorig = $data['Profile']['picture'];
				}else{
					$imgorig = $this->Profile->resize($row['Profile']['picture'], 250, 250);
				}
				
				if(empty($row['Profile']['signature']['name'])){
					$imgSig = $data['Profile']['signature'];
				}else{
					$imgSig = $this->Profile->resize($row['Profile']['signature'], 250, 250);
				}
				
				
				$data = array(					
						'Profile' =>array(
							'first_name' => $row['first_name'],
							'last_name' => $row['last_name'],
							'middle_name' => $row['middle_name'],
							'birthdate' => $row['birthdate'],
							'contact' => $row['contact'],
							'facebook' => $row['facebook'],
							'picture' => $imgorig,
							'email' => $row['email'],
							'gender' => $row['gender'],
							'address' => $row['address'],
							'contact_person' => $row['contact_person'],
							'contact_person_no' => $row['contact_person_no'],
							'signature' => $imgSig
						)
				);
				
				if($this->Profile->save($data)){
					return $this->redirect('/');
				}else{
					$errors = $this->Profile->validationErrors;	
				}
				$this->Session->setFlash(__('Unable to update your post'));	
			}
			
			$imgPic = $data['Profile']['picture'];
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