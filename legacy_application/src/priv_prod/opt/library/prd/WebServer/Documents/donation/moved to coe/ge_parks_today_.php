<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;
$_GET['ge']="m";
if($_GET['ge']=="" and $_GET['gm']==""){echo "No record was selected. Click your browser's back button.";exit;}

$domain="www.dpr.ncparks.gov";

//echo "<pre>";print_r($_GET); echo "</pre>";exit;

$db="donation";
$database=$db;
ini_set('display_errors',1);

include("../../include/connectROOT.inc");  //sets $database

// Sets the active MySQL database.
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) 
{
  die ('Can\'t use db : ' . mysql_error());
}

date_default_timezone_set('America/New_York');
$pass_edit=date("Y-m-d");

$sql="SELECT '100th', 'x',  t1.park
from donation.calendar as t1 
where t1.date = '$pass_edit'
union
select 'dprcoe', t2.ann_100, t2. park
from dprcoe.event as t2
where t2.dateE = '$pass_edit'
order by 100th, park
"; //echo "$sql";
$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row=mysql_fetch_assoc($result))
	{
	$geArray[]=$row['park'];
	}
	
$_GET['var']="CABE,ENRI,MOJE,GORG";
//$_GET['var']="CABE";
$_GET['sn']="NC State Parks-100th_Anniversary";
 
$table1="dpr_system.dprunit";
$table2="dpr_system.parkcode_names";
 if($_GET['var']!="")
	{
//		$varTrim=rtrim($_GET['var'],",");
//		$geArray=explode(",",$varTrim);
		foreach($geArray as $v)
			{
			@$where.="parkcode='".$v."' OR ";
			}
			$where=rtrim($where," OR");
			 $query = "SELECT `parkcode` as `park_code`,`park_name`, left(latoff,10) as lat, left(lonoff,10) as lon
			 FROM $table1 as t1
			 LEFT JOIN $table2 as t2 on t1.parkcode=t2.park_code
			 WHERE $where"; 
		//	 echo "$query<br />p=$_POST[passCount] t=$test";exit;
	}

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
//$kml[] = " <href>http://maps.google.com/mapfiles/kml/pal4/icon49.png</href>";
// red ballon with dot
$kml[] = " <href>http://maps.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png</href>";
$kml[] = " </Icon>";
$kml[] = " </IconStyle>";
$kml[] = " </Style>";

// Iterates through the rows, printing a node for each row.
while ($row = @mysql_fetch_assoc($resultGoogle)) 
	{
		//	echo "<pre>"; print_r($row); echo "</pre>"; exit;
	$id=$row["park_code"];
	$park=$row['park_name'];
	
	if($row['lat']=="")
		{
		include("../_base_top.php");
		echo "No base coordinates have been entered for <b>$park</b>. These are required before we can map distribution by park. Contact the System Admin using the \"Admin Page\" link and request coordinates be entered for this park.";
		exit;
		}
	
	$sn=$_GET['sn'];
	if(in_array($id,$geArray))
	{
	if($row["lon"]>0){$row["lon"]="-".$row["lon"];}
	  $kml[] = " <Placemark id=\"placemark" . $id . "\">";
	  $kml[] = " <name>" . htmlentities($park) . "</name>";
	  $fullName=$sn;
	  $editLink="View NC State Parks <a href='http://$domain/dprcoe/findPub.php?ann_100=$pass_edit&park=$id' target='_blank'>100th Anniversary Events</a>";
//	  $kml[] = " <description>" . htmlentities($fullName) ."<br />". htmlentities($editLink) .  "</description>";
	  $kml[] = " <description>". htmlentities($editLink) .  "</description>";
	  $iconType="bar";   // line 66
	  $kml[] = " <styleUrl>#" . ($iconType) ."Style</styleUrl>";
	  $kml[] = " <Point>";
	  $kml[] = " <coordinates>" . $row["lon"] . ","  . $row["lat"] . "</coordinates>";
	  $kml[] = " </Point>";
	  $kml[] = " </Placemark>";}
	} 

//echo "<pre>"; print_r($kml); echo "</pre>"; exit;

// End XML file
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);

/*
if($_GET['ge']=="e")
	{
	$sci=explode(" ",$_GET['sn']);
	$title=$sci[0]."_".$sci[1].".kml";

	//	if($_GET['sn']!=""){$title=$_GET['sn'].".kml";}
	
	header("Content-type: application/vnd.google-earth.kml+xml");
	header("Content-Disposition: attachment; filename=$title");
	echo "$kmlOutput";
	exit;
	}
*/

if($_GET['ge']=="m")
	{
//	echo "<pre>"; print_r($_REQUEST); print_r($_SERVER); echo "</pre>";  exit;
	$sci=explode(" ",$_GET['sn']);
//	$googleFile=$sci[0]."_".$sci[1].".kml";

$time=time();
	$googleFile=$time.".kml";

	//	if($_GET['sn']!=""){$googleFile=$_GET['sn'].".kml";}

	$document_root1="/opt/library/prd/WebServer/Documents";
//	$var1=$_SERVER['SCRIPT_URL'];
//	$var2=explode("/",$var1);
//	$document_root=$var2[1];

	$filename = $document_root1."/donation/google_map/".$googleFile;
//	echo "$filename d=$document_root"; exit;
@unlink($filename); //exit;
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
header("Location:http://maps.google.com/maps?f=q&hl=en&geocode=&q=http://$domain/donation/google_map/$googleFile&z=8' target='_blank'");
}
?>