<div class="modal-dialog modal-lg">
  <div class="modal-content" style="-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border:1px solid #ddd;">
    <div class="modal-header">
      <div class="row">
        <div class="col-md-6"><h4 class="modal-title"><b><i class="fa fa-btn fa-upload"></i><?php echo $data->titlelist; ?></b></h4></div>
        <div class="col-md-6">
            <span class="pull-right">
              <a href="<?php echo $data->go_back.'?account_id='.$data->auth_id; ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-angle-double-left"></i> <?php echo $data->button_back; ?></a>
            </span>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-6 col-md-6">
          <div class="alert alert-success" id="success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-btn fa-check-circle"></i><?php echo $data->message_success; ?><br />
          </div>
          <p>- Click <button class="btn btn-primary btn-xs">Go To <i class="fa fa-arrow-circle-o-right"></i>
</button> view detail.</p>
          <p>- Click <button class="btn btn-default btn-xs">Go To <i class="fa fa-arrow-circle-o-right"></i>
</button> upload management.</p>
        </div>
        <div class="col-sm-6 col-md-6">
          <a href="http://localhost/development/koktep_web/blog/public/post-account/detail?account_id=1&amp;post_id=11&amp;category_id=3-photography"><img src="http://localhost/development/koktep_storage//images/cache/catalog/1/Fashion-photography-600x400.jpg" alt="" style="width:100%"></a>
          <div><b><a href="http://localhost/development/koktep_web/blog/public/post-account/detail?account_id=1&amp;post_id=11&amp;category_id=3-photography">wer</a></b></div>
          <p>erwterwewr</p>
          <div class="row">
              <div class="col-md-8">
                  <div><span><img style="width:40px; 5px solid rgba(255,255,255,0.5); border-radius:50%;" src="http://localhost/development/koktep_storage//images/cache/catalog/1/profile/profile_chansophea1-100x100.jpg"></span> &nbsp; <a href="http://localhost/development/koktep_web/blog/public/overview-account?account_id=1"> <b>Chan Sophea</b></a></div>
              </div>
              <div class="col-md-4">
                  <span class="pull-right" style="font-size:11px;">
                      <i data-toggle="tooltip" title="" class="fa fa-btn fa-eye" data-original-title="View"></i>99 &nbsp;
                      <i data-toggle="tooltip" title="" class="fa fa-btn fa-comment" data-original-title="Comment"></i>5 &nbsp;
                      <a href="http://localhost/development/koktep_web/blog/public/post-account/detail?account_id=1&amp;post_id=11&amp;category_id=3-photography"><i data-toggle="tooltip" title="" class="fa fa-btn fa-picture-o" data-original-title="Image"></i></a>1                            </span>
              </div>
          </div>
        </div>
      </div>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>