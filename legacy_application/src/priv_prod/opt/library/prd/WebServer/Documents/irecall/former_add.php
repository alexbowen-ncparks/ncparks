<?php
extract($_REQUEST);
    // Data from form is processed
//print_r($_REQUEST);exit;

include_once("../../include/iConnect.inc");
$database="irecall";
mysqli_select_db($connection,$database);

// **************** Delete Person ***************************
if(@$del=="Delete person")
	{
	$sql="DELETE FROM irecall.former_emp WHERE formerid='$formerid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	ECHO "$first_name $last_name has been deleted.<br /><br />
	Click <a href='view.php'>here</a> to return to main page.
	";
	exit;
	}


// **************** New Person ***************************
    // Show the form to submit a new Person
if (@$submit == "")
	{
	$sub="Add";
	if(@$formerid)
		{
		$sub="Update"; $sub1="Delete person";
		$sql="SELECT * FROM irecall.former_emp WHERE formerid='$formerid'";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$row = mysqli_fetch_array($result);
		extract($row);
		}
	if(!isset($first_name)){$first_name="";}
	if(!isset($last_name)){$last_name="";}
	if(!isset($add1)){$add1="";}
	if(!isset($city)){$city="";}
	if(!isset($state)){$state="";}
	if(!isset($zip)){$zip="";}
	if(!isset($phone)){$phone="";}
	if(!isset($email)){$email="";}
	if(!isset($last_pos)){$last_pos="";}
	if(!isset($formerid)){$formerid="";}
	if(!isset($sub1)){$sub1="";}
	echo "<table>
	<form method='post' action='former_add.php' enctype='multipart/form-data'>
	
	<tr><td>First name: <INPUT TYPE='text' name='first_name' value='$first_name'></td><td>Last name: <INPUT TYPE='text' name='last_name' value='$last_name'></td></tr><tr><td>Address: <INPUT TYPE='text' name='add1' value='$add1'></td></tr>
	<tr><td>City: <INPUT TYPE='text' name='city' value='$city'></td><td>State: <INPUT TYPE='text' name='state' value='$state'></td><td>Zip: <INPUT TYPE='text' name='zip' value='$zip'></td></tr>
	<tr><td>Phone: <INPUT TYPE='text' name='phone' value='$phone'></td><td colspan='3'>Email: <INPUT TYPE='text' name='email' value='$email' size='50'></td></tr><tr><td colspan='4'>Last Position/Park: <INPUT TYPE='text' name='last_pos' value='$last_pos' size='50'></td></tr>
	
	<tr><td align='center'><INPUT TYPE='hidden' name='formerid' value='$formerid'><INPUT TYPE='submit' name='submit' value='$sub person'>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='submit' name='del' value='$sub1'>
		</form></td></tr></table>";
	}

if (@$submit == "Add person")
	{
	//extract ($_FILES);// not needed for text only
	mysqli_select_db($connection,"irecall.tradition");
	// $first_name=addslashes($first_name);
// 	$last_name=addslashes($last_name);
// 	$add1=addslashes($add1);
// 	$last_pos=addslashes($last_pos);
	
	$query="INSERT into irecall.former_emp SET first_name='$first_name', last_name='$last_name',add1='$add1',last_pos='$last_pos',city='$city' ,state='$state' ,zip='$zip',email='$email',phone='$phone',level='1'";
	//echo "$query";exit;
	$result=mysqli_QUERY($connection,$query);
		$mid= mysqli_insert_id($connection);
	
	if(@$mid)
		{
		// Display
		header("Location:search.php?search=$last_name&submit=Search");
		}
	else
	{echo "There was a problem, and your story was not entered. Contact Tom Howard (tom.howard@ncmail.net) for help.";}
		}


if (@$submit == "Update person")
	{
	//extract ($_FILES);// not needed for text only
	mysqli_select_db($connection, "irecall.former_emp");
	// $first_name=addslashes($first_name);
// 	$last_name=addslashes($last_name);
// 	$add1=addslashes($add1);
// 	$last_pos=addslashes($last_pos);
	
	$query="UPDATE irecall.former_emp SET first_name='$first_name', last_name='$last_name',add1='$add1',last_pos='$last_pos',city='$city' ,state='$state' ,zip='$zip',email='$email',phone='$phone' where formerid='$formerid'";
	//echo "$query";exit;
	$result=mysqli_QUERY($connection,$query);
		$mid= mysqli_affected_rows($connection);
	
	if(@$mid)
		{
		// Display
		header("Location:success.php?m=$mid&type=former_emp");
		}
	else
	{echo "There was a problem, and your story was not entered. Contact Tom Howard (tom.howard@ncmail.net) for help.";}
		}
?>