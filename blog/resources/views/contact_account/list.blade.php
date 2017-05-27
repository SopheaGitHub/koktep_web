<div class="row">
  <div class="col-sm-12 col-md-12">
    <h4 style="margin:0px; padding:0px;"><i class="fa fa-btn fa-university"></i> Address</h4>
    <hr />
    <form action="#" method="post" enctype="multipart/form-data" id="form-account-setting" class="form-horizontal">
      <?php
        if(count($data->user_address) > 0) {
          foreach ($data->user_address as $address) { ?>
            <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label">Contact Name :</label>
              <div class="col-sm-10">
                <?php echo $address->firstname.' '.$address->lastname; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Company :</label>
              <div class="col-sm-10">
                <?php echo $address->company; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Address :</label>
              <div class="col-sm-10">
                <?php echo $address->address.', '.$address->city.', '.((isset($data->countries[$address->country_id]))? $data->countries[$address->country_id]:$address->country_id).', '.((isset($data->zones[$address->zone_id]))? $data->zones[$address->zone_id]:$address->zone_id); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Post Code :</label>
              <div class="col-sm-10">
                <?php echo $address->postcode; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Phone :</label>
              <div class="col-sm-10">
                <?php echo $address->phone; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Fax :</label>
              <div class="col-sm-10">
                <?php echo $address->fax; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Email :</label>
              <div class="col-sm-10">
                <?php echo $address->email; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Website :</label>
              <div class="col-sm-10">
                <a href="#" target="_blank"><?php echo $address->website; ?></a>
              </div>
            </div>
          </fieldset>
          <hr />
        <?php  }
        }
      ?>
    </form>
  </div>
</div>