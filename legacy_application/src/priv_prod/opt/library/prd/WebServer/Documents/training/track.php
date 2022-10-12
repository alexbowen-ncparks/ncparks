<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>"; print_r($_POST); echo "</pre>";
ini_set('display_errors',1);

$database="training";
include("../../include/auth.inc"); // used to authenticate users
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
$emid=$_SESSION[$database]['emid'];
// $level=$_SESSION[$database]['level'];
if(empty($_POST['rep']))
	{
	include("/opt/library/prd/WebServer/Documents/_base_top.php");
	}
// include("../../include/iConnect.inc");// database connection parameters
include("../../include/get_parkcodes_reg.php");

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
if(@$_POST['submit']=="Reset")
	{
	$_REQUEST=array();
	unset($_POST);
	$class="";
	$name="";
	}
if(empty($_POST['rep']))
	{
	mysqli_select_db($connection,'divper');
	$where="t2.currPark !=''";
	if($level==1 and $_SESSION['training']['working_title']!="Park Superintendent")
		{
		$where="t1.emid = '$emid'";
		}
	if($level==1 and ($_SESSION['training']['working_title']=="Park Superintendent")) 
	// allow ranger acting as PASU
// 	 or $_SESSION['training']['tempID']=="Coffman4471"
		{
		$var_park=$_SESSION['training']['select'];
		$multi_park=explode(",",$_SESSION['training']['accessPark']);
		if(count($multi_park)>1)
			{
			$temp="(";
			foreach($multi_park as $k=>$v)
				{
				$temp.="t2.currPark='".$v."' or ";
				}
			$where=rtrim($temp," or ").")";
			}
			else
			{
			$where.=" or t2.currPark='$var_park'";
			}
		}
		
		$sql="SELECT concat(t1.Lname,', ',t1.Fname,' ',t1.Mname,'-',t2.currPark,'*',t1.emid) as name
		from empinfo as t1
		LEFT JOIN emplist as t2 on t1.emid=t2.emid
		where $where
		order by t1.Lname, t1.Fname"; 
// 		echo "$sql";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		$source_name="";
		while($row=mysqli_fetch_assoc($result))
			{
			$source_name.="\"".$row['name']."\",";
			}
		$source_name=rtrim($source_name,",");


	extract($_REQUEST);

// Form ************************************
	// Classes
	$database="training";
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
	mysqli_select_db($connection,$database);
	$sql="SELECT * from program_categories where 1 order by cat_name";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));

	while($row=mysqli_fetch_assoc($result))
		{
		$program_array[$row['prog_cat']]=$row['cat_name'];
		}


	echo "<table><tr><th colspan='5'><font color='gray'>Search DPR Training Database</font></th></tr></table>";


	$fld_array=array("name","class","date_completed","weblink");

	if(!isset($name)){$name="";}
	echo "<form action='track.php' method='POST'><table>";

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
	
	if($emid=="710" or $level>4) // Thomas Crate
		{
		echo "<tr><td>IQS <input type='checkbox' name='iqs' value=\"x\"></td></tr>";
		}
		echo "<tr><td colspan='2' align='center'>";
		if(!empty($_POST))
			{echo "<input type='checkbox' name='rep' value='x'> Excel export";}
	
		echo "
		<input type='submit' name='submit' value='Find' style=\"background:yellow\">
		</td>
		<td><input type='submit' name='submit' value='Reset' style=\"background:aliceblue\"></td>
		</tr>";
	
	
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
		$ck_fld="";
		if(in_array($fld,$skip)){continue;}
		if(empty($value)){continue;}
		if($fld=="name")
			{
			$exp=explode("*",$name);
			@$value=$exp[1];
			$clause.=" and t1.emid='$value'";
			$ck_fld="name";
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
		$value=html_entity_decode($value);
		if($fld=="comments")
			{@$clause.=$fld." like '%".$value."%' AND ";}

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
	
	if($level==1 and $_SESSION['training']['working_title']!="Park Superintendent")
		{
	//	$clause.=" and t1.emid = '$emid'";
		}	
	if($level==1 and $ck_fld!="name" and $_SESSION['training']['working_title']=="Park Superintendent")
		{
		$var_park=$_SESSION['training']['select'];
		$multi_park=explode(",",$_SESSION['training']['accessPark']);
		if(count($multi_park)>1)
			{
			$temp="(";
			foreach($multi_park as $k=>$v)
				{
				$temp.="t5.currPark='".$v."' or ";
				}
			$clause.=" and ".rtrim($temp," or ").")";
			}
			else
			{
			$clause.=" and t5.currPark='$var_park'";
			}
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
		{$sort="name, title, date_completed ASC";}
//	if($sort=="title ASC"){$sort.=", date_completed";}

$iqs_fld="";
		if(($emid=="710" or $level>4)) // Thomas Crate
			{
			$iqs_fld="t1.iqs,";
			 if(!empty($iqs))
			 	{
				$clause.=" and iqs='Yes'";
			 	}
			}
	$sql="SELECT $iqs_fld concat( t3.Lname, ', ', t3.Fname ) AS name, t1.id, t2.program, t2.title, t1.date_completed, group_concat( t4.file_name SEPARATOR '*') AS file_name, t1.comments, t1.hours, t2.hrs_credits, group_concat( t4.link SEPARATOR '*') AS link, t5.currPark as Park
	
FROM track AS t1
LEFT JOIN class AS t2 ON t1.class_id = t2.id
LEFT JOIN divper.empinfo AS t3 ON t1.emid = t3.emid
LEFT JOIN divper.emplist AS t5 ON t1.emid = t5.emid
LEFT JOIN file_upload AS t4 ON t1.id = t4.track_id
	 where $clause and t5.currPark is NOT NULL
	 group by name, title
	 order by $sort";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
// echo "$sql<br /><br />";
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

// Program categories
mysqli_select_db($connection,$database);
$sql="SELECT * from program_categories where 1 order by cat_name";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
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
	echo "<th align='center'>$c</th><td colspan='11'>Click on a column header to sort.</td></tr><tr>";
	}

if($level>1)
	{
	echo "<th> </th>";
	}
	
$skip=array("id");
if(!empty($rep)){$skip[]="link";}

foreach($ARRAY[0] as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$k1=str_replace("_"," ",$k);
	
		$header_link="<form method='POST' action='track.php'>";
		if(!empty($name)){$header_link.="<input type='hidden' name='name' value='$name'>";}
		if(!empty($class)){$header_link.="<input type='hidden' name='class' value='$class'>";}
//		if($k=="date_completed" and $sort=="date_completed ASC"){$k.=" DESC";}else{$k.=" ASC";}
		if($sort==$k." ASC"){$k.=" DESC";}else{$k.=" ASC";}
		$header_link.="<input type='hidden' name='sort' value='$k'>";
		if(!empty($_POST['program']))
			{
			foreach($_POST['program'] as $var_k=>$var_v)
				{
				$header_link.="<input type='hidden' name='program[]' value='$var_v'>";
				}
			}
		$header_link.="<input type='submit' name='submit' value='$k1' style=\"background: #339933; color: #FFF\"></form>";
	
	echo "<th align='center'>";
		if(empty($_POST['rep']))
			{
			echo "$header_link";
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
	
		if((empty($_POST['rep']) and $_SESSION['training']['emid']==$id) or $level>1)
			{
			echo "<td>$button</td>";
			}
			
	foreach($array as $fld=>$value)
		{		
		if(in_array($fld,$skip)){continue;}
		if($fld=="hours"){@$total_hours+=$value;}
		if($fld=="file_name")
			{
			if((!empty($value) and $_SESSION['training']['emid']==$id) or $level>1)
				{
				$exp=explode("*",$value);
				$exp1=explode("*",$array['link']);
		//		echo "<pre>"; print_r($exp1); echo "</pre>"; // exit;
				$temp="";
				foreach($exp as $k=>$v)
					{
					$var_link=$exp1[$k];
					$temp.="<a href=\"$var_link\" target='_blank'>$v</a><br />";
					}
				$value=$temp;
				}
				else
				{$value="";}
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
		if($fld=="link" and !empty($value))
			{
			$temp="<a href=\"$value\" target='_blank'>Document</a><br />";
			$value=$temp;
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
$th=number_format($total_hours,1);
echo "<tr><td colspan='8' align='right'>$th hours</td></tr>";

echo "</table></form>";
/*
if(!empty($_POST['rep']))
{

}
*/

?>