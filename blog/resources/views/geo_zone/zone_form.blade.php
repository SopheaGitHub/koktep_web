<option value="">All Zones</option>
<?php
	if(count($data->country_zones) > 0) {
		foreach ($data->country_zones as $zone_id => $zone_name) { ?>
			<option <?php echo (($zone_id == $data->zone_id)? 'selected="selected"':'') ?> value="<?php echo $zone_id; ?>"><?php echo $zone_name; ?></option>
	<?php }
	}
?>