<?php 
ini_set('display_errors',1);
$database="fofi";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,"fofi"); // database 

extract($_REQUEST);

// Process input
// *********** SEARCH **********
if(@$Submit =="Search")
	{
	//print_r($_REQUEST);
	// Create the WHERE clause
	$where = "WHERE zip = ''";
	
	if(@$zip)
		{
		$where = "WHERE zip='$zip'";}
	if(@$city)
		{
		$where = "WHERE city='$city'";}
	if(@$zip!="" AND @$city!="")
		{
		$where = "WHERE zip='$zip' and city='$city'";}
	if(@$state)
		{
		$where = "WHERE state='$state'";}
	if(@$Lname)
		{
// 		$Lname=addslashes($Lname);
		$where = "WHERE Lname='$Lname'";}
	if(@$cita)
		{
		if($cita=="findall")
			{
			$where = "WHERE cita != ''";}
			else
			{
// 			$cita=addslashes($cita);
			$where = "WHERE cita LIKE '%$cita%'";}
		}
	if(@$penum)
		{
		$padpenum=str_pad($penum, 4, "0", STR_PAD_LEFT);
		$where = "WHERE penum='$padpenum'";}
	if(@$vtag)
		{
		$where = "WHERE vtag='$vtag'";}
		
	$sql = "SELECT * From permit $where";
//	echo "$sql<br />"; //exit;
	$result = @mysqli_query($connection,$sql) or die("Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$numrow = mysqli_num_rows($result);
//	echo "n=$numrow";
	if($numrow < 1)
		{
		include("menu.php");
		echo "<br><hr><h2>No Permit found using: <font color='blue'>$where</font></h2><hr>";
		searchForm();
		exit;
		}
	if($numrow>1)
		{
		$a="<td colspan='5'>The database contains $numrow Permits.<font color='green'> $where</font></td>";
		echo "<hr><table border='1' cellpadding='5'>
		<tr>$a</tr>
		<tr><td align='center'>Permit Number</td>
		<td align='center'><u>Fname</u></td>
		<td align='center'><u>Lname</u></td>
		<td align='center'><u>City State Zip</u></td>
		<td align='center'><u>Citation</u></td>
		</tr>";
		while ($row = mysqli_fetch_array($result))
			{
			extract($row);
			echo "
			<td align='center'><a href='formEmpInfo.php?submit=Find&peid=$peid'>$penum</a></td>
			<td>$Fname</td>
			<td>$Lname</td>
			<td>$city, $state $zip</td>
			<td>$cita</td>
			</tr>";
			}
		echo "</table></body></html>";
		exit;
		}
	else
		{
		$row = mysqli_fetch_array($result);
//		echo "<pre>"; print_r($row); echo "</pre>"; // exit;
		extract($row);
		header("Location: formEmpInfo.php?submit=Find&peid=$peid");
		exit;
		}
	} // end Search
// ************ Show Search Form

include("menu.php");
searchForm();

//  ************Search form Function*************
function searchForm(){
echo "Search the Ft. Fisher SRA Permit Database</font>
<hr><form name='search' method='post' action='search.php'>
<table width='400'><tr>
<td>Permit Number: </td>
<td><input type='text' name='penum' value=''></td></tr>
 <tr>
<td>Zip Code: </td>
<td><input type='text' name='zip' value=''></td></tr>
 <tr>
<td>Last Name: </td>
<td><input type='text' name='Lname' value=''></td></tr>
 <tr>
<td>Tag Number: </td>
<td><input type='text' name='vtag' value=''></td></tr>
 <tr>
<td>Citation: (any word)</td>
<td><input type='text' name='cita' value=''></td><td><input type='radio' name='cita' value='findall'> All</td></tr>
<tr><td>&nbsp;</td><td align='center'>
 <input type='submit' name='Submit' value='Search'></form></td></tr>
 </table>
<hr>
";
}
?>