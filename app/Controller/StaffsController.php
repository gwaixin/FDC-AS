<?php

App::import('Controller', 'Profiles');
App::import('Controller', 'Employees');
App::import('Controller', 'Attendances');
class StaffsController extends AppController {
	
	
	public function index() {
		
		$this->layout = 'staff';
			
	}
	
	public function employees() {
		
		$this->layout = 'staff';
		
		$this->loadModel('Position');
		$this->loadModel('Positionlevel');

		
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));
		
		$positionlevel = $this->Positionlevel->find('list', array(
				'fields' => array('id', 'description')
		));		
		
		
		$this->set('profile', 1);
		
		$this->set('position', $position);
		$this->set('positionlevel', $positionlevel);
		
		$this->render('/employees/employee_lists');
		
	}
	
	public function attendances() {
		
		$this->layout = 'staff';
		
		$this->render('/attendances/index');
		
	}
	
}