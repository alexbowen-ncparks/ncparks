<?php
//include("../../include/get_parkcodes.php");
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 

include("../../include/get_parkcodes_dist.php"); 

mysqli_select_db($connection,'divper'); // database

extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

$database="donation";
$level=$_SESSION[$database]['level'];

if(@$submit=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip=array("id","donor_unique_id","submit","First_name","Last_name");
	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		$clause.=$fld."='".$value."',";
		}
	$clause=rtrim($clause,",");
	$sql="UPDATE donor_contact set $clause
		where donor_unique_id='$donor_unique_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
//	echo "$sql $id";
	
	}

if(@$submit=="Add")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip=array("id","donor_unique_id","submit");
	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		$clause.=$fld."='".$value."',";
		}
	$clause=rtrim($clause,",");
	$sql="INSERT into donor_contact set $clause, id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$donor_unique_id=mysqli_insert_id($connection);
	unset($id);
//	echo "$sql ";
	
	}



if(@$rep=="")
	{
	include("menu.php");
	mysqli_select_db($connection,'divper'); // database
	include("/opt/library/prd/WebServer/Documents/divper/dpr_labels_base_i.php");
	}
	else
	{
	$fieldArray=array("park","affiliation_code","First_name","Last_name");
	}

if(isset($donor_unique_id) AND !isset($id))
	{
	// contact info
	$action="Update";
	$skip=array("donor_unique_id","id","First_name","Last_name");
	$sql="SELECT t1.*, t2.First_name, t2.Last_name 
		from donor_contact as t1
		left join labels as t2 on t1.id=t2.id
			where donor_unique_id='$donor_unique_id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
			{
			$contact_result_array[]=$row;
			$id=$row['id'];
			}
// echo "<br /><br />m=$sql";
//	echo "<pre>"; print_r($contact_result_array); echo "</pre>"; // exit;
	}
	else
	{
	$pass_value="";
	$action="Add";
	$skip=array("donor_unique_id","id","First_name","Last_name");
	if(!empty($id)){$where="and t2.id='$id'";}
	$sql="SELECT t1.*, t2.First_name, t2.Last_name 
		from labels as t2
		left join donor_contact as t1 on t1.id=t2.id
		where 1 $where
		limit 1";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
			{
			$contact_result_array[]=$row;
			}
	}
// ****** Show Input form **********
$PATH="/opt/library/prd/WebServer/Documents/divper/";
$how_contact_array=array("Phone","Email","Letter","Meeting");

/*
$donor_type_array=array("Individual/Family","Civic Group/Club","Non-Profit","Foundation");
$donation_type_array=array("Financial","Land","Material");
$donation_recipient_array=array("Park","Division","PARTF","Friends Group");
$recognition_array=array("Public Recognition","Anonymous");
$fund_array=array("1280"=>"State Parks","2235"=>"PARTF");
*/

$readonly=array("id","donor_unique_id");
$dropdown=array("how_contacted","park_code");

// echo "<pre>"; print_r($contact_result_array); echo "</pre>";
echo "<form action='donor_contact.php' method='POST'><table border='1' cellpadding='5' align='center'>";
$name=$contact_result_array[0]['First_name']." ".$contact_result_array[0]['Last_name'];

echo "<tr><td colspan='2'><font color='brown'>Donation Contact for $name</font></td></tr>";
foreach($contact_result_array AS $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(In_array($fld,$skip)){continue;}
		$ro="";
		if(isset($pass_value)){$value="";}
		if(in_array($fld,$readonly)){$ro="READONLY";}
		if($fld=="contact_date")
			{$fld_id="datepicker1";}
			else
			{$fld_id="$fld";}
		$input="<tr><td>$fld</td>
		<td><input type='text' id='$fld_id' name='$fld' value=\"$value\" $ro></td>
		</tr>";

		if($fld=="donation_comments")
			{
			$input="<tr><td>$fld</td>
		<td><textarea name='$fld' rows='20' cols='75'>$value</textarea></td>
		</tr>";
			}

		if(in_array($fld,$dropdown))
			{
			$input="<tr><td>$fld</td><td>
			<select name='$fld'><option value='' selected></option>\n";
			if($fld=="park_code")
				{
				$dd_array=$parkCode;
				}
				else
				{$dd_array=$how_contact_array;}
			foreach($dd_array as $k=>$v)
				{
				if($value==$v){$s="selected";}else{$s="";}
				$input.="<option value='$v' $s>$value</option>\n";
				}
			
			$input.="</select></td></tr>";
			}
		echo "$input";
		}
	}
echo "<tr><td colspan='2' align='center'>";
if($action=="Update")
	{echo "<input type='hidden' name='donor_unique_id' value='$donor_unique_id'>";}
	else
	{echo "<input type='hidden' name='id' value='$id'>";}

echo "<input type='submit' name='submit' value='$action'>
</td></form>
<form action='form.php' method='POST'>
<td><input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Return'>
</td>
</tr>";
echo "</table>";


echo "</body></html>";

?>