<div class="container-fluid">
	<div class="row-fluid">
		<div class="main-content">
			<div class='span3'>
				<h3>Attendance History</h3>
				<ul class="nav nav-list bs-docs-sidenav affix-top" id="attendance-menu">
		          	<?php
						$currentDate = '';
						$first = true;
						foreach ($history as $key => $val) {
							if ($currentDate != $val['Attendance']['date']) {
								$currentDate = $val['Attendance']['date'];
								$dateFormat = date('Y F', strtotime($currentDate));
								//$active = $first ? 'class="active"' : '';
								//$first = false;
								echo "<li><a href='javascript:;' date='$currentDate'><i class='icon-chevron-right'></i> $dateFormat </a></li>";
							}
						}
				   	?>
		        </ul>
		    </div>
		    <div class='span9'>
		    	<div id='attendance-detail'>

		    	</div>
		    </div>
		    <div class='clearfix'></div>
		</div>
	</div>
</div>
<script>
	var empId = "<?php echo $empId; ?>";
	$(document).ready(function() {

		$('#attendance-menu li a').click(function() {
			var date = $(this).attr('date');
			var activeLi = $(this).parent();
			$('#attendance-menu li').removeClass('active');
			$.post(webroot+'attendances/getAttendanceDetail', {id: empId, date: date}, function(data) {
				$('#attendance-detail').html(data);
				activeLi.attr('class', 'active');
			});
		});
		$('#attendance-menu li:nth(0)').find('a').click();
	});
</script>