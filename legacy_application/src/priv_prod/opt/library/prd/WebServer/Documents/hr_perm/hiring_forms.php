<?php

date_default_timezone_set('America/New_York');
$database="hr_perm"; 
$dbName=$database;

include_once("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

include_once("../../include/get_parkcodes_reg.php");  // include iConnect.inc

mysqli_select_db($connection,$dbName);
$sql="SELECT * from hiring_forms where 1 order by sort_order"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
echo "<style>
.head {
font-size: 16px;
color: #999900;
}

table.alt_color tr:nth-child(odd) {
    background-color: #eeeedd;
    font-weight: bold;
    color: #666600;
    }
table.alt_color tr:nth-child(even) {
    background-color: #e5e5cc;
    font-weight: bold;
    color: #666600;
}
</style>";
$skip=array("id","sort_order");
$c=count($ARRAY);
echo "<table class='alt_color' border='1' cellpadding='4'><tr><td colspan='2' class='head'>DPR HR Forms for Hiring a New or Transferred Employee<br />(under development - not all forms available online)</td></tr>";
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
	if(empty($array['form_name'])){continue;}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(empty($value)){continue;}
		if($fld=="link")
			{
			if(!empty($value))
				{
				$value="<a href='$value'>Form</a>";
				}
				
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";




?>