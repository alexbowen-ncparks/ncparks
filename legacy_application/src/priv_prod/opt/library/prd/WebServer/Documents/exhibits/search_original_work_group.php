<?php
ini_set('display_errors', 1);
session_start();
extract($_REQUEST);
//echo "session<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "request<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

if(empty($connection_i))
	{
	$db="mns";
	include("../../include/connect_mysqli.inc"); // database connection parameters
	}

include("_base_top.php");

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$ti=$_SESSION['work_order']['tempID'];
$group=$_SESSION['work_order']['group'];
$group_array=array();
if(!empty($group))
{
$sql="select emp_id from personnel where 1 and work_order_group='$group' order by last_name";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$group_array[]=$row['emp_id'];
	}
 mysqli_free_result($result);
 }
 
$sql="select distinct section from work_order where 1 order by section";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$section_array[]=$row['section'];
	}
 mysqli_free_result($result);
if(empty($section_array)){echo "There are presently no work orders.";exit;}

$sql="select distinct misc_aspect from work_order where misc_aspect!='' order by misc_aspect";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$misc_aspect_array[]=$row['misc_aspect'];
	}
 mysqli_free_result($result);
 
$sql="select distinct time_aspect from work_order where time_aspect!='' order by time_aspect";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$time_aspect_array[]=$row['time_aspect'];
	}
 mysqli_free_result($result);
 
$sql="select distinct emp_id from work_order where 1 order by emp_id";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$employee_array[]=$row['emp_id'];
	}
 mysqli_free_result($result);
	
$sql="select distinct category from work_order where 1 order by category";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$category_array[]=$row['category'];
	}
 mysqli_free_result($result);

$sql="select distinct emp_id from work_order_workers where 1 order by emp_id";
$result = mysqli_query($connection_i,$sql);
$assigned_to_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	$assigned_to_array[]=$row['emp_id'];
	}
if($level==1)
	{
	$assigned_to_array=array($ti);
	}

 mysqli_free_result($result);

$sql="select distinct routed_to_1 as rt from work_order 
UNION 
select distinct routed_to_2 rt from work_order 
where 1 order by rt";
$result = mysqli_query($connection_i,$sql);
$routed_to_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	if(empty($row['rt'])){continue;}
	$routed_to_array[]=$row['rt'];
	}
 mysqli_free_result($result);

$sql="select distinct building from work_order where 1 order by building";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$building_array[]=$row['building'];
	}
 mysqli_free_result($result);
$sql="select distinct location from work_order where 1 order by location";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$location_search_array[]=$row['location'];
	}
 mysqli_free_result($result);

$today=date("Y-m-d");
$sql="select distinct due_date from work_order where 1 and due_date>='$today' order by due_date";
$result = mysqli_query($connection_i,$sql);
$due_date_search_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	$due_date_search_array[]=$row['due_date'];
	}
 mysqli_free_result($result);

// ******************* Form ********************
echo "<table cellpadding='5'>
<tr><th colspan='3' align='left'>Search Work Order Requests - $ti</th></tr>";

echo "
<tr><td><a href='mailto:christina.cucurullo@naturalsciences.org?subject=Exhibits & Emerging Media Work Order'>Email</a> Christina.Cucurullo@naturalsciences.org with any questions.</td></tr>";

if($message!="")
	{
	echo "<tr><td colspan='3'><font color='green'><h3>$message</h3></font>
	$won
	<font color='brown'>Click on the Submit Request link in nav menu to add another request.</font></td></tr>";
	$species="";
	$date="";
	$location="";
	$comments="";
	}
echo "</table>";

echo "<form name='submit' action='search.php' method='POST'>
<table cellpadding='5'>";

echo "<td>Work Order Number:<br /><input type='text' name='work_order_number' value=\"$work_order_number\" size='10'></td>";
echo "<td colspan='2'>Time Aspect: ";
foreach($time_aspect_array as $k=>$v)
		{
		$ck="";
		if($time_aspect==$v){$ck="checked";}
		echo " [<input type='radio' name='time_aspect' value='$v' $ck>$v] ";
		}
echo "<br />";

echo "Miscellaneous Aspect: ";
foreach($misc_aspect_array as $k=>$v)
		{
		$ck="";
		if($misc_aspect==$v){$ck="checked";}
		echo " [<input type='radio' name='misc_aspect' value='$v' $ck>$v] ";
		}
echo "</td>";
$ck1="checked";$ck3="";$ck2="";
$text_nc="<font color='red' size='+1'>Not Completed</font>";
$text_c="Completed";
$text_b="Both";
if(!empty($date_completed))
	{
	if($date_completed=="x")
		{$ck1="checked";  $text_nc="<font color='red' size='+1'>Not Completed</font>";}
		else
		{$text_nc="Not Completed";}
	if($date_completed=="y")
		{$ck2="checked";  $text_c="<font color='green' size='+1'>Completed</font>";}
		else
		{$text_c="Completed";}
	if($date_completed=="z")
		{$ck3="checked";  $text_b="<font color='purple' size='+1'>Both</font>";}
		else
		{$text_b="Both";}
	}

echo "<td><input type='radio' name='date_completed' value='x' $ck1>$text_nc 
<input type='radio' name='date_completed' value='y' $ck2>$text_c 
<input type='radio' name='date_completed' value='z' $ck3>$text_b 
</td>";
echo "</tr></table>";

echo "<table><tr><td>Submission by:<br />";
echo "<select name='emp_id'><option selected=''></option>";
foreach($employee_array as $k=>$v)
	{
	if($emp_id==$v){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>";
	}
if(!isset($error_emp_id)){$error_emp_id="";}
echo "</select></td>";

echo "<td>Section:<br />";
//if(empty($department_name)){$department_name=$department;}
echo "<select name='section'><option selected=''></option>";
foreach($section_array as $k=>$v)
	{
	if($section_name==$v){$s="selected";}else{$s="value";}
	echo "<option $s=\"$v\">$v</option>";
	}
if(!isset($error_section)){$error_section="";}
echo "</select></td>";

if($level>1)
	{
	echo "<td>Routed To:<br />";
	echo "<select name='routed_to'><option selected=''></option>";
	foreach($routed_to_array as $k=>$v)
		{
		if($routed_to==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>";
		}
	echo "</select></td>";
	}

if($level>1 or in_array($ti, $assigned_to_array))
	{
	echo "<td>Assigned To:<br />";
	echo "<select name='worker_id'><option selected=''></option>";
	foreach($assigned_to_array as $k=>$v)
		{
		if($worker_id==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>";
		}
	echo "</select></td>";
	}
echo "</tr></table>";

echo "<table><tr><td colspan='5'>Project Name contains:<br /><input type='text' name='proj_name' value=\"$proj_name\" size='45'></td></tr>";

echo "<tr><td valign='top'>Due Date >= Today:<br />
<select name='due_date'><option selected=''></option>";
foreach($due_date_search_array as $k=>$v)
	{
	if($due_date==$v){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>";
	}
echo "</select></td>";

echo "<td valign='top' colspan='3'>Category<br />";
foreach($category_array as $k=>$v)
	{
	$ck="";
	$v1=$v;
	if($category==$v){$ck="checked";}
	if(empty($v)){$v1="Blank"; $ck="";}
	echo "<input type='radio' name='category' value='$v' $ck>$v1&nbsp;&nbsp;&nbsp;";
	}
echo "</td></tr></table>";

echo "<table><tr><td valign='top' colspan='2'>Building: ";
foreach($building_array as $k=>$v)
	{
	$ck="";
	$val=$_POST['building'];
	if(@in_array($val,$building_array))
		{$ck="checked";}
	echo "<input type='checkbox' name='building[$v]' value='$v' $ck>$v ";
	}
echo "</td>";

echo "<td valign='top'>Location: ";
echo "<select name='location'><option selected=''></option>";
foreach($location_search_array as $k=>$v)
	{
	if($_POST['location']==$v){$s="selected";}else{$s="value";}
	echo "<option $s=\"$v\">$v</option>";
	}
echo "</select></td>";

if(!isset($error_location_comment)){$error_location_comment="";}
echo "<td valign='top'>Location Comments contain:<br /><textarea name='location_comment' rows='1' cols='20'>$location_comment</textarea></td>
</tr>";

echo "<tr>
<td colspan='3'>Project Description contains:<br /><textarea name='proj_description' rows='1' cols='25'>$proj_description</textarea></td>
</tr>";

$action="Find";
echo "<tr>
<td><input type='submit' name='submit' value='$action'></td></form>
<form><td><input type='submit' name='submit' value='Reset'></td>
</tr>
</table></form>";

//echo "<pre>"; print_r($_POST); echo "</pre>";

if($submit=="Reset"){exit;}


$skip=array("submit","due_date","date_completed","routed_to");
	$like=array("work_order_number","proj_name","proj_description","location_comment","component_comment","component_type","component_type");

$ct=$_POST['component_type'];
$due_date=$_POST['due_date'];
	foreach($_POST as $k=>$v)
		{
		if(empty($v) AND $k!="category"){continue;}
		if(in_array($k,$skip)){continue;}
		if(is_array($v))
			{
			$ct="OR";
			$clause1=" (";
			foreach($v as $k1=>$v1)
				{
				$clause1.="t1.".$k." like '%$v1%' $ct ";
				}
			$clause1=rtrim($clause1," $ct ").") ";
			@$clause.=$clause1;
			}
		else
			{
			if(in_array($k,$like))
			{@$clause.="t1.".$k." like '%$v%' AND ";}
			else
				{
				$table="t1";
				if($k=="worker_id")
					{
					$table="t2";
					$k="emp_id";
					}
				@$clause.=$table.".".$k."='$v' AND ";
				}
			}
		}
	
	$where_level="";
	$order_by="order by t1.due_date";
	if($sort=="work_order_id"){$order_by="order by t1.work_order_number DESC";}
	if($sort=="routed_to_1"){$order_by="order by t1.routed_to_1 ";}

	$find_message="No request was found matching the above criterion/criteria.";

	if(!empty($clause))
		{$clause="and ".rtrim($clause," AND ");}
	
	if(!empty($due_date))
		{$clause.=" AND due_date>='".date("Y-m-d")."' ";}
		
	if(!empty($routed_to))
		{$clause.=" AND (routed_to_1='$routed_to' OR routed_to_2='$routed_to') ";}
		
	if(@$date_completed=="x")
		{$clause.=" AND date_completed ='' "; $pass_clause="&date_completed=x";}
	if(@$date_completed=="y")
		{$clause.=" AND date_completed !='' "; $pass_clause="&date_completed=y";}
	if(@$date_completed=="z")
		{$clause.=" AND (date_completed ='' OR date_completed !='') "; $pass_clause="&date_completed=z";}
		
	$submitted_by="";
	$ei=$_SESSION['work_order']['tempID'];


	if($level==1)
		{
//		echo "<pre>"; print_r($group_array); echo "</pre>";  exit;
		$submitted_by="Work Orders:";
		if(empty($clause))
			{
			$clause=" and (date_completed is NULL OR date_completed='') ";
			if(!empty($group_array))
				{
				$gc="AND (";
				foreach($group_array as $k=>$v)
					{
					$gc.="t1.emp_id='".$v."' OR ";
					}
				$clause.=rtrim($gc," OR ").") ";
				$submitted_by.=" $group ";
				}
				else
				{
				@$clause.="and (t1.emp_id='$ei'";
				$clause.=" or t2.emp_id='$ei')";
				}
			}
		}
	if($level==2)
		{
		@$clause.="and (t1.emp_id='$ei'";
		$clause.=" or t1.routed_to_1='$ei' or t1.routed_to_2='$ei') ";
		$clause.=" or (t2.emp_id='$ei') ";
		if(empty($_POST)){$clause.=" and date_completed=''";}
		$submitted_by="Work Orders:";
		if($login==1)
			{
			$where_level="and (date_assigned is NULL OR date_assigned='') ";
			$find_message="At present you do not have any work orders awaiting assignment.";
			}
		}	

	if($level>4)
		{
		$submitted_by="Work Orders:";
		if(empty($clause))
			{
			$where_level=" and date_completed='' and (t1.routed_to_1='' and t1.routed_to_2='') OR (t1.routed_to_1='$ti' or t1.routed_to_2='$ti') ";
			if(empty($_POST)){$where_level.=" and date_completed=''";}
			$find_message="At present you do not have any work orders awaiting assignment.";
			}
		}
		
	if($level>3)
		{$assignees=", group_concat(distinct t2.emp_id,'-',t2.time SEPARATOR '<br />') as assigned_to";}
		else
		{$assignees="";}
		
		
// ***********
	$sql="select t1.* $assignees
	from work_order as t1
	LEFT JOIN  work_order_workers as t2 on t1.work_order_number=t2.work_order_number
	where 1  $clause $where_level
	group by t1.work_order_number
	$order_by";
//	echo "$sql<br />c=$clause";
	if($result = mysqli_query($connection_i,$sql) or die(mysqli_error($connection_i)))
		{
		while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
		}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";

$skip=array("time","funding_source","assigned_number","time_proj_description","time_materials_costs","time_project_comments","proj_description_original");
if($level==1)
	{
	$skip2=array("instructions");
	$skip=array_merge($skip,$skip2);
	}
//,"proj_description_original"
$limit_text=array("instructions","proj_description","location_comment");
$sort_fld=array("work_order_id","due_date","routed_to_1");
$count=count($ARRAY);

	if(empty($ARRAY))
		{
		echo "<font color='purple'>$find_message</font><br />";
		}
		else
		{
		echo "<table border='1'>
		<tr><td colspan='24'><font size='+1' color='green'>$submitted_by $count</font> </td></tr>";
//		echo "c=$pass_clause";
		foreach($ARRAY as $index=>$array)
			{
			if($index==0)
				{ // Headers
				echo "<tr>";
				foreach($ARRAY[0] as $fld=>$val)
					{
					if(in_array($fld,$skip)){continue;}
					if(in_array($fld,$sort_fld))
						{
						$fld="<a href='search.php?sort=$fld$pass_clause'>$fld</a>";
						}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}

			echo "<tr>";
			foreach($array as $fld=>$val)
				{
				if(in_array($fld,$skip)){continue;}
				if($fld=="work_order_id")
					{
					$val="<a href='work_order_form.php?pass_id=$val'>Edit/View</a>";
					}
					if(in_array($fld,$limit_text) and !empty($val))
						{$val=substr($val,0,50)."....";
					}
				if($fld=="work_order_number")
					{
					$val="<font color='green' size='+1'>$val</font>";
					}
				if($fld=="proj_name")
					{
					$val="<font color='brown'>$val</font>";
					}
				if($fld=="date_completed")
					{$val="<font color='green'>$val</font>";}
					
				if($fld=="due_date")
					{
					if($val<date("Y-m-d"))
						{
						$val="<font color='red'><del>$val</del></font>";
						}
					if($val==date("Y-m-d"))
						{
						$val="<font color='red'>$val</font>";
						}
					$dd_array=explode("-",$val);
					$y=$dd_array[0]+0;  // must cast as an integer
					$val_due_date=mktime(0, 0, 0, $dd_array[1],$dd_array[2],$y);
					$seven_days_out=mktime(0, 0, 0, date("m") , date("d")+7, date("Y"));
						if($seven_days_out>$val_due_date)
						{$val="<font color='magenta'>$val</font>";}
					}
				echo "<td>$val</td>";
				}
			}
		echo "</tr>";
		}
		echo "</table>";


echo "</div>
</div></body></html>";

@mysqli_free_result($result);
mysqli_close($connection_i);
?>