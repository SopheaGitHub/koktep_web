<div class="row">
  <div class="col-md-12">
    <div class="panel-group" id="accordion">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="fa fa-btn fa-info-circle"></i><?php echo $data->tab_user_information; ?></h4>
        </div>
        <!-- <div id="collapse1" class="panel-collapse collapse in"> -->
          <div id="collapse1" class="panel-collapse collapse">
          <div class="panel-body">

            <form action="#" method="post" enctype="multipart/form-data" id="form-setting-information" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <span class="pull-right">
                      <button type="button" id="submit-setting-information" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save_change; ?></button>
                      <button type="reset" class="btn btn-sm btn-default"><i class="fa fa-btn fa-close"></i> <?php echo $data->button_cancel; ?></button>                            
                  </span>
                </div>
              </div>
              <br />
              <p id="message-setting-information"></p>
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
            </form>

          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="fa fa-btn fa-address-book"></i><?php echo $data->tab_user_contact; ?></h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
          <div class="panel-body">

            <form action="#" method="post" enctype="multipart/form-data" id="form-setting-contact" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <span class="pull-right">
                      <button type="button" id="submit-setting-contact" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save_change; ?></button>
                      <button type="reset" class="btn btn-sm btn-default"><i class="fa fa-btn fa-close"></i> <?php echo $data->button_cancel; ?></button>                            
                  </span>
                </div>
              </div>
              <br />
              <p id="message-setting-contact"></p>
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <?php
                $address_row = 0;
                if(count($data->user_address) > 0) {
                  foreach ($data->user_address as $address) { ?>

                    <fieldset>
                      <div class="form-group required">
                        <label class="col-sm-3 control-label" for="input-firstname"><?php echo $data->entry_name; ?></label>
                        <div class="col-sm-9">
                          <input type="text" name="user_address[<?php echo $address_row; ?>][firstname]" value="<?php echo (($address->firstname!='')? $address->firstname: ((\Auth::check())? \Auth::user()->name:'') ); ?>" placeholder="<?php echo $data->entry_firstname; ?>" id="lastname" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-company"><?php echo $data->entry_location_name; ?></label>
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
                          <input type="text" name="user_address[<?php echo $address_row; ?>][email]" value="<?php echo (($address->email!='')? $address->email : ((\Auth::check())? \Auth::user()->email:'') ); ?>" placeholder="<?php echo $data->entry_email; ?>" id="email" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-website"><?php echo $data->entry_website; ?></label>
                        <div class="col-sm-9">
                          <input type="text" name="user_address[<?php echo $address_row; ?>][website]" value="<?php echo $address->website; ?>" placeholder="<?php echo $data->entry_website; ?>" id="website" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-address"><?php echo $data->entry_address; ?></label>
                        <div class="col-sm-9">
                          <input type="text" name="user_address[<?php echo $address_row; ?>][address]" value="<?php echo $address->address; ?>" placeholder="<?php echo $data->entry_address; ?>" id="address" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group">
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
                      <div class="form-group">
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
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="input-zone"><?php echo $data->entry_zone; ?></label>
                        <div class="col-sm-9">
                          <select name="user_address[<?php echo $address_row; ?>][zone_id]" id="zone<?php echo $address_row; ?>" class="form-control">
                          </select>
                        </div>
                      </div>
                    </fieldset>

                  <?php $address_row++; ?>
                <?php  }
                } else { ?>
                  <fieldset>
                    <div class="form-group required">
                      <label class="col-sm-3 control-label" for="input-firstname"><?php echo $data->entry_name; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][firstname]" value="<?php echo ((\Auth::check())? \Auth::user()->name:''); ?>" placeholder="<?php echo $data->entry_name; ?>" id="firstname" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-company"><?php echo $data->entry_location_name; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][company]" value="" placeholder="<?php echo $data->entry_location_name; ?>" id="company" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-phone"><?php echo $data->entry_phone; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][phone]" value="" placeholder="<?php echo $data->entry_phone; ?>" id="phone" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-fax"><?php echo $data->entry_fax; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][fax]" value="" placeholder="<?php echo $data->entry_fax; ?>" id="fax" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group required">
                      <label class="col-sm-3 control-label" for="input-email"><?php echo $data->entry_email; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][email]" value="<?php echo ((\Auth::check())? \Auth::user()->email:''); ?>" placeholder="<?php echo $data->entry_email; ?>" id="email" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-website"><?php echo $data->entry_website; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][website]" value="" placeholder="<?php echo $data->website_placeholder; ?>" id="website" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-address"><?php echo $data->entry_address; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][address]" value="" placeholder="<?php echo $data->entry_address; ?>" id="address" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-city"><?php echo $data->entry_city; ?></label>
                      <div class="col-sm-9"><input name="user_address[0][city]" value="" placeholder="<?php echo $data->entry_city; ?>" id="city" class="form-control" type="text"></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-postcode"><?php echo $data->entry_postcode; ?></label>
                      <div class="col-sm-9">
                        <input name="user_address[0][postcode]" value="" placeholder="<?php echo $data->entry_postcode; ?>" id="postcode" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-country"><?php echo $data->entry_country; ?></label>
                      <div class="col-sm-9">
                        <select name="user_address[0][country_id]" id="country0" onchange="$('#zone0').load('<?php echo $data->load_zone_action; ?>/' + this.value + '/0');" class="form-control">
                          <option value=""><?php echo $data->text_select; ?></option>
                          <?php foreach ($data->countries as $country_id => $country_name) { ?>
                            <option value="<?php echo $country_id; ?>"><?php echo $country_name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="input-zone"><?php echo $data->entry_zone; ?></label>
                      <div class="col-sm-9">
                        <select name="user_address[0][zone_id]" id="zone0" class="form-control">
                        </select>
                      </div>
                    </div>
                  </fieldset>
              <?php  }
              ?>
            </form>

          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="fa fa-btn fa-book"></i><?php echo $data->tab_skill_charge; ?></h4>
        </div>
        <div id="collapse3" class="panel-collapse collapse">
          <div class="panel-body">

            <form action="#" method="post" enctype="multipart/form-data" id="form-setting-technical-skills" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <span class="pull-right">
                      <button type="button" id="submit-setting-technical-skills" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save_change; ?></button>
                      <button type="reset" class="btn btn-sm btn-default"><i class="fa fa-btn fa-close"></i> <?php echo $data->button_cancel; ?></button>                            
                  </span>
                </div>
              </div>
              <br />
              <p id="message-setting-technical-skills"></p>
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="table-responsive">
                <table id="technicals" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td width="70%" class="text-left"><?php echo $data->entry_skill; ?></td>
                      <td width="10%" class="text-right"><?php echo $data->entry_percent; ?></td>
                      <td width="10%" class="text-right"><?php echo $data->entry_min_charge; ?></td>
                      <td width="10%" class="text-right"><?php echo $data->entry_max_charge; ?></td>
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
                            <td class="text-left"><button type="button" onclick="$('#technical-row<?php echo $technical_row; ?>').remove();" class="btn btn-danger btn-xs"><i class="fa fa-btn fa-minus-circle"></i><?php echo $data->button_remove; ?></button></td>
                          </tr>
                        <?php $technical_row++; ?>
                      <?php  }
                      }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"></td>
                      <td class="text-left"><button type="button" onclick="addSkill();" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-plus-circle"></i><?php echo $data->button_technical_add; ?></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </form>

          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="fa fa-btn fa-picture-o"></i><?php echo $data->tab_watermark; ?></h4>
        </div>
        <div id="collapse4" class="panel-collapse collapse">
          <div class="panel-body">

            <form action="#" method="post" enctype="multipart/form-data" id="form-setting-watermark" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <span class="pull-right">
                      <button type="button" id="submit-setting-watermark" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save_change; ?></button>
                      <button type="reset" class="btn btn-sm btn-default"><i class="fa fa-btn fa-close"></i> <?php echo $data->button_cancel; ?></button>                            
                  </span>
                </div>
              </div>
              <br />
              <p id="message-setting-watermark"></p>
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $data->entry_enabled; ?></label>
                <div class="col-sm-10">
                  <input type="checkbox" name="user_watermark[status]" value="1" <?php echo (($data->watermark_status == '1')? 'checked="checked"':''); ?> />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $data->entry_position; ?></label>
                <div class="col-sm-10">
                  <select name="user_watermark[position]" id="input-position" class="form-control">
                    <?php
                      foreach ($data->watermark_positions as $key => $position) { ?>
                        <option <?php echo (($key == $data->watermark_position)? 'selected="selected"':''); ?> value="<?php echo $key; ?>"><?php echo $position; ?></option>
                      <?php }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $data->entry_watermark_status; ?></label>
                <div class="col-sm-10">
                  <div class="watermark-userpic">
                    <div class="watermark-pic">
                        <div class="img-thumbnail">
                          <img id="view-watermark" src="<?php echo $data->watermark_thumb; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" />
                          <input type="hidden" name="user_watermark[image]" value="<?php echo ((isset($data->watermark_image))? $data->watermark_image:''); ?>" id="input-watermark-image" />
                          <input type="hidden" name="user_watermark[data_image]" value="" id="input-data-watermark-image" />
                        </div>
                        <div class="edit"><a href="#" role="button" data-toggle="select-watermark" data-id="1"><i class="fa fa-pencil fa-lg"></i></a></div>
                    </div>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>

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

  var technical_row = <?php echo $technical_row; ?>;
  function addSkill() {
    html  = '<tr id="technical-row' + technical_row + '">';
    html += '<td class="text-left"><input type="text" name="user_technical[' + technical_row + '][skill]" value="" placeholder="<?php echo $data->entry_skill; ?>" class="form-control" /></td>';
    html += '<td class="text-right"><input type="text" name="user_technical[' + technical_row + '][percent]" value="0" placeholder="<?php echo $data->entry_percent; ?>" class="form-control" /></td>';
    html += '<td class="text-right"><input type="text" name="user_technical[' + technical_row + '][min_charge]" value="0" placeholder="<?php echo $data->entry_min_charge; ?>" class="form-control" /></td>';
    html += '<td class="text-right"><input type="text" name="user_technical[' + technical_row + '][max_charge]" value="0" placeholder="<?php echo $data->entry_max_charge; ?>" class="form-control" /></td>';
    html += '<td class="text-left"><button type="button" onclick="$(\'#technical-row' + technical_row  + '\').remove();" class="btn btn-danger btn-xs"><i class="fa fa-btn fa-minus-circle"></i><?php echo $data->button_remove; ?></button></td>';
    html += '</tr>';

    $('#technicals tbody').append(html);

    technical_row++;
  }
</script>