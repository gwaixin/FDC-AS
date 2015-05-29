
<style>
#login-container {
	margin: 80px auto;
	width: 300px;
}
#login-container #login-inputs {
  margin: 0px auto;
  width: 250px;
}
#login-container #login-inputs input {
  width: 250px;
}
</style>
<div id="login-container">
<?php
  if(isset($error)) {
    echo '<div class="alert alert-error">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> '.$error.'.
          </div>';
  }

  echo $this->Form->create('post'); ?>
    <div id="login-inputs">
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
</div>
