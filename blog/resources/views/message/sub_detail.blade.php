<?php
  if(count($data->sub_messages) > 0) {
    foreach ($data->sub_messages as $message) { ?>
      <hr />
      <div>
        <p style="font-size: 11px;">
          <i class="fa fa-btn fa-calendar"></i><?php echo date('M dS, Y', strtotime($message->created_at)); ?>
        </p>
        <div>
           <img style="width:30px; margin-top:5px; border-radius:50%;" src="<?php echo ((isset($data->thumb_user[$message->id]))? $data->thumb_user[$message->id]:''); ?>"> &nbsp; <span style="font-size: 12px;"><?php echo $message->author_name; ?></span>
        </div>
        <br />
        <?php
          $subject = mb_substr(strip_tags(html_entity_decode($message->subject, ENT_QUOTES, 'UTF-8')), 0, 100).((mb_strlen($message->subject)>100)? '...':'');
          $text = mb_substr(strip_tags(html_entity_decode($message->text, ENT_QUOTES, 'UTF-8')), 0, 225).((mb_strlen($message->text)>225)? '...':'');
        ?>
        <div><b><?php echo $subject; ?></b></div>
        <p><?php echo $text; ?></p>

      </div>
  <?php  }
  }
?>