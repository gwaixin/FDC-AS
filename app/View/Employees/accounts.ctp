

<?php 
	echo $this->Html->css('main');
	echo $this->Html->css('datepicker');
	echo $this->Html->script('bootstrap-datepicker');
?>
<style>
#Accounts-container {
	font: 17px "Tahoma";
	margin-top: 20px;
	width: 500px;
}
#Accounts-container table {
	margin-top: 40px;
}
#Accounts-container table tr td {
	padding: 5px 10px;
	vertical-align: top;
}
</style>


<div id="Accounts-container">
	<table class="table table-striped table-bordered">
		<tr>
			<td colspan=2> 
				<h3> Accounts Details </h3> </td>
		</tr>
		<tr> 
			<td> <b>Tin No</b> </td>
			<td > <?php echo $Accounts['tin']; ?> </td>
		</tr>
		<tr> 
			<td> <b>Drug Test</b> </td>
			<td> <?php echo $Accounts['drug_test']; ?>  </td>
		</tr>
		<tr> 
			<td> <b>Medical</b> </td>
			<td> <?php echo $Accounts['medical']; ?>  </td>
		</tr>
		<tr> 
			<td> <b>Pagibig</b> </td>
			<td> <?php echo $Accounts['pagibig']; ?>  </td>
		</tr>
		<tr> 
			<td> <b>Phil Health</b> </td>
			<td> <?php echo $Accounts['philhealth']; ?>  </td>
		</tr>
		<tr> 
			<td> <b>SSS</b> </td>
			<td> <?php echo $Accounts['pagibig']; ?>  </td>
		</tr>
		<tr> 
			<td> <b>Insurance ID</b> </td>
			<td> <?php echo $Accounts['insurance_id']; ?> </td>
		</tr>
	</table>
</div>
