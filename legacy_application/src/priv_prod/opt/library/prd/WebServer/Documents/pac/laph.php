<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
// include("../../include/get_parkcodes_i.php"); 

extract($_REQUEST);

$database="divper";   // data is stored in divper, only the forms are stored in directory pac
// login is through the database "pac"

$title="Lake Phelps Advisory Committee"; 
include("/opt/library/prd/WebServer/Documents/pac/_base_top_pac.php");
$level=$_SESSION['pac']['level'];


mysqli_select_db($connection,$database);

$sql="SELECT person_id as id,affiliation_code as code, t2.First_name , t2.M_initial as Middle_name, t2.Last_name, t2.general_comments, t2.county, t2.email, t2.phone  
from labels_affiliation as t1
left join labels as t2 on t1.person_id=t2.id
where affiliation_code='LAPH'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
		
$skip=array("code");
$c=count($ARRAY);
echo "<table><tr><td colspan='10'>$c $title </td></tr>";
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
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</body></html>";	
?>