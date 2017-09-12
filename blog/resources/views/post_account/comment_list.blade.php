<div class="form-group required">
    <input type="hidden" name="post_id" value="<?php echo $data->post_id; ?>" />
    <div class="col-sm-12">
        <label class="control-label" for="input-review"><?php echo $data->your_text; ?></label>
        <textarea name="comment" rows="3" id="input-review" class="form-control" placeholder="<?php echo $data->text_comment; ?>"></textarea>
    </div>
</div>
<div class="form-group required">
    <div class="col-sm-12">
        <label class="control-label"><?php echo $data->text_rating; ?></label>
        &nbsp;&nbsp;&nbsp; <?php // echo $data->text_bad; ?>&nbsp;
        <input name="rating" value="1" type="radio">
        &nbsp;
        <input name="rating" value="2" type="radio">
        &nbsp;
        <input name="rating" value="3" type="radio">
        &nbsp;
        <input name="rating" value="4" type="radio">
        &nbsp;
        <input name="rating" value="5" type="radio">
        &nbsp;<?php echo $data->text_good; ?>
    </div>
</div>
<div class="buttons clearfix">
    <div class="pull-left">
        <button type="button" class="btn btn-primary btn-sm" id="submit-comment"><i class="fa fa-btn fa-paper-plane"></i><?php echo $data->button_send; ?></button>
    </div>
</div>
<br />

<div class="actionBox" style="border:none;" >
    <ul class="commentList">
        <?php
            if(count($data->post_comments) > 0) {
                foreach ($data->post_comments as $post_comment) { 
                    $comment = mb_substr(strip_tags(html_entity_decode($post_comment->comment, ENT_QUOTES, 'UTF-8')), 0, mb_strlen($post_comment->comment));
                    ?>
                    <li>
                        <div class="commenterImage">
                          <img src="<?php echo ((isset($data->thumb_user[$post_comment->post_comment_id]))? $data->thumb_user[$post_comment->post_comment_id]:''); ?>" alt="" />
                        </div>
                        <div class="commentText">
                            <div><a href="<?php echo $data->overview_account.'?account_id='.$post_comment->user_id; ?>"><?php echo $post_comment->user_name; ?></a></div> 
                            <p class=""><?php echo $comment; ?></p>
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <?php if ($post_comment->rating < $i) { ?>
                                <span class="fa fa-stack" style="margin-left: -12px;"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } else { ?>
                                <span class="fa fa-stack" style="color: #27C3ED; margin-left: -12px;"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } ?>
                            <?php } ?>
                            <span class="date sub-text">on <?php echo date('M dS, Y', strtotime($post_comment->created_at)); ?></span>
                        </div>
                    </li>
            <?php }
            }
        ?>
    </ul>
</div>