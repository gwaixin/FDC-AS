<?php
App::uses('AppController', 'Controller');
class EmployeeshiftsController extends AppController {
	
	public $components = array('Paginator');
	
	public $paginate = array('limit' => 5);

	public function create() {
		$this->layout = 'admin';
		if ($this->request->is('post')) {
			$data 	= $this->request->data;
			$eshift = $this->convertData($data);
			
			
			if ($this->Employeeshift->save($eshift)) {
				$this->Session->setFlash(__('New shift created.'));
				return $this->redirect(array('controller' => 'admin', 'action' => 'create_shift'));
			} else {
				$errors = $this->Employeeshift->validationErrors;
				$errStr = "";
				foreach ($errors as $key => $val) {
					$errDetail = implode(", ", $val);
					$errStr .= $errDetail . '<br/>'; 
				}
				$this->Session->setFlash(__($errStr));
				//$this->redirect(array('controller' => 'admin', 'action' => 'create_shift'));
			}
		}
	}

	public function listShift($layout) {
		$this->Paginator->settings = array(
			'conditions' => array('status' => 1),
			'limit' => 5
		);
		$data = $this->Paginator->paginate('Employeeshift');
		$this->layout = $layout;
		$this->set(compact('data'));
	}

	public function delete() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->Employeeshift->id = $data['id'];
			$shiftData = array('Employeeshift' => array('status' => 0));
			if ($this->Employeeshift->save($shiftData)) {
				echo 'success';
			} else {
				echo 'fail';
			}
		}
	}

	public function edit() {
		if ($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$data = $this->request->data;
			if ($data) {
				$result = $this->Employeeshift->find('first', array(
					'conditions' => array('id' => $data['id'])
					)
				);
				$this->set('shift', $result);
				$this->render('form');
			} 
			return;
		}
	}

	public function update($id) {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$eshift = $this->convertData($data, $id);
			if ($eshift && $id) {
				$this->Employeeshift->id = $id;
				if ($this->Employeeshift->save($eshift)) {
					$result = array('result' => 'success', 'changes' => $eshift);
				} else {
					$errors = $this->Employeeshift->validationErrors;
					$errStr = "";
					foreach ($errors as $key => $val) {
						$errDetail = implode(", ", $val);
						$errStr .= $errDetail . '<br/>'; 
					}
					$result = array('result' => 'fail', 'error' => $errStr);
				}
				echo json_encode($result);
			}
		}
		
	} 

	//Convert data to db expected result
	private function convertData($data, $id = "") {
		$ftimeinData = $data['Employee_shift']['f_time_in'];
		$ftimeoutData = $data['Employee_shift']['f_time_out'];

		$ftimein 	= $ftimeinData['hour'] 	. ':' . $ftimeinData['min'] 	. ' ' . $ftimeinData['meridian']; //implode(':', $ftimeinData);
		$ftimeout 	= $ftimeoutData['hour'] . ':' . $ftimeoutData['min']  	. ' ' . $ftimeoutData['meridian']; //implode(':', $data['Employee_shift']['f_time_out']);
		
		$eshift = array(
				'description' => $data['Employee_shift']['description'],
				'f_time_in'	=> date('H:i:s', strtotime($ftimein)),
				'f_time_out'	=> date('H:i:s', strtotime($ftimeout)),
		);
		if (!empty($data['Employee_shift']['l_time_in']) && !empty($data['Employee_shift']['l_time_out'])) {
			$ltimeinData 	= $data['Employee_shift']['l_time_in'];
			$ltimeOutData 	= $data['Employee_shift']['l_time_out'];
			$ltimein 		= $ltimeinData['hour'] 	. ':' . $ltimeinData['min'] 	. ' ' . $ltimeinData['meridian']; //implode(':', $data['Employee_shift']['l_time_in']);
			$ltimeout 		= $ltimeOutData['hour'] . ':' . $ltimeOutData['min'] 	. ' ' . $ltimeOutData['meridian']; //implode(':', $data['Employee_shift']['l_time_out']);
			$eshift['l_time_in'] 	= date('H:i:s', strtotime($ltimein));
			$eshift['l_time_out'] 	= date('H:i:s', strtotime($ltimeout));
		}
		if ($id) {
			$eshift['id'] = $id;
		}
		return $eshift;
	}

}