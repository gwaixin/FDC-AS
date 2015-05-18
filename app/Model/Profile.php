<?php

App::uses('AppModel', 'Model');

class Profile extends AppModel{


	public $imgsrc = null;
	public $tmpsrc = null;
	public $mode = 0;

	public $validate = array(
			'first_name' => array(
					'rule' => 'notEmpty',
					'message' => 'Please provide a valid First name.'
			),
			'last_name' => array(
					'rule' => 'notEmpty',
					'message' => 'Please provide a valid Last name.'
			),
			'email' => array(
					'rule' => array('email', true),
					'message' => 'Please provide a valid email address.'
			),
			'birthday' => array(
					'rule' => array('datetime', 'y-m-d'),
					'message' => 'Please enter a valid date and time.'
			),
			'facebook' => array(
					'rule' => array('email', true),
					'message' => 'Please provide a valid email address.'
			),
			'picture' => array(
					'rule1'=>array(
				        'rule' => array('extension',array('jpeg','jpg','png','gif')),
				        'required' => 'create',
				        'allowEmpty' => true,
				        'message' => 'Select valid image for profile picture',
				        'on' => 'create',
				        'last'=>true
				    ),
				    'rule2'=>array(
				        'rule' => array('extension',array('jpeg','jpg','png','gif')),
				        'message' => 'Select valid image for profile picture',
				        'on' => 'update',
				    ),
					'rule3' => array(
							'rule' => array('fileSize', '<=', '1MB'),
							'message' => 'Image must be less than 1MB'
					)
			),
			'signature' => array(
					'rule1'=>array(
				        'rule' => array('extension',array('jpeg','jpg','png','gif')),
				        'required' => 'create',
				        'allowEmpty' => true,
				        'message' => 'Select valid file for signature',
				        'on' => 'create',
				        'last'=>true
				    ),
				    'rule2'=>array(
				        'rule' => array('extension',array('jpeg','jpg','png','gif')),
				        'message' => 'Select valid file for signature',
				        'on' => 'update',
				    ),
					'rule3' => array(
							'rule' => array('fileSize', '<=', '1MB'),
							'message' => 'Image must be less than 1MB'
					)
			),
			'contact' => array(
					'min_length' => array(
							'rule' => array('minLength', '8'),
							'message' => 'Contact number must have a mimimum of 12 characters'
					)
			),
			'contact_person_no' => array(
					'min_length' => array(
							'rule' => array('minLength', '8'),
							'message' => 'Contact person number must have a mimimum of 12 characters'
					)
			),

	);

	/**
	 * Process resize image according to its dimesion
	 * @param unknown $src = file source
	 * @param unknown $width = set width of the image ex:(250)
	 * @param unknown $height = set height  of the image ex:(250)
	 * @return string temp name of the image
	 */
	public function resize($src = null, $width = 0, $height = 0){

		$file = $src;
		$tmppath = $this->webroot.'upload/';

		if(empty($file['tmp_name'])){
			return '';
		}
		/* Get original image x y*/
		list($w, $h) = getimagesize($file['tmp_name']);

		if(empty($w) || empty($h)){
			return false;
		}

		/* calculate new image size with ratio */
		$ratio = max($width/$w, $height/$h);
		$h = ceil($height / $ratio);
		$x = ($w - $width / $ratio) / 2;
		$w = ceil($width / $ratio);

		$ext = $file['type'];
		$extension = $this->getExtenstion($file['type']);

		/* new file name */
		$this->imgsrc = $tmppath.$width.'x'.$height.'_'.$w.$h.time().'.'.$extension;

		/* read binary data from image file */
		$imgString = file_get_contents($file['tmp_name']);

		/* create image from string */
		$image = imagecreatefromstring($imgString);
		$this->tmp = imagecreatetruecolor($width, $height);
		imagecopyresampled($this->tmp, $image,0, 0,$x, 0,$width, $height, $w, $h);
		$this->UploadProcess($ext);

		return str_replace($tmppath, '', $this->imgsrc);

	}

	/**
	 * Proccess Image upload  ex:(gif , jpeg, png,)
	 * default upload direct file to folder
	 * @param unknown $ext
	 */
	public function UploadProcess($ext){
		switch ($ext) {
			case 'image/jpeg':
				imagejpeg($this->tmp, $this->imgsrc, 100);
				break;
			case 'image/png':
				imagepng($this->tmp, $this->imgsrc, 0);
				break;
			case 'image/gif':
				imagegif($this->tmp, $this->imgsrc);
				break;
			default:
				move_uploaded_file($this->tmp, $this->imgsrc);
				break;
		}
	}

	/**
	 * return file extesion
	 * @param unknown $file = source image file extension
	 * @return boolean|string
	 */
	function getExtenstion($file) {
		$ext = 'jpg';
		switch ($file) {
			case 'image/jpeg':
				$ext = 'jpeg';
				break;
			case 'image/png':
				$ext = 'png'; break;
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				return false;
		}
		return $ext;
	}

	public function beforeSave($options  = array()){

		if($this->mode == 0){
			$this->data[$this->alias]['picture'] = $this->resize($this->data[$this->alias]['picture'], 250, 250);
			$this->data[$this->alias]['signature'] = $this->resize($this->data[$this->alias]['signature'], 250, 250);
		}else{

			if(!empty($this->data[$this->alias]['picture']['name'])){
				$this->data[$this->alias]['picture'] = $this->resize($this->data[$this->alias]['picture'], 250, 250);
			}
			
			if(!empty($this->data[$this->alias]['signature']['name'])){
				pr('s');
				$this->data[$this->alias]['signature'] = $this->resize($this->data[$this->alias]['signature'], 250, 250);
			}
			
		}
		return true;
		
	}

	function beforeValidate($options = array()){
		
		if(empty($this->data[$this->alias]['picture']['name'])){
			unset($this->validate['picture']);
		}
		
		if(empty($this->data[$this->alias]['signature']['name'])){
			unset($this->validate['signature']);
		}

		return true; //this is required, otherwise validation will always fail
	
	}
	
}