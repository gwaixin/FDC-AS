
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
													'conditions' => array(
															'employee.current_contract_id = contract_logs.id'
													)
												)
											);
			$employees = $this->Employee->find('all',array(
																						'joins' => $joins,
																						'fields' => array('*')
																						)
																				);
			$employees_arr = [];
			foreach($employees as $key => $employee) {
				$data = array(
										'id' => $employee['Employee']['profile_id'],
										'employee_id' => $employee['Employee']['id'],
										'name' => $employee['profiles']['first_name']. " " . $employee['profiles']['middle_name'] . " " .$employee['profiles']['last_name'],
										'tin' => $employee['Employee']['tin'],
										'salary' => $employee['Employee']['salary'],
										'drug_test' => $employee['Employee']['drug_test'],
										'pagibig' => $employee['Employee']['pagibig'],
										'philhealth' => $employee['Employee']['philhealth'],
										'sss' => $employee['Employee']['sss'],
										'insurance_id' => $employee['Employee']['insurance_id'],
										'position' => $employee['positions']['description'],
										'position_level' => $employee['position_levels']['description'],
										'contract' => $employee['contract_logs']['description'],
									);
				array_push($employees_arr,$data);
			}
			echo json_encode($employees_arr);
		}

	}

	public function suggestNames() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Profiles');
			$employees = $this->Profiles->find('all',array(
																									'conditions' => array("concat(first_name,' ',middle_name,' ',last_name) LIKE '%".$this->request->data['name']."%' 
																									 and id not in (Select profile_id from employees)")
																								)
																							);
			$names = [];
			echo "<option value=''> Employees </option>";
			foreach($employees as $employee) {
				$name =  $employee['Profiles']['first_name'] . " " . $employee['Profiles']['middle_name'] . " " . $employee['Profiles']['last_name'];
				echo "<option value='$name'> $name </option>";
			}
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
			$position = "";
			$searchPosition = $this->Position->findByDescription($employee['position']);
			if($searchPosition) {
				$position = $searchPosition['Position']['id'];
			}
			$position_level = "";
			$searchPositionLevel = $this->Position_level->findByDescription($employee['position_level']);
			if($searchPositionLevel) {
				$position_level = $searchPositionLevel['Position_level']['id'];
			}
			$exists = $this->Employee->findByProfile_id($employee['id']);
			if($exists) {
				$this->Employee->id = $employee['employee_id'];
				$data = array(
								'id' => $employee['employee_id'],
								'tin' => $employee['tin'],
								'salary' => $employee['salary'],
								'drug_test' => $employee['drug_test'],
								'pagibig' => $employee['pagibig'],
								'philhealth' => $employee['philhealth'],
								'sss' => $employee['sss'],
								'insurance_id' => $employee['insurance_id'],
								'position_id' => $position,
								'position_level_id' => $position_level,
								'current_contract' => 1
							);
				$this->Employee->save($data);
			} else {
				$employee_id = "";
				$employeeInfo = $this->Profile->find('first',array(
																									'conditions' => array("concat(first_name,' ',middle_name,' ',last_name) LIKE '%".$employee['name']."%'")
																								)
																							);
				
				if($employeeInfo) {
					$employee_id = $employeeInfo['Profile']['id'];
				}
				$data = array(
							'id' => $employee['employee_id'],
							'profile_id' => $employee_id,
							'tin' => $employee['tin'],
							'salary' => $employee['salary'],
							'drug_test' => $employee['drug_test'],
							'pagibig' => $employee['pagibig'],
							'philhealth' => $employee['philhealth'],
							'sss' => $employee['sss'],
							'insurance_id' => $employee['insurance_id'],
							'position_id' => $position['id'],
							'position_level_id' => $position_level['id'],
							'current_contract' => 1
						);
				print_r($data);
				//$this->Employee->save($data);
			}
		}

	}

}