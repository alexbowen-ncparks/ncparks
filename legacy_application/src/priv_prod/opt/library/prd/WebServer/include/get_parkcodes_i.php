<?php
$database="dpr_system";
$db=$database;
if(!isset($connection)){include("iConnect.inc");}
mysqli_select_db($connection,'dpr_system'); // database

$new_array_eadi_north=array("DISW","MEMI","PETT","JORI");
$new_array_eadi_south=array("CLNE","EADO","FOMA","GOCR","HABE");
			
$sql_parkcodes = "SELECT t1.parkcode, t1.county, t2.park_name, t2.district
From dprunit as t1
LEFT JOIN parkcode_names as t2 on t1.parkcode=t2.park_code
WHERE 1 
ORDER by t1.parkcode";
//echo "$sql"; //exit;
$result_parkcodes = mysqli_query($connection,$sql_parkcodes) or die ("Couldn't execute query. $sql_parkcodes");

$skip=array("ARCH","NCBL","YORK","EADI","NODI","SODI","WEDI","WARE");
while ($row_parkcodes=mysqli_fetch_array($result_parkcodes))
	{
	if(!in_array($row_parkcodes['parkcode'],$skip))
		{
		$parkCode[]=$row_parkcodes['parkcode'];
		}

// Park - District	
	if($row_parkcodes['district']!="")
		{
		$district[$row_parkcodes['parkcode']]=$row_parkcodes['district'];
		}
// Park Code - Park Name
	if($row_parkcodes['park_name']!="")
		{
		$parkCodeName[$row_parkcodes['parkcode']]=$row_parkcodes['park_name'];
		}
// Park Code - Park County
	if($row_parkcodes['county']!="")
		{
		$parkCounty[$row_parkcodes['parkcode']]=$row_parkcodes['county'];
		}

// District	arrays	
	if($row_parkcodes['district']=="EADI")
		{
		$all_parks[]=$row_parkcodes['parkcode'];
		$arrayEADI[]=$row_parkcodes['parkcode'];
		if(in_array($row_parkcodes['parkcode'],$new_array_eadi_north))
			{
			$dist_hr_array[$row_parkcodes['parkcode']]=60032955; // Latasha Peele position
			}
		if(in_array($row_parkcodes['parkcode'],$new_array_eadi_south))
			{
			$dist_hr_array[$row_parkcodes['parkcode']]=60032785; // Teresa McCall position
			}
		}
	if($row_parkcodes['district']=="NODI")
		{
		$all_parks[]=$row_parkcodes['parkcode'];
		$arrayNODI[]=$row_parkcodes['parkcode'];
		$dist_hr_array[$row_parkcodes['parkcode']]=60032955; // Latasha Peele position
		}
	if($row_parkcodes['district']=="SODI")
		{
		$all_parks[]=$row_parkcodes['parkcode'];
		$arraySODI[]=$row_parkcodes['parkcode'];
		$dist_hr_array[$row_parkcodes['parkcode']]=60032785; // Teresa McCall position
		}
	if($row_parkcodes['district']=="WEDI")
		{
		$all_parks[]=$row_parkcodes['parkcode'];
		$arrayWEDI[]=$row_parkcodes['parkcode'];
		$dist_hr_array[$row_parkcodes['parkcode']]=60032783; // Sheila Green position
		}
	}

		$dist_hr_array['YORK']=60032785; // Teresa McCall position
		$dist_hr_array['ARCH']=60032783; // Sheila Green position
		
		if(!in_array("EADI",$arrayEADI)){$arrayEADI[]="EADI";}
		if(!in_array("NODI",$arrayNODI)){$arrayNODI[]="NODI";}
		if(!in_array("SODI",$arraySODI)){$arraySODI[]="SODI";}
		if(!in_array("WEDI",$arrayWEDI)){$arrayWEDI[]="WEDI";}
				
?>