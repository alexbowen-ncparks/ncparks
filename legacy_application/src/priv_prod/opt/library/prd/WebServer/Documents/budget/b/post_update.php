<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//if($post2ncas=='y'){$post2ncas2='n';}
//if($post2ncas=='n'){$post2ncas2='y';}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters


if($transaction_type=='cdcs')
{
$query1="update cid_vendor_invoice_payments
         set post2ncas='y'
		 where id='$source_id' ";
}

if($transaction_type=='pcard')
{
$query1="update pcard_unreconciled
         set ncas_yn='y'
		 where id='$source_id' ";
}





		 
//echo "query1=$query1<br />"; exit;		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query = "truncate table budget.project_unposted1;
";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//2
 $query = "insert into project_unposted1( center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, datesql, ncas_invoice_number,'cdcs', ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//3
 $query = "insert into project_unposted1( center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, datesql, ncas_invoice_number,'cdcs', -ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//4
 $query = "insert into project_unposted1(center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode  ) select center, projnum,ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, 'pcard',sum(amount), id,'' from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//5
 $query = "update project_unposted1,partf_projects
set project_unposted1.parkcode=partf_projects.park
where project_unposted1.project_number=partf_projects.projnum
and partf_projects.projyn='y';
";
    $result = @mysqli_query($connection, $query,$connection);







//echo "<table align='center'><tr><th><font color='red'>Update Successful</font><a href='park_project_balances.php?projnum=$projnum&expense=2'>Return to previous page</a></th></tr></table>";
//exit;
//echo "CVIP ID# $id  to $post2ncas2<br />";

header("location: park_project_balances.php?projnum=$projnum&expense=2&message=yes");

?>

























