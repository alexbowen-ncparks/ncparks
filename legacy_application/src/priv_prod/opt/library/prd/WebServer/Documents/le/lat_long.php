<?php
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
?>


<!--
<html><head><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEQtuoWMbScKMQHnBTM9ZFxfdVczrpEC0&callback=initMap"
  type="text/javascript"></script>
 -->

 <html><head><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbqVWe3AL7_XYlpGfwkhB_v9toSAc-t9U&callback=initMap"
  type="text/javascript"></script>



 <title>
 <?php
 echo "$pp_code Record";
if(isset($s)){$form="setForm_add_new_form()";}else{$form="setForm()";}
 ?>
 </title>
<script language="JavaScript">
function setForm() {
    opener.document.pr63_form.lat.value = document.setLatLonForm.lat.value;
    opener.document.pr63_form.lon.value = document.setLatLonForm.lon.value;
    self.close();
    return false;
}
function setForm_add_new_form() {
    opener.document.feedback.passLat.value = document.setLatLonForm.lat.value;
    opener.document.feedback.passLon.value = document.setLatLonForm.lon.value;
    self.close();
    return false;
}

</script>
</head><body bgcolor='beige'>
<form name="setLatLonForm" onSubmit="return <?php echo "$form"; ?>;">
<table>
<tr><td><?php echo "$pp_code Record"; ?></td></tr>
<tr>
		<td><div style="width: 800px;" class="tekst"><b>Simply click a location on the map and it will enter the latitude and longitude in the coordinate boxes.</b><br />Click and drag to move around the map. <font color="blue">Click "Set" to set the coordinates.</font></div>
		<div id="map" style="width: 800px; height: 800px"></div>
		<div id="geo" style="width: 200px;position: absolute;left: 820px;top: 150px;" class="tekst">
			<b>* Coordinates:</b><br />
			<table>
				<tr><td>* Lat:</td><td><input type='text' name='lat' id="frmLat" value="<?php echo "$lat";?>" size="12"></td></tr>
				<tr><td>* Lon:</td><td><input type='text' name='lon' id="frmLon" value="<?php echo "$lon";?>" size="12"></td></tr>
			<tr><td align="center" colspan="2"><input type="submit" name="setLatLon" value="Set"></td></tr>
			</table>
		</form>
        
		<a href="#" id="maplink"></a>
		
		
	</div>
	<div style="width: 800px;" class="smalltekst">
		<font color='red'>Click on a pointer to remove it from the map.</font>
		Click "Set" to set the coordinates.
		<br />
		
		<font size='-2'>Based on code taken from <a href="http://conversationswithmyself.com/googleMapDemo.html">this website</a>, <a href="http://www.evolt.org/article/Javascript_to_Parse_URLs_in_the_Browser/17/14435/?format=print">this website</a>, and <a href="http://www.gorissen.info/Pierre/">this website</a>.</font>
		
	</div>
	</td>
    <script type="text/javascript">
    //<![CDATA[

	var baseLink = "https://10.35.152.9/photo_point/lat_long.php";
	var baseLink = "https://10.35.152.9/photo_point/lat_long.php";
	var geocoder = new google.maps.Geocoder();
	var markersArray = [];
	var setLat = <?php echo "$lat";?> ;
	var setLon = <?php echo "$lon";?> ;

			google.maps.Map.prototype.clearOverlays = function() {
				for (var i = 0; i < markersArray.length; i++) {
					markersArray[i].setMap(null)
				}
		
				markersArray = [];
			}

	// argItems code taken from 
	// http://www.evolt.org/article/Javascript_to_Parse_URLs_in_the_Browser/17/14435/?format=print
	function argItems (theArgName) {
		sArgs = location.search.slice(1).split('&');
    		r = '';
    		for (var i = 0; i < sArgs.length; i++) {
        		if (sArgs[i].slice(0,sArgs[i].indexOf('=')) == theArgName) {
            			r = sArgs[i].slice(sArgs[i].indexOf('=')+1);
            			break;
        		}
    		}
    	return (r.length > 0 ? unescape(r).split(',') : '')
	}
	

	
	function placeMarker(setLat, setLon) {
				var message = "geotagged geo:lat=" + setLat + " geo:lon=" + setLon + " "; 
	
				document.getElementById("maplink").href = baseLink + "?lat=" + setLat + "&lon=" + setLon ;
	
				document.getElementById("frmLat").value = setLat;
				document.getElementById("frmLon").value = setLon;

				var startPoint = new google.maps.LatLng(setLat, setLon);
				var mapOptions = {
					zoom: 17,
					center: startPoint
				}	  

				var map = new google.maps.Map(document.getElementById("map"), mapOptions);
		
				var marker = new google.maps.Marker({position: startPoint});
				markersArray.push(marker);
				google.maps.event.addListener(marker, "click", function() { map.clearOverlays(); });
				marker.setMap(map);

				google.maps.event.addListener(map, 'click', function(mouseEvent) {
					map.clearOverlays(); // removes all markers

					var marker = new google.maps.Marker({position: mouseEvent.latLng});
					markersArray.push(marker);
					google.maps.event.addListener(marker, "click", function() { map.clearOverlays(); });
					marker.setMap(map)

			
					var lat = mouseEvent.latLng.lat();
					var lon = mouseEvent.latLng.lng();
					lat = lat.toFixed(6);
					lon = lon.toFixed(6);
					var message = "geotagged geo:lat=" + lat + " geo:lon=" + lon + " "; 
		
					document.getElementById("frmLat").value = lat;
					document.getElementById("frmLon").value = lon;
				});
			}

			if (argItems("lat") == '' || argItems("lon") == '') {
				placeMarker(setLat, setLon);
		    	} else {
				var setLat = parseFloat( argItems("lat") );
				var setLon = parseFloat( argItems("lon") );
				setLat = setLat.toFixed(6);
			    	setLon = setLon.toFixed(6);
				placeMarker(setLat, setLon);
		    	}
		</script>
	</body>
</html>