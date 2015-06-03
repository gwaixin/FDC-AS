<h4><?php echo date('F Y', strtotime($currentDate)); ?></h4>
<table class="table table-bordered"> 
<?php
	$row = 5;
    for($i = 0; $i <= $row; $i++){
       echo "<tr>";
       
        for ($j = 0; $j < 7; $j++) {
            $class = ''; $id = '';

            //$style = ($days == $today-1 && $month == date('m')) ? 'style="border: 1px solid red"' : '';
            //$style = ($i>0) ? '':'style="background:#FFF380"';
            $isValidDay = $days < $totalDays && $days > 0;
            $isFirstDay = $firstDay === $week[$j];

            if ($i == 0) {
                $class .= "day-head";
            } else if ($i > 0 && $isValidDay || $isFirstDay) {
                $class = "days";
                //$id = "day". ($days + 1);
                if ($days == $today-1 && $month == date('m')) {
                    $id = "focus-day";
                }
            }
			//$class = ($i >0)?'class=""'.' id="day'..'"': '';
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

<input type='hidden' id='yearmonth' value="<?php echo date('Y/m/', strtotime($currentDate)); ?>"/>

<?php $d->modify('+1 month'); ?>
<span class='calendar-nav pull-right' date="<?php echo $d->format('Y-m-d'); ?>">
    <i class='fa fa-2x fa-chevron-circle-right'></i>
</span>

<?php $d->modify('-2 month'); ?>
<span class='calendar-nav' date="<?php echo $d->format('Y-m-d'); ?>">
    <i class='fa fa-2x fa-chevron-circle-left'></i>
</span>