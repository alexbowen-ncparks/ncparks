<html><head>

<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>

<?php
ini_set('display_errors',1);
include("../../include/get_parkcodes_i.php");
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,$database); // database

date_default_timezone_set('America/New_York');
// **********************************************

//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

$tempID=$_SESSION['pac']['tempID'];
$database="pac";

mysqli_select_db($connection,$database); // database 
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
$where="where t1.meeting_date like '$check_month%'";

$sql="SELECT distinct t1.parkcode
from meetings as t1 
$where
order by parkcode"; //echo "$sql";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$entered_park[]=$row['parkcode'];
	}
	

$where="where t1.meeting_date like '$check_month%'";

if(!empty($dist))
	{
	$where.=" and dist='$dist'";
	}
$sql="SELECT t1.parkcode,t1.meeting_date, id
from meetings as t1 
$where
order by meeting_date,parkcode"; //echo "$sql";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$day_entry[]=$row['meeting_date'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

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

<?php
// ********** Filters *************
echo "<form action='cal.php'>";

if($level>1)
	{

	$distArray=array("EADI","NODI","SODI","WEDI");
	echo "<td><font color='white'>Filter Calendar by: ";

	echo "<br />District</font> <select onChange=\"MM_jumpMenu('parent',this,0)\">
	<option value='cal.php'></option>";
	foreach($distArray as $k=>$v)
		{
		if(@$dist==$v){$o="selected";}else{$o="value";}
		echo "<option $o='cal.php?dist=$v'>$v</option>";
		}
		echo "</select>
	</td>";


	echo "<td align='center'><font color='white'>Park</font><br />
	<select onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>";
	foreach($entered_park as $k=>$v)
		{
		if(@$parkcode==$v){$o="selected";}else{$o="value";}
		echo "<option $o='cal.php?parkcode=$v'>$v</option>";
		}
		echo "</select>
	</td>";
	}
echo "<td align='center'><font color='white'>Add and/or Display</font><br /><a style=\"color:#FFFFFF\" href='pac_cal.php'>Meeting</a></td>";

if($level>3){echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color='white'>Edit default CHOP</font> <a style=\"color:#FFFFFF\" href='pac_chop_comment.php' target='_blank'>comment</a> <font color='white'>and file upload.</font></td>";}

echo "</form>";
?>


	<td align="right">
	  <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF">Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF">Next</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td align="center"><font color='green' size='+2'>North Carolina State Parks System - PAC Meetings</font>
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
		$size="100%";
		if(!empty($day_entry))
			{
			if(in_array($edit,$day_entry)){$color="#FF0000"; $size="200%";}
			}
		
	//	$display="<a href='pac_cal.php?pass_edit=$edit' style=\"color:$color; font-size:$size\">$day</a>";
		$display="<font color='$color' size='+3'>$day</font>";
		
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
		if($array['meeting_date']==$edit)
			{
			$j++;
			$id=$array['id'];
			$park=$array['parkcode'];
		$text.="<a href='pac_cal.php?edit=$id'>".$park."</a><br />";
		//	$text.=$park."<br />";
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