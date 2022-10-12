<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;


include("menu.php");

	$sql = "SELECT t1.* , t2.Lname, t2.Fname
	FROM `emplist` as t1
	left join empinfo as t2 on t1.emid=t2.emid
	WHERE t2.tempid='$ti'
	";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql ".mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
		
//echo "$sql";

$skip=array("updateon","listid","emid","tempID","password","password","itinerary","supervise","photoID","lead_for","Fname","Mname","Lname","jobtitle","posNum");
echo "
<table border='1'>
<tr><td>$row[Fname] $row[Lname]</td><td>$ti</td></tr>
<tr><td>db</td><td>level</td></tr>";

ksort($row);

foreach($row as $fld=>$val)
	{
	if(in_array($fld,$skip)){continue;}
	echo "<tr><td>$fld</td><td>$val</td></tr>";
	}
echo "</table></body></html>";

?>