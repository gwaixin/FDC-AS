
<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController {

	public function index() {
	}

	public function getEmployees() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employee');
			$joins = array(
							        array(
							            'table' => 'profiles',
							            'conditions' => array(
							                'employee.profile_id = profiles.id'
							            )
							       	 	),
											array(
													'table' => 'positions',
													'conditions' => array(
															'employee.position_id = positions.id'
													)
												),
											array(
													'table' => 'position_levels',
													'conditions' => array(
															'employee.position_level_id = position_levels.id'
													)
												),
											array(
													'table' => 'contract_logs',
													'type' => 'LEFT',
													'conditions' => array(
															'employee.id = contract_logs.employees_id'
													)
												)
											);
			$conditions = array("concat(profiles.first_name, ' ',profiles.middle_name,' ',profiles.last_name) LIKE '%" . $this->request->data['value'] . "%' and employee.status != 0");
			switch($this->request->data['field']) {
				case "name":
					$conditions = array("concat(profiles.first_name, ' ',profiles.middle_name,' ',profiles.last_name) LIKE '%" . $this->request->data['value'] . "%' and employee.status != 0");
				break;
				case "employee_id":
					$conditions = array("employee_id LIKE '%" . $this->request->data['value'] . "%' and employee.status != 0");
				break;
				case "position":
					if($this->request->data['value']) {
						$positionLevelCondition = "";
						if($this->request->data['position_level']) {
							$positionLevelCondition = "and position_levels.description = '" . $this->request->data['position_level'] . "'";
						}
						$conditions = array("positions.description = '" . $this->request->data['value'] . "' $positionLevelCondition and employee.status != 0");
					}
				break;
				case "status":
					$conditions = array("employee.status = '" . $this->request->data['value'] . "' and employee.status != 0");
				break;
			}
			$employees = $this->Employee->find('all',array(
																						'joins' => $joins,
																						'conditions' => $conditions,
																						'fields' => array('*')
																						)
																				);
			$employees_arr = [];
			foreach($employees as $key => $employee) {
				$status = "Trash";
				$status = ($employee['Employee']['status'] == 1) ? "Inactive" : "Active";
				$data = array(
										'id' => $employee['Employee']['id'],
										'name' => $employee['profiles']['first_name']. " " . $employee['profiles']['middle_name'] . " " .$employee['profiles']['last_name'],
										'employee_id' => $employee['Employee']['employee_id'],
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
										'contract' => $employee['contract_logs']['description'],
										'f_time_in' => $employee['Employee']['f_time_in'],
										'f_time_out' => $employee['Employee']['f_time_out'],
										'l_time_in' => $employee['Employee']['l_time_in'],
										'l_time_out' => $employee['Employee']['l_time_out'],
										'role' => $employee['Employee']['role'],
										'status' => $status
									);
				array_push($employees_arr,$data);
			}
			if(!$employees_arr) {
				$data = array(
										'id' => null,
										'employee_id' => null,
										'name' => null,
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
										'contract' => null,
										'f_time_in' => null,
										'f_time_out' => null,
										'l_time_in' => null,
										'l_time_out' => null,
										'role' => null,
										'status' => null
									);
				array_push($employees_arr,$data);
			}
			echo json_encode($employees_arr);
		}

	}

	public function getDropdownValues() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$json['names'] = $this->suggestNameLists();
			$json['positions'] = $this->getPositionLists();
			$json['positionLevels'] = $this->getPositionLevelLists();
			echo json_encode($json);
		}

	}

	public function suggestNameLists() {

		$this->autoRender = false;
		$this->loadModel('Profiles');
		$employees = $this->Profiles->find('all',array(
																								'conditions' => array("id not in (Select profile_id from employees)")
																							)
																						);
		$names = [];
		foreach($employees as $employee) {
			$name =  $employee['Profiles']['first_name'] . " " . $employee['Profiles']['middle_name'] . " " . $employee['Profiles']['last_name'];
			array_push($names,$name);
		}
		return $names;

	}

	public function suggestNames() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Profiles');
			$employees = $this->Profiles->find('all',array(
																									'conditions' => array("id not in (Select profile_id from employees)")
																								)
																							);
			$names = [];
			foreach($employees as $employee) {
				$name =  $employee['Profiles']['first_name'] . " " . $employee['Profiles']['middle_name'] . " " . $employee['Profiles']['last_name'];
				array_push($names,$name);
			}
			return $names;
		}

	}

	public function getPositionLists() {

		$this->autoRender = false;
		$this->loadModel('Position');
		$positions = $this->Position->find('all');
		$position_arr = [];
		foreach($positions as $position) {
			array_push($position_arr,$position['Position']['description']);
		}
		return $position_arr;

	}

	public function getPositionLevelLists() {

			$this->autoRender = false;
			$this->loadModel('Position');
			$this->loadModel('Position_level');
			$level_arr = [];
			$levels = $this->Position_level->find('all',array(
																										'fields' => array('distinct(description)')
																										)
																									);
			foreach($levels as $level) {
				array_push($level_arr,$level['Position_level']['description']);
			}
			return $level_arr;

	}

	public function validateFields() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$employee = $this->request->data['employee'];
			$this->loadModel('Employee');
			$this->Employee->set($employee);
			$validate = $this->Employee->validates();
			$errors = $this->Employee->validationErrors;
			echo json_encode($errors);
		}

	}

	public function saveChanges() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employee');
			$this->loadModel('Profile');
			$this->loadModel('Position');
			$this->loadModel('Position_level');
			$employee = $this->request->data['employee'];
			$action = "edit";
			$position = "";
			$searchPosition = $this->Position->findByDescription($employee['position']);
			if($searchPosition) {
				$position = $searchPosition['Position']['id'];
			}
			$position_level = "";
			$searchPositionLevel = $this->Position_level->find('first',array(
																																	'conditions' => array("positions_id = '$position' and description = '" . $employee['position_level'] . "'")
																																)
																															);
			if($searchPositionLevel) {
				$position_level = $searchPositionLevel['Position_level']['id'];
			}
			$error = "";
			$status = 0;
			if($employee['status'] === "Inactive") {
				$status = 1;
			} else if($employee['status'] === "Active") {
				$status = 2;
			}
			$id = (isset($employee['id'])) ? $employee['id'] : 0;
			$exists = $this->Employee->findById($id);
			if($exists) {
				$this->Employee->id = $employee['id'];
				$data = array(
								'employee_id' => $employee['employee_id'],
								'tin' => $employee['tin'],
								'salary' => $employee['salary'],
								'drug_test' => $employee['drug_test'],
								'pagibig' => $employee['pagibig'],
								'philhealth' => $employee['philhealth'],
								'medical' => $employee['medical'],
								'sss' => $employee['sss'],
								'insurance_id' => $employee['insurance_id'],
								'position_id' => $position,
								'position_level_id' => $position_level,
								'current_contract' => 'null',
								'f_time_in' => $employee['f_time_in'],
								'f_time_out' => $employee['f_time_out'],
								'l_time_in' => $employee['l_time_in'],
								'l_time_out' => $employee['l_time_out'],
								'role' => $employee['role'],
								'status' => $status
							);
				if(!$this->Employee->save($data)) {
					$error = 1;
				}
			} else {
				$profile_id = "";
				$employeeInfo = $this->Profile->find('first',array(
																									'conditions' => array("concat(first_name,' ',middle_name,' ',last_name) LIKE '%".$employee['name']."%'")
																								)
																							);
				
				if($employeeInfo) {
					$profile_id = $employeeInfo['Profile']['id'];
				}
				$data = array(
							'employee_id' => $employee['employee_id'],
							'profile_id' => $profile_id,
							'tin' => $employee['tin'],
							'salary' => $employee['salary'],
							'drug_test' => $employee['drug_test'],
							'pagibig' => $employee['pagibig'],
							'philhealth' => $employee['philhealth'],
							'sss' => $employee['sss'],
							'insurance_id' => $employee['insurance_id'],
							'position_id' => $position,
							'position_level_id' => $position_level,
							'current_contract' => 'null',
							'f_time_in' => $employee['f_time_in'],
							'f_time_out' => $employee['f_time_out'],
							'l_time_in' => $employee['l_time_in'],
							'l_time_out' => $employee['l_time_out'],
							'role' => $employee['role'],
							'status' => $status
						);
				if(!$this->Employee->save($data)) {
					$error = 1;
				} else {
					$action = "add";
					$employeeInfo = $this->Employee->findByEmployee_id($employee['employee_id']);
					$json['id'] = $employeeInfo['Employee']['id'];
				}
			}
			$json['error'] = $error;
			$json['action'] = $action;
			echo json_encode($json);
		}

	}

	function deleteEmployee() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employee');
			$status = array('status' => 0);
			$this->Employee->id = $this->request->data['id'];
			$success = $this->Employee->save($status);
			echo json_encode($success);
		}

	}

}