<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
//if($_POST['ge']=="" and $_POST['gm']==""){echo "No record was selected. Click your browser's back button.";exit;}

$domain="10.35.152.9";
$domain="10.35.152.9";
$base_server="/opt/library/prd/WebServer/Documents";
$db="facilities";
$database=$db;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

include("../../include/auth.inc"); // includes session_start();
include("../../include/get_parkcodes_dist.php"); // includes session_start();
//$park=$_SESSION['nrid']['select'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$dir = "google_earth";
$dh = opendir($dir);

$path="/opt/library/prd/WebServer/Documents/facilities/google_earth/";
 while (false !== ($filename = readdir($dh))) {
	if($filename!="."&&$filename!=".."&&$filename!=".DS_Store")
		{
		unlink($path.$filename);
		}
 }
 
if(empty($connection))
{include("../../../include/iConnect.inc");}

extract($_REQUEST);
if (!$connection) 
	{
	  die('Not connected : ' . mysqli_error($connection));
	}

// Sets the active MySQL database.
$database="facilities";
$db_selected = mysqli_select_db($connection,$database);
if (!$db_selected) 
{
  die ('Can\'t use db : ' . mysqli_error($connection));
}

 $pass_fac_type="";
 if(!empty($gis_id) or !empty($park_abbr) or @$fac_type=="Park Residence")
 	{
 	if(!empty($park_abbr))
 		{$where="t1.park_abbr='$park_abbr'";}
 		else
 		{$where=1;}
 	if(!empty($fac_type))
 		{
 		$where.=" and t1.fac_type='$fac_type'";
 		}
 	if(!empty($gis_id))
 		{
 		$where.=" and t1.gis_id='$gis_id'";
 		}
 		

 	$file="edit_fac.php";
 	if(@$fac_type=="Park Residence")
 		{
 		$pass_fac_type=$fac_type;
 		$file="edit.php";
 		$add_fld=", t2.occupant";
 		$join="LEFT JOIN housing as t2 on t1.gis_id=t2.gis_id";
 		if(!empty($gis_id))
 			{
 			$where.="and t1.gis_id='$gis_id'";
 			}
 		}
 		else
 		{
 		$add_fld="";
 		$join="";
 		}
 		
 	
	 $query = "SELECT t1.gis_id, t1.park_abbr, t1.fac_name, t1.fac_type, t1.doi_id, left(t1.lat,10) as lat, left(t1.`long`,10) as lon
	 $add_fld
	 FROM spo_dpr as t1
	 $join
	 WHERE $where 
	 and t1.lat>0"; 
//	 echo "$query<br />"; exit;
//	 echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//	 exit;
	}
	else
	{echo "Select a park before clicking the map link."; exit;}

 $resultGoogle = mysqli_query($connection,$query);
 if (!$resultGoogle) 
 {
  die('Invalid query: ' . mysqli_error($connection). $query);
 }

// Creates an array of strings to hold the lines of the KML file.
$kml = array("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
$kml[] = "<kml xmlns=\"https://earth.google.com/kml/2.1\">";

$kml[] = " <Document>";
$kml[] = " <Style id=\"restaurantStyle\">";
$kml[] = " <IconStyle id=\"restuarantIcon\">";
$kml[] = " <Icon>";
// white circle with dot
$kml[] = " <href>https://maps.google.com/mapfiles/kml/pal4/icon57.png</href>";
$kml[] = " </Icon>";
$kml[] = " </IconStyle>";
$kml[] = " </Style>";
$kml[] = " <Style id=\"barStyle\">";
$kml[] = " <IconStyle id=\"barIcon\">";
$kml[] = " <Icon>";
// red circle with dot
$kml[] = " <href>https://maps.google.com/mapfiles/kml/pal4/icon49.png</href>";
$kml[] = " </Icon>";
$kml[] = " </IconStyle>";
$kml[] = " </Style>";

// Iterates through the rows, printing a node for each row.
while ($row = @mysqli_fetch_assoc($resultGoogle)) 
	{
	print_r($row);    
	ECHO "<br />";
	//exit;
	continue;
//	if($fac_type=="Park Residence")
//		{$id=$_GET['id'];}
//		else
//		{$id=$row["id"];}
		
	$gis_id=$row["gis_id"];
	$park=$row["park_abbr"];
	$park_abbr=$row["park_abbr"];
	$doi_id=$row["doi_id"];
	$fac_type=$row["fac_type"];
	
	if(empty($row["occupant"]))
		{
		if($pass_fac_type=="Park Residence")
			{$row["occupant"]="VACANT";}
			else
			{$row["occupant"]="";}
		}
	$lon=$row["lon"];
		if($row["lon"]>0){$row["lon"]="-".$row["lon"];}
		$kml[] = " <Placemark id=\"placemark" . $gis_id . "\">";
		
		$kml[] = " <name>" . htmlentities($row["park_abbr"]) ."-". htmlentities($row["fac_name"]) ."-". htmlentities($row["occupant"]) ."</name>";
		$fullName=$row["doi_id"]." [".$row["fac_name"]."] ".$gis_id;
		
	
		   $editLink=" - <a href='https://$domain/facilities/$file?gis_id=$gis_id&doi_id=$doi_id' target='_self'>Update</a><br />";
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

//echo "$kmlOutput"; exit;

/*
if($_POST['google_type']=="ge")
	{
	$sci=explode(" ",$sn);
	$title=$park."_".$sci[0]."_".$sci[1].".kml";
//	echo "<pre>$title"; print_r($_REQUEST); echo "</pre>";  exit;

	if(!empty($check_for_park))
		{
		$googleFile=$check_for_park."_".$sci[0]."_".$sci[1].".kml";
		}
		else
		{
		$googleFile="map_".$sci[0]."_".$sci[1].".kml";
		}
	
	header("Content-type: application/vnd.google-earth.kml+xml");
	header("Content-Disposition: attachment; filename=$googleFile");
	echo "$kmlOutput";
	exit;
	}
*/
if($_GET['google_type']=="gm")
	{
	$time=time();
	
	if(!empty($park_abbr))
		{
		$googleFile=$park_abbr."_park_facility_".$time.".kml";
		}
		else
		{
		if(@$fac_type=="Park Residence")
			{$googleFile="park_residence_".$time.".kml";}
			else
			{exit;}		
		}
	
//	echo "<pre>$googleFile"; print_r($_REQUEST); echo "</pre>";  exit;

			
	$document_root=$base_server;
	$feed_url_js="/facilities/google_earth/".$googleFile;
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
   
include("ge_ID_js.php");
//header("Location: ge_ID_js.php?gis_id=$gis_id&feed_url_js=$feed_url_js");

}
?>