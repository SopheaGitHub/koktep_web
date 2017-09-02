<div style="text-align:center; background: #91beb1; color: #fff;">
	<h3><?php echo $data->load_title; ?></h3>
</div>
<br />
<?php
   if(count($data->messages) > 0) {
      foreach ($data->messages as $message) { 
            $subject = mb_substr(strip_tags(html_entity_decode($message->subject, ENT_QUOTES, 'UTF-8')), 0, 100).((mb_strlen($message->subject)>100)? '...':'');
            $text = mb_substr(strip_tags(html_entity_decode($message->text, ENT_QUOTES, 'UTF-8')), 0, 225).((mb_strlen($message->text)>225)? '...':'');
         ?>
         <a href="<?php echo $data->action_detail.'&amp;message_id='.$message->id; ?>">
            <div class="<?php echo (( ($data->load_title=='Inbox') && ($message->viewed<=0) )? 'message-list-active':'message-list'); ?>">
              <p style="font-size: 11px;">
                <i class="fa fa-btn fa-calendar"></i><?php echo date('M dS, Y', strtotime($message->created_at)); ?>
                <?php echo (($message->total_reply > 0)? '<b> &nbsp; | &nbsp; Reply: '.$message->total_reply.'</b>':'') ?>
              </p>
               <div class="message-sender">
                  <img style="width:30px; margin-top:5px; border-radius:50%;" src="<?php echo ((isset($data->thumb_user[$message->id]))? $data->thumb_user[$message->id]:''); ?>"> &nbsp; <span style="font-size: 12px;"><?php echo $message->author_name; ?> <?php echo (($message->sender_id==$data->auth_id)? '(Me)':''); ?></span>
               </div>
               <div class="message-subject"><?php echo $subject; ?></div>
               <p class="message-preview"><?php echo $text; ?></p>

            </div>
         </a>
   <?php   }
   }
      else {
      echo 'There is no message';
   }
?>
<div class="row">
    <div class="col-sm-6 text-left" id="render-list-message"><?php echo $data->messages->render(); ?></div>
    <div class="col-sm-6 text-right">
        <?php
        $start = ($data->messages->currentPage() * $data->messages->perPage()) - $data->messages->perPage() + 1;
        $stop = $data->messages->currentPage() * $data->messages->perPage();
        if($stop > $data->messages->total()){
          $stop = ( $start + $data->messages->count()) - 1;
        }
        if($stop == 0){
          $start = 0;
        }
      ?>
      <?php echo $data->show; ?> <?php echo $start; ?> <?php echo $data->to; ?> <?php echo $stop; ?> <?php echo $data->of; ?> <?php echo $data->messages->total(); ?> &nbsp;&nbsp; (<?php echo $data->page; ?> <?php echo $data->messages->currentPage(); ?> )
    </div>
</div>