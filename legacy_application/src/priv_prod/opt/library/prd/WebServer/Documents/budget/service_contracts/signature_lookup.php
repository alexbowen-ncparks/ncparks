<?php
/*
$database="divper";
$db="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
*/

//$cashier='ake2721';
//if($cashier=='Hunt3953'){$cashier='Barbour3953';}
////echo "<br />beginning of signature_lookup.php<br />";
////echo "<br />contract_administrator=$contract_administrator<br />";
////echo "<br />cashier=$cashier<br />";
////echo "<br />manager=$manager<br />";

if($contract_administrator)
{
	$sql = "SELECT `Nname`,`Fname`,`Lname`,`phone` From `divper`.`empinfo` where `tempID`='$contract_administrator'";
	//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	//$row=mysqli_fetch_array($result);
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute sql. $sql");
    $row=mysqli_fetch_array($result);	
	extract($row);
	if($Nname){$Fname=$Nname;}
	$crj_contract_administrator=$Fname." ".$Lname;
	
////	echo "<br />Line 27: sql=$sql<br />";
////	echo "<br />Line 28: contract_administrator_name: $crj_contract_administrator<br />";
}



if($cashier)
{
	$sql = "SELECT `Nname`,`Fname`,`Lname`,`phone` From `divper`.`empinfo` where `tempID`='$cashier'";
	//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	//$row=mysqli_fetch_array($result);
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute sql. $sql");
    $row=mysqli_fetch_array($result);	
	extract($row);
	if($Nname){$Fname=$Nname;}
	$crj_prepared_by=$Fname." ".$Lname;
	
////	echo "Line 28: sql=$sql";
}


//if($cashier=='adams_s' and $parkcode=='CRMO'){$crj_prepared_by="Stacey Adams";}
//if($cashier=='taub_j' and $parkcode=='FALA'){$crj_prepared_by="Judy Taub";}
//if($cashier=='sigmon' and $parkcode=='SOMO'){$crj_prepared_by="Allendria Sigmon";}
//if($cashier=='wagner9210' and $parkcode=='LAWA'){$crj_prepared_by="Paula Wagner";}
//if($cashier=='Eaves9964' and $parkcode=='CRMO'){$crj_prepared_by="Christina Eaves";}

//$manager='anundson9926';
//if($manager=='Hunt3953'){$manager='Barbour3953';}
if($manager)
{
$sql2 = "SELECT `Nname`,`Fname`,`Lname`,`phone` From `divper`.`empinfo` where `tempID`='$manager'";
	//$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query2. $sql2");
	//$row2=mysqli_fetch_array($result2);
	$result2=mysqli_query($connection,$sql2) or die ("Couldn't execute sql2. $sql2");
    $row2=mysqli_fetch_array($result2);	
	extract($row2);
	if($Nname){$Fname=$Nname;}
	$crj_approved_by=$Fname." ".$Lname;
	
////	echo "<br />Line 67: sql=$sql<br />";
////	echo "<br />Line 68: manager: $crj_approved_by<br />";
	
}	


//if($puof=='Hunt3953'){$puof='Barbour3953';}
if($puof)
{
$sql2 = "SELECT `Nname`,`Fname`,`Lname`,`phone` From `divper`.`empinfo` where `tempID`='$puof'";
	//$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query2. $sql2");
	//$row2=mysqli_fetch_array($result2);
	$result2=mysqli_query($connection,$sql2) or die ("Couldn't execute sql2. $sql2");
    $row2=mysqli_fetch_array($result2);		
	extract($row2);
	if($Nname){$Fname=$Nname;}
	$puof_name=$Fname." ".$Lname;
}	



//if($buof=='Hunt3953'){$buof='Barbour3953';}
if($buof)
{
$sql2 = "SELECT Nname,Fname,Lname,phone From `divper`.`empinfo` where `tempID`='$buof'";
	//$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query2. $sql2");
	//$row2=mysqli_fetch_array($result2);
	$result2=mysqli_query($connection,$sql2) or die ("Couldn't execute sql2. $sql2");
    $row2=mysqli_fetch_array($result2);			
	extract($row2);
	if($Nname){$Fname=$Nname;}
	$buof_name=$Fname." ".$Lname;
}	



//echo "sql=$sql<br />";
//echo "puof_name=$puof_name<br />";
//echo "crj_approved_by=$crj_approved_by<br />";	
//echo "sql2=$sql2<br />";
//echo "crj_approved_by=$crj_approved_by<br />";
$database="photos";
$db="photos";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database



$sql3 = "SELECT `link` as 'contract_administrator_signature' From `photos`.`signature` where `personID`='$contract_administrator'";
	//echo "sql3=$sql3<br />";
	//$result3 = mysqli_query($connection, $sql3) or die ("Couldn't execute query3. $sql3");
	//$row3=mysqli_fetch_array($result3);
	$result3=mysqli_query($connection,$sql3) or die ("Couldn't execute sql3. $sql3");
    $row3=mysqli_fetch_array($result3);		
	extract($row3);
	
//$cashier_sig1="/photos/".$cashier_signature;	
$contract_administrator_sig1="/divper/".$contract_administrator_signature;	
//$cashier_sig1="/budget/".$cashier_signature;
//echo "cashier_sig1=$cashier_sig1<br />";



	$sql3 = "SELECT `link` as 'cashier_signature' From `photos`.`signature` where `personID`='$cashier'";
	//echo "sql3=$sql3<br />";
	//$result3 = mysqli_query($connection, $sql3) or die ("Couldn't execute query3. $sql3");
	//$row3=mysqli_fetch_array($result3);
	$result3=mysqli_query($connection,$sql3) or die ("Couldn't execute sql3. $sql3");
    $row3=mysqli_fetch_array($result3);		
	extract($row3);
	
//$cashier_sig1="/photos/".$cashier_signature;	
$cashier_sig1="/divper/".$cashier_signature;	
//$cashier_sig1="/budget/".$cashier_signature;
//echo "cashier_sig1=$cashier_sig1<br />";


$sql4 = "SELECT `link` as 'manager_signature' From `photos`.`signature` where `personID`='$manager' ";
	//echo "sql4=$sql4<br />";
	//$result4 = mysqli_query($connection, $sql4) or die ("Couldn't execute query4. $sql4");
	//$row4=mysqli_fetch_array($result4);
	$result4=mysqli_query($connection,$sql4) or die ("Couldn't execute sql4. $sql4");
    $row4=mysqli_fetch_array($result4);		
	extract($row4);

if($manager_signature=='')
{
$manager_sig1='';
}
else
{	
//$manager_sig1="/photos/".$manager_signature;
$manager_sig1="/divper/".$manager_signature;
//$manager_sig1="/budget/".$manager_signature;
}





$sql5 = "SELECT `link` as 'puof_signature' From `photos`.`signature` where `personID`='$puof'";
	//echo "sql4=$sql4<br />";
	//$result5 = mysqli_query($connection, $sql5) or die ("Couldn't execute query5. $sql5");
	//$row5=mysqli_fetch_array($result5);
	$result5=mysqli_query($connection,$sql5) or die ("Couldn't execute sql5. $sql5");
    $row5=mysqli_fetch_array($result5);		
	extract($row5);

if($puof_signature=='')
{
$puof_sig1='';
}
else
{	
//$manager_sig1="/photos/".$manager_signature;
$puof_sig1="/divper/".$puof_signature;
//$manager_sig1="/budget/".$manager_signature;
}



$sql6 = "SELECT `link` as 'buof_signature' From `photos`.`signature` where `personID`='$buof'";
	//echo "sql4=$sql4<br />";
	//$result6 = mysqli_query($connection, $sql6) or die ("Couldn't execute query6. $sql6");
	//$row6=mysqli_fetch_array($result6);
	$result6=mysqli_query($connection,$sql6) or die ("Couldn't execute sql6. $sql6");
    $row6=mysqli_fetch_array($result6);		
	extract($row6);


if($buof_signature=='')
{
$buof_sig1='';
}
else
{	
//$manager_sig1="/photos/".$manager_signature;
$buof_sig1="/divper/".$buof_signature;
//$manager_sig1="/budget/".$manager_signature;
}
//echo "<br />end of signature_lookup.php<br />";

?>
