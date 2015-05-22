<?php
App::uses('AppController', 'Controller');
class AttendancesController extends AppController {
	public $helpers = array('Html', 'Form');
	public function index($date = 0) {
		$this->layout = 'main';
		if ($date == 0) {
			$date = date('Y-m-d');	
		}
		
		$this->set('title', 'FDC : ATTENDANCE');
		$this->set('attendanceStat', $this->getAttendanceStatus());
	}
	
	
	
	public function getEmployee() {
		$this->loadModel('Employee');
		$this->autoRender = false;
		
		$employees = $this->Employee->find('all',
				array(
						'conditions' => array('Employee.status = 2'),
						'fields' => array(
							'id',
							'f_time_in',
							'f_time_out',
							'l_time_in',
							'l_time_out'
						)
				)
		);
			
		return $employees;
	}
	
	public function attendanceList() {
		if($this->request->is('ajax')) {
			$this->autoRender = false;
			
			$data = $this->request->data;
			
			$employees = $this->getEmployeeAttendance($data);
			
			$employees_arr = array();
			$statusArr = $this->getAttendanceStatus();
			foreach($employees as $key => $employee) {
				$ftimein 	= $employee['attendances']['f_time_in'] ? date('Y-m-d H:i:s', strtotime($employee['attendances']['f_time_in'])) : '--------';
				$ftimeout 	= $employee['attendances']['f_time_out'] ? date('Y-m-d H:i:s', strtotime($employee['attendances']['f_time_out'])) : '--------';
				$ltimein 	= $employee['attendances']['l_time_in'] ? date('Y-m-d H:i:s', strtotime($employee['attendances']['l_time_in'])) : '--------';
				$ltimeout 	= $employee['attendances']['l_time_out'] ? date('Y-m-d H:i:s', strtotime($employee['attendances']['l_time_out'])) : '--------';
			
				$firstLog 	= $this->totalDifference($ftimein, $ftimeout);
				$lastLog 	= $this->totalDifference($ltimein, $ltimeout);
				//$totalTime 	= $this->Attendance->sumTime($firstLog['time'], $lastLog['time']);
				
				
				$getStat 	= $employee['attendances']['status'] ? $employee['attendances']['status'] : 0;
				$status 	= $statusArr[$getStat];
				
				$data = array(
						'employee_id' 	=> 	$employee['Employee']['employee_id'],
						'name' 			=> 	$employee['profiles']['first_name']. " " . $employee['profiles']['middle_name'] . " " .$employee['profiles']['last_name'],
						'f_time_in' 	=>	$ftimein,
						'f_time_out' 	=>	$ftimeout,
						'l_time_in' 	=>	$ltimein,
						'l_time_out' 	=>	$ltimeout,
						'total_time'	=>  $employee['attendances']['render_time'],
						'over_time'		=>  $employee['attendances']['over_time'],
						'status'		=>	$status,
						'id'			=>	$employee['attendances']['id'],
						'ef_time_in'	=>	!$this->Attendance->verifyTimeFormat($employee['Employee']['f_time_in']),
						'ef_time_out'	=>	!$this->Attendance->verifyTimeFormat($employee['Employee']['f_time_out']),
						'el_time_in'	=>	!$this->Attendance->verifyTimeFormat($employee['Employee']['l_time_in']),
						'el_time_out'	=>	!$this->Attendance->verifyTimeFormat($employee['Employee']['l_time_out']),
						'estatus'		=> $employee['Employee']['status']
				);
				array_push($employees_arr, $data);
			}
			echo json_encode($employees_arr);
		}
	}
	
	public function updateAttendance() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			
			$val = ($data['field'] != 'status') ? date('Y-m-d H:i:s', strtotime($data['value'])) : $data['value'];
			$attendanceData = array(
					'Attendance' => array(
						$data['field'] => $val
					)
			);
			
			$this->Attendance->id = $data['id'];
			if ($this->Attendance->save($attendanceData)) {
				echo 'success';
			} else {
				echo json_encode($this->Attendance->validationErrors);
			}
		}
	}
	
	public function resetAttendance() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$eAttendance = $this->getEmployeeAttendance($data);
			$updateData =array();
			foreach($eAttendance as $ea) {
				array_push($updateData, array('Attendance.id' => $ea['attendances']['id']));
			}
			$resetData = array(
					'Attendance.l_time_in' 	=> NULL,
					'Attendance.l_time_out'	=> NULL,
					'Attendance.f_time_in'	=> NULL,
					'Attendance.f_time_out'	=> NULL,
					'Attendance.status'		=> 0	
			);
			echo $this->Attendance->updateAll($resetData, array('OR'=>$updateData));
			echo json_encode($resetData);
			
		}
	}
	
	
	public function getTotalTime() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$totalTime = $this->Attendance->updateTime($data);
			$stat = $this->Attendance->checkStat($data);
			//$overtime = $this->Attendance->getOT($data['id']);
			$this->Attendance->saveTime($data['id'], array('render_time', $totalTime));
			$this->Attendance->saveTime($data['id'], array('status', $stat));
			
			//echo $totalTime;
			echo json_encode(array('total' => $totalTime, 'stat' => $stat));
		}
	}
	
	public function getOverTime() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$overtime = $this->Attendance->getOT($data['id']);
			$this->Attendance->saveTime($data['id'], array('over_time', $overtime));
			echo $overtime;
		}
	}
	
	public function resetOvertime() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$this->Attendance->saveTime($data['id'], array('over_time', '00:00:00'));
			echo 'success';
		}
	}
	
	
	/* Private Functions */
	
	private function getEmployeeAttendance($data) {
		//Check date
		$currentDate = date("Y-m-d");
		$conditions = array();
		if (!empty($data)) {
			if (!empty($data['date'])) {
				$currentDate = date('Y-m-d', strtotime($data['date']));
			}
			if (!empty($data['keyword'])) {
				$conditions['OR'] = array(
						array("concat_ws(' ', profiles.first_name, profiles.middle_name, profiles.last_name) like" => "%{$data['keyword']}%"),
						array("Employee.employee_id like" => "%{$data['keyword']}%")
				);
					
				//$conditions["like"] = "%{$data['keyword']}%";
			}
			if (!empty($data['status']) && $data['status'] >= 0) {
				$conditions['attendances.status ='] = $data['status'];
			}
			if (!empty($data['time-in']) && strtotime($data['time-in']) > 0) {
				$conditions['Employee.f_time_in >='] = date('H:i:s', strtotime($data['time-in']));
			}
		}
		if (!$this->Attendance->hasAttendance($currentDate)) {
			$employee = $this->getEmployee();
			$this->Attendance->createAttendance($currentDate, $employee);
		
		}
			
		$conditions['attendances.date ='] = $currentDate;
		//$conditions['Employee.status ='] = 2;
			
		$this->loadModel('Employee');
		
		$join = array(
				array(
						'table' => 'profiles',
						'conditions' => array(
								'Employee.profile_id = profiles.id'
						)
				), array(
						'table' => 'attendances',
						'type' => 'left',
						'conditions' => array(
								'Employee.id = attendances.employees_id'
						)
				)
		);
		
		$selectFields = array(
				'Employee.employee_id',
				'Employee.f_time_in',
				'Employee.f_time_out',
				'Employee.l_time_in',
				'Employee.l_time_out',
				'Employee.status',
				'profiles.first_name',
				'profiles.last_name',
				'profiles.middle_name',
				'attendances.f_time_in',
				'attendances.f_time_out',
				'attendances.l_time_in',
				'attendances.l_time_out',
				'attendances.status',
				'attendances.id',
				'attendances.over_time',
				'attendances.render_time'
		);
		$employees = $this->Employee->find('all',
				array(
						'joins' => $join,
						'fields' => $selectFields,
						'conditions' => $conditions
							
				)
		);
		
		return $employees;
		
	}
	
	private function totalDifference($timeA, $timeB) {
		$totalTime = 0;
		if ($timeA != '--------' && $timeB != '--------') {
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
	
	/*
	private function computeTotalTime($first, $last) {
		$totalH = ($first['h'] + $last['h']) ? ($first['h'] + $last['h']) . ' hrs': '';
		$totalM = ($first['m'] + $last['m']) ? ($first['m'] + $last['m']) . ' min': '';
		$totalS = ($first['s'] + $last['s']) ? ($first['s'] + $last['s']) . ' sec': '';
		$totalTime = $totalH . ' ' . $totalM . ' ' . $totalS;
		return $totalTime;
	}*/
	
	
	
	/*private function hasAttendance($date) {
		$attendance = $this->Attendance->find('first', array(
			'conditions' => array(
				'Attendance.date =' => $date
			)	
		));
		return $attendance ? true : false;
	}*/
	
	/*private function createAttendance($date) {
		$presentDate = date('Y-m-d');
		if (strtotime($presentDate) < strtotime($date)) {
			$this->Session->setFlash(__('No attendance for this date'));
			return 'FAIL';
		}
		
		$attendance = array();
		$employee = $this->getEmployee();
		foreach($employee as $e) {
			$data = array(
					'employees_id' 	=> $e['Employee']['id'],
					'satus'			=> 0,
					'date'			=> $date
			);
			array_push($attendance, $data);
		}
		
		if ($this->Attendance->saveAll($attendance)) {
			return 'SUCCESS';
		} else {
			return 'FAIL';
		}
	}*/
	
	private function getAttendanceStatus() {
		return $statusArr = array('pending', 'present', 'absent', 'late', 'undertime');
	}
}
?>