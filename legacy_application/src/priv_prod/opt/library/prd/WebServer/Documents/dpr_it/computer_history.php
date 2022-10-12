<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$ARRAY_computer_history=array("rec_p"=>"Received at Park","sent_r"=>"Sent to Raleigh","rec_r"=>"Received in Raleigh","sent_p"=>"Sent to Park");

$sql="SELECT * from computers_history
where id='$id'
";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql");
IF(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$computer_history_array[]=$row;}
	}
	else
	{
	echo "No history for this computer. You may close this tab.";
	exit;
	}
$skip=array();
echo "<table><tr><td colspan='5'>History of movement for id = $id</td><td>Close tab when done.</td></tr>";
foreach($computer_history_array AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($computer_history_array[0] AS $fld=>$value)
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
		if($fld=="action")
			{$value.=" - ".$ARRAY_computer_history[$value];}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}