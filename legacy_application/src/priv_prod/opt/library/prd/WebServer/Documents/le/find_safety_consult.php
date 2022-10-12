<html><head>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script language="JavaScript">
function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
</script>
</head>

<?php
ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	}

if(!isset($_SESSION['le']['level']))
	{
	$_SESSION['le']['level']=$_SESSION['inspect']['level'];
	$_SESSION['le']['tempID']=$_SESSION['inspect']['tempID'];
	$_SESSION['le']['beacon']=$_SESSION['inspect']['beacon'];	
	$_SESSION['le']['accessPark']=$_SESSION['inspect']['accessPark'];	
	}

$level=$_SESSION['le']['level'];
$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];
if($beacon_num=="60033189")
	{
	$safety_consult=1;
	$_SESSION['fuel']['safety_consult']=1;
	}
$currPark=$_SESSION['le']['select'];
$accessPark=$_SESSION['le']['accessPark'];

	if($level<1)
		{
		exit;
		}	
include("../../include/get_parkcodes_dist.php");

$database="le";	
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if($level>3)
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	}

$sql="SELECT distinct parkcode FROM pr63 order by parkcode";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		$parkcode_array[]=$row['parkcode'];
		}
if(empty($parkcode_array)){array_unshift($parkcode_array,"");}
//secho "<pre>"; print_r($parkcode_array); echo "</pre>"; // exit;

$sql="SELECT distinct t1.incident_code, t1.incident_name
FROM pr63 as t1
left join ems_codes as t3 on t1.incident_code=t3.incident_code
where t3.fosc='x'
order by t1.incident_code";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		$var_ic=$row['incident_code']."*".$row['incident_name'];
		@$incident_code_source.="\"".$var_ic."\",";
		$incident_code_array[$row['incident_code']]=$row['incident_name'];
		}
// echo "<pre>"; print_r ($incident_code_array); echo "</pre>";  exit;

$show=array("ci_num","parkcode", "incident_code");
$sql="SHOW COLUMNS FROM pr63";
 $result = @mysqli_QUERY($connection,$sql); 
while($row=mysqli_fetch_assoc($result))
		{
		if(!in_array($row['Field'],$show)){continue;}
		$allFields[]=$row['Field'];
		}
// echo "<pre>"; print_r($allFields); echo "</pre>"; 
// exit;

echo "<body bgcolor='beige'  class=\"yui-skin-sam\">";

echo "<table align='center'><tr><th colspan='3'>
<h3><font color='purple'>NC DPR PR-63 / DCI for Districts</font></h3></th></tr>
<tr><th>
<a href='pr63_home.php'>PR-63 / DCI Home Page</a></th>
<th>&nbsp;&nbsp;&nbsp;</th>
<th>
<a href='find_pr63_reg.php'>Search Form</a></th>";

if(!empty($safety_consult) or $level>4)
	{
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>";
	echo "<th>&nbsp;&nbsp;&nbsp;</th>
	<th><a href='find_safety_consult.php'>Safety Consultant Form</a></th>";
	}
	
if(!empty($_POST))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip_post=array("submit");
	$clause="";
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld, $skip_post)){continue;}
		if(!empty($val))
			{
			$clause.="<input type='hidden' name='$fld' value=\"$val\">";
// 			$temp[]="$val";
			}
		}

	echo "<th>&nbsp;&nbsp;&nbsp;</th>";
	echo "<th><form method='POST' ACTION='export_csv_safety_consult.php'>";
	echo "<input type='hidden' name='date_occur' value=\"$_POST[date_occur]\">";
	echo "<input type='submit' name='submit_form' value=\"Export to CSV\">";
	echo "</form></th>";
	}
echo "</tr></table>";

echo "<div align='center'>";
// echo "<form action='find_pr63_reg.php' method='POST' enctype='multipart/form-data'>";

$rename_fields=array("ci_num"=>"Case Incident Number/OCA","call_out"=>"Call Out","parkcode"=>"Park Code","location_code"=>"Location Code","loc_name"=>"Location of Incident","date_occur"=>"When did it occur?","time_occur"=>"24 hr. Time","day_week"=>"Day of Week","incident_code"=>"Incident Code","incident_name"=>"Nature of Incident","report_how"=>"How Reported","report_by"=>"Reported by","report_address"=>"Address","report_phone"=>"Phone number of person making report","report_receive"=>"Received by","report_receive_date"=>"Received date","report_investigate_date"=>"Investigated date","report_investigate_time"=>"Investigated time", "report_receive_time"=>"Received time", "weather"=>"Weather", "investigate_by"=>"Investigated by", "clear_date"=>"Date Cleared","clear_time"=>"Time Cleared","disposition"=>"Disposition","details"=>"Details of Incident<br /><font size='2'>Enter a search word or phrase.</font>","dist_approve"=>"DISU Approved","le_approve"=>"LE Reviewed","pasu_approve"=>"PASU Approved","pasu_name"=>"PASU Name","disu_name"=>"DISU Name","entered_by"=>"Entered by","narcan"=>"NALOXONE / NARCAN","use_of_force"=>"Use of Force");

//$readonly=array("ci_num","loc_name");
$radio=array("dist_approve","le_approve","pasu_approve");
$pasu_approve_array=array("Y"=>"y","N"=>"n");
$dist_approve_array=array("Y"=>"y","N"=>"n");
$le_approve_array=array("Y"=>"y","N"=>"n");

$excludeFields=array("id","lat","lon");

$textarea=array("details");
$hard_fields=array("ci_num","parkcode");
$drop_down=array("parkcode","disposition","narcan","use_of_force");

if(empty($_POST))
	{
	echo "<form method='post' action='find_safety_consult.php'><table><tr>
	<td><input type='text' name='date_occur' value=\"\"></td>
	<td><input type='submit' name='submit' value=\"Find Year\"></td>
	</tr></table></form>";
	exit;
	}


	$clause="1 AND (";
	$temp=array();
	foreach($incident_code_array as $k=>$v)
		{
		$temp[]="incident_code='$k'";
		}
	$clause=implode(" or ",$temp);
// 	echo "$clause"; exit;
	$sql="SELECT * FROM pr63 where ($clause)  and date_occur like '%$date_occur%' order by ci_num desc";  
// 	echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql"; exit;
 	$num=mysqli_num_rows($result); //echo "n=$num";
 		if($num==1)
 			{
			$row=mysqli_fetch_assoc($result); extract($row);
			header("Location: pr63_form_reg.php?id=$id");
			exit;
			}

// ************************* RESULTS ******************************
 			$export="";
 		if($num>1)
 			{
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}

 			echo "<table border='1' cellpadding='5'><tr><td colspan='2'>$num reports</td>
 			<td colspan='8'>for these incident ";
 			echo "<a onclick=\"toggleDisplay('codes');\" href=\"javascript:void('')\">Codes</a>
<div id=\"codes\" style=\"display: none\"><pre>"; print_r($incident_code_array); echo "</pre></div>
 			</td>
 			</tr>";
 			$f1="<font color='brown'>";$f2="</font>";
			foreach($ARRAY as $index=>$array)
				{
				@$i++;
				extract($array);
				$ci_link="<a href='pr63_form_reg.php?id=$id'>$ci_num</a>";
				IF($index==0)
					{
					echo "<tr><td></td>
					<td align='center'>CI Num</td>
					<td align='center'>Park</td>
					<td align='center'>Nature of Incident</td>
					<td align='center'>Location</td>
					<td align='center'>Date of Incident</td>
					<td align='center'>Completed by</td>
					";
					echo "</tr>";
					
					}
			
					echo "<tr><td>$i</td>
					<td align='center'>$f1$ci_link$f2</td>
					<td align='center'>$f1$parkcode$f2</td>
					<td align='left'>$f1$incident_name$f2</td>
					<td align='left'>$f1$loc_name$f2</td>
					<td align='center'>$f1$date_occur$f2</td>
					<td align='left'>$f1$investigate_by$f2</td>
					";
					
					echo "</tr>";
					
				}
			echo "</table>";
			exit;
			}
 		if($num<1)
 			{
			$message="No PR-63 / DCI found using $clause";
			exit;
			}
	
echo "</body></html>";
?>