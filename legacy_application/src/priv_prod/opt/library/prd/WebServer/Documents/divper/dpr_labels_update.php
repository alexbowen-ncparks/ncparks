<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
// extract($_REQUEST);
mysqli_select_db($connection,$database);

if($submit_label=="Delete"){
	$query = "DELETE FROM labels where id='$id'";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
	
	$query = "DELETE FROM labels_affiliation where person_id='$id'";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}

include("dpr_labels_base.php");

if($submit_label=="Add"){

	$ignore=array("id","custom","affiliation_code","affiliation_name");

	for($i=0;$i<count($fieldArray);$i++){
	$val=${$fieldArray[$i]};// force the variable
	if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
	$val="'".$val."'";
	$arraySet.=",".$fieldArray[$i]."=".$val;
		}

$arraySet=trim($arraySet,",");
	
	$query = "INSERT INTO labels arraySet";
	echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}


if($submit_label=="Update")
	{
	//echo "<pre>"; print_r($_REQUEST); print_r($_POST); echo "</pre>";  exit;
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
		if($fieldArray[$i]=="pac_nomination"){
			$val=str_replace("\r\r", "***", $val);
			$val=str_replace("\n\n", "***", $val);
			$val=str_replace("\r\n\r\n", "***", $val);
			$val=str_replace("\r\n", " ", $val);
			$val=str_replace("***", "\n\n", $val);
			
			}
				$val=trim($val,"\r\n");
				$val=trim($val," ");
				if($fieldArray[$i]=="park"){$val=strtoupper($val);}
				if($fieldArray[$i]=="pac_nomin_month"){$val=str_pad($val,2,"0", STR_PAD_LEFT);}
	$val="'".$val."'";
	$arraySet.=",".$fieldArray[$i]."=".$val;
		}
	
	$arraySet=trim($arraySet,",");
	
	$query = "UPDATE labels SET $arraySet where id='$id'";
	//echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	
	
//	if($add_cat)
//		{
		$sql="DELETE FROM labels_affiliation where person_id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		
		//echo "$sql";exit;
		if(isset($add_cat))
			{
			foreach($add_cat as $k=>$v)
				{
				$sql="INSERT into labels_affiliation set person_id='$id', affiliation_code='$v'";
				//echo "$sql";exit;
				$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
				}
			}
		
//		}
	
	}

if(in_array("PAC",$_POST['add_cat']) OR in_array("PAC_nomin",$_POST['add_cat']))
	{
	$park=$_POST['park'];
//	echo "106"; exit;
	header("Location: dpr_labels_find.php?id=$id&submit_label=Find&pass=$park");
	}
	else
	{
//	echo "111"; exit;
	header("Location: dpr_labels_find.php?id=$id&submit_label=Find");
	}


?>