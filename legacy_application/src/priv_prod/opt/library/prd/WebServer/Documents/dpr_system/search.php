<?php
ini_set('display_errors', 1);
if($_POST['submit']=="Reset"){unset($_REQUEST);}
@extract($_REQUEST);
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

if(empty($connection_i))
	{
	$db="denr";
	include("../../include/connect_mysqli.inc"); // database connection parameters
	}

if(empty($rep)){include("_base_top.php");}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$ti=$_SESSION['denr_parking']['tempID'];
$group=strtolower($_SESSION['denr_parking']['group']);
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
 
$sql="select distinct division from denr_parking where 1 order by division";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$division_array[]=$row['division'];
	}
 mysqli_free_result($result);
if(empty($division_array)){echo "There are presently no parking allocated.";exit;}

$sql="select distinct last_name as name from denr_parking where 1 and last_name!='' order by last_name";
$result = mysqli_query($connection_i,$sql);
$source_name="";
while($row=mysqli_fetch_assoc($result))
	{
	$source_name.="\"".$row['name']."\",";
	}
 mysqli_free_result($result);
 
$sql="select distinct lot from denr_parking where lot!='' order by lot";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$lot_array[]=$row['lot'];
	}
 mysqli_free_result($result);
 
/*
$sql="select distinct time_aspect from denr_parking where time_aspect!='' order by time_aspect";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$time_aspect_array[]=$row['time_aspect'];
	}
 mysqli_free_result($result);
 
 if($group=="moderate" OR $group=="advanced")
	 {
	$sql="select distinct emp_id from denr_parking where 1 order by emp_id";
	}
	else
	 {
	$sql="select distinct emp_id from denr_parking where 1 and emp_id='$ti'";
	}
$result = mysqli_query($connection_i,$sql);
$employee_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	$employee_array[]=$row['emp_id'];
	}
 mysqli_free_result($result);
	
$sql="select distinct category from denr_parking where 1 order by category";
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


$sql="select distinct routed_to_1 as rt from denr_parking 
UNION 
select distinct routed_to_2 rt from denr_parking 
where 1 order by rt";
$result = mysqli_query($connection_i,$sql);
$routed_to_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	if(empty($row['rt'])){continue;}
	$routed_to_array[]=$row['rt'];
	}
 mysqli_free_result($result);

$sql="select distinct building from denr_parking where 1 order by building";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$building_array[]=$row['building'];
	}
 mysqli_free_result($result);
$sql="select distinct location from denr_parking where 1 order by location";
$result = mysqli_query($connection_i,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$location_search_array[]=$row['location'];
	}
 mysqli_free_result($result);

$today=date("Y-m-d");
$sql="select distinct due_date from denr_parking where 1 and due_date>='$today' order by due_date";
$result = mysqli_query($connection_i,$sql);
$due_date_search_array=array();
while($row=mysqli_fetch_assoc($result))
	{
	$due_date_search_array[]=$row['due_date'];
	}
 mysqli_free_result($result);
*/
// ******************* Form ********************

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if(empty($rep))
	{
	echo "<table cellpadding='5'>
	<tr><th colspan='3' align='left'>Search DENR Parking</th></tr>";

	echo "
	<tr><td><a href='mailto:pamela.witt@ncdenr.gov.org?subject=parking_database'>Email</a> Pam Witt with any questions.</td></tr>";
	echo "</table>";


	echo "<form name='submit' action='search.php' method='POST'>
	<table cellpadding='5'>";

	echo "<tr>";
	
	echo "<td>Lot:<br />";
	echo "<select name='lot'><option selected=''></option>";
	foreach($lot_array as $k=>$v)
		{
		if($lot===$v){$s="selected";}else{$s="";}
		echo "<option value=\"$v\" $s>$v</option>";
		}
	if(!isset($error_lot)){$error_lot="";}
	echo "</select></td>";
	
	echo "<td>Space:<br /><input type='text' name='space' value=\"$space\"></td>";


	echo "<td>Division:<br />";
	echo "<select name='division'><option selected=''></option>";
	foreach($division_array as $k=>$v)
		{
		if($division==$v){$s="selected";}else{$s="";}
		echo "<option value=\"$v\" $s>$v</option>";
		}
	if(!isset($error_division)){$error_division="";}
	echo "</select></td>";

	echo "<td>Last Name:<br /><input id='last_name' type='text' name='last_name' value=\"$last_name\"></td>";

	echo "
	<script>
		$(function()
			{
			$( \"#last_name\" ).autocomplete({
			source: [ $source_name ]
				});
			});
		</script>";
		
		
	echo "<td>Transponder:<br /><input type='text' name='transponder_GS' value=\"$transponder_GS\"></td>";

	echo "</tr></table>";

	
	$action="Find";
	echo "<tr>";
	
	if(!empty($_POST)){echo "<td><input type='checkbox' name='rep' value='x'>Excel export</td>";}
	
	echo "
	<td><input type='submit' name='submit' value='$action'></td>
	
	<td><input type='submit' name='submit' value='Reset'></td>
	</tr>
	</table></form>";
	}
//echo "<pre>"; print_r($_POST); echo "</pre>";

if(@$submit!="Find" and @$pass_submit!="Find"){exit;}


$skip=array("submit","due_date","date_completed","routed_to","rep", "sort", "direction", "pass_submit");
	$like=array("work_order_number","proj_name","proj_description","location_comment","component_comment","component_type","component_type");

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$pass_criteria=array();
$clause="";
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
		$clause="AND ".rtrim($clause," AND");
		}
	
	$order_by="";
	if(!empty($_POST['sort']))
		{
		$order_by="order by ".$_POST['sort']." ".$_POST['direction'];
		}

		
	$submitted_by="";
	$ei=$_SESSION['denr_parking']['tempID'];

		
// *********** Run Query *****************************************
	$sql="select t1.* 
	from denr_parking as t1
	where 1 $clause 
	$order_by
	";

//	echo "$sql  ";   //<br />c=$clause
//	echo "<pre>"; print_r($pass_criteria); echo "</pre>"; // exit;
	 //exit;
	if($result = mysqli_query($connection_i,$sql) or die(mysqli_error($connection_i)))
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
$sort_fld=array("work_order_number","due_date","routed_to_1","time_aspect","assigned_to");

$time_aspect_array=array("1"=>"red","2"=>"yellow","3"=>"lightgreen","4"=>"aliceblue");
$misc_aspect_array=array("New","Replace","Improve","M&R","On-going","Standard","On-hold");

$rename=array("work_order_id"=>"edit_view","date_submitted"=>"start_date","time_aspect"=>"priority","section"=>"for_section","misc_aspect"=>"type","work_order_number"=>"work_order_#","emp_id"=>"Requested by","routed_to_1"=>"Project Manager 1","routed_to_2"=>"Project Manager 2");
$count=count($ARRAY);

	if(empty($ARRAY))
		{
		echo "<font color='purple'>$find_message</font><br />";
		}
		else
		{
		if(!empty($rep))
			{
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=denr_parking.xls');
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
					if(!in_array($pass_sort,$sort_fld))
						{
						if(empty($rep))
							{
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
							<input type='hidden' name='pass_submit' value='Find'>
							<input type='submit' name='submit' value='$fld' style=\"background:Tan\">
							</form>\n";
							$fld=$temp;
							}
						}
					echo "<th bgcolor='beige' align='center'>$fld</th>";
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
					{$td=" bgcolor='".$time_aspect_array[$val]."'";}
					
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
				echo "<td$td>$val</td>";
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