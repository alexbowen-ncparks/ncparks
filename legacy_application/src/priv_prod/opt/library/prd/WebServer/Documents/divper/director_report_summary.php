<?php
//These are placed outside of the webserver directory for security
$database="divper";
date_default_timezone_set('America/New_York');
include("../../include/auth_i.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
if($level>3)
	{
	ini_set('display_errors',1);
	}
include("../../include/get_parkcodes_reg.php");
include("menu.php");
//print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
// ************ Process input
extract($_REQUEST);

$level=$_SESSION['divper']['level']; 
mysqli_select_db($connection,$database); // database

// include("director_vacant_test.php");

// get total vacancies
// 2.beacon_title as 'BEACON Title',
$sql = "SELECT  t2.section as 'Section', t2.posTitle as `Working Title`, count(t2.beacon_title) as num
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
where 1 and (t1.status!='' and t1.status!='Filled')
group by t2.beacon_title
order by t2.section, t2.posTitle
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_title[]=$row;
	@$total+=$row['num'];
	}

$var_tv="Total Vacancies: ".$total;
//    echo "<pre>"; print_r($ARRAY_title); echo "</pre>";  exit;

// Pending Post = Status field = Posted.
unset($ARRAY);
$sql = "SELECT t1.status,t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and t1.status='Pending Post'
order by t2.park
";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<table><tr><td colspan='5'><font size='+1' color='purple'>Pending Post = $c</font> Status = Pending Post</td></tr>";
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
		if($fld=="beacon_num"){$value="<a href='trackPosition.php?beacon_num=$value' target='_blank'>$value</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table><hr />";



// Screening = Posting Closed has value and Hiring Manager is empty.
unset($ARRAY);
$sql = "SELECT t1.status,t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`, t1.postClose, t1.appToMan
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and (t1.postClose!='' and t1.appToMan='') and t3.tempID is NULL and t2.park!=''
order by t2.park
";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
$my=date("F, Y");

echo "<table>

<tr><td colspan='2'><h3>Monthly Vacancy Statistics: $my</h3></td></tr>
<tr><td colspan='2'><h3>Date of Report: ".date("Y-m-d")."</h3></td><td colspan='2'><h3>$var_tv</h3></td></tr>

<tr><td colspan='5'><font size='+1' color='purple'>Screening = $c</font> Posting Closed has value and Hiring Manager is empty.</td></tr>";
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
		if($fld=="beacon_num"){$value="<a href='trackPosition.php?beacon_num=$value' target='_blank'>$value</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table><hr />";


// Interviewed = Hiring Mananger has date and Status not equal to Filled and these are empty - PASU/DISU, CHOP, HR Rep, Director
unset($ARRAY);
$sql = "SELECT t1.status,t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`, t1.appToMan, t1.recToSup, t1.supToSup, t1.supToHR, t1.hrToDir
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and t1.appToMan!='' and t1.recToSup='' and t1.supToSup='' and t1.supToHR='' and t1.hrToDir='' and t1.status!='filled'
order by t2.park
";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<table><tr><td colspan='6'><font size='+1' color='purple'>Interviewed = $c</font> Hiring Mananger has date and Status not equal to Filled and these are empty - PASU/DISU, CHOP, HR Rep, Director</td></tr>";
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
		if($fld=="beacon_num"){$value="<a href='trackPosition.php?beacon_num=$value' target='_blank'>$value</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";


// Awaiting HR approval = HR Manager has a date but status is NOT filled
unset($ARRAY);
$sql = "SELECT t1.status,t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`, t1.appToMan, t1.recToSup, t1.supToSup, t1.supToHR, t1.hrToDir, t1.repToHRsup
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and t1.repToHRsup!='' and t1.status!='filled'
order by t2.park
";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<hr /><table><tr><td colspan='6'><font size='+1' color='purple'>Awaiting HR approval = $c</font> HR Manager has a date but status is NOT \"Filled\"</td></tr>";
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
		if($fld=="beacon_num"){$value="<a href='trackPosition.php?beacon_num=$value' target='_blank'>$value</a>";}
		if($fld=="supToHR"){$value="<strong>$value</strong>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table><hr />";


$skip=array();
$c=count($ARRAY_title);
echo "<table>";
foreach($ARRAY_title AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_title[0] AS $fld=>$value)
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
		echo "<td align='right'>$value</td>";
		if($fld=="num")
			{
			@$tot+=$value;
			}
		}
	echo "</tr>";
	}
echo "<tr><td></td><td></td><td></td><td align='right'>$tot</td></table><hr />";





$sql = "SELECT status, count(status) as number
from vacant
where 1 and (status!='' and status!='Filled')
group by status
";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	
$var_365=strtotime("-365 day"); $count_365=0;
$var_270=strtotime("-270 day"); $count_270=0;
$var_180=strtotime("-180 day"); $count_180=0;
$var_90=strtotime("-90 day"); $count_90=0;
$var_90=strtotime("-1 day"); $count_00=0;
$count_future=0;
$today=time();
$no_date=0;
$new=array();
$not_numeric=array();

$sql = "SELECT beacon_num, trim(dateVac) as dateVac, str_to_date(dateVac, '%m/%d/%Y') as new_date, status
from vacant
where 1 and (status!='' and status!='Filled')
";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$d=$row['new_date'];
	if($row['new_date'] == NULL)
		{
		$new[]=$row['beacon_num'];
		continue;
		}
	if($row['new_date'] == "0000-00-00")
		{$not_numeric[]=$row['beacon_num'];}
		
		$ts=strtotime($d); 
		if(is_numeric($ts))
			{
			$numeric[]=$row['beacon_num'];
			}
		if($ts<=$var_365){$count_365++;}
		if($ts>$var_365 and $ts<=$var_270){$count_270++;}
		if($ts>$var_270 and $ts<=$var_180){$count_180++;}
		if($ts>$var_180 and $ts<=$var_90){$count_90++;}
		if($ts>$var_90 and $ts<=$today){$count_00++;}
		if($ts>$today){$count_future++;}
		
		$d=$d." - ".date("jS F, Y", $ts)." - ".$var_365;

	$b=$row['beacon_num'];
	@$i++;
	$ARRAY_date_vacant[$row['beacon_num']]=$ts." ".$d." ".$i;
// 	$ARRAY_date_vacant[$row['beacon_num']]=$b;
	}

echo "<table border='1' cellpadding='3'>
<tr><td colspan='2'>Date position vacated was:</td></tr>";
echo "<tr><td>&nbsp;&nbsp;greater than or equal to 365 days</td><td align='right'>$count_365</td></tr>";
echo "<tr><td>&nbsp;&nbsp;greater than or equal to 270 but less than 365</td><td align='right'>$count_270</td></tr>";
echo "<tr><td>&nbsp;&nbsp;greater than or equal to 180 but less than 270 days&nbsp;&nbsp;</td><td align='right'>$count_180</td></tr>";
echo "<tr><td>&nbsp;&nbsp;greater than 90 but less than 180</td><td align='right'>$count_90</td></tr>";
echo "<tr><td>&nbsp;&nbsp;90 days or less</td><td align='right'>$count_00</td></tr>";
echo "<tr><td>&nbsp;&nbsp;Pre-vacated</td><td align='right'>$count_future</td></tr>";
$vac_subtotal=$count_365+$count_270+$count_180+$count_90+$count_00+$count_future;
echo "<tr><td align='right'><b>Subtotal</b></td><td align='right'>$vac_subtotal</td></tr>";

echo "<tr><td>&nbsp;&nbsp;New position</td><td align='right'>".count($new)."</td>";
if(!empty($new))
	{
	echo "<td>"; print_r($new); echo "</td></tr>";
	}
if(!empty($not_numeric))
	{
	echo "<td>"; print_r($not_numeric); echo "</td></tr>";
	}
echo "<tr><td>&nbsp;&nbsp;No valid vacated date</td><td align='right'>".count($not_numeric)."</td>";
$vac_total=$vac_subtotal+count($new)+count($not_numeric);
echo "<tr><td align='right'><b>Total</b></td><td>$vac_total</td></tr></table><hr />";

// echo "<pre>"; print_r($new); echo "</pre>"; // exit;
// echo "<pre>"; print_r($not_numeric); echo "</pre>"; // exit;

// $skip=array();
// $c=count($ARRAY);
// echo "<table>";
// foreach($ARRAY AS $index=>$array)
// 	{
// 	if($index==0)
// 		{
// 		echo "<tr>";
// 		foreach($ARRAY[0] AS $fld=>$value)
// 			{
// 			if(in_array($fld,$skip)){continue;}
// 			echo "<th>$fld</th>";
// 			}
// 		echo "</tr>";
// 		}
// 	echo "<tr>";
// 	foreach($array as $fld=>$value)
// 		{
// 		if(in_array($fld,$skip)){continue;}
// 		@$tot+=$value;
// 		echo "<td>$value</td>";
// 		}
// 	echo "</tr>";
// 	}
// echo "<tr>$var_tv</tr>";  // line 31
// echo "</table>";

// Pending Posting
// Posted


echo "</body></html>";
?>