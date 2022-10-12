<?php
ini_set('display_errors',1);
$database="divper";
include("../../include/auth.inc"); // database connection parameters
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

include("menu.php");

if($level>4)
	{
//	echo "<pre>";print_r($_SESSION);echo "</pre>";  // exit;
	}

if(@$_SESSION['divper']['level']<4)
	{
	echo "You do not have access 17.";exit;
	}

$restrict_to=array("Strickland7786"=>"60032783", "McCall5186"=>"60032785",
 "Peele5397"=>"60032955", "CHOP"=>"60033018","CHOP OA"=>"60032920", "DEP DIR"=>"60033202");
 
$exclude_people=array("CHOP"=>"60033018","CHOP OA"=>"60032920", "DEP DIR"=>"60033202");

$user_beacon_num=$_SESSION['beacon_num'];

if(!in_array($user_beacon_num,$restrict_to) AND $_SESSION['logname']!="Howard6319")
	{
	echo "You do not have access 29.";exit;
	}


if(@$_REQUEST['reset']=="Reset")
	{
	foreach($_REQUEST as $k=>$v)
		{
		${$k}="";
		}
	}
else
	{
	
	foreach($_REQUEST as $k=>$v)
		{
		if($v==""){${$k}="";}else{${$k}=$v;}		
		}
	}
	
$sql="SELECT min(effective_date) as start_from
FROM position_history
where 1 and effective_date!='0000-00-00'
group by effective_date
order by start_from 
limit 1
"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

$row=mysqli_fetch_assoc($result);
extract($row);

$sql="SELECT max(effective_date) as start_to
FROM position_history
where 1
group by effective_date
order by start_to desc
limit 1
";// echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

$row=mysqli_fetch_assoc($result);
extract($row);


$exclude_people=array("CHOP"=>"60033018","CHOP OA"=>"60032920", "DEP DIR"=>"60033202");
$exclude_action=array("ZD"=>"Cancel Salary Adjustment(NC)","ZB"=>"Demotion (NC)", "109"=>"Abolish Position", "Z3"=>"Leave of Absence (NC)", "112"=>"Legislative Increase for Position", "X6"=>"PMIS Bonus", "X7"=>"PMIS SER/SMR Increase", "111"=>"Position Budgeted Salary Change", "ZC"=>"Salary Adjustment (NC)", "Z6"=>"Suspension (NC)");

$exclude="";

if(in_array($user_beacon_num,$exclude_people))
	{
	foreach($exclude_action as $code=>$desc)
		{
		$exclude.="action_type != '".$code."' and ";
		}
		$exclude="and ".rtrim($exclude," and ");
	}

$sql="SELECT distinct action_type,action_desc
FROM position_history
where 1
$exclude
order by action_desc
"; //echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count=mysqli_num_rows($result);

while ($row=mysqli_fetch_assoc($result))
	{
	$act_type[$row['action_type']]=$row['action_desc'];
	}

$sql="SELECT distinct beacon_title
FROM position_history
where 1
order by beacon_title
"; //echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count=mysqli_num_rows($result);

while ($row=mysqli_fetch_assoc($result))
	{
	$title_array[]=$row['beacon_title'];
	}
if(!isset($beacon_num)){$beacon_num="";}
if(!isset($pmis)){$pmis="";}
if(!isset($employee_name)){$employee_name="";}
if(!isset($employee_num)){$employee_num="";}
if(!isset($date_end)){$date_end="";}
if(!isset($date_begin)){$date_begin="";}
if(!isset($org_unit_num)){$org_unit_num="";}
echo "<form action='position_history.php' method='POST'>";
echo "<table><tr>
<td colspan='3'><h2>Search Form</h2>
Database date range: $start_from to $start_to</td></tr>
<tr><td>Date >= <br /><input type='text' name='date_begin' value='$date_begin'><br /></td>
<td><font color='red'>date format must be yyyy-mm-dd</font></td>
<td>Date <=<br /><input type='text' name='date_end' value='$date_end'><br /></td></tr></table>

<table><tr><td>beacon_num <br /><input type='text' name='beacon_num' value='$beacon_num'><br />(partial number OK)</td>
<td>pmis  <br /><input type='text' name='pmis' value='$pmis'><br />(partial number OK)</td>
<td>Employee Name  <br /><input type='text' name='employee_name' value='$employee_name'><br />(partial name OK)</td>
<td>Employee Number  <br /><input type='text' name='employee_num' value='$employee_num'><br />&nbsp;</td>
<td>Organizational Unit:  <br /><input type='text' name='org_unit_num' value='$org_unit_num'><br />&nbsp;</td>";

echo "<td>Action Description<br /><select name='action_type'><option selected=''></option>";
foreach($act_type as $code=>$desc)
	{
	echo "<option value='$code'>$desc</option>";
	}
echo "</select><br />&nbsp;</td>";

echo "<td>Position Title<br /><select name='beacon_title'><option selected=''></option>";
foreach($title_array as $index=>$title)
	{
	echo "<option value='$title'>$title</option>";
	}
echo "</select><br />&nbsp;</td>";
echo "</tr>";

echo "<tr>
<td><input type='submit' name='submit' value='Search'></td>
<td><input type='submit' name='reset' value='Reset'></td>
</tr>";
echo "</table></form>";

if(!isset($_REQUEST['submit'])){EXIT;}

$like=array("beacon_num","pmis","employee_name");
$clause="";
foreach($_POST as $fld=>$value)
	{
	if($value=="" OR $fld=="submit"){continue;}
	if(in_array($fld,$like))
		{
		$clause.=$fld." like '%".$value."%' and ";
		}
	else
		{
		$operator="=";
		if($fld=="date_begin")
			{
			$fld="effective_date";
			$operator=" >= ";
			}
		if($fld=="date_end")
			{
			$fld="effective_date";
			$operator=" <= ";
			}
		$clause.=$fld.$operator."'".$value."' and ";
		}
	}
	
	$clause=rtrim($clause," and ");


if($clause==""){echo "No search criterion entered.";exit;}

$order_by="";
if($action_type==109){$order_by="order by beacon_title";}
if(!empty($beacon_num)){$order_by="order by effective_date desc";}


$sql="SELECT t1.*
FROM position_history as t1 
where 1 and $clause
$exclude
$order_by
"; 
//echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count=mysqli_num_rows($result);

while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	
$skip=array("seid");
if($count>0)
	{
	$tr1="<h2><font color='green'>";$tr2="</font></h2>";
	$blank="";
	}
	else
	{
	if(!isset($where)){$where="";}
	$tr1="<h2><font color='red'>";$tr2="</font></h2>";
	$blank="<tr><td>No position was found using: $where</td></tr>";
	}
	
if($count==1){$rec="Record";}else{$rec="Records";}
echo "<table border='1'><tr><td colspan='14'>$tr1 Tracking History for <b>$count $rec</b>$tr2 $clause</td></tr>
$blank";

if($count<1){exit;}

	echo "<tr>";
	foreach($ARRAY[0] as $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<th>$fld</th>";
		}
	echo "</tr>";
	
foreach($ARRAY as $index=>$array)
	{
	if(fmod($index,2)==0){$t1=" bgcolor='aliceblue'";}else{$t1="";}
	echo "<tr$t1>";
	foreach($array as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if($k=="Original_RCC" AND $v!="")
			{
			$v=$v." ".$rcc_array[$v];
			}
		if($k=="pmis")
			{
//			$v="<a href='position_history_update.php?pmis=$v' target='_blank'>$v</a>";
			}
		if($k=="beacon_num")
			{
//			$v="<a href='position_history_update.php?beacon_num=$v' target='_blank'>$v</a>";
			}
		if($k=="employee_num")
			{
//			$v="<a href='position_history.php?employee_num=$v&submit=find'>$v</a>";
			}
		echo "<td>$v</td>";
		}
	echo "</tr>";
	}
echo "</table><hr />";
?>