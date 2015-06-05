
<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController {
	
	public function employee_lists($layout = '') {
		if (!empty($layout)) {
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
		} else {
			$this->redirect(array(
													'controller' => 'main'
												)
											);
		}
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
     	 	),array(
					'table' => 'company_systems',
					'type' => 'LEFT',
					'conditions' => array(
							'Employee.company_systems_id = company_systems.id'
					)
				),array(
					'table' => 'positions',
					'type' => 'LEFT',
					'conditions' => array(
							'Employee.position_id = positions.id'
					)
				),array(
					'table' => 'position_levels',
					'type' => 'LEFT',
					'conditions' => array(
							'Employee.position_level_id = position_levels.id'
					)
				),array(
					'table' => 'roles',
					'type' => 'LEFT',
					'conditions' => array(
							'Employee.role = roles.id'
					)
				),array(
					'table' => 'contract_logs',
					'type' => 'LEFT',
					'conditions' => array(
							'Employee.current_contract_id = contract_logs.id'
					)
				),array(
					'table' => 'employee_shifts',
					'type' => 'LEFT',
					'conditions' => array(
							'Employee.employee_shifts_id = employee_shifts.id'
					)
				)
			);
			$conditions = array("concat(profiles.first_name, ' ',profiles.middle_name,' ',profiles.last_name) LIKE '%" . addslashes($this->request->data['value']) . "%' and Employee.status != 0");
			switch($this->request->data['field']) {
				case "name":
					$conditions = array("concat(profiles.first_name, ' ',profiles.middle_name,' ',profiles.last_name) LIKE '%" . addslashes($this->request->data['value']) . "%' and Employee.status != 0");
				break;
				case "nick-name":
					$conditions = array("profiles.nick_name LIKE '%" . addslashes($this->request->data['value']) . "%' and Employee.status != 0");
				break;
				case "employee-id":
					$conditions = array('AND' => 
																	array("employee_id LIKE '%" . addslashes($this->request->data['value']) . "%'"),
																	array('Employee.status != 0')
															);
				break;
				case "position":
					if ($this->request->data['value']) {
						$conditions = array('AND' => 
																		array('positions.description' => $this->request->data['value'])
																);
						if ($this->request->data['position_level']) {
							$positionLevelCondition = array('position_levels.description' => $this->request->data['position_level']);
							array_push($conditions['AND'],$positionLevelCondition);
						}
					}
				break;
				case "status":
					$conditions = array('Employee.status' => $this->request->data['value']);
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
			$status = 'Trashed';
			if ($employee['Employee']['status'] == 1) {
				$status = "Inactive";
			} else if ($employee['Employee']['status'] == 2) {
				$status = "Active";
			}
			$picture = "<img src='".$this->webroot."img/emptyprofile.jpg.'>";
			if(!empty($employee['profiles']['picture'])) {
				$picture = "<img src='".$this->webroot. "upload/".$employee['profiles']['picture']."'>";
			}
			$data = array('id' => $employee['Employee']['id'],
									  'name' => $employee['profiles']['first_name']. " " . $employee['profiles']['middle_name'] . " " .$employee['profiles']['last_name'],
									  'nick_name' => $employee['profiles']['nick_name'],
										'picture' => $picture,
										'employee_id' => $employee['Employee']['employee_id'],
										'profile_id' => $employee['profiles']['id'],
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
										'role' => $employee['roles']['description'],
										'status' => $status,
										'btnAction' => '<a class="btn btn-default btn-view-employee" data-toggle="modal" data-target="#modalAccounts"> <i class="icon-briefcase"></i>Accounts</a>
																	  <a class="btn btn-default btn-view-profile" data-toggle="modal" data-target="#modalProfile" onclick="viewProfile('.$employee['Employee']['profile_id'].')"> <i class="icon-user"></i>Profile</a>'
								);
			array_push($employees_arr,$data);	
			}
			if (!$employees_arr) {
				$data = array('id' => null,
											'employee_id' => null,
											'company_systems' => null,
											'profile_id' => null,
											'name' => null,
											'nick_name' => null,
											'picture' => null,
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
											'status' => null,
											'btnAction' => ''
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
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employeeshift');
			$info = $this->Employeeshift->findById($this->request->data['id']);
			$f_time_in = ($info['Employeeshift']['f_time_in']) ? $this->convertTimeToMilitary($info['Employeeshift']['f_time_in']) : '--:-- --';
			$f_time_out = ($info['Employeeshift']['f_time_out']) ? $this->convertTimeToMilitary($info['Employeeshift']['f_time_out']) : '--:-- --';
			$break = ($info['Employeeshift']['break'] && $info['Employeeshift']['break'] !== '00:00:00') ? $info['Employeeshift']['break'] : '--:--:--';
			$overtime_start = ($info['Employeeshift']['overtime_start']) ? $this->convertTimeToMilitary($info['Employeeshift']['overtime_start']) : '--:-- --';
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
								<td> Break </td>
								<td> : </td>
								<td>".$break."</td>
							</tr>
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
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->Employee->id = $this->request->data['id'];
			$data = array(
								'employee_shifts_id' => $this->request->data['shift_id']
							);
			$success = 0;
			if ($this->Employee->save($data)) {
				$success = 1;
			}
			echo json_encode($success);
		}
	}

	public function getEmployeeProfile() {
		$id = $this->request->data['id'];
		$this->loadModel('Profile');
		$Profile = $this->Profile->findById($id);
		$Profile['Profile']['id'] = $id;
		if(!empty($Profile['Profile']['picture'])) {
			$Profile['Profile']['picture'] = $this->webroot.'upload/'.$Profile['Profile']['picture'];
		} else {
			$Profile['Profile']['picture'] = $this->webroot.'img/emptyprofile.jpeg';
		}
		$this->layout = false;
		$this->Set($Profile);
		$this->render('employee_profile');
	}

	public function updateEmployeeProfile() {
		$this->autoRender = false;
		$this->loadModel('Profile');
		$this->Profile->id = $this->request->data['Profile']['id'];
		if (!empty($_FILES['file-profile-picture']['name'])) {
			$this->request->data['Profile']['picture'] = $_FILES['file-profile-picture'];
		}
		if (!empty($_FILES['file-profile-picture']['name'])) {
			$this->request->data['Profile']['picture'] = $_FILES['file-profile-picture'];
		}
		if($this->request->data['Profile']['birthdate']) {
			$birthdate = split('/',$this->request->data['Profile']['birthdate']);
			$this->request->data['Profile']['birthdate'] = $birthdate[2].'-'.$birthdate[0].'-'.$birthdate[1];
		}
		$errors = array();
		if(!$this->Profile->save($this->request->data['Profile'])) {
			$errors = $this->Profile->validationErrors;
		}
		echo json_encode($errors);
	}

	public function getShiftMasterLists() {
		$this->layout = false;
		$this->loadModel('Employeeshift');
		$lists = $this->Employeeshift->find('all');
		$shift_lists = array();
		foreach($lists as $list) {
			$row = $list['Employeeshift'];
			$row['f_time_in'] = (strlen($row['f_time_in']) > 0) ? $this->convertTimeToMilitary($row['f_time_in']) : '--:-- --';
			$row['f_time_out'] = (strlen($row['f_time_out']) > 0) ? $this->convertTimeToMilitary($row['f_time_out']) : '--:-- --';
			$row['overtime_start'] = (strlen($row['overtime_start']) > 0) ? $this->convertTimeToMilitary($row['overtime_start']) : '--:-- --';
			$row['break'] = ($row['break'] && $row['break'] !== '00:00:00') ? $row['break'] : '--:--:--';
			$data['Employeeshift'] = $row;
			array_push($shift_lists,$data);
		}
		$this->Set('lists',$shift_lists);
		$this->render('employee_shift_lists');
	}

	public function getDropdownValues() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$json['names'] = $this->getNameLists();
			$json['companies'] = $this->getCompanyLists();
			$json['positions'] = $this->getPositionLists();
			$json['positionLevels'] = $this->getPositionLevelLists();
			$json['roles'] = $this->getRoleLists();
			$json['shiftMaster'] = $this->getShiftLists();
			$json['role'] = $this->Session->read('Auth.Rights.role');
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
																							'conditions' => array(
																									'status' => 1
																							),
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
																						'fields' => array('Position.description','position_levels.description')
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

	public function getRoleLists() {
		$this->autoRender = false;
		$this->loadModel('Role');
		$roles = $this->Role->find('list',array(
																	'conditions' => array(
																			'status' => 1
																		),
																	'fields' => array('description')
																	)
																);
		$roles_arr = array();
		foreach($roles as $role) {
			array_push($roles_arr, $role);
		}
		return $roles_arr;
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
															'conditions' => array("concat(first_name,' ',middle_name,' ',last_name) = '".addslashes($employee['name'])."'")
														)
													);
			if ($employeeInfo) {
				$saveData = array();
				foreach($employee as $key => $detail) {
					$field = $key;
					$value = $detail;
					if ($key === 'position' || $key === 'position_level' || $key === 'role') {
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
							case 'role' :
							$field = 'role';
							$searchRole = $this->Role->findByDescription($detail);
							if ($searchRole) {
								$value = $searchRole['Role']['id'];
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
				if ($employee['status'] === 'Active') {
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
					$this->loadModel('Profile');
					$Profile = $this->Profile->findById($employeeInfo['profile_id']);
					$Profile = $Profile['Profile'];
					$json['profile_id'] = $employeeInfo['id'];
					$json['id'] = $employeeInfo['id'];
					$json['picture'] = "<img src='".$this->webroot."img/emptyprofile.jpg'>";
					$json['nick_name'] = $Profile['nick_name'];
					if(!empty($Profile['picture'])) {
						$json['picture'] = "<img src='".$this->webroot."upload/".$Profile['picture']."'>";
					}
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
			$this->loadModel('Role');
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
				if ($field === 'company_systems' || $field === 'position' || $field === 'position_level' || 
						$field === 'role') {
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
						case 'role' :
							$field = 'role';
							$searchRole = $this->Role->findByDescription($employee['value']);
							if ($searchRole) {
								$value = $searchRole['Role']['id'];
							}
						break;
					}
				}
				if ($field === 'password') {
					$value = Security::hash($value,'sha1',true);
				}
				$data = array(
							$field => $value
						);

				$this->Employee->id = $employee['id'];
				if ($field === 'position_level_id' && $value === 'NULL') {
					$this->Employee->saveField('position_level_id', null);
				} else {
					$this->Employee->save($data);
				}
			}
			$json['errors'] = $error_arr;
			echo json_encode($json);
		}
	}

	public function updateAdditionInfo() {
		if ($this->request->is('ajax')) {
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
			if ($employee['password'] !== 'company_default_password') {
				$data['password'] = $employee['password'];
			}
			$this->Employee->id = $employee['id'];
			$txtErrors = "";
			if (!$this->Employee->save($data)) {
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