<?php
App::uses('AppController', 'Controller');
App::uses('AttendancesController', 'Controller');
class AdminController extends AppController {
	
	/*public function beforeRender() {
		parent::beforeRender();
		
	}*/
	
	public function index() {
		$this->layout = 'main';
		$this->loadModel('Position');
		$positions = $this->Position->find('list', array( 
				'fields' 		=> array('id', 'description'),
				'conditions' 	=> array('status = 2')
			)
		);
		$this->set('positions', $positions);
	}
	
	public function getAllPosition() {
		if ($this->request->is('Ajax')) {
			//$this->autoRender = false;
			$this->layout = 'ajax';
			
			$this->loadModel('Position');
			$positions = $this->Position->find('list', array( 
					'fields' 		=> array('id', 'description'),
					'conditions' 	=> array('status = 2')
				)
			);
			$this->set('positions', $positions);
			$this->render('Positions/all_positions');
			return;
			//exit();
		}
		
	}
	
	public function testing() {
		$this->autoRender = false;
		$auth = $this->Session->read('Auth');
		
	}
	
	/*public function viewAttendance() {
		//$this->set('title', 'FDC : ATTENDANCE');
		$clientdata = $this->requestAction('/Attendances/index');
		echo $clientdata;
		exit();
	}*/
}