<div class="contract-container">
	<input type="hidden" id="url" value="<?php echo $this->webroot;?>">
	<h1>Contract History</h1>
		<table class="table table-list-contract table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Employees ID</th>
                  <th>Description</th>
                  <th>Date Start</th>
                  <th>Date End</th>
                  <th>Document</th>
                  <th>Salary</th>
                  <th>Deminise</th>
                  <th>Term</th>
                  <th>Status</th>
                  <th>Position</th>
                  <th>Position level</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              	$num = 1;
              	 foreach ($data as $row){
              ?>
                <tr>
                  <td><?php echo $num++;?></td>
                  <td><?php echo $row['emp']['employee_id'];?></td>
                  <td><?php echo $row['Contractlog']['description'];?></td>
                  <td><?php echo $row['Contractlog']['date_start'];?></td>
                  <td><?php echo $row['Contractlog']['date_end'];?></td>
                  <td><?php echo $row['Contractlog']['document'];?></td>
                  <td><?php echo $row['Contractlog']['salary'];?></td>
                  <td><?php echo $row['Contractlog']['deminise'];?></td>
                  <td><?php echo $row['Contractlog']['term'];?></td>
                  <td><?php echo $row['Contractlog']['status'];?></td>
                  <td><?php echo $row['post']['description'];?></td>
                  <td><?php echo $row['postlevel']['description'];?></td>
                  <td>
                  	<?php
                  		if($row['Contractlog']['status'] == 0):
                  	?>
                  		<a href="#View-Contract" role="button" data-toggle="modal" data-id-contract="<?php echo $row['Contractlog']['employees_id'].':'.$row['Contractlog']['id']; ?>" class="View-Contract btn btn-info" >Info</a>
                  	<?php else: ?>
                  		<a href="<?php echo $this->webroot;?>contractlogs/update/<?php echo $row['Contractlog']['id'];?>" class="btn btn-primary" type="button">Edit</a>
                  	<?php endif; ?>
                  </td>
                </tr>
            <?php
            	}
            ?>    
              </tbody>
       </table>
</div>	
<!-- Modal -->
<div class="modal hide fade" id="View-Contract" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail</h4>
      </div>
      <div class="modal-body">
			<div class="form-horizontal">
			  <div class="control-group">
			    <label for="inputEmail3" class="col-sm-2 control-label">Employees ID:</label>
			    <div class="controls">
			      	<span id="employee-id"></span>
			    </div>
			  </div>
			  <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
			    <div class="controls">
			      <span id="description"></span>
			    </div>
			  </div>
			  <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Date Start</label>
			    <div class="controls">
			      <span id="date-start"></span>
			    </div>
			 </div>
			 <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Date End</label>
			    <div class="controls">
			      <span id="date-end"></span>
			    </div>
			 </div>
			 <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Document</label>
			    <div class="controls">
			      <span id="document"></span>
			    </div>
			 </div>
			  <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Salary</label>
			    <div class="controls">
			      <span id="salary"></span>
			    </div>
			 </div>
			  <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Deminise</label>
			    <div class="controls">
			      <span id="deminise"></span>
			    </div>
			 </div>
			  <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Term</label>
			    <div class="controls">
			      <span id="term"></span>
			    </div>
			 </div>
			  <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Position</label>
			    <div class="controls">
			      <span id="position"></span>
			    </div>
			 </div>
			  <div class="control-group">
			    <label for="inputPassword3" class="col-sm-2 control-label">Position level</label>
			    <div class="controls">
			      <span id="position-level"></span>
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