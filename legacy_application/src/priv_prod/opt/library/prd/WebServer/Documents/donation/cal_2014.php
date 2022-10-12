<?php
include("../../include/get_parkcodes.php");
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users

// To open to public, comment out auth.inc here and exclude menu.php below


include("../../include/connectROOT.inc"); 
mysql_select_db($database, $connection); // database

date_default_timezone_set('America/New_York');
// **********************************************

	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

$emid=$_SESSION['donation']['emid'];
$log_name=$_SESSION['donation']['log_name'];

mysql_select_db($database, $connection); // database 
extract($_REQUEST);
if(!empty($pass_edit))
	{
	$var_date=explode("-",$pass_edit);
	$_REQUEST['year']=$var_date[0];
	$_REQUEST['month']=$var_date[1];
	}
if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("m");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

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

$check_month=$cYear."-".$pass_month;
$sql="SELECT t1.park,t1.date,t1.title,'donation',id
from donation.calendar as t1 
where t1.date like '$check_month%'
union
select t2.park,t2.dateE,t2.title, 'dprcoe', eid
from dprcoe.event as t2

where t2.dateE like '$check_month%' and t2.ann_100='x'

order by date,park,title"; //echo "$sql";

if($cYear==2016 and !empty($placeholder))
	{
	$check_month="2016-".$pass_month;
	$sql="SELECT t1.park,t1.date,t1.title,'donation',id
	from donation.calendar as t1 
	where t1.date like '$check_month%'
	union
	select t3.park,t3.dateE,t3.title, 'dprcoe', eid
	from dprcoe.year_2016 as t3

	where t3.dateE like '$check_month%' and (t3.year16_100='x')

	order by date,park,title"; //echo "$sql"; exit;
	}

$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row=mysql_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$day_entry[]=$row['date'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(empty($check_array)){$check_array=array();}
$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

include("menu.php");
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
$year_array=range(date('Y'),"2016");
if(empty($year)){$year=date("Y");}
echo "<select name='year' onchange=\"this.form.submit()\"><option selected=''>Year</option>\n";
foreach($year_array as $k=>$v)
	{
	if($v==$year){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
?>
</select></td>

<td style="color:#FFFFFF">
<?php
$month_array=range(1,12);
if(empty($month)){$month=date('n');}
echo "<select name='month' onchange=\"this.form.submit()\"><option selected=''>Month</option>\n";
foreach($month_array as $k=>$v)
	{
	if($v==$month){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
?>
</select></td>

	<td align="right">
	  <a href="<?php 
	  if(empty($placeholder))
	  	{echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year;}
	  	else
	  	{echo $_SERVER["PHP_SELF"] . "?placeholder=1&month=". $prev_month . "&year=" . $prev_year;}
	   ?>" style="color:#FFFFFF">Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="<?php 
	  if(empty($placeholder))
	  	{echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year;}
	  	else
	  	{echo $_SERVER["PHP_SELF"] . "?placeholder=1&month=". $next_month . "&year=" . $next_year;}
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
	<td colspan="7" bgcolor="#999999" style="color:#FFFFFF">
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
		if($array['date']==$edit)
			{
			$j++;
			$title=$array['title'];
			$id=$array['id'];
			$park=$array['park'];
	//		$text.="<a href='cal_edit.php?id=$id' target='_blank'>".$title."</a><br />";
			$text.=$park."-".$title."<br />";
			}
		}
	}
$height=($j>4?"100px":"100px"); $j=0;
echo "<td valign='top'><font size='+1'>$display</font>
<div style=\"width: 150px; height: $height; background-color: $td_color;\" 
        onmouseover=\"document.getElementById('$div').style.display = 'block';\"
        onmouseout=\"document.getElementById('$div').style.display = 'none';\">
   <div id=\"$div\" style=\"display: none;\">$text</div>
</div></td>";
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