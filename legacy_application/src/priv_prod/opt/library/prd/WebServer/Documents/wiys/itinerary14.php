<?php

ini_set('display_errors',1);

$database="wiys";
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);

include("../../include/auth.inc");
// extract($_REQUEST);
date_default_timezone_set('America/New_York');

// $e=code for an update error,  $u=code to return values after update
/*
echo "<pre>";
print_r($_REQUEST);
print_r($_SESSION);
echo "</pre>";
//EXIT;
*/

include("functions.php");
$viewID=$tempID;// Used to pass variable when viewing someone else

$todayYMD=date("Y-m-d");

// ************* Update **********
if(@$Submit=="Update")
	{
	//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
	
	$day1=$pass1."~".(addslashes($day1));
	$day2=$pass2."~".(addslashes($day2));
	$day3=$pass3."~".(addslashes($day3));
	$day4=$pass4."~".(addslashes($day4));
	$day5=$pass5."~".(addslashes($day5));
	$day6=$pass6."~".(addslashes($day6));
	$day7=$pass7."~".(addslashes($day7));
	$day8=$pass8."~".(addslashes($day8));
	$day9=$pass9."~".(addslashes($day9));
	$day10=$pass10."~".(addslashes($day10));
	$day11=$pass11."~".(addslashes($day11));
	$day12=$pass12."~".(addslashes($day12));
	$day13=$pass13."~".(addslashes($day13));
	$day14=$pass14."~".(addslashes($day14));
	
	$query = "replace itinerary14 set empID='$tempID',day1='$day1',day2='$day2',day3='$day3',day4='$day4', day5='$day5',day6='$day6',day7='$day7',day8='$day8',day9='$day9',day10='$day10',day11='$day11',day12='$day12',day13='$day13',day14='$day14'";
	$result = @mysqli_query($connection,$query) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	$query = "INSERT INTO itinerary14_track set empID='$tempID',day1='$day1',day2='$day2',day3='$day3',day4='$day4', day5='$day5',day6='$day6',day7='$day7',day8='$day8',day9='$day9',day10='$day10',day11='$day11',day12='$day12',day13='$day13',day14='$day14'";
// 	echo "$query"; exit;
	$result = @mysqli_query($connection,$query) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	header("Location: itinerary14.php?tempID=$tempID&v=1&loc=SODI&return=x"); exit;
	exit;
	}

// ************* End Update **********

// ************* After Update **********

$sql = "select * from itinerary14 where empID='$tempID'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$row=MYSQLI_FETCH_ARRAY($result);
extract($row);

// ************* Update Problem **************
if(@$u!="")
	{
	if($e=="0"){$message="<tr><td><font color='red' size=+1>Itinerary Updated</font></td></tr>";}
	if($e=="1")
		{
		$message="<tr><td><font color='red' size=+1>You failed to indicate your return time. Please correct.</font></td></tr>";
		}
	}// end if e
// ************* End Update Problem ************

if(!isset($message)){$message="";}
headerStuff14($message);
//$Fname=$_SESSION['wiys'][first];
//$Lname=$_SESSION['wiys'][last];
@$tempID=$_SESSION['wiys']['tempID'];


// *********** Check for Ability to Update
// *************** Validate **********
@$testPark=strtoupper($_SESSION['wiys']['parkS']);
if($testPark==$loc||$_SESSION['wiys']['level']>2){$v=1;}else{$v="";}

$testArrayCONS=array("Amoroso0038","Huband9514");
if($tempID=="Goss0610"){
if(in_array($viewID,$testArrayCONS)){$v=1;}
}

$testArrayCHOP=array("Burns0996");
if($tempID=="Williams5894"){
if(in_array($viewID,$testArrayCHOP)){$v=1;}
}

if($v==1)
	{
	$today=strtotime("now");
	
	$check=date("Ymd",$today);
	if($updateon<$check){$updateon=$check;}
	
	mysqli_select_db($connection,'divper');
	$sql = "select Nname,Fname,Lname from empinfo where tempID='$viewID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=MYSQLI_FETCH_ARRAY($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	echo "<table><tr><td>Itinerary for $Fname $Lname</td></tr>";
	$d=date("W");$d2=$d+1;
	echo "<tr><td>Weeks <font color='blue'>$d</font> and <font color='green'>$d2</font></td>";
	include("Make2Weeks.php");// function to make a week 
	list($year,$month,$day)=explode("-",$todayYMD);
	$week = get_weekdates($year,$month,$day);// array of weekdays
	
	//echo "<pre>";print_r($week);echo "</pre>";exit;
	for($j=1;$j<=14;$j++){
	$weekA[]=$week[$j]['year'].$week[$j]['month'].$week[$j]['day'];}
	
	//echo "<pre>";print_r($weekA);echo "</pre>";//exit;
	
	mysqli_select_db($connection,'wiys');
	$sql="SELECT day1,day2,day3,day4,day5,day6,day7, day8,day9,day10,day11,day12,day13,day14 FROM itinerary14 where empID='$viewID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$total=mysqli_num_rows($result);
	if($total<1){
	$sql = "INSERT INTO itinerary14 SET empID='$viewID'";
	$total_result = @mysqli_query($connection,$sql);
	//echo "$sql";exit;
	header("Location: itinerary14.php?tempID=$viewID&loc=$loc&return=x");
	}
	while($row=MYSQLI_FETCH_ARRAY($result)){
	//echo "<pre>";print_r($row);echo "</pre>";//exit;
	//extract($row);
	for($k=0;$k<14;$k++){
	$testVal[]=$row[$k];
	}
	//echo "<pre>testVal-";print_r($testVal);echo "</pre>";//exit;
	sort($testVal);
	//echo "<pre>testVal-";print_r($testVal);echo "</pre>";//exit;
	
	for($varW=0;$varW<14;$varW++)
		{
		$var=explode("~",$testVal[$varW]);
		if(in_array($var[0],$weekA)){$dateItin[]=$var[0];$itin[]=$var[1];}
		}
	
	if(isset($dateItin))
		{
		for($zz=0;$zz<count($dateItin);$zz++)
			{
			$key=array_search($dateItin[$zz],$weekA);
			$newArray[$key]=$itin[$zz];
			}
		}
	//echo "<pre>dateItin-";print_r($dateItin);echo "</pre>";//exit;
	//echo "<pre>itin-";print_r($itin);echo "</pre>";//exit;
	//echo "<pre>newArray-";print_r($newArray);echo "</pre>";//exit;
	
	echo "</tr><tr>";
	for($k=0;$k<14;$k++)
		{
		$varY=substr($weekA[$k], 0, 4);$varM=substr($weekA[$k], 4, 2);
		$varD=substr($weekA[$k], 6, 2);
		$n=date("D - F jS",mktime(0, 0, 0, $varM, $varD, $varY));
		if($k<7){$f1="<font color='blue'>";$f2="</font>";}else{$f1="<font color='green'>";$f2="</font>";}
		if($k==7){echo "</tr><tr>";}
		$varDay="day".($k+1);$passDate="pass".($k+1);
		$passVar="<input type='hidden' name='$passDate' value='$weekA[$k]'>";
		
		if(!isset($newArray[$k])){$newArray[$k]="";}
		echo "<td>$f1$n$f2<br><textarea name='$varDay' cols='15' rows='2'>$newArray[$k]</textarea>$passVar</td>";
		}
	}
	
	echo "</tr><tr><td>&nbsp;</td><td width='150' align='center'>
	<input type='hidden' name='tempID' value='$viewID'>
	<input type='submit' name='Submit' value='Update'></td></form>
	<td><form name='return' method='post' action='status14.php'>
	<input type='hidden' name='tempID' value='$tempID'>
	<input type='submit' name='Submit' value='Return'></td></form></tr>
	</table></body></html>";}
else
	{ // cannot update
	mysqli_select_db($connection,'divper');
	$sql = "select Nname,Fname,Lname from empinfo where tempID='$viewID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	//echo "$sql";exit;
	$row=MYSQLI_FETCH_ARRAY($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	echo "<table><tr><td>Itinerary for $Fname $Lname</td></tr>";
	$d=date("W");$d2=$d+1;
	echo "<tr><td>Weeks <font color='blue'>$d</font> and <font color='green'>$d2</font></td>";
	include("Make2Weeks.php");// function to make a week 
	list($year,$month,$day)=explode("-",$todayYMD);
	$week = get_weekdates($year,$month,$day);// array of weekdays
	
	for($j=1;$j<=14;$j++){
	$weekA[]=$week[$j]['year'].$week[$j]['month'].$week[$j]['day'];}
	
	mysqli_select_db($connection,'wiys');
	$sql="SELECT day1,day2,day3,day4,day5,day6,day7, day8,day9,day10,day11,day12,day13,day14 FROM itinerary14 where empID='$viewID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$total=mysqli_num_rows($result);
	if($total<1){
	$sql = "INSERT INTO itinerary14 SET empID='$viewID'";
	$total_result = @mysqli_query($connection,$sql);
	//echo "$sql";exit;
	header("Location: itinerary14.php?tempID=$viewID&loc=$loc&return=x");
	}
	while($row=MYSQLI_FETCH_ARRAY($result)){
	for($k=0;$k<14;$k++){
	$testVal[]=$row[$k];
	}
	for($varW=0;$varW<14;$varW++){
	$var=explode("~",$testVal[$varW]);
	if(in_array($var[0],$weekA)){$dateItin[]=$var[0];$itin[]=$var[1];}
	}
	
	if(isset($dateItin))
		{
		for($zz=0;$zz<count($dateItin);$zz++)
			{
			$key=array_search($dateItin[$zz],$weekA);
			$newArray[$key]=$itin[$zz];
			}
		}
	
	echo "</tr></table><table border='1' cellpadding='3'><tr>";
	$f2="</font>";
	for($k=0;$k<14;$k++){
	$varY=substr($weekA[$k], 0, 4);$varM=substr($weekA[$k], 4, 2);
	$varD=substr($weekA[$k], 6, 2);
	$n=date("D - F jS",mktime(0, 0, 0, $varM, $varD, $varY));
	if($k<7){$f1="<font color='blue'>";}else{$f1="<font color='green'>";}
	if($k==7){echo "</tr><tr>";}
	if(@$newArray[$k]=="")
		{
		$displayItin="&nbsp;";
		}
		else
		{
		$displayItin=$newArray[$k];
		}
	$varDay="day".($k+1);$passDate="pass".($k+1);
	echo "<td>$f1$n$f2<br>$displayItin</td>";
	}
	}
	echo "</form>"; // just a kludge to get around <form> in headerStuff();
	echo "</tr><tr>
	<td colspan='7' align='center'><form name='return' method='post' action='status14.php'>
	<input type='hidden' name='u' value='1'>
	<input type='hidden' name='tempID' value='$tempID'>
	<input type='submit' name='Submit' value='Return'></form></td></tr>";
	if($tempID=="Ledford8149")
		{
		echo "<tr><td colspan='7' align='center'><form name='osax' method='post' action='http://127.0.0.1:8888/osax.php'>
		<input type='submit' name='Submit' value='Update iCal for This Week'></form></td></tr>";
		}
	
	echo "</table></body></html>";
	}
if($v==1)
	{
	include("status14.php");
	}

?>