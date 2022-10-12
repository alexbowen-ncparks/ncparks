<?php
include("menu.php");

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,"fofi"); // database 


// ************ Process input
if(!isset($Submit)){$Submit="";}
$val = strpos($Submit, "Update");
if($val > -1)
	{  // strpos returns 0 if Edit starts as first character
		if(!$seid==""){
	$sql = "UPDATE position SET `posNum`='$posNum',`posTitle`='$posTitle',`fund`='$fund',`rate`='$rate' 
	,`hrs`='$hrs',`weeks`='$weeks',`dateBegin`='$dateBegin',`dateEnd`='$dateEnd'
	WHERE seid='$seid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$message="Update successful.";
	header("Location: form.php?park=$parkG&message=$message");
		}// end if !$seid
	} // end Update
	
$val = strpos($Submit, "Add");
if($val > -1)
	{  // strpos returns 0 if Add starts as first character
	if($posNum==""){echo "Position Number cannot be blank.<br><br>Click your Browser's Back button."; exit;}
	$sql = "INSERT INTO position SET `posNum`='$posNum',`posTitle`='$posTitle',`fund`='$fund',`rate`='$rate',`hrs`='$hrs',`weeks`='$weeks',`dateBegin`='$dateBegin',`dateEnd`='$dateEnd',`park`='$park',`posType`='$posType'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$message="Addition successful.";
	header("Location: form.php?park=$parkG&message=$message");
	} // end Add

$val = strpos($Submit, "Transfer");
if($val > -1)
	{  // strpos returns 0 if Transfer starts as first character
	if(!$reason){$message="You must enter a reason for transfering a position";
	header("Location: form.php?park=$parkG&message=$message");exit;
	}
	$sql = "UPDATE position
	SET `markDel`='x',`reason`='$reason'
	WHERE seid='$seid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$message="Position $posNum removed from $parkG. Now complete blank info for $reason.";
	header("Location: form.php?park=$reason&message=$message&posNum=$posNum");exit;
	} // end Transfer

//  ************Start input form*************

if(!isset($scope)){$scope="";}	
if(!isset($loginS)){$loginS="";}	
	if($loginS == "ADMIN" or $scope=="all")
		{$where="";$limit="";}
		else
		{$where="WHERE 1"; $limit = "LIMIT 100";}
	$sql = "SELECT * From permit
	$where
	ORDER by peid DESC
	$limit";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br />c=$connection");
if(!isset($message)){$message="";}	
	echo "<font color='red'>$message</font>
	<hr>
	<table><tr>
	<th width='100'>Permit Number</th>
	<th width='100'>Date Issued</th>
	<th width='100'>First Name</th>
	<th width='100'>Last Name</th>
	<th width='50'>Add1</th>";
	echo "
	<th width='50'>City, State Zip</th>
	<th width='50'>Phone Number</th>
	</tr>";
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		permitShow($peid,$dateissue,$Fname,$Mname,$Lname,$suffix,$add1,$city,$state,$zip,$phone,$penum);
		}// end while

echo "Showing Most Recent 100 permits.
";

echo "</table></div></body></html>";


// *************** Update Park Positions FUNCTION **************
function positionEdit($peid,$recnum,$Fname,$Mname,$Lname,$suffix,$add1,$add2,$city,$state,$zip,$penum){
echo "
<form method='post' action='form.php'>
<tr><td align='center'>
<input type='text' size='7' name='posNum' value='$posNum'></td>
<td>
<input type='text' size='27' name='posTitle' value='$posTitle'></td>
<td align='center'>
<input type='text' size='7' name='fund' value='$fund'></td>
<td align='right'>
<input type='text' size='5' name='rate' value='$rate'></td>
<td align='right'>
<input type='text' size='3' name='hrs' value='$hrs'></td>
<td align='right'>
<input type='text' size='3' name='weeks' value='$weeks'></td>
<td align='right'>
<input type='text' size='10' name='dateBegin' value='$dateBegin'></td>
<td align='right'>
<input type='text' size='10' name='dateEnd' value='$dateEnd'></td>
<td align='right'>$totalCalc</td>
<td><input type='hidden' name='park' value='$parkG'>
<input type='hidden' name='seid' value='$seid'>
<input type='submit' name='Submit' value='Update'></td>
<td><input type='text' size='10' name='reason' value='$reason'>
<input type='submit' name='Submit' value='Transfer' onClick='return confirmSubmit()'>
</form></td></tr>";
}
// *************** Show Park Positions FUNCTION **************
function permitShow($peid,$dateissue,$Fname,$Mname,$Lname,$suffix,$add1,$city,$state,$zip,$phone,$penum){
echo "
<form method='post' action='form.php'>
<tr><td align='center'>
$penum</td>
<td>
$dateissue</td>
<td>
$Fname $Mname</td>
<td>
$Lname</td>
<td>
$add1</td>";
/*
echo "<td>
$add2</td>";
*/
echo "<td>
$city, $state $zip</td>
<td align='right'>
$phone</td>
<td><a href='formEmpInfo.php?submit=Find&peid=$peid'>View/Edit</a></td>
<td><a href='formEmpInfo.php?submit=del&peid=$peid' onClick='return confirmLink()'>Remove</a></td></tr>";
}
?>