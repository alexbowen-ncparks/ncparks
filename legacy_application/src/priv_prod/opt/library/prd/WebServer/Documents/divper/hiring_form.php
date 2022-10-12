<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters

// extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;

mysqli_select_db($connection,'divper'); // database

if(!empty($_POST['update']))
	{
	$skip=array("target_date","update","pass_id","tempID");
//	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	$clause="";
	foreach($_POST as $fld=>$temp)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="pass_f_year"){$fld="f_year";}
		if($fld=="hire_comments")
			{
			if(empty($temp)){continue;}
// 			$var=mysqli_real_escape_string($temp);
$var=$temp;
			$new_temp=$var." [".$_POST['tempID']."_".date("Y-m-d")."]";
			$clause.="$fld=if(`hire_comments`='$var',`hire_comments`, '$new_temp'),";
			continue;
			}
		if(!is_array($temp))
			{
// 			$var=mysqli_real_escape_string($temp);
			$var=$temp;
			$clause.=$fld."='$var',";
			}
		if(is_array($temp))
			{
			foreach($temp as $k=>$v)
				{
// 				$var=mysqli_real_escape_string($v);
				$var=$v;
				$var_fld=$fld."_".$k."='$var',";
				$clause.=$var_fld;
				}
			}
		}
	$clause=rtrim($clause,",");
	
	if(empty($_POST['pass_id']))
		{
		$sql = "INSERT INTO hiring_form set $clause";		
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$pass_id=mysqli_insert_id($connection);
		$message="<font color='magenta' size='+1'>Hiring Process Started</font>";
		}
		else
		{
		$pass_id=$_POST['pass_id'];
		$sql = "UPDATE hiring_form set $clause where id='$pass_id'"; //echo "$sql<br />"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$message="<font color='green' size='+1'>Hiring Process Updated</font>";
		}
//	echo "$sql"; //exit;
	}
include("menu.php");	
include("/opt/library/prd/WebServer/Documents/budget/~f_year.php");
$f_year_array=array($f_year, $pf_year);

if(empty($pass_f_year))
	{$pass_f_year=$pf_year;}
	
if(!empty($pass_id) OR !empty($_REQUEST['pass_id']))
	{
	if(empty($pass_id)){extract($_REQUEST['pass_id']);}
	$sql = "SELECT * From hiring_form
	WHERE id='$pass_id'
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_assoc($result);
//	echo "$sql<pre>"; print_r($row); echo "</pre>";  exit;
	extract($row);
	$pass_version=$version;
	if($completed_date_10!='0000-00-00' and $signature_10!=''){$process_complete=1;}
	}
	

if($_SESSION['divper']['level']==1){$pass_park=$_SESSION['divper']['select'];}
IF(!empty($_SESSION['divper']['accessPark']))
	{
	$multi_park=explode(",",$_SESSION['divper']['accessPark']);
	$park_menu="<td><select name='pass_park' onchange=\"this.form.submit()\">";
	foreach($multi_park as $k=>$v)
		{
		IF($v==@$_REQUEST['pass_park'])
			{
			$pass_park=$_REQUEST['pass_park'];
			$s="selected";}
			else{$s="";}
		$park_menu.="<option value=\"$v\" $s>$v</option>\n";
		}
	$park_menu.="</select></td>";
	}
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$where="";
IF(!EMPTY($pass_park))
	{$where="and park='$pass_park'";}
$sql = "SELECT beacon_num as temp_bn From position
WHERE 1 
$where
ORDER by beacon_num";
//echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$posArray=array();
while ($row=mysqli_fetch_array($result))
	{
//	extract($row);
	$posArray[]=$row['temp_bn'];
	}
	
$sql = "SELECT beacon_num as temp_bn From emplist ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$empArray=array();
while ($row=mysqli_fetch_array($result))
	{
//	extract($row);
	$empArray[]=$row['temp_bn'];
	}


$sql = "SELECT * From vacant_admin ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num>0)
	{
	while ($row=mysqli_fetch_array($result))
		{
		//extract($row);
		$makeVacant[]=$row['beacon_num'];
		}
	$vacArray=array_diff($empArray,$makeVacant);
	}
else
{$vacArray=$empArray;}

//exit;

$vacantArray=array();
@$sortArray=$sort;
$diffArray=array_diff($posArray,$vacArray);
$c=count($diffArray);
//echo "$c<pre>"; print_r($diffArray); echo "</pre>";  exit;
foreach($diffArray as $index=>$bn) // beacon_num
	{
	@$source_position.="\"".$bn."\",";
	}

$sql = "SELECT t1.Fname, t1.Lname, t1.emid, t2.currPark, t3.working_title
	From empinfo as t1
	left join emplist as t2 on t1.emid=t2.emid
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t2.emid is not NULL
	ORDER by t1.Lname, t1.Fname";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$name=$row['Lname'].", ".$row['Fname']."*".$row['emid']."*".$row['working_title']."*".$row['currPark'];
	@$source_personnel.="\"".$name."\",";
	}


$sql = "SELECT `date` From hiring_form_holidays
WHERE 1 and f_year='$pass_f_year'
ORDER by id";
//echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$i=0;
while ($row=mysqli_fetch_assoc($result))
	{
//	echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	if(($i==0 or $i==17)and $row['date']=="0000-00-00")
		{
		include("hiring_form_menu.php");
		echo "No Holidays have been entered for fy $pass_f_year."; 
		exit;
		}
	$i++;
	$exp=explode("-",$row['date']);
	$t = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
	$holiday_array[]=$t;
	}
	
if(!empty($_POST['get_position']) or !empty($_POST['beacon_num']) or !empty($beacon_num))
	{
	if(empty($beacon_num))
		{$var=$_POST['beacon_num'];}
		else
		{$var=$beacon_num;}
	
	$sql = "SELECT beacon_num, working_title, beacon_title, code 
	FROM divper.position
	where beacon_num='$var'";  //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$position_array[$row['beacon_num']]=$row;
		}
	}
//echo "<pre>"; print_r($position_array); echo "</pre>"; // exit;

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "
<script>
    $(function() {";
    for($i=0;$i<=24;$i++)
    	{
    	echo "
        $( \"#datepicker".$i."\" ).datepicker({
		numberOfMonths: 2,
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: \"-5yy:+1yy\",
		maxDate: \"+1yy\",
		showButtonPanel: true });
   ";
    }
echo " });</script>";

echo "<form method='POST' action='hiring_form.php'>";

include("hiring_form_menu.php");

if(empty($source_position))
	{
	echo "No vacant positions.";
	exit;}
	
if(!isset($var)){$var="";}

if(!empty($pass_id)){$ro="readonly";}else{$ro="";}
echo "<table><tr><td>$c Vacant Position Numbers</td>";
echo "<td><input type='text' id='beacon_num' name='beacon_num' value=\"$var\" size='10' $ro ></td>";
echo "<td>
<select name='pass_f_year'>";
if($pass_f_year==$f_year_array[1]){$s1="selected";}else{$s1="";}
echo "<option value='$f_year_array[1]' $s1>$f_year_array[1]</option>\n";
if($pass_f_year==$f_year_array[0]){$s0="selected";}else{$s0="";}
echo "<option value='$f_year_array[0]' $s0>$f_year_array[0]</option>\n
</select>
</td>";

if(!empty($message)){echo "<td>$message</td>";}
echo "</tr>";
echo "</table></form>";
echo "
	<script>
	$(function()
	{
		$( \"#beacon_num\" ).autocomplete({
			source: [ $source_position ],
			change: function() {
				this.form.submit();
			},
			select: function(event, ui) {
				$(\"#beacon_num\").val(ui.item.value);
				this.form.submit();
			}
		});
	});
	$(function()
	{
		$( \"#supervisor\" ).autocomplete({
		source: [ $source_personnel ]
			});
	});
	</script>";

if(!empty($var))
	{
	include("hiring_form_data.php");
	
	if(!empty($process_complete))
		{
		echo "</div>";
		}
	}
//echo "<pre>"; print_r($summary_days); echo "</pre>"; // exit;
if(!empty($process_complete))
	{
	$sql = "SELECT datediff(pass_target_date_1, completed_date_0) as cal_1, datediff(completed_date_10, pass_target_date_0) as cal_2, t2.beacon_title, t2.working_title, t2.park, t1.supervisor
FROM hiring_form as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
where t1.id='$pass_id'
";  //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql");
$row=mysqli_fetch_assoc($result); extract($row);
	$target_1=$summary_days['2.0'];
	$target_2=$summary_days['2.0'] + $summary_days['3.0'] + $bus_days + $summary_days['4.0'] + $summary_days['5.0'] + $summary_days['6.0'] + $summary_days['7.0'] + $summary_days['8.0'] + $summary_days['9.0'] + $summary_days['10.0'] + $summary_days['11.0'];
	$target_4=$summary_days['8.0'];
	$target_5=$summary_days['8.0'];
	$target_6=$summary_days['9.0'] + $summary_days['10.0'] + $summary_days['11.0'];
	$act_1=$pass_target_date_0."".$completed_date_1;
	echo "
	<table border='1'>
	<tr><th colspan='4'>Summary</th></tr>
	<tr><th>Target BDs</th><th>Actual BDs</th><th>Calendar Days</th><th>Action [Numbers in brackets represent items listed below.]</th></tr>";
	
	$t=days_between(1,$pass_target_date_0);
	echo "<tr><td align='right'>$target_1</td><td>$t</td><td align='right'>$cal_1</td><td>1) Days between verbal resignation and receipt of written resignation letter [1 to 2].</td></tr>";
	
	$t=days_between($target_2,$pass_target_date_1);
	echo "<tr><td align='right'>$target_2</td><td>$t</td><td align='right'>$cal_2</td><td>2) Days between written resignation letter to the date an offer is accepted [2 to 11]. </td></tr>";
	
	$t="?";
	echo "
	<tr><td align='right'>?</td><td>$t</td><td align='right'></td><td>3) Days between written resignation to EOD date [NA].</td></tr>";
	
	$t=days_between($target_4,$pass_target_date_7);
	echo "
	<tr><td align='right'>$target_4</td><td>$t</td><td align='right'></td><td>4) Hiring Manager Time (From date applications are given to Hiring Manager until a complete recommendation package is submitted to Division HRM) [7 to 8].</td></tr>";
	
	$t=days_between(10,$pass_target_date_9);
	echo "
	<tr><td align='right'>$target_5</td><td>$t</td><td align='right'></td><td>5) Days between Division HRM receiving recommendation and submitting recommendation package to DENR-HR [8 to 9].</td></tr>";
	
	$t=days_between(6,$completed_date_10);
	echo "
	<tr><td align='right'>$target_6</td><td>$t</td><td align='right'></td><td>6) Days between submittal of recommendation package to DENR-HR to final approval date [9 to 11].</td></tr>
	</table>";
	}
	
echo "</body></html>";

function days_target_complete($td, $cd) 
	{
	global $holiday_array;
//	$x=$dc;
	$target_date=$td;
	$complete_date=$cd;
	
	if(empty($target_date)){echo "No target date given."; exit;}
	$exp=explode("-",$target_date);
	$t = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );

	$exp=explode("-",$complete_date);
	$c = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
	
//	echo "$t $c"; exit;
	$i=0;
	// loop for X days
	if($c>$t)
		{
		while($t<$c){
			$i++;
			// add 1 day to timestamp
			$addDay = 86400;

			// get what day it is next day
			$nextDay = date('w', ($t+$addDay));

			// if it's Saturday or Sunday get $i-1
			if($nextDay == 0 || $nextDay == 6)
				{
				@$i--;
				}

			// if it's a Holiday get $i-1
			if(in_array(($t+$addDay),$holiday_array))
				{
				@$i--;
				}

			// modify timestamp, add 1 day
			$t = $t+$addDay;
			$target_date=date("Y-m-d", $t);
			}
		}

	if($c<$t) // completed task ahead of target
		{
	//	echo "$c $t"; exit;
		while($t>$c){
			$i--;
			// sub 1 day from timestamp
			$subDay = 86400;

			// get what day it is prev day
			$prevDay = date('w', ($t-$subDay));

			// if it's Saturday or Sunday get $i+1
			if($prevDay == 0 || $prevDay == 6)
				{
				@$i++;
				}

			// if it's a Holiday get $i+1
			if(in_array(($t-$subDay),$holiday_array))
				{
				@$i++;
				}

			// modify timestamp, sub 1 day
			$t = $t-$subDay;
			$target_date=date("Y-m-d", $t);
			}
		}
//echo "$i<br />";
	return  $i;
	}
	
// $dc = day_count  $td = $target_date
function days_between($dc, $td) 
	{
	global $holiday_array;
	$x=$dc;
	$target_date=$td;
	if(empty($target_date)){$target_date=date("Y-m-d");}
	$exp=explode("-",$target_date);
	$t = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );

	// loop for X days
	for($i=0; $i<$x; $i++){

	// add 1 day to timestamp
	$addDay = 86400;

	// get what day it is next day
	$nextDay = date('w', ($t+$addDay));

	// if it's Saturday or Sunday get $i-1
	if($nextDay == 0 || $nextDay == 6)
		{
		$i--;
		}

	// if it's a Holiday get $i-1
	if(in_array(($t+$addDay),$holiday_array))
		{
		$i--;
		}

	// modify timestamp, add 1 day
	$t = $t+$addDay;
	$target_date=date("Y-m-d", $t);
	}

//	$date = date_create($target_date);
//	$display_target_date=date_format($date, 'Y-m-d');
	return  $i;
	}
?>