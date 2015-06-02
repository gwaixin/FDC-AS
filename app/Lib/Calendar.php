<?php

class Calendar {

    public $month;
    public $days;
    public $today;
    public $week;
    public $d;
    public $firstDay;
    public $totalDays;
    public $currentDate;

    public function ini($currentDate = '') {
        //date_default_timezone_set('UTC');
        //echo date("Y-m-d H:i:s");
        //$this->days = cal_days_in_month(CAL_GREGORIAN, $this->month, date("Y", strtotime($currentDate)));
        $currentDate = empty($currentDate) ? date('Y-m-d') : $currentDate;

        $this->currentDate = $currentDate;
        $this->month = date('m', strtotime($currentDate));
        $this->d = new DateTime(date('Y', strtotime($this->currentDate))."-".$this->month);
        $this->today = date('j', strtotime($currentDate));
        $this->d->modify('first day of this month');
        $this->firstDay = $this->d->format('D');
        $this->days = 0;
        $this->totalDays =  $this->d->format('t');
        $this->week = array(
            'Sun',
            'Mon',
            'Tue',
            'Wed', 
            'Thu',
            'Fri',
            'Sat'
        );
    }
}
    
      
?>
