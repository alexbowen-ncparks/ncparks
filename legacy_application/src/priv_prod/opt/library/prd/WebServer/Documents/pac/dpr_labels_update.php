<?php
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
extract($_REQUEST);

//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

$database="divper";
mysqli_select_db($connection,$database);

if($submit_label=="Delete"){
	$query = "DELETE FROM labels where id='$id'";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	
	$query = "DELETE FROM labels_affiliation where person_id='$id'";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}


if(@$submit_person=="Add")
	{
	$code=$pass_code;
	$query = "REPLACE labels_affiliation SET person_id='$id', affiliation_code='$code'";  //echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query"); //exit;
	
	$query = "UPDATE labels SET park='$park_code' where id='$id'";  //echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query"); //exit;
	
	header("LocatIon: add_new.php?id=$id&submit_label=Find&park_code=$park_code&pass_code=PAC_nomin");
	exit;
	}


$title="PAC"; 
include("/opt/library/prd/WebServer/Documents/pac/_base_top_pac.php");

echo "<body>";
echo "<table><tr><td><form action='home.php?submit_label=Home+Page'>
		<input type='submit' name='submit' value='Home'  style=\"background-color:#E9967A\"></form></td></tr></table>";

if($submit_label=="Add")
	{
$database="pac";
	echo "We will first need to determine if this person already exists in the database.<br /><br />";
	$ln=$_POST['Last_name'];
	$query = "SELECT group_concat(t2.affiliation_code) as affiliation, park, id, First_name, M_initial, Last_name, address, concat(city,', ',state,' ',zip) as csz 
	from labels 
	LEFT JOIN labels_affiliation as t2 on t2.person_id=labels.id
	where Last_name='$ln'
	group by labels.id";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	if(mysqli_num_rows($result)>0 and empty($new_pac))
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
			$c=count($ARRAY);
			echo "<table cellpadding='7'>
			<tr>
			<td colspan='5'>$c People with the last name: <font color='blue'>$ln</font> are already in the database.</td>
			<td colspan='5'>If the person you wish to add is NOT listed below, click <a href='add_new.php?new=2&park_code=$park_code&pass_code=PAC_nomin'>here</a>.</td>
			</tr>";
			
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
					echo "<td>$value</td>";
					}
				$id=$array['id'];
$action_page="dpr_labels_update.php";
$action="Add";
$text="Nominate as a PAC member";
$submit_fld="submit_person";
if($ARRAY[$index]['affiliation']=="PAC_nomin")
	{
	$action_page="current_pac.php";
	$text="Already Nominated";
	$park_code=$ARRAY[$index]['park'];
	$action="Find";
	$submit_fld="submit_label";
	}
				echo "<td>
<img src=\"/fam_icons/icons/tick.png\" alt=\"\"/> $text for $park_code</td>
				<td><form method='POST' action='$action_page'>
<input type='hidden' name='pass_code' value='PAC_nomin'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='park_code' value='$park_code'>
<input type='submit' name='$submit_fld' value='$action'>
</form></td>
				</tr>";
				}
			echo "</table>";
		exit;
		}
		else
		{ // name not found
			
		
		$ignore=array("id","custom","affiliation_code","affiliation_name","submit_label","new_pac");

		foreach($_POST as $fld=>$val)
			{
			if(in_array($fld,$ignore) OR $val==""){continue;}
			if($fld=="park_code")
				{
				if(empty($_POST['park']))
					{$fld="park";}
					else
					{continue;}			
				}
			$val="'".$val."'";
			$arraySet.=",".$fld."=".$val;
			}

	$arraySet=trim($arraySet,",");
	
		$query = "INSERT INTO labels set $arraySet";
//	echo "$query";   exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
			$id=mysqli_insert_id($connection);
		$query = "INSERT INTO labels_affiliation set person_id='$id', affiliation_code='PAC_nomin'";
//		echo "$query";   exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query ");
			header("Location: add_new.php?park_code=$park_code");
		exit;
		
		}
	}


if($submit_label=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	// ****** Create Array of couplets for Insert/Update **********
	
	$ignore=array("id","custom","affiliation_code","affiliation_name","file_link","park_code","submit_label","nom_type");
	
	$notBlank=array("PAC","PAC_nomin");
	$year_array=array("one"=>"1","two"=>"2","three"=>"3");
	
	
	foreach($_POST['add_cat'] as $k=>$v){
			if(in_array($v,$notBlank)){$blank=1;}
			}
	if($blank!=1){$interest_group="";}
	
	$arraySet="";
	if(!isset($_POST['pac_chair'])){$arraySet.="pac_chair=''";}
	if(!isset($_POST['pac_ex_officio'])){$arraySet.=",pac_ex_officio=''";}
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$ignore)){continue;}
		if($fld=="pac_nomination")
			{
			$val=str_replace("\r\r", "***", $val);
			$val=str_replace("\n\n", "***", $val);
			$val=str_replace("\r\n\r\n", "***", $val);
			$val=str_replace("\r\n", " ", $val);
			$val=str_replace("***", "\n\n", $val);
	
			}
				$val=trim($val,"\r\n");
				$val=trim($val," ");
				if($fld=="park"){$val=strtoupper($val);}
				if($fld=="pac_nomin_month"){$val=str_pad($val,2,"0", STR_PAD_LEFT);}
				if($fld=="pac_terminates"){$val=($_POST['pac_nomin_year']+$year_array[$_POST['pac_term']])."-".$_POST['pac_nomin_month'];}
		$val="'".$val."'";
		$arraySet.=",".$fld."=".$val;
		}
	
	$arraySet=trim($arraySet,",");
	
	$query = "UPDATE labels SET $arraySet where id='$id'";
//	echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query ");
	
	}

if(!empty($nom_type))
	{
	if($nom_type=="renomination")
		{
		$query = "UPDATE labels_affiliation SET affiliation_code='PAC_nomin' where person_id='$id' and affiliation_code='PAC'";
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query ");
		
		header("Location: add_old.php?id=$id&submit_label=Find&park_code=$park");}
	}
	else
		{header("Location: add_new.php?id=$id&submit_label=Find&park_code=$park");}

//header("Location: current_pac.php?id=$id&submit_label=Find&park_code=$park");
?>