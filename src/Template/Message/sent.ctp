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
			
			<div class="row">
	      <div class="col-md-6">
			<h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span>Message</h3>
			</div>

		<div class="col-md-6">
		   <p id="msg_sent_success" class="text-light-blue" style="display: none;"></p>
		</div>
		</div>
		</div>

	<div class="col-md-6">



 <div class="row">

 
<div class="col-md-12  text-right">
<?php
                    if (array_key_exists("index", $module_pages)):
                        $page_id = $module_pages["index"];
                        foreach ($user_permission as $permission):
                            if ($permission['page_id'] == $page_id):?>
                                    <a href="<?php echo $this->Url->build('/message/index/'); ?>"  class="btn btn-success btn-flat btn-grid">
                                        <i class="fa fa-list"></i>
                                        <?php echo __('Inbox '.'('. $total_unread_msg.')'); ?>
                                    </a>
                                    <?php
	                                break;
	                            endif;
	                        endforeach;
	                    endif;
                    ?>

  <?php             
                    foreach ($user_permission as $permission) {                   
                    foreach($nav_arr as $nav){
                    	if ($permission['page_id'] == $nav['page_id']){
                    ?>
                    	
                            <a id="<?php echo __($nav['id']) ?>" href="<?php echo $this->Url->build(["action" => $nav['action']]); ?>" class="btn btn-success btn-flat btn-grid">
                               <?php echo $nav['icon']; ?>
                                <?php echo __($nav['label']) ?>
                            </a>
                        
                    <?php    
                    }
                    }
                      }  
                    ?>

<div class="btn-group">
                  <button type="button" class="btn btn-primary"><?php echo __('Message'); ?></button>
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
											if(strtolower($submodule['controller_name']) != strtolower($current_sub_module)){
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
                                         <?= $this->Form->create(null, ['url' => ['controller' => 'message', 'action' => 'sentbulkAction']]); ?>
                                         <?= $this->Form->hidden('selected_content'); ?>
                                      	<div class="col-md-6">
                                            <?php echo $this->Form->input('bulk_action', array('label' => false, 'options' => $bulk_actions, 'empty' => __('Bulk Action'), 'required' => true, 'class' => 'form-control')); ?>
                                        </div>

							      <div class="col-md-6">
                                            <?= $this->Form->button(__('Apply'), ['id' => 'bulk_action_apply', 'class' => 'btn btn-success btn-flat'])?>
                                        </div>
                                        <?= $this->Form->end(); ?>
                                        <?php
																															break;
																														
																														
                                    endif;
																													endforeach
																													;
																												
																												
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
                                    <?=$this->Form->submit ( __ ( 'Message Search' ), [ 'class' => 'btn btn-success btn-flat' ] );?>
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
						
					<!-- /row -->
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
                                         <div> <!-- <div class="checkbox"> -->
                                            <input type="checkbox"  id="ContentSelect">
                                            <label class="image-checkbox-label" for="ContentSelect"></label>
                                        </div>
                                    </th>
                                    <th class="sorting_asc"><?= $this->Paginator->sort('Message.user_id', ['value' => __('To')]) ?></th>
                                    <th><?= $this->Paginator->sort('Message.subject', ['value' => __('Subject')]) ?></th>
                                    <th><?= $this->Paginator->sort('Message.msg_date', ['value' => __('Message Date')]) ?></th>                                   
                                    <th class="text-right"><?=  __('Action') ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php 
                                $count=1;
                                foreach ($messages as $message): ?>
                                    <tr>
                                        <td>
                                           <!-- <div class="checkbox"> -->
                                                <input type="checkbox" 
                                                         id="content_<?= $message->message['msg_id'] ?>">
                                                <label class="image-checkbox-label"
                                                       for="content_<?= $message->message['msg_id'] ?>"></label>
                                            
                                        </td>
                                        <td><?= $message->cmsusers['email']?></td>
                             
                                        <td>  <?= h($message->message['subject']) ?></td>
                                        <td> <?= date("M,d",strtotime($message->message['msg_date'])) ?></td>

                                    
                                           <td class=" text-right">
                                          
                                          <div class="btn-group">
              
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-list"></i> <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  
                  <li>  
                    	<?php
                            if (array_key_exists("view", $module_pages)):
                                $page_id = $module_pages["view"];
                                foreach ($user_permission as $permission):
                                    if ($permission['page_id'] == $page_id):?>
                                            <a  class="view_msg" href="<?php echo $this->Url->build(['action' => 'sentview', $message->message['msg_id']]) ?>"><i class="fa fa-list-alt"></i><?php echo __('VIEW') ?></a>
                                        <?php
                                        break;
                                    endif;
                                endforeach;
                            endif;
                          ?>
                      </li>
     
                    <li>  
                    	<?php
                            if (array_key_exists("delete", $module_pages)):
                                $page_id = $module_pages["delete"];
                                foreach ($user_permission as $permission):
                                    if ($permission['page_id'] == $page_id):?>
                                               
                                                <?php echo $this->Form->postLink(' <i class="fa fa-trash-o"></i>'.__('DELETE'), ['action' => 'sentdelete', $message->message['msg_id']], ['confirm' => __('Are you sure you want to delete {0}?', $message->message['subject']),'escape'=>false]) ?>
                                            
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
                                endforeach; ?>
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
    <div class="modal fade" id="send_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <?php
                echo $this->Form->create(null, [
                	'class'=>'form-horizontal send_email',	
				    'url' => ['controller' => 'Message', 'action' => 'send']
				]);
				 ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Send  Email</h4>
                    <div class="row">
                    <div class="col-sm-12 text-center">
                   <img src="<?php echo $this->Url->build('/images/loadingicon.gif'); ?>" class="loading_icon"
                         style="display:none;"/>

					<div id="msg_sent_error" class="alert alert-danger alert-dismissible"  style="display:none;"> </div>
              
                    </div>
                    </div>
                </div>
              
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
              <div class="form-group">
               <label class="col-sm-2 control-label"><?php echo __('To')?></label>
               <div class="col-sm-10">
                <select name="to_email_list[]" id="to_email_list" class="form-control select2" multiple="multiple" data-placeholder="Select " style="width: 100%;">
                 <?php 
               
                 foreach ($to_email_list as $row){
                 	//$username = .' <';
                 	//$email = ;
                 ?>
                  <option value="<?php echo $row->id ?>"><?php echo $row->username.' &lt'.$row->email.'&gt' ?></option>
                 <?php } ?> 
                </select>
              </div>
              </div>
               <div class="form-group">
                 <label class="col-sm-2 control-label"><?php echo __('Subject')?></label>
               <div class="col-sm-10">
                 <?php echo $this->Form->input('subject',['label'=>false,'class' => 'form-control', 'id'=>'subject']); ?>                
              </div>
              </div>
                 </div>     
                </div>
                 <div class="row">
                        <div class="col-md-12">
              <div class="form-group">
               <label class="col-sm-1 control-label">&nbsp;</label>
              <div class="col-sm-10">
               <?php echo $this->Form->textarea('msg_content', ['id'=>'msg_body','class' => 'form-control']); ?>
               </div>
              </div>
              </div> 
              </div>     
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php
                    echo $this->Form->button('Send ', array('class' => 'btn btn-primary sub_btn'));
                    ?>
                    
                    
                </div>
                
            </div>
            <?php
                echo $this->Form->end();
                ?>
            <!-- / modal-content -->
        </div>
        <!-- / modal-dialog -->
    </div>
 <!-- Modal -->
 
  <!-- View Modal  -->
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Read Mail</h4>
                </div>
                
                <div class="modal-body">
                <div id="msg-loading-div" >
                    <img src="<?php echo $this->Url->build('/images/loadingicon.gif'); ?>" class="loading_icon" />
                </div>
                <div id="msg_view_content"></div>
                   
                </div>


                 
            </div>
            <!-- / modal-content -->
        </div>
        <!-- / modal-dialog -->
    </div>
 <!-- Modal -->
<script>
    $(document).ready(function () {
    	  CKEDITOR.replace('msg_body');	         
    	  $("#send_msg").click(function (e) {
    		  e.preventDefault();
    		  $('#send_modal').modal('show');
          });

    	   $('.send_email').submit(function (e) {
    		  var form_tag = $(this);
    		  e.preventDefault();
    		 var msg_content = CKEDITOR.instances['msg_body'].getData(); 
    		 var subject=$('#subject').val();
    		 var to_email_list=$('#to_email_list').val();
    		 form_tag.find('.loading_icon').show();
              $.ajax({
                  url: '<?php echo $this->Url->build('/Message/send'); ?>/',
                  type: 'POST',
                  data:{ msg_content: msg_content, subject:subject,to_email_list:to_email_list},//$(".send_email" ).serialize(),
                  success: function (response) {
                      //alert(response);
                      var res = JSON.parse(response);
                     if(res.status=="1"){
                    	 form_tag.find('.loading_icon').hide();  
                    	  $('#send_modal').modal('hide');
                    	  $('#msg_sent_error').hide(); 
                    	  $('#msg_sent_success').show();
                    	  $('#msg_sent_success').text(res.msg);
                    	  $('#msg_sent_success').fadeOut(5000);
                    	  $("#to_email_list").select2("val", "");
                    	  $("#subject").val(''); 
                    	  CKEDITOR.instances['msg_body'].setData('');
                    	                   	                      	  
                         }
                     else if(res.status=="0"){
                    form_tag.find('.loading_icon').hide();     
                    $('#msg_sent_error').show();
                    $('#msg_sent_error').text(res.msg);
                	  
                     }
                      
                  },
                  error: function (data) {
                      //alert(data.toSource());
                  }
              });
              
          });

                  	  
    	  $(".view_msg").click(function (e) {
    		  e.preventDefault();
    		  $('#view_modal').modal('show');
    		   var url=$(this).attr('href') + '/';        	
               
      	 	  $.post(url,
      	                function(data,status){
      	                   //alert("Status: " + data);
      	                   $('#msg-loading-div').css('display', 'none');                    
      	                	$("#msg_view_content").html(data);                	
      	                });
      	    	       $("#msg_view_content").empty()
      	    	      $('#msg-loading-div').css('display', 'block');
      
          });
        $("#bulk_action_apply").click(function (e) {
            var selectedContent = $("input[name='selected_content']").val();
            if (selectedContent == null || selectedContent == "") {
                e.preventDefault();
                $('#status-area').flash_message({
                    text: 'Select atleast one item in the list!',
                    how: 'append'
                });
            }
        });
        
    });
</script>