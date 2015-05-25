<?php

class StaffsController extends AppController {
	
	
	public function index(){
		
		$this->layout = 'staff';
		
		
		
	}
	
	public function employees(){
		
		$this->layout = 'staff';
		$this->render('/employees/index');
		
	}
	
}