<?php
$database="sign";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

include("menu.php");       
//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
if(@$_GET['id']!="")
	{
	$sql = "DELETE FROM sign_list_1
	WHERE id='$_GET[id]'";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
	} 
	$sql = "SELECT * FROM sign_list_1 as t1 
	WHERE location='' and email=''
	order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
	if(mysqli_num_rows($result)<1){echo "No blank requests have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
		

		
echo "<table border='1' cellpadding='3'>";
echo "<tr><td colspan='".count($ARRAY[0])."'>Requests that have at least the LOCATION and EMAIL fields blank. Click the link in the id column to delete this request.</td></tr>";
foreach($ARRAY as $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($array as $k=>$v)
			{
			echo "<th>$k</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
		foreach($array as $k=>$v)
			{
			if($k=="id")
			{echo "<td><a href='admin.php?id=$v' onClick='return confirmLink()'>$v</a></td>";}
			else{echo "<td>$v</td>";}
			}
		echo "</tr>";
	}
echo "</table></body></html>";
?>