<?php
if(empty($connection))
	{
	$db="dpr_system";
	include("../../include/iConnect.inc"); // database connection parameters
	}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

extract($_REQUEST);


date_default_timezone_set('America/New_York');
$today=date("Y-m-d");
$sql="SHOW columns from survey_2013";
$result = mysqli_query($connection,$sql);

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['Field']]="";
	}
 mysqli_free_result($result);

$sql="SELECT * FROM parkcode_names";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
//	if($row['park_code']=="WARE"){continue;}
	$parkcode_parkname[$row['park_code']]=$row['park_name'];
	$park_county[$row['park_code']]=$row['county'];
	}
$num_parks=count($parkcode_parkname);
 mysqli_free_result($result);
// ******************* Form ********************

$skip=array("id");
$emp_status_array=array("Permanent","Temporary/Contract");

if(!empty($id) or !empty($park_code))
	{
	if(!empty($id))
		{$where="id='$id'";}
		else
		{$where="park_code='$park_code'";}
	$sql="SELECT * from survey_2013 where $where";
	$result = mysqli_query($connection,$sql);

	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_ID=$row;
		}
	if(!empty($ARRAY_ID))
		{
		$ARRAY=$ARRAY_ID;
		extract($ARRAY_ID);
		}
	 mysqli_free_result($result);
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

/*
echo "<table><tr><th colspan='2' valign='top'>Legislative Site Survey - </th><td>";
echo "<td>n=$num_parks<form>
<select name='park_code' onchange=\"this.form.submit()\"><option value='' selected></option>\n";
foreach($parkcode_parkname as $k=>$v)
	{
	if(@$park_code==$k){$s="selected";}else{$s="";}
	echo "<option value='$k' $s>$v</option>\n";
	}
echo "</select></form></td>";
if(!empty($park_code))
	{
	$pc=strtolower($park_code)."_search.jpg";
	$img="http://ncparks.gov/pictures/starmaps/$pc";
	echo "<td><img src='$img'></td>";
	}
echo "</tr></table>";
*/
if(empty($park_code)){exit;}

// ********** Park Specific *************
$sql="SELECT * FROM dprunit where parkcode='$park_code'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_contact[$row['parkcode']]=$row;
	}
//echo "<pre>"; print_r($park_contact); echo "</pre>";  exit;
$sql="SELECT * FROM park_birthday where park_code='$park_code'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_date[$row['park_code']]=$row;
	}
$sql="SELECT parkcode, sum(acres_land) as acres_land, sum(acres_water) as acres_water, sum(length_miles) as length_miles, sum(easement) as easement, group_concat(note_1,' ',note_2) as `Acres Comments`
FROM dpr_acres 
where parkcode='$park_code'
group by parkcode";  //echo "$sql";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_acres[$row['parkcode']]=$row;
	}
$sql="SELECT * FROM act.info where park='$park_code'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$pc=strtoupper($row['park']);
	$park_act[$pc]=$row;
	}
$sql="SELECT t1.Fname, t1.Lname, t3.working_title
FROM divper.empinfo as t1
left join divper.emplist as t2 on t1.emid=t2.emid
left join divper.position as t3 on t3.beacon_num=t2.beacon_num
where t3.park='$park_code' and t3.beacon_title='Law Enforcement Supervisor'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$contact=$row['Fname']." ".$row['Lname'].", ".$row['working_title'];
	}

include("facilities.php");    // call query from here

include("fiscal_year_attendance.php");    // call query from here

include("fiscal_year_programs.php");    // call query from here

include("rentals.php");    // call query from here

include("fiscal_year_budget.php");    // call query from here

include("fiscal_year_staff.php");    // call query from here

include("fiscal_year_vols.php");    // call query from here

include("fiscal_year_r_r.php");    // call query from here

include("fiscal_park_year_maj_cap.php");    // call query from here

include("fiscal_park_year_land.php");    // call query from here

include("need_support_limit.php");    // call query from here


 mysqli_free_result($result);
 
mysqli_close($connection);


echo "<html>";

foreach($ARRAY AS $fld=>$value)
	{
	if(in_array($fld, $skip)){continue;}
	
	include("fields_word.php");

	}
	
echo "</html>";
?>