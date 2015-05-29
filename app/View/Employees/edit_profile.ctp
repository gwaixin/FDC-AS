<?php
echo $this->Html->css('employee-edit-profile');
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

<h3> My Profile </h3>
<?php 
	foreach($errors as $error):
		echo '<div class="alert alert-warning">
					    <a href="#" class="close" data-dismiss="alert">&times;</a>
					    <strong>Warning!</strong> '.$error[0].'.
					</div>';
	endforeach;
?>
<div id="profile-container">
<?php echo $this->Form->create('Profile',array('type' => 'file', 'class' => 'form-horizontal')); ?>
	<div id="profile-picture-container">
		<div id="profile-picture">
			<img src="<?php echo $this->webroot."$Profile[picture]"; ?>" id="img-profile">
		</div>
		<?php 			
			echo $this->Form->file(' ',array(
																			'name' => 'file-profile-picture',
																			'class' => 'file',
																			'id' => 'file-profile',
																			'required' => false,
																			'accept' => "image/*",'style' => 'display:none;'
																		)
																	);
			echo $this->Form->button('Browse <span class="icon-edit"></span>',array(
																								'type' => 'button',
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
																								'type' => 'button',
																								'class' => 'btn btn-success',
																								'data-toggle' => 'modal',
																								'data-target' => '#modalSignature',
																								'id' => 'btn-show-signature'
																							)
																						);
						echo " ";
						echo $this->Form->button('Browse <span class="icon-edit"></span>',array(
																								'type' => 'button',
																								'id' => 'btn-browse-signature',
																								'class' => 'btn btn-success'
																							)
																						);

						echo $this->Form->file(' ',array(
																						'name' => 'file-signature-picture',
																						'id' => 'file-signature',
																						'class' => 'file',
																						'required' => false,
																						'accept' => "image/*",'style' => 'display:none;'
																					)
																				);
					?>

			</td>
		</tr>
		<tr>
			<td colspan=2> </td>
			<td>
						<?php
							echo $this->Form->submit('Save',array(
																									'class' => 'btn btn-primary',
																									'div' => false
																								)
																							);
							echo " ";
							echo $this->Html->link('Cancel',array(
																								'controller' => 'employees',
																								'action' => 'profile'
																							),array(
																									'class' => 'btn btn-primary'
																								)
																							);
						?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
