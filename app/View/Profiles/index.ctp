<div class="container">
	<div class='row'>
		<div class="list-container">
			<div class="span12">
				<h4>Profile list</h4>
				<input type="hidden" id="url" value="<?php echo $this->webroot;?>">
				<a href="<?php echo $this->webroot.'profiles/profile_register'; ?>" ><i class="fa fa-plus-square"></i> ADD</a>
			</div>
	<?php
		foreach($data as $row) {
	?>
	
		<div class="span3 box-span pro-id-<?php echo $row['Profile']['id']; ?>">
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
							
							$img = ($row['Profile']['picture'])? $this->webroot.'upload/'.$row['Profile']['picture'] :  $this->webroot.'img/emptyprofile.jpg' ;
							
							
						?>					
						<img class="img-responsive" src="<?php echo $img; ?>" alt="...">
					</div>
				</div>
				<div class="caption">
					
					<p class='game-options'>
						<span>
							<a href="#myModal" role="button" class="view-detail" data-toggle="modal" data-view-id="<?php echo $row['Profile']['id']; ?>">
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
		
	<div class='span12' >
		<div class="paginate">
				<div class="pagination">
					<ul>
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
				</div>
			</div>
	</div>	
	</div>
</div>

<!-- Modal -->
<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail</h4>
      </div>
      <div class="modal-body">
      		 	<ul class="list-group span5">
	                <li class="list-group-item text-muted" >Profile</li>
	                <li class="list-group-item "><span class=""><strong class="">Full name:</strong></span> <div id="f_name" class="pull-right"></div></li>
	                <li class="list-group-item "><span class=""><strong class="">Nick name:</strong></span> <div id="nk_name" class="pull-right"></div></li>
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
								</div>
							</div>
	               		 </div>
	                </li>
            	</ul>
            	<div class="img-cont span4">
					<div class="img-prev">
						<img src="/FDC_AS/img/emptyprofile.jpg" alt="CakePHP" id="img_preview" class="img-responsive">
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>