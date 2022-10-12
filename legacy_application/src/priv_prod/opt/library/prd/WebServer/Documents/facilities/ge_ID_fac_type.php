<?php
//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; exit;

$dir = "google_earth";
$dh = opendir($dir);

$path="/opt/library/prd/WebServer/Documents/facilities/google_earth/";
 while (false !== ($filename = readdir($dh))) {
	if($filename!="."&&$filename!=".."&&$filename!=".DS_Store")
		{
		unlink($path.$filename);
		}
 }
 
//echo "<pre>"; print_r($files); echo "</pre>";  exit;

$domain="10.35.152.9";
$domain="10.35.152.9";
$base_server="/opt/library/prd/WebServer/Documents";
$db="facilities";
$database=$db;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

include("../../include/auth.inc"); // includes session_start();
//$park=$_SESSION['nrid']['select'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if(empty($connection))
{include("../../include/iConnect.inc");}

include("../../include/get_parkcodes_dist.php"); // includes session_start();

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

$clause="";
 foreach($_POST as $k=>$v)
 	{
 	if($k=="submit"){continue;}
 	$clause.=$k.$v." and ";
 	}
 	$where=rtrim($clause," and ");
 
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
 if(!empty($_REQUEST['fac_type']) and COUNT($_POST)<3)
 	{
 	$var=$_REQUEST['fac_type'];
 	$var=str_replace("'","",$var);
 	$var=str_replace("=","",$var);
 	$var=stripslashes($var);
 	}
 if(!empty($_REQUEST['pass_clause']))
 	{
 	$where=stripslashes($_REQUEST['pass_clause']);
 	}
 	
 if($where!="")
 	{
	 $query = "SELECT gis_id, park_abbr, fac_name, sub_unit, doi_id, left(lat,10) as lat, left(`long`,10) as lon
	 FROM spo_dpr
	 WHERE $where"; 
//	 echo "$query<br />";exit;
	}

 $resultGoogle = mysqli_query($connection,$query);
 if (!$resultGoogle) 
	 {
	  die('Invalid query: ' . mysqli_error($connection). $query);
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

//echo "<pre>"; print_r($kml); echo "</pre>";  exit;
// Iterates through the rows, printing a node for each row.
while ($row = @mysqli_fetch_assoc($resultGoogle)) 
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
		
	
		   $editLink=" - <a href='https://$domain/facilities/edit_fac.php?gis_id=$gis_id'>Update</a><br />";
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

//echo "<pre>"; print_r($kml); echo "</pre>";  exit;
$kmlOutput = join("\n", $kml);


	$time=time();
	
	if(!empty($_POST['fac_type']))
		{
		$fac_type=$_POST['fac_type'];
		$fac_type=str_replace(" ","_".$fac_type);
		$googleFile=$fac_type."_park_facility_".$time.".kml";
		}
		else
		{
		$googleFile="park_facility_".$time.".kml";
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
  
   fclose($handle);
   }

$goto="https://10.35.152.9/facilities/google_earth/$googleFile";
$goto="https://10.35.152.9/facilities/google_earth/$googleFile";

header("Location: $goto");


// header("Location:http://maps.google.com/maps?f=q&hl=en&geocode=&q=https://$domain/facilities/google_earth/$googleFile&z=16' target='_blank'");

?>