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

include("director_vacant_test.php");


// get total vacancies
$sql = "SELECT t2.beacon_title as 'BEACON Title', t2.section as 'Section', t2.posTitle as `Park Title`, count(t2.beacon_title) as num
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
where 1 and (t1.status!='' and t1.status!='Filled')
group by t2.beacon_title
order by t2.section, t2.beacon_title
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_title[]=$row;
	@$total+=$row['num'];
	}

$var_tv="<td>Total Vacancies</td><td>".$total." on ".date("Y-m-d")."</td>";
//    echo "<pre>"; print_r($ARRAY_title); echo "</pre>";  exit;

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

$sql = "SELECT t1.status, t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`, trim(t1.dateVac) as dateVac, str_to_date(t1.dateVac, '%m/%d/%Y') as new_date, str_to_date(t1.postClose, '%m/%d/%Y') as post_closed, t1.appToMan
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and (t1.status!='' and t1.status!='Filled' )
order by t2.park
";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$d=$row['new_date'];
	$pc=$row['post_closed'];
	$atm=trim($row['appToMan']);
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
		$tpc=strtotime($pc); 
		if(is_numeric($tpc))
			{
			if($tpc>$today and $atm=="" and $row['post_closed']!="0000-00-00")
				{
				$post_close_array[]=$row;}
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
echo "<table><tr><td colspan='2'>Date position vacated was:</td></tr>";
echo "<tr><td>greater than 365 days</td><td>$count_365</td></tr>";
echo "<tr><td>greater than 270 but less than 366</td><td>$count_270</td></tr>";
echo "<tr><td>greater than 180 but less than 271 days</td><td>$count_180</td></tr>";
echo "<tr><td>greater than 90 but less than 181</td><td>$count_90</td></tr>";
echo "<tr><td>90 days or less</td><td>$count_00</td></tr>";
echo "<tr><td>Pre-vacated</td><td>$count_future</td></tr>";
$vac_subtotal=$count_365+$count_270+$count_180+$count_90+$count_00+$count_future;
echo "<tr><td align='right'><b>Subtotal</b></td><td>$vac_subtotal</td></tr>";

echo "<tr><td>New position</td><td>".count($new)."</td>";
if(!empty($new))
	{
	echo "<td>"; print_r($new); echo "</td></tr>";
	}
if(!empty($not_numeric))
	{
	echo "<td>"; print_r($not_numeric); echo "</td></tr>";
	}
echo "<tr><td>No valid vacated date</td><td>".count($not_numeric)."</td>";
$vac_total=$vac_subtotal+count($new)+count($not_numeric);
echo "<tr><td align='right'><b>Total</b></td><td>$vac_total</td></tr></table><hr />";


@$ARRAY=$post_close_array;
// Posted = Posted Closing is less than today and Hiring Manager is blank
// echo "<pre>"; print_r($post_close_array); echo "</pre>"; // exit;
$skip=array("dateVac","new_date","appToMan");
$c=count($ARRAY);  $tot_pos=$c;
$today_date=date("Y-m-d");
echo "<table><tr><td colspan='5'><font size='+1' color='purple'>Posted = $c</font> Posted Closing is greater than today ($today_date) and Hiring Manager is empty</td></tr>";
if($c>1)
	{
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
	}
echo "</table><hr />";



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
$c=count($ARRAY);  $tot_pos+=$c;
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



// Screening = Posting Closed has value and postClose is less than today and Hiring Manager is empty.
unset($ARRAY);
$sql = "SELECT t1.status,t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`, str_to_date(t1.postClose, '%m/%d/%Y') as post_closed, t1.appToMan
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and (t1.postClose!='' and t1.appToMan='') and t3.tempID is NULL and t2.park!='' and t1.status!='filled'
order by t2.park
";
//echo "l=$level p=$pass_level<br />$sql<br /><br />"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$pc=$row['post_closed'];
	$ts=strtotime($pc); 
	if($ts>$today){continue;}
	$ARRAY[]=$row;
	}
//echo "Screening <pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip=array();
if(empty($ARRAY))
	{
	ECHO "<table><tr><td colspan='5'><font size='+1' color='purple'>Screening = 0</font> Posting Closed has value and postClose is less than today and Hiring Manager is empty and status is not \"Filled\".</td></tr>";
	}
	else
	{
	$c=count($ARRAY);  $tot_pos+=$c;
echo "<table><tr><td colspan='5'><font size='+1' color='purple'>Screening = $c</font> Posting Closed has value and postClose is less than today and Hiring Manager is empty and status is not \"Filled\".</td></tr>";
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
$c=count($ARRAY);  $tot_pos+=$c;
echo "<table><tr><td colspan='6'><font size='+1' color='purple'>Interviewing = $c</font> Hiring Mananger has date and Status not equal to Filled and these are empty - PASU/DISU, CHOP, HR Rep, Director</td></tr>";
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


// Awaiting HR approval = HR Manager has a date or HR Rep has a date but status is NOT filled and status is not 'Pending background'
unset($ARRAY);
$sql = "SELECT t1.status,t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`, t1.supToHR, t1.repToHRsup
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and (t1.repToHRsup!='' or t1.supToHR!='') and t1.status='Recruiting'
order by t2.park
";
// where 1 and (t1.repToHRsup!='' or (t1.status='Recruiting' and t1.supToHR!='')) and t1.status!='filled' and t1.status!='Pending background'
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY))
	{
	echo "<hr /><table><tr><td colspan='10'><font size='+1' color='purple'>Awaiting HR approval = 0</font> HR Manager has a date or HR Rep has a date and status is \"Recruiting\" </td></tr>";
	}
	else
	{
	$skip=array();
	$c=count($ARRAY);  $tot_pos+=$c;
	echo "<hr /><table><tr><td colspan='10'><font size='+1' color='purple'>Awaiting HR approval = $c</font> HR Manager has a date or HR Rep has a date and status is \"Recruiting\" </td></tr>";
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
	}
echo "</table>";
	

// Pending Background = Status is 'Pending background'
unset($ARRAY);
$sql = "SELECT t1.status,t1.beacon_num, t2.park, t2.beacon_title as 'BEACON Title', t2.posTitle as `Park Title`, t1.supToHR, t1.repToHRsup
from vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
left join emplist as t3 on t1.beacon_num=t3.beacon_num
where 1 and t1.status='Pending background'
order by t2.park
";
// where 1 and (t1.repToHRsup!='' or (t1.status='Recruiting' and t1.supToHR!='')) and t1.status!='filled' and t1.status!='Pending background'
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);  $tot_pos+=$c;
echo "<hr /><table><tr><td colspan='10'><font size='+1' color='purple'>Pending Background = $c</font> Status is \"Pending background\" </td></tr>";
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
$dif=$total-$tot_pos;
echo "<tr><td></td></tr>";
echo "<tr><td colspan='6'>$total - $tot_pos = $dif positions listed as vacant but not accouted for in the Status listings.</td></td>";
echo "</table>";





echo "</body></html>";
?>