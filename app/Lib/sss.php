<?php

class sss {
	public function getResult($salary) {
		for($x = 0,$to = 1249.99,$value = 1000; $value <= 15750 ; $x++,$to += 500) {
			echo $value . ' - ' . $to.'<br>';
			if($x === 0) {
				$value += 250;
			} else {
				$value += 500;
			}
		}
	}
}