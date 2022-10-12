<?php
$database="travel";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

if(isset($_POST['id_string']))
	{
	foreach($_POST['id_string'] as $k=>$v)
		{		
		$sql = "UPDATE category set id_sort='$v' where id='$k'";
		$result = mysqli_query($connection,$sql);
		}
	}


if(isset($_POST))
	{
	extract($_POST);
	if(@$submit=="Add Category")
		{		
		$sql = "SELECT max(id_string) as var from category ";	//echo "$sql";exit;
		$result = mysqli_query($connection,$sql); $row=mysqli_fetch_assoc($result);
		$max_id=$row['var'];
		$next_id=$max_id+1;
			
		$sql = "UPDATE category set id=0 where id_string='18'";
		$result = mysqli_query($connection,$sql); 
		
		$sql = "INSERT INTO category set name='$name'";	//echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		$new_id=mysqli_insert_id($connection);
		
		$sql = "UPDATE category set id='$next_id', id_string='$next_id' where id='$new_id'";
		$result = mysqli_query($connection,$sql);
		
		$sql = "UPDATE category set id='$new_id' where id_string='18'";
		$result = mysqli_query($connection,$sql); 
		}
	}


include("menu.php");
 
$sql = "SELECT * FROM category as t1 
	WHERE 1 order by id_sort";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[$row['id_sort']]=$row['name'];
		}

echo "<form method='POST'><table>";

foreach($ARRAY as $fld=>$value)
	{
	
	echo "<tr>
	<td><input type='text' name='id_string[$fld]' value='$fld' size='3'></td>
	<td>$value</td>
	</tr>";
	}

echo "<tr><td><input type='submit' name='submit' value='Set Order'></td></tr></table></form>";

	echo "<table><tr><td colspan='2' align='right'><form method='POST'><input type='text' name='name'></td>
	<td><input type='submit' name='submit' value='Add Category'></form></td></tr>";
echo "</table>";
?>