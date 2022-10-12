<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
extract($_REQUEST);
$level=$_SESSION['state_lakes']['level'];
$tempID=$_SESSION['state_lakes']['tempID'];
$passPark=$_SESSION['state_lakes']['select'];
date_default_timezone_set('America/New_York');

if($level<1){echo "You do not have access to this database."; exit;}


echo "<html><head>
</head>
<title>DPR State Lakes Site</title>";

	
//	echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<body><div align='center'>";

if($_SERVER['PHP_SELF']=="/state_lakes/prepare_letter_park.php")
	{
	echo "<img src='lawa_pier.jpg'>";
	include("menu.php");
	}

$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$sql="SELECT distinct YEAR from piers";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}
			

echo "<form method='POST' action='/state_lakes/print_letters_park.php'>";

echo "<hr><table>";
$this_year=date('Y');
echo "<tr><td><select name='year'>";
foreach($year_array as $k=>$v)
	{
	if($v==$this_year){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>";
	}
echo "</select></td></tr>";

echo "<tr><td>Print letters for: ";

			include("park_arrays.php");
					
			foreach($var_array as $k2=>$v2)
				{
				if($v2==@$_REQUEST['park']){$ck="checked";}else{$ck="";}
				echo "<input type='radio' name='park' value='$v2' $ck>$v2 ";
				}

echo "</td></tr>";

echo "<tr><td>Notification: 
<input type='radio' name='notify' value='annual' checked>Annual
<input type='radio' name='notify' value='final'>Final Notice
</td></tr>";

IF($passPark=="LAWA"){$due_date="June 15";}ELSE{$due_date="May 1";}
echo "<tr><td>Due date for the Fee(s) or Final Notice: 
<input type='text' name='due_date' value='$due_date'>
</td></tr>";

echo "<tr><td>Date Letter Sent: 
<input type='text' name='date_sent' value='' size='35'> (If left blank, today's date is used.)
</td></tr>";

echo "<tr><td>Limit: 
<input type='text' name='limit' value='3'>
</td></tr>";

echo "<tr><td>Last Name: 
<input type='text' name='billing_last_name' value=''>
</td></tr>";

echo "<tr><td colspan='6' align='center'><input type='submit' name='submit' value='Submit'></td></tr>";

echo "</table></form></div></body></html>";

?>