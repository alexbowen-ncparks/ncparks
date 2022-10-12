<?php
foreach($_POST as $k=>$v)
	{
	if($k!="submit" AND $k!="clear")
		{
		if($v==""){@$missing.="[".$k."] ";}
		if($k=="Lname"){$v=ucfirst($v);}
		if($k=="Fname"){$v=ucfirst($v);}
		if($k=="tempID"){$track=$v; continue;}
		if($v){@$string.="$k='".$v."', ";}
		}
	}
	
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
if(!isset($track)){$track="";}
if(!isset($missing)){$missing="";}
	$Lname=ucfirst($_POST['Lname']);
	$ssn_last4=$_POST['ssn_last4'];
	$Lname=trim($Lname, "  ");
	$Lname=trim($Lname, " ");
	$Lname=str_replace("'","",$Lname);
	$string.="tempID='".$Lname.$ssn_last4."'";
	$string.=", track='".$track."'";
	
if($missing)
	{
	echo "You forgot to enter any info for: <font color='red'>$missing</font>";
	if(strpos($missing,"driver_")>0){echo "<br />Enter \"none\" if applicant doesn't have a driver's license.";}
	if(strpos($missing,"beaconID")>0){echo "<br />Enter \"none\" if applicant doesn't have a BEACON Identification number.";}
	}
else
	{		
	$query="INSERT into sea_employee SET $string";
	//	echo "$query";exit;
	
	$error_message="<font color='red'>It is likely that this seasonal already has a profile in the HR database. Please remember to uncheck the \"Limit to just this Park\" and \"Hide records with a Time Entry (1st day @ work)\" boxes when searching for a seasonal.</font><br /><br />Please click your browser's back button and search again. If this is still a problem, contact your District OA for assistance.<br /><br />$query";
	
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $error_message");
	$tempID=$Lname.$ssn_last4;
	header("Location: new_hire.php?tempID=$tempID&submit=Find");
	}
?>
