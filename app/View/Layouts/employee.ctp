<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>

		<?php echo $this->fetch('title'); ?>
	</title>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<?php

		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap-2.3');
		echo $this->Html->css('datepicker');
		echo $this->Html->css('style.css');
		
		echo $this->Html->script('jquery-1.11.2.min');
		
		echo $this->fetch('meta');
		//echo $this->fetch('css');
		echo $this->fetch('script');

	?>
</head>
<body>
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
              <li class="">
              </li>
            </ul>
          </ul>
          </div>
        </div>
      </div>
    </div>
	<div id="container" class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="sidebar-nav">
				    <div class="well" style="width:300px; padding: 8px 0;">
						<ul class="nav nav-list"> 
						  <li class="nav-header">Employee Menu</li>        
						  <li><a href="index"><i class="icon-home"></i> Dashboard</a></li>
							<li><a href="/employees/profile"><i class="icon-user"></i> My Profile</a></li>
							<li><a href="/employees/accounts"><i class="icon-file"></i> Accounts</a></li>
							<li><a href="/employees/attendances"><i class="icon-calendar"></i> My Attendances</a></li>
						  <li><a href="/users/logout"><i class="icon-share"></i> Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="span9">
				<div id="content">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
			 
			
			<div id="footer">
					
			</div>
		</div>
	</div>
</body>
<?php
	echo $this->Html->script('bootstrap-datepicker');
	echo $this->Html->script('bootstrap.min');
	echo $this->Html->script('script');
?>
</html>
