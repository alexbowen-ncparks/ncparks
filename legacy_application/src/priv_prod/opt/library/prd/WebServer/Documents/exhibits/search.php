<?php
ini_set('display_errors', 1);
extract($_REQUEST);
if(empty($rep)){session_start();}
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


if(empty($connection))
	{
	$db="exhibits";
	include("../../include/iConnect.inc"); // database connection parameters
	}
if(empty($rep)){include("_base_top.php");}


//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

date_default_timezone_set('America/New_York');

$ti=$_SESSION['exhibits']['tempID'];

/*
$group=strtolower($_SESSION['exhibits']['group']);
$group_array=array();
if(!empty($group))
	{
	$sql="select emp_id from personnel where 1 and work_order_group='$group' order by last_name";
	$result = mysqli_query($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$group_array[]=$row['emp_id'];
		}
	 mysqli_free_result($result);
	 }
 */
 
$sql="select distinct section from work_order where 1 order by section";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$section_array[]=$row['section'];
	}
 mysqli_free_result($result);
if(empty($section_array)){echo "There are presently no work orders.";exit;}

$sql="select distinct misc_aspect from work_order where misc_aspect!='' order by misc_aspect";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$misc_aspect_array[]=$row['misc_aspect'];
	}
 mysqli_free_result($result);
 
$sql="select distinct time_aspect from work_order where time_aspect!='' order by time_aspect";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$time_aspect_array[]=$row['time_aspect'];
	}
 mysqli_free_result($result);
 
 if($level>1)
	 {
	$sql="select distinct emp_id from work_order where 1 order by emp_id";
	}
	else
	 {
	$sql="select distinct emp_id from work_order where 1 and emp_id='$ti'";
	}
$result = mysqli_query($connection,$sql);
$employee_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	$employee_array[]=$row['emp_id'];
	}
 mysqli_free_result($result);
	
$sql="select distinct category from work_order where 1 order by category";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$category_array[]=$row['category'];
	}
 mysqli_free_result($result);

$sql="select distinct emp_id from work_order_workers where 1 order by emp_id";
$result = mysqli_query($connection,$sql);
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
$result = mysqli_query($connection,$sql);
$routed_to_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	if(empty($row['rt'])){continue;}
	$routed_to_array[]=$row['rt'];
	}
 mysqli_free_result($result);

$sql="select distinct park_code from work_order where 1 order by park_code";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_code_array[]=$row['park_code'];
	}
 mysqli_free_result($result);

$today=date("Y-m-d");
$sql="select distinct due_date from work_order where 1 and due_date>='$today' order by due_date";
$result = mysqli_query($connection,$sql);
$due_date_search_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	$due_date_search_array[]=$row['due_date'];
	}
 mysqli_free_result($result);

// ******************* Form ********************
if(empty($rep))
	{
	echo "<table cellpadding='5'>
	<tr><th colspan='3' align='left'>Search Work Order Requests - $ti</th>";

	echo "<td><a href='mailto:sean.higgins@ncparks.gov?subject=Exhibits & Emerging Media Work Order'>Email</a> sean.higgins@ncparks.gov with any questions.</td></tr>";

	if(!empty($message))
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

	echo "<tr><td colspan='6'><input type='radio' name='date_completed' value='x' $ck1>$text_nc 
	<input type='radio' name='date_completed' value='y' $ck2>$text_c 
	<input type='radio' name='date_completed' value='z' $ck3>$text_b 
	</td></tr>";
if(!isset($work_order_number)){$work_order_number="";}
	echo "<td>Work Order Number:<br /><input type='text' name='work_order_number' value=\"$work_order_number\" size='10'></td>";
	echo "<td colspan='2'>Priority: ";
	foreach($time_aspect_array as $k=>$v)
			{
			$ck="";
			if(@$time_aspect==$v){$ck="checked";}
			echo " [<input type='radio' name='time_aspect' value='$v' $ck>$v] ";
			}
	echo "<br />";

	echo "Type: ";
	foreach($misc_aspect_array as $k=>$v)
			{
			$ck="";
			if(@$misc_aspect==$v){$ck="checked";}
			echo " [<input type='radio' name='misc_aspect' value='$v' $ck>$v] ";
			}
	echo "</td>";
	
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
	echo "</tr>";

if(!isset($proj_name)){$proj_name="";}
	echo "<tr><td colspan='5'>Project Name contains:<br /><input type='text' name='proj_name' value=\"$proj_name\" size='45'></td>";

	echo "<td valign='top'>Due Date >= Today:<br />
	<select name='due_date'><option selected=''></option>";
	foreach($due_date_search_array as $k=>$v)
		{
		if($due_date==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>";
		}
	echo "</select></td></tr></table>";

	echo "<table><td valign='top' colspan='3'>Category<br />";
	foreach($category_array as $k=>$v)
		{
		$ck="";
		$v1=$v;
		if(isset($_POST['category']))
			{
			if(in_array($v,$_POST['category'])){$ck="checked";}
			}
		if(empty($v)){$v1="Blank"; $ck="";}
		echo "<input type='checkbox' name='category[]' value='$v' $ck>$v1&nbsp;&nbsp;&nbsp;";
		}
	echo "</td></tr></table>";

	echo "<table><tr>
	<td valign='top' colspan='2'>Park: <select name='park_code'><option value='' selected></option>\n";
	foreach($park_code_array as $k=>$v)
		{
		$val=@$_POST['park_code'];
		if($v==$val){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
		}
	echo "</select></td>";

//	echo "<td valign='top'>Latitude: ";
//	echo "<select name='lat'><option selected=''></option>";
//	foreach($lat_search_array as $k=>$v)
//		{
//		if($_POST['lat']==$v){$s="selected";}else{$s="value";}
//		echo "<option $s=\"$v\">$v</option>";
//		}
//	echo "</select></td>";
//	echo "</td>";

	if(!isset($error_location_comment)){$error_location_comment="";}
	if(!isset($location_comment)){$location_comment="";}
	echo "<td valign='top'>Location Comments contain:<br /><textarea name='location_comment' rows='1' cols='20'>$location_comment</textarea></td>
	";

if(!isset($proj_description)){$proj_description="";}
	echo "
	<td colspan='3'>Project Description contains:<br /><textarea name='proj_description' rows='1' cols='25'>$proj_description</textarea></td>
	</tr>";

	$action="Find";
	echo "<tr>
	<td>";
	if(!empty($_POST)){echo "<input type='checkbox' name='rep' value='x'>Excel export";}
	
	echo "</td>
	<td><input type='submit' name='submit' value='$action'></td>
	</form>
	<form><td><input type='submit' name='submit' value='Reset'></td>
	</tr>
	</table></form>";
	}
//echo "<pre>"; print_r($_POST); echo "</pre>";

if(@$submit=="Reset"){exit;}


$skip=array("submit","due_date","date_completed","routed_to","rep", "sort", "direction");
	$like=array("work_order_number","proj_name","proj_description","location_comment","component_comment");

//$ct=$_POST['component_type'];
$due_date=@$_POST['due_date'];

$pass_criteria=array();
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
				$pass_criteria[$k][]=$v1;
				$clause1.="t1.".$k." like '%$v1%' $ct ";
				}
			$clause1=rtrim($clause1," $ct ").") ";
			@$clause.=$clause1;
			}
		else
			{
			if(in_array($k,$like))
				{
				$pass_criteria[$k]=$v;
				@$clause.="t1.".$k." like '%$v%' AND ";
				}
				else
				{
				$table="t1";
				$pass_criteria[$k]=$v;
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
	if(!isset($sort)){$sort="";}
	if($sort=="work_order_number" OR $sort=="work_order_#")
		{
		$order_by="order by t1.work_order_number";
		}
	if($sort=="routed_to_1")
		{
		$order_by="order by t1.routed_to_1 ";
		}
	if($sort=="time_aspect" OR $sort=="priority")
		{
		$order_by="order by t1.time_aspect ";
		}
	if($sort=="assigned_to")
		{
		$order_by="order by t2.emp_id ";
		}
	if(!isset($direction)){$direction="";}
	$order_by.=" ".$direction;
	
	$find_message="No request was found matching the above criterion/criteria.";

	if(!empty($clause))
		{$clause="and ".rtrim($clause," AND ");}
		else
		{$clause="";}
	
	if(!empty($due_date))
		{
		$pass_criteria['due_date']=$due_date;
		$clause.=" AND due_date>='".$due_date."' ";}
	//	{$clause.=" AND due_date>='".date("Y-m-d")."' ";}
		
	if(!empty($routed_to))
		{
		$pass_criteria['routed_to']=$routed_to;
		$clause.=" AND (routed_to_1='$routed_to' OR routed_to_2='$routed_to') ";
		}
		
	if(@$date_completed=="x")
		{
		$pass_criteria['date_completed']="x";
		$clause.=" AND date_completed ='' "; $pass_clause="&date_completed=x";}
	if(@$date_completed=="y")
		{
		$pass_criteria['date_completed']="y";
		$clause.=" AND date_completed !='' "; $pass_clause="&date_completed=y";}
	if(@$date_completed=="z")
		{
		$pass_criteria['date_completed']="z";
		$clause.=" AND (date_completed ='' OR date_completed !='') "; $pass_clause="&date_completed=z";}
		
	$submitted_by="";
	$ei=$_SESSION['exhibits']['tempID'];


	if($level==1)
		{
//		echo "<pre>"; print_r($group_array); echo "</pre>";  exit;
		$submitted_by="Work Orders:";
		if(empty($clause))
			{
			$clause=" and (date_completed is NULL OR date_completed='') ";
			}
	//	if($group=="basic")
	//		{
			@$clause.="and (t1.emp_id='$ei'";
			$clause.=" or t2.emp_id='$ei')";
	//		}
		}
	if($level==2)
		{
		@$clause.="and (t1.emp_id='$ei'";
		$clause.=" or t1.routed_to_1='$ei' or t1.routed_to_2='$ei'";
		$clause.=" or t2.emp_id='$ei' or t2.emp_id='$ei') ";
		if(empty($_POST)){$clause.=" and date_completed=''";}
		$submitted_by="Work Orders:";

		}	

	if($level>2)
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
		
		
// *********** Run Query *****************************************

$search_flds="t1.`work_order_id`, t1.`work_order_number`, t1.`category`, t1.`section`, t1.`park_code`, t1.`proj_name`, t1.`time_aspect`, t1.`date_submitted`, t1.`due_date`, t1.`emp_id`, t1.`routed_to_1`";

if(!isset($clause)){$clause="";}
//t1.* 
	$sql="select $search_flds $assignees
	from work_order as t1
	LEFT JOIN  work_order_workers as t2 on t1.work_order_number=t2.work_order_number
	where 1  $clause $where_level
	group by t1.work_order_number
	$order_by";
	
if(!empty($special_report))
	{
	//t1.* 
	$sql="select $seach_flds $assignees
		from work_order as t1
		LEFT JOIN  work_order_workers as t2 on t1.work_order_number=t2.work_order_number
		where 1  $clause 
		group by t1.work_order_number
		$order_by";
	}
//	echo "$sql  ";   //<br />c=$clause
//	echo "<pre>"; print_r($pass_criteria); echo "</pre>"; // exit;
	 //exit;
	if($result = mysqli_query($connection,$sql) or die(mysqli_error($connection)))
		{
		while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
		}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";
//	echo "<pre>"; print_r($_POST); echo "</pre>";

$skip=array("time","funding_source","assigned_number","time_proj_description","time_materials_costs","time_project_comments","proj_description_original","time_instructions","work_order_id");
if($level==1)
	{
	$skip2=array("instructions","time_aspect");
	$skip=array_merge($skip,$skip2);
	}
//,"proj_description_original"
$limit_text=array("instructions","proj_description","location_comment","project_comments");
$sort_fld=array("category","work_order_number","due_date","routed_to_1","time_aspect","assigned_to");

$time_aspect_array=array("1"=>"red","2"=>"yellow","3"=>"lightgreen","4"=>"aliceblue","none"=>"white");
$misc_aspect_array=array("New","Replace","Improve","M&R","On-going","Standard","On-hold");

$rename=array("work_order_id"=>"edit_view","date_submitted"=>"start_date","time_aspect"=>"priority","section"=>"for_section","misc_aspect"=>"type","work_order_number"=>"work_order_#","emp_id"=>"Requested by","routed_to_1"=>"Project Manager 1","routed_to_2"=>"Project Manager 2", "due_date"=>"Target Date");
@$count=count($ARRAY);

	if(empty($ARRAY))
		{
		echo "<font color='purple'>$find_message</font><br />";
		}
		else
		{
		if(!empty($rep))
			{
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=work_order.xls');
			}
		echo "<table border='1'>";
		if(empty($rep))
			{
			echo "<tr><td colspan='24'><font size='+1' color='green'>$submitted_by $count</font></td></tr>";
			}
//		echo "c=$pass_clause";
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$skip_excel=array("work_order_id");
		foreach($ARRAY as $index=>$array)
			{
			if($index==0)
				{ // Headers
				echo "<tr>";
				foreach($ARRAY[0] as $fld=>$val)
					{
					if(in_array($fld,$skip)){continue;}
					if(!empty($rep) and in_array($fld,$skip_excel)){continue;}
					$pass_sort=$fld;
					if(array_key_exists($fld,$rename)){$fld=$rename[$fld];}
					if(in_array($pass_sort,$sort_fld))
						{
						if(empty($rep))
							{
						//	$fld="<a href='search.php?sort=$pass_sort$pass_clause'>$fld</a>";
							$temp="\n<form method='POST'>";
							foreach($pass_criteria as $k=>$v)
								{
								if(is_array($v))
									{
									foreach($v as $k1=>$v1)
										{
										$name=$k."[]";
										$temp.="<input type='hidden' name='$name' value=\"$v1\">";
										}
									}
									else
									{$temp.="<input type='hidden' name='$k' value=\"$v\">";}
								
								}
							if(empty($direction) OR $direction=="DESC"){$direct="ASC";}else{$direct="DESC";}
							$temp.="<input type='hidden' name='sort' value='$pass_sort'>
							<input type='hidden' name='direction' value='$direct'>
							<input type='submit' name='submit' value='$fld' style=\"background:Tan\">
							</form>\n";
							$fld=$temp;
							}
						}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}

			echo "<tr>";
			foreach($array as $fld=>$val)
				{
				if(in_array($fld,$skip)){continue;}
				$td="";
				
				if(in_array($fld,$limit_text) and !empty($val))
						{$val=substr($val,0,75)."....";
					}
				if($fld=="work_order_number")
					{
					if(empty($rep))
						{
					$pass_id=$array['work_order_id'];
					$val="<a href='work_order_form.php?pass_id=$pass_id' target='_blank'><font size='+1'>$val</font></a>";
						}
					}
				if($fld=="proj_name")
					{
					$val="<font color='brown'>$val</font>";
					}
				if($fld=="date_completed")
					{$val="<font color='green'>$val</font>";}
					
				if($fld=="time_aspect") // priority
					{
					if(empty($val)){$val="none";}
					$td=" bgcolor='".$time_aspect_array[$val]."'";
					}
					
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
					$d=$dd_array[2]+0;  // must cast as an integer
					$m=$dd_array[1]+0;  // must cast as an integer
			//		echo "y=$y<pre>"; print_r($dd_array); echo "</pre>"; // exit;
					$val_due_date=mktime(0, 0, 0, $m,$d,$y);
					$seven_days_out=mktime(0, 0, 0, date("m") , date("d")+7, date("Y"));
						if($seven_days_out>$val_due_date)
						{$val="<font color='magenta'>$val</font>";}
					}
				echo "<td$td>$val</td>";
				}
			}
		echo "</tr>";
		}
		echo "</table>";


echo "</div>
</div></body></html>";

@mysqli_free_result($result);
mysqli_close($connection);

?>