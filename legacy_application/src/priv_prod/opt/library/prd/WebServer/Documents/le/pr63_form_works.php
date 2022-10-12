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
		 bConfirm=confirm('Are you sure you want to delete this record?')
		 return (bConfirm);
		}

function confirmFile()
		{
		 bConfirm=confirm('Are you sure you want to delete this file?')
		 return (bConfirm);
		}

function popitup(url)
	{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1');
			if (window.focus) {newwindow.focus()}
			return false;
	}
	
function MM_jumpMenu(targ,selObj,restore)
	{ //v3.0
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
	}

</script>
</head>

<?php
ini_set('display_errors',1);
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$level=$_SESSION['le']['level'];
$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];
if($level<1){echo "You do not access to this database.";exit;}

if(@$_POST['id']!=""){$_GET['id']=$_POST['id'];}

include("../../include/connectROOT.inc"); // database connection parameters
include("../../include/get_parkcodes.php");

// populate array for js
mysql_select_db("divper",$connection);
$sql="SELECT t3.Fname, t3.Lname, t3.badge
FROM position as t1
LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN empinfo as t3 on t2.emid=t3.emid
where t1.beacon_title like 'Law Enforcement%' and t3.tempID is not NULL
order by t3.Lname, t3.Fname
"; //echo "$sql";
$result = @MYSQL_QUERY($sql,$connection);
$source="";
while($row=mysql_fetch_assoc($result))
		{
		$ac_name=$row['Lname'].", ".$row['Fname']."*".$row['badge'];
		$source.="\"".$ac_name."\",";
		}
	$source=rtrim($source,",");
 //   echo "source: [ ".$source. "]";

$database="le";
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
       
$limit_park="";

$p=$_SESSION['le']['select'];
$level=$_SESSION['le']['level'];
if($level<2)
	{
	$currPark=$_SESSION['le']['select'];
	$limit_park="and parkcode='$currPark'";
	if(!empty($_SESSION['le']['accessPark']))
		{
		$limit_park="and (";
		$access_array=explode(",",$_SESSION['le']['accessPark']);
		foreach($access_array as $k=>$v)
			{
			$limit_park.="parkcode='".$v."' or ";
			}
		$limit_park=rtrim($limit_park," or ").")";
		}
		else
		{
		$_GET['parkcode']=$currPark;
		$parkcode=$currPark;
		}
	}
		

$sql="SHOW COLUMNS FROM pr63";
 $result = @MYSQL_QUERY($sql,$connection); 
while($row=mysql_fetch_assoc($result))
		{
		$allFields[]=$row['Field'];
		}

// ********** Filter row ************
if(@$_GET['id']){$display="none";}else{$display="block";}

date_default_timezone_set('America/New_York');

echo "<body bgcolor='beige'>";

echo "<table align='center'><tr><th colspan='3'>
<h3><font color='purple'>NC DPR PR-63</font></h3></th></tr><tr><th>
<a href='start.php'>LE Home Page</a></th>
<th>&nbsp;&nbsp;&nbsp;</th>
<th>
<a href='pr63_home.php'>PR-63 Home Page</a></th>
";


if(!@$_GET['parkcode'] AND !@$_GET['id'])
	{
	if($level==1)
		{
		
		}
	echo "<form method='POST'><table align='center'>";
	$sql="SELECT distinct parkcode
	FROM cite.location
	where 1 $limit_park
	group by parkcode";
 	$result = @MYSQL_QUERY($sql,$connection); //ECHO "$sql";
 	while($row=mysql_fetch_assoc($result))
				{$park_array[]=$row['parkcode'];}
	echo "</tr><tr><td>Select the Park: ";
	echo "<select name='parkcode'  onChange=\"MM_jumpMenu('parent',this,0)\"><option></option>";
	foreach($park_array as $k=>$v)
		{
		echo "<option value='pr63_form.php?parkcode=$v'>$v</option>\n";
		}
	echo "</select></td></tr></table></form>";
	exit;
	}
	
	
echo "<div align='center'>";

$rename_fields=array("ci_num"=>"Case Incident Number","parkcode"=>"Park Code","location_code"=>"Location Code","loc_name"=>"Location of Incident","date_occur"=>"When did it occur?","time_occur"=>"24 hr. Time","day_week"=>"Day of Week <font size='2'>auto-complete</font>","incident_code"=>"Incident Code","incident_name"=>"Nature of Incident <font size='2'>auto-complete</font>","report_how"=>"How Reported","report_by"=>"Reported by","report_address"=>"Address","report_phone"=>"Phone number of person making report","report_phone_type"=>"Type of phone Home, Cell, Work","report_receive"=>"Received by","report_receive_date"=>"Received date","report_investigate_date"=>"Investigated date","report_investigate_time"=>"Investigated time","weather"=>"Weather","investigate_by"=>"Investigated by<br />(<font size='-2'>type first 3 letters of Last Name, if Badge Number is missing update your contact info.</font>","badge_num"=>"Badge Number","clear_date"=>"Date Cleared","clear_time"=>"Time Cleared","disposition"=>"Disposition","details"=>"<font color='brown'>Details of Incident: </font><a onclick=\"toggleDisplay('incident');\" href=\"javascript:void('')\">show/hide</a><br /><font size='2'>Enter the account (<font color='brown'>up to around 5 rows</font>) here. If the account is longer than about 5 rows,<br />add the account as a Word document attachment.</font>","dist_approve"=>"District Approved","le_approve"=>"LE Reviewed","pasu_approve"=>"PASU Approved");

$resize_fields=array("ci_num"=>"10","parkcode"=>"5","loc_name"=>"50","time_occur"=>"8","day_week"=>"8","incident_code"=>"Incident Code","incident_name"=>"55","report_how"=>"35","report_by"=>"35","report_address"=>"50","report_phone_h"=>"15","report_phone_w"=>"15","report_receive"=>"35","report_investigate_time"=>"8","weather"=>"45","investigate_by"=>"40","badge_num"=>"5","clear_time"=>"8","disposition"=>"Disposition");

$readonly=array("ci_num","loc_name","parkcode","incident_name","day_week");
$radio=array("report_phone_type");
$report_phone_type_array=array("H"=>"H","C"=>"C","W"=>"W");

if(@$_GET['id'])
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
	if(in_array($beacon_num,$position_array)){$var_level=3.2;}else{$var_level=3.1;}
	}

$textarea=array("details");

extract($_REQUEST);

	@$sql="SELECT * FROM pr63 where id='$id' $limit_park";
 	$result = @MYSQL_QUERY($sql,$connection); //ECHO "$sql";
 		if(mysql_num_rows($result)>0)
 			{	$menu_array=array("parkcode","location_code","incident_code","badge_num");
			$row=mysql_fetch_assoc($result); 
		extract($row);
			$dow=date("l",strtotime($date_occur));
			echo "<td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;<form><select name='field'  onChange=\"MM_jumpMenu('parent',this,0)\">><option value=''>Find All for:</option>";
				foreach($menu_array as $k=>$v)
					{
					$val=${$v};
					echo "<option value='find_pr63.php?$v=$val'>$v</option>\n";
					}
				
				echo "</select></form></td>";
				
				echo "</tr></table>";
			}

if($level<2 and !empty($access_array))
	{
	if(!in_array($parkcode,$access_array))
		{echo "You don't have access to $parkcode."; exit;}
	}

	$sql="SELECT loc_code,location
		FROM cite.location
		where 1 and parkcode='$parkcode'
		order by loc_code
		";
		$result = @MYSQL_QUERY($sql,$connection); //ECHO "$sql";
		while($row=mysql_fetch_assoc($result))
					{$location_array[$row['loc_code']]=$row['location'];}
	
	$sql="SELECT *
		FROM le.incident
		where 1 
		order by incident_code
		";
		$result = @MYSQL_QUERY($sql,$connection); //ECHO "$sql";
		while($row=mysql_fetch_assoc($result))
					{$incident_array[$row['incident_code']]=$row['incident_desc'];}

	$sql="SELECT *
		FROM le.disposition
		where 1 
		order by disposition_code
		";
		$result = @MYSQL_QUERY($sql,$connection); //ECHO "$sql";
		while($row=mysql_fetch_assoc($result))
					{$disposition_array[$row['disposition_code']]=$row['disposition_desc'];}

	$sql="SELECT *
		FROM le.weather
		where 1 
		order by id
		";
		$result = @MYSQL_QUERY($sql,$connection); //ECHO "$sql";
		while($row=mysql_fetch_assoc($result))
					{$weather_array[$row['weather_desc']]=$row['weather_desc'];}

//echo "<pre>"; print_r($row); echo "</pre>"; // exit;
$hour_array=range(0,23);
$minute_array=range(0,59);


// ************************************ Start Form ************************************
echo "<form action='pr63_action.php' name='pr63_form' method='POST' enctype='multipart/form-data'>";
echo "<table border='1' cellpadding='3' align='left'><tr><td><table>";
$size="35";

// Row 1
$v1="Case Incident Number<br /><input type='text' name='ci_num' value=\"$ci_num\" size='10' READONLY>";
$v2="Park Code<br /><input type='text' name='parkcode' value=\"$parkcode\" size='4' READONLY>";
$v3="Location Code<br /><select name='location_code'><option value=''></option>";
	foreach($location_array as $lc=>$loc)
		{
		if($lc==@$location_code){$s="selected";}else{$s="value";}
		$v3.="<option $s='$lc - $loc'>$lc - $loc</option>";
		}
$v3.="</select>";
//$v4="Location of Incident<br /><input type='text' name='loc_name' value=\"$loc_name\" size='24'>";
$v4="";
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";

// Row 2
$date_field="datepicker1";
if(!isset($date_occur)){$date_occur="";}
$v1="Incident date<br /><input id='$date_field' type='text' name='date_occur' value=\"$date_occur\" size='10'>";

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
$v3="Day of Week<br /><input type='text' name='day_week' value=\"$dow\" size='10' READONLY>";
	
//$v4="How Reported<br /><input type='text' name='report_how' value=\"$report_how\" size='24'>";
$v4="";
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";

// Row 3
if(!isset($incident_code)){$incident_code="";}
$v1="Incident Code<br /><input type='text' name='incident_code' value='$incident_code' size='8' readonly><input type=\"button\" value=\"List of Incident Codes\" onClick=\"return popitup('incident.php')\">";

$v2="Nature of Incident auto-complete<br /><input type='text' name='incident_name' value=\"$incident_name\" size='44' READONLY>";

$v3="";
echo "<tr><th>$v1</th><th colspan='3'>$v2</th><th>$v3</th><th>$v4</th></tr>";

// Row 4
if(!isset($report_by)){$report_by="";}
$v1="Reported by<br /><input type='text' name='report_by' value=\"$report_by\" size='24'>";

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
$v2="Received date<br /><input id='$date_field' type='text' name='report_receive_date' value=\"$report_receive_date\" size='10'>";

if(!isset($report_receive_time)){$report_receive_time="";}
$value_hr=substr($report_receive_time,0,2);
	$v_hr="Hour:<select name='report_receive_time'><option value=''></option>";
		foreach($hour_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_hr){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v_hr.=" Minute:<select name='occur_min'><option value=''></option>";
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
$v1="Investigated by<br /><label for=\"investigate_by\"></label>
<input id=\"investigate_by\" name='investigate_by' value=\"$investigate_by\" size='30'>
<script>
$( \"#investigate_by\" ).autocomplete({
source: [ $source ]
});
</script>";

$date_field="datepicker3";
if(!isset($report_investigate_date)){$report_investigate_date="";}
$v2="Investigated date<br /><input id='$date_field' type='text' name='report_investigate_date' value=\"$report_investigate_date\" size='10'>";

if(!isset($report_investigate_time)){$report_investigate_time="";}
$value_hr=substr($report_investigate_time,0,2);
	$v_hr="Hour:<select name='report_investigate_time'><option value=''></option>";
		foreach($hour_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_hr){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v_hr.=" Minute:<select name='occur_min'><option value=''></option>";
	$value_min=substr($report_investigate_time,2,2);				
		foreach($minute_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_min){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v3="Investigated @<br />".$v_hr;

$v4="";
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";


// Row 7

$date_field="datepicker4";
if(!isset($clear_date)){$clear_date="";}
$v1="Cleared date<br /><input id='$date_field' type='text' name='clear_date' value=\"$clear_date\" size='10'>";

if(!isset($clear_time)){$clear_time="";}
$value_hr=substr($clear_time,0,2);
	$v_hr="Hour:<select name='clear_time'><option value=''></option>";
		foreach($hour_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_hr){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v_hr.=" Minute:<select name='occur_min'><option value=''></option>";
	$value_min=substr($clear_time,2,2);				
		foreach($minute_array as $x=>$y)
			{
			$y=str_pad($y,2,"0",STR_PAD_LEFT);
			if($y==$value_min){$s="selected";}else{$s="value";}
			$v_hr.="<option $s='$y'>$y</option>";
			}
	$v_hr.="</select>";
	$v2="Cleared @<br />".$v_hr;

if(!isset($disposition)){$disposition="";}
$v3="Disposition<br /><select name='disposition'><option value=''></option>";
		foreach($disposition_array as $dc=>$dc_name)
			{
			if($dc==$disposition){$s="selected";}else{$s="value";}
			$v3.="<option $s='$dc - $dc_name'>$dc - $dc_name</option>";
			}
	$v3.="</select>";

$v4="";
echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";

// Row 
if($ci_num!="auto-generated")
	{
	$v1="PASU Approved<br /><input id='datepicker5' type='text' name='pasu_approve' value='$dist_approve'>";
	$v2="District Approved<br /><input id='datepicker6' type='text' name='dist_approve' value='$dist_approve'>";
	if(!empty($le_approve)){$ck="checked";}else{$ck="";}
	$v3="Raleigh Office Reviewed: <input type='checkbox' name='le_approve' value='' $ck>";
	$v4="";
	echo "<tr><td>$v1</td><td>$v2</td><td>$v3</td><td>$v4</td></tr>";
	}
echo "</table>";
	
//  ************** end form
		
			
// Involved Persons
@$sql="SELECT * FROM involved_person where ci_id='$id'"; //echo "$sql";  //exit;
 $result = @MYSQL_QUERY($sql,$connection);
 $person_num=mysql_num_rows($result);
while($row=mysql_fetch_assoc($result))
		{$var_persons[$row['row_num']]=$row;}

//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
$server=$_SERVER['HTTP_USER_AGENT'];
		$rows=5;
		$cols=85;
IF(strpos($server,"AppleWebKit/")>0){$cols=85;}//   for Safari and Chrome
IF(strpos($server,"Gecko/")>0){$cols=110;}
IF(strpos($server,"Windows;")>0){$cols=114;}

				

if(@$var_persons[0]['Name']!=""){$block="block";}else{$block="none";}					
echo "<table><tr><td><font color='brown'>Involved Persons:</font> <a onclick=\"toggleDisplay('persons');\" href=\"javascript:void('')\">    show/hide</a> table</td></tr></table><div id=\"persons\" style=\"display: $block\">";

$race_array=array("White"=>"01","Black"=>"02","Hispanic"=>"03","American Indian/Alaska Native"=>"04","Asian/Pacific Islander"=>"05","Other"=>"08",);
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
				echo "<table><tr><td>$v0</td></tr></table>
				<div id=\"incident\" style=\"display: $block\"><table align='center'><tr>
				<td colspan='4'>$v1<td></tr>";
		
			echo "</table></div>";



include("staff_upload_forms.php");

echo "<table align='center'><tr><td align='center'>";
if(!empty($id))
	{
	echo "<input type='hidden' name='id' value='$id'>";
	}
echo "<input type='submit' name='submit' value='Submit'>
</td></tr></form></table>";

if(!empty($id))
	{
	echo "<table><tr><td align='right'><form action='print_pr63.php' method='POST'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='View / Print'></form></td></tr></table>";
	}


// Upload images
if(!empty($id))
	{
$sql="Select id as image_id, parkcode, image_name, link From `le_images` where pr63_id='$id'";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result))
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
				$del="<a href='staff_image_uploads?id=$id&del=$im'  onClick='return confirmLink()'>Delete</a> Image";
				$value="view full-size <a href='$value' target='_blank'>image</a>&nbsp;&nbsp;&nbsp;<img src='$tn'>&nbsp;&nbsp;&nbsp;$del";
				}
				if($fld=="image_id"){$value="";}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}


	echo "<hr /><table><tr><td colspan='3'>
		<font color='purple'>Don't try to upload all images at once. Upload them in batches of 2 or 3.</font><br />A 3mb image will take around a half-minute (depending on your internet speed). Uploading 3 images of that size will take at least a minute and a half.</td></tr>";
	
	$num_images=5;
		echo "<form method='post' action='staff_image_uploads.php' enctype='multipart/form-data'>";
			for($i=1; $i<=$num_images; $i++)
				{
				echo "<tr><td align='right'>Image $i description:</td>
				<td><textarea name='image_name[]' cols='45' rows='3'></textarea></td>
				<td><input type=file name='file_upload[]'></td>
				</tr>";
				}
		echo "<tr><td colspan=2 align='center'>
		
	<input type='hidden' name='id' value='$id'>
	<input type='hidden' name='parkcode' value='$parkcode'>
	<input type='hidden' name='form_name' value='images'>
	<input type=submit name='submit' value='Add Image(s)'></td></tr></table></form>";
		
	}
else
{
echo "<table><tr><td>After submitting the PR-63 you will have the opportunity to upload photos.</td></tr></table>";
}

echo "</div></html>";
?>