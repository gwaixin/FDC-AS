<?php

class ProfilesController extends AppController{
	
	public $components = array('RequestHandler','Paginator');
	
	public $helpers  = array('Html', 'Form');
	
	protected $imgpath = null; //image path
	
	
	/**
	 * list of profile
	 */
	public function list_profile(){
		$this->layout = 'profile';
		$this->Paginator->settings = array(
					'limit' => 8, 
				);
		$data = $this->Paginator->paginate('Profile');

		$this->set(compact('data'));
	}
	
	public function profile_register(){
		
		$this->layout = 'profile';
		$errors = '';
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
					'picture' => $this->file($row['Profile']['picture']),
					'email' => $row['email'],
					'gender' => $row['gender'],
					'address' => $row['address'],
					'contact_person' => $row['contact_person'],
					'contact_person_no' => $row['contact_person_no'],
					'signature' => $row['signature'],
			);
			
			if($this->Profile->save($data)){
				$this->upload($row['Profile']['picture']['tmp_name']);
				$this->Session->setFlash('Data Successfully added');
				return $this->redirect('/');
			}else{
				$this->set('data', $data);
				$errors = $this->Profile->validationErrors;
			}
			
			
		}
		
		$this->set('errors', $errors);
		
	}
	
	public function profile_update($id = null){
		$this->layout = 'profile';
		$errors = '';
		
		if(!$id){
			return $this->redirect('/');
		}
		
		$data = $this->Profile->findById($id);
		
		if($data){
			
			if($this->request->is(array('post','put'))){
				$this->Profile->id = $id;
				
				$row = $this->request->data;
				
				$this->imgpath = '';
				
				if(empty($row['Profile']['picture']['name'])){
					$imgorig = $data['Profile']['picture'];
				}else{
					$imgorig = $this->file($row['Profile']['picture']);
				}
				
				$data = array(
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
						'signature' => $row['signature'],
				);
				
				if($this->Profile->save($data)){
					
					if(!empty($row['Profile']['picture']['name'])){
						$this->upload($row['Profile']['picture']['tmp_name']);
					}
					
					return $this->redirect('/');
				}else{
					
					$errors = $this->Profile->validationErrors;
					
				}
				$this->Session->setFlash(__('Unable to update your post'));	
			}
			
			$imgPic = $data['Profile']['picture'];
			$data['Profile']['picture'] = ($imgPic)? $this->webroot.'upload/'.$imgPic : $this->webroot.'img/emptyprofile.jpg' ;
			
			pr($data);
			$this->set('data',$data);
			
			$this->set('errors', $errors);
			
		}else{
			return $this->redirect('/');
		}
		
	}
	
	public function delete(){
		$this->layout = 'ajax';
		
		if($this->request->is('post')){
			
			$data = $this->request->data;

			if($this->Profile->delete($data['dataID'])){
				echo '1';
				exit();
			}
		}

	}
	
	public function view(){
		
		$this->layout = 'ajax';
		
		if($this->request->is('ajax')){
			
			$data = $this->request->data;
			
			$result = $this->Profile->findById($data['dataId']);
			
			echo json_encode($result) ;
			
			exit();
		
		}
		
		
	}
	
	/**
	 * Initialize image path 
	 * @param unknown $params
	 * @return boolean|string
	 */
	public function file($params) {
		$image = $params;

		$imageTypes = array("image/gif", "image/jpeg", "image/png");
		$uploadFolder = "upload";
		
		if(empty($image['name'])){
			return false;
		}
		
		$uploadPath = WWW_ROOT . $uploadFolder;
		foreach ($imageTypes as $type) {

			if ($type == $image['type']) {
				 
				if ($image['error'] == 0) {

					$imageName = $image['name'];

					$imageName = 'fdc'.date('His') . $imageName;
		
					$full_image_path = $uploadPath . '/' . $imageName;
					
					$this->imgpath = $full_image_path;
					
					return $imageName;

				} else {
					$this->Session->setFlash('Error uploading file.');
				}
				break;
			} else {
				$this->Session->setFlash('Unacceptable file type');
			}
		}
	}
	
	/**
	 * Upload final Image
	 * @param unknown $params
	 * @return boolean
	 */
	public function upload($params){
		
		if (move_uploaded_file($params, $this->imgpath)) {
			return true;
		} else {
			$this->Session->setFlash('There was a problem uploading file. Please try again.');
		}
	}
}