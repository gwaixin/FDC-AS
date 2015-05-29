<?php 
	echo $this->Html->css('employee-profile');
	echo $this->Html->script('employee-profile');
?>
<div class="modal fade" id="modalSignature" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       	<h3> Signature </h3>
       </div>
      <div class="modal-body" id="contract-container">
      	<center>
	      	<img src="<?php echo $this->webroot."$Profile[signature]"; ?>" id="img-signature">
	      </center>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<div>
<h3> My Profile </h3>

<div id="profile-container">
	<div id="profile-picture-container">
		<div id="profile-picture">
			<img src="<?php echo $this->webroot."$Profile[picture]"; ?>">
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
			<td> <b> Nick Name </b> </td>
			<td> : </td>
			<td> <?php echo $Profile['nick_name']; ?> </td>
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
																								'class' => 'btn btn-success',
																								'data-toggle' => 'modal',
																								'data-target' => '#modalSignature'
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