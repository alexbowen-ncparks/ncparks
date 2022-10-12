<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
ini_set('display_errors',1);

$database="training";
include("../../include/auth.inc"); // used to authenticate users
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//$emid=$_SESSION[$database]['emid'];
$level=$_SESSION[$database]['level'];
if($level<1){exit;}
include("../../include/iConnect.inc");// database connection parameters

include("../../include/get_parkcodes_reg.php");

if(empty($_POST['rep']))
	{
	include("/opt/library/prd/WebServer/Documents/_base_top.php");
	}
mysqli_select_db($connection,$database);

if(!empty($_POST['emid']))
	{
	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

	foreach($_POST['emid'] AS $index=>$emid)
		{
		$sql="UPDATE track set class_id='$course_new' where emid='$emid' and class_id='$course_old'"; 
		echo "$sql"; exit;;
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		}
	}
if(empty($_POST['rep']))
	{

	// Form ************************************
	// Classes
// 	mysqli_select_db($database,$connection);
	$sql="SELECT distinct title,id from class where 1 order by title";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		$source_title="";
	while($row=mysqli_fetch_assoc($result))
		{
		$source_title.="\"".$row['title']."*".$row['id']."\",";
		$program_title[$row['title']]=$row['id'];
		}
		$source_title=rtrim($source_title,",");
	//echo "$source_title";  exit;

	echo "<table><tr><th colspan='5'><font color='gray'>Search DPR Training Database</font></th></tr></table>";

	echo "<form action='migrate_course.php' method='POST'><table>";

	if(!isset($course_old)){$course_old="";}
	echo "<tr><td><font color='brown'>Existing Course to be removed:</font> </td><td><input type='text' id=\"course_old\" name='course_old' value=\"$course_old\" size='44'></td>";


	echo "	<script>
			$(function()
				{
				$( \"#course_old\" ).autocomplete({
				source: [ $source_title]
					});
				});
			</script>
	";
		

	if(!isset($course_new)){$course_new="";}
	echo "<tr><td><font color='brown'>Move to this Course:</font> </td><td><input type='text' id=\"course_new\" name='course_new' value=\"$course_new\" size='94'></td></tr>";
	
		echo "<tr><td colspan='2' align='center'>";
	
		echo "
		<input type='submit' name='submit' value='Find' style=\"background:yellow\">
		</td></tr>";
	
	
		echo "</table></form>";

	echo "	<script>
			$(function()
				{
				$( \"#course_new\" ).autocomplete({
				source: [ $source_title ]
					});
				});
			</script>";	
	}	
if(empty($_REQUEST)){exit;}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if(!empty($_REQUEST))	
	{
// 	mysqli_select_db($database,$connection);
// 	extract($_REQUEST);
	if(!empty($_POST['course_old']))
		{
		$exp=explode("*",$_POST['course_old']);
		$course_old=$exp[1];
		$exp=explode("*",$_POST['course_new']);
		$course_new=$exp[1];
		}
	$sql="SELECT t1.*, t2.title, t3.Fname, t3.Lname
	FROM `track` as t1
	left join `class` as t2 on t1.class_id=t2.id
	left join divper.`empinfo` as t3 on t1.emid=t3.emid
	where  t2.id = '$course_old'
	"; //echo "$sql";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
		
	}
// echo "$sql<pre>"; print_r($ARRAY); echo "</pre>";  exit;	

// ************************* Display search results ****************

$skip=array();
$c=count($ARRAY);

echo "<form method='POST' action='migrate_course.php'>";

echo "<table><tr><td>$c</td></tr>";
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
		extract($array);
		if($fld=="emid")
			{
			echo "<input type='hidden' name='emid[]' value=\"$emid\">";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}

echo "<tr><td colspan='8' align='center'>Migrate all above from Course Number: $course_old to Course Number: $course_new</td></tr>";

echo "<tr><td colspan='4' align='center'>
<input type='hidden' name='course_old' value=\"$course_old\">
<input type='hidden' name='course_new' value=\"$course_new\">
<input type='submit' name='submit' value=\"Migrate\">
</td></tr>";
echo "</table></form>";

echo "</body></html>";

?>