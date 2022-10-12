<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
echo "<pre>"; print_r($_POST); echo "</pre>";
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

/*
if(@$_GET['del']==1)
	{
	$id=$_GET['id'];
	$sql="DELETE from track where id='$id'";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	echo "The training class has been deleted.";
	exit;
	}
*/
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
		else
		{
		$exp=explode("*",$_POST['name']);
		$emid=$exp[1];
		$full_name=$_SESSION['training']['full_name'];
		extract($_REQUEST);
		if(empty($_REQUEST['sort']))
			{
			$sort="date_completed";
			}
		if($sort=="title ASC"){$sort.=", date_completed";}
	
	mysql_select_db('fire',$connection);
		$sql="SELECT *
		FROM `fire_train`
		where emp_id='$emid'
		"; echo "$sql";
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
		while($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
		if(empty($ARRAY))
			{
			echo "No training class has been entered.";
			exit;
			}
		$skip=array("id","emid","class_id");
		if(count($ARRAY>0))
			{
			$c=count($ARRAY);
			echo "<table border='1' cellpadding='5'><tr><th colspan='5' align='left'><font color='#009900'>$c Training Courses entered for $full_name</font></tdh></tr>";
			foreach($ARRAY AS $index=>$array)
				{
				if($index==0)
					{
					echo "<tr>";
					foreach($ARRAY[0] AS $fld=>$value)
						{
					
						if(in_array($fld,$skip)){continue;}
						$k=$fld;
		if($k=="date_completed" and $sort=="date_completed ASC"){$k.=" DESC";}else{$k.=" ASC";}
		$link="<a href='track.php?sort=$k'>$fld</a>";
		echo "<th>$link</th>";
					//	echo "<th>$fld</th>";
						}
					echo "</tr>";
					}
				echo "<tr>";
				foreach($array as $fld=>$value)
					{
					if(in_array($fld,$skip))
						{continue;}
					if($fld=="hours"){@$total_hours+=$value;}
					echo "<td>$value</td>";
					}
				echo "</tr>";
				}
		
			$th=number_format($total_hours,1);
			echo "<tr><td colspan='6' align='right'>$th hours</td></tr>";
			echo "</table>";
			}
		exit;
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
		}
		$source_title=rtrim($source_title,",");
	//echo "$source_title";  exit;


	// Program categories
	mysql_select_db($database,$connection);
	$sql="SELECT * from program_categories where 1 order by cat_name";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());

	while($row=mysql_fetch_assoc($result))
		{
		$program_array[$row['prog_cat']]=$row['cat_name'];
		}


	echo "<table><tr><th colspan='5'><font color='gray'>Search DPR Training Database</font></th></tr></table>";


	$fld_array=array("name","class","date_completed","weblink");

	if(!isset($name)){$name="";}
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
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if(!empty($_REQUEST))	
	{
	$skip=array("submit","edit","u","sort","program","rep");
	$clause=1 ;
	foreach($_REQUEST AS $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(empty($value)){continue;}
		if($fld=="name")
			{
			$exp=explode("*",$name);
			@$value=$exp[1];
			$clause.=" and t1.emid='$value'";
			}
		if($fld=="class")
			{
			$exp=explode("*",$class);
			if(count($exp)>1)
				{
				$value=$exp[1];
				$fld=" and class_id";
				$clause.=" and class_id='$value'";
				}
				else
				{
				$fld=" and t2.title like '%$exp[0]%'";
				@$clause.=$fld." AND ";
				}
			}
		$value=addslashes($value);
		if($fld=="comments")
			{@$clause.=$fld." like '%".$value."%' AND ";}
	//	else
	//		{@$clause.=$fld."='".$value."' AND ";}
		
		}
	@$clause=rtrim($clause," AND ");
	
	if(!empty($_POST['program']))
		{
		$clause.=" and (";
		foreach($_POST['program'] as $k=>$v)
			{
			@$prog_clause.="t2.program like '%$v%' OR ";
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
		{$sort="date_completed ASC";}
//	if($sort=="title ASC"){$sort.=", date_completed";}
	
	$sql="SELECT  concat(t3.Lname,', ',t3.Fname) as name, t1.id, t2.program, t2.title, t1.date_completed, t4.file_name, t1.comments, t1.hours, t2.hrs_credits, t4.link
	from track as t1
	left join class as t2 on t1.class_id=t2.id
	left join divper.empinfo as t3 on t1.emid=t3.emid
	left join file_upload as t4 on t1.id=t4.track_id
	 where $clause 
	 order by $sort";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
//	echo "$sql<br /><br />";
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

// Program categories
mysql_select_db($database,$connection);
$sql="SELECT * from program_categories where 1 order by cat_name";
$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());

while($row=mysql_fetch_assoc($result))
	{
	$program_array[$row['prog_cat']]=$row['cat_name'];
	}
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

$skip=array("id","link");	
foreach($ARRAY[0] as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$k1=str_replace("_"," ",$k);
	
		$link="<form method='POST' action='migrate_training.php'>";
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

foreach($ARRAY as $index=>$array)
	{
	$id=$ARRAY[$index]['id'];
	
	$button="<form method='POST' action='update.php'>";
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
		if(in_array($fld,$skip)){continue;}
		if($fld=="hours"){@$total_hours+=$value;}
		if($fld=="file_name")
			{
		//	$file=$array['link'];
		//	$value="<a href='$file'>$value</a>";
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
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
$th=number_format($total_hours,1);
echo "<tr><td colspan='7' align='right'>$th hours</td></tr>";

echo "</table></form>";
/*
if(!empty($_POST['rep']))
{

}
*/

?>