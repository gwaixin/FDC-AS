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
    public $year;

    public function ini($currentDate = '') {
        $currentDate = empty($currentDate) ? date('Y-m-d') : $currentDate;

        $this->currentDate = $currentDate;
        $this->month = date('m', strtotime($currentDate));
        $this->year = date('Y', strtotime($currentDate));
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

    public function getMonths() {
        $months = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December' 
        );
        return $months;
    }

    public function getYears($start, $end = '') {
        $yearEnd = empty($end) ? date('Y') : $end;
        $yearStart = $start;
        $year = array();
        for (;$yearStart <= $yearEnd; $yearStart++) {
            $year[] = $yearStart;
        }
        return $year;
    }
}
    
      
?>
