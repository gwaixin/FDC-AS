<?php
class AttendanceStatus {

	public $status;

	public function ini() {
		$this->status = array('pending', 'present', 'absent', 'late', 'undertime');
	}
}

?>