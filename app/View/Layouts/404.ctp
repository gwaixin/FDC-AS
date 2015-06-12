<!DOCTYPE html>
<html>
<head>
	<title>404 Page</title>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('twitter-bootstrap.min');
		echo $this->Html->css('style.css');
		echo $this->Html->script('jquery-1.11.2.min');

	?>

</head>
<body>
	<div id="container">
		
		<div id="content">
			<div class="main-content">
				<div class="navbar navbar-inverse navbar-fixed-top nav-bar-mod">
				    <div class="navbar-inner">
				        <div class="container-fluid">
				          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				          </button>
				          <a class="brand" href="<?php echo $this->webroot;?>">FDC AS</a>
				          <div class="nav-collapse collapse">
				            <ul class="nav">
				              <!--  <li class="">
				                <a href="<?php echo $this->webroot;?>attendances">Attendance</a>
				              </li>-->
				            </ul>
				            <ul class="nav pull-right">
				              <li class="dropdown">
				                  <a href="#" data-toggle="dropdown" class="dropdown-toggle"> 
				                	<?php echo $this->Session->read('Auth.UserProfile.first_name')." ".
				                						 $this->Session->read('Auth.UserProfile.middle_name')." ".
				                						 $this->Session->read('Auth.UserProfile.last_name'); 
				                	?>
				                  <b class="caret"></b></a>
				                  <ul class="dropdown-menu">
										<li><a href="/admin/myprofile"><i class="icon-user"></i> My Profile</a></li>
										<li><a href="/admin/mycontracts"><i class="icon-file"></i> My Contracts</a></li>
										<li><a href="/admin/myaccounts"><i class="icon-briefcase"></i> My Accounts</a></li>
										<li><a href="<?php echo $this->webroot."users/logout"; ?>"><i class="icon-share"></i>Logout</a></li>
				                  </ul>
				              </li>
				          </ul>
				          </div>
				        </div>
				    </div>
			    </div>
				<center>
					<img src="<?php echo $this->webroot;?>img/404.jpg" />
					<p><a href="<?php echo $this->webroot;?>"><<< Back to Home Page</a></p>
				</center>

			</div>
		</div>
		<div id="footer">
				
		</div>
	</div>

</body>
<?php
	echo $this->Html->script('bootstrap.min');
?>
</html>