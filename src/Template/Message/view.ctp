<div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><strong>Subject: </strong><?php echo $message->message['subject'] ?></h3>
                <h5><strong>From: </strong><?php echo $message->cmsusers['email']?>
                  <span class="mailbox-read-time pull-right"><?php echo date("d M Y g:i a",strtotime($message->message['msg_date'])) ?></span></h5>
              </div>
              <!-- /.mailbox-read-info -->
            
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
              <h3><strong>Message Content: </strong></h3>
               <?php 
                echo $message->message['msg_content']  
                ?>
              </div>
              <!-- /.mailbox-read-message -->
</div>

<div class="modal-footer">
	<div class="pull-right">
    	<a class="btn btn-default" href="<?php echo $this->Url->build(['action' => 'reply', $message->message['msg_id']]) ?>"><i class="fa fa-reply"></i><?php echo __('Reply') ?></a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>