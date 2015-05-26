
<style>
#profile-container {
	font: 17px "Tahoma";
}
#profile-container table {
	margin-top: 20px;
}
#profile-container table tr td {
	padding: 10px 5px;
}
#profile-picture-container {
	border: 1px solid #999;
	width: 230px;
	height: 230px;
	background: #fff;
	border-radius: 5px;
	overflow: none;
}
#profile-picture-container button {
	margin: 2px;
}
</style>

<div>
<h3> My Profile </h3>

<div id="profile-container">
	<div id="profile-picture-container">
		<div id="profile-picture">
			<img src="<?php echo $this->webroot; ?>upload/250x250_4054051431929527.jpeg">
		</div>
	</div>
	<table>
		<tr> 
			<td> <b> First Name </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['first_name']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Last Name </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['last_name']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Middle Name </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['middle_name']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Birth Date </b> </td>
			<td> : </td>
			<td> 
				<?php 
					$birthdate = split(' ',$Profile['birthdate']);
					echo $birthdate[0]; 
				?> 
			</td>
		</tr>
		<tr> 
			<td> <b> Contact </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['contact']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Facebook </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['facebook']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Email </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['email']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Gender </b> </td>
			<td> : </td>
			<td> 
				<?php 
					$gender = "No Gender Selected";
					if($Profile['gender'] == 'M') {
						$gender = "Male";
					} else if($Profile['gender'] == 'F') {
						$gender = "Female";
					}
					echo $gender;
				?> 
			</td>
		</tr>
			<tr> 
			<td> <b> Address </b> </td>
			<td> : </td>
			<td> <div class="txt-address"> <?php echo $Profile['address']; ?> </div> </td>
		</tr>
		<tr> 
			<td> <b> Contact Person </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['contact_person']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Contact Person No </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['contact_person_no']; ?> </td>
		</tr>
		<tr> 
			<td> <b> Signature </b> </td>
			<td> : </td>
			<td> 
					<?php
						echo $this->Form->button('View <span class="icon-search"></span>',array(
																								'class' => 'btn btn-success'
																							)
																						);
					?>
			</td>
		</tr>
		<tr>
			<td colspan=2> </td>
			<td>
					<?php
						echo $this->Html->link('Edit',"/employees/profile/edit",array(
																								'class' => 'btn btn-primary'
																							)
																						);
					?>
			</td>
		</tr>
	</table>
</div>