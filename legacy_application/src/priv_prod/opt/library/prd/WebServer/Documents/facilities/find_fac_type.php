<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
if(!empty($_SESSION[$database]['accessPark']))
	{$multi_park=explode(",",$_SESSION[$database]['accessPark']);}

date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,$database); // database

ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//  echo "<pre>";print_r($_SESSION);echo "</pre>";
$level=$_SESSION[$database]['level'];

if(!empty($fac_type))
	{$fac_type_title=$fac_type;}
	else
	{$fac_type_title="";}


$dist_parks="";
$ignore=array();
if($level<3)
	{
	$ignore=array("rent_code","rent_comment","rent_fee");
	
	$ignore[]="tempID";
	
	if($level==2)
		{
		$reg=$_SESSION[$database]['select'];
		include("../../include/get_parkcodes_reg.php");
		$limit_dist=${"array".$reg};
// 		echo "$dist<pre>"; print_r($limit_dist); echo "</pre>";  exit;
		$dist_parks="and (";
		foreach($limit_dist as $k=>$v)
			{
			$dist_parks.="park_abbr='$v' OR ";
			}
		$dist_parks=rtrim($dist_parks," OR ").")";
		mysqli_select_db($connection,$database); // database
		}
	if($level==1)
		{
		$dist_parks="and park_abbr='".$_SESSION['facilities']['select']."'";
		if(!empty($multi_park))
			{
			$var="and (";
			foreach($multi_park as $k=>$v)
				{
				$v=trim($v);
				$var.="park_abbr='$v' OR ";
				}
			$dist_parks=rtrim($var," OR ").")";
			}
		}	
	}


mysqli_select_db($connection,"facilities"); // database
	$sql = "SHOW COLUMNS FROM spo_dpr";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysqli_num_rows($result);
	while ($row=mysqli_fetch_assoc($result))
		{
		if(in_array($row['Field'],$ignore)){continue;}
		$fieldArray[]=$row['Field'];
	//	$fieldArray_edit[]=$row['Field'];
		}

if(@$rep=="")
	{
	include("menu.php");
	
	echo "<form action='find_fac_type.php' method='POST'>
	<table border='1' cellpadding='5'><tr><td colspan='5' align='left'><font color='blue'><b>$fac_type_title</b></font></td></tr>";
	
// **********************
			include("find_form_fac_type.php");
	
	echo "<tr>
	<td colspan='2' align='center'><input type='submit' name='submit_label' value='Find' style=\"background-color:lightgreen;width:65;height:35\"></form></td>";
	
if(!empty($fac_type))
	{
	echo "<td align='center'><form action='/facilities/find_fac_type.php?fac_type=$fac_type' method='POST'>
<input type='hidden' name='submit_label' value='Find'>
<input type='submit' name='submit' value='Facility Type All Parks' style=\"background-color:yellow;width:85;height:35\"></form>
</td>";
	}
/*
echo "<td align='center'><form action='/facilities/find_fac_type.php' method='POST'>
<input type='submit' name='submit' value='Clear' style=\"background-color:pink;width:85;height:35\"></form>
</td>";
*/
echo "</tr></table>";
	}
else
	{
	$date=date('Y-m-d'); //echo "d=$date"; exit;
	$sort="park_abbr";
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  
	$var=str_replace("*", "'", $var)." order by t1.park_abbr";
	$sql="SELECT t1.*, t2.comment as comment from spo_dpr as t1
		left join spo_dpr_comments as t2 on t1.gis_id = t2.gis_id
		where $var
		"; 

	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error());
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// 	echo "$sql<pre>"; print_r($ARRAY); echo "</pre>";  exit;

header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=facility_export.$date.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
// 		$comment_line[]=array("To prevent Excel dropping any leading zero of an upper_left_code or upper_right_code an apostrophe is prepended to those values and only to those values.");
			$output = fopen("php://output", "w");
// 			foreach ($comment_line as $row) {
// 				fputcsv($output, $row); // here you can change delimiter/enclosure
// 			}
			foreach ($header_array as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
		fclose($output);
		}

		$header_array[]=array_keys($ARRAY[0]);
// 		echo "<pre>"; print_r($header_array); print_r($comment_line); echo "</pre>";  exit;
		outputCSV($header_array, $ARRAY);
		exit;
	}

if(@$submit_label=="Go to Find" OR @$submit_label=="Find" OR @$rep!="")
	{
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($fieldArray);echo "</pre>";
	
	$like=array("comment","doi_id");
	
	$end_with=array("doi_id");
	
$skip=array("datecreate","crs_idn");
	
if($level<2)
	{$skip[]="comment";}	
	
	
	$arraySet="1";
	$passQuery="";
	$map_array=array();
	
	for($i=0;$i<count($fieldArray);$i++)
		{
		@$val=${$fieldArray[$i]};// force the variable
		if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
		
		// Like
		if(in_array($fieldArray[$i],$like))
			{
			if(in_array($fieldArray[$i],$end_with))
				{
				$arraySet.=" and t1.".$fieldArray[$i]." like '%_".$val."'";
				$map_array[$fieldArray[$i]]=" like '%_".$val."'";
				$passQuery=$fieldArray[$i]."=".$val."&";
				}
				else
				{
				$arraySet.=" and t1.".$fieldArray[$i]." like '%".$val."%'";
				$map_array[$fieldArray[$i]]=" like '%".$val."%'";
				$passQuery=$fieldArray[$i]."=".$val."&";
				}
			
			}
		
			else
			{
		// Equals
			$val="'".$val."'";
			$arraySet.=" and t1.".$fieldArray[$i]."=".$val;
				$map_array[$fieldArray[$i]]="=".$val;
			$passQuery=$fieldArray[$i]."=".$val."&";
			}
		}
// 	echo "<pre>"; print_r($passQuery); echo "</pre>"; // exit;
	//echo "<pre>"; print_r($map_array); echo "</pre>";  exit;
// 	echo "<pre>"; print_r($arraySet); echo "</pre>"; // exit;
	$field_list=implode(",",$fieldArray);
	
	if($arraySet==""){$arraySet="1";}
	
	if(@$id)
		{
		// t1 = housing
		$arraySet="1 and t1.id='$id'";
		}


	
if($arraySet=="1"){exit;}

// echo "<pre>"; print_r($arraySet); echo "</pre>"; // exit;


		$sql="SELECT t1.*, t2.comment as comment from spo_dpr as t1
		left join spo_dpr_comments as t2 on t1.gis_id = t2.gis_id
		where $arraySet $dist_parks
		"; 
//		echo "$sql";
//		echo "$arraySet<br />$dist_parks";

	$order_by="ORDER BY park_abbr";
	
	$sql.=" ".$order_by;



$pass_clause="<form action='ge_ID_fac_type.php' target='_blank' method='POST'>";

$var=str_replace('t1.', '',$arraySet);
$var=str_replace('1 and ', '',$var);

if(!empty($dist_parks))
	{$var.=" ".$dist_parks;}

$pass_clause.= "<input type='hidden' name='pass_clause' value=\"$var\">";


$pass_clause.="<input type='submit' name='submit' value='Map Found Records'>";
$pass_clause.="</form>";

	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error());
	$num=mysqli_num_rows($result);
	
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}

	if($num<1){echo "No record found using $arraySet"; exit;}
		
$var=str_replace('\'', '*',$arraySet);
	echo "<table border='1'><tr><td colspan='6'>Number found: $num $fac_type</td><td colspan='3' align='left'>$pass_clause</td><td colspan='10'>&nbsp;&nbsp;<a href='find_fac_type.php?rep=1&var=$var'>Export</a></td></tr>";
		foreach($ARRAY[0] as $k=>$v)
			{
	if(in_array($k,$skip)){continue;}
			echo "<th>$k</th>";
			}
	echo "</tr>";
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;	
	foreach($ARRAY as $k=>$array)
		{
		echo "<tr>";
		foreach($array as $k1=>$v1)
			{
	if(in_array($k1,$skip)){continue;}
			if($k1=="gis_id" AND @$rep=="")
				{
				$v1="<a href='edit_fac.php?gis_id=$v1'>$v1</a>";
				}
				
			if(strpos($k1,"photo")>-1)
				{
				if($v1!="")
					{
					$link="/photos/getData.php?pid=$v1";
					$v1="<a href='$link&source=divper' target='_blank'>photo</a>";
					}
				if(@$rep!=""){$v1="photo taken";}			
				}
			
			if($k1=="lat")
				{
				$long=$array['long'];
			$v1="<a href='https://maps.google.com/maps?safe=off&q=$v1,$long&um=1&ie=UTF-8&hl=en&sa=N&tab=wl' target='_blank'>$v1</a>";
				}
			if($k1=="spo_assid" and $v1!=0)
				{
				$v1="<a href='http://www.ncspo.com/FIS/dbBldgAsset_public.aspx?BldgAssetID=$v1' target='_blank'>$v1</a>";
				}
			if($k1=="comment")
				{
				$v1=substr($v1,0,100)."...";
				if(@$rep!=""){$v1="photo taken";}			
				}
					
			echo "<td>$v1</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
	}// end Find
echo "</body></html>";
mysqli_close($connection);

?>