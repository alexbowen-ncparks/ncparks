<?php
$database="dpr_system";
ini_set('display_errors', 1);
if(@$_POST['submit']=="Reset"){unset($_REQUEST);}
@extract($_REQUEST);
if(empty($rep)){session_start();}
include("_base_top.php");
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
if(empty($connection))
	{
	$db="dpr_system";
	include("../../include/iConnect.inc"); // database connection parameters
	}

if(!empty($ticket_id) and $submit_form=="Update")
	{
	include("track_time_action.php");
	}
	
if(!empty($_POST['submit_form']) and $submit_form=="Add")
	{
	include("track_time_action.php");
	$pass_ticket_id=$insert_id;
	}

if(!empty($link) and $act=="Delete")
	{
	// passes $pass_ticket_id from line 10 of track_time_action.php
	include("track_time_action.php");
	}	
date_default_timezone_set('America/New_York');
$today=date("Y-m-d");

$activity_array=array("password_reset", "access_permanent", "access_seasonal_nondpr", "issue_prd", "issue_pub", "dev_app_prd", "test_app_prd", "dev_app_pub", "test_app_pub", "research", "documentation", "tutorial", "requested_action", "meeting", "other" );


$ticket_status_array=array("active","void");

$resolution_array=array("complete","on-going","paused");

// gets list of databases and creates lists for jquery input values
// client, database_app, etc.
include("track_time_fill_in_source.php");

$sql="SHOW columns from track_time";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_flds[]=$row['Field'];
	}
	
	// These are not fields in tract_time, but they are in other tables
	// This allows thest fields to show on the Add form of tract_time.php
	$ARRAY_flds[]="link";  // field in tract_time_uploads
	$ARRAY_flds[]="time_in_hours"; // field in tract_time_updates

// start location with hardwired values
$add_array=array("UNKN"=>"Unknown","STWD"=>"State Wide","PRTF"=>"PARTF","REMA"=>"REMA-Resource Management","FOSC"=>"FOSC-Safety Consultant","STLA"=>"State Lakes","TRPR"=>"Trails Program");
$location_code_location_name=array();
foreach($add_array as $k=>$v)
	{
	$location_code_location_name[$k]=$v;
	}
// add values from emplist
$sql="SELECT t1.park_code as location_code , t2.park_name
from dpr_system.parkcode_names_district as t1
left join dpr_system.parkcode_names_district as t2 on t1.park_code=t2.park_code
where 1 
group by t1.park_code
order by t1.park_code";

// $sql="SELECT t1.currPark as location_code , t2.park_name
// from divper.emplist as t1
// left join dpr_system.parkcode_names_district as t2 on t1.currPark=t2.park_code
// where 1 
// group by t1.currPark
// order by t1.currPark";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	if($row['location_code']==""){continue;}
	if($row['location_code']=="WOED"){continue;}
	$location_code_location_name[$row['location_code']]=$row['park_name'];
	}
// echo "<pre>"; print_r($ARRAY_location_code); echo "</pre>";
$employee_status_array=array("permanent","seasonal","nondpr","other");

//echo "<pre>"; print_r($parkcode_parkname); echo "</pre>";  exit;
$num_parks=count($location_code_location_name);
// ******************* Form ********************

if(!empty($id) or !empty($location_code))
	{
	if(!empty($id))
		{$where="id='$id'";}
		else
		{$where="location_code='$location_code'";}
	$sql="SELECT * from track_time where $where";
	$result = mysqli_query($connection,$sql);

	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;


echo "<table><tr valign='top'><td><b>DPR Ticket Tracking - Logging</b></td></tr>";
echo "<tr valign='top'>
<td>
</tr>";
echo "<tr valign='top'><td> </td></tr>";

if(empty($pass_ticket_id)) // location_code dropdown
	{
	echo "<tr valign='top'><td><form><b>Select a Location: </b>
	<select name='location_code' onchange=\"this.form.submit()\"><option value='' selected></option>\n";
	foreach($location_code_location_name as $k=>$v)
		{
		if(@$location_code==$k){$s="selected";}else{$s="";}
		echo "<option value='$k' $s>$v</option>\n";
		}
	echo "</select></form></td>";
	
if(empty($location_code))
	{
	exit;
	}
	if(!empty($location_code))
		{
		$pc=strtolower($location_code)."_search.jpg";
		$img="https://files.nc.gov/ncparks/park-dot-maps/cliffs-neuse-nc-map.png";
		echo "<td><img src='$img'></td>";
		}

	if(empty($location_code))
		{
		echo "</tr>";
		$location_code="";
		}
$sql="SELECT t1.parkcode as location_code, t2.park_name, t1.ophone, phone1, phone2
FROM dprunit_district as t1
left join parkcode_names_district as t2 on t1.parkcode=t2.park_code
where t1.parkcode='$location_code'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$park_contact[$row['location_code']]=$row;
	}

$contact=array();
$where="t3.park='$location_code'";
if($location_code=="ARCH")
	{$where="(t3.park='$location_code' or t3.park='PRTF')";}
$sql="SELECT t1.Fname, t1.Lname, t3.working_title, t2.tempID
FROM divper.empinfo as t1
left join divper.emplist as t2 on t1.emid=t2.emid
left join divper.position as t3 on t3.beacon_num=t2.beacon_num
where $where
order by t1.Lname";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$perm_contact[$row['tempID']]=$row['Fname']." ".$row['Lname'].", ".$row['working_title'];
	}
$sql="SELECT t1.Fname, t1.Lname, t1.tempID
FROM divper.nondpr as t1
where t1.currPark='$location_code'
order by t1.Lname";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$seasonal_contact=array();
while($row=mysqli_fetch_assoc($result))
	{
	$seasonal_contact[$row['tempID']]=$row['Fname']." ".$row['Lname'];
	}
	

echo "<td>";
if(!empty($park_contact))
	{
	foreach($park_contact[$location_code] as $k=>$v)
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
		$k="<a href='track_time.php?employee_status=permanent&location_code=$location_code&client=$k'>$k</a>";
		echo "$k ==> $v<br />";	
		}
	}
	else
	{echo "No Permanent Staff in the system for $location_code.";}
echo "</div>&nbsp;&nbsp;&nbsp;</td>";

echo "<td>
<a onclick=\"toggleDisplay('seasonal');\" href=\"javascript:void('')\">Seasonal Staff</a>
<div id=\"seasonal\" style=\"display: none\">";
if(!empty($seasonal_contact))
	{
	foreach($seasonal_contact as $k=>$v)
		{
		$k="<a href='track_time.php?employee_status=seasonal&location_code=$location_code&client=$k'>$k</a>";
		echo "$k ==> $v<br />";	
		}
	}
	else
	{echo "No Seasonal Staff in the system for $location_code.";}
echo "</div>&nbsp;&nbsp;&nbsp;</td>";
echo "<td><div>";
echo "<a href='track_time.php?employee_status=nondpr&location_code=$location_code&client='>nondpr</a>";
echo "</div></td>";

echo "</tr></table>";

	}

// ************************************************
if(!empty($pass_ticket_id))
	{
	$sql="SELECT time_in_hours, notes, user_id, date_update 
	from track_time_updates
	 where ticket_id='$pass_ticket_id' order by date_update desc";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_notes_update[]=$row;
		}
// 	echo "$sql <pre>"; print_r($ARRAY_notes_update); echo "</pre>";
	$skip_search=array("submit_form");
	$array_t2=array("t2.update_id","t2.time_in_hours","t2.user_id","t2.date_update");
	$t2_flds=implode(",",$array_t2);

	$sql="SELECT t1.*, $t2_flds, group_concat(distinct t3.link) as link, group_concat(distinct t3.file_name) as file_name
	from track_time as t1
	left join track_time_updates as t2 on t1.ticket_id=t2.ticket_id
	left join track_time_uploads as t3 on t1.ticket_id=t3.ticket_id
	 where t1.ticket_id='$pass_ticket_id'
	 group by t1.ticket_id";
// 	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		}
	$time_in_hours="";
	}

$skip=array();
$readonly=array("ticket_id","date_create","date_update","location_code");
if(!empty($pass_ticket_id))
	{
	$readonly[]="client";
	$readonly[]="database_app";
	$readonly[]="sub_application";
	}
$drop_down_array=array("activity", "employee_status");
$radio_array=array("ticket_status","resolution");
echo "<form method='POST' action='track_time.php' enctype='multipart/form-data'>";
echo "<table>";
foreach($ARRAY_flds AS $num=>$fld)
	{
	if(in_array($fld, $skip)){continue;}
	if($fld=="date_create"){${$fld}=date("Y-m-d");}
	if($fld=="date_update"){${$fld}=date("Y-m-d H:i:s");}
	if(empty(${$fld})){${$fld}="";}
	if(in_array($fld, $readonly)){$ro="readonly";}else{$ro="";}
	
	if($fld!="link") // link handles separately
		{
		$input_type="<input id='$fld' type='text' name='$fld' value=\"".${$fld}."\" $ro>";
		}
	
	if($fld=="notes")
		{

		$input_type="<textarea name='$fld' cols='100' rows='10'></textarea>";
		if(!empty($ARRAY_notes_update))
			{
			$input_type.="<a onclick=\"toggleDisplay('systemalert');\" href=\"javascript:void('')\"> Previous Notes:</a>
<div id=\"systemalert\" style=\"display: none\"><table border='1' cellpadding='3'>";
			foreach($ARRAY_notes_update as $index=>$array)
				{
				$user_id=$array['user_id'];
				$db_supprt_email=array("Bass3"=>"tony.p.bass@ncparks.gov","Carter5"=>"john.carter@ncparks.gov","Cooper8"=>"cathy.cooper@ncparks.gov","Howard6"=>"tom.howard@ncparks.gov");
				$subject="Ticket #$pass_ticket_id Location: $location_code Client: $client DB: $database_app";
				$body="https%3A%2F%2F10.35.152.9%2Ftrack_time.php?pass_ticket_id=419";
				$body="https%3A%2F%2F10.35.152.9%2Ftrack_time.php?pass_ticket_id=419";
				$email_user_id="<a href='mailto:$db_supprt_email[$user_id]?subject=$subject&body=$body'>$user_id</a>";
				$array['user_id']=str_replace($user_id, $user_id."_test", $array['user_id']);
		$array['notes']=nl2br($array['notes']);
				$input_type.="<tr><td>$array[notes] $array[date_update] $email_user_id </td></tr>";
				}		
			$input_type.="</table></div>";
			}
		}
	if(in_array($fld, $drop_down_array))
		{
		$val=${$fld};
		$show_array=${$fld."_array"};
		$input_type="<select name='$fld'><option value></option>\n";
		foreach($show_array as $k=>$v)
			{
			if($val==$v){$s="selected";}else{$s="";}
			$input_type.="<option value='$v' $s>$v</option>\n";
			}
		$input_type.="</select>";
		}
	if(in_array($fld, $radio_array))
		{
		$val=${$fld};

		$show_array=${$fld."_array"};
		$input_type="";
		if($fld=="ticket_status" and empty($val)){$val="active";}
		if($fld=="resolution" and empty($val)){$val="on-going";}
		foreach($show_array as $k=>$v)
			{
			if($v==$val){$ck="checked";}else{$ck="";}
			$input_type.="<input type='radio' name='$fld' value=\"$v\" $ck>$v ";
			}
		}
	 
	if($fld=="link")
		{
		if(!empty(${$fld}))
			{
			$var1=${$fld};
			$var2=${"file_name"};
			$exp1=explode(",", $var1);
			$exp2=explode(",", $var2);
			$var="";
			foreach($exp1 as $k=>$v)
				{
				$var.="<br /><a href='$v' target='_blank'>$exp2[$k]</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='track_time.php?link=$v&act=Delete' onclick=\"return confirm('Are you sure you want to delete?')\">Delete</a><br />";
				}
			}
			else
			{$var="";}
		$input_type=$var;
		}
		
	if($fld=="user_id")
		{
		$user_id=substr($_SESSION['dpr_system']['tempID'], 0, -3);
		$input_type="<input id='$fld' type='text' name='$fld' value=\"".$user_id."\" readonly>";
		}
	echo "<tr>
	<td>$fld</td>
	<td>$input_type</td>
	</tr>";
	}
if(empty($pass_ticket_id))
	{
	$submit_value="Add";
	$ck="checked";
	}
	else
	{
	$submit_value="Update";
	$ck="";
	}
echo "<tr><td><input type='file' name='file_upload'  size='20'></td></tr>";

	echo "<tr><td></td><td><input type='checkbox' name='send_email'  value='yes'>Send email to database.support</td></tr>";
echo "<tr><td colspan='3' align='center'><input type='submit' name='submit_form' value=\"$submit_value\"></td></tr>";
echo "</table></form>";
echo "</body></html>";

echo "
	<script>
		$(function()
			{
			$( \"#database_app\" ).autocomplete({
			source: [ $source_db ]
				});
			});
		</script>";
mysqli_close($connection);
?>