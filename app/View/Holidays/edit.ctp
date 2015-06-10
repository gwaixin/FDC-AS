<?php 
	echo $this->Html->script('bootstrap-datepicker');
	echo $this->Html->script('holiday/holiday.js');
?>
<div class="main-content">
<h2>Edit Holiday Information</h2>
<form id="edit-holiday-info" >
	<input type="hidden" name="id" value="<?php echo $holiday_info['Holiday']['id']?>">
	<table class="table">
		<tr>
			<td>Date</td>
			<td>
				<input type="text" name="date" id="holiday-date" value="<?php echo (isset($holiday_info['Holiday']['date'])) ? $holiday_info['Holiday']['date'] : '';?>">
				<br/>
				<span class="alert alert-danger error hide" role="alert" id="date"></span>
				
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<textarea name="description"><?php echo $holiday_info['Holiday']['description']?></textarea>
				<br/>
				<span class="alert alert-danger error hide" role="alert" id="description"></span>
			</td>
		</tr>
		<tr>
			<td>Rate</td>
			<td>
				<input type="text" maxlength="4" name="rate" onkeyup="formatRate()" value="<?php echo $holiday_info['Holiday']['rate']?>" class="rate" />
				<br/>
				<span class="alert alert-danger error hide" role="alert" id="rate"></span>
			</td>
		</tr>
		<tr>
			<td>Occurence</td>
			<td>
				<select name="recurring" id="holiday-recurring">
					<option value="0" <?php echo($holiday_info['Holiday']['recurring'] == '0' )? 'selected':''?> >Once</option>
					<option value="1" <?php echo($holiday_info['Holiday']['recurring'] == '1' )? 'selected':''?>>Yearly</option>
					<option value="2" <?php echo($holiday_info['Holiday']['recurring'] == '2' )? 'selected':''?>>Monthly</option>
				</select>
				<br/>
				<span class="alert alert-danger error hide" role="alert" id="recurring"></span>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><button class="btn btn-primary" id="edit-holiday-btn">Edit</button></td>
		</tr>
	</table>
</form>


</div>

<script type="text/javascript">
	$('#edit-holiday-btn').click(function(e){
		e.preventDefault();
		var url = "<?php echo Router::url(array('controller'=>'holidays','action'=>'saveEditHoliday'))?>";
		$.post(url,$('#edit-holiday-info').serialize(),function(data){
			if (data == 1) {
				window.location.reload();
			} else {
				var error = $.parseJSON(data);
				$.each(error,function(index, value){
					$('#'+index).text(value).show();
				});
			}
		});

	});
</script>