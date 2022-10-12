<?php
//echo "<table><tr><td>beacnum</td><td>$beacnum</td></tr></table>";


$query0="select myreports_only from cash_handling_roles where tempid='$tempid'";
//echo "<br /><br />query0=$query0<br /><br />";
$result0 = mysqli_query($connection,$query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
if($row0)
	{
extract($row0);//brings back max (end_date) as $end_date
}

if(empty($myreports_only)){$myreports_only="";}

//echo "<br /><br />myreports_only=$myreports_only<br />";
if($myreports_only=='y')
{

$tempid2=substr($tempid,0,-2);
if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}

/*
echo "<table align='center'><tr><th>
<a href='/budget/infotrack/position_reports.php?menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img><br /><font color='brown'>My<br />Reports</font>
</a></th>";

echo "<th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><font color='green'>$concession_location2<br /> $tempid2</font>
</th>";
echo "</tr></table>";
*/


if($concession_location=='ADM'){$concession_location='ADMI';}
//10-25-14
//$query2="select center_desc,center from center where parkcode='$concession_location' and fund='1280'   ";	
$query2="select center_desc from center where parkcode='$concession_location' and fund='1280'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection,$query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

echo "<br /><br />center_location=$center_location<br />";
echo "<table align='center'>";
echo "<tr>";	
echo "<th>
<a href='/budget/infotrack/position_reports.php?menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";
	if(!isset($concession_center)){$concession_center="";}
	$pc="<br /><font color='brown'>".$center_location." - $concession_center</font>";
	
	echo "<td colspan='8' align='center'><font size='+1'><b>NC State Parks MoneyCounts</b>$pc</font></td>";


$tempid2=substr($tempid,0,-2);
if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}
echo "<th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><font color='green'>$concession_location2<br /> $tempid2</font>
</th>";




	
	echo "</tr>";
	
	echo "</table>";











}

else

{

echo "<table align='center'>";
echo "<tr>";	
	//if($level < '3' or $beacnum=='60032780' or $beacnum=='60032945' or $beacnum=='60092637' or $beacnum=='60033189' or $beacnum=='60033242' )
	if($level < '3')
{
echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";
}
else
//10-25-14
/*
{
echo "<th>
<a href='/budget/home.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";
}
*/
{
echo "<th>
<a href='/budget/menu1314.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";
}




if($concession_location=='ADM'){$concession_location='ADMI';}
//10-25-14
//$query2="select center_desc,center from center where parkcode='$concession_location' and fund='1280'   ";	
$query2="select center_desc from center where parkcode='$concession_location' and fund='1280'   ";	

//echo "<br /><br />query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection,$query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

//echo "center_location=$center_location<br />";
	

	if(!isset($concession_center)){$concession_center="";}
	$pc="<br /><font color='brown'>".$center_location." - $concession_center</font>";
	
	echo "<td colspan='8' align='center'><font size='+1'><b>NC State Parks MoneyCounts</b>$pc</font></td>";


$tempid2=substr($tempid,0,-2);
if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}
echo "<th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><font color='green'>$concession_location2<br /> $tempid2</font>
</th>";




	
	echo "</tr>";
	
	echo "</table>";
	}
	//echo "parkcode=$parkcode<br />";
?>