<?php
$sql="SELECT * FROM contact_method";
$result=mysqli_query($connection, $sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_contact_method_code[]=$row['contact_method_code'];
	$ARRAY_contact_method_name[$row['contact_method_code']]=$row['contact_method_name'];
	}
	
$sql="SELECT * FROM contact_type";
$result=mysqli_query($connection, $sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_contact_type_code[]=$row['contact_type_code'];
	$ARRAY_contact_type_name[$row['contact_type_code']]=$row['contact_type_name'];
	}
?>