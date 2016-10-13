<script src="<?php echo $this->request->webroot; ?>js/jquery-1.11.2.js"></script>
<?php
	echo $this->Html->script('bulk_select.js');
	$menu_modules = unserialize($this->request->session()->read('modules'));
?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span>Feedbacks</h3>
					</div>
					<div class="col-md-6">
 						<div class="row">
							<div class="col-md-12  text-right">
							 <?php
				                    if (array_key_exists("add", $module_pages)):
				                        $page_id = $module_pages["add"];
				                        foreach ($user_permission as $permission):
				                            if ($permission['page_id'] == $page_id):?>
				                                    <a href="<?php echo $this->Url->build('/feedbacks/add/'); ?>"  class="btn btn-success btn-flat btn-grid">
				                                        <i class="fa fa-plus-square"></i>
				                                        <?php echo __('ADD_FEEDBACK'); ?>
				                                    </a>
				                                    <?php
				                                break;
				                            endif;
				                        endforeach;
				                    endif;
			                    ?>

					<div class="btn-group">
                  	<button type="button" class="btn btn-primary"><?php echo __('Feedback Management'); ?></button>
                  	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  	</button>
                  	<ul class="dropdown-menu" role="menu">
                   <?php 
					      $access_submodule=array();
					      foreach($user_permission as $row){
					      if(!in_array($row['submodule_id'],$access_submodule))
					      $access_submodule[]=$row['submodule_id'];
					      }
						  $current_module = array_values($current_module);
						  $current_sub_module = $this->request->params['controller'];
						  foreach($menu_modules as $module){
								if($module["id"] == $current_module[0]){
									foreach($module['sub_modules'] as $submodule ){ 
										if(in_array($submodule['id'],$access_submodule)){
											if($submodule['controller_name'] != $current_sub_module){
											 	$sub_icon='<i class="fa fa-circle-o"></i>';
          									 if($submodule['icon']!=""){
           										$sub_icon=$submodule['icon'];
          									 }
										?>
										<li>
											<a href="<?php  echo $this->Url->build(["controller" =>$submodule['controller_name'] ,"action" => "index"]); ?>"><?php echo $sub_icon. $submodule['name'] ?></a>
			                        	</li>
							<?php
										}
									}
								}
							}
						}
					?>
                    </ul>
                	</div>
              	</div>
              </div>
            </div>
		</div>
      </div>
     </div> 
   </div>             
</div>

<div class="row">
	<div class="col-md-12">
    	<div class="box box-primary">
            <div class="box-header">

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
                            <?php
								if (array_key_exists ( "delete", $module_pages )) :
								$page_id = $module_pages ["delete"];
									foreach ( $user_permission as $permission ) :
										if ($permission ['page_id'] == $page_id) :
									?>
                                        <?= $this->Form->create(null, ['url' => ['controller' => 'feedbacks', 'action' => 'bulkAction']]); ?>
                                        <?= $this->Form->hidden('selected_content'); ?>
                                      	<div class="col-md-6">
                                            <?php echo $this->Form->input('bulk_action', array('label' => false, 'options' => $bulk_actions, 'empty' => __('Bulk Action'), 'required' => true, 'class' => 'form-control')); ?>
                                        </div>

							      		<div class="col-md-6">
                                            <?= $this->Form->button(__('Apply'), ['id' => 'bulk_action_apply', 'class' => 'btn btn-success btn-flat'])?>
                                        </div>
                                        <?= $this->Form->end(); ?>
                                        <?php																													
                                    		endif;
											endforeach;
											endif;
										?>
                        
               		</div>
               		<div class="clearfix">&nbsp;</div>
	                <div class="row">
	                <div class="col-md-6 ">
	                <div class="row">                
		               <?= $this->Form->create(null, array('type' => 'get','id'=>'limitForm')); ?>
		               <div class="col-md-2"><strong>Show</strong></div>
		               <div class="col-md-4"><select name="page_limit"  class="form-control input-sm"  onchange="this.form.submit()">
		               <option value="10" <?php echo $page_limit=="10"?'selected="selected"':''  ?>> 10</option>
		               <option value="25" <?php echo $page_limit=="25"?'selected="selected"':''  ?>>25</option>
		               <option value="50" <?php echo $page_limit=="50"?'selected="selected"':''  ?>>50</option>
		               <option value="100" <?php echo $page_limit=="100"?'selected="selected"':''  ?>>100</option>
		               </select>
		               </div>
		              <?= $this->Form->end(); ?>
                   </div>
                   </div>                 
                 </div>
				</div>
				<!-- /col-md-6 -->
				<div class="col-md-6">				
					<div class="row">
						<div class="col-md-12">                 
                         	<div class="row">                        
                        		<div class="col-md-8 pull-right">
                        		<?= $this->Form->create(null, array('type' => 'get')); ?>

                       			<div class="box-tools">
									<div class="input-group input-group-sm">
                            			<?=$this->Form->input ( '', [ 'placeholder' => __ ( 'SEARCH' ),'class' => 'form-control','type' => 'text','name' => 'search','value' => $searchText,'id' => 'search' ] );?>
                           			<div class="input-group-btn">
                                    	<?=$this->Form->submit ( __ ( 'Search Feedback' ), [ 'class' => 'btn btn-success btn-flat' ] );?>
                                	</div>
									</div>
								</div>
                        		</div>
                        	</div>                 
                        	<?= $this->Form->end(); ?>
                    	</div>
						<div class="col-md-12">				
					        &nbsp;
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
            
            <!-- /.box-header -->
<div class="box-body table-responsive ">
    <table class="table table-striped table-bordered table-hover">             
        <thead>
            <tr>
                <th>
                    <div>
                         <input type="checkbox"  id="ContentSelect">
                          <label class="image-checkbox-label" for="ContentSelect"></label>
                    </div>
                 </th>
                 <th class="sorting_asc"><?= $this->Paginator->sort('Feedbacks.id', ['value' => __('Feedback ID')]) ?></th>
                 <th><?= $this->Paginator->sort('Feedbacks.name', ['value' => __('Name')]) ?></th>
                 <th><?= $this->Paginator->sort('Feedbacks.email', ['value' => __('Email')]) ?></th>
                 <th><?= $this->Paginator->sort('Feedbacks.subject', ['value' => __('Subject')]) ?></th>
                 <th><?= $this->Paginator->sort('Feedbacks.date', ['value' => __('Date')]) ?></th>
                 <th><?= $this->Paginator->sort('Feedbacks.status', ['value' => __('Status')]) ?></th>
                 <th class="text-right"><?=  __('Action') ?></th>
              </tr>
           </thead>
           <tbody>
           <?php
           		$count = 1;
                foreach ($feedbacks as $feedback): ?>
               <tr>
                   <td>
                       <div>
                            <input type="checkbox" id="content_<?= $feedback->id ?>">
                            <label class="image-checkbox-label" for="content_<?= $feedback->id ?>"></label>
                       </div>
                   </td>
                   <td><?= $feedback->id ?></td>
                   <td><?= $feedback->name ?></td>
                   <td><?= $feedback->email ?></td>
                   <td><?= $feedback->subject ?></td>
                   <td><?= $feedback->date ?></td>
                   <td><?php 
						if($feedback->status==0){
							echo "Pending";
						} else{
							echo "Replied";
						}
						?>
					</td>
                   <td class=" text-right">
				       <div class="btn-group">             
                  	       <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    	   <i class="fa fa-list"></i> <span class="caret"></span>
                    	   <span class="sr-only">Toggle Dropdown</span>
                  		   </button>
                  	<ul class="dropdown-menu dropdown-menu-right" role="menu">
                  			<li>                                                                      
                            	<a data-toggle="modal" class="viewModal" id=<?php echo $feedback->id;?>><i class="fa fa-list-alt"></i><?php echo __('View') ?></a>                                                                
                        	</li> 
     					<li>  
     						<?php
                                  if (array_key_exists("delete", $module_pages)):
                                       	$page_id = $module_pages["delete"];
                                             foreach ($user_permission as $permission):
                                                 if ($permission['page_id'] == $page_id):?>                                                                     
                                                       <?php echo $this->Form->postLink(' <i class="fa fa-trash-o"></i>'.__('DELETE'), ['action' => 'delete', $feedback->id], ['confirm' => __('Are you sure you want to delete {0}?', $feedback->subject),'escape'=>false]) ?>                                                                  
                                                       <?php
                                                            break;
                                                            endif;
                                                        	endforeach;
                                                    		endif;
                                                    	?>
                        </li> 
                        <li>
                     		<?php
                                  if (array_key_exists("reply", $module_pages)):
                                      $page_id = $module_pages["reply"];
                                      foreach ($user_permission as $permission):
                                      if ($permission['page_id'] == $page_id):?>
                                      	<a href="<?php echo $this->Url->build(['action' => 'reply', $feedback->id]) ?>"><i class="fa fa-pencil"></i><?php echo __('Reply') ?></a>
                                      <?php
                                           break;
                                           endif;
                                           endforeach;
                                           endif;
                                      ?>
                    	</li>            
                  </ul>
                  </div>                                       
                  </td>
                        </tr>
                             <?php
                                    $count++;
                                    endforeach;
                              ?>
              </tbody>
              </table>                            
                            
            </div>
            <!-- /.box-body -->
            <?php
            //debug($this->Paginator->params());
            if($this->Paginator->params()['nextPage']){
	            $start_limit=(($this->Paginator->params()['page']* $this->Paginator->params()['current'])-$this->Paginator->params()['perPage'])+1;
	            $end_limit=$this->Paginator->params()['page']* $this->Paginator->params()['current'];
            }
            else{
	            if($this->Paginator->params()['count']!=0){
	            $start_limit=($this->Paginator->params()['count']-$this->Paginator->params()['current'])+1;
            }
            else{
            	$start_limit=0;
            }
            	$end_limit=$this->Paginator->params()['count'];
            }
            ?>
            <div class="box-footer clearfix">
               <div class="row">
                     <div class="col-md-6"><p style="padding-top:20px;"><?php echo 'Showing '.  $start_limit .' to '. $end_limit. ' of ' . $this->Paginator->params()['count']. ' entries';?></p></div>
                            <div class="col-md-6">
								<div class="paginator pull-right">
						        <ul class="pagination ">
						            <?= $this->Paginator->prev('< ' . __('previous')) ?>
						            <?= $this->Paginator->numbers() ?>
						            <?= $this->Paginator->next(__('next') . ' >') ?>
						        </ul>						      
						        </div>													
					          </div>
			    </div> 
			</div>           
        </div>
          <!-- /.box -->
    </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="details_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> 
             <div class ="loading_icon text-center">
 				<img src="<?php echo $this->Url->build('/images/loadingicon.gif'); ?>"/>
 				<span>Loading...</span>
 			</div>               
            </div>
            <!-- / modal-content -->
        </div>
        <!-- / modal-dialog -->
    </div>
 <!-- Modal -->
 
 <style>
 .loading_icon img{
  margin-top: 100px;
  margin-bottom: 100px;
}
</style>
 <script>
$(document).ready(function(){
	$('.viewModal').click(function(){
		$('#details_modal').modal('show');	
		var id = $(this).attr('id'); 
		$.ajax({
			  method: "POST",
			  url: "<?php echo $this->Url->build(['action' => 'view'])?>",
			  data: { id: id}
			})
			  .done(function( msg ) {
				  $('.modal-content').html(msg);
			  });
	});
});
 </script>
 