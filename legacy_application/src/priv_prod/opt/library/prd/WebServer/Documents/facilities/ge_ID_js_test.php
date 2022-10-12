<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
$domain="www.dpr.ncparks.gov";
$base_server="/opt/library/prd/WebServer/Documents";
$db="facilities";
$database=$db;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

include("../../include/auth.inc"); // includes session_start();
include("../../include/get_parkcodes.php"); // includes session_start();

if(empty($connection))
{include("../../../include/connectROOT.inc");}

extract($_REQUEST);
if (!$connection) 
	{
	  die('Not connected : ' . mysql_error());
	}

// Sets the active MySQL database.
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) 
{
  die ('Can\'t use db : ' . mysql_error());
}

	 $query = "SELECT t1.gis_id, t1.park_abbr, t1.fac_name, t1.doi_id, left(t1.lat,10) as lat, left(t1.`long`,10) as lon
	 FROM spo_dpr as t1
	 WHERE gis_id='$gis_id'
	 and t1.lat>0"; 
//	 echo "$query<br />"; exit;
//	 echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//	 exit;
	

 $resultGoogle = mysql_query($query);
 if (!$resultGoogle) 
 {
  die('Invalid query: ' . mysql_error(). $query);
 }
 while ($row = @mysql_fetch_assoc($resultGoogle)) 
	{
	extract($row); //print_r($row); exit;
	}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>DPR Facility <?php echo "$gis_id"; ?></title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
function initialize() {
  var map_loc = new google.maps.LatLng( <?php echo "$lat,$lon"; ?> );
  var mapOptions = {
    /*zoom: 20,*/
    center: map_loc,
    mapTypeId: google.maps.MapTypeId.SATELLITE
  }

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  /*var ctaLayer = new google.maps.KmlLayer({
    url: <?php echo "'https://10.35.152.9".$feed_url_js."'"; ?>
    url: <?php echo "'https://10.35.152.9".$feed_url_js."'"; ?>
  });*/
  

		
		var marker = new google.maps.Marker({position: {lng: -77.906545, lat: 34.044951}});
		marker.setMap(map);
		var marker = new google.maps.Marker({position: {lng: -77.905045, lat: 34.044385}});
		marker.setMap(map);
		var marker = new google.maps.Marker({position: {lng:-77.904447, lat: 34.046479}});
		marker.setMap(map);
	
  
  /*ctaLayer.setMap(map);*/
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

