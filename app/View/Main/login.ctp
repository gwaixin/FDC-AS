
<style>
#login-container {
	margin: 100px auto;
	width: 500px;
}
#flashMessage {
	color: red;
}
</style>
<div id="login-container">
	<?php
	echo $this->Session->Flash();
	echo $this->Form->create('post');
	echo $this->Form->input(' ',array(
																		'name' => 'username',
																		'value' => $username,
																		'placeholder' => 'Username',
																	)
															);

	echo $this->Form->password(' ',array(
																		'name' => 'password',
																		'value' => $password,
																		'placeholder' => 'Password'
																	)
															);
	echo $this->Form->submit('Sign in',array(
																	'class' => 'btn btn-primary'
																)
															);
	echo $this->Form->end();
	?>
</div>