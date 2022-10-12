<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>"; print_r($_POST); echo "</pre>";
ini_set('display_errors',1);

$database="training";
include("../../include/auth.inc"); // used to authenticate users
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
$emid=$_SESSION[$database]['emid'];
if(empty($_POST['rep']))
	{
	include("/opt/library/prd/WebServer/Documents/_base_top.php");
	}

include("../../include/iConnect.inc");// database connection parameters
include("../../include/get_parkcodes_i.php");

$database="training";
mysqli_select_db($connection,$database);

if(@$_GET['del']==1)
	{
	$id=$_GET['id'];
	$sql="DELETE from track where id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	echo "The training class has been deleted.";
	exit;
	}

if(empty($_POST['rep']))
	{
// 	extract($_REQUEST);

	// Form ************************************
	// Classes
	mysqli_select_db($connection,$database);
	$sql="SELECT distinct title,id from class where 1 order by title";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		$source_title="";
	while($row=mysqli_fetch_assoc($result))
		{
		$source_title.="\"".$row['title']."*".$row['id']."\",";
		}
		$source_title=rtrim($source_title,",");
	//echo "$source_title";  exit;


	// Program categories
// 	mysqli_select_db($connection,$database);
	$sql="SELECT * from program_categories where 1 order by cat_name";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));

	while($row=mysqli_fetch_assoc($result))
		{
		$program_array[$row['prog_cat']]=$row['cat_name'];
		}


	echo "<table><tr><th colspan='5'><font color='gray'>Search DPR Training Database</font></th></tr></table>";


	$fld_array=array("name","class","date_completed","weblink");

	if(!isset($name)){$name="";}
	echo "<form action='view_class.php' method='POST'><table>";
		
	if(!isset($class)){$class="";}
	echo "<tr><td><font color='brown'>Class:</font> </td><td><input type='text' id=\"class\" name='class' value=\"$class\" size='94'></td></tr>";

	echo "<tr><td><font color='brown'>Program<br />Category:</font> </td><td valign='bottom'>";
	foreach($program_array as $k=>$v)
		{
		@$i++;
		if(@in_array($k,$_POST['program'])){$ck="checked";}else{$ck="";}
		echo "<input type='checkbox' name='program[]' value='$k' $ck>$v ";
		if($i==10){echo "<br />";}
		}
	echo "</td></tr>";
	
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

$action_button="Update";
echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if(!empty($_REQUEST))	
	{
	$skip=array("submit","edit","success","sort","program","rep");
	if(!empty($_REQUEST['program']))
		{
		$_SESSION['training']['var_prog']=$_REQUEST['program'];
		}
	if(!empty($success))
		{
		$_POST['program']=$_SESSION['training']['var_prog'];
		}
	$clause=1 ;
	foreach($_REQUEST AS $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(empty($value)){continue;}

		if($fld=="class")
			{
			$exp=explode("*",$class);
			if(count($exp)>1)
				{
				$value=$exp[1];
				$fld=" and id";
				$clause.=" and id='$value'";
				}
				else
				{
				$fld=" and t1.title like '%$exp[0]%'";
				@$clause.=$fld." AND ";
				}
			}
		$value=addslashes($value);
		}
	@$clause=rtrim($clause," AND ");
	
	if(!empty($_POST['program']))
		{
		$clause.=" and (";
		foreach($_POST['program'] as $k=>$v)
			{
			@$prog_clause.="t1.program like '%$v%' OR ";
			}
		$clause.=rtrim($prog_clause,"  OR ").")";
		}
		
	if(empty($clause))
		{
		echo "<font color='red'>Nothing entered.</font>";
		exit;
		}
	if(@$_REQUEST['u']==1)
		{
		echo "<font color='green'>Update successful.</font>";
		}
	
	if(empty($sort))
		{$sort="title ASC";}
//	if($sort=="title ASC"){$sort.=", date_completed";}
	
	$sql="SELECT  t1.*
	from class as t1
	 where $clause 
	 order by $sort";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
//	echo "$sql<br /><br />";
	while($row=mysqli_fetch_assoc($result))
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
$c=count($ARRAY);
if(!empty($_POST['rep']))
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=training_record.xls');
	}
echo "<table border='1' align='center' cellpadding='5'>";
echo "<tr>";

if(empty($_POST['rep']))
	{
	echo "<th align='center'>$c</th>";
	}
	
foreach($ARRAY[0] as $k=>$v)
	{
	if($k=="id"){continue;}
	$k1=str_replace("_"," ",$k);
	
		$link="<form method='POST' action='track.php'>";
		if(!empty($name)){$link.="<input type='hidden' name='name' value='$name'>";}
		if(!empty($class)){$link.="<input type='hidden' name='class' value='$class'>";}
//		if($k=="date_completed" and $sort=="date_completed ASC"){$k.=" DESC";}else{$k.=" ASC";}
		if($sort==$k." ASC"){$k.=" DESC";}else{$k.=" ASC";}
		$link.="<input type='hidden' name='sort' value='$k'>";
		if(!empty($_POST['program']))
			{
			foreach($_POST['program'] as $var_k=>$var_v)
				{
				$link.="<input type='hidden' name='program[]' value='$var_v'>";
				}
			}
		$link.="<input type='submit' name='submit' value='$k1' style=\"background: #339933; color: #FFF\"></form>";
	
	echo "<th align='center'>";
		if(empty($_POST['rep']))
			{
			echo "$link";
			}
			else
			{echo "$k1";}
			
	echo "</th>";
//	@$header.="<th>$k1</th>";
	}
echo "</tr>";
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY as $index=>$array)
	{
	$id=$ARRAY[$index]['id'];
	
	$button="<form method='POST' action='update_class.php'>";
	$button.="<input type='hidden' name='edit' value='1'>";
	$button.="<input type='hidden' name='id' value='$id'>";
	$button.="<input type='submit' name='submit' value='Edit' style=\"background: #800000; color: #FFF\"></form>";
//	echo "<tr><td><a href='update.php?edit=1&id=$id'>edit</a></td>";
	echo "<tr>";
	
		if(empty($_POST['rep']))
			{
			echo "<td>$button</td>";
			}
			
	foreach($array as $fld=>$value)
		{
		if($fld=="id"){continue;}
		if($fld=="title")
			{
			if($level>3){$id=$array['id']; $value=$id." - ".$value;}
			}
		if($fld=="program" and !empty($value))
			{
			$exp=explode(",",$value);
			$temp="";
			foreach($exp as $k=>$v)
				{
				$temp.=str_replace(" ","&nbsp;",$program_array[$v])." ";
				}
			$value=$temp;
			if($level>3){$id=$array['id']; $value=$id." - ".$value;}
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}

echo "</table></form>";

?>