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
			return 'FAIL';
		}
	
		$attendance = array();
		
		foreach($employee as $e) {
			$hasAttendance = $this->find('first', array(
					'conditions' => array(
						'employees_id' => $e['Employee']['id'],
						'date'	=> $date
					)
			)); 
			if (!$hasAttendance) {
				$fTimein = $e['employee_shifts']['ftime_in'];
				$fTimeout = $e['employee_shifts']['ftime_out'];
				$lTimein = $e['employee_shifts']['ltime_in'];
				$lTimeout = $e['employee_shifts']['ltime_out'];

				$totalTime = $this->getTotalTime($fTimein, $fTimeout, $lTimein, $lTimeout);
				$data = array(
						'employees_id' 	=> $e['Employee']['id'],
						'satus'			=> 0,
						'date'			=> $date,
						'total_time'	=> $totalTime
				);
				array_push($attendance, $data);
			}
		}
		if ($this->saveAll($attendance)) {
			return 'SUCCESS';
		} else {
			return 'FAIL-NO-SAVE';
		}
	}
	
	public function saveTime($id, $fieldData) {
		$this->read(null, $id);
		$this->set($fieldData[0], $fieldData[1]);
		if ($this->save()) {
 			return true;
 		}
	}
	public function updateTime($data) {
		$eData = $this->getEmployeeDetail($data['id']);
		
		$col = array('f_time_in', 'f_time_out', 'l_time_in', 'l_time_out');
		$attendance = array();
		foreach($col as $c) {
			$eEmp = $eData['Attendance']['date'] . ' ' . $eData['es'][$c];
			if ($c == 'f_time_out' || $c == 'l_time_out') {
				$con = strtotime($data[$c]) > strtotime($eEmp);
			} else {
				$con = ($c == 'f_time_in' && strtotime($data[$c]) < strtotime($eEmp));
			}
			if ($this->valDateTimeFormat($data[$c])) {
				$attendance[] = ($con) ? $eEmp : $data[$c];
			} else {
				$attendance[] = 0;
			}
		}
		
		$firstLog 	= $this->totalDifference($attendance[0], $attendance[1]);
		$lastLog 	= $this->totalDifference($attendance[2], $attendance[3]);
		
		
		
		$totalTime 	= $this->sumTime($firstLog['time'], $lastLog['time']);
		
		/*$hr 	= timePadding(($firstLog['h']+$lastLog['h']));
		$min 	= timePadding(($firstLog['m']+$lastLog['m']));
		$sec 	= timePadding(($firstLog['s']+$lastLog['s']));*/
		
		return $totalTime;
	}
	
	public function checkStat($d) {
		$this->id = $d['id'];
		$join = array(
			array(
				'table' => 'employees as e', 
				'conditions' => array('e.id = Attendance.employees_id')
			),
			array(
				'table'	=> 'employee_shifts as es',
				'conditions' => array('es.id = e.employee_shifts_id')
			)
		);
		$data = $this->find('first', array(
				'fields' => array(
						'es.f_time_in',
						'es.f_time_out',
						'es.l_time_in',
						'es.l_time_out',
						'Attendance.status',
						'Attendance.total_time',
						'Attendance.render_time'
				),
				'joins' => $join
		));
		$stat = $data['Attendance']['status'];
		$eTimeIn = strtotime($data['es']['f_time_in']);
		$cTimeIn = strtotime($d['f_time_in']);
		$eTimeOut = strtotime($data['es']['f_time_out']);
		$cTimeOut = strtotime($d['f_time_out']);
		
		$eLTimeIn = strtotime($data['es']['l_time_in']);
		$cLTimeIn = strtotime($d['l_time_in']);
		$eLTimeOut = strtotime($data['es']['l_time_out']);
		$cLTimeOut = strtotime($d['l_time_out']);
		
		/*$cTotalTime = strtotime($data['Attendance']['total_time']);
		$cRenderTime = strtotime($data['Attendance']['render_time']);
		*/
		$elastOut = $this->verifyTimeFormat($eLTimeOut) ? $eLTimeOut : $eTimeOut;
		$cLastOut = $this->verifyTimeFormat($cLTimeOut) ? $cLTimeOut : $cTimeOut;
		
		if ($cLastOut < $elastOut) {
			$stat = 4;
		} else  if ($cTimeIn > $eTimeIn) {
			$stat = 3;
		} else if ($cTimeIn <= $eTimeIn) {
			$stat = 1;
		}
		
		/*if ($stat != $data['Attendance']['status']) {
			$this->read(null, $d['id']);
			$this->set('Attendances.status', $stat);
			if ($this->save()) {
				return $stat;
			}
		} else {
			return $d['id'];
		}*/
		return $stat;
		
	}
	
	public function getOT($id) {
		$join = array(
				array(
					'table' => 'employees as e',
					'conditions' => array('e.id = Attendance.employees_id')
				), 
				array(
					'table'	=> 'employee_shifts as es',
					'conditions' => array('e.employee_shifts_id = .es.id')
				)
		);
		
		$data = $this->find('first', array(
				'fields' => array(
						'es.f_time_out',
						'es.l_time_out',
						'Attendance.f_time_out',
						'Attendance.l_time_out',
						'Attendance.date'
				),
				'joins' => $join,
				'conditions' => array('Attendance.id' => $id)
		));
		
		
		$ot = '00:00:00';
		$lastOutTime = $this->verifyTimeFormat($data['es']['l_time_out']) ? 'l_time_out': 'f_time_out';
		$lastOut = $data['Attendance']['date'] . ' ' . $data['es'][$lastOutTime];
		$present = $data['Attendance'][$lastOutTime];
		if (strtotime($lastOut) < strtotime($present)) {
			$diff = $this->totalDifference($lastOut, $present);
			$ot = $diff['time'];
		}
		//$ot = "$lastOut - $present";
		return $ot;
	}
	
	public function sumTime($time1, $time2) {
		if (!empty($time1) || !empty($time2)) {
			$times = array($time1, $time2);
			$seconds = 0;
			foreach ($times as $time)
			{
				if (!empty($time)) {
					$timeArr = explode(':', $time);
					$seconds += $timeArr[0]*3600;
					$seconds += $timeArr[1]*60;
					$seconds += $timeArr[2];
				}
			}
			$hours = floor($seconds/3600);
			$seconds -= $hours*3600;
			$minutes  = floor($seconds/60);
			$seconds -= $minutes*60;
			// return "{$hours}:{$minutes}:{$seconds}";
			return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
		}
	}
	
	//private
	private function getTotalTime($fTimein, $fTimeout, $lTimein, $lTimeout) {
		$first 	= $this->totalDifference($fTimein, $fTimeout);
		$last 	= $this->totalDifference($lTimein, $lTimeout);
		if ($this->verifyTimeFormat($last['time'])) {
			$total = $this->sumTime($last['time'], $first['time']); //$this->totalDifference($first["time"], $last["time"]);
		} else if($this->verifyTimeFormat($first['time'])) {
			$total = $first["time"];
		} else {
			$total = $fTimein . '@' . $fTimeout;
		}
		/*echo "$fTimein - $fTimeout -  $lTimein - $lTimeout @ ";
		echo "{$first['time']} - {$last['time']} @ ";
		echo "$total";
		exit();*/
		return $total;
	}
	
	private function totalDifference($timeA, $timeB) {
		$totalTime = 0;
		if (
			($this->valDateTimeFormat($timeA) && $this->valDateTimeFormat($timeB)) ||
			($this->verifyTimeFormat($timeA) && $this->verifyTimeFormat($timeB))
		) {
			$to_time 	= new DateTime($timeA);
			$from_time 	= new DateTime($timeB);
			$diff 		= $from_time->diff($to_time);
			$hours 		= $this->timePadding($diff->format('%h'));
			$mins 		= $this->timePadding($diff->format('%i'));
			$sec 		= $this->timePadding($diff->format('%s'));
			$totalTime 	= array(
					"time" 	=> "$hours:$mins:$sec",
					"h" 	=> $hours,
					"m" 	=> $mins,
					"s" 	=> $sec
			);
		}
		return $totalTime;
	}
	public function verifyTimeFormat($value) {
		if (!empty($value)) {
			$pattern1 = '/^(0?\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/';
			$pattern2 = '/^(0?\d|1[0-2]):[0-5]\d\s(am|pm)$/i';
			return preg_match($pattern1, $value) || preg_match($pattern2, $value);
		} else {
			return false;
		}
	}
	private function valDateTimeFormat($value) {
		$pattern = '(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})';
		return preg_match($pattern, $value);
	}
	
	private function timePadding($val) {
		return str_pad($val, 2, "0", STR_PAD_LEFT);
	}
	
	private function getEmployeeDetail($id, $condtion = "") {
		$join = array(
				array(
					'table' => 'employees as e',
					'conditions' => array('e.id = Attendance.employees_id')
				),
				array(
					'table' => 'employee_shifts as es',
					'conditions' => array('es.id = e.employee_shifts_id')
				)
		);
		$data = $this->find('first', array(
				'fields' => array(
						'es.f_time_in',
						'es.f_time_out',
						'es.l_time_in',
						'es.l_time_out',
						'Attendance.status',
						'Attendance.date'
				),
				'joins' => $join,
				'conditions' => array('Attendance.id' => $id)
		));
		return $data;
	}
}
?>