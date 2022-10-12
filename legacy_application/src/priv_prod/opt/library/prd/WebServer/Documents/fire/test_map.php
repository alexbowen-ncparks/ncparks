<!DOCTYPE html>
<html>
<head>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>

function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(35.789300, -78.659362),
    zoom:11,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById('mapdiv'),
      mapProp);

  google.maps.event.addListener(map, 'click', function(e) {
  
        document.getElementById('latlng').value = e.latLng.lat() + ', ' + e.latLng.lng();
    placeMarker(e.latLng, map);
  });

}

function placeMarker(position, map) {
  var marker = new google.maps.Marker({
    position: position,
    map: map
  });
  map.panTo(position);
}

google.maps.event.addDomListener(window, 'load', initialize);



</script>
</head>

<body>

<p id="demo">hi</p>

<div id="mapdiv" style="width:500px;height:380px;"></div>
<input type='text' id='latlng' name='latlng' value=''>
</div>
</body>
</html> 