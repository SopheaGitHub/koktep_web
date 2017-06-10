<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-pencil"></i> <b><?php echo $data->titlelist; ?></b></h3>
    </div>
    <div class="panel-body">

      <form action="#" method="post" enctype="multipart/form-data" id="form-account-setting" class="form-horizontal">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $data->tab_general; ?></a></li>
          <li><a href="#tab-image" data-toggle="tab"><?php echo $data->tab_image; ?></a></li>
          <li><a href="#tab-skills-charge" data-toggle="tab"><?php echo $data->tab_skill_charge; ?></a></li>
          <li><a href="#tab-contact" data-toggle="tab"><?php echo $data->tab_contact; ?></a></li>
          <li><a href="#tab-social-media" data-toggle="tab"><?php echo $data->tab_social_media; ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-general">
            <div class="form-group required">
              <label class="col-sm-2 control-label"><?php echo $data->entry_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="name" value="<?php echo ((isset($data->name))? $data->name:''); ?>" class="form-control" id="input-name" placeholder="<?php echo $data->entry_name; ?>" />
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $data->text_title_email; ?>"><?php echo $data->entry_email; ?></span></label>
              <div class="col-sm-10">
                <input type="text" name="email" value="<?php echo ((isset($data->email))? $data->email:''); ?>" class="form-control" id="input-email" placeholder="<?php echo $data->entry_email; ?>" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $data->entry_description; ?></label>
              <div class="col-sm-10">
                <textarea name="description" class="form-control" style="max-width:100%;min-width:100%;min-height:200px;max-height:200px;" placeholder="<?php echo $data->entry_email; ?>"><?php echo ((isset($data->description))? $data->description:''); ?></textarea>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="tab-image">
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo $data->entry_profile; ?> <br /> <?php echo $data->entry_scale; ?>: 100px, 100px</label>
              <div class="col-sm-9"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $data->thumb_image; ?>" alt="" title="" data-placeholder="<?php echo $data->image_placeholder; ?>" /></a>
                <input type="hidden" name="image" value="<?php echo ((isset($data->image))? $data->image:''); ?>" id="input-image" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo $data->entry_first_cover; ?> <br /> <?php echo $data->entry_scale; ?>: 600px, 400px</label>
              <div class="col-sm-9"><a href="" id="thumb-first-cover" data-toggle="image" class="img-thumbnail"><img src="<?php echo $data->thumb_first_cover; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /></a>
                <input type="hidden" name="first_cover" value="<?php echo ((isset($data->first_cover))? $data->first_cover:''); ?>" id="input-first-cover" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"><?php echo $data->entry_second_cover; ?> <br /> <?php echo $data->entry_scale; ?>: 600px, 400px</label>
              <div class="col-sm-9"><a href="" id="thumb-second-cover" data-toggle="image" class="img-thumbnail"><img src="<?php echo $data->thumb_second_cover; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /></a>
                <input type="hidden" name="second_cover" value="<?php echo ((isset($data->second_cover))? $data->second_cover:''); ?>" id="input-second-cover" />
              </div>
            </div>
          </div>

          <div class="tab-pane" id="tab-skills-charge">
            <div class="table-responsive">
              <table id="technicals" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $data->entry_skill; ?></td>
                    <td class="text-right"><?php echo $data->entry_percent; ?></td>
                    <td class="text-right"><?php echo $data->entry_min_charge; ?></td>
                    <td class="text-right"><?php echo $data->entry_max_charge; ?></td>
                    <td class="text-right"><?php echo $data->entry_sort_order; ?></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $technical_row = 0;
                    if(count($data->user_technicals) > 0) {
                      foreach ($data->user_technicals as $technical) { ?>
                        <tr id="technical-row<?php echo $technical_row; ?>">
                          <td class="text-left"><input type="text" name="user_technical[<?php echo $technical_row; ?>][skill]" value="<?php echo $technical->skill; ?>" placeholder="<?php echo $data->entry_skill; ?>" class="form-control" /></td>
                          <td class="text-right"><input type="text" name="user_technical[<?php echo $technical_row; ?>][percent]" value="<?php echo $technical->percent; ?>" placeholder="<?php echo $data->entry_percent; ?>" class="form-control" /></td>
                          <td class="text-right"><input type="text" name="user_technical[<?php echo $technical_row; ?>][min_charge]" value="<?php echo $technical->min_charge; ?>" placeholder="<?php echo $data->entry_min_charge; ?>" class="form-control" /></td>
                          <td class="text-right"><input type="text" name="user_technical[<?php echo $technical_row; ?>][max_charge]" value="<?php echo $technical->max_charge; ?>" placeholder="<?php echo $data->entry_max_charge; ?>" class="form-control" /></td>
                          <td class="text-right"><input type="text" name="user_technical[<?php echo $technical_row; ?>][sort_order]" value="<?php echo $technical->sort_order; ?>" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>
                          <td class="text-left"><button type="button" onclick="$('#technical-row<?php echo $technical_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                      <?php $technical_row++; ?>
                    <?php  }
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"></td>
                    <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $data->button_technical_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div class="tab-pane" id="tab-contact">
            <div class="table-responsive">
              <table id="address" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $data->entry_detail; ?></td>
                    <td class="text-right"><?php echo $data->entry_sort_order; ?></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $address_row = 0;
                    if(count($data->user_address) > 0) {
                      foreach ($data->user_address as $address) { ?>
                        
                        <tr id="address-row<?php echo $address_row; ?>">
                          <td class="text-left">

                            <fieldset>
                              <div class="form-group required">
                                <label class="col-sm-3 control-label" for="input-firstname"><?php echo $data->entry_firstname; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][firstname]" value="<?php echo $address->firstname; ?>" placeholder="<?php echo $data->entry_firstname; ?>" id="firstname" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-3 control-label" for="input-lastname"><?php echo $data->entry_lastname; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][lastname]" value="<?php echo $address->lastname; ?>" placeholder="<?php echo $data->entry_lastname; ?>" id="lastname" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-company"><?php echo $data->entry_company; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][company]" value="<?php echo $address->company; ?>" placeholder="<?php echo $data->entry_company; ?>" id="company" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-phone"><?php echo $data->entry_phone; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][phone]" value="<?php echo $address->phone; ?>" placeholder="<?php echo $data->entry_phone; ?>" id="phone" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-fax"><?php echo $data->entry_fax; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][fax]" value="<?php echo $address->fax; ?>" placeholder="<?php echo $data->entry_fax; ?>" id="fax" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-3 control-label" for="input-email"><?php echo $data->entry_email; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][email]" value="<?php echo $address->email; ?>" placeholder="<?php echo $data->entry_email; ?>" id="email" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-website"><?php echo $data->entry_website; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][website]" value="<?php echo $address->website; ?>" placeholder="<?php echo $data->entry_website; ?>" id="website" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-3 control-label" for="input-address"><?php echo $data->entry_address; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][address]" value="<?php echo $address->address; ?>" placeholder="<?php echo $data->entry_address; ?>" id="address" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-3 control-label" for="input-city"><?php echo $data->entry_city; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][city]" value="<?php echo $address->city; ?>" placeholder="<?php echo $data->entry_city; ?>" id="city" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-postcode"><?php echo $data->entry_postcode; ?></label>
                                <div class="col-sm-9">
                                  <input type="text" name="user_address[<?php echo $address_row; ?>][postcode]" value="<?php echo $address->postcode; ?>" placeholder="<?php echo $data->entry_postcode; ?>" id="postcode" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-3 control-label" for="input-country"><?php echo $data->entry_country; ?></label>
                                <div class="col-sm-9">
                                  <select name="user_address[<?php echo $address_row; ?>][country_id]" id="country<?php echo $address_row; ?>" onchange="$('#zone<?php echo $address_row; ?>').load('<?php echo $data->load_zone_action; ?>/' + this.value + '/0');" class="form-control">
                                    <option value=""><?php echo $data->text_select; ?></option>
                                    <?php foreach ($data->countries as $country_id => $country_name) { ?>
                                      <option <?php echo (($country_id==$address->country_id)? 'selected="selected"':''); ?> value="<?php echo $country_id; ?>"><?php echo $country_name; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group required">
                                <label class="col-sm-3 control-label" for="input-zone"><?php echo $data->entry_zone; ?></label>
                                <div class="col-sm-9">
                                  <select name="user_address[<?php echo $address_row; ?>][zone_id]" id="zone<?php echo $address_row; ?>" class="form-control">
                                  </select>
                                </div>
                              </div>
                            </fieldset>

                          </td>
                          <td class="text-right"><input type="text" name="user_address[<?php echo $address_row; ?>][sort_order]" value="<?php echo $address->sort_order; ?>" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>
                          <td class="text-left"><button type="button" onclick="$('#address-row<?php echo $address_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>

                      <?php $address_row++; ?>
                    <?php  }
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2"></td>
                    <td class="text-left"><button type="button" onclick="addAddress();" data-toggle="tooltip" title="<?php echo $data->button_contact_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div class="tab-pane" id="tab-social-media">
            <div class="tab-pane" id="tab-contact">
              <div class="table-responsive">
                <table id="social-media" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $data->entry_social_media; ?></td>
                      <td class="text-left"><?php echo $data->entry_link; ?></td>
                      <td class="text-right"><?php echo $data->entry_sort_order; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $social_media_row = 0;
                      if(count($data->user_social_medias) > 0) {
                        foreach ($data->user_social_medias as $social_media) { ?>
                          <tr id="social-media-row<?php echo $social_media_row; ?>">
                            <td class="text-left">
                              <select name="user_social_media[<?php echo $social_media_row; ?>][social_media_id]" class="form-control">
                                <option value=""><?php echo $data->text_select; ?></option>
                                <?php
                                  foreach ($data->social_medias as $social_media_id => $social_media_name) { ?>
                                    <option <?php echo (($social_media_id==$social_media->social_media_id)? 'selected="selected"':''); ?> value="<?php echo $social_media_id; ?>"><?php echo $social_media_name; ?></option>
                                <?php  }
                                ?>
                              </select>
                            </td>
                            <td class="text-left"><input type="text" name="user_social_media[<?php echo $social_media_row; ?>][link]" value="<?php echo $social_media->link; ?>" placeholder="<?php echo $data->entry_link; ?>" class="form-control" /></td>
                            <td class="text-right"><input type="text" name="user_social_media[<?php echo $social_media_row; ?>][sort_order]" value="<?php echo $social_media->sort_order; ?>" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>
                            <td class="text-left"><button type="button" onclick="$('#social-media-row<?php echo $social_media_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                          </tr>
                        <?php $social_media_row++; ?>
                      <?php  }
                      }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"></td>
                      <td class="text-left"><button type="button" onclick="addSocialMedia();" data-toggle="tooltip" title="<?php echo $data->button_social_media_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          
        </div>
      </form>

    </div>
  </div>
</div>
<script type="text/javascript">
  <?php
    $address_row=0;
    foreach ($data->user_address as $address) { ?>
      $('#zone<?php echo $address_row; ?>').load('<?php echo $data->load_zone_action; ?>/<?php echo $address->country_id; ?>/<?php echo $address->zone_id; ?>');
  <?php $address_row++; }
  ?>
</script>
<script type="text/javascript"><!--
var technical_row = <?php echo $technical_row; ?>;

function addImage() {
  html  = '<tr id="technical-row' + technical_row + '">';
  html += '<td class="text-left"><input type="text" name="user_technical[' + technical_row + '][skill]" value="" placeholder="<?php echo $data->entry_skill; ?>" class="form-control" /></td>';
  html += '<td class="text-right"><input type="text" name="user_technical[' + technical_row + '][percent]" value="" placeholder="<?php echo $data->entry_percent; ?>" class="form-control" /></td>';
  html += '<td class="text-right"><input type="text" name="user_technical[' + technical_row + '][min_charge]" value="" placeholder="<?php echo $data->entry_min_charge; ?>" class="form-control" /></td>';
  html += '<td class="text-right"><input type="text" name="user_technical[' + technical_row + '][max_charge]" value="" placeholder="<?php echo $data->entry_max_charge; ?>" class="form-control" /></td>';
  html += '<td class="text-right"><input type="text" name="user_technical[' + technical_row + '][sort_order]" value="" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>';
  html += '<td class="text-left"><button type="button" onclick="$(\'#technical-row' + technical_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

  $('#technicals tbody').append(html);

  technical_row++;
}


var address_row = <?php echo $address_row; ?>;

function addAddress() {
  var requestAction = "<?php echo $data->load_zone_action; ?>";
  var html = '';
  html += '<tr id="address-row' + address_row + '">'
  html += '<td class="text-left">';

  html += '<fieldset>';
  html += '<div class="form-group required">';
  html += '<label class="col-sm-3 control-label" for="input-firstname"><?php echo $data->entry_firstname; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][firstname]" value="" placeholder="<?php echo $data->entry_firstname; ?>" id="firstname" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group required">';
  html += '<label class="col-sm-3 control-label" for="input-lastname"><?php echo $data->entry_lastname; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][lastname]" value="" placeholder="<?php echo $data->entry_lastname; ?>" id="lastname" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group">';
  html += '<label class="col-sm-3 control-label" for="input-company"><?php echo $data->entry_company; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][company]" value="" placeholder="<?php echo $data->entry_company; ?>" id="company" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group">';
  html += '<label class="col-sm-3 control-label" for="input-phone"><?php echo $data->entry_phone; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][phone]" value="" placeholder="<?php echo $data->entry_phone; ?>" id="phone" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group">';
  html += '<label class="col-sm-3 control-label" for="input-fax"><?php echo $data->entry_fax; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][fax]" value="" placeholder="<?php echo $data->entry_fax; ?>" id="fax" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group required">';
  html += '<label class="col-sm-3 control-label" for="input-email"><?php echo $data->entry_email; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][email]" value="" placeholder="<?php echo $data->entry_email; ?>" id="email" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group">';
  html += '<label class="col-sm-3 control-label" for="input-website"><?php echo $data->entry_website; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][website]" value="" placeholder="<?php echo $data->entry_website; ?>" id="website" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group required">';
  html += '<label class="col-sm-3 control-label" for="input-address"><?php echo $data->entry_address; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][address]" value="" placeholder="<?php echo $data->entry_address; ?>" id="address" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group required">';
  html += '<label class="col-sm-3 control-label" for="input-city"><?php echo $data->entry_city; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][city]" value="" placeholder="<?php echo $data->entry_city; ?>" id="city" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group">';
  html += '<label class="col-sm-3 control-label" for="input-postcode"><?php echo $data->entry_postcode; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<input type="text" name="user_address[' + address_row + '][postcode]" value="" placeholder="<?php echo $data->entry_postcode; ?>" id="postcode" class="form-control" />';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group required">';
  html += '<label class="col-sm-3 control-label" for="input-country"><?php echo $data->entry_country; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<select name="user_address[' + address_row + '][country_id]" onchange="$(\'#zone' + address_row + '\').load(\''+requestAction+'/\' + this.value + \'/0\');" id="country'+address_row+'" class="form-control">';
  <?php
    if(count($data->countries) > 0) {
      foreach ($data->countries as $country_id => $country_name) { ?>
        html += '<option value="<?php echo $country_id; ?>"><?php echo addslashes($country_name); ?></option>';
      <?php  }
    }
  ?>
  html += '</select>';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group required">';
  html += '<label class="col-sm-3 control-label" for="input-zone"><?php echo $data->entry_zone; ?></label>';
  html += '<div class="col-sm-9">';
  html += '<select name="user_address[' + address_row + '][zone_id]" id="zone' + address_row + '" class="form-control">';
  html += '</select>';
  html += '</div>';
  html += '</div>';
  html += '</fieldset>';

  html += '</td>';
  html += '<td class="text-right"><input type="text" name="user_address[' + address_row + '][sort_order]" value="" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>';
  html += '<td class="text-left"><button type="button" onclick="$(\'#address-row' + address_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

  $('#address tbody').append(html);
  $('#zone' + address_row).load(requestAction+ '/' + $('#country' + address_row).val()+'/0');
  address_row++;
}

var social_media_row = <?php echo $social_media_row; ?>;

function addSocialMedia() {
  var html = '';
  html += '<tr id="social-media-row' + social_media_row + '">';
  html += '<td class="text-left">';
  html += '<select name="user_social_media[' + social_media_row + '][social_media_id]" class="form-control">';
  html += '<option value=""><?php echo $data->text_select; ?></option>';
    <?php
      if(count($data->social_medias) > 0) {
        foreach ($data->social_medias as $social_media_id => $social_media_name) { ?>
          html += '<option value="<?php echo $social_media_id; ?>"><?php echo addslashes($social_media_name); ?></option>';
        <?php  }
      }
    ?>
  html += '</select>';
  html += '</td>';
  html += '<td class="text-left"><input type="text" name="user_social_media[' + social_media_row + '][link]" value="" placeholder="<?php echo $data->entry_link; ?>" class="form-control" /></td>';
  html += '<td class="text-right"><input type="text" name="user_social_media[' + social_media_row + '][sort_order]" value="" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>';
  html += '<td class="text-left"><button type="button" onclick="$(\'#social-media-row' + social_media_row + '\').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';

  $('#social-media tbody').append(html);

  social_media_row++;
}

$(document).ready(function() {
  requestSubmitForm('submit-account-setting', 'form-account-setting', "<?php echo $data->action; ?>");
});
//--></script>