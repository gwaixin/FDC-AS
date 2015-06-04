
<?php

App::uses('AppController', 'Controller');
App::uses('sss', 'Lib');

class EmployeeController extends AppController {

	public function dashboard() {
		$this->layout = 'employee';
	}

	public function index() {
		$this->layout = 'employee';
		$this->render('dashboard');
	}

	public function convertTimeToMilitary($time = '') {
		if (!empty($time) && $time !== '00:00:00') {
			$this->autoRender = false;
			$split_time = split(':',$time);
			$hours = (int)$split_time[0];
			$minutes = $split_time[1];
			$period = 'AM';
			if ($hours >= 12) {
				if ($hours > 12) {
					$hours -= 12;
					$period = 'PM';
				}
			}
			if ($hours == 12 && $period === 'AM') {
				$period = 'PM';
			}
			$time = $hours.':'.$minutes.' '.$period;
			return $time;
		} else {
			return '';
		}
	}

	function convertTimeToDefault($time = '') {
		if ($time) {
			$time_split = split(':',$time);
			$hours = (int)$time_split[0];
			$minutes = $time_split[1];
			$time_split = split(' ',$time);
			$period = $time_split[1];
			if ($period === 'PM' && $hours !== 12) {
				$hours += 12;
			}
			if ($hours < 10) {
				$hours = '0'.$hours;
			}
			if ($hours == '00') {
				$hours = '12';
			}
			$time = $hours.':'.$minutes;
			return $time;
		}
	}
	public function myprofile($action = 'view',$role = null) {
		$this->layout = 'employee';
		if($role !== null) {
			$this->layout = $role;
		}
		$this->loadModel('Profile');
		$Profile = $this->Profile->findById($this->Session->read('Auth.UserProfile'));
		$Profile['Profile']['picture'] = 'upload/'.$Profile['Profile']['picture'];
		$Profile['Profile']['signature'] = 'upload/'.$Profile['Profile']['signature'];
		$this->Set('action',$action);
		$file = "profile";
		$errors = array();
		$success = false;
		if ($action === 'edit') {
			if ($this->request->is('post')) {
				$this->Profile->mode = 1;
				$this->Profile->id = $Profile['Profile']['id'];
				$birthdate = explode('/',$this->request->data['Profile']['birthdate']);
				$this->request->data['Profile']['birthdate'] = $birthdate[2].'-'.$birthdate[0].'-'.$birthdate[1];
				if (!empty($_FILES['file-profile-picture']['name'])) {
					$this->request->data['Profile']['picture'] = $_FILES['file-profile-picture'];
				}

				$Profile = $this->Profile->findById($Profile['Profile']['id']);
				if (!$this->Profile->save($this->request->data)) {
					$this->request->data['picture'] = $Profile['Profile']['picture'];
					$this->request->data['picture'] = $Profile['Profile']['signature'];
					$Profile = $this->request->data;
					$Profile['Profile']['picture'] = 'img/emptyprofile.jpg' ;
					$errors = $this->Profile->validationErrors;
				} else {
					$this->redirect($this->webroot.$this->Session->read('Auth.Rights.role')."/myprofile");
				}
			}
			$file = "edit_profile";
		}
		$this->Set('errors',$errors);
		$this->Set($Profile);
		$this->render($file);
	}

	public function mycontracts($role = null) {
		$this->loadModel('Contractlog');
		$conditions = array('AND' => array(
															array('\'' . date('Y-m-d h:i:s') .'\' >= date_start'),
															array('\'' . date('Y-m-d h:i:s') .'\' <= date_end'),
															array('Contractlog.id = (Select current_contract_id from employees where id = \''.$this->Session->read('Auth.UserProfile.employee_id').'\')'),
															array('Contractlog.status' => 1)
														)
													);
		$joins = array(
								array(
									'table' => 'positions',
									'conditions' => array('Contractlog.positions_id = positions.id')
								),
								array(
									'table' => 'position_levels',
									'conditions' => array('Contractlog.position_levels_id = position_levels.id')
								)
							);

		$current_contract = $this->Contractlog->find('all',array(
																											'joins' => $joins,
																											'conditions' => $conditions,
																											'limit' => array(1),
																											'fields' => array('description','date_start','date_end','Contractlog.salary',
																																				'document','deminise','term','positions.description',
																																				'position_levels.description')
																											)
																										);
		$contracts = $this->Contractlog->find('all',array(
																							'joins' => $joins,
																							'conditions' => array(
																									'employees_id' => $this->Session->read('Auth.UserProfile.employee_id')
																								),
																							'fields' => array('Contractlog.description','Contractlog.date_start','Contractlog.date_end',
																																'Contractlog.salary','Contractlog.document','Contractlog.deminise','Contractlog.term',
																																'Contractlog.status','positions.description','position_levels.description'),
																							'order' => array('Contractlog.date_start ASC'))
																						);
		$this->Set('data',$contracts);
		$this->Set('currentContract',$current_contract);
		if($role === null) {
			$this->layout = 'employee';
		} else {
			$this->layout = $role;
		}
	}

	public function myaccounts($role = null) {
		if($role === null) {
			$this->layout = 'employee';
		} else {
			$this->layout = $role;
		}
		$accounts = $this->Employee->findById($this->Session->read('Auth.UserProfile.employee_id'));
		$this->Set('Accounts', $accounts['Employee']);
	}

}