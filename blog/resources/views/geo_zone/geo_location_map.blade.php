<div id="map"></div>
<input type="text" class="txtfield" id="lat" value="13.0000">
<input type="text" class="txtfield" id="lng" value="105.0000">
<input type="text" id="address3" value="uk, london, abbey roa">
<script src="<?php echo asset('/javascript/jquery/geolocation/jquery.geolocation.edit.min.js'); ?>"></script>
<script>
$(document).ready(function () {
  
  // activate geolocate plugin
  $("#map").geolocate({
    lat: "#lat",
    lng: "#lng",
    address: ["#address3"]
  });
  
});
</script>