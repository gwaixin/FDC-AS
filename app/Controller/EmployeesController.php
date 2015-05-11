
<?php

App::uses('AppController', 'Controller');

class EmployeesController extends AppController {

	public function index() {
	}

	public function get_employees() {

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
										'id' => $employee['Employee']['id'],
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

	public function add_employee() {

		if($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->loadModel('Employee');
			print_r($this->request->data);
			// if($this->Employee->save($this->request->data)) {

			// } else {

			// }
		}

	}

}