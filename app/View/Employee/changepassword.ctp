<style>
#change-password-container {
	margin: 100px auto;
	width: 400px;
	background: #F9F9F9;
	padding: 10px 20px;
}
</style>
<div id="change-password-container">
	<legend> Change Password </legend>
	<?php 
	foreach($errors as $error):
		echo '<div class="alert alert-error">
					    <a href="#" class="close" data-dismiss="alert">&times;</a>
					    <strong>Error!</strong> '.$error.'.
					</div>';
	endforeach;
	?>
	<?php
	echo $this->form->create('post');
	
	echo "<table>
					<tbody>
				 		<tr>
				 			<td> <b> Current Password </b> </td>
				 			<td>". $this->form->password('Current Password',array(
														'name' => 'current_password',
														'placeholder' => 'Enter Current Password',
														'required',
														'div' => false,
														'value' => (isset($new_password)) ? $current_password : ''
													)
												).
			 				"</td>
						</tr>
					</tbody>
					<tbody>
				 		<tr>
				 			<td> <b> New Password </b> </td>
				 			<td>". $this->form->password('New Password',array(
														'name' => 'new_password',
														'placeholder' => 'Enter New Password',
														'required',
														'div' => false,
														'value' => (isset($new_password)) ? $new_password : ''
													)
												).
			 				"</td>
						</tr>
					</tbody>
					<tbody>
				 		<tr>
				 			<td> <b> Confirm Password </b> </td>
				 			<td>". $this->form->password('Confirm Password',array(
														'name' => 'confirm_password',
														'placeholder' => 'Enter Confirm Password',
														'required',
														'div' => false,
														'value' => (isset($confirm_password)) ? $confirm_password : ''
													)
												).
			 				"</td>
						</tr>
					</tbody>
					<tbody>
				 		<tr>
				 			<td> </td>
				 			<td><center>". $this->form->submit('Submit',array(
														'class' => 'btn btn-primary'
													)
												).
			 				"</center></td>
						</tr>
					</tbody>
				<table>";
	echo $this->form->end();
	?>
</div>