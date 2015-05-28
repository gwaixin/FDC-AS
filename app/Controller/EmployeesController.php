
<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController {

	public function beforeFilter() {
		$this->layout = 'employee';
	}

	public function dashboard() {

	}

	public function index() {

	}

	public function attendances() {

	}

	public function profile($action = 'view') {
		$this->loadModel('Profile');
		$Profile = $this->Profile->findById($this->Session->read('Auth.UserProfile'));
		$Profile['Profile']['picture'] = 'upload/'.$Profile['Profile']['picture'];
		$Profile['Profile']['signature'] = 'upload/'.$Profile['Profile']['signature'];
		$this->Set('action',$action);
		$file = "profile";
		$errors = array();
		$success = false;
		if($action === 'edit') {
			if($this->request->is('post')) {
				$this->Profile->mode = 1;
				$this->Profile->id = $Profile['Profile']['id'];
				$birthdate = explode('/',$this->request->data['Profile']['birthdate']);
				$this->request->data['Profile']['birthdate'] = $birthdate[2].'-'.$birthdate[0].'-'.$birthdate[1];
				if (!empty($_FILES['file-profile-picture']['name'])) {
					$this->request->data['Profile']['picture'] = $_FILES['file-profile-picture'];
				}

				if (!empty($_FILES['file-signature-picture']['name'])) {
					$this->request->data['Profile']['signature'] = $_FILES['file-signature-picture'];
				}

				$Profile = $this->Profile->findById($Profile['Profile']['id']);
				if(!$this->Profile->save($this->request->data)) {
					$this->request->data['picture'] = $Profile['Profile']['picture'];
					$this->request->data['picture'] = $Profile['Profile']['signature'];
					$Profile = $this->request->data;
					$Profile['Profile']['picture'] = 'img/emptyprofile.jpg' ;
					$errors = $this->Profile->validationErrors;
				} else {
					$this->redirect(array(
															'controller' => 'employees', 
															'action' => 'profile'
															)
														);
				}
			}
			$file = "edit_profile";
		}
		$this->Set('errors',$errors);
		$this->Set($Profile);
		$this->render($file);
	}

	/*public function employee_lists() {
		$this->layout = $layout;
	}*/

	public function accounts() {
		$accounts = $this->Employee->findById($this->Session->read('Auth.UserProfile.id'));
		$this->Set('Accounts', $accounts['Employee']);
	}

	public function employee_lists($layout) {
		$this->layout = $layout;

		$this->loadModel('Position');
		$this->loadModel('Positionlevel');
		$position = $this->Position->find('list', array(
				'fields' => array('id', 'description')
		));

		$positionlevel = $this->Positionlevel->find('list', array(
				'fields' => array('id', 'description')
		));

		$this->set('position', $position);
		$this->set('positionlevel', $positionlevel);
	}

	public function getEmployees() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employee');
			$joins = array(
							        array(
							            'table' => 'profiles',
							            'conditions' => array(
							                'Employee.profile_id = profiles.id'
							            )
							       	 	),
							        array(
													'table' => 'company_systems',
													'type' => 'LEFT',
													'conditions' => array(
															'Employee.company_systems_id = company_systems.id'
													)
												),
											array(
													'table' => 'positions',
													'type' => 'LEFT',
													'conditions' => array(
															'Employee.position_id = positions.id'
													)
												),
											array(
													'table' => 'position_levels',
													'type' => 'LEFT',
													'conditions' => array(
															'Employee.position_level_id = position_levels.id'
													)
												),
											array(
													'table' => 'contract_logs',
													'type' => 'LEFT',
													'conditions' => array(
															'Employee.current_contract_id = contract_logs.id'
													)
												),
											array(
													'table' => 'employee_shifts',
													'type' => 'LEFT',
													'conditions' => array(
															'Employee.employee_shifts_id = employee_shifts.id'
													)
												)
											);
			$conditions = array("concat(profiles.first_name, ' ',profiles.middle_name,' ',profiles.last_name) LIKE '%" . $this->request->data['value'] . "%' and Employee.status != 0");
			switch($this->request->data['field']) {
				case "name":
					$conditions = array("concat(profiles.first_name, ' ',profiles.middle_name,' ',profiles.last_name) LIKE '%" . $this->request->data['value'] . "%' and Employee.status != 0");
				break;
				case "employee_id":
					$conditions = array("employee_id LIKE '%" . $this->request->data['value'] . "%' and Employee.status != 0");
				break;
				case "position":
					if ($this->request->data['value']) {
						$positionLevelCondition = "";
						if ($this->request->data['position_level']) {
							$positionLevelCondition = "and position_levels.description = '" . $this->request->data['position_level'] . "'";
						}
						$conditions = array("positions.description = '" . $this->request->data['value'] . "' $positionLevelCondition and Employee.status != 0");
					}
				break;
				case "status":
					$conditions = array("Employee.status = '" . $this->request->data['value'] . "' and Employee.status != 0");
				break;
			}
			$employees = $this->Employee->find('all',array(
																						'joins' => $joins,
																						'conditions' => $conditions,
																						'fields' => array('*')
																						)
																				);
			$employees_arr = array();
			foreach($employees as $key => $employee) {
			$status = ($employee['Employee']['status'] == 1) ? "Inactive" : "Active";
			
			$data = array(
									'id' => $employee['Employee']['id'],
									'name' => $employee['profiles']['first_name']. " " . $employee['profiles']['middle_name'] . " " .$employee['profiles']['last_name'],
									'employee_id' => $employee['Employee']['employee_id'],
									'company_systems' => $employee['company_systems']['name'],
									'username' => $employee['Employee']['username'],
									'password' => $employee['Employee']['password'],
									'tin' => $employee['Employee']['tin'],
									'salary' => $employee['Employee']['salary'],
									'drug_test' => $employee['Employee']['drug_test'],
									'pagibig' => $employee['Employee']['pagibig'],
									'philhealth' => $employee['Employee']['philhealth'],
									'medical' => $employee['Employee']['medical'],
									'sss' => $employee['Employee']['sss'],
									'insurance_id' => $employee['Employee']['insurance_id'],
									'position' => $employee['positions']['description'],
									'position_level' => $employee['position_levels']['description'],
									'shift' => ($employee['Employee']['employee_shifts_id']) ? $employee['employee_shifts']['description'] : 'Select Shift',
									'shift_id' => ($employee['Employee']['employee_shifts_id']) ? $employee['employee_shifts']['id'] : '',
									'contract' => $employee['contract_logs']['description'],
									'contract_id' => $employee['contract_logs']['id'],
									'role' => $employee['Employee']['role'],
									'status' => $status
								);
			array_push($employees_arr,$data);	
			}
			if (!$employees_arr) {
				$data = array(
										'id' => null,
										'employee_id' => null,
										'company_systems' => null,
										'name' => null,
										'username' => null,
										'password' => null,
										'tin' => null,
										'salary' => null,
										'drug_test' => null,
										'pagibig' => null,
										'philhealth' => null,
										'medical' => null,
										'sss' => null,
										'insurance_id' => null,
										'position' => null,
										'position_level' => null,
										'shift' => null,
										'shift_id' => null,
										'contract' => null,
										'contract_id' => null,
										'role' => null,
										'status' => null
									);
				array_push($employees_arr,$data);
			}
			echo json_encode($employees_arr);
		}
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

	public function getEmployeeShift() {
		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employeeshift');
			$info = $this->Employeeshift->findById($this->request->data['id']);
			$f_time_in = $this->convertTimeToMilitary($info['Employeeshift']['f_time_in']);
			$f_time_out = $this->convertTimeToMilitary($info['Employeeshift']['f_time_out']);
			$l_time_in = ($info['Employeeshift']['l_time_in']) ? $info['Employeeshift']['l_time_out'] : 'None';
			$l_time_out = ($info['Employeeshift']['l_time_out']) ? $info['Employeeshift']['l_time_out'] : 'None';
			$overtime_start = ($info['Employeeshift']['overtime_start']) ? $info['Employeeshift']['overtime_start'] : 'None';
			echo "<h2> Employee Shift Detail </h2>
						<table id='table-shift-detail'>
							<tr>
								<td> Description </td>
								<td> : </td>
								<td>".$info['Employeeshift']['description']."</td>
							</tr>
							<tr>
								<td> First Timein </td>
								<td> : </td>
								<td>".$f_time_in."</td>
							</tr>
							<tr>
								<td> First Timeout </td>
								<td> : </td>
								<td>".$f_time_out."</td>
							</tr>
							<tr>
								<td> Last Timein </td>
								<td> : </td>
								<td>".$l_time_in."</td>
							</tr>
							<tr>
								<td> Last Timeout </td>
								<td> : </td>
								<td>".$l_time_out."</td>
							</tr>
							<tr>
								<td> Overtime Start </td>
								<td> : </td>
								<td>".$overtime_start."</td>
							</tr>
							<tr>
								<td><span class='btn btn-primary' id='btn-change-shift'>Change Shift</span></td>
							</tr>
						</table>";
		}
	}

	public function updateEmployeeShift() {
		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->Employee->id = $this->request->data['id'];
			$data = array(
									'employee_shifts_id' => $this->request->data['shift_id']
								);
			$success = 0;
			if($this->Employee->save($data)) {
				$success = 1;
			}
			echo json_encode($success);
		}
	}

	public function getShiftMasterLists() {
		$this->layout = false;
		$this->loadModel('Employeeshift');
		$lists = $this->Employeeshift->find('all');
		$this->Set('lists',$lists);
		$this->render('employee_shift_lists');
	}

	public function getDropdownValues() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$json['names'] = $this->getNameLists();
			$json['companies'] = $this->getCompanyLists();
			$json['positions'] = $this->getPositionLists();
			$json['positionLevels'] = $this->getPositionLevelLists();
			$json['shiftMaster'] = $this->getShiftLists();
			echo json_encode($json);
		}
	}

	public function getNameLists() {
		$this->autoRender = false;
		$this->loadModel('Profiles');
		$employees = $this->Profiles->find('all',array(
														'conditions' => array("id not in (Select profile_id from employees)"),
														'fields' => array("first_name","middle_name","last_name")
													)
												);
		$names = array();
		foreach($employees as $employee) {
			$name =  $employee['Profiles']['first_name'] . " " . $employee['Profiles']['middle_name'] . " " . $employee['Profiles']['last_name'];
			array_push($names,$name);
		}
		return $names;
	}

	public function getCompanyLists() {
		$this->autoRender = false;
		$this->loadModel('Company_system');
		$companies = $this->Company_system->find('list',array(
																										'conditions' => array("status = '1'"),
																										'fields' => array('name')
																										)
																									);
		$company_lists = array();
		foreach($companies as $company) {
			array_push($company_lists,$company);
		}
		return $company_lists;
	}

	public function getPositionLists() {
		$this->autoRender = false;
		$this->loadModel('Position');
		$positions = $this->Position->find('list',array('fields' => array('description')));
		return $positions;
	}

	public function getPositionLevelLists() {
		$this->autoRender = false;
		$this->loadModel('Position');
		$this->loadModel('Position_level');
		$joins = array(
							 array(
			            'table' => 'position_levels',
			            'conditions' => array(
			                'Position.id = position_levels.positions_id'
			            )
			           )
							);
		$positions = $this->Position->find('all',array(
																								'joins' => $joins,
																								'fields' => array('*')
																							)
																						);
		$positionLevels = array();
		foreach($positions as $position) {
		$data = array(
					'position' => $position['Position']['description'],
					'positionLevel' => $position['position_levels']['description']
				);
			array_push($positionLevels,$data);
		}
		return $positionLevels;
	}

	public function getShiftLists() {
		$this->autoRender = false;
		$this->loadModel('Employeeshift');
		$lists = $this->Employeeshift->find('list',array('fields' => array('description')));
		return $lists;
	}


	public function validateFields() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$employee = $this->request->data['employee'];
			$this->loadModel('Employee');
			$this->Employee->set($employee);
			$validate = $this->Employee->validates();
			$errors = $this->Employee->validationErrors;
			echo json_encode($errors);
		}
	}

	function addEmployee() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$employee = $this->request->data['employee'];
			$this->loadModel('Employee');
			$this->loadModel('Profile');
			$this->loadModel('Position');
			$this->loadModel('Position_level');
			$this->loadModel('Profile');
			$validatedFields = array();
			$employeeInfo = $this->Profile->find('first',array(
															'conditions' => array("concat(first_name,' ',middle_name,' ',last_name) = '$employee[name]'")
														)
													);
			if ($employeeInfo) {
				$saveData = array();
				foreach($employee as $key => $detail) {
					$field = $key;
					$value = $detail;
					if ($key === 'position' || $key === 'position_level') {
						$value = "";
						$field = $field."_id";
						switch($key) {
							case 'company_systems' :
								$company = $this->Company_system->findByName($employee['value']);
								if ($company) {
									$value = $company['Company_system']['id'];
								}
							break;
							case 'position' :
								$searchPosition = $this->Position->findByDescription($value);
								if ($searchPosition) {
									$value = $searchPosition['Position']['id'];
								}
							break;
							case 'position_level' :
								$searchPositionLevel = $this->Position_level->findByPositions_idAndDescription(1,$value);
								if ($searchPositionLevel) {
									$value = $searchPositionLevel['Position_level']['id'];
								}
							break;
						}
					}
					$data = array(
								$key => $value
							);
					if ($key !== 'name' && $key !== 'contract' && $key !== 'id') {
						array_push($validatedFields,$key);
						$this->Employee->set($data);
						if ($this->Employee->validates()) {
							$saveData[$field] = $value;
						}
					}
				}
				$employeeInfo = $employeeInfo['Profile'];
				$status = 1;
				if($employee['status'] === 'Active') {
					$status = 2;
				}
				$saveData['status'] = $status;
				$saveData['profile_id'] = $employeeInfo['id'];
				$this->Employee->validationErrors = array();
				foreach($validatedFields as $field) {
					if ($field !== 'employee_id') {
						$this->Employee->validator()->remove($field);	
					}
				}
				$success = $this->Employee->save($saveData);
				if ($success) {
					$employeeInfo = $this->Employee->findByEmployee_id($employee['employee_id']);
					$employeeInfo = $employeeInfo['Employee'];
					$json['id'] = $employeeInfo['id'];
				} else {
					$success = false;
				}
				$json['success'] = $success;
				echo json_encode($json);
			}
		}
	}

	public function saveAll() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$employees = $this->request->data['employees'];
			$this->loadModel('Employee');
			$this->loadModel('Company_system');
			$this->loadModel('Position');
			$this->loadModel('Position_level');
			$error_arr = array();
			foreach($employees as $employee) {
				$field = $employee['field'];
				$value = $employee['value'];
				if ($field === 'status') {
					$value = "";
					if (strtolower($employee['value']) === 'inactive') {
						$value = 1;
					} else if (strtolower($employee['value']) === 'active') {
						$value = 2;
					}
				}
				if ($field === 'f_time_in' || $field === 'f_time_out' || $field === 'l_time_in' || $field === 'l_time_out') {
					$value = $this->convertTimeToDefault($value);
				}
				if ($field === 'company_systems' || $field === 'position' || $field === 'position_level') {
					$value = "";
					$field = $field."_id";
					switch($employee['field']) {
						case 'company_systems' :
							$company = $this->Company_system->findByName($employee['value']);
							if ($company) {
								$value = $company['Company_system']['id'];
							}
						break;
						case 'position' :
							$searchPosition = $this->Position->findByDescription($employee['value']);
							if ($searchPosition) {
								$value = $searchPosition['Position']['id'];
							}
						break;
						case 'position_level' :
							$position = 0;
							$value = 'NULL';
							$searchPosition = $this->Position->findByDescription($employee['position']);
							if ($searchPosition) {
								$position = $searchPosition['Position']['id'];
								$searchPositionLevel = $this->Position_level->findByPositions_idAndDescription($position,$employee['value']);
								if ($searchPositionLevel) {
									$value = $searchPositionLevel['Position_level']['id'];
								}
							}
						break;
					}
				}
				if($field === 'password') {
					$value = Security::hash($value,'sha1',true);
				}
				$data = array(
							$field => $value
						);
				
				$this->Employee->id = $employee['id'];
				if($field === 'position_level_id' && $value === 'NULL') {
					$this->Employee->saveField('position_level_id', null);
				} else if(!$this->Employee->save($data)) {
					array_push($error_arr,array(
															'field' => $field,
															'value' => $value
																)
															);
				}
			}
			$json['errors'] = $error_arr;
			echo json_encode($json);
		}
	}

	public function updateAdditionInfo() {
		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$employee = $this->request->data['employee'];
			$data = array(
									'tin' => $employee['tin'],
									'drug_test' => $employee['drug_test'],
									'medical' => $employee['medical'],
									'pagibig' => $employee['pagibig'],
									'sss' => $employee['sss'],
									'philhealth' => $employee['philhealth'],
									'insurance_id' => $employee['insurance_id'],
									'username' => $employee['username']
								);
			if(isset($employee['salary'])) {
				$data['salary'] = $employee['salary'];
			}
			if($employee['password'] !== 'company_default_password') {
				$data['password'] = Security::hash($employee['password'],'sha1',true);
			}
			$this->Employee->id = $employee['id'];
			$txtErrors = "";
			if(!$this->Employee->save($data)) {
				$errors = $this->Employee->validationErrors;
				$x = 0 ;
				foreach ($errors as $key => $error) {
					$txtErrors .= ($x === 0) ? $errors[$key][0] : ",<br>".$errors[$key][0];
					$x++;
				}
			}
			echo json_encode($txtErrors);
		}
	}

	function deleteEmployee() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employee');
			$status = array('status' => 0);
			$this->Employee->id = $this->request->data['id'];
			$success = $this->Employee->save($status);
			echo json_encode($success);
		}
	}

}