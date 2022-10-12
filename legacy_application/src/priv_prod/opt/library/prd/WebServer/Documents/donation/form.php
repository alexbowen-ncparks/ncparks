<?php
//include("../../include/get_parkcodes.php");
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/get_parkcodes_dist.php");
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
extract($_REQUEST);

$database="donation";
$level=$_SESSION[$database]['level'];

if(!empty($pass_id))
	{
	if(@$submit_label=="Delete")
		{
		$sql="DELETE FROM labels_affiliation where person_id='$pass_id' AND affiliation_code='DONOR'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));

		$sql="DELETE FROM donor_contact where id='$pass_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));

		$sql="DELETE FROM donor_donation where id='$pass_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));

		$sql="DELETE  FROM labels where id='$pass_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			echo "Deletion from Donation Database successful.";
		}
	}

if(@$rep=="")
	{
	include("menu.php");
	mysqli_select_db($connection,'divper'); // database
	include("/opt/library/prd/WebServer/Documents/divper/dpr_labels_base_i.php");
	}
	else
	{
	$fieldArray=array("affiliation_code","First_name","Last_name");
	}

$pass_affiliation_codes="";
$contact_result_array=array();
if(isset($id))
	{
	// donor info
	$sql="SELECT t0.*, group_concat(t2.affiliation_code) as affiliation_code, t2.affiliation_name
			from divper.labels as t0
			LEFT JOIN labels_affiliation as t1 on t1.person_id=t0.id
			LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
			where t0.id='$id'
			group by t0.id";
	//		echo "$sql<br />";//exit;
			
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			$row=mysqli_fetch_assoc($result);
//			echo "<pre>"; print_r($row); echo "</pre>"; // exit;
			$field_row=$row;
			extract($row);
			$pass_affiliation_codes=$row['affiliation_code'];
	// contact info
	$sql="SELECT * from donor_contact
			where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
				{
				$contact_result_array[]=$row;
				}
	// donation info
	if(!empty($sort)){$order_by="order by date_donation_received desc";}else{$order_by="";}
	$sql="SELECT * from donor_donation
			where id='$id'
			$order_by";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
			{
			$donation_result_array[]=$row;
			}
	
	foreach($field_row as $k=>$v)
		{
		$donation_fieldArray[]=$k;
		}
	}
// ****** Show Input form **********
$PATH="/opt/library/prd/WebServer/Documents/divper/";

if(isset($id))
	{
	$pass_id=$id;
	$go_file="/donation/donor_update.php";
	$action="Update";
	}
else
	{
	$go_file="/donation/donation_find.php";
	$action="Find";
	}

//echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
// here and in donation_update.php
$how_contact_array=array("Phone","Email","Letter","Meeting");
$donation_type_array=array("Financial","Land","Material");
$donation_recipient_array=array("Park","Division","PARTF","Friends Group");
$recognition_array=array("Public Recognition","Anonymous");
$fund_array=array("1280"=>"State Parks","2235"=>"PARTF");
$donor_typeArray=array("Individual/Family","Civic Group/Club","Non-Profit","Corporation/Business","Foundation","General Public","Sponsor"); // also used in divper/dpr_labels_form.php


echo "<form name='donor_form' action='$go_file' method='POST'";
IF(!empty($id)){ECHO "onsubmit=\"return validateForm()\"";}
echo ">";
echo "<table border='1' cellpadding='5'>";

$calling_app=$database;
$calling_page=$_SERVER['PHP_SELF'];

// *************************************************************
include("base_form.php");

if(strpos($pass_affiliation_codes,"DONOR")>-1)
	{
	if(empty($donation_result_array)){$pot="potential";}else{$pot="";}
	if($donor_type=="Individual/Family" OR empty($donor_type))
		{
		echo "<table align='center'><tr>
		<td><strong>$First_name $Last_name</strong> is a $pot Donor.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }
	else
		{
		echo "<table align='center'><tr>
		<td><strong>$donor_organization $First_name $Last_name</strong> is a $pot Donor.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }
	}
else
	{
	if(!empty($id))
		{
			$ck="";
			echo "<table align='center'><tr>
			<td><font color='red'>Select a Donor Type and  Check 
			<input type='checkbox' name='add_cat[]' value='DONOR' $ck> to add this person to the Donation database.</font> Then click \"Update\"
			<input type='hidden' name='db_source' value='$database'>";
		}
		else
		{echo "<table align='center'><tr><td>"; }
	}
if(isset($pass_id))
	{
	echo "<input type='hidden' name='pass_id' value='$pass_id'>";
	}
echo "
<input type='hidden' name='source_db' value='donation'>
<input type='submit' name='submit_label' value='$action' style=\"background-color:lightgreen;width:65;height:35\">
</td></form>";

if(!empty($id))
	{
	echo "
	<form action='/donation/form.php'><td align='right'>
	<input type='submit' name='submit_label' value='Go to Find' style=\"background-color:lightblue;width:75;height:35\"></td></form>";
	
	echo "
	<form action='/donation/form.php' onSubmit=\"return confirmDonor()\"><td align='right'>
	<input type='hidden' name='pass_id' value='$pass_id'>
	<input type='submit' name='submit_label' value='Delete' style=\"background-color:pink;width:75;height:35\"></td></form>";
	}

echo "</tr></table>";

if(!empty($pass))
	{$pc=$pass;}
	else
	{$pc=@$contact_result_array[0]['park_code'];}
//echo "<pre>"; print_r($contact_result_array); echo "</pre>"; // exit;
if(!empty($contact_result_array))
	{
//	$no_edit_contact=array("donor_unique_id");
	echo "<hr /><table border='1' cellpadding='5'>";
	$donor_unique_id=@$contact_result_array[0]['donor_unique_id'];
	
	foreach($contact_result_array AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr><td><a href='donor_contact.php?id=$id&donor_unique_id=$donor_unique_id&park_code=$pc'>Add a Donor Contact</a></td>";
			}
			else
			{
			echo "<td></td>";
			}
		foreach($array as $fld=>$value)
			{
			$var_fld=str_replace("_"," ",$fld);
			if($var_fld=="donor unique id")
				{
				$value="Edit: <a href='donor_contact.php?donor_unique_id=$value'>[ $value ]</a>";
				}
			if($index==0)
				{
				echo "<td><b>$var_fld</b><br />$value</td>";
				}
				else
				{
				echo "<td>$value</td>";
				}
			}
		echo "</tr>";
		}
	echo "</table>";
	}
else
	{
	if(!empty($id))
	{
	echo "<hr /><table border='1'><tr><td><a href='donor_contact.php?id=$id'>Add a Donor Contact</a></td></tr></table>";}
	}

//echo "<pre>"; print_r($donation_result_array); echo "</pre>"; // exit;
// down page
if(isset($donation_result_array))
	{
	echo "<hr /><table border='1'><tr><td valign='top' colspan='3'><a href='donation_update.php?id=$id&pass=$pc'>Add a Donation</td></tr>";
	
	foreach($donation_result_array as $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($donation_result_array[0] as $fld=>$value)
			{
			if($fld=="attachment_num"){continue;}
			$fld=str_replace("_"," ",$fld);
			if($fld=="date donation received")
				{
				$temp="id=$id&submit_label=Find&pass=$pass&sort=date_received";
				$fld="<a href='form.php?$temp'>$fld</a>";
				}
			echo "<th>$fld</th>";
			}
			echo "</tr>";
		
			}
		echo "<tr>";
		foreach($array as $fld=>$val)
			{
			if($fld=="attachment_num"){continue;}
			if(strpos($fld,"_donation_amount"))
				{
				$var_a="_total";
				@${$fld.$var_a}+=$val;
				}
			$var_fld=str_replace("_"," ",$fld);
			if($fld=="donor_unique_id")
				{
				$dt=$array['donation_type'];
				echo "<td><a href='donation_update.php?donation_type=$dt&donor_unique_id=$val'>Edit: $val</a></td>";
				}
				else
				{
				echo "<td>$val</td>";
				}			
			}
		echo "</tr>";
		}
	echo "<tr><td colspan='7' align='right'>$financial_donation_amount_total</td>
	<td colspan='2' align='right'>$land_donation_amount_total</td>
	<td colspan='2' align='right'>$material_donation_amount_total</td>
	</tr>";
	echo "</table>";
	}
else
	{
	if(!empty($id)){
	echo "<hr /><table border='1'><tr><td><a href='donation_update.php?id=$id'>Add a Donation</a></td></tr></table>";}
	}


echo "</body></html>";

?>