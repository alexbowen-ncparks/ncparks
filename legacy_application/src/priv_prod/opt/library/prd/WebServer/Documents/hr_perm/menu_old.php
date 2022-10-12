<?php
$database="hr_perm";
if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION[$database]['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	ini_set('display_errors',1);


include("../../include/iConnect.inc"); // includes no_inject.php
mysqli_select_db($connection,$database);

$sql="SELECT * from manage_menu order by sort_order"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die();
while($row=mysqli_fetch_assoc($result))
	{
	$menu_array[$row['menu_item']][$row['menu_name']][$row['tab_name']]="";
	if($level<5 and $row['menu_item']=="admin"){continue;}
	$ARRAY[]=$row;
	$file_array[$row['menu_name']]=$row['menu_item'];
	}

// echo "<pre>"; print_r($file_array); echo "</pre>"; // exit;

echo "
<table bgcolor='#ABC578' cellpadding='2'>";

if($level>0) // 0
	{
	foreach($file_array as $k=>$v)
		{
		if($k=="Admin Functions"){$target="target='_blank'";}else{$target="";}
		echo "<tr><td><a href='menu_target.php?v=$v' $target>$k</a></td></tr>";
		}
	}


echo "</table>";


?>