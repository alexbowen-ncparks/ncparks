<?php
include("../../include/get_parkcodes.php");
ini_set('display_errors',1);
$database="dprcoe";
include("../../include/auth.inc"); // used to authenticate users

// To open to public, comment out auth.inc here and exclude menu.php below


include("../../include/connectROOT.inc"); 
mysql_select_db($database, $connection); // database

date_default_timezone_set('America/New_York');
// **********************************************

//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

$emid=$_SESSION['dprcoe']['emid'];
$level=$_SESSION['dprcoe']['level'];
$session_park=$_SESSION['dprcoe']['park'];
$accessPark=$_SESSION['dprcoe']['accessPark'];

$d_array=array("EADI","NODI","SODI","WEDI");
array_unshift($parkCode,"STWD","EADI","NODI","SODI","WEDI");
	

mysql_select_db($database, $connection); // database 
extract($_REQUEST);
if(!empty($pass_edit))
	{
	$var_date=explode("-",$pass_edit);
	$_REQUEST['year']=$var_date[0];
	$_REQUEST['month']=$var_date[1];
	}
if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("m");
//if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = 2016;

$cMonth = $_REQUEST["month"];
$pass_month = str_pad($_REQUEST["month"],2,"0",STR_PAD_LEFT);
$cYear = $_REQUEST["year"];
 
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}

if(!empty($cal_level))
	{
	$clause=" and park='$cal_level'";
	if($cal_level=="STWD" or $cal_level=="STWD_District_Park")
		{$clause="";}
	if(in_array($cal_level,$d_array))
		{
		$a="array";
		$district=${$a.$cal_level};
		$clause=" and (";
		foreach($district as $k=>$v)
			{
			$clause.="park='$v' OR ";
			}
		$clause=rtrim($clause," OR ").")";
		}
	$limit_month="";
	$limit_num="";
	}
	else
	{
	$cal_level="";
	$clause="";
	$check_month=$cYear."-".$pass_month;
	$limit_month=" and dateE like '$check_month%'";
	$limit_num="limit 1";
	}
	
$sql="SELECT *
from dprcoe.event
where 1 and ann_100='x' $limit_month
$clause
order by dateE,park,title
$limit_num"; 
echo "$sql";


$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row=mysql_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$day_entry[]=$row['dateE'];
	}
echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

if(count($ARRAY>1))
	{
	$c=count($ARRAY);
echo "<table><tr><td>$c 100th Events</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
exit;
	}
if(empty($check_array)){$check_array=array();}
$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

include("menu_100.php");
?>
<form>
<table width="1024" align='center' border='1'>
<tr align="center">
<td bgcolor="#999999" style="color:#FFFFFF">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="purple">
	<td align="left"></td>

<td style="color:#FFFFFF">
<?php
if(!empty($placeholder)){echo "<input type='hidden' name='placeholder' value='1'>";}
//$year_array=range(date('Y'),"2016");
$year_array=array("2016");
if(empty($year)){$year=2016;}
echo "<select name='year' onchange=\"this.form.submit()\"><option selected=''>Year</option>\n";
foreach($year_array as $k=>$v)
	{
	if($v==$year){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
?>
</select></td>

<td style="color:#FFFFFF">
<?php
$month_array=range(1,12);
//echo "<pre>"; print_r($month_name_array); echo "</pre>"; // exit;
if(empty($month)){$month=date('n');}
echo "<select name='month' onchange=\"this.form.submit()\"><option selected=''>Month</option>\n";
foreach($month_array as $k=>$v)
	{
	if($v==$month){$s="selected";}else{$s="";}
	$m=$monthNames[$k];
	echo "<option value='$v' $s>$m</option>\n";
	}
?>
</select></td>

<td style="color:#FFFFFF">
<?php

echo "<select name='cal_level' onchange=\"this.form.submit()\"><option selected=''>STWD_District_Park</option>\n";
foreach($parkCode as $k=>$v)
	{
	if($v==$cal_level){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
?>
</select></td>

<td><a href='find.php?Submit=Find&ann_100=x' style="color:#FFFFFF">All 100th Events</a></td>
	<td align="right">
	  <a href="<?php 
	  if(empty($placeholder))
	  	{echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year . "&cal_level=" . $cal_level;}
	  	else
	  	{echo $_SERVER["PHP_SELF"] . "?placeholder=1&month=". $prev_month . "&year=" . $prev_year . "&cal_level=" . $cal_level;}
	   ?>" style="color:#FFFFFF">Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="<?php 
	  if(empty($placeholder))
	  	{echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year . "&cal_level=" . $cal_level;}
	  	else
	  	{echo $_SERVER["PHP_SELF"] . "?placeholder=1&month=". $next_month . "&year=" . $next_year . "&cal_level=" . $cal_level;}
	  	 ?>" style="color:#FFFFFF">Next</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td align="center"><font color='green' size='+2'>North Carolina State Parks System - 100th Anniversary</font>

<?php
if(!empty($placeholder) AND $year==2016){echo " <font color='red' size='+2'>Place Holder</font>";}
?>


	<table width="100%" border="1" cellpadding="2" cellspacing="2">
	<tr align="center">
	<td colspan="7" bgcolor="#999999" style="color:#66FFFF">
	<font size="+3">
	<?php echo $monthNames[$cMonth-1].' '.$cYear; ?>
	</font></td>
	</tr>
	<tr>
	<td align="center" bgcolor="#999999" style="color:#990000"><strong>S</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
	<td align="center" bgcolor="#999999" style="color:#990000"><strong>S</strong></td>
	</tr>

<?php
$pass_today=date("d");

$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
if(!isset($pass_status)){$pass_status="";}
if(!isset($pass_edit)){$pass_edit="";}

for ($i=0; $i<($maxday+$startday); $i++)
	{
		if(($i % 7) == 0 ) {echo "<tr style=\"height:100px\">";}
		if($i < $startday) {echo "<td></td>";}
		else 
		{
		$day=($i - $startday + 1);
		$edit=$cYear."-".$pass_month."-".str_pad($day,2,"0",STR_PAD_LEFT);
		$color="#000099";
		if(!empty($day_entry))
		{
		if(in_array($edit,$day_entry)){$color="#FF0000";}
		}
		
		$display="<a href='new_entry.php?pass_edit=$edit' style=\"color:$color; \">$day</a>";
		if(!empty($placeholder))
			{
			$display="<a href='new_entry.php?placeholder=1&pass_edit=$edit' style=\"color:$color; \">$day</a>";
			}
		
	//	if(($i % 7) == 0 ) {$display=$day; $status="";}
	//	if(($i % 7) == 6 ) {$display=$day;$status="";}

		if(($i % 7) == 0 ) {$pass_status="";}
		if(($i % 7) == 6 ) {$pass_status="";}

		$td_color="white";
		if(str_pad($day,2,"0",STR_PAD_LEFT)==$pass_today)
			{$td_color="Bisque";}
		if(str_pad($day,2,"0",STR_PAD_LEFT)==substr($pass_edit,-2))
			{$td_color="DarkKhaki";}
		
$div="div".$i;
$text="";
$j=0;
if(!empty($ARRAY))
	{
	foreach($ARRAY as $index=>$array)
		{
		if($array['dateE']==$edit)
			{
			$j++;
			$title=$array['title'];
			$id=$array['eid'];
			$park=$array['park'];
	//		$text.="<a href='cal_edit.php?id=$id' target='_blank'>".$title."</a><br />";
			$text.=$park."-".$title."<br />";
			}
		}
	}
$height=($j>4?"100px":"100px"); $j=0;
echo "<td valign='top'><font size='+1'>$display</font>
<div style=\"width: 150px; font-size:65%; height: $height; background-color: $td_color;\" 
        onmouseover=\"document.getElementById('$div').style.display = 'block';\"
        onmouseout=\"document.getElementById('$div').style.display = 'block';\">
   <div id=\"$div\" style=\"display: block;\">$text</div>
</div></td>";
/*
echo "<td valign='top'><font size='+1'>$display</font>
<div style=\"width: 150px; font-size:65%; height: $height; background-color: $td_color;\" 
        onmouseover=\"document.getElementById('$div').style.display = 'block';\"
        onmouseout=\"document.getElementById('$div').style.display = 'none';\">
   <div id=\"$div\" style=\"display: none;\">$text</div>
</div></td>";
*/
$pass_status="";
		}
		if(($i % 7) == 6 ) echo "</tr>";
	}
?>

	</table>
</td>
</tr>
</table>
</form>