<div class="container">
	<div class='row'>
		<div class="list-container">
<<<<<<< HEAD
			<div class="col-md-12">
=======
			<div class="span12">
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
				<h4>Profile list</h4>
				<input type="hidden" id="url" value="<?php echo $this->webroot;?>">
				<a href="<?php echo $this->webroot.'profiles/profile_register'; ?>" ><i class="fa fa-plus-square"></i> ADD</a>
			</div>
	<?php
		foreach($data as $row) {
	?>
	
<<<<<<< HEAD
		<div class="col-md-3 pro-id-<?php echo $row['Profile']['id']; ?>">
=======
		<div class="span3 box-span pro-id-<?php echo $row['Profile']['id']; ?>">
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
			<div class="thumbnail box-shadow-cont">
				<div class="modal-header">
		            <button type="button" class="close delete-list" data-profid="<?php echo $row['Profile']['id']; ?>"><i class="fa fa-times"></i></button>
		            <h4 class="modal-title" id="modal-title">
		           		<h4><?php echo $row['Profile']['first_name']. ' ' .$row['Profile']['middle_name'].' '.$row['Profile']['last_name'];?></h4>
		            </h4>
	          	</div>
				<div class="prof-table">
					<div class="prof-img-cont">
						<?php 
							
							$img = ($row['Profile']['picture'])? $this->webroot.'upload/'.$row['Profile']['picture'] :  $this->webroot.'/img/emptyprofile.jpg' ;
							
							
						?>					
						<img class="img-responsive" src="<?php echo $img; ?>" alt="...">
					</div>
				</div>
				<div class="caption">
					
					<p class='game-options'>
						<span>
<<<<<<< HEAD
							<a href='#' class="view-detail" data-toggle="modal" data-target=".bs-example-modal-lg" data-view-id="<?php echo $row['Profile']['id']; ?>">
=======
							<a href="#myModal" role="button" class="view-detail" data-toggle="modal" data-view-id="<?php echo $row['Profile']['id']; ?>">
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
								<i class="fa fa-eye"></i>
							</a>
						</span>
						<span>
							<a href='<?php echo $this->webroot.'profiles/profile_update/'.$row['Profile']['id']; ?>'>
								<i class="fa fa-pencil"></i>
							</a>
						</span>
						<span>
							<a href='javascript:;'>
								<i class="fa fa-trash"></i>
							</a>
						</span>
					</p>
					<!-- <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p> -->
				</div>
			</div>
		</div>
	<?php
	}
	?>
		</div>
		
<<<<<<< HEAD
	<div class='col-lg-12' >
		<div class="paginate">
				<nav>
					<ul class="pagination">
=======
	<div class='span12' >
		<div class="paginate">
				<div class="pagination">
					<ul>
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
						<?php echo $this->Paginator->prev('« ', array('tag'=>'li'), null, array('class'=>'disabled'));?>
							
						<?php echo $this->Paginator->numbers(
								array(
										'modulus' => 4,
										'tag' => 'li',
										'separator' => '', 
										'currentClass' => 'active',
										'currentTag' => 'span'
									)
								);
						?>
						<?php echo $this->Paginator->next('»', array('tag'=>'li',), null, array('class'=>'disabled'));?>
					</ul>		
<<<<<<< HEAD
				</nav>
=======
				</div>
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
			</div>
	</div>	
	</div>
</div>

<!-- Modal -->
<<<<<<< HEAD
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
=======
<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail</h4>
      </div>
      <div class="modal-body">
<<<<<<< HEAD
      	<div class='row'>
      		 <div class="col-md-8">
      		 	<ul class="list-group">
	                <li class="list-group-item text-muted" contenteditable="false">Profile</li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Full name:</strong></span> <div id="f_name">ss</div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Birth Date:</strong></span> <div id="birth"></div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Contact no.</strong></span> <div id="c_no"></div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Facebook:</strong></span> <div id="fb"></div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Email: </strong></span> <div id="email"></div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Gender: </strong></span> <div id="gender"></div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Address: </strong></span> <div id="address"></div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Contact Person: </strong></span><div id="c_p"></div></li>
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Contact Person #: </strong></span><div id="c_p_no"></div></li>
	                <li class="list-group-item text-right">
	               		 <span class="pull-left"><strong class="">Signature:</strong></span>
	               		 <div id="sig">
	               		 	<div class="img-cont">
								<div class="img-prev">
									<img src="upload/250x250_1431660000.jpg" alt="CakePHP" class="img-responsive sig-prev">
=======
      		 	<ul class="list-group span5">
	                <li class="list-group-item text-muted" >Profile</li>
	                <li class="list-group-item "><span class=""><strong class="">Full name:</strong></span> <div id="f_name" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Birth Date:</strong></span> <div id="birth" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Contact no.</strong></span> <div id="c_no" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Facebook:</strong></span> <div id="fb" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Email: </strong></span> <div id="email" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Gender: </strong></span> <div id="gender" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Address: </strong></span> <div id="address" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Contact Person: </strong></span><div id="c_p" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Contact Person #: </strong></span><div id="c_p_no" class="pull-right"></div></li>
	                <li class="list-group-item ">
	               		 <span class=""><strong class="">Signature:</strong></span>
	               		 <div id="sig">
	               		 	<div class="img-cont">
								<div class="img-prev">
									<img src="/FDC_AS/img/emptyprofile.jpg" alt="CakePHP" class="img-responsive sig-prev">
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
								</div>
							</div>
	               		 </div>
	                </li>
            	</ul>
<<<<<<< HEAD
      		 </div>
	      	 <div class="col-md-4">
		        <div class="img-cont">
=======
            	<div class="img-cont span4">
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
					<div class="img-prev">
						<img src="/FDC_AS/img/emptyprofile.jpg" alt="CakePHP" id="img_preview" class="img-responsive">
					</div>
				</div>
<<<<<<< HEAD
			 </div>	
		</div>
=======
>>>>>>> 27eb62a9280065e1b3a5943210263340afde1305
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>