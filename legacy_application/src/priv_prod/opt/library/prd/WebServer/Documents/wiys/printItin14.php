<?php
//ini_set('display_errors',1);

$database="wiys";
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);

include("../../include/auth.inc");

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
@$viewID=$tempID;// Used to pass variable when viewing someone else

$todayYMD=date("Y-m-d");

if(!isset($message)){$message="";}
headerStuff14($message);

//$tempID=$_SESSION[wiys][tempID];

include_once("../../include/iConnect.inc");
mysqli_select_db($connection,'divper');

$sql = "select IF(empinfo.Nname!='',empinfo.Nname,empinfo.Fname) AS Fname,empinfo.Lname,empinfo.tempID
from empinfo 
left join emplist on emplist.tempID=empinfo.tempID
where itinerary='$sectItin' order by Fname";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// echo "$sql";//exit;
while($row=mysqli_FETCH_ARRAY($result))
	{
	extract($row);
	$itinArray[]=$tempID;
	$FnameArray[]=$Fname;
	@$NnameArray[]=$Nname;
	$LnameArray[]=$Lname;
	}
//print_r($itinArray);//exit;

$itinList=array("CONS"=>"Design & Development","TESU"=>"Technical Support","PLNR"=>"Planning");

echo "<div align='center'><table><tr><td>Itinerary for $itinList[$sectItin]</td></tr>";
$d=date("W");$d2=$d+1;
echo "<tr><td>Weeks <font color='blue'>$d</font> and <font color='green'>$d2</font></td></tr></table>";

include("Make2Weeks.php");// function to make a week 
list($year,$month,$day)=explode("-",$todayYMD);
$week = get_weekdates($year,$month,$day);// array of weekdays

for($j=1;$j<=14;$j++)
	{
	$weekA[]=$week[$j]['year'].$week[$j]['month'].$week[$j]['day'];
	}

mysqli_select_db($connection,$database);

// Force an Update of ALL itineraries for $sectItin
for($f=0;$f<count($itinArray);$f++)
	{
	$empID=$itinArray[$f];
	$sql="SELECT day1,day2,day3,day4,day5,day6,day7, day8,day9,day10,day11,day12,day13,day14 FROM itinerary14 where empID='$empID'"; //echo "$sql<br />";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$total=mysqli_num_rows($result);
	
	while($row=mysqli_FETCH_ARRAY($result))
		{
		for($k=0;$k<14;$k++)
			{
			$dateItin=explode("~",$row[$k]);
			$dateID=$dateItin[0];
			$testVal[$empID][$dateID]=$dateItin[1];
			}
		
		for($zz=0;$zz<count($weekA);$zz++)
			{
			$testID=$weekA[$zz];
			@$dayItin[$empID][$weekA[$zz]]=$testVal[$testID];
			}
		
		//echo "$empID<pre>";print_r($dayItin);echo "</pre>";//exit;
		}
	
	}

//echo "<pre>";print_r(array_keys($testVal));echo "</pre>";//exit;
//exit;

echo "<table border='1' cellpadding='3' width='800'><tr><td>&nbsp;</td>";
for($k=0;$k<7;$k++)
	{
	$varY=substr($weekA[$k], 0, 4);$varM=substr($weekA[$k], 4, 2);
	$varD=substr($weekA[$k], 6, 2);
	
	// D = 3 char day l=full day
	$n1=date("l",mktime(0, 0, 0, $varM, $varD, $varY));
	$n2=date("F jS",mktime(0, 0, 0, $varM, $varD, $varY));
	
	if($k<7){$f1="<font color='blue'>";$f2="</font>";}
	if($k==7){echo "</tr><tr>";}
	if(@$newArray[$k]=="")
		{
		$displayItin="&nbsp;";}
		else
		{
		$displayItin=$newArray[$k];}
		
	$varDay="day".($k+1);$passDate="pass".($k+1);
	echo "<th bgcolor='#C0C0C0'>$f1$n1$f2<br>$n2</th>";
	}

for($m=0;$m<count($itinArray);$m++)
	{
	if($NnameArray[$m]!=""){$Fname=$NnameArray[$m];}else{$Fname=$FnameArray[$m];}
	$Lname=$LnameArray[$m];
	$sql="SELECT day1,day2,day3,day4,day5,day6,day7, day8,day9,day10,day11,day12,day13,day14,offHour
	FROM itinerary14
	left join status as s1 on s1.empID=itinerary14.empID
	where itinerary14.empID='$itinArray[$m]'";
	//echo "$sql";//exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$total=mysqli_num_rows($result);
	
	//echo "<pre>";print_r($weekA);echo "</pre>";
	
	while($row=mysqli_FETCH_ARRAY($result))
		{
		//echo "<pre>";print_r($row);echo "</pre>";//exit;
		$offHour=$row[14];
		
		echo "</tr><tr><td width='65' align='center'><b>$Fname</b><br />$Lname<br>$offHour</td>";
		
		for($k=0;$k<7;$k++)
			{
			@$displayItin=$testVal[$itinArray[$m]][$weekA[$k]];
			echo "<td align='center' width='75'>$displayItin</td>";
			}
		}
	}// end for $m


// ******************* Second Week *********************

//include("MakeAWeek.php");// function to make a week 

$day8=date('d')+7;// get next week
$todayYMD=date("Y-m-d");

list($year,$month,$day)=explode("-",$todayYMD);
$day=$day8;
$week = get_weekdates($year,$month,$day);// array of weekdays

$weekA="";
for($j=1;$j<=14;$j++){
$weekA[]=$week[$j]['year'].$week[$j]['month'].$week[$j]['day'];}

//include("../../include/connectWIYS.inc");

echo "<tr><td colspan='8'></td></tr><tr><td>&nbsp;</td>";
for($k=0;$k<7;$k++)
	{
	$varY=substr($weekA[$k], 0, 4);$varM=substr($weekA[$k], 4, 2);
	$varD=substr($weekA[$k], 6, 2);
	
	$n1=date("l",mktime(0, 0, 0, $varM, $varD, $varY));
	$n2=date("F jS",mktime(0, 0, 0, $varM, $varD, $varY));
	
	if($k<7){$f1="<font color='green'>";$f2="</font>";}
	if($k==7){echo "</tr><tr>";}
	if(@$newArray[$k]=="")
		{$displayItin="&nbsp;";}else{$displayItin=$newArray[$k];}
	
	$varDay="day".($k+1);$passDate="pass".($k+1);
	echo "<th bgcolor='#C0C0C0'>$f1$n1$f2<br>$n2</th>";
	}

for($m=0;$m<count($itinArray);$m++)
	{
	if($NnameArray[$m]!=""){$Fname=$NnameArray[$m];}else{$Fname=$FnameArray[$m];}
	$Lname=$LnameArray[$m];
	$sql="SELECT day8,day9,day10,day11,day12,day13,day14 FROM itinerary14 where empID='$itinArray[$m]'";
	//echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$total=mysqli_num_rows($result);
	
	while($row=mysqli_FETCH_ARRAY($result))
		{
		//echo "<pre>";print_r($row);echo "</pre>";//exit;
		@$offHour=$row[14];
		
		echo "</tr><tr><td width='65' align='center'><b>$Fname</b><br />$Lname<br>$offHour</td>";
		
		for($k=0;$k<7;$k++)
		{
		@$displayItin=$testVal[$itinArray[$m]][$weekA[$k]];
		echo "<td align='center'>$displayItin</td>";}
		}
	}// end for


echo "</form>"; // just a kludge to get around <form> in headerStuff();
echo "</tr><tr>
<td colspan='8' align='center'><form name='return' method='post' action='status14.php'>
<input type='hidden' name='u' value='1'>
<input type='hidden' name='tempID' value='$tempID'>
<input type='submit' name='Submit' value='Return'></form></td></tr>
</table></div></body></html>";

?>