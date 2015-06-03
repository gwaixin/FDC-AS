<div class="container-fluid">
	<div class="row-fluid">
		<div class="main-content">
			<div class='span3'>
				<h3>Attendance History</h3>
				<ul class="nav nav-list bs-docs-sidenav affix-top" id="attendance-menu">
		          	<?php
						$currentDate = '';
						foreach ($history as $key => $val) {
							if ($currentDate != $val['Attendance']['date']) {
								$currentDate = $val['Attendance']['date'];
								$dateFormat = date('Y F', strtotime($currentDate));
								echo "<li><a href='javascript:;' date='$currentDate'><i class='icon-chevron-right'></i> $currentDate </a></li>";
							}
						}
				   	?>
		        </ul>
		    </div>
		    <div class='span9'>
		    	<span class='pull-right'><i class='fa fa-calendar fa-3x'></i></span>
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
			$.post(webroot+'attendances/getAttendanceDetail', {id: empId, date: date}, function(data) {
				$('#attendance-detail').html(data);
			});
		});
	});
</script>