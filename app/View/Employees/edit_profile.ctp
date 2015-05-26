
<?php 
	echo $this->Html->css('main');
	echo $this->Html->css('datepicker');
	echo $this->Html->script('bootstrap-datepicker');
?>
<style>
#profile-container {
	font: 17px "Tahoma";
}
#profile-container table {
	margin-top: 40px;
}
#profile-container table tr td {
	padding: 5px;
	vertical-align: top;
}
#profile-picture-container {
	background: #fff;
	border-radius: 5px;
}
#profile-picture {
	width: 230px;
	height: 230px;
	border: 1px solid #999;
	overflow: hidden;
}
#profile-picture-container button {
	margin: 2px;
}
textarea#address {
	resize: none;
	width: 250px;
	height: 80px;
}
.file {
	display: none;
}


.right-inner-addon {
    position: relative;
}
.right-inner-addon input {
    padding-right: 5px;    
}
.right-inner-addon i {
    position: absolute;
    right: 10px;
    height: 20px;
    margin-top: 5px;
    pointer-events: none;
}
.hide-input {
	display: none;
}
</style>

<script>
$(document).ready(function() {

	$('#birthdate').datepicker();
	$("button").click(function() {
		return false;
	})
	$("#btn-browse-profile").click(function(){
		$("#file-profile").click();
	});
	$("#file-profile").change(function() {
		var img = URL.createObjectURL($("#file-profile")[0].files[0]);
		$("#img-profile").attr('src',img);
	});

	$("#btn-browse-signature").click(function(){
		$("#file-signature").click();
	});

});
</script>


<div class="modal fade" id="modalSignature" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true" style="display:none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       </div>
      <div class="modal-body" id="contract-container">
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<h3> My Profile </h3>
<?php 
	foreach($errors as $error):
		echo '<div class="alert alert-warning">
					    <a href="#" class="close" data-dismiss="alert">&times;</a>
					    <strong>Warning!</strong> '.$error[0].'.
					</div>';
	endforeach;
	if($success) {
		echo '<div class="alert alert-success">
					    <a href="#" class="close" data-dismiss="alert">&times;</a>
					    <strong>Success!</strong> You have successfully updated you profile information.
					</div>';
	}
?>
<div id="profile-container">
<form method="post" enctype="multipart/form-data">
	<div id="profile-picture-container">
		<div id="profile-picture">
			<img src="<?php echo $this->webroot; ?>upload/250x250_4054051431929527.jpeg" id="img-profile">
		</div>
		<?php 
			echo $this->Form->file(' ',array(
																			'name' => 'file-profile-picture',
																			'class' => 'file',
																			'id' => 'file-profile',
																		)
																	);
			echo $this->Form->button('Browse <span class="icon-edit"></span>',array(
																								'id' => 'btn-browse-profile',
																								'class' => 'btn btn-success'
																							)
																						);
		?>
	</div>
	<table>
		<tr> 
			<td> <b> First Name </b> </td>
			<td> : </td>
			<td> 
				<?php
					echo $this->Form->input('',array(
																						'name' => 'Profile[first_name]',
																						'value' => $Profile['first_name'],
																						'placeholder' => 'Enter First Name',
																						'label' => false,
																						'div' => false
																					)
																				);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Last Name </b> </td>
			<td> : </td>
			<td>
					<?php
						echo $this->Form->input('',array(
																						'name' => 'Profile[last_name]',
																						'value' => $Profile['last_name'],
																						'placeholder' => 'Enter Las Name',
																						'label' => false,
																						'div' => false
																					)
																				);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Middle Name </b> </td>
			<td> : </td>
			<td>
				<?php
					echo $this->Form->input('',array(
																						'name' => 'Profile[middle_name]',
																						'value' => $Profile['middle_name'],
																						'placeholder' => 'Enter Middle Name',
																						'label' => false,
																						'div' => false
																					)
																				);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Birth Date </b> </td>
			<td> : </td>
			<td> 
				<div class="col-xs-6" >
				    <div class="right-inner-addon">
				        <!-- <i class="icon-calendar"></i> -->
				        <?php 
				        		$birthdate = explode('-',$Profile['birthdate']);
										$birthdate = $birthdate[1].'/'.substr($birthdate[2],0,2).'/'.$birthdate[0];
										echo $this->Form->input('',array(
																											'name' => 'Profile[birthdate]',
																											'id' => 'birthdate',
																											'value' => $birthdate,
																											'label' => false,
																											'div' => false
																										)
																									);
								?>
				    </div>
				</div>
			</td>
		</tr>
		<tr> 
			<td> <b> Contact </b> </td>
			<td> : </td>
			<td>
					<?php 
						echo $this->Form->input('',array(
																						'name' => 'Profile[contact]',
																						'value' => $Profile['contact'],
																						'placeholder' => 'Enter Contact No',
																						'label' => false,
																						'div' => false
																					)
																				);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Facebook </b> </td>
			<td> : </td>
			<td>
				<?php 
						echo $this->Form->input('',array(
																						'name' => 'Profile[facebook]',
																						'value' => $Profile['facebook'],
																						'placeholder' => 'Enter Facebook',
																						'label' => false,
																						'div' => false
																					)
																				);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Email </b> </td>
			<td> : </td>
			<td>
				<?php 
						echo $this->Form->input('',array(
																						'name' => 'Profile[email]',
																						'value' => $Profile['email'],
																						'placeholder' => 'Enter Email Address',
																						'label' => false,
																						'div' => false
																					)
																				);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Gender </b> </td>
			<td> : </td>
			<td> 
				<?php 
						echo $this->Form->select('',array(
																						'M' => 'Male',
																						'F' => 'Female'
																							),
																				array(
																					'name' => 'Profile[gender]',
																					'empty' => 'Select Gender',
																					'value' => $Profile['gender']
																					)
																				);
				?>
			</td>
		</tr>
			<tr> 
			<td> <b> Address </b> </td>
			<td> : </td>
			<td>  
				<?php
					echo $this->Form->textarea('',array(
																						'name' => 'Profile[address]',
																						'id' => 'address',
																						'value' => $Profile['address']
																					)
																				);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Contact Person </b> </td>
			<td> : </td>
			<td>
				<?php
					echo $this->Form->input('',array(
																					'name' => 'Profile[contact_person]',
																					'value' => $Profile['contact_person'],
																					'placeholder' => 'Enter Contact Person ',
																					'label' => false,
																					'div' => false
																				)
																			);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Contact Person No </b> </td>
			<td> : </td>
			<td>
				<?php 
						echo $this->Form->input('',array(
																						'name' => 'Profile[contact_person_no]',
																						'value' => $Profile['contact_person_no'],
																						'placeholder' => 'Enter Contact Person No',
																						'label' => false,
																						'div' => false
																					)
																				);
					?>
			</td>
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
						echo " ";
						echo $this->Form->button('Browse <span class="icon-edit"></span>',array(
																								'id' => 'btn-browse-signature',
																								'class' => 'btn btn-success'
																							)
																						);

						echo $this->Form->file(' ',array(
																						'name' => 'file-signature-picture',
																						'id' => 'file-signature',
																						'class' => 'file'
																					)
																				);
					?>

			</td>
		</tr>
		<tr>
			<td colspan=2> </td>
			<td>
					<center>
						<?php
							echo $this->Form->submit('Save',array(
																									'class' => 'btn btn-primary'
																								)
																							);
						?>
					</center>
			</td>
		</tr>
	</table>
	</form>
</div>
