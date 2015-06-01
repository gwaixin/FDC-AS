<div class="container">
 	<div class="row">
		<div class="contract-container">
		<input type="hidden" id="url" value="<?php echo $this->webroot;?>">
		<h3>list Contract</h3>
		<table class="table">
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
              	 foreach ($data as $row){
              ?>
                <tr>
                  <td><?php echo $row['Contractlog']['id'];?></td>
                  <td><?php echo $row['Contractlog']['employees_id'];?></td>
                  <td><?php echo $row['Contractlog']['description'];?></td>
                  <td><?php echo $row['Contractlog']['date_start'];?></td>
                  <td><?php echo $row['Contractlog']['date_end'];?></td>
                  <td><?php echo $row['Contractlog']['document'];?></td>
                  <td><?php echo $row['Contractlog']['salary'];?></td>
                  <td><?php echo $row['Contractlog']['deminise'];?></td>
                  <td><?php echo $row['Contractlog']['term'];?></td>
                  <td><?php echo $row['Contractlog']['status'];?></td>
                  <td><?php echo $row['Contractlog']['positions_id'];?></td>
                  <td><?php echo $row['Contractlog']['position_levels_id'];?></td>
                </tr>
            <?php
            	}
            ?>    
              </tbody>
            </table>
	</div>	
</div>		