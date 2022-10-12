<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
//ini_set('display_errors',1);

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$level=$_SESSION['divper']['level'];
$position=$_SESSION['position'];

$position_allow=array();
if(strpos($position, "Park Superintendent")>-1)
	{
	$position="Park Superintendent";
	$position_allow[]="Park Superintendent";
	}
	
if(strpos($position, "Office Assistant")>-1)
	{
	$position="Office Assistant";
	$position_allow[]="Office Assistant";
	}

// supervise is a field in divper.emplist, session var set in dpr_login.php
@$check_supervise=explode(",",$_SESSION['divper']['supervise']);

if(!in_array($position, $position_allow) and $level<2 and !in_array($_REQUEST['beacon_num'],$check_supervise))
	{exit;}

include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,'dpr_system'); // database
$sql = "SELECT * FROM dpr_system.parkcode_names_district";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$parkCodeName[$row['park_code']]=$row['park_name'];
	if($row['district']=="EADI"){$arrayEADI[]=$row['park_code'];}
	if($row['district']=="SODI"){$arraySODI[]=$row['park_code'];}
	if($row['district']=="NODI"){$arrayNODI[]=$row['park_code'];}
	if($row['district']=="WEDI"){$arrayWEDI[]=$row['park_code'];}
	}

mysqli_select_db($connection,'divper'); // database

extract($_REQUEST);
date_default_timezone_set('America/New_York');

//include("../../include/parkcodesDiv.inc");
// include("../../include/dist.inc");
//print_r($_REQUEST);//exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//print_r($_POST);exit;
$user_beacon_number=$_SESSION['beacon_num'];
//$tempID=$_SESSION['logname'];
//echo "l=$level";

if(@$submit=="Delete Position")
	{
	if($posNum){
	$query="DELETE from position WHERE posNum='$posNum'";}else{
	$query="DELETE from position WHERE beacon_num='$beacon_num'";}
	//echo "$query";exit;
	
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: findVacant_dist.php");
	exit;
	}


if(@$submit=="Enter")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
		foreach($_POST as $k=>$v)
			{
			if($k=="comments"){$newComment=trim($v);}
			if($k=="chop_comments"){$new_CHOP_Comment=trim($v);}
			if($k=="dateVac"){$date_vacant=trim($v);}
			
			if($k!="submit" and $k!="oldComment" and $k!="old_CHOP_Comment")
			{@$string.="$k='".htmlspecialchars_decode($v)."', ";}
			}
	$string=trim($string,", ");
	
	$query="REPLACE vacant SET $string"; //echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
	
	if (trim($oldComment) != trim($newComment))
		{
		extract($_REQUEST);
		$oldComment=htmlspecialchars_decode($oldComment);
		$query="INSERT vacant_comments SET beacon_num='$beacon_num', tracked='$oldComment', date_vacant='$date_vacant'"; //echo "$query";exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
		
		}
	
	if (trim($old_CHOP_Comment) != trim($new_CHOP_Comment))
		{
		extract($_REQUEST);
		$old_CHOP_Comment=htmlspecialchars_decode($old_CHOP_Comment);
		$query="INSERT vacant_chop_comments SET beacon_num='$beacon_num', tracked='$old_CHOP_Comment', date_vacant='$date_vacant'"; //echo "$query";exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
		
		}
	header("Location: trackPosition_dist.php?beacon_num=$beacon_num&m=1");
	exit;
	}

include("menu.php");


$sql = "SELECT * From position WHERE beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$dist="";
	if(in_array($park,$arrayEADI)){$dist="EADI";}
	if(in_array($park,$arraySODI)){$dist="SODI";}
	if(in_array($park,$arrayNODI)){$dist="NODI";}
	if(in_array($park,$arrayWEDI)){$dist="WEDI";}
	}
if(@$m){$message="Position Updated";}

$sql = "SELECT * From vacant WHERE beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
if(mysqli_num_rows($result)<1)
	{
	$sql = "SELECT * From vacant_admin WHERE beacon_num='$beacon_num'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1)
		{
		echo "No vacant position found for BEACON Number $beacon_num"; exit;
		}
	}
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	}
//echo "$sql";
//if($release_request=="x"){$ckRelease_request="checked";}

if(!isset($dateVac)){$dateVac="";}
$sql = "SELECT id From vacant_comments WHERE beacon_num='$beacon_num' and date_vacant='$dateVac' LIMIT 1";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
if(mysqli_num_rows($result)>0)
	{
	$ca="<th><a href='comment_history.php?bn=$beacon_num&dv=$dateVac' target='_blank'>History</a></th>";
	}

$sql = "SELECT id From vacant_chop_comments WHERE beacon_num='$beacon_num' and date_vacant='$dateVac' LIMIT 1";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
if(mysqli_num_rows($result)>0)
	{
	$ca_chop="<th><a href='chop_comment_history.php?bn=$beacon_num&dv=$dateVac' target='_blank'>History</a></th>";
	}
if(@$passbeacon_num){$beacon_num=$passbeacon_num;}

// *************Entry Form 
echo "<!DOCTYPE html><html><head><title>Enter Emp Info</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige}
th
{font-size:95%;vertical-align:bottom}
#div-legend {
font-size:90%;
 position:absolute;
 top:370;
 left:30;
 width:200px;
 text-align:left; 
}
--> 
</STYLE>
</head>
<body><font size='4' color='004400'>NC State Parks System Permanent Position</font>";
if(@$message){$m="<font color='red' size='4'>$message</font>";}
else{$m="";}

if(!isset($success)){$success="";}
if(!isset($hireMan)){$hireMan="";}
if(!isset($class)){$class="";}

//<th>Position<br>Number</th>
//<td align='center'>
//<font color='blue'>$posNum</font></td>
echo "<div align='center'>
<table><tr><td>Track Position Number - <font size='+1' color='blue'>$beacon_num</font> - <font color='purple'> $posTitle
</font></td></tr><tr><td>$m</td></tr>
</table><form method='post' action='trackPosition_dist.php'>
$success
<table border='1'><tr><th>BEACON<br>Number</th><th>Park</th><th>District</th><th>CDL Required</th><th>Hiring Manager<br>Name</th><th>Classification</th></tr>
<tr>

<td align='center'><font color='blue'>$beacon_num</font></td>
<td align='center'><font color='blue'>$park</font></td>
<td align='center'><font color='blue'>$dist</font></td>
<td align='center'><font color='blue'>$cdl</font></td>
<td align='center'>
<input type='text' size='20' name='hireMan' value=\"$hireMan\"></td>
<td align='center'>
<input type='text' size='27' name='class' value='$class'></td></tr>
</table>";


if(!isset($payGrade)){$payGrade="";}
if(!isset($dateVac)){$dateVac="";}
if(!isset($lastEmp)){$lastEmp="";}
if(!isset($varEI)){$varEI="";}
if(!isset($to_dpr_hr)){$to_dpr_hr="";}
//<th>E/I</th>
echo "<hr>
<table border='1'>
<tr><th>Pay<br>Grade</th><th>Date<br>Vacant</th><th>Last Employee</th><th>To DPR HR</th></tr>
<tr><td align='center'>
<input type='text' size='5' name='payGrade' value='$payGrade'></td>
<td>
<input type='text' size='11' name='dateVac' value='$dateVac'></td>
<td>
<input type='text' size='37' name='lastEmp' value='$lastEmp'></td>";
// <td align='center'>
// <input type='text' size='3' name='varEI' value='$varEI'></td>
echo "<td align='center'>
<input type='text' size='12' name='to_dpr_hr' value='$to_dpr_hr'></td>
</tr></table>
<hr>
<table border='1'><tr>";
if($_SESSION['beacon_num']=="60032920" || $_SESSION['beacon_num']=="60033018"){
// CHOP OA and CHOP
echo "<th>Release Request<br>from CHOP</th>";}

echo "<th>Posting<br>Open</th><th>Posting<br>Closed</th><th>Close Plus<br>
<a href='ninety.php'>Ninety Days</a></th><th>Screener<br>Name</th></tr><tr>";

if($_SESSION['beacon_num']=="60032920" || $_SESSION['beacon_num']=="60033018")
	{
	echo "<td align='center'><input type='text' size='12' name='release_request' value='$release_request'></td>";
	}

if(!isset($postOpen)){$postOpen="";}
if(empty($postClose))
	{$postClose=""; $ts="";}
	else
	{
	$var_ar=explode("/",$postClose);	@$var_close=$var_ar[2]."-".str_pad($var_ar[0],2,'0',STR_PAD_LEFT)."-".str_pad($var_ar[1],2,'0',STR_PAD_LEFT);
	$var_ninety=(90*24*60*60);
	$ts = strtotime($var_close)+$var_ninety;
	$ts="<font color='purple'>".date("Y-m-d",$ts)."</font>";
	}
if(!isset($screen_name)){$screen_name="";}


echo "<td align='center'>
<input type='text' size='12' name='postOpen' value='$postOpen'></td>
<td align='center'>
<input type='text' size='12' name='postClose' value='$postClose'></td>
<td align='center'>$ts</td>
<td align='center'>
<textarea name='screen_name' cols='25' rows='1'>$screen_name</textarea></td>
</tr></table>";

if(!isset($appToMan)){$appToMan="";}
if(!isset($recToSup)){$recToSup="";}
if(!isset($supToSup)){$supToSup="";}
if(!isset($supToHR)){$supToHR="";}

echo "<div id='div-legend'>
<p>Application Flow</p>";
$var=trim($appToMan);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>1 -$f1 Hiring Manager$f2</p>";
$var=trim($recToSup);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>2 -$f1 PASU/DISU$f2</p>";
$var=trim($supToSup);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>3 -$f1 CHOP$f2</p>";
$var=trim($supToHR);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>4 -$f1 HR Rep$f2</p>";
$var=trim($hrToDir);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>5 -$f1 Director$f2</p>";
$var=trim($repToHRsup);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>6 -$f1 HR Sup$f2</p>";
$var=trim($recToHR);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>7 -$f1 To DNCR HR$f2</p>";
// $var=trim($start_date);
// if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
// echo "<p>8 -$f1 Budget$f2</p>";
$var=trim($appFromHR);
if(empty($var)){$f1="";$f2="";}else{$f1="<font color='green'>";$f2="</font>";}
echo "<p>8 -$f1 From DNCR HR$f2</p>";

echo "</div>";

if(!isset($repToHRsup)){$repToHRsup="";}
if(!isset($hrToDir)){$hrToDir="";}
echo "<hr>
<table border='1'>
<tr><th align='center' colspan='5'><font color='red' size='+1'>The following dates represent the Received Dates.</font></th></tr>
<tr><th>Hiring Manager</th>
<th>PASU/DISU</th>
<th>CHOP</th>
<th>HR Rep</th>
<th>Director</th>
<tr><td align='center'><input type='text' size='10' name='appToMan' value='$appToMan'></td>
<td align='center'>
<input type='text' size='10' name='recToSup' value='$recToSup'></td>
<td align='center'>
<input type='text' size='10' name='supToSup' value='$supToSup'></td>
<td align='center'>
<input type='text' size='15' name='supToHR' value='$supToHR'></td>
<td align='center'>

<input type='text' size='10' name='hrToDir' value='$hrToDir'></td>
</tr></table>

<table border='1'>
<tr><th>HR Sup</th>
<th>To DNCR HR</th>
<th>Start Date</th>
<th>From DNCR HR</th>
<th>Status</th>";

if(!isset($hrToDir)){$hrToDir="";}
if(!isset($recToHR)){$recToHR="";}
if(!isset($start_date)){$start_date="";}
if(!isset($appFromHR)){$appFromHR="";}
if(!isset($status)){$status="";}
echo "</tr>";
$x=1;
echo "
<script>
    $(function() {";
    for($i=1;$i<=$x;$i++)
    	{
    	echo "
        $( \"#datepicker".$i."\" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: \"-1yy\" });
   ";
    }
echo " });
</script>";

echo "<tr><td align='center'>
<input type='text' size='15' name='repToHRsup' value='$repToHRsup'></td>
<td align='center'>
<input type='text' size='10' name='recToHR' value='$recToHR'></td>
<td align='center'>
<input type='text' size='10' id=\"datepicker1\" name='start_date' value='$start_date'></td>
<td align='center'><input type='text' size='10' name='appFromHR' value='$appFromHR'></td>";

$ckr=""; $ckp="";
//"Screening", 
$status_array=array("Pending background", "Filled", "Recruiting", "Lateral", "Pending Post", "Reclassification", "Resubmission 2nd", "Resubmission 3rd", "Resubmission 4th", "Resubmission 5th");
echo "<td><select name='status'><option value=\"\"></option>\n";
foreach($status_array as $k=>$v)
	{
	if($v==$status){$s="selected";}else{$s="";}
	echo "<option value=\"$v\" $s>$v</option>\n";
	}
echo "</select></td>";


if(!isset($ca)){$ca="";}
if(!isset($comments)){$comments="";}
echo "</tr>
</table>
<table>
<tr><th>General Comments</th>$ca
</tr>
<tr>
<td><textarea name='comments' cols='80' rows='10'>$comments</textarea></td>
</tr>";

$view_chop_comments=array("60032931","60032913","60033019","60033093","60033104","60033148", "60032912", "60032892");
//60032913=WEDI DISU
//60032931=WEDI OA
//60032912=EADI DISU
//60032892=EADI OA
//60033104=NODI DISU
//60033148=NODI OA
//60033019=SODI DISU
//60033093=SODI OA

if(!isset($chop_comments)){$chop_comments="";}
if(in_array($_SESSION['beacon_num'],$view_chop_comments) || $_SESSION['divper']['level']>3)
	{
	if(!isset($ca_chop)){$ca_chop="";}
	echo "</tr>
	</table>
	<table>
	<tr><th>CHOP Comments</th>$ca_chop
	</tr>
	<tr>
	<td><textarea name='chop_comments' cols='80' rows='10'>$chop_comments</textarea></td>
	</tr>";
	}
else
	{
	echo "<input type='hidden' name='chop_comments' value='$chop_comments'>";
	}

echo "</table>";

// DISU & DIOA
if($level>3 or in_array($_SESSION['beacon_num'],$view_chop_comments)) 
	{
	if(!isset($comments)){$comments="";}
	if(!isset($chop_comments)){$chop_comments="";}
	echo "<table><tr><td>
	<input type='hidden' name='oldComment' value='$comments'>
	<input type='hidden' name='old_CHOP_Comment' value='$chop_comments'>
	<input type='hidden' name='posNum' value='$posNum'>
	<input type='hidden' name='beacon_num' value='$beacon_num'>
	<input type='submit' name='submit' value='Enter'></td></tr></form></table>";
	}

echo "</div><table align='center' border='1' cellpadding='5'><tr><td align='center'>DPR Merit Based Hiring SOP <a href='https://10.35.152.9/find/forum.php?searchterm=Merit Based&submit=Search' target='_blank'>forms</a> required to complete a Merit Based Hiring Recommendation Package.</td><td>View/Upload <a href='vacant_form_upload.php?beacon_num=$beacon_num'>forms</a> necessary to start filling this position.</td></tr>";
echo "</div><table align='center' border='1' cellpadding='5'><tr><td align='center'>DPR Merit Based Hiring SOP <a href='https://10.35.152.9/find/forum.php?searchterm=Merit Based&submit=Search' target='_blank'>forms</a> required to complete a Merit Based Hiring Recommendation Package.</td><td>View/Upload <a href='vacant_form_upload.php?beacon_num=$beacon_num'>forms</a> necessary to start filling this position.</td></tr>";

if($level>1){echo "<tr><td>&nbsp;</td></tr><tr><td>View/Upload the HQ applicant <a href='pd107_upload.php?beacon_num=$beacon_num'>PD107s</a> for this position.</td>";}

if($level==1){echo "<tr><td>&nbsp;</td></tr><tr><td>View the HQ applicant <a href='pd107_upload.php?beacon_num=$beacon_num'>PD107s</a> for this position.</td>";}

echo"<td>View the Recommendation <a href='recommend.php?beacon_num=$beacon_num'>package</a> for this position.</td>";

echo "</tr></table></body></html>";

?>