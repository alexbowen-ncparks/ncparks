<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$passFile=$_SERVER['PHP_SELF'];
$passPark=$_SESSION['inspect']['select'];

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

$f1="<font color='green'>";$f2="</font>";

$subunit="routine";
echo "<table border='1' align='center'><tr valign='top'><td>$f1 Routine:$f2 ";
foreach($routine as $k=>$v)
	{
	if(@$parkAdd){$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}else{$action="$v";}
	echo "<table><tr><td align='right'>$action</td><td></td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/overview.php")
	{echo "<br /><a href='overview.php?add=$subunit'>Add</a></td>";}


$sql="SELECT id,week_inspect FROM weekly order by week_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$week[$id]=$row['week_inspect'];
	}

$subunit="weekly";
echo "<td>$f1 Weekly:$f2 ";
foreach($week as $k=>$v)
	{
	if(@$parkAdd)
		{$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}
		else
		{$action="$v";}
	echo "<table><tr><td align='right'>$action</td><td></td></tr></table>";
}
if($level>3 AND $passFile=="/inspect/overview.php")
	{echo "<br /><a href='overview.php?add=$subunit'>Add</a></td>";}

$sql="SELECT id,month_inspect FROM monthly order by month_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$month[$id]=$row['month_inspect'];
	}

$subunit="monthly";
echo "<td>$f1 Monthly:$f2 ";
foreach($month as $k=>$v)
	{
		if(@$parkAdd){$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}else{$action="$v";}
		echo "<table><tr><td align='right'>$action</td><td></td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/overview.php")
	{echo "<br /><a href='overview.php?add=$subunit'>Add</a></td>";}

$sql="SELECT id,quarter_inspect FROM quarterly order by quarter_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$quarter[$id]=$row['quarter_inspect'];
	}

$subunit="quarterly";
echo "<td>$f1 Quarterly:$f2 ";
foreach($quarter as $k=>$v)
	{
		if(@$parkAdd){$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}else{$action="$v";}
		echo "<table><tr><td align='right'>$action</td><td></td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/overview.php")
	{echo "<br /><a href='overview.php?add=$subunit'>Add</a></td>";}

$sql="SELECT id,year_inspect FROM yearly order by year_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$year[$id]=$row['year_inspect'];
	}

$subunit="yearly";
echo "<td>$f1 Yearly:$f2 ";
foreach($year as $k=>$v)
	{
	if(@$parkAdd)
		{$action="<a href='$file?$subunit=$v&id=$k'>$v</a>";}
		else
		{$action="$v";}
	echo "<table><tr><td align='right'>$action</td><td></td></tr></table>";
	}
if($level>3 AND $passFile=="/inspect/overview.php")
	{echo "<br /><a href='overview.php?add=$subunit'>Add</a></td>";}

echo "</tr></table>";


?>