<div class="container">
	<div class='row'>
		<div class="list-container">
			<div class="col-md-12">
				<h4>Profile list</h4>
				<input type="hidden" id="url" value="<?php echo $this->webroot;?>">
				<a href="<?php echo $this->webroot.'profiles/profile_register'; ?>" ><i class="fa fa-plus-square"></i> ADD</a>
			</div>
	<?php
		foreach($data as $row) {
	?>
	
		<div class="col-md-3 pro-id-<?php echo $row['Profile']['id']; ?>">
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
							<a href='#' class="view-detail" data-toggle="modal" data-target=".bs-example-modal-lg" data-view-id="<?php echo $row['Profile']['id']; ?>">
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
		
	<div class='col-lg-12' >
		<div class="paginate">
				<nav>
					<ul class="pagination">
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
				</nav>
			</div>
	</div>	
	</div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail</h4>
      </div>
      <div class="modal-body">
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
	                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Signature:</strong></span><div id="sig"></div></li>
            	</ul>
      		 </div>
	      	 <div class="col-md-4">
		        <div class="img-cont">
					<div class="img-prev">
						<img src="/FDC_AS/img/emptyprofile.jpg" alt="CakePHP" id="img_preview" class="img-responsive">
					</div>
				</div>
			 </div>	
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>