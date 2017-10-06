<div class="row">
<?php
if(count($data->notifications) > 0) {?>
    <div class="col-md-12">
<?php  foreach ($data->notifications as $notification) { ?>
        <div>
            <a href="<?php echo url('/'.str_replace(['@author_id@', '@post_id@', '@category_id@'], [$notification->author_id, $notification->post_id, (( empty($notification->category_id) )? '0':strtolower($notification->category_id))  ], $notification->link) ); ?>">
                <div class="<?php echo (($notification->viewed_status=='new')? 'message-box-active':'message-box'); ?>">
                    <img class="message-author-image" src="<?php echo ((isset($data->notification_thumb_user[$notification->id]))? $data->notification_thumb_user[$notification->id]:''); ?>"> &nbsp; 
                    <span class="message-author-name"><?php echo $notification->user_name; ?> <?php echo (($notification->user_id==$data->auth_id)? '('.trans('message.you').')':''); ?></span>, 
                    <span class="message-date"><?php echo date('M dS, Y H:i', strtotime($notification->notification_date)); ?></span><br />
                    <span class="message-text"><?php echo str_replace(['@profile@ ', '@upload_title@'], ['', '"'.$notification->post_title.'"'], $notification->text); ?></span>
                </div>
            </a>
        </div>
<?php } ?> 
    </div>
<?php }
?>
</div>
<div class="row">
    <div class="col-sm-6 text-left" id="render-list-notification"><?php echo $data->notifications->render(); ?></div>
    <div class="col-sm-6 text-right">
        <?php
        $start = ($data->notifications->currentPage() * $data->notifications->perPage()) - $data->notifications->perPage() + 1;
        $stop = $data->notifications->currentPage() * $data->notifications->perPage();
        if($stop > $data->notifications->total()){
          $stop = ( $start + $data->notifications->count()) - 1;
        }
        if($stop == 0){
          $start = 0;
        }
      ?>
      <?php echo $data->show; ?> <?php echo $start; ?> <?php echo $data->to; ?> <?php echo $stop; ?> <?php echo $data->of; ?> <?php echo $data->notifications->total(); ?> &nbsp;&nbsp; (<?php echo $data->page; ?> <?php echo $data->notifications->currentPage(); ?> )
    </div>
</div>
