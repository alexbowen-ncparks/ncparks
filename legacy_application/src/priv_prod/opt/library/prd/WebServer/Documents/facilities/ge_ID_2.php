<?php
//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
//if($_POST['ge']=="" and $_POST['gm']==""){echo "No record was selected. Click your browser's back button.";exit;}

$domain="www.dpr.ncparks.gov";
$base_server="/opt/library/prd/WebServer/Documents";
$db="facilities";
$database=$db;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

include("../../include/auth.inc"); // includes session_start();
include("../../include/get_parkcodes.php"); // includes session_start();
//$park=$_SESSION['nrid']['select'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

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

 if(!empty($fac_type))
 	{
 	$where="fac_type='$fac_type'";
	}
 
 if(!empty($park_abbr))
 	{
 	$where="park_abbr='$park_abbr' and fac_type='$fac_type'";
	}
	
	 $query = "SELECT gis_id, park_abbr, fac_name, sub_unit, doi_id, left(lat,10) as lat, left(`long`,10) as lon
	 FROM spo_dpr
	 WHERE $where"; 
	 //echo "$query<br />";exit;

 $resultGoogle = mysql_query($query);
 if (!$resultGoogle) 
	 {
	  die('Invalid query: ' . mysql_error(). $query);
	 }

// Creates an array of strings to hold the lines of the KML file.
$kml = array("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
$kml[] = "<kml xmlns=\"http://earth.google.com/kml/2.1\">";

$kml[] = " <Document>";
$kml[] = " <Style id=\"restaurantStyle\">";
$kml[] = " <IconStyle id=\"restuarantIcon\">";
$kml[] = " <Icon>";
// white circle with dot
$kml[] = " <href>http://maps.google.com/mapfiles/kml/pal4/icon57.png</href>";
$kml[] = " </Icon>";
$kml[] = " </IconStyle>";
$kml[] = " </Style>";
$kml[] = " <Style id=\"barStyle\">";
$kml[] = " <IconStyle id=\"barIcon\">";
$kml[] = " <Icon>";
// red circle with dot
$kml[] = " <href>http://maps.google.com/mapfiles/kml/pal4/icon49.png</href>";
$kml[] = " </Icon>";
$kml[] = " </IconStyle>";
$kml[] = " </Style>";

// Iterates through the rows, printing a node for each row.
while ($row = @mysql_fetch_assoc($resultGoogle)) 
	{
	//print_r($row);exit;

	$park=$row["park_abbr"];
	$gis_id=$row["gis_id"];
	$lon=$row["lon"];
		if($row["lon"]>0){$row["lon"]="-".$row["lon"];}
		$kml[] = " <Placemark id=\"placemark" . $gis_id . "\">";
		$kml[] = " <name>" . htmlentities($row["fac_name"]) . "</name>";
		
		$fullName=$row["park_abbr"]." [".$row["fac_name"]."] ";
		if(!empty($row["sub_unit"]))
			{
			$fullName.=" [".$row["sub_unit"]."] ";
			}
		$fullName.=$gis_id;
		
	
		   $editLink=" - <a href='http://$domain/facilities/edit_fac.php?&gis_id=$gis_id'>Update</a><br />";
		  $kml[] = " <description>" . htmlentities($fullName)  .  htmlentities($editLink) . "</description>";
	
		
		
		$iconType="bar";
		$kml[] = " <styleUrl>#" . ($iconType) ."Style</styleUrl>";
		$kml[] = " <Point>";
		$kml[] = " <coordinates>" . $row["lon"] . ","  . $row["lat"] . "</coordinates>";
		$kml[] = " </Point>";
		$kml[] = " </Placemark>";
	} 

// End XML file
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);

if($_GET['google_type']=="gm")
	{
	$time=time();
	
	if(!empty($park_abbr))
		{
		$googleFile=$park_abbr."_park_residence_".$time.".kml";
		}
	if(!empty($fac_type))
		{
		$googleFile=$fac_type."_park_facility_".$time.".kml";
		}
	
//	echo "<pre>$googleFile"; print_r($_REQUEST); echo "</pre>";  exit;

			
	$document_root=$base_server;
	$filename = $document_root."/facilities/google_earth/".$googleFile;

//	echo "<pre>$googleFile"; print_r($_REQUEST); echo "</pre>";  exit;

 	function touch_it_good($filename){exec("touch {$filename}");}
	touch_it_good($filename); 

	$somecontent = $kmlOutput;

// Let's make sure the file exists and is writable first.
if (is_writable($filename)) {

  // The file pointer is at the start of the file and will
  //replace any existing content.
   if (!$handle = fopen($filename, 'w')) {
     echo "Cannot open file ($filename)";
     exit;
  }

   // Write $somecontent to our opened file.
   if (fwrite($handle, $somecontent) === FALSE) {
    echo "Cannot write to file ($filename)";
    exit;
  }
  
 // echo "Success, wrote ($somecontent) to file ($filename)";
  
   fclose($handle);}
header("Location:http://maps.google.com/maps?f=q&hl=en&geocode=&q=http://$domain/facilities/google_earth/$googleFile&z=16' target='_blank'");
}
?>