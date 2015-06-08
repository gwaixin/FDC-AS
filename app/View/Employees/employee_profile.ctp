<script>
$(document).ready(function() {

	$('#birthdate').datepicker();
	$("#btn-browse-profile").click(function(){
		$("#tmp-file-profile").click();
	});
	$("#tmp-file-profile").change(function() {
		var img = URL.createObjectURL($("#tmp-file-profile")[0].files[0]);
		$("#img-profile").attr('src',img);
		$("#file-picture")[0].files = $("#tmp-file-profile")[0].files;
	});

	$("#btn-browse-signature").click(function(){
		$("#file-signature").click();
	});

	$("#file-signature").change(function() {
		var img = URL.createObjectURL($("#file-signature")[0].files[0]);
		$("#img-signature").attr('src',img);
	});
	

	$(document).click(function(e) {
		if(e.target.className === 'modal-backdrop fade in') {
			$("#modalSignature").modal('hide');
		}
	});

});
</script>

<h3> My Profile </h3>
<div id="profile-container">
	<div id="profile-picture-container">
		<input type="hidden" name="Profile[id]" value="<?php echo $Profile['id'] ?>">
		<div id="profile-picture">
			<img src="<?php echo $Profile['picture']; ?>" id="img-profile">
		</div>
		<?php
			echo $this->Form->create('post');
			echo $this->Form->file(' ',array('name' => 'none',
																			 'class' => 'file',
																			 'id' => 'tmp-file-profile',
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
	<table class="table table-striped">
		<tr> 
			<td> <b> First Name </b> </td>
			<td> 
				<?php
					echo $this->Form->input('',array('name' => 'Profile[first_name]',
																					 'value' => $Profile['first_name'],
																					 'placeholder' => 'Enter First Name',
																					 'label' => false,
																					 'div' => false,
																					 'required'
																					)
																				);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Last Name </b> </td>
			<td>
					<?php
						echo $this->Form->input('',array('name' => 'Profile[last_name]',
																						 'value' => $Profile['last_name'],
																						 'placeholder' => 'Enter Las Name',
																						 'label' => false,
																					 	 'div' => false,
																						 'required'
																						)
																					);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Middle Name </b> </td>
			<td>
				<?php
					echo $this->Form->input('',array('name' => 'Profile[middle_name]',
																					 'value' => $Profile['middle_name'],
																					 'placeholder' => 'Enter Middle Name',
																					 'label' => false,
																					 'div' => false,
																					 'required'
																					)
																				);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Nick Name </b> </td>
			<td>
				<?php
					echo $this->Form->input('',array('name' => 'Profile[nick_name]',
																					 'value' => $Profile['nick_name'],
																					 'placeholder' => 'Enter Nick Name',
																					 'label' => false,
																					 'div' => false,
																					 'required'
																					)
																				);
				?>
				<i class="icon-warning-sign"></i> Optional
			</td>
		</tr>
		<tr> 
			<td> <b> Birth Date </b> </td>
			<td> 
				<div class="col-xs-6" >
				    <div class="right-inner-addon">
				        <!-- <i class="icon-calendar"></i> -->
				        <?php 
				        		$birthdate = explode('-',$Profile['birthdate']);
										$birthdate = $birthdate[1].'/'.substr($birthdate[2],0,2).'/'.$birthdate[0];
										echo $this->Form->input('',array('name' => 'Profile[birthdate]',
																										 'id' => 'birthdate',
																										 'value' => $birthdate,
																										 'label' => false,
																										 'div' => false,
																										 'required'
																										)
																									);
								?>
				    </div>
				</div>
			</td>
		</tr>
		<tr> 
			<td> <b> Contact </b> </td>
			<td>
					<?php 
						echo $this->Form->input('',array('name' => 'Profile[contact]',
																						 'value' => $Profile['contact'],
																						 'placeholder' => 'Enter Contact No',
																						 'label' => false,
																						 'div' => false,
																						 'required'
																						)
																					);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Facebook </b> </td>
			<td>
				<?php 
						echo $this->Form->input('',array('name' => 'Profile[facebook]',
																						 'value' => $Profile['facebook'],
																						 'placeholder' => 'Enter Facebook',
																						 'label' => false,
																						 'div' => false,
																						 'required'
																						)
																					);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Email </b> </td>
			<td>
				<?php 
						echo $this->Form->input('',array('name' => 'Profile[email]',
																						 'value' => $Profile['email'],
																						 'placeholder' => 'Enter Email Address',
																						 'label' => false,
																						 'div' => false,
																						 'required'
																						)
																					);
					?>
			</td>
		</tr>
		<tr> 
			<td> <b> Gender </b> </td>
			<td> 
				<?php 
						echo $this->Form->select('',array(
																						'M' => 'Male',
																						'F' => 'Female'
																							),
																				array(
																					'name' => 'Profile[gender]',
																					'empty' => 'Select Gender',
																					'value' => $Profile['gender'],
																					'required'
																					)
																				);
				?>
			</td>
		</tr>
			<tr> 
			<td> <b> Address </b> </td>
			<td>  
				<?php
					echo $this->Form->textarea('',array(
																						'name' => 'Profile[address]',
																						'id' => 'address',
																						'value' => $Profile['address'],
																						'required'
																					)
																				);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Contact Person </b> </td>
			<td>
				<?php
					echo $this->Form->input('',array(
																			'name' => 'Profile[contact_person]',
																			'value' => $Profile['contact_person'],
																			'placeholder' => 'Enter Contact Person ',
																			'label' => false,
																			'div' => false,
																			'required'
																		)
																	);
				?>
			</td>
		</tr>
		<tr> 
			<td> <b> Contact Person No </b> </td>
			<td>
					<?php
					echo $this->Form->input('',array(
																			'name' => 'Profile[contact_person_no]',
																			'value' => $Profile['contact_person_no'],
																			'placeholder' => 'Enter Contact Person ',
																			'label' => false,
																			'div' => false,
																			'required'
																		)
																	);
				?>
			</td>
		</tr>
		<tr style="display:none;">
			<td> </td>
			<td> 
				<?php
				?>
			</td>
		</tr>
		<tr>
			<td> Signature </td>
			<td>  
				<?php

					echo $this->Form->file(' ',array('name' => 'file-profile-signature',
																			 'class' => 'file',
																			 'id' => 'file-signature',
																			 'required' => false,
																			 'accept' => "image/*",'style' => 'display:none;'
																			)
																		);
					echo $this->Form->file(' ',array('name' => 'file-profile-picture',
																			 'class' => 'file',
																			 'id' => 'file-picture',
																			 'required' => false,
																			 'accept' => "image/*",'style' => 'display:none;'
																			)
																		);
					echo $this->Form->button('View <span class="icon-search"></span>',array(
																								'type' => 'button',
																								'id' => 'btn-view-signature',
																								'class' => 'btn btn-success'
																							)
																						);
					echo " ";
					echo $this->Form->button('Browse <span class="icon-edit"></span>',array(
																								'type' => 'button',
																								'id' => 'btn-browse-signature',
																								'class' => 'btn btn-success'
																							)
																						);
				?>
			</td>
		</tr>
	</table>
	<?php 
		echo $this->Form->end();
	?>
</div>