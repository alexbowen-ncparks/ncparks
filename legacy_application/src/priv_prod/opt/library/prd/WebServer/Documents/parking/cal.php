<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

session_start();
$level=@$_SESSION['parking']['level'];
$tempID=@$_SESSION['parking']['tempID'];
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

include("cal_array.php");  // lists the various items being tracked

$database="parking";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

// echo "<pre>"; print_r($cal_type); echo "</pre>"; // exit;
if(!empty($cal_type))
	{
	$prev_type="&cal_type=".$cal_type;
	if($cal_type=="van")
		{
		include("van.php");
		exit;
		}
	if($cal_type=="event")
		{
		include("event.php");
		exit;
		}
	if($cal_type=="festival")
		{
		include("festival.php");
		exit;
		}
	if($cal_type=="canoe")
		{
		include("canoe.php");
		exit;
		}
	}

$space_array=array("65","66","75");

// **********************************************
if(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
	if(@$_SESSION['parking']['level']<1)
		{
		echo "While you can view the Edenton Street Church parking space database without logging in, you must login in order to make changes. Click <a href='parking.html'>here</a> to login.";
	exit;
		}
$emid=$_SESSION['parking']['emid'];
$log_name=addslashes($_SESSION['parking']['log_name']);
// echo "$log_name";

mysqli_select_db($connection,$database); // database 
	$skip_post=array("submit","pass_edit","name","comment","log_name","lot");
	if($level<4)
		{
	//	$ck_name="and name='$log_name'";
		$blank_name="and (am_slot='$log_name' OR pm_slot='$log_name' OR all_day='$log_name')";
		}
		else
		{
		$blank_name="";
		$ck_name="";}


foreach($space_array as $space)
	{
	if(EMPTY($_POST[$space]))
		{
		$sql="SELECT  pm_slot, am_slot, all_day from `dates`
		where date_id = '$_POST[pass_edit]' and space='$space' $blank_name
		";  
//echo "check record $sql<br />$blank_name<br />";
		$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{$exist[$space]=$row;}
		$sql="UPDATE dates 
		SET pm_slot='', am_slot='', all_day=''
		where date_id = '$_POST[pass_edit]' and space='$space' $blank_name
		";  
//echo "empty update $sql<br />$blank_name<br />";
		$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
		}
	if(!empty($exist))
		{
		foreach($exist AS $var_space=>$array_names)
			{
			foreach($array_names as $var_slot=>$var_name)
				{
				if(!empty($var_name))
					{$pass_names[$var_space]=$var_name." on ".$_POST['pass_edit'];}
				}
			}
		}
	}
//echo "test<pre>"; print_r($pass_names); echo "</pre>"; // exit;
 //EXIT;

$edit_array=array("am_slot","pm_slot","all_day");
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
foreach($_POST as $space=>$array)
		{
	foreach($edit_array as $ck_fld)
				{
				if($space=="comment"){continue;}
				if(empty($_POST[$space][$ck_fld]))
					{
					$sql="UPDATE ignore dates 
					SET $ck_fld=''
					where date_id = '$_POST[pass_edit]' and space='$space' and $ck_fld='$log_name'";  
//echo "add update1 $sql<br /><br />"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
					}
				}
				
if(in_array($space,$skip_post)){continue;}
		foreach($array as $fld=>$value)
			{//$ck_name
			$sql="UPDATE ignore dates 
		SET $fld='$value'
		where date_id = '$_POST[pass_edit]' and space='$space' ";  
//echo "add update2 $sql<br /><br />"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
			$num=mysqli_affected_rows($connection);
			if($num<1){
//echo "n=$sql";exit;
					$sql="INSERT ignore INTO dates 
		SET $fld='$value', date_id = '$_POST[pass_edit]', space='$space'";  
//echo "n=$sql<br /><br />"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
					}
			}
		}
	foreach($_POST['comment'] as $space=>$value)
		{
			$comment=$value;
			$sql="UPDATE ignore dates 
		SET comment='$comment' where date_id = '$_POST[pass_edit]' AND space='$space'";  
		$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
			
		}
	}


extract($_REQUEST);
if(!empty($pass_edit))
	{
	$var_date=explode("-",$pass_edit);
	$_REQUEST['year']=$var_date[0];
	$_REQUEST['month']=$var_date[1];
	}
if (empty($_REQUEST["month"])) $_REQUEST["month"] = date("m");
if (empty($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

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
$sql="SELECT * from dates where date_id like '$check_month%'"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$check_array[]=$row['date_id']."-".$row['space'];
	}
if(empty($check_array)){$check_array=array();}

$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

?>

<table width="600" align='center' border='1'>
<?php

	echo "<tr><form><td><font color='green'>Reservations for items: </font><select name='cal_type' onChange='this.form.submit()'>";
	foreach($cal_array as $k=>$v)
		{
		if($cal_type=="parking" and $k=="parking"){$s="selected";}else{$s="";}
		echo "<option value='$k' $s>$v</option>\n";
		}
	echo "</select></form></td></tr>";
echo "<tr><td>For Division staff traveling to the downtown Raleigh area, please be aware that the Edenton Street Church parking lot is <font color='red'>no longer an option</font> to use. Visitors and staff coming to the Nature Research Center will need to use the pay lots or pay parking on the surrounding streets. (The best option is located behind the NRC, via W. Edenton Street, in the Green Square parking deck.) <br />
<a href='https://www.downtownraleigh.org/go/green-square-parking-deck'>https://www.downtownraleigh.org/go/green-square-parking-deck</a>
  <br/><br />
Staff with p-cards can use them to pay for parking when they come to NRC. Staff without p-cards can pay out of pocket and get reimbursed. Receipts are required along with an approved blanket travel request (TA) or an individually approved TA. Non-park staff/visitors are ineligible for reimbursement.
  <br/><br />
The database option for reserving the former parking spaces has been disabled. Sorry for the inconvenience.
  <br/><br />
Adrienne
  <br/><br />
Adrienne Eikinas
Executive Assistant
North Carolina State Parks
919-707-9336

 <br/><br /><font color='green'>Reservations for the other items (Van, Trailers, and Canoes) are still available in the drop-down menu.</font>
</td></tr></table>";
exit;
?>
<tr align="center">
<td bgcolor="#999999" style="color:#FFFFFF">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="purple">
	<td align="left">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF">Previous</a></td>

	<td align="right"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF">Next</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
<tr style='background-color:#ccffff'>
<td align="center"><font color='green' size='+2'>DPR Spaces @ Edenton Street Church Parking Lot</font>
	<table width="100%" border="1" cellpadding="2" cellspacing="2">
	<tr align="center">
	<td colspan="7" bgcolor="#999999" style="color:#FFFFFF">
	<font size="+3">
	<?php 
	$mn=@$monthNames[$cMonth-1].' '.$cYear;
	echo $mn; 
	
	?>
	</font></td>
	</tr>
	<tr>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
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
		if(($i % 7) == 0 ) {echo "<tr>";}
		if($i < $startday) {echo "<td></td>";}
		else 
		{
		$day=($i - $startday + 1);
		$edit=$cYear."-".$pass_month."-".str_pad($day,2,"0",STR_PAD_LEFT);
		
		if(empty($_REQUEST['lot']))
			{$display="<a href='cal.php?pass_edit=$edit'>$day</a>";}
			else
			{$display="<a href='cal.php?lot=77&pass_edit=$edit'>$day</a>";}
		
		
		if(($i % 7) == 0 ) {$display=$day; $status="";}
		if(($i % 7) == 6 ) {$display=$day;$status="";}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($space_array as $key=>$value)
	{
	$ck_edit=$edit."-".$value;
	$array_key=array_search($ck_edit,$check_array);
@$ck_status="<font color='green'>$value</font> ";
		if(in_array($ck_edit,$check_array) and $ARRAY[$array_key]['all_day']!="")
			{
			if($ARRAY[$array_key]['space']==$value)
				{$ck_status="<font color='red'>$value</font> ";}
			@$pass_status.=" ".$ck_status;			
			}
		elseif(in_array($ck_edit,$check_array) and $ARRAY[$array_key]['am_slot']!="")
			{
			if($ARRAY[$array_key]['space']==$value)
				{
				$ck_status="<font color='brown'>$value</font>a";
				if($ARRAY[$array_key]['pm_slot']!="")
					{$ck_status.="p";}
				}
			@$pass_status.=" ".$ck_status;			
			}
		elseif(in_array($ck_edit,$check_array) and $ARRAY[$array_key]['pm_slot']!="")
			{
			if($ARRAY[$array_key]['space']==$value)
				{$ck_status="<font color='brown'>$value</font>p ";}
			@$pass_status.=" ".$ck_status;			
			}
			else
			{@$pass_status.=" ".$ck_status;}
	}
		if(($i % 7) == 0 ) {$pass_status="";}
		if(($i % 7) == 6 ) {$pass_status="";}

		$td_color="white";
		if(str_pad($day,2,"0",STR_PAD_LEFT)==$pass_today)
			{$td_color="#F5F6CE";}
		if(str_pad($day,2,"0",STR_PAD_LEFT)==substr($pass_edit,-2))
			{$td_color="DarkKhaki";}
		echo "<td align='center' valign='middle' height='60px' bgcolor='$td_color'><font size='+3'>". $display . "</font><br />$pass_status</td>";
$pass_status="";
		}
		if(($i % 7) == 6 ) echo "</tr>";
	}
?>

	</table>
</td>
</tr>
</table>

<?php
echo "<table align='center'><tr><td><font color='red'><i><b>The parking spaces are NOT to be used on weekends, before 5am, or after 8pm.</b></i></font></td></tr></table>";

if(!empty($pass_names))
	{
mysqli_select_db($connection,"divper");

$bump_message="NOTICE:  Due to unforeseen circumstances, the Director’s office procured your parking reservation at the Edenton Street Church Parking Lot for urgent Division business.  Please park at the NRC visitor parking lot and use your purchasing card when you exit or pay cash.  Follow normal accounting procedures to prepare p-card reconcile or employee reimbursement forms at your home base.  Thank You";

	echo "<tr><td><font size='+2' color='red'>You have revoked the reservation for:</font><br />";
	foreach($pass_names as $var_space=>$var_value)
		{
		
$var=explode(" ",$var_value);
$sql = "SELECT t3.email, t3.phone, t3.work_cell,t3.Mphone
FROM emplist 
LEFT JOIN position as t2 on t2.beacon_num=emplist.beacon_num
LEFT JOIN empinfo as t3 on t3.tempID=emplist.tempID
WHERE t3.Lname = '$var[1]' AND (t3.Fname='$var[0]' OR t3.Nname='$var[0]')";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); extract($row);
	$name=$var[0]." ".$var[1];
		echo "$var_value for Space: $var_space &nbsp;&nbsp;&nbsp;Please <a href='bump.php?name=$name&date=$pass_edit&space=$value' target='_blank'>
Send an Email or Call</a> $var[0]<br />";
		}
	echo "</td></tr>";
	}

if(isset($pass_edit))
	{
	mysqli_select_db($connection,$database); // database 
	if(!empty($cal_type))
		{
		if($cal_type=="van")
			{
			include("van_edit.php");
			exit;
			}
		}
	include("cal_edit.php");
	}

?>