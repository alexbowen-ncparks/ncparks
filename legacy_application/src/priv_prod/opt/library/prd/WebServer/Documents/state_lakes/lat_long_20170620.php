<?php
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$var=explode("_",$_REQUEST['object']);
$var1=explode("[",$var[0]);
$form=$var1[1]."Form";
if($form=="swimForm"){$form="swim_lineForm";}
//echo "$form"; exit;
?>

<html><head>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAYOLGe4ukmB94v1yVi9tpHxQSC-GqoIBSX0gW3cWo1QaosJRoaxS10h3pH6TK81AkP1AxW-ESbrqiDg" type="text/javascript"></script>
 
 <title>$sciName Record at $occurPark</title>
<script language="JavaScript">
function setForm() {
    opener.document.<?php echo "$form";?>.lat.value = document.setLatLonForm.lat.value;
    opener.document.<?php echo "$form";?>.lon.value = document.setLatLonForm.lon.value;
    self.close();
    return false;
}

</script>
</head><body bgcolor='beige'>
<form name="setLatLonForm" onSubmit="return setForm();">
<table><tr><td>
		<td><div style="width: 1024px;" class="tekst"><b>Simply click a location on the map and it will enter the latitude and longitude in the coordinate boxes.</b><br />Click and drag to move around the map. <font color="blue">Click "Set" to set the coordinates.</font></div>
		<div id="map" style="width: 1024px; height: 800px"></div>
		<div id="geo" style="width: 200px;position: absolute;left: 820px;top: 100px;" class="tekst">
			<b><font color='red'>Coordinates: <?php echo "<br />$object";?></font></b><br />
			<table>
				<tr><td>Lat:</td><td><input type='text' name='lat' id="frmLat" value="<?php echo "$lat";?>" size="12"></td></tr>
				<tr><td>Lon:</td><td><input type='text' name='lon' id="frmLon" value="<?php echo "$lon";?>" size="12"></td></tr>
			<tr><td align="center" colspan="2"><input type="submit" name="setLatLon" value="Set" style="background-color:lightgreen"></td></tr>
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

	var baseLink = "https://10.35.152.9/state_lakes/lat_long.php";
	var baseLink = "https://10.35.152.9/state_lakes/lat_long.php";
//	var multimapBaseLink = "http://www.multimap.com/map/browse.cgi?scale=10000&icon=x";
	var geocoder = new GClientGeocoder();
	var setLat = <?php echo "$lat";?> ;
	var setLon = <?php echo "$lon";?> ;

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
	  
		var map = new GMap(document.getElementById("map"));
		
		map.addControl(new GSmallMapControl()); // added
		map.addControl(new GMapTypeControl()); // added
		map.centerAndZoom(new GPoint(setLon, setLat), <?php echo "$zoom";?>);
		
		var point = new GPoint(setLon, setLat);
		var marker = new GMarker(point);
		map.addOverlay(marker);

		GEvent.addListener(map, 'click', function(overlay, point) {
			if (overlay) {
				map.removeOverlay(overlay);
			} else if (point) {
				map.recenterOrPanToLatLng(point);
				var marker = new GMarker(point);
				map.addOverlay(marker);
				var matchll = /\(([-.\d]*), ([-.\d]*)/.exec( point );
				if ( matchll ) { 
					var lat = parseFloat( matchll[1] );
					var lon = parseFloat( matchll[2] );
					lat = lat.toFixed(6);
					lon = lon.toFixed(6);
					var message = "geotagged geo:lat=" + lat + " geo:lon=" + lon + " "; 
					
				} else { 
					var message = "<b>Error extracting info from</b>:" + point + ""; 
				
				}
		

		//		document.getElementById("maplink").href = baseLink + "?lat=" + lat + "&lon=" + lon ;
			
				document.getElementById("frmLat").value = lat;
				document.getElementById("frmLon").value = lon;

			}
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

    //]]>
    </script>