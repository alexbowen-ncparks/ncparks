<?php
// used by Fire Management Officer to complete info needed for 
// The Incident Qualification System (IQS) we use to track staff fire training and qualifications has been updated and requires birth month/day and middle names now. 
//  https://wildfiretoday.com/2020/03/10/interagency-resource-ordering-capability-replaces-ross/

$level=0;
ini_set('display_errors',1);

$database="training";

if(empty($_SESSION))
	{session_start();}
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
if(!empty($_SESSION["fire"]['emid']))
	{
	$_SESSION[$database]['level']=3;
	$level=$_SESSION[$database]['level'];
	$_SESSION['training']['emid']=$_SESSION["fire"]['emid'];
	}
	else
	{
	$level=$_SESSION[$database]['level'];
	}
// echo "l=$level";
// $level=$_SESSION[$database]['level'];
if($level<3){exit;}

if(empty($_POST['rep']))
	{
	include("/opt/library/prd/WebServer/Documents/_base_top.php");
	}
////echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>"; print_r($_POST); echo "</pre>";

include("../../include/get_parkcodes_reg.php");

$database="training";
mysqli_select_db($connection,$database);

// We are using S-130 Firefighter Training as a way of limiting this to just those whose info is likely to be needed
$sql="SELECT track.emid, concat(divper.empinfo.Lname, ', ',divper.empinfo.Fname, ' ',divper.empinfo.Mname) as name,  divper.empinfo.dbmonth, divper.empinfo.dbday, divper.emplist.currPark, track.date_completed,  track.comments, class.title, file_upload.link
FROM `track`
left join divper.empinfo on divper.empinfo.emid=track.emid
left join divper.emplist on divper.emplist.emid=track.emid
left join class on class.id=track.class_id
left join file_upload on file_upload.track_id=track.id
 WHERE track.`class_id` = 74 and divper.emplist.currPark is NOT NULL
 order by divper.empinfo.Lname, divper.empinfo.Fname";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array("title");
$c=count($ARRAY);
echo "<table border='1'><tr><td colspan='5'>$c entries for ".$ARRAY[0]['title']."</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="date_completed" and $value=="0000-00-00")
			{
			$value="blank";
			}
		if($fld=="link" and !empty($value))
			{
			$value="<a href='$value' target='_blank'>certificate</a>";
			}
		echo "<td valign='top'>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";


?>
	