
<style>
#login-container {
	margin: 80px auto;
	width: 300px;
}
</style>
<div id="login-container">
<big style="color:red;"> <?php echo $this->Session->flash(); ?> </big>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <?php 
    		echo $this->Form->input('username');
   		  echo $this->Form->input('password');
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
