<?php 
class HolidaysController extends AppController {
	public $uses = array('Holiday');
	public function index() {
		$this->layout = 'admin';
		$holidays = $this->Holiday->find('all',array('conditions'=>array('status'=>1)));
		$this->set('holidays',$holidays);
	}
	public function createHoliday() {
		$this->autoRender = false;
		if($this->request->is('ajax')) {
			$data = array(
				'date' => $this->request->data('date'),
				'description' => $this->request->data('description'),
				'rate' =>$this->request->data('rate'),
				'recurring' => $this->request->data('recurring'),
				'created_ip' => $this->request->clientIp(),
				'created_date' => date('Y-m-d')

			);

			if($this->Holiday->save($data)){
				echo true;
			} else {
				$err = $this->Holiday->validationErrors;
				echo json_encode($err,true);
			}
		}
	}

	public function deleteHoliday() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$remove_holiday = array(
				'modified_ip' => $this->request->clientIp(),
				'modified_date' => date('Y-m-d'),
				'status' => 0
			);
			$this->Holiday->id = $this->request->data('id');
			$this->Holiday->set($remove_holiday);
			if ($this->Holiday->save()) {
				echo true;
			} else {
				echo false;
			}
			
			
		}
	}

	public function editHoliday($id) {
		if(isset($id)) {
			$this->layout = 'admin';
			$holiday_info= $this->Holiday->find('first',array('conditions'=>array('id'=>$id)));
			if (count($holiday_info)>0) {
				$this->set('holiday_info',$holiday_info);
			} else {
				echo 'it seems there are errors';
			}
		}
	}

	public function saveEditHoliday() {
		$this->autoRender = false;
		if($this->request->is('ajax')) {
			$id = $this->request->data('id');
			$this->Holiday->id = $id;
			$info = array(
				'date' => $this->request->data('date'),
				'description' => $this->request->data('description'),
				'rate'	=> $this->request->data('rate'),
				'recurring' => $this->request->data('recurring'),
				'modified_ip' => $this->request->clientIp(),
				'modified_date' => date('Y-m-d')
			);
			$this->Holiday->set($info);
			if($this->Holiday->save()){
				echo true;
			} else {
				$err = $this->Holiday->validationErrors;
				echo json_encode($err,true);
			}
			
		}
	}
}