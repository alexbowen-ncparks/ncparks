<?php

$level=@$_SESSION['parking']['level'];
$tempID=@$_SESSION['parking']['tempID'];
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

$database="parking";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,"dpr_system"); // database 

$sql="SELECT  parkcode from `dprunit_region` where 1";  
		$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{$space_array[]=$row['parkcode'];}
// $space_array=array("65","66","75");

mysqli_select_db($connection,$database); // database 
// **********************************************
if(!empty($_POST))
	{
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

	if(@$_SESSION['parking']['level']<1)
		{

		echo "While you can view the DPR Event Trailer database without logging in, you must login in order to make changes. Click <a href='parking.html'>here</a> to login.";
	exit;
		}
	$emid=$_SESSION['parking']['emid'];
	$log_name=$_SESSION['parking']['log_name'];


	mysqli_select_db($connection,$database); // database 
		$skip_post=array("submit_form","pass_edit","name","comment","log_name");
		if($level<4)
			{
		//	$ck_name="and name='$log_name'";
			$blank_name="and all_day='$log_name'";
			}
			else
			{
			$blank_name="";
			$ck_name="";
			}


		if(!EMPTY($_POST['space']))
			{
// 			echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
			$sql="SELECT  all_day from `van_dates`
			where date_id = '$_POST[pass_edit]' and space='$space' $blank_name
			";  
// 	echo "check record $sql<br />$blank_name<br />";   exit;
			$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
				{
				$exist[$space]=$row;
				}
			$sql="UPDATE van_dates 
			SET all_day=''
			where date_id = '$_POST[pass_edit]' and space='$space' $blank_name
			";  
			$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
			
			if(@$_POST['submit_form']=="Release Van")
				{
				$sql="DELETE FROM van_dates 
				where date_id = '$_POST[pass_edit]' and space='$space'
				";  
				$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
// 				echo "The van will now be available for that date.";
header("Location: cal.php?cal_type=van");
				exit;
				}
			}

$edit_array=array("all_day");
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;


		$sql="UPDATE ignore van_dates 
		SET all_day='$log_name'
		where date_id = '$_POST[pass_edit]' and space='$space' ";  
//echo "add update2 $sql<br /><br />"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
			$num=mysqli_affected_rows($connection);
			if($num<1)
			{
			$sql="INSERT ignore INTO van_dates 
		SET all_day='$_POST[all_day]', date_id = '$_POST[pass_edit]', space='$space'";  
//echo "n=$sql<br /><br />"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
					}
			
		if(!empty($_POST['comment']))
			{
			foreach($_POST['comment'] as $index=>$value)
				{
					$comment=$value;
					$sql="UPDATE ignore van_dates 
				SET comment='$comment' where date_id = '$_POST[pass_edit]' AND space='$space'";  
				$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
			
				}
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
$sql="SELECT * from van_dates where date_id like '$check_month%'"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$check_array[$row['date_id']]=$row['space'];
	}
if(empty($check_array)){$check_array=array();}
// echo "<pre>"; print_r($check_array); echo "</pre>"; // exit;

$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

?>

<table width="600" align='center' border='1'>

<?php
include("cal_array.php");  // lists the various items being tracked
	
	echo "<tr><form><td><select name='cal_type' onChange='this.form.submit()'>";
	foreach($cal_array as $k=>$v)
		{
		if($cal_type=="van" and $k=="van"){$s="selected";}else{$s="";}
		echo "<option value='$k' $s>$v</option>\n";
		}
	echo "</select></form></td></tr>";
	
?>

<tr align="center">
<td bgcolor="#999999" style="color:#FFFFFF">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="purple">
	<td align="left">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year . $prev_type; ?>" style="color:#FFFFFF">Previous</a></td>

	<td align="right"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year . $prev_type; ?>" style="color:#FFFFFF">Next</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
<tr style='background-color:#e6ffb3'>
<td align="center"><font color='green' size='+2'>DPR's 15 Passenger Van</font>
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
		
		$display="<a href='cal.php?cal_type=van&pass_edit=$edit'>$day</a>";
		
		
		@$pass_status=$check_array[$edit];
		
		
		$td_color="white";
		if(str_pad($day,2,"0",STR_PAD_LEFT)==$pass_today)
			{$td_color="#F5F6CE";}
		
		if(!empty($check_array[$edit]))
			{$td_color="red";}
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
echo "<table align='center'><tr><td><font color='green'><i><b>The van is stationed at the Yorkshire Center 12700 Bayleaf Church Road.</b></i></font><br /><br />If reserving the van, it is also your responsibility to coordinate returning the van to the Yorkshire Center in a timely manner.</td></tr></table>";

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
	include("van_edit.php");
	}

?>