<div class="container-fluid">
 	<div class="row-fluid">
		<div class="lg-container main-content box-center">
		<input type="hidden" id="url" value="<?php echo $this->webroot; ?>">
		<h3>Company List:</h3>
			<div id="search-role-container" class="form-control">
			<?php 
				echo $this->Form->create('Companysystem',array('id' => 'Company-system','type' => 'get','action' => 'index'));
				echo $this->Form->select('field',
						array(
								'name' => 'Name',
								'address' => 'Address',
								'description' => 'Description',
								'owner' => 'Owner',
								'deleted' => 'Delete',
						),
						array(
								'name' => 'action',
								'empty' => 'Search By',
								'id' => 'cm-search',
								'value' => $action,
								'class' => 'form-control span3'
						)
				);
				echo $this->Form->select('field',
						array(
								'name' => 'Name',
								'address' => 'Address',
								'description' => 'Description',
								'owner' => 'Owner'
						),
						array(
								'name' => 'action_delete',
								'empty' => 'Search By',
								'id' => 'cm-search-by',
								'style' => $display,
								'value' => $action_by,
								'class' => 'form-control span3'
						)
				);
				echo $this->Form->input('text',array(
								'div' => false,
								'class' => 'form-control span3',
								'name' => 'search',
								'id' => 'txtsearch',
								'value' => $keyword,
								'label' => false
	
							));
			   echo $this->Form->end();
			?>		
		</div>
		<table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Description</th>
                  <th>Date Start</th>
                   <th>Owner</th>
                  <th>Status</th>
                  <th>
                 	 <a href="<?php echo $this->webroot; ?>admin/company/add" class="btn pull-right" ><i class="icon-plus-sign"></i> ADD</a>
                  </th>
                </tr>
              </thead>
              <tbody>
              <?php
              	 $num = 1;
              	 foreach ($data as $row){
              ?>
                <tr class="role-id-<?php echo $row['Companysystem']['id'];?>">
                  <td><?php echo $num;?></td>
                  <td><?php echo $row['Companysystem']['name'];?></td>
                  <td><?php echo $row['Companysystem']['address'];?></td>
                  <td><?php echo $row['Companysystem']['description'];?></td>
                  <td><?php echo $row['Companysystem']['date_start'];?></td>
                  <td><?php echo $row['Companysystem']['owner'];?></td>
                  <td><?php echo ($row['Companysystem']['status'])? 'Active' : 'Inactive';?></td>
                  <td>
                  	<a href="#" class="btn btn-danger btnCompDelete" type="button" data-role-id="<?php echo $row['Companysystem']['id'];?>">Delete</a>
                  	<a href="<?php echo $this->webroot; ?>admin/company/edit/<?php echo $row['Companysystem']['id']; ?>" class="btn btn-primary" data-role-id="<?php echo $row['Companysystem']['id'];?>">Edit</a>
                  </td>
                </tr>
            <?php
            	$num++;
            	}
            ?>    
              </tbody>
            </table>
            <div class="pagination role-paginates">
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