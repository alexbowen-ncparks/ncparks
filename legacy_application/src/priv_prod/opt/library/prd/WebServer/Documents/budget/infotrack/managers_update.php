<?php
//echo "hello world";exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

if($first_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form. Click Browser Back Button to enter ALL Form info<br /><br />"; exit;}

if($last_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form. Click Browser Back Button to enter ALL Form info<br /><br />"; exit;}

if($tempid==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form. Click Browser Back Button to enter ALL Form info<br /><br />"; exit;}

if($beacnum==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form. Click Browser Back Button to enter ALL Form info<br /><br />"; exit;}



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

// If MC-User (Bass/Dodd) is Updating Table=cash_handling_roles for existing employee and designating that employee as "Lead Superintendent" ($lead_superintendent=y)
//....we need to verify whether another employee has already been designated as "Lead Superintendent"
//...if so, MC-User gets ERROR Message
if($lead_superintendent=='y')
{
$query4="select count(id) as 'LS_count' from cash_handling_roles where park='$park' and lead_superintendent='y' and tempid != '$tempid' ";

//echo "<br />query4=$query4<br />";	exit;

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");	

$row4=mysqli_fetch_array($result4);
extract($row4);//brings back max (end_date) as $end_date

if($LS_count>0){echo "<font color='brown' size='5'>Oops:<br /> $tempid can not be designated as Lead Superintendent because another employee is designated as Lead Superintendent.<br />  2 employees can not be designated as Lead Superintendent. Click Browser Back Button to Return to Form<br />"; exit;}

}

//echo "<br />Line 48<br />";
//exit;

$system_entry_date=date('Ymd');
if($submit=='update')
{
/*	
$query1="update cash_handling_roles
         set first_name='$first_name',last_name='$last_name',tempid='$tempid',beacnum='$beacnum',role='$role',role_change_by='$manager_name',role_change_date='$system_entry_date'
		 where id='$idS' ";
*/
	
$query1="delete from cash_handling_roles where id='$idS' ";

	
//echo "<br />query1=$query1<br />";		 
		 
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");	

if($role!='none')
{
$query2="insert into cash_handling_roles
         set first_name='$first_name',last_name='$last_name',tempid='$tempid',beacnum='$beacnum',role='$role',park='$park',sig_scale='.30',lead_superintendent='$lead_superintendent',role_change_by='$manager_name',role_change_date='$system_entry_date' ";
}

if($role=='none')
{
$query2="insert into cash_handling_roles
         set first_name='$first_name',last_name='$last_name',tempid='$tempid',beacnum='$beacnum',role='$role',park='$park',sig_scale='.30',lead_superintendent='n',role_change_by='$manager_name',role_change_date='$system_entry_date' ";
}

 
 		 
//echo "<br />query1=$query1<br />";	
//exit;	 
		 
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");	


}

if($submit=='add')
{
	
$query_sig_check="select count(pid) as 'sig_count' from photos.signature where personID='$tempid' ";	

//echo "<br />query_sig_check=$query_sig_check<br />";

$result_sig_check=mysqli_query($connection, $query_sig_check) or die ("Couldn't execute query_sig_check. $query_sig_check");	

$row_sig_check=mysqli_fetch_array($result_sig_check);
extract($row_sig_check);

//echo "<br />Line 70: sig_count=$sig_count<br />";


if($sig_count==0)
{echo "<table align='center'><tr><td><font color='brown' size='5'><br />Oops: User ID <b>$tempid</b> can not be added as Manager (Signature not on File).<br /><br /> ADD Employee Signature via FORM  <a href=''>HERE</a> (Instructions on Form)<br /></font></td>";
exit;
} 	
	

$query0="delete from cash_handling_roles where park='$park' and tempid='$tempid' ";

//echo "<br />query1a=$query1a<br />";	

$result0=mysqli_query($connection, $query0) or die ("Couldn't execute query 0. $query0");


$query1a="select count(id) as 'cashier_count' from cash_handling_roles where park='$park' and role='cashier' and tempid='$tempid' ";

//echo "<br />query1a=$query1a<br />";	

$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");	

$row1a=mysqli_fetch_array($result1a);
extract($row1a);//brings back max (end_date) as $end_date

if($cashier_count > 0){$cashier_role='yes';} else {$cashier_role='no';}

if($cashier_role=="yes"){echo "<font color='brown' size='5'>Oops: $tempid can not be added as Manager, because $tempid is already listed as Cashier.  User can not be in both Roles. <br />If you would like to add $tempid into Role of Manager, you must first remove from Cashier Role<br />Click Browser Back Button to Return to Form<br />"; exit;}


	
$query2="select count(id) as 'manager_count' from cash_handling_roles where park='$park' and role='manager' and tempid='$tempid' ";

//echo "<br />query2=$query2<br />";	

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");	

$row2=mysqli_fetch_array($result2);
extract($row2);//brings back max (end_date) as $end_date

if($manager_count > 0){$manager_role='yes';} else {$manager_role='no';}

if($manager_role=="yes"){echo "<font color='brown' size='5'>Oops: $tempid can not be added as Manager, because $tempid is already listed as  Manager. <br />Click Browser Back Button to Return to Form<br />"; exit;}



	
$query3="insert into cash_handling_roles
         set first_name='$first_name',last_name='$last_name',tempid='$tempid',beacnum='$beacnum',role='manager',park='$park',sig_scale='.20',role_change_by='$manager_name',role_change_date='$system_entry_date'
		  ";
		 
//echo "<br />query3=$query3<br />";	 exit;	 
		 
$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");	
}


header("location: procedures_crj.php?park=$park");





?>
