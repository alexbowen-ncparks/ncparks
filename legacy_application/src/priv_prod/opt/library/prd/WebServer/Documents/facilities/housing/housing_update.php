<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); // database connection parameters
mysql_select_db($database,$connection);
extract($_REQUEST);

if($submit_label=="Delete")
	{
	$query = "DELETE FROM housing where id='$id'";
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	
//	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}


$sql = "SHOW COLUMNS FROM housing";//echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql".mysql_error());
$numFlds=mysql_num_rows($result);
while ($row=mysql_fetch_assoc($result))
	{
	$fieldArray[]=$row['Field'];
	}

if($submit_label=="Add")
	{

	$ignore=array("id","custom","affiliation_code","affiliation_name");

	for($i=0;$i<count($fieldArray);$i++){
	$val=${$fieldArray[$i]};// force the variable
	if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
	$val="'".mysql_real_escape_string($val)."'";
	$arraySet.=",".$fieldArray[$i]."=".$val;
		}

$arraySet=trim($arraySet,",");
	
	$query = "INSERT INTO housing arraySet";
	echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");

	header("Location: find.php?id=$id&submit_label=Find");
	exit;
	}


if($submit_label=="Update")
	{
	//echo "<pre>"; print_r($_REQUEST); print_r($_POST); echo "</pre>";  //exit;
	// ****** Create Array of couplets for Insert/Update **********
	
	$ignore=array("id","custom","affiliation_code","affiliation_name","file_link");
	
	$notBlank=array("PAC","PAC_nomin");
	
	foreach($_POST['add_cat'] as $k=>$v){
			if(in_array($v,$notBlank)){$blank=1;}
			}
	if($blank!=1){$interest_group="";}
	
	for($i=0;$i<count($fieldArray);$i++){
	$val=${$fieldArray[$i]};// force the variable
	//if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
	if(in_array($fieldArray[$i],$ignore)){continue;}
				$val=trim($val,"\r\n");
				$val=trim($val," ");
				if($fieldArray[$i]=="park"){$val=strtoupper($val);}
				if($fieldArray[$i]=="pac_nomin_month"){$val=str_pad($val,2,"0", STR_PAD_LEFT);}
	$val="'".mysql_real_escape_string($val)."'";
	$arraySet.=",`".$fieldArray[$i]."`=".$val;
		}
	
	$arraySet=trim($arraySet,",");
	
	$query = "UPDATE housing SET $arraySet where id='$id'";
//	echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	
	header("Location: find.php");
	}


?>