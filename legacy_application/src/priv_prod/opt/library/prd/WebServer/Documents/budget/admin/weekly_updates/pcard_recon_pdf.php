<?php
ini_set('display_errors',1);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
session_start();
$level=$_SESSION['budget']['level'];
// **************  Show Results ***************
$WHERE="";
extract($_REQUEST);
$sql = "SELECT DISTINCT ncas_account as OK_account
FROM `pa_approval_exceptions` 
WHERE 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$approved_accounts[]=strtoupper($row['OK_account']);
}


// Determine access
if($level>2 AND $parkcode!="all")
{$WHERE.=" where pcard_unreconciled.admin_num='$parkcode'";}

if($level==2)
	{
	include_once("../../../include/get_parkcodes.php");
	$parkList=$_SESSION['budget']['select'];// Get district
	if(!$parkcode){$parkcode=$parkList;}
	$da=${"array".$parkList}; //print_r($da);exit;
	if(in_array($parkList,$da))
		{
		$parkcode=strtoupper($parkcode);
		if(in_array($parkcode,$da)){
		$WHERE.=" where pcard_unreconciled.admin_num='$parkcode'";}
		
		}
	
	}

//mysqli_select_db($connection, $database); // database
if($level==1)
	{
	$parkcode=strtoupper($parkcode);
	$parkSession=$_SESSION['budget']['select'];
	IF($parkSession=="ARCH"){$parkSession="ADMN";}
	$WHERE.=" where pcard_unreconciled.admin_num='$parkSession'";
	//Workaround for NERI/MOJE
	if($_SESSION['budget']['select']=="NERI" and ($parkcode=="NERI" or $parkcode=="MOJE")){
	$WHERE=" where pcard_unreconciled.admin_num='$parkcode'";}
	
	}

if($WHERE=="")
{
if($admin_num=="all"){
$passAdmin_num="all";
$WHERE="WHERE 1";}
else
{$rep=$_SESSION['budget']['report'];echo "You do not have access privileges for this database [$db] report $rep at level $level $posTitle. Contact Tom Howard tom.howard@ncmail.net if you wish to gain access.<br><br>budget.php<br>";print_r($a);print_r($_SESSION['budget']['report']);exit;}
}


mysqli_select_db($connection, $database); // database
// ******** Show Results ***********
// Parse any PA Approval Number errors


if($cardholder){$WHERE.=" AND pcard_unreconciled.cardholder='$cardholder'";
$passCardholder="$cardholder";}


if($report_type){
if($report_type=="1656-Travel"){$loc="1656";}else{$loc=$report_type;}
$WHERE.=" and pcard_unreconciled.location='$loc'";
$passCardholder="$cardholder";}

if($report_type){$newPage="target='_blank'";

 $query = "SELECT  ncasNum 
FROM coa
WHERE budget_group =  'TRAVEL' AND valid_div =  'y'
and ((left(ncasNum,6)>='532700')or(ncasNum='532181900'))
ORDER  BY ncasNum";
//echo "$query<br><br>";
   $result = @mysqli_query($connection, $query,$connection) or die ("Couldn't execute query. $sql".mysqli_error()); ;
while($row = mysqli_fetch_assoc($result))
	{
	@$ncas_a.=$row['ncasNum'].",";
	}
@$ncas_a=trim($ncas_a,",");
//echo "$ncas_a<br>";
if($report_type=="1656-Travel"){$findNCAS=" and FIND_IN_SET(ncasNum,'$ncas_a')>0";}else{$findNCAS=" and FIND_IN_SET(ncasNum,'$ncas_a')<1";}
}

//if($_SESSION['budget']['tempID']=="Howard6319"){$limit="limit 500";}

$sql = "SELECT concat( center_code, '*', pa_number, '*', re_number ) as app, concat( pa_number, '*', re_number ) as app_menu
FROM approved_re
WHERE 1 
ORDER BY center_code, pa_number
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$APPROVAL[]=strtoupper($row['app']);
$APPROVAL_menu[]=strtoupper($row['app_menu']);
}
//TBASS 5/24/17
$query1="SELECT cashier,cashier_date,manager,manager_date
         from pcard_report_dates_compliance
         where admin_num='$parkcode' and report_date='$xtnd_date' ";
		 
echo "query1=$query1<br />";	exit;	 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

 $query = "SELECT pcard_unreconciled.admin_num,
pcard_unreconciled.cardholder,
pcard_unreconciled.pcard_num,
pcard_unreconciled.location,
pcard_unreconciled.transid_new AS 'transid',
pcard_unreconciled.transdate_new AS 'transdate',
pcard_unreconciled.vendor_name,
pcard_unreconciled.amount,
pcard_unreconciled.item_purchased,
pcard_unreconciled.ncas_description,
pcard_unreconciled.company,
pcard_unreconciled.ncasnum,
pcard_unreconciled.center,
pcard_unreconciled.pa_number,
pcard_unreconciled.re_number,
pcard_unreconciled.projnum,
pcard_unreconciled.equipnum,
pcard_unreconciled.xtnd_rundate_new,
pcard_unreconciled.report_date,
pcard_unreconciled.park_recondate,
pcard_unreconciled.budget_ok,
pcard_unreconciled.budget2controllers,
pcard_unreconciled.reconcilement_date,
pcard_unreconciled.center as pc_center,
pcard_unreconciled.id as pc_id,
pcard_unreconciled.last_name,
pcard_unreconciled.first_name,
pcard_unreconciled.code_1099,
pcard_unreconciled.contract_num
FROM pcard_unreconciled
$WHERE 
and xtnd_rundate_new>='$xtnd_start' and xtnd_rundate_new<='$xtnd_end'
$findNCAS
order by admin_num,cardholder,transid_new,amount";

echo "xtnd_end=$xtnd_end<br /><br />"; EXIT;
//echo "$query<br /><br />"; EXIT;
   $result = @mysqli_query($connection, $query,$connection);
   
   if($form_type=="controller")
   	{
   	include("pcard_recon_pdf_vert.php");
   	}
    if($form_type=="dpr")
   	{ include("pcard_recon_pdf_print.php");}
  

?>