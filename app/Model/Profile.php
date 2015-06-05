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
					'rule1' => array(
						'rule' => array('email', true),
						'message' => 'Please provide a valid email address.'
					),
					'rule2' => array(
							'rule' => 'isUnique',
            				'message' => 'Email already registered'
					)
			),
			'birthdate' => array(
					'rule' => 'date',
					'message' => 'Please enter a valid date and time.'
			),
			'facebook' => array(
					'rule1' => array(
						'rule' => array('email', true),
						'message' => 'Please provide a valid facebook email address.'
					),
					'rule2' => array(
							'rule' => 'isUnique',
            				'message' => 'Facebook email already registered'
					)
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
		
		if (!file_exists($tmppath)) {
			mkdir($tmppath, 0777, true);
		}

		if(empty($file['tmp_name'])){
			return '';
		}
		/* Get original image x y*/
		list($w, $h) = getimagesize($file['tmp_name']);

		if(empty($w) || empty($h)){
			return false;
		}

		
		$newWidth = $width;
		$rate = ($newWidth / $w);
		$newHeight = $rate * $h;
		
		$ext_type = $file['type'];
		$ext = $this->getExtenstionType($file['tmp_name']); //extension .gif , .jpeg and png
		
		$this->tmp = imagecreatetruecolor($newWidth, $newHeight);
		$color  = imagecolorallocate ($this->tmp, 255, 255, 255);
		

		/* new file name */
		$this->imgsrc = $tmppath.'img'.date('Ymdis').'.'.$ext;
		
		switch ($ext) {
			case 'png' 	:
				imagealphablending($this->tmp, false);
				imagesavealpha($this->tmp,true);
				$transparent = imagecolorallocatealpha($this->tmp, 255, 255, 255, 127);
				imagefilledrectangle($this->tmp, 0, 0, $newWidth, $newHeight, $transparent);
				break;
			default:
				imagefill($this->tmp, 0, 0, $color);
		}


		$image = $this->createImageFrom($file['tmp_name'], $ext);

		imagecopyresampled($this->tmp, $image,0, 0,0, 0,$newWidth, $newHeight, $w, $h);
		$image = $this->imgsrc;
		$this->UploadProcess($ext_type);

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
				imagejpeg($this->tmp, $this->imgsrc, 90);
				break;
			case 'image/png':
				imagepng($this->tmp, $this->imgsrc, 0);
				break;
			case 'image/gif':
				imagegif($this->tmp, $this->imgsrc, 90);
				break;
			default:
				move_uploaded_file($this->tmp, $this->imgsrc);
				break;
		}
	}
	
	function getExtenstionType($file) {
		$ext = 'jpg';
		switch(exif_imagetype($file)) {
			case IMAGETYPE_GIF: $ext = 'gif'; break;
			case IMAGETYPE_JPEG: $ext = 'jpg'; break;
			case IMAGETYPE_PNG: $ext = 'png'; break;
		}
		return $ext;
	}

	function createImageFrom($src, $ext) {
		$img = '';
		switch($ext) {
			case 'png' 	:
			case 'PNG' 	:
				$img = imagecreatefrompng($src);
				break;
			case 'jpg' 	:
			case 'JPG' 	:
			case 'jpeg' :
			case 'JPEG' :
				$img = imagecreatefromjpeg($src);
				break;
			case 'gif' 	:
			case 'GIF'	:
				$img = imagecreatefromgif($src);
				break;
		}
		return $img;
	}
	
	public function beforeSave($options  = array()){

		if($this->mode == 0){
			$this->data[$this->alias]['picture'] = $this->resize($this->data[$this->alias]['picture'], 250, 0);
			$this->data[$this->alias]['signature'] = $this->resize($this->data[$this->alias]['signature'], 250, 0);
		}else{

			if(!empty($this->data[$this->alias]['picture']['name'])){
				$this->data[$this->alias]['picture'] = $this->resize($this->data[$this->alias]['picture'], 250, 0);
			}
			
			if(!empty($this->data[$this->alias]['signature']['name'])){
				$this->data[$this->alias]['signature'] = $this->resize($this->data[$this->alias]['signature'], 250, 0);
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