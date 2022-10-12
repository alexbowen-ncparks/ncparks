<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters

// extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;

mysqli_select_db($connection,'divper'); // database

if(!empty($_POST) and !empty($_POST['update']))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	foreach($_POST['holiday'] as $k=>$v)
		{
// 		$v=mysqli_real_escape_string($v);
		$var_date=$_POST['date'][$k];
		$sql = "UPDATE hiring_form_holidays
		SET holiday='$v', date='$var_date'
		WHERE id='$k'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
		}
	}
date_default_timezone_set('America/New_York');

// ******
if(@$f_year=="")
	{
	ini_set('date.timezone', 'America/New_York');
	$testMonth=date('n');
	if($testMonth >0 and $testMonth<9){$year2=date('Y')-1;}
	if($testMonth >8){$year2=date('Y');}
	$yearNext=$year2+1;
	$yx=substr($year2,2,2);
	$year3=$yearNext;$yy=substr($year3,2,2);
	$f_year=$yx.$yy;
	
	if(@$prev_year=="prev")
		{
		$yx=substr(($year2-1),2,2);
		$yy=substr(($year3-1),2,2);
		$f_year=$yx.$yy;
		}
	
	$pf_year=$yx=substr(($year2-1),2,2);
	$yy=substr(($year3-1),2,2);
	$pf_year=$yx.$yy;
	}



// include("/opt/library/prd/WebServer/Documents/budget/~f_year.php");
$f_year_array=array($f_year, $pf_year);

if(empty($pass_f_year))
	{$pass_f_year=$pf_year;}
$sql = "SELECT * FROM hiring_form_holidays where f_year='$pass_f_year' order by id";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$holiday_id=$row['id'];
	}

if(empty($ARRAY) and in_array($pass_f_year,$f_year_array))
	{
	for($i=1; $i<=20; $i++)
		{
		$sql = "INSERT into hiring_form_holidays set f_year='$pass_f_year' ";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
		}
		
	$sql = "SELECT * FROM hiring_form_holidays where f_year='$pass_f_year' order by id";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}




include("menu.php");

$f_year_holiday_id=0+$holiday_id;
$i_start=1+($f_year_holiday_id-20);

echo "
<script>
    $(function() {";
    for($i=$i_start; $i<=$f_year_holiday_id; $i++)
    	{
    	echo "
        $( \"#datepicker".$i."\" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: \"-5yy:+1yy\",
		maxDate: \"+1yy\" });
   ";
    }
echo " });</script>";

include("hiring_form_menu.php");

$skip=array("id");
echo "<form method='POST' action='hiring_form_holidays.php'>";
echo "<table cellpadding='2'>";
echo "<tr><td colspan='3'>
<select name='pass_f_year' onChange=\"this.form.submit()\">";
if($pass_f_year==$f_year_array[1]){$s1="selected";}else{$s1="";}
echo "<option value='$f_year_array[1]' $s1>$f_year_array[1]</option>\n";
if($pass_f_year==$f_year_array[0]){$s0="selected";}else{$s0="";}
echo "<option value='$f_year_array[0]' $s0>$f_year_array[0]</option>\n
</select>
</td></tr>";

foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$dv=$value;
		$ID=$array['id'];
		if($fld=="holiday")
			{
			$dv="<input type='text' name='holiday[$ID]' value=\"$value\" size='33'>";
			}
		if($fld=="date")
			{
			$var_id="datepicker".$ID;
			$dv="<input type='text' id='$var_id' name='date[$ID]' value=\"$value\" size='11'>";
			}
		echo "<td>$dv</td>";
		}
	echo "</tr>";
	}

echo "<tr><td colspan='2' align='center'><input type='submit' name='update' value=\"Update\"></td></tr>";
echo "</table>";
echo "</form>";

?>