<?php
//These are placed outside of the webserver directory for security
ini_set('display_errors',1);
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
$multi_park=explode(",",$_SESSION[$database]['accessPark']);

// include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");

$database="facilities";
mysqli_select_db($connection,$database); // database

extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

$level=$_SESSION[$database]['level'];

if($level<5)
	{
	$readonly=array("gis_id","dist","occupant","park_abbr","doi_id","spo_assid","spo_assid");
	}


if($level<3)
	{
	$add_readonly=array("year","location","sq_foot","bedrms","bathrms","ac", "rent_code","salary","rent_fee","salary","current_salary");
	$readonly=array_merge($readonly,$add_readonly);
	}

if($level<3)
	{
	$ignore=array("rent_code","rent_comment","current_salary","rent_fee","salary");
//	$add_readonly=array("GIS_ID");
//	$readonly=array_merge($readonly,$add_readonly);
	}
	

	include("menu.php");
	

// $housing_fields="t4.gis_id, t4.doi_id,  t4.park_abbr, t4.spo_assid, t4.status, t4.fac_name, t1.dist, t1.region, t1.tempID, t1.occupant, t1.position, t1.occupant_num, t1.location, group_concat(t6.pid) as fac_photo, t1.year, t1.bedrms, t1.bathrms, t1.ac, t1.rent_code, t1.salary, t1.rent_fee, t1.fas_num, t1.rent_comment,t1.comment, t5.comment as spo_comment";	
//t1.salary, 
$housing_fields="t4.gis_id, t4.doi_id,  t4.park_abbr, t4.spo_assid, t4.status, t4.fac_name, t1.dist, t1.region, t1.tempID, t1.occupant, t1.position, t1.occupant_num, t1.location,  t1.year, t1.bedrms, t1.bathrms, t1.ac, t1.rent_code, t1.rent_fee, t1.fas_num, t1.rent_comment,t1.comment, t1.lease_period, t5.comment as spo_comment";	

$housing_fields_array=array("id","dist", "region","park_abbr","tempID","occupant","position","occupant_num", "location","fac_photo","year","bedrms","bathrms","ac","rent_code","salary","rent_fee","rent_comment","fas_num","comment");	
//echo "<pre>"; print_r($fieldArray); echo "</pre>"; // exit;

if(!empty($gis_id))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	
	
$fieldArray=explode(",",$housing_fields);


	$sql="SELECT t1.pid
	from fac_photos as t1
	where t1.gis_id='$gis_id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$fac_photo_array[]=$row['pid'];
		}

	$sql="SELECT t1.link as agree_link, housing_agreement
	from housing_attachment as t1
	where t1.gis_id='$gis_id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$housing_attachment_array[]=array($row['agree_link'], $row['housing_agreement']);
		}
// 	t3.current_salary as salary, t8.annual_salary, 
// 	left join divper.employee_salary as t8 on t2.beacon_num=t8.beacon_num
	$sql="SELECT $housing_fields, t1.gis_id as housing_gis_id
	from spo_dpr as t4
	left join housing as t1 on t1.gis_id=t4.gis_id
	left join spo_dpr_comments as t5 on t5.gis_id=t4.gis_id
	left join fac_photos as t6 on t6.gis_id=t4.gis_id
	left join divper.emplist as t2 on t1.tempID=t2.tempID
	left join divper.position as t3 on t2.beacon_num=t3.beacon_num
	where t4.gis_id='$gis_id'
	"; 
// if($level>4)
// 	{
// 	echo "$sql"; //exit;
// 	}

	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$num=mysqli_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
	
	$i=0;
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_edit=$row;
		}
	$park_abbr=$ARRAY_edit['park_abbr'];
// 	$salary=$ARRAY_edit['salary'];
	$rent_code=$ARRAY_edit['rent_code'];
if($level>4)
	{
// 	echo "<pre>"; print_r($ARRAY_edit); echo "</pre>";  //exit;
// 	echo "<pre>"; print_r($fac_photo_array); echo "</pre>";  //exit;
// 	echo "<pre>"; print_r($housing_attachment_array); echo "</pre>";  //exit;
	}
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	if($park_abbr != $_SESSION['facilities']['select'] AND !in_array($park_abbr,$multi_park) AND $level<2)
		{
	//	echo "p =$park_abbr<br />";
	//	echo "mp<pre>"; print_r($multi_park); echo "</pre>"; // exit;
	//	echo "l =$level<br />";
		exit;
		}
	
	
	$sql="SELECT tempID from divper.emplist where currPark='$park_abbr' order by tempID";
	$result = @mysqli_QUERY($connection,$sql);  //echo "s $sql";
	$source="";
	while($row=mysqli_fetch_assoc($result))
			{
			$source.="\"".$row['tempID']."\",";
			}
		$source=rtrim($source,",");  //echo "s=$source";
		
		//echo "$source";
	}// end Find

echo "<form action='housing_update.php' method='POST' enctype='multipart/form-data'>
	<table border='1' cellpadding='5'>";

// include("calc_rent.php");

include("find_form.php");
	
	
include("upload_form.php");


	if(!empty($spo_bldg_asset_number ) or @$spo_bldg_asset_number!=0)
		{
		$input_spo="<input type='hidden' name='spo_bldg_asset_number' value='$spo_bldg_asset_number'>";
		}
	echo "<tr>
	<td colspan='3' align='center'>
	<input type='hidden' name='gis_id' value='$gis_id'>
	<input type='submit' name='submit_label' value='Update' style=\"background-color:lightgreen;width:65;height:35\"></td>
	</form>";
	
	
	if(!empty($housing_gis_id))
		{
		echo "<td colspan='1' align='center'>
		<form action='/photos/store.php' method='POST'>
		<input type='hidden' name='source' value='housing'>
		<input type='hidden' name='photo_num' value='$photo_num'>";

		if(!empty($input_spo)){echo "$input_spo";}

		echo "<input type='hidden' name='gis_id' value='$gis_id'>
		<input type='hidden' name='fac_type' value='Park Residence'>
		<input type='hidden' name='pass_cat' value='facility'>
		<input type='hidden' name='park' value='$park_abbr'>
		<input type='submit' name='submit' value='Add a Photo' style=\"background-color:violet;width:85;height:35\"></form>";
		}
	echo "</td>
		
	<form action='find.php' method='POST'>
	<td colspan='2' align='center'>";
	if(!empty($park_abbr))
		{
		echo "<input type='hidden' name='park_abbr' value='$park_abbr'>";
		}
		echo "<input type='hidden' name='fac_type' value='Park Residences'>";
	echo "<input type='submit' name='submit_label' value='Go to Find' style=\"background-color:lightblue;width:75;height:35\"></td>
	</tr></table></form>";

echo "</body></html>";

?>