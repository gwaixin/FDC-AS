<?php
App::uses('AppController', 'Controller');
App::uses('AttendancesController', 'Controller');
class AdminController extends AppController {
	
	public function beforeRender() {
		parent::beforeRender();
		$this->layout = 'main';
	}
	
	public function index() {
		$this->loadModel('Position');
		$positions = $this->Position->find('list', array( 
				'fields' 		=> array('id', 'description'),
				'conditions' 	=> array('status = 2')
			)
		);
		$this->set('positions', $positions);
	}
	
	public function viewAttendance() {
		//$this->set('title', 'FDC : ATTENDANCE');
		$clientdata = $this->requestAction('/Attendances/index');
		echo $clientdata;
		exit();
	}
}