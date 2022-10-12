<?php
$database="ware";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection, $database)
	   or die ("Couldn't select database $database");

$sql="select id, item_group from base_inventory where 1";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		$ARRAY[$id]=$item_group;
		}

foreach($ARRAY as $id=>$item_group)
	{
	if(isInteger($item_group) or empty($item_group))
		{
		echo "$id <br />";
		}
		else
		{
		echo "2 $item_group<br />";
		}
	}




function isInteger($input){
    return(ctype_digit(strval($input)));
}








?>