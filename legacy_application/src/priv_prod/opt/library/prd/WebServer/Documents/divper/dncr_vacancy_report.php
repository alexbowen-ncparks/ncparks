<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
$db="divper";
mysqli_select_db($connection,$database);


include("menu.php");
$sql="SHOW columns
FROM dncr_vacancy";  // Human Resource Manager
$result = mysqli_query($connection,$sql) or die ();
while($row=mysqli_fetch_assoc($result))
	{
	$dncr_vacancy_flds[]=$row['Field'];
	}
echo "<pre>"; print_r($dncr_vacancy_flds); echo "</pre>"; // exit;

$sql="SELECT t1.Fname, t1.Lname 
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
WHERE t3.beacon_num='60033136'";  // Human Resource Manager
$result = mysqli_query($connection,$sql) or die ();
$row=mysqli_fetch_assoc($result);
extract($row);
$div_hr_manager="$Fname $Lname";
		
	$sql="SELECT t1.beacon_num, t2.code_reg, t2.beacon_title, t2.current_salary, t2.fund_source
	FROM vacant_excel as t1
	LEFT JOIN position as t2 on t1.beacon_num=t2.beacon_num
	where 1	
	";
	$result = mysqli_query($connection,$sql) or die ();
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_div_vacant[]=$row;
		}
		
$skip=array("vid","posNum","","");
$c=count($ARRAY_div_vacant);
echo "<table><tr><td>$c</td></tr>";
foreach($ARRAY_div_vacant AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_div_vacant[0] AS $fld=>$value)
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
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table></body></html>";

?>