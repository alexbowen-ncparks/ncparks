<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$passFile=$_SERVER['PHP_SELF'];
$passPark=$_SESSION['inspect']['select'];

//********** Personnel Safety Topic Files
$sql="SELECT * FROM personnel_safety order by title";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$personnel_safety_array[]=$row;
	}
//echo "<pre>"; print_r($personnel_safety_array); echo "</pre>"; // exit;

//********** Safety Topic Files
$sql="SELECT * FROM topics order by title";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$topic_array[]=$row;
	}
//echo "<pre>"; print_r($topic_array); echo "</pre>"; // exit;
//********** JHA Files
$sql="SELECT * FROM jha order by title";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$jha_array[]=$row;
	}
//echo "<pre>"; print_r($jha_array); echo "</pre>"; // exit;
//********** PowerPoint Files
$sql="SELECT * FROM powerpoint order by title";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$powerpoint_array[]=$row;
	}
//echo "<pre>"; print_r($powerpoint_array); echo "</pre>"; // exit;
//********** Vehicle Files
$sql="SELECT * FROM vehicle order by title";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$vehicle_array[]=$row;
	}
//echo "<pre>"; print_r($powerpoint_array); echo "</pre>"; // exit;//********** Vehicle Files

$sql="SELECT * FROM gas order by title";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$gas_array[]=$row;
	}
//echo "<pre>"; print_r($gas_array); echo "</pre>"; // exit;

$sql="SELECT * FROM shop order by title";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$shop_array[]=$row;
	}
//echo "<pre>"; print_r($shop_array); echo "</pre>"; // exit;




// *************** Daily Inspection
$sql="SELECT id,routine_inspect FROM routine order by routine_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$routine[$id]=$row['routine_inspect'];
	}

// Default file
$file="edit_inspection.php";

if($passFile=="/inspect/park.php")
	{
	$parkAdd=1;
	$file="add_park_inspection.php";
	}


// *************** Safety Topics
$sql="SELECT id, daily_inspect FROM daily_topics order by id";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$daily_topics[$id]=$row['daily_inspect'];
	}

// Default file
$file="edit_inspection.php";

if($passFile=="/inspect/park.php")
	{
	$parkAdd=1;
	$file="add_park_inspection.php";
	}

$f1="<font color='green'>";$f2="</font>";

$subunit="daily_inspect";
echo "<table border='1' cellpadding='5' align='center' bgcolor='yellow'>";

echo "<tr><td colspan='7' align='center'><a href='Training Attendance Sheet.doc'>Training Attendance Sheet</a></td></tr>";


echo "<tr>";

	$c=count($personnel_safety_array);
	echo "<td valign='top'>$c 
	<a onclick=\"toggleDisplay('personnel_safety');\" href=\"javascript:void('')\">$f1 Personnel Safety $f2</a>
<div id=\"personnel_safety\" style=\"display: none\">

	<table cellpadding='3'>";
	foreach($personnel_safety_array as $k=>$v)
		{
		extract($v);
		$action="<a href='$link'>$title</a>";
		echo "<tr><td align='left'>•&nbsp;$action</td></tr>";
		}
	echo "</table></div></td>";
	
	$c=count($topic_array);
	echo "<td valign='top'>$c 
	<a onclick=\"toggleDisplay('safety');\" href=\"javascript:void('')\">$f1 Safety $f2</a>
<div id=\"safety\" style=\"display: none\">

	<table cellpadding='3'>";
	foreach($topic_array as $k=>$v)
		{
		extract($v);
		$action="<a href='$link'>$title</a>";
		echo "<tr><td align='left'>•&nbsp;$action</td></tr>";
		}
	echo "</table></div></td>";

	$c=count($jha_array);
	echo "<td valign='top'>$c 
	<a onclick=\"toggleDisplay('jha');\" href=\"javascript:void('')\">$f1 JHA $f2</a>
<div id=\"jha\" style=\"display: none\">

	<table cellpadding='3'>";
	foreach($jha_array as $k=>$v)
		{
		extract($v);
		$action="<a href='$link'>$title</a>";
		echo "<tr><td align='left'>•&nbsp;$action</td></tr>";
		}
	echo "</table></div></td>";

	$c=count($powerpoint_array);
	echo "<td valign='top'>$c 
	<a onclick=\"toggleDisplay('powerpoints');\" href=\"javascript:void('')\">$f1 PowerPoint $f2</a>
<div id=\"powerpoints\" style=\"display: none\">

	<table cellpadding='3'>";
	foreach($powerpoint_array as $k=>$v)
		{
		extract($v);
		$action="<a href='$link'>$title</a>";
		echo "<tr><td align='left'>•&nbsp;$action</td></tr>";
		}
	echo "</table></div></td>";

	$c=count($vehicle_array);
	echo "<td valign='top'>$c 
	<a onclick=\"toggleDisplay('vehicle');\" href=\"javascript:void('')\">$f1 Vehicle $f2</a>
<div id=\"vehicle\" style=\"display: none\">

	<table cellpadding='3'>";
	foreach($vehicle_array as $k=>$v)
		{
		extract($v);
		$action="<a href='$link'>$title</a>";
		echo "<tr><td align='left'>•&nbsp;$action</td></tr>";
		}
	echo "</table></div></td>";
	
	$c=count($gas_array);
	echo "<td valign='top'>$c 
	<a onclick=\"toggleDisplay('gas');\" href=\"javascript:void('')\">$f1 Compressed Gas $f2</a>
<div id=\"gas\" style=\"display: none\">

	<table cellpadding='3'>";
	foreach($gas_array as $k=>$v)
		{
		extract($v);
		$action="<a href='$link'>$title</a>";
		echo "<tr><td align='left'>•&nbsp;$action</td></tr>";
		}
	echo "</table></div></td>";
	
	$c=count($shop_array);
	echo "<td valign='top'>$c 
	<a onclick=\"toggleDisplay('shop');\" href=\"javascript:void('')\">$f1 Shop Hazards $f2</a>
<div id=\"shop\" style=\"display: none\">

	<table cellpadding='3'>";
	foreach($shop_array as $k=>$v)
		{
		extract($v);
		$action="<a href='$link'>$title</a>";
		echo "<tr><td align='left'>•&nbsp;$action</td></tr>";
		}
	echo "</table></div></td>";
	
echo"</tr>";
echo "</table>";

// More Safety topics...
		
// *************** Daily Topics
$f1="<font color='red'>";$f2="</font>";

$subunit="routine";
echo "<table border='1' align='center'><tr valign='top'><td>$f1 Daily Inspection:$f2 ";
foreach($routine as $k=>$v)
	{
	if(@$parkAdd){$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}else{$action="$v";}
	echo "<table><tr><td align='left'>•&nbsp;$action</td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/home.php")
	{echo "<br /><a href='home.php?add=$subunit'>Add</a> an Item for this section.</td>";}

// ******************* Weekly Inspection
$sql="SELECT id,week_inspect FROM weekly order by week_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$week[$id]=$row['week_inspect'];
	}

$subunit="weekly";
echo "<td>$f1 Weekly Inspection:$f2 ";
foreach($week as $k=>$v)
	{
	if(@$parkAdd)
		{$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}
		else
		{$action="$v";}
	echo "<table><tr><td align='left'>•&nbsp;$action</td></tr></table>";
}
if($level>3 AND $passFile=="/inspect/home.php")
	{echo "<br /><a href='home.php?add=$subunit'>Add</a> an Item for this section.</td>";}


// ************************* Monthly
$sql="SELECT id,month_inspect FROM monthly order by month_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$month[$id]=$row['month_inspect'];
	}

$subunit="monthly";
echo "<td>$f1 Monthly Inspection:$f2 ";
echo "<table>
<tr><td align='left'>•&nbsp;<a href='forms/Worksite_Audit_20181212.doc'>Worksite Audit Form</a></td><td></td></tr>
</table>";
// <tr><td align='left'>•&nbsp;<a href='forms/Occupational Safety Audit Form.pdf'>Occupational Safety Audit Form</a></td><td></td></tr>

foreach($month as $k=>$v)
	{
		if(@$parkAdd){$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}else{$action="$v";}
		echo "<table><tr><td align='right'>•&nbsp;$action</td><td></td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/home.php")
	{echo "<br /><a href='home.php?add=$subunit'>Add</a> an Item for this section.</td>";}

// ************* Quarterly
$sql="SELECT id,quarter_inspect FROM quarterly order by quarter_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$quarter[$id]=$row['quarter_inspect'];
	}

$subunit="quarterly";
echo "<td>$f1 Quarterly Reports:$f2 ";
echo "<table>
<tr><td align='left'>•&nbsp;<a href='forms/DPR_Quarterly_Facility_Audit_2018.docx'>Quarterly Facility Safety Audits Form</a></td><td></td></tr>
</table>";
foreach($quarter as $k=>$v)
	{
		if(@$parkAdd){$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}else{$action="$v";}
		echo "<table><tr><td align='left'>•&nbsp;$action</td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/home.php")
	{echo "<br /><a href='home.php?add=$subunit'>Add</a> an Item for this section.</td>";}


// ************* Yearly
$sql="SELECT id,year_inspect FROM yearly order by year_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$year[$id]=$row['year_inspect'];
	}

$subunit="yearly";
echo "<td>$f1 Yearly Reports:$f2 ";
foreach($year as $k=>$v)
	{
	if(@$parkAdd)
		{$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}
		else
		{$action="$v";}
	echo "<table><tr><td align='left'>•&nbsp;$action</td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/home.php")
	{echo "<br /><a href='home.php?add=$subunit'>Add</a> an Item for this section.</td>";}

echo "</tr></table>";


?>