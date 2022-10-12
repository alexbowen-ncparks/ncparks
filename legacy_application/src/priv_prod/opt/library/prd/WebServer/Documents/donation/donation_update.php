<?php
include("../../include/get_centers.php"); // uses mysqli functions

ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");

include("../../include/get_parkcodes_dist.php"); 

mysqli_select_db($connection,'divper'); // database

extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

$database="donation";
$level=$_SESSION[$database]['level'];

if(@$submit=="Delete")
	{
	$sql="DELETE FROM donor_donation
	where donor_unique_id='$donor_unique_id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	header("Location: form.php?id=$id"); exit;
	}

if(@$submit=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

	$sql="UPDATE donor_donation set financial_donation_amount='', financial_donation_description='', land_donation_amount='', land_donation_description='', material_donation_amount='', material_donation_description=''
		where donor_unique_id='$donor_unique_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$skip=array("id","donor_unique_id","submit","donor_id","attachment_num");
	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="financial_donation_amount")
			{
			$value=str_replace("$","", $value);
			$value=str_replace(",","", $value);
			}
		if($fld=="material_donation_amount")
			{
			$value=str_replace("$","", $value);
			$value=str_replace(",","", $value);
			}
		if($fld=="land_donation_amount")
			{
			$value=str_replace("$","", $value);
			$value=str_replace(",","", $value);
			}
		
		if($fld=="center")
			{
			$pc=$_POST['park_code'];
			$get_center=@$center_array[$pc];
			if(!empty($pc)){$value=$get_center;}
			}

		$clause.=$fld."='".$value."',";
		}
	$clause=rtrim($clause,",");

	include("file_upload.php");

	$sql="UPDATE donor_donation set $clause
		where donor_unique_id='$donor_unique_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
//	echo "$sql $id";

	}

// here and in form.php
$how_contact_array=array("Phone","Email","Letter","Meeting");
$donor_type_array=array("Individual/Family","Civic Group/Club","Non-Profit","Foundation");
$donation_type_array=array("Financial","Land","Material");
$donation_recipient_array=array("Park","Division","PARTF","Friends Group");
$recognition_array=array("Public Recognition","Anonymous");
$fund_array=array("1280"=>"State Parks","2235"=>"PARTF");

if(@$submit=="Add")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip=array("id","donor_unique_id","submit","donor_id");
	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="financial_donation_amount")
			{
			$value=str_replace("$","", $value);
			$value=str_replace(",","", $value);
			}
		if($fld=="material_donation_amount")
			{
			$value=str_replace("$","", $value);
			$value=str_replace(",","", $value);
			}
		if($fld=="land_donation_amount")
			{
			$value=str_replace("$","", $value);
			$value=str_replace(",","", $value);
			}
		if($fld=="center")
			{
			$pc=$_POST['park_code'];
			$get_center=@$center_array[$pc];
			if(!empty($pc)){$value=$get_center;}
			}
			
		$clause.=$fld."='".$value."',";
		}
	$clause=rtrim($clause,",");
	$sql="INSERT into donor_donation set $clause, id='$id'";
//	echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$donor_unique_id=mysqli_insert_id($connection);
	$donor_id=$id;
	include("file_upload.php");
	unset($id);

	
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

//if(isset($donor_unique_id) AND !isset($id))
if(isset($donor_unique_id))
	{
	// contact info
	$action="Update";
	$skip=array("donor_unique_id","id");
	$sql="SELECT t1.* , t2.First_name, t2.Last_name
			from donor_donation as t1
			left join labels as t2 on t1.id=t2.id
			where t1.donor_unique_id='$donor_unique_id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
			{
			$contact_result_array[]=$row;
			$id=$row['id'];
			$_GET['donation_type']=$row['donation_type'];
			}
// echo "<br /><br />m=$sql";
//	echo "<pre>"; print_r($contact_result_array); echo "</pre>"; // exit;
	}
	else
	{
	$pass_value="";
	$action="Add";
	$skip=array("donor_unique_id","id");
	if(!empty($id)){$where="and t2.id='$id'";}
	$sql="SELECT t1.* , t2.First_name, t2.Last_name
			from labels as t2
			left join donor_donation as t1 on t1.id=t2.id
			where 1 $where
			limit 1";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
			{
			$contact_result_array[]=$row;
			}
	}
//echo "<pre>"; print_r($contact_result_array); echo "</pre>"; // exit;

//echo "$sql<br /><br />";
// ****** Show Input form **********
$PATH="/opt/library/prd/WebServer/Documents/divper/";

$how_contact_array=array("Phone","Email","Letter","Meeting");
$donor_type_array=array("Individual/Family","Civic Group/Club","Non-Profit","Foundation");
$donation_type_array=array("Financial","Land","Material");
$donation_recipient_array=array("Park","Division","PARTF","From a Friends Group","To a Friends Group");
$recognition_desired_array=array("Public Recognition","Anonymous");
//$fund_array=array("1280-State Parks","2235-PARTF");
$park_code_array=$parkCode;
$park_code_array[]="STWD";

$readonly=array("id","donor_unique_id");
$dropdown=array("donation_type","donation_recipient","recognition_desired","park_code");
$textarea=array("financial_donation_description","land_donation_description","material_donation_description","donor_stated_purpose", "restrictions_requirements","donor_donation_comments");

$skip[]="First_name";
$skip[]="Last_name";
$pass_Last_name=$contact_result_array[0]['Last_name'];
$name=$contact_result_array[0]['First_name']." ".$pass_Last_name;


$start_array=array("donation_type","park_code", "center", "project",  "donation_recipient","donor_stated_purpose","date_donation_received", "date_donation_acknowledged", "recognition_desired", "restrictions_requirements", "project_completion_date", "donor_notified_of_project_completion", "donor_donation_comments");
$financial_start_array=array("financial_donation_amount","financial_donation_description");
$land_start_array=array("land_donation_amount","land_donation_description");
$material_start_array=array("material_donation_amount","material_donation_description");

if(empty($donation_type))
	{
	$display_array=$start_array;
	$donation_type="";
	}
	else
	{
	$second_array=${strtolower($donation_type)."_start_array"};
	$display_array=array_merge($start_array,$second_array);
	}
//echo "$donation_type<pre>"; print_r($display_array); echo "</pre>"; // exit;

$rename=array("center"=>"Center (will be auto-completed for a park)");

//echo "<pre>"; print_r($contact_result_array); echo "</pre>"; // exit;
echo "<form action='donation_update.php' method='POST' enctype=\"multipart/form-data\">";

echo "<table border='1' align='center' cellpadding='5'>
<tr><td colspan='2'><font color='brown'>Donation from $name</font></td></tr>";
foreach($contact_result_array AS $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(!in_array($fld,$display_array)){continue;}
		$ro="";
		if(isset($pass_value)){$value="";}
		if(in_array($fld,$readonly)){$ro="READONLY";}
		{$fld_id="$fld";}

		if($fld=="date_donation_received")
			{$fld_id="datepicker1";}
		if($fld=="date_donation_acknowledged")
			{$fld_id="datepicker2";}
		if($fld=="project_completion_date")
			{$fld_id="datepicker3";}
		if($fld=="donor_notified_of_project_completion")
			{$fld_id="datepicker4";}

		if(array_key_exists($fld,$rename)){$fld_name=$rename[$fld];}else{$fld_name=$fld;}
		$input="<tr><td bgcolor='aliceblue'>$fld_name</td>
		<td bgcolor='aliceblue'><input type='text' id='$fld_id' name='$fld' value=\"$value\" size='40' $ro></td>
		</tr>";

		if($fld=="donation_comments")
			{
			$input="<tr><td bgcolor='aliceblue'>$fld</td>
		<td bgcolor='aliceblue'><textarea name='$fld' rows='10' cols='45'>$value</textarea></td>
		</tr>";
			}

		if(in_array($fld,$dropdown))
			{
			if($fld=="donation_type")
				{
				$on="onChange=\"MM_jumpMenu('parent',this,0)\"";
				
			if(!empty($pass)){$pc=$pass;}else{$pc="";}
				$file="donation_update.php?id=$id&park_code=$pc";
				if(!empty($donor_unique_id))
					{$file.="&donor_unique_id=$donor_unique_id";}
				
				$file.="&donation_type=";
				if(empty($value)){$value=$donation_type;}
				if(!empty($donation_type)){$value=$donation_type;}				
				}
				else
				{$on=""; $file="";}
			
			$input="<tr><td bgcolor='aliceblue'>$fld</td><td bgcolor='aliceblue'><select name='$fld' $on><option selected=''></option>\n";
			$select_array=${$fld."_array"};
		if($fld=="park_code"){@$value=$contact_result_array[0]['park_code'];}
			foreach($select_array as $k=>$v)
				{
				if($value==$v){$s="selected";}else{$s="value";}
				$input.="<option $s='$file$v'>$v</option>\n";
				}
			
			$input.="</select></td></tr>";
			}

		if(in_array($fld,$textarea))
			{
			$input="<tr><td bgcolor='aliceblue'>$fld</td><td bgcolor='aliceblue'><textarea name='$fld' cols='35' rows='5'>$value</textarea>";
			}

		echo "$input";
		if(empty($_GET['donation_type'])){exit;}
		}
	}

//echo "</table>";

include("upload_form.php");

echo "<tr><td align='center' bgcolor='green'>";
if($action=="Update")
	{echo "<input type='hidden' name='donor_unique_id' value='$donor_unique_id'>";}
	else
	{echo "<input type='hidden' name='id' value='$id'>";}

if(!isset($donor_unique_id)){$donor_unique_id="";}
echo "<input type='submit' name='submit' value='$action'>
</td></form>

<form action='donation_update.php' method='POST'><td align='center' bgcolor='red'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='donor_unique_id' value='$donor_unique_id'>
<input type='submit' name='submit' value='Delete' onClick=\"return confirmLink()\"></td></form>

<form action='form.php' method='POST'><td bgcolor='orange'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Return'>
</td></form>
</tr>";
echo "</table>";


echo "</body></html>";

?>