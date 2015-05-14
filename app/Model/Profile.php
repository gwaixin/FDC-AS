<?php

class Profile extends AppModel{
	
	
	public $imgsrc = null;
	public $tmpsrc = null;
		
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
			'facebook' => array(
					'rule' => array('email', true),
					'message' => 'Please provide a valid email address.'
			),
			'picture' => array(
					    'extension' => array(
					        'rule' => array('extension', array('jpeg','jpg','png','gif')),
					        'message' => 'Only image files',
					     ),
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
	
	public function resize($src, $width, $height){
		
		$file = $src;

		/* Get original image x y*/
		list($w, $h) = getimagesize($file['tmp_name']);
		/* calculate new image size with ratio */
		$ratio = max($width/$w, $height/$h);
		$h = ceil($height / $ratio);
		$x = ($w - $width / $ratio) / 2;
		$w = ceil($width / $ratio);
		/* new file name */
		$this->imgsrc = 'upload/'.$width.'x'.$height.'_'.$file['name'];
		/* read binary data from image file */
		$imgString = file_get_contents($file['tmp_name']);
		/* create image from string */
		$image = imagecreatefromstring($imgString);
		$this->tmp = imagecreatetruecolor($width, $height);
		imagecopyresampled($this->tmp, $image,0, 0,$x, 0,$width, $height, $w, $h);
		
		return str_replace('upload/', '', $this->imgsrc);

	}
	
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

}