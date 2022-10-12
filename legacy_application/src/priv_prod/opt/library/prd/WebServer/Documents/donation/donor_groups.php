<?php
include("../../include/get_parkcodes_i.php");
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

$database="donation";
$level=$_SESSION[$database]['level'];

if(@$submit=="Delete")
	{
	$sql="DELETE from donor_group_list 
		where id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
		header("Location: donor_groups.php");
	exit;
	}
	
if(@$submit=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip=array("id","submit");
	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		$clause.=$fld."='".$value."',";
		}
	$clause=rtrim($clause,",");
	$sql="UPDATE donor_group_list set $clause
		where id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
//	echo "$sql $id";
	
	}

if(@$submit=="Add")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	$skip=array("id","donor_unique_id","submit");
	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		$clause.=$fld."='".$value."',";
		}
	$clause=rtrim($clause,",");
	$sql="INSERT into donor_group_list set $clause";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$id=mysqli_insert_id($connection);
	
	}



include("menu.php");
mysqli_select_db($connection,'divper'); // database
$sql="SHOW columns from donor_group_list";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
			{
			$group_array[]=$row['Field'];
			}
//echo "<pre>"; print_r($group_array); echo "</pre>";  exit;

if(empty($submit) AND empty($id))
	{
	$sql="SELECT t1.*
	from donor_group_list as t1
	where 1";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$contact_result_array[]=$row;
		}
		echo "<table border='1'>";
			echo "<tr>";
			foreach($contact_result_array[0] as $fld=>$val)
				{
				$fld=str_replace("_"," ",$fld);
				echo "<th>$fld</th>";
				}
			echo "</tr>";
		foreach($contact_result_array AS $index=>$array)
			{
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if($fld=="id"){$value="<a href='donor_groups.php?id=$value'>$value</a>";}
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		echo "<tr><form action='donor_groups.php' method='POST'>
		<td colspan='3' align='center' bgcolor='green'>
		<input type='submit' name='submit' value='New'></td></form></tr>";
		echo "</table>";
		exit;
	}

if(isset($id))
	{
	// contact info
	$action="Update";
	$skip=array("id");
	$sql="SELECT t1.*
		from donor_group_list as t1
			where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
			{
			$contact_result_array=$row;
			}
// echo "<br /><br />m=$sql";
//	echo "<pre>"; print_r($contact_result_array); echo "</pre>"; // exit;
	}
	else
	{
	$contact_result_array=array();
	$pass_value="";
	$action="Add";
	$skip=array("id");
	}
// ****** Show Input form **********
$PATH="/opt/library/prd/WebServer/Documents/divper/";
$how_contact_array=array("Phone","Email","Letter","Meeting");


$readonly=array("id","donor_unique_id");
$dropdown=array("how_contacted");

echo "<form action='donor_groups.php' method='POST'><table border='1' cellpadding='5' align='center'>";
if(!empty($contact_result_array['name']))
	{
	$name=@$contact_result_array['name'];
	}
	else
	{$name="";}
echo "<tr><td colspan='2'><font color='brown'>Group Donation Contact Info</font><h2>$name</h2></td></tr>";

foreach($group_array as $index=>$fld)
	{
	$value=@$contact_result_array[$fld];
	if(In_array($fld,$skip)){continue;}
	$ro="";
	if(isset($pass_value)){$value="";}
	if(in_array($fld,$readonly)){$ro="READONLY";}
	if($fld=="contact_date")
		{$fld_id="datepicker1";}
		else
		{$fld_id="$fld";}
	if($fld=="physical_state" AND empty($value))
		{$value="NC";}
	$input="<tr><td>$fld</td>
	<td><input type='text' id='$fld_id' name='$fld' value=\"$value\" $ro></td>
	</tr>";

	if($fld=="comments")
		{
		$input="<tr><td>$fld</td>
	<td><textarea name='$fld' rows='10' cols='45'>$value</textarea></td>
	</tr>";
		}

	if(in_array($fld,$dropdown))
		{
		$input="<tr><td>$fld</td><td><select name='$fld'><option selected=''></option>\n";
		foreach($how_contact_array as $k=>$v)
			{
			if($value==$v){$s="selected";}else{$s="value";}
			$input.="<option $s='$v'>$v</option>\n";
			}
		
		$input.="</select></td></tr>";
		}
	echo "$input";
	}

echo "<tr><td colspan='2' align='center'>";
if($action=="Update")
	{
	echo "<input type='hidden' name='id' value='$id'>";
	}
	
echo "<input type='submit' name='submit' value='$action'>
</td></form>";
if($action=="Update")
{
echo "<form action='donor_groups.php' method='POST'>
<td>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Delete' onClick=\"return confirmLink()\"></td>";
}
echo "</tr>";
echo "</table>";


echo "</body></html>";

?>