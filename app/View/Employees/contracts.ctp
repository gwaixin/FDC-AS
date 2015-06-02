<?php if (count($currentContract) > 0) { 
$currentContract = $currentContract[0];
?>
<table class="table table-striped" style="width:600px;margin-top: 20px;">
	<tr>
		<td colspan=2> <h3> My Current Contract </h3> </td>
	</tr>
	<tr>
		<td> Description </td>
		<td> <?php echo $currentContract['Contractlog']['description'];?> </td>
	</tr>
	<tr>
		<td> Date Start </td>
		<td> <?php echo $currentContract['Contractlog']['date_start'];?> </td>
	</tr>
	<tr>
		<td> Date End </td>
		<td> <?php echo $currentContract['Contractlog']['date_end'];?> </td>
	</tr>
	<tr>
		<td> Salary </td>
		<td> <?php echo "P".number_format($currentContract['Contractlog']['salary'],2);?> </td>
	</tr>
	<tr>
		<td> Deminise </td>
		<td> <?php echo "P".number_format($currentContract['Contractlog']['deminise'],2);?> </td>
	</tr>
	<tr>
		<td> Term </td>
		<td> <?php echo $currentContract['Contractlog']['term'];?> </td>
	</tr>
	<tr>
		<td> Position </td>
		<td> <?php echo $currentContract['positions']['description'];?> </td>
	</tr>
	<tr>
		<td> Position Level </td>
		<td> <?php echo $currentContract['position_levels']['description'];?> </td>
	</tr>
	<tr>
		<td> Document </td>
		<td> 
			<a href="<?php echo $this->webroot."document/".$currentContract['Contractlog']['document']; ?>" target="blank">Document</a> 
			</td>
	</tr>
</table>
<?php
}  else {
?>
<table class="table" style="width:600px;margin-top: 20px;">
	<tr>
		<td colspan=2> <h3> No active contract found. </h3> </td>
	</tr>
</table>
<?php
}
?>

<h3>My Contract Logs</h3>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
    	<th> # </th>
      <th><center>Description</center></th>
      <th><center>Date Start</center></th>
      <th><center>Date End</center></th>
      <th><center>Document</center></th>
      <th><center>Salary</center></th>
      <th><center>Deminise</center></th>
      <th><center>Term</center></th>
      <th><center>Status</center></th>
      <th><center>Position</center></th>
      <th><center>Position level</center></th>
    </tr>
  </thead>
  <tbody>
  <?php 
  	$i = 1;
  	foreach ($data as $row){
  ?>
    <tr>
    	<td><?php echo $i;?></td>
      <td><?php echo $row['Contractlog']['description'];?></td>
      <td><center><?php echo $row['Contractlog']['date_start'];?></center></td>
      <td><center><?php echo $row['Contractlog']['date_end'];?></center></td>
      <td><center><a href="<?php echo $this->webroot."document/".$row['Contractlog']['document']; ?>" target="blank">Document</a></center></td>
      <td><?php echo "P".number_format($row['Contractlog']['salary'],2);?></td>
      <td><?php echo "P".number_format($row['Contractlog']['deminise'],2);?></td>
      <td><?php echo $row['Contractlog']['term'];?></td>
      <td><center><?php echo ($row['Contractlog']['status'] == 1) ? 'Active' : 'Inactive';?></center></td>
      <td><?php echo $row['positions']['description'];?></td>
      <td><?php echo $row['position_levels']['description'];?></td>
    </tr>
	<?php
			$i++;
		}
	?>    
  </tbody>
</table>
