<?php
App::uses('AppController', 'Controller');
App::uses('Calendar', 'Lib');
class DtrController extends AppController {

	public function index($layout) {
		$this->layout = $layout;
		$this->loadModel('Attendance');

		$calendar = new Calendar();
		$months = $calendar->getMonths();
		$years = $calendar->getYears(2013);

		$this->loadModel('Employeeshift');

		$shifts = $this->Employeeshift->find('all', array(
				'fields' => array('description', 'id'),
				'conditions' => array(
					'status' => 1
				)
			)
		);

		$this->set('shifts', $shifts);
		$this->set('months', $months);
		$this->set('years', $years);
	}

	public function listDTR() {
		if ($this->request->is('Ajax')) {
			$this->layout = 'ajax';
			$data = $this->request->data;
			if ($data) {
				$this->loadModel('Attendance');
				
				$condition = array();
				if (!empty($data['month'])) {
					$condition['MONTH(Attendance.date)'] = $data['month'];
				}

				if (!empty($data['year'])) {
					$condition['YEAR(Attendance.date)'] = $data['year'];
				}

				if (!empty($data['shift'])) {
					$condition['employees.employee_shifts_id'] = $data['shift'];
				}

				$order = array('Attendance.date' => 'ASC');
				$join = array(
					array(
						'table' => 'employees',
						'type'	=> 'left',
						'conditions' => array(
							'employees.id = Attendance.employees_id'
						)
					), array(
						'table' => 'profiles',
						'conditions' => array(
								'employees.profile_id = profiles.id'
						)
					)
				);
				$empResult = $this->Attendance->find('all', array(
						'conditions' => $condition, 
						'order' 	=> $order, 
						'joins'		=> $join,
						'fields'	=> array(
							'Attendance.date',
							'Attendance.f_time_in',
							'Attendance.f_time_out',
							'Attendance.over_time',
							'Attendance.status',
							'Attendance.total_time',
							'Attendance.render_time',
							'employees.id', 
							'profiles.first_name',
							'profiles.last_name',
							'profiles.middle_name'
						)
					)
				);

				$dtrHeader = array();
				foreach($empResult as $key => $val) {
					$dtrHeader[$val['Attendance']['date']] = $val['employees'];
				}

				$absent = 0;
				$dtrBody = array();
				$workingHrs = "00:00:00";
				$totalHrs = "00:00:00";
				foreach ($empResult as $key => $val) {
					$dtrBody[$val['employees']['id']]['attendance'][] = $val['Attendance'];
					$dtrBody[$val['employees']['id']]['profile'] = $val['profiles'];
					
					//individual total of render and overtime
					$render = empty($dtrBody[$val['employees']['id']]['total_render']) ? '00:00:00' : $dtrBody[$val['employees']['id']]['total_render'];
					$dtrBody[$val['employees']['id']]['total_render'] = $this->sumTime($render, $val['Attendance']['render_time'], '%02d:%02d');
					
					$overtime = empty($dtrBody[$val['employees']['id']]['total_overtime']) ? '00:00:00' : $dtrBody[$val['employees']['id']]['total_overtime'];
					$dtrBody[$val['employees']['id']]['total_overtime'] = $this->sumTime($overtime, $val['Attendance']['over_time'], '%02d:%02d');
					if ($val['Attendance']['status'] == 2)  { // Absent
						$absent++;
					}
					//get total render, and working time
					$workingHrs = $this->sumTime($workingHrs, $val['Attendance']['render_time'], '%02d:%02d');
					$totalHrs = $this->sumTime($totalHrs, $val['Attendance']['total_time'], '%02d:%02d');
				}
				//pr($dtrBody);
				//exit();
				$empCount = count($dtrBody);
				$this->set('absent', $absent);
				$this->set('empCount', $empCount);
				$this->set('dtrHeader', $dtrHeader);
				$this->set('dtrBody', $dtrBody);
				$this->set('workingHrs', $workingHrs);
				$this->set('totalHrs', $totalHrs);
			}
			$this->render('list');
			return;
		}
	}

	//private function
	private function sumTime($time1, $time2, $format = '%02d:%02d:%02d') {
		$this->autoRender = false;
		if (!empty($time1) || !empty($time2)) {
			$times = array($time1, $time2);
			$seconds = 0;
			foreach ($times as $time)
			{
				if (!empty($time)) {
					$timeArr = explode(':', $time);
					$seconds += $timeArr[0]*3600;
					$seconds += $timeArr[1]*60;
					if (!empty($timeArr[2])) {
						$seconds += $timeArr[2];
					}
				}
			}
			$hours = floor($seconds/3600);
			$seconds -= $hours*3600;
			$minutes  = floor($seconds/60);
			$seconds -= $minutes*60;
			// return "{$hours}:{$minutes}:{$seconds}";
			return sprintf($format, $hours, $minutes, $seconds);
		} else {
			return $time1;
		}
	} 
	
}