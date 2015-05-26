
<style>
#login-container {
	margin: 80px auto;
	width: 300px;
}
</style>
<div id="login-container">
<big style="color:red;"> <?php echo $this->Session->flash(); ?> </big>
<?php echo $this->Form->create('post'); ?>
    <fieldset>
        <?php 
    		echo $this->Form->input('username',array(
    																					'name' => 'username',
    																					'placeholder' => 'Enter Username',
                                              'value' => (isset($User)) ? $User['username'] : "",
    																					'required'
    																					)
    																				);
   		  echo $this->Form->input('password',array(
   		  																			'name' => 'password',
   		  																			'placeholder' => 'Enter Password',
                                              'value' => (isset($User)) ? $User['password'] : "",
   		  																			'required'
   		  																			)
   		  																		);
    		?>
    </fieldset>
<?php 
	echo $this->Form->submit('Sign in',array(
										'class' => 'btn btn-primary'
									)
								);
	echo $this->Form->end(); 
?>
</div>
