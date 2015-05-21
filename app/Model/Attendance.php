<?php
App::uses('AppModel', 'Model');

class Attendance extends AppModel {
	
	public $validate = array(
		'f_time_in' => array(
			'rule' 		=> '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',
			'allowEmpty' => true,
			'message' 	=> 'Must input valid time format.'
		), 'f_time_out' => array(
			'rule' 		=> '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',
			'allowEmpty' => true,
			'message' 	=> 'Must input valid time format.'
		), 'l_time_in' => array(
			'rule' 		=> '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',
			'allowEmpty' => true,
			'message' 	=> 'Must input valid time format.'
		), 'l_time_out' => array(
			'rule' 		=> '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',
			'allowEmpty' => true,
			'message' 	=> 'Must input valid time format.'
		)
	);
	
	private function validateTime() {
		return ;
	}
	
	public function hasAttendance($date) {
		$attendance = $this->find('first', array(
				'conditions' => array(
						'Attendance.date =' => $date
				)
		));
		return $attendance ? true : false;
	}
	
	public function createAttendance($date, $employee) {
		$presentDate = date('Y-m-d');
		if (strtotime($presentDate) < strtotime($date)) {
			$this->Session->setFlash(__('No attendance for this date'));
			return 'FAIL';
		}
	
		$attendance = array();
		
		foreach($employee as $e) {
			$fTimein = $e['Employee']['f_time_in'];
			$fTimeout = $e['Employee']['f_time_out'];
			$lTimein = $e['Employee']['l_time_in'];
			$lTimeout = $e['Employee']['l_time_out'];
			$totalTime = $this->getTotalTime($fTimein, $fTimeout, $lTimein, $lTimeout);
			$data = array(
					'employees_id' 	=> $e['Employee']['id'],
					'satus'			=> 0,
					'date'			=> $date,
					'total_time'	=> $totalTime
			);
			array_push($attendance, $data);
		}
	
		if ($this->saveAll($attendance)) {
			return 'SUCCESS';
		} else {
			return 'FAIL';
		}
	}
	
	public function updatePresentTime($id, $time) {
		$this->read(null, $id);
		$this->set('present_time', $time);
		if ($this->save()) {
 			return true;
 		}
	}
	
	public function checkStat($d) {
		$this->id = $d['id'];
		$join = array(
				array(
					'table' => 'employees as e', 
					'conditions' => array('e.id = Attendance.employees_id')
			)
		);
		$data = $this->find('first', array(
				'fields' => array(
						'e.f_time_in',
						'e.f_time_out',
						'e.l_time_in',
						'e.l_time_out',
						'Attendance.status'
				),
				'joins' => $join
		));
		$stat = $data['Attendance']['status'];
		$eTimeIn = strtotime($data['e']['f_time_in']);
		$cTimeIn = strtotime($d['ftimein']);
		$eTimeOut = strtotime($data['e']['f_time_out']);
		$cTimeOut = strtotime($d['ftimeout']);
		
		$eLTimeIn = strtotime($data['e']['l_time_in']);
		$cLTimeIn = strtotime($d['ltimein']);
		$eLTimeOut = strtotime($data['e']['l_time_out']);
		$cLTimeOut = strtotime($d['ltimeout']);
		
		if ($cTimeIn > $eTimeIn) {
			$stat = 3;
		} else if ($cTimeIn <= $eTimeIn) {
			$stat = 1;
		}
		
		if ($stat != $data['Attendance']['status']) {
			$this->read(null, $d['id']);
			$this->set('status', $stat);
			$this->save();
		}
		return $stat;
	}
	
	//private
	private function getTotalTime($fTimein, $fTimeout, $lTimein, $lTimeout) {
		$first 	= $this->totalDifference($fTimein, $fTimeout);
		$last 	= $this->totalDifference($lTimein, $lTimeout);
		if ($this->verifyTimeFormat($last['time'])) {
			$total = $this->totalDifference($first["time"], $last["time"]);
		} else if($this->verifyTimeFormat($first['time'])) {
			$total = $first["time"];
		} else {
			$total = "00:00:00";
		}
		return $total;
	}
	
	private function totalDifference($timeA, $timeB) {
		$totalTime = 0;
		if ($this->verifyTimeFormat($timeA) && $this->verifyTimeFormat($timeB)) {
			$to_time 	= new DateTime($timeA);
			$from_time 	= new DateTime($timeB);
			$diff 		= $from_time->diff($to_time);
			$hours 		= str_pad($diff->format('%h'), 2, "0", STR_PAD_LEFT);
			$mins 		= str_pad($diff->format('%i'), 2, "0", STR_PAD_LEFT);
			$sec 		= str_pad($diff->format('%s'), 2, "0", STR_PAD_LEFT);
			$totalTime 	= array(
					"time" 	=> "$hours:$mins:$sec",
					"h" 	=> $hours,
					"m" 	=> $mins,
					"s" => $sec
			);
		}
		return $totalTime;
	}
	private function verifyTimeFormat($value) {
		$pattern1 = '/^(0?\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/';
		$pattern2 = '/^(0?\d|1[0-2]):[0-5]\d\s(am|pm)$/i';
		return preg_match($pattern1, $value) || preg_match($pattern2, $value);
	}
}
?>