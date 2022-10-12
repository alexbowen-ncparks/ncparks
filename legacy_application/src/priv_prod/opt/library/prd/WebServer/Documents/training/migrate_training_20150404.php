<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
ini_set('display_errors',1);

$database="training";
include("../../include/auth.inc"); // used to authenticate users
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//$emid=$_SESSION[$database]['emid'];
$level=$_SESSION[$database]['level'];
if($level<1){exit;}
include("../../include/connectROOT.inc");// database connection parameters
include("../no_inject.php");
include("../../include/get_parkcodes.php");

if(empty($_POST['rep']))
	{
	include("/opt/library/prd/WebServer/Documents/_base_top.php");
	}
mysql_select_db($database,$connection);

if(!empty($_POST['class_id']))
	{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	$emid=$_POST['emid'];
		$sql="SELECT class_id from track where emid='$emid'";
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
		while($row=mysql_fetch_array($result))
			{
			$skip_this[]=$row['class_id'];
			}
	foreach($_POST['class_id'] AS $index=>$class_id)
		{
		if(empty($class_id)){continue;}
		if(in_array($class_id,$skip_this)){continue;}
		$fire_id=$_POST['fire_db_name'][$index];
		$sql="INSERT INTO track set class_id='$class_id', emid='$emid', fire_id='$fire_id'"; //echo "$sql"; exit;;
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
	//	exit;
		}
	}
if(empty($_POST['rep']))
	{
	if($level>2)
		{
	mysql_select_db('divper',$connection);
		$sql="SELECT concat(t1.Lname,', ',t1.Fname,' ',t1.Mname,'-',t2.currPark,'*',t1.emid) as name
		from empinfo as t1
		LEFT JOIN emplist as t2 on t1.emid=t2.emid
		where t2.currPark !=''
		order by t1.Lname, t1.Fname";
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
		$source_name="";
		while($row=mysql_fetch_assoc($result))
			{
			$source_name.="\"".$row['name']."\",";
			}
		$source_name=rtrim($source_name,",");
		}
		


	extract($_REQUEST);

	// Form ************************************
	// Classes
	mysql_select_db($database,$connection);
	$sql="SELECT distinct title,id from class where 1 order by title";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
		$source_title="";
	while($row=mysql_fetch_assoc($result))
		{
		$source_title.="\"".$row['title']."*".$row['id']."\",";
		$program_title[$row['title']]=$row['id'];
		}
		$source_title=rtrim($source_title,",");
	//echo "$source_title";  exit;

	echo "<table><tr><th colspan='5'><font color='gray'>Search DPR Training Database</font></th></tr></table>";


	$fld_array=array("name","class","date_completed","weblink");

	if(!isset($name)){$name="";}
	IF(!empty($emid))
		{
		mysql_select_db('divper',$connection);
		$sql="SELECT concat(t1.Lname,', ',t1.Fname,' ',t1.Mname,'-',t2.currPark,'*',t1.emid) as name
		from empinfo as t1
		LEFT JOIN emplist as t2 on t1.emid=t2.emid
		where t2.emid='$emid'
		order by t1.Lname, t1.Fname";
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
		$source_name="";
		while($row=mysql_fetch_assoc($result))
			{
			$name=$row['name'];
			}
		}
	echo "<form action='migrate_training.php' method='POST'><table>";

	echo "<tr><td><font color='brown'>Name:</font> </td><td><input type='text' id=\"name\" name='name' value=\"$name\" size='44'></td>";


	echo "	<script>
			$(function()
				{
				$( \"#name\" ).autocomplete({
				source: [ $source_name]
					});
				});
			</script>
	";
		

	if(!isset($class)){$class="";}
	echo "<tr><td><font color='brown'>Class:</font> </td><td><input type='text' id=\"class\" name='class' value=\"$class\" size='94'></td></tr>";
	
		echo "<tr><td colspan='2' align='center'>";
		if(!empty($_POST))
			{echo "<input type='checkbox' name='rep' value='x'> Excel export";}
	
		echo "
		<input type='submit' name='submit' value='Find' style=\"background:yellow\">
		</td></tr>";
	
	
		echo "</table></form>";

	echo "	<script>
			$(function()
				{
				$( \"#class\" ).autocomplete({
				source: [ $source_title ]
					});
				});
			</script>";	
	}	
if(empty($_REQUEST)){exit;}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if(!empty($_REQUEST))	
	{
	mysql_select_db($database,$connection);
	extract($_REQUEST);
	if(!empty($_POST['name']))
		{
		$exp=explode("*",$_POST['name']);
		$emid=$exp[1];
		}
	$sql="SELECT t1.*, t2.title, t3.*
	FROM `track` as t1
	left join `class` as t2 on t1.class_id=t2.id
	left join `fire_to_train` as t3 on t1.class_id=t3.train_id
	where t1.emid='$emid' and t2.program like '%fima%'
	"; //echo "$sql";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY_tracked[]=$row['id'];
		$ARRAY_tracked_fire[$row['class_id']]=$row['fire_id'];
		$ARRAY_tracked_train[$row['class_id']]=$row['title'];
		}
		
	mysql_select_db('fire',$connection);
	$sql="SELECT *
	FROM `fire_train`
	where emp_id='$emid'
	"; //echo "$sql";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	

if(empty($ARRAY))
	{
	IF(!empty($_REQUEST))
		{
		if($level>6){echo "$sql";}
		echo "<font color='red'>Nothing found.</font>";
		}
	exit;
	}
//echo $sql;

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

// ************************* Display search results ****************
//echo "$sql";
//echo "<pre>"; print_r($ARRAY_tracked); echo "</pre>"; // exit;
//echo "<pre>"; print_r($ARRAY_tracked_fire); echo "</pre>"; // exit;
//echo "<pre>"; print_r($ARRAY_tracked_train); echo "</pre>"; // exit;
$flip=array_flip($ARRAY_tracked_fire);

echo "<form method='POST' action='migrate_training.php'>";
echo "<table border='1'>";
echo "<tr><th>Class ID</th><th>Class Title (Fire Management)</th><th>Fire db</th><th>Training History db</th></tr>";
foreach($ARRAY[0] AS $class=>$value)
	{
	@$i++;
//	if(empty($value)){continue;}
	if($value!="X"){continue;}
	$var_class="";
	$var=str_replace("_"," ",$class);
	$var_th="";
	$train_id="";
	if(in_array($var, $ARRAY_tracked_train)){$var_th="X";}
	if(in_array($var, $ARRAY_tracked_fire))
		{
		$train_id=$flip[$var];
		$var_th=$ARRAY_tracked_train[$train_id];
		}
	if(array_key_exists($var,$program_title))
		{
		$var_class=$program_title[$var];
		if(in_array($var_class, $ARRAY_tracked))
			{$class="<td>".$var."</td>";}
			else
			{
			$class="<td><input type='text' name='class_id[$i]' value=\"$var_class\" size='4'></td><td>".$var."</td>";
			}
		
		}
		else
		{
		if(!empty($var_th)){$var_class=$train_id;}
		$class="<td>".$var."</td>
		<td>
		<input type='hidden' name='fire_db_name[$i]' value=\"$var\">
		<input type='text' name='class_id[$i]' value=\"$var_class\" size='4'>
		</td>";
		}
	echo "<tr>$class<td align='center'></td><td align='center'>$var_th</td></tr>";
		
	}
echo "<tr><td colspan='4' align='center'>
<input type='hidden' name='emid' value=\"$emid\">
<input type='submit' name='submit' value=\"Migrate\">
</td></tr>";
echo "</table></form>";

echo "</body></html>";

?>