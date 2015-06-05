
<div class='span4'>
    <h4><?php echo date('F Y', strtotime($currentDate)); ?></h4>
</div>
<table class="table table-bordered"> 
<?php
	$row = 5;
    for($i = 0; $i <= $row; $i++){
       echo "<tr>";
       
        for ($j = 0; $j < 7; $j++) {
            $class = ''; $id = '';

            $isValidDay = $days < $totalDays && $days > 0;
            $isFirstDay = $firstDay === $week[$j];

            if ($i == 0) {
                $class .= "day-head";
            } else if ($i > 0 && $isValidDay || $isFirstDay) {
                $class = "days";
                if ($days == $today-1 && $month == date('m', strtotime($focus))) {
                    $id = "focus-day";
                }
            }
			echo "<td class='$class' id='$id'>";
            if ($i > 0) {
                if (($isValidDay)|| $isFirstDay) {
                    $days += 1;
                    echo $days;
                }
            } else {
                echo $week[$j];
            }   
            echo "</td>";
            
        }
        echo "</tr>";
		if (($i === $row) && ($days < $totalDays)) {
			$row += 1;
			$firstDay = null;
		}
    }
?>    
</table>

<input type='hidden' id='yearmonth' value="<?php echo date('Y-m', strtotime($currentDate)); ?>"/>

<?php $d->modify('+1 month'); ?>
<span class='calendar-nav pull-right' title='Next month' date="<?php echo $d->format('Y-m'); ?>">
    <i class='fa fa-2x fa-chevron-circle-right'></i>
</span>

<?php $d->modify('-2 month'); ?>
<span class='calendar-nav' title='Prev month' date="<?php echo $d->format('Y-m'); ?>">
    <i class='fa fa-2x fa-chevron-circle-left'></i>
</span>