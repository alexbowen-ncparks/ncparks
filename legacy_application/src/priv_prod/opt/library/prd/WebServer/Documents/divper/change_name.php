<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database); // database

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
	
unset($ARRAY_change_db);
$sql = "SELECT * from change_last_name
WHERE 1
order by db_name";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_change_db[]=$row;
	}

if(@$submit=="Change")
	{
	$sql = "SELECT tempID as current_tempID, Fname, Lname, concat(Fname, ' ', Mname, ' ', Lname) as old_full_name
	from empinfo
	WHERE tempID='$old_tempID'
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_assoc($result);
	extract($row);
	echo "<pre>"; print_r($_POST);  print_r($row); echo "</pre>";  //exit;
	
	$sql = "UPDATE empinfo
	set tempID='$new_tempID', Lname='$new_last_name'
	WHERE tempID='$old_tempID'
	";
	echo "$sql<br /><br />";   //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

// 	echo "<pre>"; print_r($ARRAY_change_db); echo "</pre>"; // exit;
	foreach($ARRAY_change_db as $index=>$array)
		{
		extract($array);
		if($table_name=="empinfo"){continue;} // values already changed line 33
		if(empty($table_name)){continue;} // values already changed line 33
		mysqli_select_db($connection,$db_name); // database
		$temp="$field_name='$new_tempID'";
		$where="$field_name='$old_tempID'";
		if($comment=="full name")
			{
			$temp="$field_name=replace($field_name, '$old_full_name', '$Fname $new_last_name')";
			$where="$field_name like '%$old_full_name%'";
			}
		
		if($comment=="Last name")
			{
			$temp="$field_name='$new_last_name'";
			$where="$field_name='$old_last_name'";
			}
		
		if($comment=="tag")
			{
			$temp="$field_name=replace($field_name, '$old_tempID', '$new_tempID')";
			$where="$field_name like '$new_tempID%'";
			}
				
		$sql="UPDATE $table_name SET $temp
		where $where";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
// 		echo "$index - $db_name $sql<br /><br />";
		}
	} // end Change

//  ************Start input form*************

include("menu.php");

if($_SESSION['divper']['level']>4)
	{
	echo "
	<table align='left'><tr><td><font size='4' color='004400'>SuperAdmin Form - Personnel Database to Change Last Name</font></td></tr>";
	
	if(!empty($message)){echo "<tr><td>$message</td></tr>";}
	
	if(!empty($Lname)){$pass_Lname=$Lname;}else{$pass_Lname="";}
	
	echo "<tr><td><form method='post' action='change_name.php'>
	<input type='text' name='Lname' value=\"$pass_Lname\">
	<input type='submit' name='submit' value='Existing Last Name'></form></td>
	</tr></table><br /><br /><br /><br />"; 
	}
if(empty($_REQUEST))
		{
		exit;
		}	
$pass_Lname=$Lname;
@$pass_tempID=$tempID;

mysqli_select_db($connection,"divper"); // database
$sql = "SELECT emid, tempID, Fname, Lname as Lname1, '' as Lname2 from empinfo
WHERE Lname like '$Lname%'
UNION
SELECT emid, tempID, Fname, '', Lname as Lname2 from empinfo
WHERE tempID like '$Lname%'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	$temp_name=substr($tempID,0,-4); //echo "$temp_name<br />";
// 	if($temp_name==$Lname1 or $temp_name==$Lname2){continue;}
	$ARRAY[]=$row;
	}
if(empty($ARRAY))
	{
	ECHO "No one found using $Lname";
	exit;
	}
// echo "$sql <pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(!empty($ARRAY))
	{
	echo "<table border='1'  cellpadding='10'>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($fld=="tempID")
				{
				$value="<a href='change_name.php?Lname=$pass_Lname&tempID=$value'>$value</a>";
				}
			if($fld=="Lname2")
				{
				if($value!=$Lname)
					{
					$value="<font color='red'>$value</font>";
					}
				
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";

			$name1=$ARRAY[0]['Lname1'];
			$name2=$ARRAY[0]['Lname2'];
	if(!empty($pass_tempID))
		{
		$four=substr($pass_tempID,-4);
	
		if(!empty($ARRAY[0]['Lname1']))
			{
			$new_tempID=$ARRAY[0]['Lname1'].$four;
			}
			else
			{
			@$new_tempID=$ARRAY[1]['Lname2'].$four;
			}
		}

	if(empty($new_tempID))
		{
// 		echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
		echo "No mismatch between entered Lname and tempID found for $Lname"; 
		// if($name2!=$Lname)
// 			{
// 			echo "<br />There is a mismatch between entered Lname $Lname and $name2 "; 
// 			}
		exit;
		}
	}
	else
	{
	echo "hello";
	
	}
	$c=count($ARRAY_change_db);
	echo "<table><tr valign='top'><td colspan='4'>$c tables using tempID or full name</td>
	<td>Existing tempID: $pass_tempID <br />
	<form action='change_name.php' method='POST'>
	New Last Name: <input type='text' name='new_last_name' value=\"\"><br />
	New tempID (last 4 of SSN stays the same): <input type='text' name='new_tempID' value=\"\">
	<input type='hidden' name='old_last_name' value=\"$Lname\">
	<input type='hidden' name='old_tempID' value=\"$pass_tempID\">
	<input type='submit' name='submit' value=\"Change\">
	<br />
	MAKE SURE BOTH OF THE ENTRIES ARE CORRECT!
	</td></tr>";
	foreach($ARRAY_change_db AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY_change_db[0] AS $fld=>$value)
				{
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($value=="tempID"){$value="<font color='red'>$value</font>";}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	
echo "</body></html>";

?>