<div>
    <i data-toggle="tooltip" title="<?php echo $data->icon_comment; ?>" class="fa fa-btn fa-comment"></i><?php echo $data->post_commented; ?>
</div>
<div>
<?php echo $data->text_rating; ?>
<?php for ($i = 1; $i <= 5; $i++) { ?>
    <?php if ($data->post_average_rating < $i) { ?>
    <span class="fa fa-stack" style="margin-right: -12px;"><i class="fa fa-star-o fa-stack-1x"></i></span>
    <?php } else { ?>
    <span class="fa fa-stack" style="color: #27C3ED; margin-right: -12px;"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
    <?php } ?>
<?php } ?>
</div>