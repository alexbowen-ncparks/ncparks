<html><head>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker5" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker6" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker7" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker8" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<script type="text/javascript">	
function toggleDisplay(objectID)
	{
		var object = document.getElementById(objectID);
		state = object.style.display;
		if (state == 'none')
			object.style.display = 'block';
		else if (state != 'none')
			object.style.display = 'none'; 
	}
function confirmLink()
		{
		 bConfirm=confirm('Are you sure you want to delete this item?')
		 return (bConfirm);
		}

function confirmFile()
		{
		 bConfirm=confirm('Are you sure you want to delete this file?')
		 return (bConfirm);
		}
function open_win(url)
{
window.open(url)
}

function popitLatLon(url)
{   newwindow=window.open(url);
        if (window.focus) {newwindow.focus()}
        return false;
}
function popitup(url)
	{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1');
			if (window.focus) {newwindow.focus()}
			return false;
	}

function validateForm()
	{
	var x1=document.forms["pr63_form"]["date_occur"].value;
	if (x1==null || x1=="")
		  {
		  alert("INCIDENT DATE must be filled out.");
		  return false;
		  }
	var x2 = document.getElementById('loc_code');
	if (x2.selectedIndex == 0)
		  {
		  alert("LOCATION CODE must be filled out.");
		  return false;
		  }
	var x3=document.forms["pr63_form"]["report_by"].value;
	if (x3==null || x3=="")
		  {
		  alert("REPORTED BY must be filled out.");
		  return false;
		  }
	var x4=document.forms["pr63_form"]["incident_code"].value;
	if (x4==null || x4=="")
		  {
		  alert("INCIDENT CODE must be filled out.");
		  return false;
		  }
	var x5=document.forms["pr63_form"]["investigate_by"].value;
	if (x5==null || x5=="")
		  {
		  alert("COMPLETED BY must be filled out.");
		  return false;
		  }
	var x6 = document.getElementById('dpr_disp');
	if (x6.selectedIndex == 0)
		  {
		  alert("DPR DISPOSITION must be filled out.");
		  return false;
		  }
	
	}


function MM_jumpMenu(targ,selObj,restore)
	{ //v3.0
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
	}

</script>
</head>
<title>NC DPR Incident / Action Database</title>
<?php

// Used to develop a new version designed for Public Info requests


ini_set('display_errors',1);
session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
//extract($_REQUEST);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
@$level=$_SESSION['le']['level'];
if($level<1)
	{
	echo "To view a PR-63 you must be logged into the PR-63 / DCI / CITE database - <a href='https://10.35.152.9/le/index.html'>login</a>.";
	echo "To view a PR-63 you must be logged into the PR-63 / DCI / CITE database - <a href='https://10.35.152.9/le/index.html'>login</a>.";
	exit;
	}
$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];
@$beacon_title=$_SESSION['le']['beacon_title'];
@$at_park=$_SESSION['le']['select'];

$database="le";
include("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,"divper");


// if($tempID=="Newsome1830") 
// 	{$_SESSION['le']['accessPark']="MEMO";}   // SEE line 360

// The actual PASU position must be VACANT for this to work.
// If it's not use next method
// if($tempID=="Anundson9926") // MOMO PARA acting as PASU 20160121
// {$_SESSION['le']['accessPark']="MOMO";}   // SEE line 365

// Use when both PARA and PASU still working
// if($tempID=="Cooke2603") // CRMO PARA acting as PASU 20160121
// 	{
// 	$_SESSION['le']['accessPark']="CRMO";
// 	$replace_PASU=$tempID;
// 	}   // SEE line 352 


if($tempID=="Matheson2236") // MOJE PARA acting as PASU at GRMO
	{
	$_SESSION['le']['accessPark']="GRMO";
	$replace_PASU=$tempID;
	$sql="SELECT t3.Fname, t3.Mname, t3.Lname, t3.tempID
	FROM divper.position as t1
	LEFT JOIN divper.emplist as t2 on t2.beacon_num=t1.beacon_num
	LEFT JOIN divper.empinfo as t3 on t2.emid=t3.emid
	LEFT JOIN le.acting_pasu as t4 on t4.acting_tempID=t2.tempID
	where (t3.tempID='$tempID')
	order by t1.o_chart
	"; //echo "$sql";
	$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	$pasu_array[]=$row['Fname']." ".$row['Mname']." ".$row['Lname'];
	}   // SEE line 352 

//$exp=explode(",",$_SESSION['le']['accessPark']);

if(@$_POST['id']!=""){$_GET['id']=$_POST['id'];}

// get RESU
// position_reg instead of position
$posTitle="Parks District Superintendent";
$new_regions=array("EADI"=>"CORE","SODI"=>"PIRE","WEDI"=>"MORE"); // not neededi if using position_reg
$sql="SELECT t3.Fname, t3.Mname, t3.Lname, t1.program_code as park, t3.email
FROM position as t1
LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN empinfo as t3 on t2.emid=t3.emid
where t1.posTitle = '$posTitle' and t3.tempID is not NULL
order by t3.Lname, t3.Fname
"; 
// echo "$sql";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
// 		if(array_key_exists($row['park'],$new_regions)){$row['park']=$new_regions[$row['park']];}
		$disu_array[$row['park']]=$row['Fname']." ".$row['Mname']." ".$row['Lname']."*".$row['email'];
// 		$resu_array[$row['park']]=$row['Fname']." ".$row['Mname']." ".$row['Lname']."*".$row['email'];
		}
// echo "<pre>"; print_r($resu_array); echo "</pre>"; // exit;

// populate array for js
$sql="SELECT t3.Fname, t3.Lname, t3.Mname, t3.badge
FROM position as t1
LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN empinfo as t3 on t2.emid=t3.emid
where  t3.tempID is not NULL
order by t3.Lname, t3.Fname
"; //echo "$sql";

//t1.beacon_title like 'Law Enforcement%' and
$result = @mysqli_QUERY($connection,$sql);
$source="";
while($row=mysqli_fetch_assoc($result))
		{
		$ac_name=$row['Lname'].", ".$row['Fname']." ".$row['Mname'];
		if(!empty($row['badge'])){$ac_name.="*".$row['badge'];}
		$source.="\"".$ac_name."\",";
		}
	$source=rtrim($source,",");
 //   echo "source: [ ".$source. "]";

$database="le";
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
$limit_park="";

@$pass_park=$_SESSION['le']['select'];
$level=$_SESSION['le']['level'];

if(!empty($_POST['delete']))
	{
	if($_POST['delete']=="del")
		{
		$id=$_POST['id'];
		$sql="DELETE FROM pr63_pio WHERE id='$id'"; echo "Contact Tom Howard and send this<br /> $sql";  exit;
	//	 $result = @mysqli_QUERY($connection,$sql); 
		}
		header("Location: find_pr63_pio.php?submit=Go");
		exit;
	}

$sql="SHOW COLUMNS FROM pr63_pio";
 $result = @mysqli_QUERY($connection,$sql); 
while($row=mysqli_fetch_assoc($result))
		{
		$allFields[]=$row['Field'];
		}

// ********** Filter row ************
if(@$_GET['id']){$display="none";}else{$display="block";}

date_default_timezone_set('America/New_York');

echo "<body bgcolor='beige'>";

echo "<div align='center'>";
echo "<table align='center'><tr><th colspan='3'>
<h3><font color='purple'>North Carolina State Parks Case Incident / Investigation Report</font></h3></th></tr><tr>
<th>
<a href='pr63_home.php'>PR-63 / DCI Home Page</a></th>
<th>&nbsp;&nbsp;&nbsp;</th>";

if(strpos($beacon_title,"Law")>-1)
	{
	echo "<th>
	<a href='start_le.php'>NC DPR Incident / Action Reports Home Page</a></th>
	";
	}


if(empty($_POST['parkcode']) AND empty($_GET['id']))
	{
	echo "<form method='POST'><table align='center'>";
	
	include("../../include/get_parkcodes_dist.php");
	array_unshift($parkCode,"ARCH");
	array_push($parkCode,"YORK");

	echo "</tr><tr><td>Select the Park: ";
	echo "<select name='parkcode'><option></option>";
	foreach($parkCode as $k=>$v)
		{
		if($pass_park==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
		}
	echo "</select></td>
	<td><input type='submit' name='submit' value='Submit'></td></tr></table></form>";
	exit;
	}
	
	

$rename_fields=array("ci_num"=>"Case Incident Number/OCA","parkcode"=>"Park Code","location_code"=>"Location Code","loc_name"=>"Location of Incident","date_occur"=>"When did it occur?","time_occur"=>"24 hr. Time","day_week"=>"Day of Week <font size='2'>auto-complete</font>","incident_code"=>"Incident Code","incident_name"=>"Nature of Incident <font size='2'>auto-complete</font>","report_how"=>"How Reported","report_by"=>"Reported by","report_address"=>"Address","report_phone"=>"Phone number of person making report","report_phone_type"=>"Type of phone Home, Cell, Work","report_receive"=>"Received by","report_receive_date"=>"Received date","report_investigate_date"=>"Investigated date","report_investigate_time"=>"Investigated time","weather"=>"Weather","investigate_by"=>"Completed by<br />(<font size='-2'>type first 3 letters of Last Name, if Badge Number is missing update your contact info.</font>","clear_date"=>"Date Cleared","clear_time"=>"Time Cleared","disposition"=>"Disposition","details"=>"<font color='brown'>Details of Incident: </font>","dist_approve"=>"District Approved","le_approve"=>"LE Reviewed","pasu_approve"=>"PASU Approved","nature_of_incident"=>"PIO Details of Incident","of_arrest"=>"PIO Details of Arrest");

$resize_fields=array("ci_num"=>"10","parkcode"=>"5","loc_name"=>"50","time_occur"=>"8","day_week"=>"8","incident_code"=>"Incident Code","incident_name"=>"55","report_how"=>"35","report_by"=>"35","report_address"=>"50","report_phone_h"=>"15","report_phone_w"=>"15","report_receive"=>"35","report_investigate_time"=>"8","weather"=>"45","investigate_by"=>"40","clear_time"=>"8","disposition"=>"Disposition");

$readonly=array("ci_num","loc_name","parkcode","incident_name","day_week");
$radio=array("report_phone_type");
$report_phone_type_array=array("H"=>"H","C"=>"C","W"=>"W");

if(!empty($_GET['id']))
	{
	$excludeFields=array("id");
	if($level<3)
		{
		$readonly[]="le_approve";
			if($level<2)
				{$readonly[]="dist_approve";}
		}
	}
	else
	{
	$ci_num="auto-generated";
	$day_week="auto-generated";
	$loc_name="Locaton set by Location Code.";
	$incident_name="Incident set by Incident Code.";
	$details="";
	$excludeFields=array("id");
	if($level<3)
		{
		$excludeFields[]="le_approve";
			if($level<2)
				{$excludeFields[]="dist_approve";}
		}
	}

// match js function at top of page for datepicker?
$date_array=array("date_occur"=>1,"report_receive_date"=>2,"report_investigate_date"=>3,"clear_date"=>4);

$var_level=$level;
if($level==3)
	{
	if(!empty($position_array))
		{
		if(in_array($beacon_num,$position_array)){$var_level=3.2;}else{$var_level=3.1;}
		}
	
	}

$textarea=array("details");

// extract($_REQUEST);

	@$sql="SELECT * FROM pr63_pio where id='$id' $limit_park";
 	$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
 		if(mysqli_num_rows($result)>0)
 			{
			$menu_array=array("parkcode","location_code","incident_code","investigate_by");
			$row=mysqli_fetch_assoc($result); 
		extract($row);
			$dow=date("l",strtotime($date_occur));
			echo "<td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;<form><select name='field'  onChange=\"MM_jumpMenu('parent',this,0)\">><option value=''>Find All for:</option>";
				foreach($menu_array as $k=>$v)
					{
					$val=${$v};
					echo "<option value='find_pr63_pio.php?$v=$val'>$v</option>\n";
					}
				
				echo "</select></form></td>";
				
				echo "</tr></table>";
			}

mysqli_select_db($connection,"divper");
// get PASU for PR-63 park
$pass_parkcode=@$_SESSION['le']['pass_parkcode'];
$pasu_park=$parkcode;
if($pasu_park=="MOJE"){$pasu_park="NERI";}
if($pasu_park=="YEMO"){$pasu_park="GRMO";}
if($pasu_park=="BEPA"){$pasu_park="GRMO";}
//if($pasu_park=="MOMO"){$pasu_park="LANO";}

$sql="SELECT t3.Fname, t3.Mname, t3.Lname, t3.tempID
FROM divper.position as t1
LEFT JOIN divper.emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN divper.empinfo as t3 on t2.emid=t3.emid
LEFT JOIN le.acting_pasu as t4 on t4.acting_tempID=t2.tempID
where (t1.posTitle = 'Park Superintendent' or t4.park_code='$pasu_park') and t3.tempID is not NULL
and park='$pasu_park'
order by t1.o_chart
"; 
//echo "$sql";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$pasu_tempID[]=$row['tempID'];  // increase rank for PARA acting as PASU line 125 & 348
		$pasu_array[]=$row['Fname']." ".$row['Mname']." ".$row['Lname'];
		}
if(!empty($pasu_array))
	{
	foreach($pasu_array as $k_p=>$v_p)
		{
		@$pass_pasu_name.=$v_p." ";
		}
	}
	else
	{
	$pass_pasu_name="";
	}
if(!empty($replace_PASU))
	{
//	$pasu_tempID="";
	$pasu_tempID[]=$replace_PASU;
// 	$pasu_array[]="Kelly E Cooke";	
	}
// echo "<pre>"; print_r($replace_PASU); echo "</pre>"; // exit;
// echo "<pre>"; print_r($pasu_tempID); echo "</pre>"; // exit;
//echo "<pre>"; print_r($pasu_array); echo "</pre>"; // exit;
if(empty($pasu_tempID))  // line 347
	{
	if(!empty($_SESSION['le']['accessPark']))
		{
		$exp=explode(",",$_SESSION['le']['accessPark']);
		if(in_array($_SESSION['parkS'], $exp))
			{
			$beacon=$_SESSION['beacon_num'];
			$sql="SELECT tempID as temp
			FROM divper.emplist
			where 1 and beacon_num='$beacon'
			";
			$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
			$row=mysqli_fetch_assoc($result); extract($row); 
// 			echo "t=$tempID";
			$pasu_tempID=array($temp);
			$sql="SELECT t3.Fname, t3.Mname, t3.Lname
			FROM divper.empinfo as t3
			where t3.tempID='$temp'";
			$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
			$row=mysqli_fetch_assoc($result);
			$pasu_array[]=$row['Fname']." ".$row['Mname']." ".$row['Lname'];	
			}
		
		}
	}
	
mysqli_select_db($connection,$database);

	$sql="SELECT loc_code,location
		FROM cite.location
		where 1 and parkcode='$parkcode'
		order by loc_code
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		while($row=mysqli_fetch_assoc($result))
					{$location_array[$row['loc_code']]=$row['location'];}
	
	$sql="SELECT *
		FROM le.incident
		where 1 
		order by incident_code
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		while($row=mysqli_fetch_assoc($result))
			{
			$incident_array[$row['incident_code']]=$row['incident_desc'];
			if($row['incident_code']>"300000" and $row['incident_code']<=300500)
				{
				$use_of_force_array[]=$row['incident_code'];
				}
			}

	$sql="SELECT *
		FROM le.disposition
		where 1 
		order by disposition_code
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		while($row=mysqli_fetch_assoc($result))
					{
			//		if($level<4 and $row['disposition_desc']=="VOID"){continue;}
					$disposition_array[$row['disposition_code']]=$row['disposition_desc'];
					}

	$sql="SELECT *
		FROM le.weather
		where 1 
		order by id
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		while($row=mysqli_fetch_assoc($result))
					{$weather_array[$row['weather_desc']]=$row['weather_desc'];}

	$sql="SELECT parkcode, latoff, lonoff
		FROM dpr_system.dprunit_district
		where 1 
		order by parkcode
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		while($row=mysqli_fetch_assoc($result))
					{$lat_lon_array[$row['parkcode']]=$row;}

	$sql="SELECT *
		FROM le.narcan
		where 1 
		order by id
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		while($row=mysqli_fetch_assoc($result))
					{$narcan_array[]=$row['narcan_agency'];}

//echo "<pre>"; print_r($row); echo "</pre>"; // exit;
$hour_array=range(0,23);
$minute_array=range(0,59);


// ************************************ Start Form ************************************
echo "<form action='pr63_action_pio.php' name='pr63_form' method='POST' enctype='multipart/form-data' onsubmit=\"return validateForm()\">";
echo "<table border='1' cellpadding='3' align='left'>
<tr><td><font color='red'><b><i>Nothing is saved until you click either the Submit or Update button at bottom of screen.</i></b></font> Items in <font color='green'>green</font> are required.</td></tr>";

if(empty($location_array))
	{
	echo "<tr><td><font color='magenta'><b><i>No location codes assigned for $pass_park.</i></b></font> Contact Bryan Dowdy or Phil King.</td></tr>";
	$location_array=array();
	}

echo "<tr><td><table>";
$size="35";


// Row 1

if(!isset($disposition)){$disposition="";}
$v1="Case Incident Number/OCA<br /><input type='text' name='ci_num' value=\"$ci_num\" size='11' READONLY>";
if($disposition=="09"){$v1.=" <font color='red'><h2>VOID</h2></font>";}

if(!empty($call_out)){$ck="checked";}else{$ck="";}
$v4="Check if this was a Call Out<br /><input type='checkbox' name='call_out' value='' $ck>";
$v2="Park Code<br /><input type='text' name='parkcode' value=\"$parkcode\" size='4' READONLY>";
$v3="<font color='green'><b>LOCATION CODE</b></font><br /><select id='loc_code' name='location_code'><option value=''></option>";
	foreach($location_array as $lc=>$loc)
		{
		if($lc==@$location_code){$s="selected";}else{$s="value";}
		$v3.="<option $s='$lc - $loc'>$lc - $loc</option>";
		}
$v3.="</select>";


echo "<tr><td>$v1</td><td>$v4</td><td>$v2</td><td>$v3</td></tr>";

// Row 2
$date_field="datepicker1";
if(!isset($date_occur)){$date_occur="";}
$v1="<font color='green'><b>INCIDENT DATE</b></font><br /><input id='$date_field' type='text' name='date_occur' value=\"$date_occur\" size='12'>";

if(!isset($time_occur)){$time_occur="";}
$value_hr=substr($time_occur,0,2);
	$v_hr="Hour:<select name='occur_hr'><option value=''></option>";
		foreach($hour_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_hr){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v_hr.=" Minute:<select name='occur_min'><option value=''></option>";
	$value_min=substr($time_occur,2,2);				
		foreach($minute_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_min){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v2="Occurred @<br />".$v_hr;

if(!isset($dow)){$dow="";}
$v3="Day of Week <font size='-2'>(auto-completed)</font><br /><input type='text' name='day_week' value=\"$dow\" size='10' READONLY>";
	
//$v4="How Reported<br /><input type='text' name='report_how' value=\"$report_how\" size='24'>";
$v4="";

// if($level>3)
// 	{
// 	echo "<pre>"; print_r($lat_lon_array['CHRO']); echo "</pre>"; // exit;
	extract($lat_lon_array[$parkcode]);
	if(empty($lat))
		{
		$lat=$latoff;
		$var_lat="";
		}
		else
		{
		$var_lat=$lat;
		}
	if(empty($lon))
		{
		$lon=$lonoff;
		$var_lon="";
		}
		else
		{
		$var_lon=$lon;
		}
// 	$v4.="(required for Incident Code beginning with 260 [SAR])<br />Latitude:<input type='text' name='lat' value=\"$var_lat\" size='10'>";
	$v4.="Map this incident: <br />Latitude:<input type='text' name='lat' value=\"$var_lat\" size='10'>";
	$v4.=" Longitude:<input type='text' name='lon' value=\"$var_lon\" size='10'>";
	$v4.="<input type='button' value='Map It!' onclick=\"return popitLatLon('lat_long.php?park=$parkcode&lat=$lat&lon=$lon')\">";	
// 	}
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td>";
echo "</tr>";
$v4="";
// Row 3
if(!isset($incident_code)){$incident_code="";}
$v1="<font color='green'><b>INCIDENT CODE</b></font><br /><input type='text' name='incident_code' value='$incident_code' size='8' readonly><input type=\"button\" value=\"List of Incident Codes\" onClick=\"return popitup('incident.php')\">";

$v2="Nature of Incident (auto-completed)<br /><input type='text' name='incident_name' value=\"$incident_name\" size='55' READONLY>";
$v3="";
if(empty($narcan)){$narcan="";}
	$v3="Use of NALOXONE / NARCAN<br />";
	$v3.="<select name='narcan'><option value=''></option>";
		foreach($narcan_array as $x=>$y)
			{
			if($y==$narcan){$s="selected";}else{$s="";}
			$v3.="<option value='$y' $s>$y</option>";
			}
	$v3.="</select>";

$v4="";
// if($level>4)
// 	{
if(empty($use_of_force)){$use_of_force="";}
	$v4="Use of Force (By Commissioned Employee)<br />";
	$v4.="<select name='use_of_force'><option value=''></option>";
		foreach($use_of_force_array as $x=>$y)
			{
			$uof_desc=$incident_array[$y];
			if($y==$use_of_force){$s="selected";}else{$s="";}
			$v4.="<option value='$y' $s>$y - $uof_desc</option>";
			}
	$v4.="</select>";
// 	}	
echo "<tr><td>$v1</td><td colspan='1'>$v2</td><td>$v3</td><td>$v4 <br /><a href='le/Use of Force Report_.docm'>Download</a>, complete, and upload the DPR UoF form if needed.</td></tr>";

// Row 4
if(!isset($report_by)){$report_by="";}
$v1="<font color='green'><b>Reported by</b></font><br /><input type='text' name='report_by' value=\"$report_by\" size='24'>";

if(!isset($report_address)){$report_address="";}
$v2="Their address<br /><input type='text' name='report_address' value=\"$report_address\" size='34'>";
if(!isset($report_phone)){$report_phone="";}
$v3="Phone number of person making report<br /><input type='text' name='report_phone' value=\"$report_phone\" size='24'>";
$v4="";
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";

// Row 5
if(!isset($report_receive)){$report_receive="";}
$v1="Received by<br /><input type='text' name='report_receive' value=\"$report_receive\" size='24'>";
$date_field="datepicker2";
if(!isset($report_receive_date)){$report_receive_date="";}
$v2="Received date<br /><input id='$date_field' type='text' name='report_receive_date' value=\"$report_receive_date\" size='12'>";

if(!isset($report_receive_time)){$report_receive_time="";}
$value_hr=substr($report_receive_time,0,2);
	$v_hr="Hour:<select name='receive_hr'><option value=''></option>";
		foreach($hour_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_hr){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v_hr.=" Minute:<select name='receive_min'><option value=''></option>";
	$value_min=substr($report_receive_time,2,2);				
		foreach($minute_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_min){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v3="Received @<br />".$v_hr;

if(!isset($weather)){$weather="";}
$v4="Weather<br /><select name='weather'><option value=''></option>";
		foreach($weather_array as $wc=>$weather_name)
			{
			if($weather==$weather_name){$s="selected";}else{$s="value";}
			$v4.="<option $s='$weather_name'>$weather_name</option>";
			}
	$v4.="</select>";
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";

// Row 6
if(!isset($investigate_by)){$investigate_by="";}

$v1="<font color='green'><b>Submitted by</b></font><br /><label for=\"investigate_by\"></label>
<input id=\"investigate_by\" name=\"investigate_by\" value=\"$investigate_by\" size='30'>";
?>
<script>
$(function()
	{
	$( "#investigate_by" ).autocomplete({source: [ <?php echo "$source"; ?> ]});
	});
</script>

<?php

$date_field="datepicker3";
if(!isset($report_investigate_date)){$report_investigate_date="";}
$v2="Submitted date<br /><input id='$date_field' type='text' name='report_investigate_date' value=\"$report_investigate_date\" size='12'>";

if(!isset($report_investigate_time)){$report_investigate_time="";}
$value_hr=substr($report_investigate_time,0,2);
	$v_hr="Hour:<select name='investigate_hr'><option value=''></option>";
		foreach($hour_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_hr){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v_hr.=" Minute:<select name='investigate_min'><option value=''></option>";
	$value_min=substr($report_investigate_time,2,2);				
		foreach($minute_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_min){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v3="Submitted @<br />".$v_hr;

$v4="";
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";


// Row 7

$date_field="datepicker4";
if(!isset($clear_date)){$clear_date="";}
$v1="Cleared date<br /><input id='$date_field' type='text' name='clear_date' value=\"$clear_date\" size='12'>";

if(!isset($clear_time)){$clear_time="";}
$value_hr=substr($clear_time,0,2);
	$v_hr="Hour:<select name='clear_hr'><option value=''></option>";
		foreach($hour_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_hr){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v_hr.=" Minute:<select name='clear_min'><option value=''></option>";
	$value_min=substr($clear_time,2,2);				
		foreach($minute_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_min){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v2="Cleared @<br />".$v_hr;

$v3="<font color='green'><b>DPR DISPOSITION</b></font><br /><select id='dpr_disp' name='disposition'><option value=''></option>";
		foreach($disposition_array as $dc=>$dc_name)
			{
			if($dc==$disposition){$s="selected";}else{$s="value";}
			$v3.="<option $s='$dc - $dc_name'>$dc - $dc_name</option>";
			}
	$v3.="</select>";

$test_array=array("60032871","60033035","60033032");
$v4="";
$temp_level=$level;  //$s=$_SESSION['position']; echo "s=$s";
if(strpos($_SESSION['position'],"Office Assistant")>-1)
	{
	$temp_level=4;
	}
if($temp_level>3 or in_array($beacon_num,$test_array))
	{
	$passYear=date('Y');
	if(!isset($id)){$id="";}
	$v4="<input type=\"button\" value=\"Add to Safety Inspection database\" onclick=\"open_win('https://10.35.152.9/inspect/inspection_record.php?parkcode=$parkcode&passYear=$passYear&v_pr63=$ci_num&ti=$tempID&date_occur=$date_occur&pr_id=$id')\">";
	$v4="<input type=\"button\" value=\"Add to Safety Inspection database\" onclick=\"open_win('https://10.35.152.9/inspect/inspection_record.php?parkcode=$parkcode&passYear=$passYear&v_pr63=$ci_num&ti=$tempID&date_occur=$date_occur&pr_id=$id')\">";
	}
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td valign='bottom'>$v4</td></tr>";

// Row 
if($ci_num!="auto-generated")
	{
	$v1="";$v2="";$v3="";$v4="";
	
	
	$v1="PASU Approval<br />";
	
// if a ranger needs to be acting as a PASU, put them in table  le.acting_pasu

// echo "d=$dist_approve<pre>"; print_r($pasu_tempID); print_r($pasu_array); echo "</pre>$pasu_approve"; // exit;
	if(@in_array($_SESSION['le']['tempID'],$pasu_tempID) OR $level>1)
		{
		if(empty($dist_approve))
			{
//$v1="PASU Approval<br />";
			$exp=explode("*",$pasu_approve);
			foreach($exp as $k_exp=>$v_exp)
				{
				$val=explode("=",$v_exp);
				$pasu_approve_value[$val[0]]=@$val[1];
				}
			$date_picker=5;
			foreach($pasu_array as $k_pasu=>$pasu_value)
				{
				$date_id="datepicker".$date_picker;
				$pasu_id=$pasu_tempID[$k_pasu];
				@$v1.="<input id='$date_id' type='text' name='pasu_approve[$pasu_id]' value='$pasu_approve_value[$pasu_id]' size='12'> $pasu_value<br />";
				$date_picker++;
				
				}
			}
			else
			{
			$exp=explode("=",@$pasu_approve);
			$v1.="$pass_pasu_name<br />".@$exp[1];
			}
		}
		else
		{$v1.=$pass_pasu_name;}

$this_district=@$district[$parkcode]; // from get_parkcodes_dist.php above
// $this_region=@$region[$parkcode]; // from get_parkcodes_reg.php above
$disu=explode("*",@$disu_array[$this_district]);
// $resu=explode("*",@$resu_array[$this_region]);
// echo "<pre>"; print_r($resu); echo "</pre>"; // exit;
$pass_disu_name=$disu[0];
if($pass_disu_name=="John R Fullwood")
	{
	$pass_disu_name="Sarah Kendrick";
	}

// 	$pass_resu_name=$resu[0];
// 	$dist_reg="Region";
	$dist_reg="District";

if(empty($pasu_approve))
	{
// $dist_reg="Region";
$dist_reg="District";
// $pass_resu_name=$resu[0];
$pass_disu_name=$disu[0];
	
	}
	
	if($level==1)
		{
		$v2=$dist_reg." Approval<br />$pass_disu_name<br />$dist_approve";
		if(!empty($le_approve)){$la="Yes";}else{$la="No";}
		$v3="Raleigh Office Reviewed: $la";
		}
	if($level>=2)
		{
		$v2=$dist_reg." Approval<br />$pass_disu_name<br /><input id='datepicker6' type='text' name='dist_approve' value='$dist_approve'>";
		if(!empty($le_approve)){$la="Yes";}else{$la="No";}
		$v3="Raleigh Office Reviewed: $la";
		}
	if($level>2)
		{
		if(!empty($le_approve)){$ck="checked";}else{$ck="";}
		$v3="Raleigh Office Reviewed: <input type='checkbox' name='le_approve' value='' $ck>";
		}
		
	echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";
	}
echo "</table>";
	
//  ************** end form
		
			
// Involved Persons
@$sql="SELECT * FROM involved_person_pio where ci_id='$id'"; //echo "$sql";  //exit;
 $result = @mysqli_QUERY($connection,$sql);
 $person_num=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result))
		{$var_persons[$row['row_num']]=$row;}

//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
$server=$_SERVER['HTTP_USER_AGENT'];
		$rows=10;
		$cols=85;
IF(strpos($server,"AppleWebKit/")>0){$cols=85;}//   for Safari and Chrome
IF(strpos($server,"Gecko/")>0){$cols=110;}
IF(strpos($server,"Windows;")>0){$cols=114;}

				

if(@$var_persons[0]['Name']!=""){$block="block";}else{$block="none";}					
echo "<table><tr><td><font color='brown'>Involved Persons:</font> <a onclick=\"toggleDisplay('persons');\" href=\"javascript:void('')\">    show/hide</a> table</td></tr></table><div id=\"persons\" style=\"display: $block\">";

$race_array=array("White"=>"01","Black"=>"02","Hispanic"=>"03","American Indian/Alaska Native"=>"04","Asian/Pacific Islander"=>"05","Other"=>"06",);
$sex_array=array("Female"=>"F","Male"=>"M",);
      echo "<table align='center' border='1' cellpadding='3'>";
      $involved_array=array("26"=>"Name","40"=>"Address","25"=>"Phone","33"=>"Sex","34"=>"Race","12"=>"DOB","2"=>"Age");
      echo "<tr>";
      foreach($involved_array as $k=>$v)
      	{
  //    	if($v=="Age"){continue;}
      	if($v=="DOB"){$v.="<br />yyyy-mm-dd";}
      	echo "<th>$v</th>";
      	}
      	echo "</tr>";
      	
	for($i=0;$i<4;$i++)
		{echo "<tr>";
		 foreach($involved_array as $k=>$v)
			{
    	//	  	if($v=="Age"){continue;}
			$field=$v."[]";
			$value=@$var_persons[$i][$v];
			
			$item="<td><input type='text' name=$field value=\"$value\" size='$k'></td>";
			
			if($v=="Race")
				{
				$item="<td><select name=$field><option value=''></option>";
				foreach($race_array as $k1=>$v1)
					{
					if($value==$v1){$s="selected";}else{$s="value";}
					$item.="<option $s='$v1'>$v1 $k1</option>\n";
					}
				$item.="</select></td>";
				}
			if($v=="Sex")
				{
				$item="<td><select name=$field><option value=''></option>";
				foreach($sex_array as $k1=>$v1)
					{
					if($value==$v1){$s="selected";}else{$s="value";}
					$item.="<option $s='$v1'>$v1 $k1</option>\n";
					}
				$item.="</select></td>";
				}
			echo $item;
			}
		echo "</tr>";
     		}
       echo "</table></div>";

					$v0=$rename_fields['details'];
					$v1="<textarea name='details' rows='$rows' cols='$cols'>$details</textarea>";
	
		if($details!=""){$block="block";}else{$block="none";}
				echo "<hr /><table><tr><td>$v0<a onclick=\"toggleDisplay('detail');\" href=\"javascript:void('')\">show/hide</a><br /><font size='2'>Enter the account (<font color='brown'>up to around 10 rows</font>) here. If the account is longer than about 10 rows,<br />add the account on the INCIDENT DETAILS form as an attachment.</font>
				<tr><td><font size='-1'>Click the link to obtain the official <a href='PR-63_Incident_Details_-_DCI_Narrative_Attachment_Format.docx'>PR-63 INCIDENT DETAILS</a> form.</font></td></tr>
				</table>
				<div id=\"detail\" style=\"display: $block; background-color:#ffdf80\">
				<table align='center'><tr>
				<td colspan='4'>$v1</td></tr>";
		
			echo "</table></div>";

include("staff_upload_forms_pio.php");

if(empty($nature_of_incident)){$nature_of_incident="";}
if(empty($time_pio_incident)){$time_pio_incident="";}
if(empty($time_pio_date)){$time_pio_date="";}
if(empty($time_pio_location)){$time_pio_location="";}
if(empty($text_arrest)){$text_arrest="";}
if(empty($text_resistance)){$text_resistance="";}
if(empty($text_weapon_possession)){$text_weapon_possession="";}


// $date_field="datepicker9";
				echo "<hr>";
echo "<table><tr><td><font size='+1' color='#00cc99'>If an arrest was made</font>, complete items below.</td></tr></table>";

//*************** Arrest ****************
include("arrested_persons_form.php");
			
$action="Submit";
$ck="";
if(!empty($submit_supervisor)){$ck="checked";}
echo "<div><hr /><table><tr><td style='width: 25em'><input type='checkbox' name='submit_supervisor' value='' $ck><font color='brown'><i>Check if PR-63 / DCI is complete<br />and ready for approval by Superintendent</i></font></td><td align='center'>";

$ck_entered_by=$_SESSION['le']['tempID'];
echo "<input type='hidden' name='entered_by' value='$ck_entered_by'>";

$ok="";
$access_array=explode(",",$_SESSION['le']['accessPark']);

//echo "c=$ck_entered_by e=$entered_by";
if(isset($entered_by))
	{
	if($ck_entered_by==$entered_by)
		{$ok=1;}
		else
		{$ok="";}
	}
if($_SESSION['le']['beacon_title']=="Law Enforcement Supervisor" OR in_array($parkcode,$access_array) OR $parkcode==$at_park)
	{$ok=1;}
if($level>1){$ok=1;}

if($level==1 and !empty($dist_approve)){$ok="";}
if($level==2 and !empty($le_approve)){$ok="";}

if(!empty($id) AND $ok==1)
	{
	echo "<input type='hidden' name='pasu_name' value=\"$pass_pasu_name\">";
	echo "<input type='hidden' name='disu_name' value=\"$pass_disu_name\">";
	
	echo "<input type='hidden' name='id' value='$id'>";
	$action="Update";
	}

if($ci_num=="auto-generated"){$ok=1;}
if($ok==1)
	{
	echo "<input type='submit' name='submit' value='$action'>
	</td></tr>";
	}

echo "</table></form>";

echo "<hr /><table><tr style='vertical-align:top'><td>";
if(!empty($id))
	{
	if($tempID=="Howard6319")
		{
		echo "<form action='print_pr63_pio.php' method='POST'>";
		}
		else
		{
		echo "<form action='print_pr63_pio.php' method='POST'>";
		}
	
	$entered_by=substr($entered_by,0,-4);
	echo "<input type='hidden' name='pass_pasu_name' value=\"$pass_pasu_name\">
	<input type='hidden' name='pass_disu_name' value=\"$pass_disu_name\">
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='View / Print'></form>
	<br /> Last Update by: $entered_by</td>
	";
	
	echo "<td><form action='print_pio_1.php' method='POST'><input type='hidden' name='pass_pasu_name' value=\"$pass_pasu_name\">
	<input type='hidden' name='pass_disu_name' value=\"$pass_disu_name\">
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='View / Print PIO'></form></td>";
	if($level>6)
		{
		echo "<td><form action='pr63_form_pio.php' method='POST'>
		<input type='hidden' name='delete' value='del'>
		<input type='hidden' name='id' value='$id'>
		<input type='submit' name='submit' value='Delete' onClick=\"return confirmLink()\"></form></td>";
		}
// 	echo "</tr></table></form>";
	echo "</tr></table>";
	}


// Upload images
if(!empty($id))
	{
$sql="Select id as image_id, parkcode, image_name, link From `le_images_pio` where pr63_id='$id'";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$images[]=$row;
	}
//echo "<pre>"; print_r($images); echo "</pre>"; // exit;
if(isset($images))
	{
	echo "<hr /><table>";
	foreach($images as $k=>$v)
		{
		echo "<tr>";
		foreach($v as $fld=>$value)
			{
			if($fld=="link")
				{
				$im=$images[$k]['image_id'];
				$path_parts=pathinfo($value);
				$tn=$path_parts['dirname']."/ztn.".$path_parts['basename'];
				$tn=str_replace(".pdf",".jpg",$tn);  // if original image was a PDF
				if($ok==1)
					{
					$del="<a href='staff_image_uploads.php?id=$id&del=$im'  onClick='return confirmLink()'>Delete</a> Image";
					if($level==1 AND !empty($dist_approve)){$del="";}
					}
					else{$del="";}

				$value="view full-size <a href='$value' target='_blank'>image</a>&nbsp;&nbsp;&nbsp;<img src='$tn'>&nbsp;&nbsp;&nbsp;$del";
				}
				if($fld=="image_id"){$value="";}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}


	echo "<hr /><form method='post' action='staff_image_uploads_pio.php' enctype='multipart/form-data'>
	<table><tr><td colspan='3'>
		<font color='purple'>Don't try to upload all images at once. Upload them in batches of 2 or 3.</font><br />A 3mb image will take around a half-minute (depending on your internet speed). Uploading 3 images of that size will take at least a minute and a half.</td></tr></table><table>";
	
	$num_images=3;

			for($i=1; $i<=$num_images; $i++)
				{
				echo "<tr><td align='right'>Image $i description:</td>
				<td><textarea name='image_name[]' cols='45' rows='3'></textarea></td>
				<td><input type=file name='file_upload[]'></td>
				</tr>";
				}

// 	if($ok==1)
	if($ok=="x")
		{
		echo "<tr><td colspan=2 align='center'>	
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='hidden' name='form_name' value='images'>
		<input type=submit name='submit' value='Add Image(s)'></td></tr>";
		}
		echo "</table></form>";
	}
else
{
echo "<table><tr><td>After submitting the PR-63 / DCI you will have the opportunity to upload photos.</td></tr></table>";
}

echo "</div></html>";

?>