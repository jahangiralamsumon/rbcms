<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php if(!empty($feedback->subject)){?><?= __('<strong>Subject: </strong>') ?><?php echo $feedback->subject;}?></h4>
</div>
<div class="modal-body">
           <?php if(!empty($feedback->message)){?><?= __('<strong>Message: </strong>') ?><?php echo $feedback->message;}?><br/><br/>
           <?php if(!empty($feedback->replied_message)){?><?= __('<strong>Replied Message Subject: </strong>') ?><?php echo 'RE: '.$feedback->subject;}?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>