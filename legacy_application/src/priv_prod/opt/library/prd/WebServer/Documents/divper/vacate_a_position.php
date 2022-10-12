<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
if(@$submit=="Add")
	{
	foreach($_POST as $k=>$v){
	if($k!="submit"){$string.="$k='".$v."', ";}
	}
	$string=trim($string,", ");
	
	$query="REPLACE vacant_admin SET $string";// echo "$query";exit;
	
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: findVacant.php");
	exit;
	}

include("menu.php");
// include("../../include/dist.inc");
//print_r($_REQUEST);//exit;
//print_r($_POST);exit;

	date_default_timezone_set('America/New_York');
// *************Entry Form 
echo "<html><head><title>Enter Emp Info</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige}
th
{font-size:95%;vertical-align:bottom}
--> 
</STYLE>
</head>
<body><font size='4' color='004400'>NC State Parks System Permanent Payroll</font>";

echo "<div align='center'>
<table><tr><td><font size='4' color='red'>ADD</font> <font size='3' color='blue'>a Position that needs to be marked as VACANT.</td></tr>
</table>";


echo "<form method='POST' action='vacate_a_position.php'><table><tr><td>
Position Number: <input type='text' name='beacon_num' value=\"\">
<input type='submit' name='submit' value=\"Search\">
</td></tr></table>";

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
if(!empty($_POST['beacon_num']))
	{
	$sql = "SELECT t1.currPark, t2.Fname, t2.Mname, t2.Lname
	From emplist as t1
	left join empinfo as t2 on t1.emid=t2.emid
	where t1.beacon_num='$beacon_num'
	";
//	 echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	
	if(!empty($ARRAY))
		{
		extract($ARRAY[0]);
		 echo "That position - $beacon_num - is already filled by $Fname $Mname $Lname at $currPark";  exit;
		}
	$sql = "SELECT *
	From position as t1
	where t1.beacon_num='$beacon_num'";
//	 echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1)
		{
		echo "($beacon_num) is either not a correct beacon number or that number has not been added to the database.";
		exit;
		}
	$sql = "SELECT *
	From vacant as t1
	where t1.beacon_num='$beacon_num'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1)
		{
		$d=date("m")."/".date("d")."/".date("Y");
		$sql = "REPLACE vacant set beacon_num='$beacon_num', dateVac='$d'";
	//	echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
		
	$query="REPLACE vacant_admin SET beacon_num=$beacon_num"; //echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	echo "Click the <a href='vacate_a_position.php'>link</a> to refresh the page.";
	exit;
	}


echo "</div></body></html>";

?>