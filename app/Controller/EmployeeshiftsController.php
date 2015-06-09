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
					$eshift['f_time_in'] 	= !empty($eshift['f_time_in']) 	? date('g:i A', strtotime($eshift['f_time_in'])) 	: '';
					$eshift['f_time_out'] 	= !empty($eshift['f_time_out']) ? date('g:i A', strtotime($eshift['f_time_out'])) 	: '';
					//$eshift['l_time_in'] 	= !empty($eshift['l_time_in']) 	? date('g:i A', strtotime($eshift['l_time_in'])) 	: '';
					//$eshift['l_time_out'] 	= !empty($eshift['l_time_out']) ? date('g:i A', strtotime($eshift['l_time_out'])) 	: '';
					$eshift['overtime_start'] = !empty($eshift['overtime_start']) ? date('g:i A', strtotime($eshift['overtime_start'])) : '';
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
				'description' 	=> $data['Employee_shift']['description'],
				'f_time_in'		=> date('H:i:s', strtotime($ftimein)),
				'f_time_out'	=> date('H:i:s', strtotime($ftimeout))
		);
		if ($id) {
			$eshift['id'] = $id;
		}

		/*if (!empty($data['Employee_shift']['l_time_in']) && !empty($data['Employee_shift']['l_time_out'])) {
			$ltimeinData 	= $data['Employee_shift']['l_time_in'];
			$ltimeOutData 	= $data['Employee_shift']['l_time_out'];
			if ($ltimeinData['hour'] >= 0) {
				$ltimein = $ltimeinData['hour'] 	. ':' . $ltimeinData['min'] 	. ' ' . $ltimeinData['meridian']; //implode(':', $data['Employee_shift']['l_time_in']);
				$ltimeout = $ltimeOutData['hour'] . ':' . $ltimeOutData['min'] 	. ' ' . $ltimeOutData['meridian']; //implode(':', $data['Employee_shift']['l_time_out']);
				$eshift['l_time_in'] 	= date('H:i:s', strtotime($ltimein));
				$eshift['l_time_out'] 	= date('H:i:s', strtotime($ltimeout));
			} else {
				$eshift['l_time_in']	= NULL;
				$eshift['l_time_out']	= NULL;
			}
		}*/
		
		if (isset($data['Employee_shift']['break'])) {
			$break = trim($data['Employee_shift']['break']);
			$eshift['break'] = empty($break) ? NULL : $break;
		}

		if (!empty($data['Employee_shift']['overtime_start'])) {
			$hr = $data['Employee_shift']['overtime_start']['hour'];
			$min = $data['Employee_shift']['overtime_start']['min'];
			$mer = $data['Employee_shift']['overtime_start']['meridian'];
			if ($hr >= 0) {
				$eshift['overtime_start'] = date('H:i:s', strtotime($hr . ':' . $min . ' ' . $mer));
			} else {
				$eshift['overtime_start'] = NULL;
			}
		}

		return $eshift;
	}

	public function getShift() {
		if ($this->request->is('Ajax')) {
			$this->layout = 'ajax';
			$data = $this->request->data;
			if ($data) {
				$this->loadModel('Employeeshift');
				$shift = $this->Employeeshift->find('first', array(
						'conditions' => array('id' => $data['id'])
					)
				);

				$this->set('shift', $shift);
				$this->render('shift_detail');
			} else {
				echo 'No data';
			}

		}
	}

}