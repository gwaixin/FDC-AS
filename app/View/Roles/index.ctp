<div class="container">
 	<div class="row">
		<div class="sm-container roles-container">
		<input type="hidden" id="url" value="<?php echo $this->webroot; ?>">
		<h1>Role list:</h1>
			<div id="search-Role-container" class="form-control">
			<?php 
				echo $this->Form->create('Role',array('id' => 'Privlegelist','type' => 'get', 'url' => '/admin/roles/search'));
				echo $this->Form->input('text',array(
								'div' => false,
								'name' => 'search',
								'id' => 'txtsearch',
								'value' => '',
								'label' => 'Description:'
	
							));
			   echo $this->Form->end();
			?>		
		</div>
		<table class="table">
              <thead>
                <tr>
                  <th>#:</th>
                  <th>description</th>
                  <th>Status</th>
                  <th>
                 	 <a href="<?php echo $this->webroot; ?>admin/roles/add" class="btn pull-right" ><i class="icon-plus-sign"></i> ADD</a>
                  </th>
                </tr>
              </thead>
              <tbody>
              <?php
              	 $num = 1;
              	 foreach ($data as $row){
              ?>
                <tr class="role-id-<?php echo $row['Role']['id'];?>">
                  <td><?php echo $num; ?></td>
                  <td><?php echo $row['Role']['description'];?></td>
                  <td><?php echo $row['Role']['status'];?></td>
                  <td>
                  	<a href="#" class="btn btn-danger btnRole" type="button" data-Role-id="<?php echo $row['Role']['id'];?>">Delete</a>
                  	<a href="<?php echo $this->webroot; ?>admin/roles/edit/<?php echo $row['Role']['id']; ?>" class="btn btn-primary" data-Role-id="<?php echo $row['Role']['id'];?>">Edit</a>
                  </td>
                </tr>
            <?php
            	$num ++;
            	}
            ?>    
              </tbody>
            </table>
            <div class="pagination Role-paginates">
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