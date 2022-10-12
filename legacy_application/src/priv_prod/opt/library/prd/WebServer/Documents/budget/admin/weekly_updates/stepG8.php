<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
/*
$query1="update pcard_extract_worksheet,pcard_unreconciled
set pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new
where pcard_extract_worksheet.ca=pcard_unreconciled.ca
and pcard_extract_worksheet.denr_paid != 'y'
and pcard_extract_worksheet.ca_count='1'
and pcard_extract_worksheet.correction = 'n'
and pcard_unreconciled.ca_count_unposted='1'
and pcard_unreconciled.ncas_yn2='n'
and pcard_unreconciled.transid_date_count='1';
";
*/
$system_entry_date=date("Ymd");

$start_date2=str_replace("-","",$start_date);  //get rid of hyphens in start_date
$start_date3=strtotime($start_date2); //unix time for start_date
$start_date3_90_unix=($start_date3-60*60*24*90);  // unix time for start_date-90 days
$start_date3_90=date("Ymd", $start_date3_90_unix); //yyyymmdd for start_date-90 days

$start_date4_180_unix=($start_date3-60*60*24*180);  // unix time for start_date-90 days
$start_date4_180=date("Ymd", $start_date4_180_unix); //yyyymmdd for start_date-90 days


echo "<br />start_date2=$start_date2<br />";
echo "<br />start_date3=$start_date3<br />";
echo "<br />start_date3_90_unix=$start_date3_90_unix<br />";
echo "<br />start_date3_90=$start_date3_90<br />";
echo "<br />start_date4_180_unix=$start_date4_180_unix<br />";
echo "<br />start_date4_180=$start_date4_180<br />";




//exit;


// 5/26/20 (TBass). In plain english (maybe??): 
// Table1="pcard_extract_worksheet" is a "derivative table" from Table=exp_rev (gold standard for posted transactions in NCAS).  However, some pcard transactions in "exp_rev" were missing pcard information.
// Table2="pcard_unreconciled" is originally populated with partial Data from XTND Report (data is uploaded each week by Budget Office)
// The partial data in Table2 is enough to facilitate the "Pcard Reconcilements" performed by Division
// When Reconcilements are performed by "Division Cashiers", Table2 is populated with additional information (center,ncasnum, etc..)
// The Query below seeks to populate missing Pcard information in Table1 
// Tables 1 and Table 2 were populated with "created fields" in previous Steps which provided each Table with "more unique records" 
// The missing info in Table 1 is provided by Table 2 if the following conditions are met
   //"ca" (center-amount) in Table 1 equals "ca" (center-amount) in Table 2
   //"acct" (ncas account#) in Table 1 equals "ncasnum" (ncas account#) in Table 2
   //"ca_count" (center-amount COUNT) in Table 1 equals: 1   (means only 1 occurrence of center-amount in Table 1)
   //"ca_count_unposted" in Table 1 equals: 1  (Each record in in Table 2 has a "ca" (center-amount). However, we need more specificity as follows:
   //......we are only interested in records in Table 2 that have ONLY 1 occurence of that "ca" in "unposted" status (unposted means Record was not previously "marked as posted" during previous WEEKLY Updates)
   //.... Example (there may be 40 records in Table 2 with the same "ca" ie.. 1680512-30.00, but there may be ONLY 1 record that is "unposted" status. The other 39 were "marked as posted" in previous WEEKLY Updates)
   //"ncas_yn2" in Table2 equals: N  (only interested in "unposted" records that were not marked as "posted" in previous WEEKLY Updates)
   //"transdate_new" in Table 2 can not be more than 90 days OLD from current WEEKLY Update "Start Date".  Don't want to populate additional info in Table 1 with Table 2 data if Record in Table 2 is more than 90 days OLD 

{
$query1="update pcard_extract_worksheet,pcard_unreconciled
set pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new,
    pcard_extract_worksheet.pcard_num=pcard_unreconciled.pcard_num,
	pcard_extract_worksheet.pcard_user=pcard_unreconciled.last_name,
	pcard_extract_worksheet.pcard_vendor=pcard_unreconciled.vendor_name,
	pcard_extract_worksheet.pcard_transdate=pcard_unreconciled.trans_date,
	pcard_extract_worksheet.pcu_verify1='y'
where
    pcard_extract_worksheet.ca=pcard_unreconciled.ca   
and pcard_extract_worksheet.acct=pcard_unreconciled.ncasnum
and pcard_extract_worksheet.ca_count='1'
and pcard_unreconciled.ca_count_unposted='1'
and pcard_unreconciled.ncas_yn2='n'
and pcard_unreconciled.transdate_new >= '$start_date3_90' ;
";

//echo "<br />query1=$query1<br />"; exit;

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");


$query1a="update pcard_extract_worksheet
         set record_complete='y'
		 where pcard_num != 'none'
		 and pcard_user != 'none'
		 and pcard_vendor != 'none'
		 and pcard_transdate != 'none'
         and record_complete='n' ";

//echo "<br />query1a=$query1a<br />"; exit;

mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

}

{
$query2="update pcard_extract_worksheet,pcard_unreconciled
set pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new,
    pcard_extract_worksheet.pcard_num=pcard_unreconciled.pcard_num,
	pcard_extract_worksheet.pcard_user=pcard_unreconciled.last_name,
	pcard_extract_worksheet.pcard_vendor=pcard_unreconciled.vendor_name,
	pcard_extract_worksheet.pcard_transdate=pcard_unreconciled.trans_date,
	pcard_extract_worksheet.pcu_verify2='y'
where
    pcard_extract_worksheet.ca=pcard_unreconciled.ca   
and pcard_extract_worksheet.ca_count='1'
and pcard_unreconciled.ca_count_unposted='1'
and pcard_unreconciled.ncas_yn2='n'
and pcard_unreconciled.transdate_new >= '$start_date3_90'
and record_complete='n' 
and pcu_verify1='n';
";

//echo "<br />query2=$query2<br />"; exit;

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query2a="update pcard_extract_worksheet
         set record_complete='y'
		 where pcard_num != 'none'
		 and pcard_user != 'none'
		 and pcard_vendor != 'none'
		 and pcard_transdate != 'none'
         and record_complete='n' ";

//echo "<br />query2a=$query2a<br />"; exit;

mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a. $query2a");



}

{
$query3="update pcard_extract_worksheet,pcard_unreconciled
set pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new,
    pcard_extract_worksheet.pcard_num=pcard_unreconciled.pcard_num,
	pcard_extract_worksheet.pcard_user=pcard_unreconciled.last_name,
	pcard_extract_worksheet.pcard_vendor=pcard_unreconciled.vendor_name,
	pcard_extract_worksheet.pcard_transdate=pcard_unreconciled.trans_date,
	pcard_extract_worksheet.pcu_verify3='y'
where
    pcard_extract_worksheet.ca=pcard_unreconciled.ca   
and pcard_extract_worksheet.ca_count='1'
and pcard_unreconciled.ca_count_unposted='1'
and pcard_unreconciled.ncas_yn2='n'
and pcard_unreconciled.transdate_new >= '$start_date4_180' 
and record_complete='n' 
and pcu_verify1='n'
and pcu_verify2='n';

";

//echo "<br />query3=$query3<br />"; exit;

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


$query3a="update pcard_extract_worksheet
         set record_complete='y'
		 where pcard_num != 'none'
		 and pcard_user != 'none'
		 and pcard_vendor != 'none'
		 and pcard_transdate != 'none'
         and record_complete='n' ";

//echo "<br />query3a=$query3a<br />"; exit;

mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a. $query3a");

echo "<br />Line 181<br />"; //exit;
}

echo "<br /><br />Line 185<br /><br />"; //exit;


//pcu_verify4
{
/*
$query4="select count(id) as 'incomplete_rec_count_v4'
         from pcard_extract_worksheet
         where ca_count='1' and record_complete='n' and pcu_verify1='n' and pcu_verify2='n' and pcu_verify3='n' and pcu_verify4='n'
         order by id asc		 ";		 
*/

//echo "<br /><br />Hello Line 195<br /><br />"; exit;

$query4="select count(id) as 'incomplete_rec_count_v4'
         from pcard_extract_worksheet
         where ca_count='1' and record_complete='n' and pcu_verify1='n' and pcu_verify2='n' and pcu_verify3='n' and pcu_verify4='n'
         ";		



	
	 
//echo "query4=$query4<br />";		 

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);	
extract($row4);
	
	
echo "<br />incomplete_rec_count=$incomplete_rec_count_v4<br />";


if($incomplete_rec_count_v4 > 0)
{
$x==1;	
for ($x = 1; $x <= $incomplete_rec_count_v4; $x++) 
{


$query4a="select id as 'update_record',ca from pcard_extract_worksheet where ca_count='1' and record_complete='n' 
          and pcu_verify1='n' and pcu_verify2='n' and pcu_verify3='n' and pcu_verify4='n' and pcu_verify4_check='n' order by id asc limit 1";
echo "<br />query4a=$query4a<br />";		 

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);	
extract($row4a);

echo "update_record: $update_record <br>";


$query4b="select id as 'source_record' from  pcard_unreconciled where ca='$ca' and ca_count_unposted > 1 and ncas_yn2='n' and pcard_unreconciled.transdate_new >= '$start_date4_180' order by transdate_new asc limit 1 ";
echo "query4b=$query4b<br />";		 

$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$row4b=mysqli_fetch_array($result4b);	
extract($row4b);
echo "<br />Line228: source_record=$source_record<br />";

$query4c="update pcard_extract_worksheet,pcard_unreconciled
    set pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new,
    pcard_extract_worksheet.pcard_num=pcard_unreconciled.pcard_num,
	pcard_extract_worksheet.pcard_user=pcard_unreconciled.last_name,
	pcard_extract_worksheet.pcard_vendor=pcard_unreconciled.vendor_name,
	pcard_extract_worksheet.pcard_transdate=pcard_unreconciled.trans_date,
	pcard_extract_worksheet.pcu_verify4='y',
	pcard_extract_worksheet.pcu_id='$source_record'
    where pcard_extract_worksheet.id='$update_record' and pcard_unreconciled.id='$source_record' ; ";


echo "query4c=$query4c<br />";		 

$result4c = mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");

$query4d="update pcard_extract_worksheet
         set record_complete='y'
		 where pcard_num != 'none'
		 and pcard_user != 'none'
		 and pcard_vendor != 'none'
		 and pcard_transdate != 'none'
         and record_complete='n' ";

echo "<br />query4d=$query4d<br />"; //exit;

mysqli_query($connection, $query4d) or die ("Couldn't execute query 4d. $query4d");


$query4d1="update pcard_extract_worksheet
         set pcu_verify4_check='y'
		 where id='$update_record' ";

echo "<br />query4d1=$query4d1<br />"; //exit;

mysqli_query($connection, $query4d1) or die ("Couldn't execute query 4d1. $query4d1");





$query4e="update pcard_unreconciled set ncas_yn2='y',posting_unit='weekly_updates',posting_name='$tempid',posting_date='$system_entry_date' where id='$source_record' ";

echo "<br />query4e=$query4e<br />"; //exit;

mysqli_query($connection, $query4e) or die ("Couldn't execute query 4e. $query4e");


$query4e2="update pcard_unreconciled,pcard_extract_worksheet 
           set pcard_unreconciled.pcard_extract_id=pcard_extract_worksheet.extract_id
           where pcard_unreconciled.id='$source_record' and pcard_extract_worksheet.id='$update_record'		   ";

echo "<br />query4e2=$query4e2<br />"; //exit;

mysqli_query($connection, $query4e2) or die ("Couldn't execute query 4e2. $query4e2");






$source_record='';



}	
echo "<br />Line 269"; //exit;	

}
/*
if($incomplete_rec_count_v4 == 0)
{
echo "<br />Line 264"; exit;
}	
*/
$query4e1="update pcard_extract_worksheet
         set pcu_verify4_check='n'
		 where 1 ";

echo "<br />query4e1=$query4e1<br />"; //exit;

mysqli_query($connection, $query4e1) or die ("Couldn't execute query 4e1. $query4e1");

echo "<br />Line 314"; //exit;
}
//pcu_verify5
{
$query5="select count(id) as 'incomplete_rec_count_v5'
         from pcard_extract_worksheet
         where ca_count>'1' and record_complete='n' and pcu_verify1='n' and pcu_verify2='n' and pcu_verify3='n' and pcu_verify4='n' and pcu_verify5='n'
         ";		
         		
	
	 
//echo "query4=$query4<br />";		 

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$row5=mysqli_fetch_array($result5);	
extract($row5);
	
	
echo "<br />incomplete_rec_count=$incomplete_rec_count_v5<br />";


if($incomplete_rec_count_v5 > 0)
{
$x==1;	
for ($x = 1; $x <= $incomplete_rec_count_v5; $x++) 
{	
$query5a="select id as 'update_record',ca,acct,acctdate from pcard_extract_worksheet where ca_count>'1' and record_complete='n' 
          and pcu_verify1='n' and pcu_verify2='n' and pcu_verify3='n' and pcu_verify4='n' and pcu_verify5='n' and pcu_verify5_check='n' and acctdate >= '$start_date4_180' order by ca asc, acct asc, acctdate asc, id asc limit 1";
echo "<br />query5a=$query5a<br />";		 

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");

$row5a=mysqli_fetch_array($result5a);	
extract($row5a);

echo "update_record: $update_record <br>";	

$query5b="select id as 'source_record' from  pcard_unreconciled where ca='$ca'  and ncasnum='$acct' and ncas_yn2='n' and pcard_unreconciled.transdate_new >= '$start_date4_180' order by transdate_new asc, id asc limit 1 ";
echo "query5b=$query5b<br />";		 

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");
$row5b=mysqli_fetch_array($result5b);	
extract($row5b);
echo "<br />Line333: source_record=$source_record<br />";


$query5c="update pcard_extract_worksheet,pcard_unreconciled
    set pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new,
    pcard_extract_worksheet.pcard_num=pcard_unreconciled.pcard_num,
	pcard_extract_worksheet.pcard_user=pcard_unreconciled.last_name,
	pcard_extract_worksheet.pcard_vendor=pcard_unreconciled.vendor_name,
	pcard_extract_worksheet.pcard_transdate=pcard_unreconciled.trans_date,
	pcard_extract_worksheet.pcu_verify5='y',
	pcard_extract_worksheet.pcu_id='$source_record'
    where pcard_extract_worksheet.id='$update_record' and pcard_unreconciled.id='$source_record' ; ";


echo "query5c=$query5c<br />";		 

$result5c = mysqli_query($connection, $query5c) or die ("Couldn't execute query 5c.  $query5c");

$query5d="update pcard_extract_worksheet
         set record_complete='y'
		 where pcard_num != 'none'
		 and pcard_user != 'none'
		 and pcard_vendor != 'none'
		 and pcard_transdate != 'none'
         and record_complete='n' ";

echo "<br />query5d=$query5d<br />"; //exit;

mysqli_query($connection, $query5d) or die ("Couldn't execute query 5d. $query5d");

$query5d1="update pcard_extract_worksheet
         set pcu_verify5_check='y'
		 where id='$update_record' ";

echo "<br />query5d1=$query5d1<br />"; //exit;

mysqli_query($connection, $query5d1) or die ("Couldn't execute query 5d1. $query5d1");

//$query5e="update pcard_unreconciled set ncas_yn2='y' where id='$source_record' ";
$query5e="update pcard_unreconciled set ncas_yn2='y',posting_unit='weekly_updates',posting_name='$tempid',posting_date='$system_entry_date' where id='$source_record' ";

echo "<br />query5e=$query5e<br />"; //exit;

mysqli_query($connection, $query5e) or die ("Couldn't execute query 5e. $query5e");


$query5e2="update pcard_unreconciled,pcard_extract_worksheet 
           set pcard_unreconciled.pcard_extract_id=pcard_extract_worksheet.extract_id
           where pcard_unreconciled.id='$source_record' and pcard_extract_worksheet.id='$update_record'		   ";

echo "<br />query5e2=$query5e2<br />"; //exit;

mysqli_query($connection, $query5e2) or die ("Couldn't execute query 5e2. $query5e2");




$source_record='';





	
}	
	


	
}
$query5e1="update pcard_extract_worksheet
         set pcu_verify5_check='n'
		 where 1 ";

echo "<br />query5e1=$query5e1<br />"; //exit;

mysqli_query($connection, $query5e1) or die ("Couldn't execute query 5e1. $query5e1");	
echo "<br />Last line: pcu_verify5<br />"; exit;
	
}





/*

$query2="update pcard_extract_worksheet,pcard_unreconciled
set pcard_extract_worksheet.transid_date_count=pcard_unreconciled.transid_date_count
where pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
*/


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>