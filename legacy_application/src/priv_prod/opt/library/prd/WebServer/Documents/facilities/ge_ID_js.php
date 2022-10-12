<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
$domain="10.35.152.9";
$domain="10.35.152.9";
$base_server="/opt/library/prd/WebServer/Documents";
$db="facilities";
$database=$db;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

include("../../include/auth.inc"); // includes session_start();
include("../../include/get_parkcodes_dist.php"); // includes session_start();

if(empty($connection))
{include("../../../include/iConnect.inc");}

extract($_REQUEST);
if (!$connection) 
	{
	  die('Not connected : ' . mysqli_error($connection));
	}

// Sets the active MySQL database.
$db_selected = mysqli_select_db($connection,$database);
if (!$db_selected) 
{
  die ('Can\'t use db : ' . mysqli_error($connection));
}

	 $query = "SELECT t1.gis_id, t1.park_abbr, t1.fac_name, t1.doi_id, left(t1.lat,10) as lat, left(t1.`long`,10) as lon
	 FROM spo_dpr as t1
	 WHERE gis_id='$gis_id'
	 and t1.lat>0"; 
//	 echo "$query<br />"; exit;
//	 echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//	 exit;
	

 $resultGoogle = mysqli_query($connection,$query);
 if (!$resultGoogle) 
 {
  die('Invalid query: ' . mysqli_error($connection). $query);
 }
 while ($row = @mysqli_fetch_assoc($resultGoogle)) 
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
    zoom: 20,
    center: map_loc,
    mapTypeId: google.maps.MapTypeId.SATELLITE
  }

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var ctaLayer = new google.maps.KmlLayer({
    url: <?php echo "'https://10.35.152.9".$feed_url_js."'"; ?>
    url: <?php echo "'https://10.35.152.9".$feed_url_js."'"; ?>
  });
  ctaLayer.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbqVWe3AL7_XYlpGfwkhB_v9toSAc-t9U&callback=initMap"
  type="text/javascript"></script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

