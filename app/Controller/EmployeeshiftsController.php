<?php
App::uses('AppController', 'Controller');
class EmployeeshiftsController extends AppController {
	
	public function create() {
		$this->layout = 'admin';
		if ($this->request->is('post')) {
			$data 		= $this->request->data;
			$ftimein 	= implode(':', $data['Employee_shift']['ftime_in']);
			$ftimeout 	= implode(':', $data['Employee_shift']['ftime_out']);
			$ltimein 	= implode(':', $data['Employee_shift']['ltime_in']);
			$ltimeout 	= implode(':', $data['Employee_shift']['ltime_out']);
			
			$eshift = array(
				'description' => $data['Employee_shift']['description'],
				'ftime_in'	=> $ftimein,
				'ftime_out'	=> $ftimeout,
				'ltime_in'	=> $ltimein,
				'ltime_out'	=> $ltimeout
			);
			if ($this->Employeeshift->save($eshift)) {
				$this->Session->setFlash(__('New shift created.'));
				return $this->redirect(array('controller' => 'admin', 'action' => 'createshift'));
			} else {
				$this->Session->setFlash(__($this->Employeeshifts->validationErrors['description']));
			}
		}
	}
}