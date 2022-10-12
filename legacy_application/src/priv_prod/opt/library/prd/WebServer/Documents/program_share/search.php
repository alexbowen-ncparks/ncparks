<?php
ini_set('display_errors',1);


if(empty($_POST['rep']))
	{
	$database="program_share";
	$title="I&E Mind Meld";
	include_once("../_base_top.php");// includes session_start();
	}
//echo "<pre>"; print_r($_SERVER); print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
$level=@$_SESSION['program_share']['level'];
//if($level<1){echo "You do not have access to this database. Contact Tom Howard for more info. tom.howard@embarqmail.com"; exit;}

$user=strtolower(@$_SESSION['program_share']['tempID']);
//$level=4;

$db="program_share";
include("../../include/iConnect.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");

if(empty($_POST['rep']))
	{
	echo "<table cellpadding='5'>
	<tr><th colspan='3' align='left'>I&E Mind Meld - Search</th></tr>
	</table>";
	$rep="";
	}
	else
	{
	$rep=1;
	}


if($_REQUEST==""){exit;}

$sql="SELECT * from resource";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)."<br />$sql");
while($row=mysqli_fetch_assoc($result))
	{
	$resource_name_array[$row['resource_id']]=$row['resource_name'];
	}
	
$sql="SELECT t1.resource_id
from `item` as t1 ";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$temp=$row['resource_id'];
	$exp=explode(",",$temp);
	foreach($exp as $k=>$v)
		{$resource_array[$v]=$resource_name_array[$v];}	
	}
//echo "<pre>"; print_r($resource_array); echo "</pre>"; // exit;		

$sql="SELECT t2.* 
from `item` as t1 
left join `subject` as t2 on t2.subject_id=t1.subject_id
order by `subject`, `subject`";
//$sql="SELECT * from `subject` order by `category`, `subject`";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$subject_array[$row['subject']]=$row['subject'];
	$topic_array[$row['subject_id']]=$row['topic'];
	}

if(empty($subject_array))
	{echo "Under development."; exit;}
	asort($subject_array);
//echo "<pre>"; print_r($subject_array); echo "</pre>"; // exit;		
	
	asort($topic_array);
$sql="SELECT program_title,submitter from `item` order by `program_title`";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$program_title_array[]=$row['program_title'];
	$submitter_array[$row['submitter']]=$row['submitter'];
	}	
	
	 echo "<form method='POST' action='search.php'><table>";
	 
	 echo "<tr><td>Resource Type:</td><td><select name='resource_id'><option selected=''></option>\n";
	 foreach($resource_array as $k=>$v)
	 	{
	 	echo "<option value='$k'>$v</option>\n";
	 	}
	 echo "</select></td></tr>";
	 	
//	  echo "<pre>"; print_r($category_array); echo "</pre>"; // exit;
	 echo "<tr><td>Subject:</td><td><select name='subject'><option selected=''></option>\n";
	 foreach($subject_array as $k=>$v)
	 	{
	 	echo "<option value='$k'>$v</option>\n";
	 	}
	 echo "</select></td></tr>";
	 
	 echo "<tr><td>Topic:</td><td><select name='subject_id'><option selected=''></option>\n";
	 foreach($topic_array as $k=>$v)
	 	{
	 	echo "<option value=\"$k\">$v</option>\n";
	 	}
	 echo "</select></td></tr>";
	 
	 echo "<tr><td>Program Title:</td><td><select name='program_title'><option selected=''></option>\n";
	 foreach($program_title_array as $k=>$v)
	 	{
	 	if(empty($v)){continue;}
	 	echo "<option value=\"$v\">$v</option>\n";
	 	}
	 echo "</select></td></tr>";
	 
	 echo "<tr><td>Submitted by:</td><td><select name='submitter'><option selected=''></option>\n";
	 foreach($submitter_array as $k=>$v)
	 	{
	 	if(empty($v)){continue;}
	 	echo "<option value=\"$v\">$v</option>\n";
	 	}
	 echo "</select></td></tr>";
	 
	
	 echo "<tr><td colspan='2' align='center'>
	 <input type='submit' name='submit' value='Find' style='background-color:#66FF33'></td>
	 <td><input type='submit' name='submit' value='Reset'>
	 </td></tr>";
	
	echo "</table></form><hr />";

	
// ************************************************************
if(!empty($_GET)){$_POST=$_GET;}
if(isset($_POST['submit']) and $_POST['submit']=="Find")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//	$t2_array=array("resource_id");
	$t3_array=array("subject","topic");
	$skip_post=array("submit");
	$like=array("employee_name","resource_id");
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$skip_post)){continue;}
		if(empty($val)){continue;}

		$t="t1";
//		if(in_array($fld, $t2_array)){$t="t2";}
		if(in_array($fld, $t3_array)){$t="t3";}
		if(in_array($fld, $like))
			{@$clause.=$t.".$fld like '%$val%' and ";}
			else
			{@$clause.=$t.".$fld='$val' and ";}
		
		}
	if(!empty($clause))
		{$clause=" and ".rtrim($clause," and ");}
		else
		{$clause="";}
	
	}
	
if(!empty($_POST['clause']))
	{
	$clause=$_POST['clause'];
	}
//	echo "$clause";

$direction="";
if(!empty($_POST['direction']))
	{
	$direction=$_POST['direction'];
	}
	
$order_by="";	
if(isset($clause))
	{
	if(!empty($sort_by))
		{
		$order_by="order by $sort_by";
		}
	
	$sql="SELECT t1.item_id, t1.resource_id, t3.subject, t3.topic, t1.program_title, t1.description, t1.submitter, t4.thumb_link
	FROM item as t1
	left join subject as t3 on t1.subject_id=t3.subject_id
	left join item_upload_thumb as t4 on t1.item_id=t4.item_id
	where 1 $clause
	$order_by $direction"; 
//		echo "$sql";

	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)."<br />$sql");
	while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
	if(empty($ARRAY)){echo "Nothing found.";}
	}

if(!isset($ARRAY)){echo "</div></body></html>";exit;}

//echo "c=$clause";

$skip=array("method","date_c","enter_by","");
$c=count($ARRAY);

if($c>1000){$limited="but only the first 1,000 are shown.";}else{$limited="are shown.";}

if(!empty($rep))
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=nc_state_parks_programs.xls');
	echo "<table>";
	}
else
	{
	$c<2?$records="record":$records="records";
	$c<2?$limited="is shown.":$limites="are shown.";
	echo "<table border='1' cellpadding='3'><tr><td colspan='8'>".number_format($c,0)." $records $limited</td>";
//	<td><form method='POST' action='search.php'>
//	<input type='hidden' name='clause' value=\"$clause\">
//	<input type='submit' name='rep' value='Excel Export $c $records'>
//	</form></td>
	echo "</tr>";
	}
$rename_fld=array("resource_id"=>"resource","thumb_link"=>"");
foreach($ARRAY AS $index=>$array)
	{
	if($index>1000 and empty($rep)){break;}
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$new_fld=str_replace("_"," ",$fld);
			if(array_key_exists($fld,$rename_fld))
				{$new_fld=$rename_fld[$fld];}
			if(@$_POST['direction']=="ASC")
				{
				$direction="DESC";
				$color="Yellow";
				}
				else
				{
				$direction="ASC";
				$color="Tan";
				}
			$sort_col="<form action='search.php' method='POST'>
			<input type='hidden' name='sort_by' value=\"$fld\">
			<input type='hidden' name='direction' value=\"$direction\">
			<input type='hidden' name='clause' value=\"$clause\">
			<input type='submit' name='submit' value='$new_fld' style=\"background:$color\">
			</form>";
			if($fld=="item_id")
				{$sort_col="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}
			if($fld=="thumb_link")
				{$sort_col="";}
			echo "<th valign='bottom'>$sort_col</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="item_id")
			{
			$value="<a href='program.php?item_id=$value'>[ View ]</a>";
			}
		if($fld=="thumb_link")
			{
			if(!empty($value))
				{$value="<img src='$value' width='250'>";}	
			}
		if($fld=="resource_id")
			{
			$exp=explode(",",$value);
			$var="";
			foreach($exp as $k=>$v)
				{
				$var.="[".$resource_array[$v]."] ";
				}
			$value=$var;
			}
		echo "<td valign='top'>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

if(empty($rep))
	{
	echo "</div>
	</div></body></html>";
	}

?>