<?php
$database="dpr_system";
ini_set('display_errors', 1);
if(@$_POST['submit']=="Reset"){unset($_REQUEST);}
@extract($_REQUEST);
if(empty($rep)){session_start();}
include("_base_top.php");

if(empty($connection))
	{
	$db="dpr_system";
	include("../../include/iConnect.inc"); // database connection parameters
	}

if(empty($rep))
	{
	$database="dpr_system";
// 	include("_base_top.php");
	}

if(!empty($ticket_id))
	{
	include("time_track_update.php");
	}
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
if(!empty($_POST['submit_form']))
	{
	include("track_time_action.php");
	$pass_ticket_id=$insert_id;
	}
	
date_default_timezone_set('America/New_York');
$today=date("Y-m-d");

$sql="SHOW columns from track_time";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_flds[]=$row['Field'];
	}
 
$sql="SELECT distinct parkcode as park_code from dprunit_district where 1";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_code[]=$row['park_code'];
	}

$ARRAY_employee_status=array("permanent","seasonal","nondpr","other");
// $ARRAY_issue_type=array("permanent","seasonal","nondpr","other");

$exclude_unit=array("WOED");
$sql="SELECT * FROM parkcode_names_district order by park_code";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['park_code'],$exclude_unit)){continue;}
// 	if($row['park_code']=="WEWO"){$row['park_name']="Weymouth Woods State Natural Area";}
	$parkcode_parkname[$row['park_code']]=$row['park_name'];
	$park_county[$row['park_code']]=$row['county'];
	}
//echo "<pre>"; print_r($parkcode_parkname); echo "</pre>";  exit;
$num_parks=count($parkcode_parkname);
// ******************* Form ********************

if(!empty($id) or !empty($park_code))
	{
	if(!empty($id))
		{$where="id='$id'";}
		else
		{$where="park_code='$park_code'";}
	$sql="SELECT * from track_time where $where";
	$result = mysqli_query($connection,$sql);

	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;


echo "<table><tr valign='top'><td><b>DPR Time Tracking - Logging</b></td></tr>";
echo "<tr valign='top'>
<td>
</tr>";
echo "<tr valign='top'><td> </td></tr>";
echo "<tr valign='top'><td><form><b>Select a Location: </b>
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
	$img="https://files.nc.gov/ncparks/park-dot-maps/cliffs-neuse-nc-map.png";
	echo "<td><img src='$img'></td>";
	}

if(empty($park_code))
	{
	echo "</tr>";
// 	exit;
	$park_code="";
	}

// ********** Park Specific *************
$sql="SELECT t1.parkcode as park_code, t2.park_name, t1.ophone, phone1, phone2
FROM dprunit_district as t1
left join parkcode_names_district as t2 on t1.parkcode=t2.park_code
where t1.parkcode='$park_code'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$park_contact[$row['park_code']]=$row;
	}

$contact=array();
$sql="SELECT t1.Fname, t1.Lname, t3.working_title, t2.tempID
FROM divper.empinfo as t1
left join divper.emplist as t2 on t1.emid=t2.emid
left join divper.position as t3 on t3.beacon_num=t2.beacon_num
where t3.park='$park_code'
order by t1.Lname";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$perm_contact[$row['tempID']]=$row['Fname']." ".$row['Lname'].", ".$row['working_title'];
	}
$sql="SELECT t1.Fname, t1.Lname, t1.tempID
FROM divper.nondpr as t1
where t1.currPark='$park_code'
order by t1.Lname";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$seasonal_contact[$row['tempID']]=$row['Fname']." ".$row['Lname'];
	}
// echo "<pre>"; print_r($seasonal_contact); echo "</pre>";
echo "<td>";
if(!empty($park_contact))
	{
	foreach($park_contact[$park_code] as $k=>$v)
		{
		echo "$k ==> $v<br />";
		}
	}
echo "</td>";
echo "<td>
<a onclick=\"toggleDisplay('contact');\" href=\"javascript:void('')\">Permanent Staff</a>
<div id=\"contact\" style=\"display: none\">";
if(!empty($perm_contact))
	{
	foreach($perm_contact as $k=>$v)
		{
		if(strpos($v, "Superintendent")>1){$v="<b>$v</b>";}
		$k="<a href='track_time.php?employee_status=permanent&park_code=$park_code&submitter=$k'>$k</a>";
		echo "$k ==> $v<br />";	
		}
	}
	else
	{echo "Must select a Location to get Staff.";}
echo "</div>&nbsp;&nbsp;&nbsp;</td>";

echo "<td>
<a onclick=\"toggleDisplay('seasonal');\" href=\"javascript:void('')\">Seasonal Staff</a>
<div id=\"seasonal\" style=\"display: none\">";
if(!empty($seasonal_contact))
	{
	foreach($seasonal_contact as $k=>$v)
		{
		$k="<a href='track_time.php?employee_status=seasonal&park_code=$park_code&submitter=$k'>$k</a>";
		echo "$k ==> $v<br />";	
		}
	}
	else
	{echo "Must select a Location to get Staff.";}
echo "</div>&nbsp;&nbsp;&nbsp;</td>";
echo "<td><div>";
echo "<a href='track_time.php?employee_status=nondpr&park_code=$park_code&submitter='>nondpr</a>";
echo "</div></td>";

echo "</tr></table>";

if(empty($submitter))
	{
// 	exit;
	}
// echo "<pre>"; print_r($ARRAY_flds); echo "</pre>"; //exit;


// ************************************************
if(!empty($pass_ticket_id))
	{
	$sql="SELECT * from track_time where pass_ticket_id='$pass_ticket_id'";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		}
	}
$skip=array();
$readonly=array("ticket_id","date_create","date_update","park_code","submitter","employee_status");
echo "<form method='POST' action='track_time.php'>";
echo "<table>";
foreach($ARRAY_flds AS $num=>$fld)
	{
	if(in_array($fld, $skip)){continue;}
	if($fld=="date_create"){${$fld}=date("Y-m-d h:i:s");}
	if(empty(${$fld})){${$fld}="";}
	if(in_array($fld, $readonly)){$ro="readonly";}else{$ro="";}
	$input_type="<input type='text' name='$fld' value=\"".${$fld}."\" $ro>";
	if($fld=="notes")
		{
		$input_type="<textarea name='$fld' cols='100' rows='3'>".
		${$fld}
		."</textarea>";
		}
	echo "<tr>
	<td>$num</td>
	<td>$fld</td>
	<td>$input_type</td>
	</tr>";
	}
echo "<tr><td><input type='submit' name='submit_form' value=\"Add\"></td></tr>";
echo "</table></form>";
echo "</body></html>";
-
-mysqli_close($connection);
?>