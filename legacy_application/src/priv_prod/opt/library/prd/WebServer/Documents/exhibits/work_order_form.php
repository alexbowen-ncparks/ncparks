<?php
ini_set('display_errors', 1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
		$findThis="MSIE ";
		$browser=$_SERVER['HTTP_USER_AGENT'];
	$pos=strpos($browser,$findThis);
		if($pos>0){$email_sep=";";}else{$email_sep=",";}
	//	echo "p=$browser";
		$findThis="http:";
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}
date_default_timezone_set('America/New_York');

include("../../include/get_parkcodes_i.php");

$db="exhibits";
if(empty($connection))
	{
	include("../../include/iConnect.inc"); // database connection parameters
	}

include("_base_top.php");

mysqli_select_db($connection,$db);

//echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
if(empty($emp_id) OR $level==1)
	{
	$emp_id=$_SESSION['exhibits']['tempID'];
	$login_user=$_SESSION['exhibits']['tempID'];
	}


//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

if(@$_POST['submit']=="Void")
	{
	include("void_request.php");
	echo "<h2> Your work order number $work_order_number is now VOID.</h2>";
	exit;
	}

$sql="SELECT tempID as emp_id, email, Fname
	FROM divper.nondpr
	where exhibits>0
	order by Lname, Fname"; //echo "$sql";
 $result = mysqli_query($connection,$sql) or die(mysqli_error($connection)." Q=".$sql);
 $source="";
 $assign_to_source="";
 if(mysqli_num_rows($result)>0)
 	{
 while($row=mysqli_fetch_assoc($result))
		{
		$var=$row['emp_id']."*".$row['Fname'];
		$source.="\"".$var."\",";
		$exhibit_staff_email[$row['emp_id']]=$row['email'];
		$assign_to_source.="\"".$var."\",";
		$employee_array[]=$row['emp_id'];
		}
 	}

$sql="SELECT t2.tempID as emp_id, t2.email, t2.Fname
	FROM divper.emplist as t1
	left join divper.empinfo as t2 on t1.tempID=t2.tempID
	where 1
	order by t2.Lname, t2.Fname";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)." Q=".$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$var=$row['emp_id']."*".$row['Fname'];
		$source.="\"".$var."\",";
		$exhibit_staff_email[$row['emp_id']]=$row['email'];
		}
	$source=rtrim($source,",");  //echo "s=$source"; exit;
 mysqli_free_result($result);

$sql="SELECT t2.tempID as emp_id, t2.Fname
	FROM divper.emplist as t1
	left join divper.empinfo as t2 on t1.tempID=t2.tempID 
	where 1
	order by t2.Lname, t2.Fname";
$result = mysqli_query($connection,$sql);

while($row=mysqli_fetch_assoc($result))
		{
		$var=$row['emp_id']."*".$row['Fname'];
		$assign_to_source.="\"".$var."\",";
		}
	$assign_to_source=rtrim($assign_to_source,",");
//echo "$assign_to_source"; // exit;
 mysqli_free_result($result);
 
$category_array=array("General Information Display","Interpretive Display","Poster Design","Multimedia/Computer Interactive","Lighting","Exhibit Repair","Interpretive Brochure","Outdoor Discovery Area","Other");
$sql="select distinct category from exhibits.work_order where 1 order by category";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)." Q=".$sql);
while($row=mysqli_fetch_assoc($result))
	{
	if(!in_array($row['category'],$category_array))
		{$category_array[]=$row['category'];}	
	}
 mysqli_free_result($result);
$time_aspect_array=array("Extreme"=>"1","High"=>"2","Medium"=>"3","Low"=>"4");
$misc_aspect_array=array("new (we've never had this before)","reprint without changes","reprint with changes","Repair");

$sql="select distinct misc_aspect from exhibits.work_order where misc_aspect!='' order by misc_aspect";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	if(!in_array($row['misc_aspect'],$misc_aspect_array))
		{$misc_aspect_array[]=$row['misc_aspect'];}	
	}
//echo "<pre>"; print_r($misc_aspect_array); echo "</pre>"; // exit;
 mysqli_free_result($result);
	
if(!empty($emp_id))   // emp_id = tempID
	{
	$test=urldecode($emp_id);
	$sql="select t1.* , t2.currPark
	from divper.empinfo as t1
	left join divper.emplist as t2 on t1.tempID=t2.tempID
	where t1.tempID='$test'"; //echo "$sql<br />";
	$result = mysqli_query($connection,$sql);
	if(mysqli_num_rows($result)>0)
		{
		$emp_info=mysqli_fetch_assoc($result);
		$first_name=$emp_info["Fname"];
		$last_name=$emp_info["Lname"];
		$section=$emp_info["currPark"];
	//	$email=$emp_info["email"];
		}
	$sql="select Fname, Lname, email, currPark, wphone as phone
	from divper.nondpr
	where tempID='$test'"; //echo "$sql<br />";
	$result = mysqli_query($connection,$sql);
	if(mysqli_num_rows($result)>0)
		{
		$emp_info=mysqli_fetch_assoc($result);
		$first_name=$emp_info["Fname"];
		$last_name=$emp_info["Lname"];
		$section=$emp_info["currPark"];
		$phone=$emp_info["phone"];
	//	$email=$emp_info["email"];
		}
	
 mysqli_free_result($result);
	}  
	
$sql="select tempID as emp_id 
from divper.emplist 
where 1
order by tempID";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$employee_array[]=$row['emp_id'];
//	$group_array[$row['emp_id']]=$row['work_order_group'];
	}
 mysqli_free_result($result);
$tempID=$_SESSION['exhibits']['tempID'];  // used to compare against work order around line

if(empty($pass_id))
	{echo "<body>";}
	else
	{echo "<body onload=\"scrollWindow()\">";}


echo "<table cellpadding='5'>
<tr><th colspan='3' align='left'>Work Order login is $tempID</th>";

echo "</tr>
<tr><td><font size='+2'>Please submit requests 3 -- 4 weeks prior to date needed.</font><br />
 **<font color='red'>All graphic, text, and multimedia intended for public display must be reviewed by the PIO.</font>**</td></tr>";
 
echo "<tr><td><a href='mailto:sean.higgins@ncparks.gov?subject=Exhibits Work Order'>Email</a> sean.higgins@ncparks.gov with any questions.</td></tr>";

if(!empty($error))
	{
	echo "<tr><td colspan='3'><font color='green'><h3>$error</h3></font>
	$won
	<font color='brown'>Click on the Submit Request link in nav menu to add another request.</font></td></tr>";
	}
echo "</table>";

$assigned_array=array();
if(!empty($pass_id))
	{
	// get request
	$sql="select * from exhibits.work_order where work_order_id='$pass_id'";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$found_row=mysqli_fetch_assoc($result);
	extract($found_row);
	
	if(!empty($routed_to_1) or !empty($routed_to_1))
		{
		if($level<2)
			{
			if($routed_to_1==$login_user){$level=2;}
			if($routed_to_2==$login_user){$level=2;}
			}
		}
		
	if(!empty($emp_id))
		{
		$test=urldecode($emp_id);
		$sql="select * from divper.empinfo where tempID='$test'";
		if($result = mysqli_query($connection,$sql))
			{
			$emp_info=mysqli_fetch_assoc($result);
		//	echo "<pre>"; print_r($emp_info); echo "</pre>"; // exit;
			}
		}

	$sql="select emp_id, time, email_sent, completed, work_done
		from exhibits.work_order_workers 
		where work_order_number='$work_order_number'";
	$result = mysqli_query($connection,$sql);
	$j=0;
//	$worker_array=array();
	while($row=mysqli_fetch_assoc($result))
		{
		$j++;
		$assigned_array[$row['emp_id']]=$row['time'];
		$worker_array[]=$row['emp_id'];
		${"assigned_to_".$j}=$row['emp_id'];
		${"time_worked_".$j}=$row['time'];
		${"email_sent_".$j}=$row['email_sent'];
		${"completed_".$j}=$row['completed'];
		${"work_done_".$j}=$row['work_done'];
		if($row['time']=="0.00" OR  $row['completed']=="")
			{
			@$hide_date_completed=1;
			}
		}
	
//echo "<pre>"; print_r($found_row); echo "</pre>";
	
	// get any supporting files
	$sql="select * from exhibits.file_upload where pass_id='$pass_id'";
	$result = mysqli_query($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$found_files['old_name'][$row['file_num']]=$row['old_name'];
		$found_files['link'][$row['file_num']]=$row['link'];
		}
	//echo "<pre>"; print_r($found_files); echo "</pre>";
	}

echo "<form name=\"autoSelectForm\" ' action='work_order_action.php' method='POST' enctype='multipart/form-data' onsubmit=\"return validateForm()\">
<table cellpadding='5'>";

if(!empty($work_order_number))
	{
	if(empty($message)){$message="";}
	echo "<tr><td>Work Order Number:</td><td><font color='green' size='+2'>$work_order_number</font>$message</td>";
	}

echo "<td>Submission by: ";

if($level==1 and $emp_id != $tempID and !in_array($tempID,$worker_array))
	{
		echo "$emp_id <font color='red'><strong><br />You are not permitted to edit another employee's Work Order. Contact Sean Higgins with any question.</strong></font>";
		exit;
	}
else
	{
$req="";
if(empty($work_order_number) or $level<5)
	{
	$jump="onChange=\"MM_jumpMenu('parent',this,0)\"";
	$var_select="link";
	}
	else
	{
	$jump="";
	$var_select="value";
	}
if(empty($emp_id)){$req="<font color='red'>required</font>";}
	echo "<select name='emp_id' $jump><option selected=''></option>\n";
	foreach($employee_array as $k=>$v)
		{
		$test=stripslashes(urldecode($emp_id));
		if($test==$v){$s="selected";}else{$s="value";}
		$encode_v=urlencode($v);
		if($var_select=="value")
			{
			echo "<option $s='$v'>$v</option>\n";
			}
			else
			{
			echo "<option $s='work_order_form.php?emp_id=$encode_v'>$v</option>\n";
			}
		}
	if(!isset($error_emp_id)){$error_emp_id="";}
	echo "</select> $req $error_emp_id</td>";
	}
echo "</tr><tr>";

if(@!empty($emp_info['email']) or @!empty($emp_info['section']))
	{
	extract($emp_info);
//	$pass_branch=$branch;
//	$pass_section=$section;
	if($phone=="919-733-7450")
		{$phone="Ext. $phone_ext";}
	$amp=urlencode("&");
	$pass_email=$email;
	if(!empty($pass_id))
		{
		$link="http://www.dpr.ncparks.gov/exhibits/work_order_form.php?pass_id=$pass_id";
		}
		else
		{$link="";}
	if(empty($pass_email))
		{$pass_email="<font color='red'>No email on record.</font>";}
	echo "<td colspan='2'>$Fname $Lname<br />Phone: $phone<br />Park/Section: $section<br />Email: <a href=\"mailto:$email?Subject=Exhibits Program Work Order&body=$link\">$email</a></td>";
	//<br />Title: $working_title
	}

echo "<td>Email: ";
if(empty($email))
	{echo "<font color='red'>No email address for $emp_id.</font></td>";}
	else
	{
	if(!empty($work_order_number))
		{
		echo "<a href='mailto:$email?subject=$emp_id Work Order: $work_order_number - $proj_name&body=Your work order request has been completed.'>$email</a>";
		}
	echo "<br /><font color='green'>We will notify you when order has been completed.</font></td>";
	}
echo "</tr>";

if(empty($date_submitted))
	{
	date_default_timezone_set('America/New_York');
	$date_submitted=date('Y-m-d');
	}

// see _base_top.php for jquery datepicker
echo "<tr><td>Request Date:</td><td><input type='text' name='date_submitted' value=\"$date_submitted\" READONLY></td></tr>";

$RO="";
$var_input_id="datepicker1";
if(!isset($due_date)){$due_date="";}

if($level<2 and !empty($routed_to_1)){$var_input_id="due_date_input"; $RO="READONLY";}
echo "<tr><td align='center'><font color='brown' font size='+1'>Target Date:</font><br /><input id=\"$var_input_id\" type='text' name='due_date' value=\"$due_date\" size='12' $RO></td>";


if($level>1)
	{
	if(empty($date_completed)){$date_completed="";}
	echo "<td align='center'><font color='brown' font size='+1'>Date Completed:</font><br /><input id=\"datepicker2\" type='text' name='date_completed' value=\"$date_completed\" size='12' $RO></td>";

	}
	else
	{
	if(empty($date_completed) AND !empty($due_date))
		{$date_completed="<br />not yet";}
		else
		{$date_completed="<br />not started";}
	echo "<td align='center'><font color='brown' font size='+1'>Date Completed:</font> $date_completed </td>";
	}
//if(empty($pass_id) OR $level>1)
	if(!isset($time_aspect)){$time_aspect="";}
	if(!isset($misc_aspect)){$misc_aspect="";}
if($level>1)
	{
	echo "<td><strong>Priority:</strong> 1 is Critical";
	foreach($time_aspect_array as $k=>$v)
		{
		$ck="";
		if(empty($time_aspect) AND $v=="Standard"){$ck="checked";}
		if($time_aspect==$v){$ck="checked";}
		echo " [<input type='radio' name='time_aspect' value='$v' $ck>$v] ";
		}
		echo "<br /><strong>Project Type:</strong><br />";
	foreach($misc_aspect_array as $k=>$v)
		{
		$ck="";
		if(empty($misc_aspect) AND $v=="New"){$ck="checked";}
		if($misc_aspect==$v){$ck="checked";}
		echo " [<input type='radio' name='misc_aspect' value=\"$v\" $ck>$v] ";
		}
	echo "</td>";
	}
	else
	{
	$size=1;
	$color="";
	
	$color_array=array("Extreme"=>"red","High"=>"yellow","Medium"=>"green","Low"=>"blue");
	$size_array=array("Extreme"=>"4","High"=>"3","Medium"=>"2","Low"=>"1");
	@$color=$color_array[$time_aspect];
	@$size=$size_array[$time_aspect];
	echo "<td><strong>Project priority - assigned by Project Manager:</strong> <font color='$color' size='$size'>$time_aspect</font>";
	echo "<br /><strong>Project type - assigned by Project Manager:</strong> $misc_aspect";
	echo "</td>";
	}

echo "</tr></table>";

echo "<script>";
	$func="#routed_to_1";
	echo "$(function()
		{
		$( \"$func\" ).autocomplete({
		source: [ $assign_to_source ]
		});
		});";
	$func="#routed_to_2";
	echo "$(function()
		{
		$( \"$func\" ).autocomplete({
		source: [ $assign_to_source ]
		});
		});";
echo "</script>";

if(!empty($routed_to_1))
	{
	$test=urldecode($routed_to_1);
		$sql="select email from divper.empinfo where tempID='$test'";
		$result = mysqli_query($connection,$sql);
		$row=mysqli_fetch_assoc($result);
		$route_to_email_1=$row['email'];
	}
if(!empty($routed_to_2))
	{
	$test=urldecode($routed_to_2);
		$sql="select email from divper.empinfo where tempID='$test'";
		$result = mysqli_query($connection,$sql);
		$row=mysqli_fetch_assoc($result);
		$route_to_email_2=$row['email'];
	}

// determines who sees the assignees
if($level>1)
	{
	echo "<table>";
	
	echo "<tr><td align='right'>";
	if(!isset($routed_on) OR empty($routed_to_1))
		{$routed_on="";}
		else
		{
		echo "<input type='hidden' name='routed_to_1' value='$routed_to_1'>
		<input type='hidden' name='routed_on' value='$routed_on'>";
		}
	@$team_email=$route_to_email_1.$email_sep;
	echo "Project Manager: <br />Associate Project Manager: </td><td colspan='2'>";
	if($level>2)
		{
		if(!isset($routed_to_1)){$routed_to_1="";}
		if(!isset($routed_to_2)){$routed_to_2="";}
		if(!isset($route_to_email_1)){$route_to_email_1="";}
		if(!isset($work_order_number)){$work_order_number="";}
		if(!isset($proj_name)){$proj_name="";}
		if(!isset($link)){$link="";}
		echo "<input id=\"routed_to_1\" name='routed_to_1' value=\"$routed_to_1\">
		&nbsp;
		Routed on: $routed_on <a href='mailto:$route_to_email_1?subject=$emp_id Work Order Number: $work_order_number - $proj_name&body=$link'>$route_to_email_1</a>";
		
		echo "<br /><input id=\"routed_to_2\" name='routed_to_2' value=\"$routed_to_2\">
		&nbsp;&nbsp;Routed on:";
		if(empty($routed_to_2))
			{}
			else
			{
			if(empty($route_to_email_2))
				{$route_to_email_2="No email address for $route_to_email_2.";}
				else
				{$team_email.=$route_to_email_2.$email_sep;}
			echo "$routed_on <a href='mailto:$route_to_email_2?$emp_id subject=Work Order Number: $work_order_number - $proj_name&body=$link'>$route_to_email_2</a>";
			}
		}
	else
		{
		echo "$routed_to_1 <a href='mailto:$route_to_email_1?subject=Work Order Number: $work_order_number - $proj_name&body=$link'>$route_to_email_1</a>";
		if(empty($routed_to_2))
			{}
			else
			{
			if(empty($route_to_email_2))
				{$route_to_email_2="No email address for $route_to_email_2.";}
				else
				{$team_email.=$route_to_email_2.$email_sep;}
			echo "<br />$routed_to_2 <a href='mailto:$route_to_email_2?$emp_id subject=Work Order Number: $work_order_number - $proj_name&body=$link'>$route_to_email_2</a>";
			}
		}

	echo "</td></tr>";

if($level<3 AND !empty($routed_to_1) OR $level > 2)
	{
		if(empty($assigned_number)){$assigned_number=4;}
		// see _base_top.php for jquery datepicker
	//	echo "Date Assigned:</td><td>$date_assigned";

//		echo "<td><input id=\"datepicker3\"  type='text' name='date_assigned' value=\"$date_assigned\"><br />";

		echo "<tr><td valign='top' colspan='5'>Number Assignees: <input type='text' name='assigned_number' value=\"$assigned_number\" size='2'></td></tr>
	<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hours worked, e.g., 1.25&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;email send &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
		
		echo "<script>";
		for($i=1;$i<=$assigned_number;$i++)
			{
			$func="#assigned_to_".$i;
			echo "$(function()
				{
				$( \"$func\" ).autocomplete({
				source: [ $source ]
				});
				});";
			}
		echo "</script>";
		
	if(!empty($no_email))
		{
		$no_email_array=explode("*",$no_email);
		}
		else
		{$no_email_array=array();}
	
	echo "<tr><td valign='top'>Assigned to:</td><td valign='top'>";
		for($i=1;$i<=$assigned_number;$i++)
			{
			$var_fld_1="assigned_to_".$i;
			$var_fld_2="time_worked_".$i;
			$var_fld_3="send_email_".$i;
			$var_fld_4="email_sent_".$i;
			$var_fld_5="time_worked_old_".$i;
			$var_fld_6="completed_".$i;
			$var_fld_7="work_done_".$i;
			@$value_1=${$var_fld_1};
			@$value_2=${$var_fld_2};
		//	@$value_3=${$var_fld_3};
			@$value_4=${$var_fld_4};
			@$value_6=${$var_fld_6};
			@$value_7=${$var_fld_7};
			
			// db datetime is Mountain Time. need to add 2 hrs. for display
			$modify_time="";
			if($value_4!="0000-00-00 00:00:00" and $value_4!=NULL)
				{
			//	$modify_time=date('Y-m-d h:i:s A', strtotime($value_4)+7200);
				$modify_time=date('Y-m-d h:i:s A', strtotime($value_4)+0);
				}
			
			
			echo "$i. <input id=\"$var_fld_1\" name='$var_fld_1' value=\"$value_1\" onchange=\"validateDateAssign()\" size='13'>
			<input type='text' name='$var_fld_2' value='' size='2'>
			<input type='hidden' name='$var_fld_5' value='$value_2'>
			&nbsp;$value_2
			<input type='checkbox' name='$var_fld_3' value='x'>
			<input type='hidden' name='$var_fld_4' value='$value_4'>&nbsp;
			<font color='magenta'>$modify_time</font>";
			if(!array_key_exists($value_1,$exhibit_staff_email))
				{
				if(!empty($value_1))
					{
					echo "<font color='red'>No email address for $value_1</font>";
					}
				
				}
				else
				{
				$link="http://www.dpr.ncparks.gov/exhibits/work_order_form.php?pass_id=$pass_id";
				$var=$exhibit_staff_email[$value_1];
				$team_email.=$var.$email_sep;;
				$value_1="<a href='mailto:$var?subject=$emp_id  - $work_order_number - $proj_name&body=$link'>$var</a>";
				echo " &nbsp;$value_1";
				}
			if($value_6=="x"){$ck="checked";}else{$ck="";}
				
			if(empty($value_1)){echo "<br />"; continue;}
			echo "&nbsp;Completed<input type='checkbox' name='$var_fld_6' value='x' $ck>";
			if($value_6=="x" and $value_7!="0000-00-00")
				{
				echo "&nbsp;on: $value_7<input type='hidden' name='$var_fld_7' value='$value_7'>";
				}
			echo "<br />";
			}
	
		echo "</td></tr>";
		$team_email=rtrim($team_email,$email_sep);
	if(!empty($work_order_number))
		{
		echo "<tr><td>Send Team an <a href='mailto:$team_email?subject=$emp_id Work Order Number: $work_order_number, Project Name=$proj_name&body=$link'>email</a></td>";
		}
		echo "</tr>";
		echo "</table>";
		}
	}

//echo "e=$emp_id<pre>"; print_r($assigned_array); echo "</pre>"; // exit;
$check_supervisor=strpos($assign_to_source,$tempID);
if(array_key_exists($tempID,$assigned_array) OR $level>1)
	{
	if($level<2){$RO="READONLY";}ELSE{$RO="";}
	
	$rows=8;
	@$len=strlen($instructions);
	@$chars=substr_count($instructions,"\n");
	$div=30-$chars;
	if($div<1){$div=1;}
	$rows=ceil($len/$div);
	
	if(!isset($time_instructions)){$time_instructions="";}
	if(!isset($instructions)){$instructions="";}
	echo "<table><tr><td>Instructions: <font color='green'>$time_instructions</font><br /><textarea name='instructions' rows='$rows' cols='50' $RO>$instructions</textarea></td>";
	$rows=8;
	@$len=strlen($project_comments);
	@$chars=substr_count($project_comments,"\n");
	$div=30-$chars;
	$rows=ceil($len/$div);
	
	if(!isset($time_project_comments)){$time_project_comments="";}
	if(!isset($project_comments)){$project_comments="";}
	echo "<td>Project Comments: <font color='green'>$time_project_comments</font><br /><textarea name='project_comments' rows='$rows' cols='50'>$project_comments</textarea></td></tr>";
	
	$rows=4;
	@$len=strlen($materials_costs);
	@$chars=substr_count($materials_costs,"\n");
	$div=25-$chars;
	if($div<1){$div=1;}
	$rows=ceil($len/$div);
	
	if(!isset($time_materials_costs)){$time_materials_costs="";}
	if(!isset($materials_costs)){$materials_costs="";}
	echo "<tr>
	<td colspan='2'>Running Account of Materials Used and Project Costs: <font color='green'>$time_materials_costs</font><br /><textarea name='materials_costs' rows='$rows' cols='103'>$materials_costs</textarea></td></tr>";
	echo "</table>";
	}		
echo "<div id=\"ValidationError\" name=\"ValidationError\">
</div>";

// Only allow the assigned person to change time worked
if($level==1 and array_key_exists($login_user,$assigned_array))
	{
	$assigned_number=count($assigned_array);
	echo "<input type='hidden' name='assigned_number' value='$assigned_number'>";
	$i=0;
	$team_email=$route_to_email_1.$email_sep;
	echo "<table>";
	echo "<tr><td>Project Manager: $routed_to_1 on $routed_on <a href='mailto:$route_to_email_1?subject=$emp_id Work Order Number: $work_order_number, Project Name=$proj_name'>$route_to_email_1</a></td>";
if(!empty($routed_to_2))
	{
	if(!empty($route_to_email_2)){$team_email.=$route_to_email_2.$email_sep;}

	echo "</tr><tr><td>Associate Project Manager: $routed_to_2 <a href='mailto:$route_to_email_2?subject=$emp_id Work Order Number: $work_order_number, Project Name=$proj_name'>$route_to_email_2</a></td>";
	}
echo "</tr></table>";

	echo "<table><tr><td valign='top'>Assigned to:</td><td><table>";
	foreach($assigned_array as $k=>$v)
		{
		$i++;
		$em="";
			$var_fld_1="assigned_to_".$i;
			$var_fld_2="time_worked_".$i;
			$var_fld_3="time_worked_old_".$i;
			$var_fld_4="completed_".$i;
			$var_fld_5="work_done_".$i;
			$value_4=${$var_fld_4};
			$value_5=${$var_fld_5};
		if($login_user==$k)
			{
			// We show the existing $v and pass it to the Update as $var_fld_3
			//along with any new value in $var_fld_2
			echo "<tr><td><input type='hidden' name='$var_fld_1' value=\"$k\">";
			echo "$k <input type='text' name='$var_fld_2' value='' size='5'> $v</td><td><input type='hidden' name='$var_fld_3' value='$v'></td>";
			
				if($value_4=="x"){$ck="checked";}else{$ck="";}
			echo "<td>Completed<input type='checkbox' name='$var_fld_4' value='x' $ck></td>";
			echo "</tr>";
			}
			else
			{
			$var_em=$exhibit_staff_email[$k];
			if(!empty($var_em))
				{
				$team_email.=$var_em.$email_sep;
				$em="<a href='mailto:$var_em?subject=$emp_id Work Order Number: $work_order_number, Project Name=$proj_name'>$var_em</a> $value_5";
				}
		
			echo "<tr><td><input type='hidden' name='$var_fld_1' value=\"$k\">";
			echo "$k <input type='hidden' name='$var_fld_2' value=\"$v\" size='5'></td><td>$em</td></tr>";
			}
		}
		$team_email=rtrim($team_email,$email_sep);
	echo "</table></td>";
	if(!empty($work_order_number))
		{
		echo "<td valign='top'>Send Team an <a href='mailto:$team_email?subject=$emp_id Work Order Number: $work_order_number, Project Name=$proj_name'>email</a></td>";
		}
	echo "</tr></table>";
	}


if(!is_array($category_array)){$category_array=array();}
$req="";
if(empty($category)){$req="<font color='red'>required</font>"; $category="";}
echo "<table><tr><td valign='top' colspan='4'>Category $req<br />";
foreach($category_array as $k=>$v)
	{
	$ck="";
	if($category==$v){$ck="checked";}
	echo "<input type='radio' name='category' value=\"$v\" $ck> $v &nbsp;&nbsp;&nbsp;";
	}
echo "&nbsp;&nbsp; (If \"Other\", please describe in the \"Project Description\" field.)</td></tr>";

/*
if($level>4){echo "<tr><td align='right' colspan='2'>Add a New Category: <input type='text' name='category_new' value=\"\"></td>";}
*/
echo "</tr>";


echo "</table>";

if(!isset($park_code)){$park_code="";}
if(!empty($park_code))
	{
	$park_code_pass="$park_code<input type='hidden' name='park_code' value=\"$park_code\">";
	if(!empty($park_code) AND empty($park_code))
		{
		$park_code_pass="$park_code<input type='hidden' name='park_code' value=\"$park_code\">";
		}
	}
else
	{
	$park_code_pass="$park_code<input type='hidden' name='park_code' value=\"$park_code\">";
	}

if(!isset($location) AND !isset($location_pass)){$location_pass="";}
else
{$location_pass.="$location<input type='hidden' name='pass_location' value=\"$location\">";}

$req="";
if(empty($park_code)){$req="<font color='red'>required</font>";}

echo "<table><tr><td>Park System Unit:<br /><font color='purple' size='+1'><b>$park_code_pass</b></font></td>";
$exp=array();
if($level==1)
	{
	$exp=explode(",", $_SESSION['exhibits']['accessPark']);
	}

if(empty($lat))
	{
	echo "<hidden name='pass_id' id='pass_id' value=''>";
	echo "<td><select id=\"park_code\" name='park_code' onchange=\"ajaxFunction()\">
	<option value='' selected></option>\n";
	foreach($parkCode as $k=>$v)
		{
//		if(!in_array($v,$exp)){continue;}
		echo "<option value='$v'>$v</option>\n";
		}
	echo "</select>&nbsp; $req</td><td><div id=\"ajaxDiv\">Map It!</div></td>";
	}
	else
	{
	// input name removed so that value is set to file name
	echo "<hidden name='pass_id' id='pass_id' value='$pass_id'>";
	echo "<td><select id=\"park_code\" onChange=\"MM_jumpMenu('parent',this,0)\">
	<option value='' selected></option>\n";
	foreach($parkCode as $k=>$v)
		{
		if(!in_array($v,$exp) AND $level==1){continue;}
		if($park_code==$v){$s="selected";}else{$s="";}
		echo "<option value='work_order_form.php?pass_id=$pass_id' $s>$v</option>\n";
		}
	echo "</select></td>
	<td>Location <input type='button' style=\"background-color:lightgreen\" value='Map It!' onclick=\"return popitLatLon('lat_long.php?&park_code=$park_code&lat=$lat&lon=$lon')\"><br />Latitude: &nbsp;&nbsp<input type='text' name='lat' value='$lat'><br />Longitude: <input type='text' name='lon' value='$lon'></td>";
	}
	
	


$req="";
if(empty($location_pass)){$req="<font color='red'>required</font>";}
if(!isset($lat)){$lat="";}
if(!isset($lon)){$lon="";}


if(!isset($location_comment)){$location_comment="";}
echo "<td valign='top'>Location Comments:<br /><textarea name='location_comment' rows='2' cols='60'>$location_comment</textarea></td>
</tr></table>";//  <font color='red'>required</font> $error_location_comment


echo "<table>";
@$proj_name=stripslashes($proj_name);
$req="";
if(empty($proj_name)){$req="<font color='red'>required</font>";}
$var_pn=htmlentities($proj_name);

if(!isset($purpose)){$purpose="";}
echo "<tr><td valign='top'>Project Name: $req<br /><input type='text' name='proj_name' value=\"$var_pn\" size='55'> </td>
	<td>Purpose or Interpretive Theme of this project:<br />
	<textarea name='purpose' rows='4' cols='50'>$purpose</textarea></td></tr></table>";

$rows=5;
if(!empty($proj_description))
	{
	$len=strlen($proj_description);
	$chars=substr_count($proj_description,"\n");
	$div=55-$chars;
	$rows=ceil($len/$div);
	$test_proj_desc=explode("~",$proj_description);
	if(count($test_proj_desc)>2)
		{$diff="<font color='brown'>The Project Description is no longer the same as the Original Project Description.</font>";}
		else
		{$diff="";}
	}
if($rows<10){$rows=5;}
$req="";
if(empty($proj_description)){$req="<font color='red'>required</font>";}

if(!isset($time_proj_description)){$time_proj_description="";}
if(!isset($proj_description)){$proj_description="";}

echo "<table><tr>
<td colspan='3'>Project Description: $req <font color='green'>$time_proj_description</font>

<a onclick=\"toggleDisplay('proj_desc');\" href=\"javascript:void('')\">
Please click for instructions:</a>
<div id=\"proj_desc\" style=\"display: none\">
<font color='purple'>Include names of primary staff working on project, all specific sizes needed (ex.  3’x4’ panel, 12”x18” poster), installations details (upright kiosk, low profile display), graphics details (map edits, new artwork), etc.</font>
</div>    



<textarea name='proj_description' rows='$rows' cols='90'>$proj_description</textarea></td>
</tr></table>";

if(!empty($proj_description))
	{
	echo "<div id=\"topicTitle\" ><a onclick=\"toggleDisplay('div1');\" href=\"javascript:void('')\"> Original Project Description &#177</a> $diff</div>
		<div id=\"div1\" style=\"display: none\"> <table><tr>
	<td colspan='3'><br /><textarea name='proj_description_original' rows='$rows' cols='90' READONLY>$proj_description_original</textarea></td>
	</tr></table></div>";
	}

echo "<table>";

	if(!empty($additional_img)){$ck="checked";}
	echo "<tr><td><input type='checkbox' name='additional_img' value='x' $ck>we’d like help finding additional images</td></tr>";
	
	$images_array=array("all"=>"<b>None</b> OR <b>if needed</b>, all necessary photos/images are <b>included below</b>","mail"=>"<b>images will be mailed</b> to HQ as a CD/DVD");
	
	if(!isset($photos)){$photos="";}
	echo "<tr><td>Images:";
	foreach($images_array as $k=>$v)
		{
		if($k==$photos){$ck="checked";}else{$ck="";}
		echo "[<input type='radio' name='photos' value='$k' $ck required>$v] ";
		}
	echo "</td></tr>";
	
	$funding_array=array("mm_dist"=>"exhibits maintenance funds already approved by district","park_budget"=>"park’s normal operating budget","external"=>"external funding, such as friends group","pending"=>"funding still pending");
	echo "<tr><td>How is project funded?<br />";
	
	if(!isset($funding)){$funding="";}
	foreach($funding_array as $k=>$v)
		{
		if($k==$funding){$ck="checked";}else{$ck="";}
		echo "[<input type='radio' name='funding' value='$k' $ck required>$v] ";
		}
		echo "<br />
	Projects listed as “funding still pending” can still receive exhibits and design support, but higher priority will be given to those already funded.
	</td></tr>
	
	</table>";
	
echo "<table border='1'><tr><td>";
echo "<table><tr><td>Supporting File(s) <br />
If text involved, upload a word file as <font color='red'>approved by PIO</font>.  Also upload images, sketches, photos of installation site, etc.  </td></tr>";
//echo "<pre>"; print_r($found_files); echo "</pre>"; // exit;
$num_files=count(@$found_files['link']);
$max_no_file=$num_files+9;  // Maximum number of files value to be set here
for($i=1; $i<=$max_no_file; $i++)
	{
	if(!empty($found_files['link'][$i]))
		{
		$link=$found_files['link'][$i];
			$var_link=explode("/",$link);
			$tn="ztn.".array_pop($var_link);
			$var_file=explode(".",$tn);
		$test_file=array_pop($var_file);
		$file_type="file";
			if(strtolower($test_file)=="jpg" or strtolower($test_file)=="jpeg" or strtolower($test_file)=="png")
				{$file_type="image";}
			$var_tn=implode("/",$var_link)."/".$tn;
		$old_name=$found_files['old_name'][$i];
		if($file_type=="image")
			{
			if(strtolower($test_file)=="png")
				{
				echo "<tr><td colspan='2'>$i Click on link to view this PNG: <a href='$link' target='_blank'><img src='$var_tn'>$old_name</a> </td>
				<td><input type='file' name='file_upload[$i]' class='bginput'><a href='del_img.php?id=$pass_id&var=$link' onClick=\"return confirmImg()\">Delete</a> Image</td>";
				}
				else
				{
	echo "<tr><td colspan='2'>$i Click on thumbnail to view this JPEG: <a href='$link' target='_blank'><img src='$var_tn'></a> $old_name</td>
	<td><input type='file' name='file_upload[$i]' class='bginput'><a href='del_img.php?id=$pass_id&var=$link' onClick=\"return confirmImg()\">Delete</a> Image</td>";
				}
			}
			else
			{
		echo "<tr><td colspan='2'>$i Click on link to view this file: <a href='$link' target='_blank'>$old_name</a></td>
		<td><input type='file' name='file_upload[$i]' class='bginput'><a onClick=\"return confirmFile()\" href='del_img.php?id=$pass_id&var=$link' >Delete</a> File</td></tr>";
			}
		}
	else
		{
		echo "<tr><td colspan='2'>Support File $i 
			<input type='file' name='file_upload[$i]' class='bginput'></td></tr>";
		}
	}

	
	echo "</table></td><td><table><tr>";
if(!empty($pass_id)){$action="Update";}else{$action="Submit";}

if(@$date_completed=="not yet"){$date_completed="";}
if($level>0 OR empty($date_completed))
	{
	echo "<td colspan='2'></td>";
	if(!empty($pass_id))
		{
		echo "<td><input type='hidden' id='pass_id' name='pass_id' value='$pass_id'></td>";
		}

	echo "<td bgcolor='green'>";
	if(!isset($section)){$section="";}

	if($action=="Submit")
		{
		echo "<input type='hidden' name='section' value='$section'>";
		}
	echo "<input type='hidden' name='tempID' value='$login_user'>";
	if($action=="Update")
		{
		echo "<input type='hidden' name='work_order_number' value='$work_order_number'>";
		}
	echo "<input type='submit' name='submit' value='$action'>
	</td></form>";
	

	if(!empty($pass_id))
		{
		echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td bgcolor='red'><form action='work_order_form.php' method='POST'>
		<input type='hidden' id='pass_id' name='pass_id' value='$pass_id'>
		<input type='hidden' name='work_order_number' value='$work_order_number'>
		<input type='submit' name='submit' value='Void' onClick=\"return confirmLink()\">
		</form></td>";
		}

	echo "</tr>
	</table></td></tr></table>";
}
echo "</div>
</div></body></html>";

?>