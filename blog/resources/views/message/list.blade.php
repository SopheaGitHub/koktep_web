<div class="message-list-box">
	<h3><?php echo $data->load_title; ?></h3>
</div>
<br />
<?php
   if(count($data->messages) > 0) {
      foreach ($data->messages as $message) { 
            $subject = mb_substr(strip_tags(html_entity_decode($message->subject, ENT_QUOTES, 'UTF-8')), 0, 100).((mb_strlen($message->subject)>100)? '...':'');
            $text = mb_substr(strip_tags(html_entity_decode($message->text, ENT_QUOTES, 'UTF-8')), 0, 225).((mb_strlen($message->text)>225)? '...':'');
         ?>
          <div class="message-list">
            <div>
              <a href="<?php echo $data->action_detail.'&amp;message_id='.(($message->parent_id!='0')? $message->parent_id:$message->message_id).'&viewed_id='.$message->message_id; ?>">
                <div class="<?php echo (($data->load_title=='Inbox' && $message->viewed == 0)? 'message-box-active':'message-box'); ?>">
                  <img class="message-author-image" src="<?php echo ((isset($data->thumb_user[$message->id]))? $data->thumb_user[$message->id]:''); ?>"> 
                  &nbsp; <span class="message-author-name"><b><?php echo $message->author_name; ?> <?php echo (($message->sender_id==$data->auth_id)? '('.$data->text_me.')':''); ?></b></span>, 
                  <span class="message-date"><?php echo date('M dS, Y H:i', strtotime($message->created_at)); ?></span><br />
                  <span class="message-text"><?php echo (($message->parent_id=='0')? trans('button.send').' Messages':trans('button.reply').' To Messages ') ?> : <?php echo mb_substr(strip_tags(html_entity_decode($message->subject, ENT_QUOTES, 'UTF-8')), 0, 100).'...'; ?></span>
                </div>
              </a>
            </div>
          </div>
   <?php   }
   }
      else {
      echo $data->text_empty_message;
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