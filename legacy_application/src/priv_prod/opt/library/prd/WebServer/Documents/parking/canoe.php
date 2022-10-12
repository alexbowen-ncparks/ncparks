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
			{$park_array[]=$row['parkcode'];}
$space_array=array("space");
$edit_array=array("Canoes Request A","Canoes Request B");

mysqli_select_db($connection,$database); // database 

if(!empty($pass_edit))
	{
	$sql="SELECT  * from `canoe_dates` where 1 and date_id = '$pass_edit'";  
	$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{$existing_dates[$row['space']]=$row;}
	}
// **********************************************
if(!empty($_POST))
	{
// 	echo "canoe <pre>"; print_r($_POST); echo "</pre>";  exit;
	
	if(@$_SESSION['parking']['level']<1)
		{
		echo "While you can view the DPR Canoe reservation database without logging in, you must login in order to make changes. Click <a href='parking.html'>here</a> to login.";
	exit;
		}
	$emid=$_SESSION['parking']['emid'];
	$log_name=$_SESSION['parking']['log_name'];
	mysqli_select_db($connection,$database); // database 

	$skip_post=array("submit_form","pass_edit","name","comment","log_name");
// 	$replace_name=", name='$log_name'";

	
	
	$allow_del="";
	if($level<4)
		{
		$allow_del="and name='$log_name'";
		}
	if(empty($_POST['space']) and !empty($existing_dates))
		{
// 		echo "<pre>"; print_r($existing_dates); echo "</pre>"; // exit;
		foreach($existing_dates as $var_canoe=>$array)
			{
			$sql="DELETE FROM `canoe_dates` 
			where date_id = '$_POST[pass_edit]' $allow_del
			";  
			$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
			}
		}	
	
	if(!empty($existing_dates) and !empty($_POST['space']))
		{
// 		echo "61<pre>"; print_r($_POST); echo "</pre>"; // exit;
		foreach($edit_array as $k1=>$var_canoe)
			{
			if(empty($_POST['space'][$var_canoe]))
				{
				$sql="DELETE FROM `canoe_dates` 
				where date_id = '$_POST[pass_edit]' and space='$var_canoe' $allow_del
				"; 
				$result = @mysqli_query($connection,$sql) or die("$sql".mysqli_error($connection));
				
				}
			}
		foreach($edit_array as $k1=>$var_canoe)
			{
			if(!empty($_POST['park_code'][$var_canoe]) and array_key_exists($var_canoe, $_POST['space']))
				{
				if($level<4)
					{
// 					echo "<pre>"; print_r($existing_dates); echo "</pre>"; // exit;
					if(!empty($existing_dates[$var_canoe]['name']) and $existing_dates[$var_canoe]['name']!=$log_name)
						{continue;}
					}
				$pc=$_POST['park_code'][$var_canoe];
				$sql="REPLACE into canoe_dates 
				SET all_day='$pc',
				date_id = '$_POST[pass_edit]', space='$var_canoe', name='$log_name'";
// 				echo "$sql<br />"; exit;
				$result = @mysqli_query($connection,$sql) or die("$sql".mysqli_error($connection));
				
				}	
			}
		}
		
	if(empty($existing_dates))
		{
		foreach($_POST['park_code'] as $var_canoe=>$park)
			{
			if(empty($park)){continue;}
			$pc=$_POST['park_code'][$var_canoe];
			$sql="INSERT into canoe_dates 
			SET all_day='$pc',
			date_id = '$_POST[pass_edit]', space='$var_canoe', name='$log_name'";
			$result = @mysqli_query($connection,$sql) or die("$sql".mysqli_error($connection));		
		}	
	}
	
// 	if(!empty($existing_dates))
// 	{
// 	echo "<pre>"; print_r($existing_dates); echo "</pre>"; // exit;
			
		if(!empty($_POST['comment']))
			{
// 			echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
			foreach($_POST['comment'] as $index=>$value)
				{
					$comment=$value;
					$sql="UPDATE ignore canoe_dates 
				SET comment='$comment' where date_id = '$_POST[pass_edit]' AND space='$index'";  //echo "$sql"; exit;
				$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
			
				}
		}
// 	}
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
$sql="SELECT * from canoe_dates where date_id like '$check_month%' order by date_id, space"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$check_array[$row['date_id']][]=$row['space'];
	$array_all_day[$row['date_id']][]=$row['all_day'];
	}
if(empty($check_array)){$check_array=array();}
// echo "<pre>"; print_r($check_array); echo "</pre>"; // exit;

$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

?>

<table width="600" align='center' border='1'>

<?php
include("cal_array.php");  // lists the various items being tracked
	echo "<tr><form><td><font color='green'>Reservations for items: </font><select name='cal_type' onChange='this.form.submit()'>";
	foreach($cal_array as $k=>$v)
		{
		if($cal_type=="canoe" and $k=="canoe"){$s="selected";}else{$s="";}
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
<tr style='background-color:#ccffe6'>
<td align="center"><font color='green' size='+2'>DPR's Canoes</font>
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

// echo "ARRAY 215<pre>"; print_r($check_array); echo "</pre>"; // exit;

for ($i=0; $i<($maxday+$startday); $i++)
	{
		if(($i % 7) == 0 ) {echo "<tr>";}
		if($i < $startday) {echo "<td></td>";}
		else 
		{
		$day=($i - $startday + 1);
		$edit=$cYear."-".$pass_month."-".str_pad($day,2,"0",STR_PAD_LEFT);
		
		$display="<a href='cal.php?cal_type=canoe&pass_edit=$edit'>$day</a>";
		$pass_status="";
		if(isset($array_all_day[$edit]))
			{
			foreach($array_all_day[$edit] as $k=>$v)
				{
				@$pass_status.="<font color='red'>".$check_array[$edit][$k]."</font> ".$v."<br />";
				}
		
		}
		
		
		$td_color="white";
		if(str_pad($day,2,"0",STR_PAD_LEFT)==$pass_today)
			{$td_color="#F5F6CE";}
	
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
echo "<table align='center'><tr><td><font color='green'><i><b>The canoes will be stationed at Falls Lake when not in use.</b></i></font></td></tr></table>";

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
	include("canoe_edit.php");
	}

?>