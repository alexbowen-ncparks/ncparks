<?php
//include("../../../include/connectBUDGET.inc");// database connection parameters
date_default_timezone_set('America/New_York');
$tempid=$_SESSION['budget']['tempID'];
//echo "<br />tempid=$tempid<br />";
//if($tempid=='Bass3278' or $tempid=='Owen1111')
//{
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//$vendor_address=$_REQUEST['vendor_address'];
//echo "<br />vendor_address=$vendor_address<br />";

//exit;	
//}

//if($tempid=='Owen1111')
//{	
//echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//}

// NOTE:  If $project_number, Code runs to see if sufficient Funds are available in the "Project CENTER"
if($project_number != '')
{	
//print_r($_SESSION);  exit;
//if($tempid=='Owen1111')
//{	
//echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//}
//echo "<br />project_number=$project_number<br />";
//echo "<br />ncas_fund=$ncas_fund<br />";
//echo "<br />ncas_invoice_amount=$ncas_invoice_amount<br />";

//exit;

$submit_acs_cdcs=$_REQUEST['submit_acs'];
$submit_acs_cdcs_id=$_REQUEST['id'];
//echo "<br />Line 20: submit_acs_cdcs=$submit_acs_cdcs <br />";
if($submit_acs_cdcs=='Update')
{
	
$sql="select ncas_invoice_amount as 'current_invoice_amount' from cid_vendor_invoice_payments where id='$submit_acs_cdcs_id' ";	
$result = @mysqli_query($connection, $sql);
$row=mysqli_fetch_array($result);
extract($row);	
	
//echo "<br />Line 30: sql=$sql<br />";		
//echo "<br />Line 31: current_invoice_amount=$current_invoice_amount<br />";	
}	

//exit;

$query = "truncate table budget.cid_fund_balances_unposted ";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', -ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted(center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode,pcard_admin,pcard_report_date,pcard_start_date,pcard_end_date  ) 
          select center, projnum,ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), xtnd_rundate_new,transdate_new, transid_new, 'pcard',sum(amount), pcard_unreconciled.id,'',admin_num,pcard_unreconciled.report_date,pcard_report_dates.xtnd_start,pcard_report_dates.xtnd_end 
		  from pcard_unreconciled
		  left join pcard_report_dates on pcard_unreconciled.report_date=pcard_report_dates.report_date
		  where 1 and ncas_yn != 'y' group by id;
";
$result = @mysqli_query($connection, $query);


$sql = "truncate table cid_fund_balances";
$result = @mysqli_query($connection, $sql);

//if($level>4){$showSQL=1;}

$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT fund_in, sum( amount ) ,  '',  ''
FROM partf_fund_trans
GROUP  BY fund_in";
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT fund_out,  '', sum( amount ) ,  ''
FROM partf_fund_trans
GROUP  BY fund_out";
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT center,  '',  '', sum( amount )
FROM partf_payments
GROUP  BY center";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);



$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments,unposted )
SELECT center,  '',  '', '', sum(transaction_amount)
FROM cid_fund_balances_unposted
GROUP  BY center";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);



$sql="SELECT sum(fundsin-fundsout-payments-unposted) as 'current_balance' FROM `cid_fund_balances` WHERE `center`='$ncas_fund' ";
$result = @mysqli_query($connection, $sql);
$row=mysqli_fetch_array($result);
extract($row);

if(isset($current_invoice_amount)){$current_balance=$current_balance+$current_invoice_amount;}

//echo "<br />current_invoice_amount=$current_invoice_amount<br />";
//echo "<br />current_balance=$current_balance<br />";
//echo "<br />ncas_invoice_amount=$ncas_invoice_amount<br />";

//exit;


if($ncas_invoice_amount > $current_balance){echo "<font color='red' size='5'>Oops! Unable to Pay Invoice for $ncas_invoice_amount <br />Current Available Balance in $ncas_fund=$current_balance</font> "; exit;}

//if($ncas_invoice_amount <= $current_balance){echo "<font color='red' size='5'>OK to Pay Invoice</font> "; exit;}

//echo "<br />Line71"; exit;
}
//echo "<br />Line73"; exit;
//}

foreach($_REQUEST as $k=>$v)
	{
	
	
	if($v!="" and $k!="submit_acs"){@$passQuery.=$k."=".urlencode($v)."&";}
		
	if($k=="num_invoice")
		{
		if($v>1){$branch=$v;}
		}
	}
$passQuery=trim($passQuery,"&");
//$passQuery.="m=invoices";

//if($tempid=='Bass3278')
//{
//echo "<br />$passQuery<br /><br />vendor_address=$vendor_address"; //exit;
//}

$level=$_SESSION['budget']['level'];
 function DateAdd($v,$d=null , $f="m/d/Y"){ 
  $d=($d?$d:date("m/d/Y")); 
  return date($f,strtotime($v." days",strtotime($d))); 
 }
 
 // Error checking
$e5="";
 if(strpos($comments,"refund")>-1 and $prefix!="43")
	{$e0=" [Prefix for ALL refunds must be 43.]<BR>";}else{$e0="";}
 if(!$ncas_invoice_number){$e1=" [Invoice number]<BR>";}else{$e1="";}
 if(!$ncas_invoice_date){$e2=" [Invoice date]<BR>";}else{$e2="";}
 if(!$ncas_invoice_amount){$e3=" [Invoice amount]<BR>";}else{$e3="";}
 if(!$ncas_number){$e4=" [NCAS account number]<BR>";}else{$e4="";}

if($ncas_number){
	$sql = "SELECT DISTINCT ncas_account as OK_account
	FROM `pa_approval_exceptions` 
	WHERE 1";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result)){
	$approved_accounts[]=strtoupper($row['OK_account']);
	}

$fullNC=$prefix.$ncas_number;

/*
if(in_array($fullNC,$approved_accounts)){
	$approve=1;
	}
*/
if(@$pa_re_number!=""){
	$pare=explode("*",$pa_re_number);
	$pa_number=$pare[1];
	$re_number=$pare[2];
	$sql = "select ncas_account,'-',account_description
		from approved_re
		where pa_number='$pa_number'
		";
	//	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	//	$row=mysqli_fetch_array($result);
	//	$ck_account=$row['ncas_account'];
	//	$account_description=$row['account_description'];
		
	//	if($ck_account==$fullNC OR $pa_number=="0000"){$approve=1;}
	//		else{$approve="";
	//		$explain=$fullNC." is not a valid account for PA# $pa_number - ".$account_description;}	
		}
/*
if($ncas_fund!="1280"){
	$approve=1;
	}
	
if(!$approve){
	$e15="[Please select a valid PA number.] $explain<BR>";
	}
*/

$sql = "SELECT coaid FROM `coa` WHERE ncasNum ='$fullNC' and valid_div='y'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num<1)
	{
	$e10="[Error Message: Not a Valid Account - $fullNC. Please re-check Account Number entered or Contact Tony P. Bass if Account Number is correct]<BR>";
	}else{$e10="";}

	$sql = "SELECT distinct ncas_account FROM `energy` WHERE 1";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result)){
			$checkEnergy[]=$row['ncas_account'];
			}
$e14="";
		if(in_array($fullNC,$checkEnergy)){
			if(!$energy OR !$energy_quantity){
			$e14="[Error Message: When paying for any ENERGY related invoice, you must enter BOTH an Energy Type and an energy_quantity. Contact Tony P. Bass if you have a question.]<BR>";}
			}
}


if($ncas_fund){
	$sql = "select distinct center
from center
where type='project'
and section='natural_resources';
";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result)){
	$approved_centers[]=strtoupper($row['center']);
	}

if(in_array($ncas_fund,$approved_centers) AND $funding_source==""){
	$e16="[Please enter a Valid funding source.]<BR>";
	}else{$e16="";}

}

$ncas_invoice_date=str_replace("-", "/",$ncas_invoice_date);
$splitDate=explode("/",$ncas_invoice_date);
$splitMonth=$splitDate[0];
$splitDay=$splitDate[1];
$splitYear=$splitDate[2];
if(!checkdate($splitMonth,$splitDay,$splitYear)){$e6=" <br> [Invoice date [$ncas_invoice_date] is NOT a valid date.]<BR>";}
$t1=strtotime($ncas_invoice_date);
$t2=strtotime(date("m/d/Y"));
$t3=strtotime("1 January 2000");
 if($t1>$t2){$e6=" <br> [Invoice date is greater than today's date.]<BR>";}else{$e6="";}
 if($t1<$t3){$e6=" <br> [Invoice date [$ncas_invoice_date] is incorrect.]<BR>";}else{$e6="";}

//echo "1=$t1 2=$t2 3=$t3 6=$e6<br>m=$splitMonth d=$splitDay y=$splitYear"; exit;

if(!$parkcode){$e7=" [Park code]<BR>";}else{$e7="";}

if(!$project_number AND $ncas_fund!="1280" AND $ncas_fund!="1932" AND $ncas_fund!="2803" AND $ncas_fund!="1000" and $ncas_fund!="2801" and $ncas_fund!="2823" and $ncas_fund!="1680" and $ncas_fund!="1685" and $ncas_fund!="2605")
{$e8=" Fund $ncas_fund entered requires a project number. Please select PARTF Project Info button & select project number. Thanks<BR>";}else{$e8="";}

$find="4";// force $find to be a string and not an integer
$nn=strpos($ncas_number,$find);// value of 0 means first char = 4
// echo "f=$find nn=$nn  ncas=$ncas_number p=$prefix fu=$ncas_fund";exit;
if(!$er_num AND $nn===0 AND ($ncas_fund=="1280" OR $ncas_fund=="1932" or $ncas_fund=="1680") AND $prefix=="53" and $ncas_rcc != "199")
{$e9="Your Equipment Item requires an Equipment Request Number. Please select the Approved Equipment List button & select an equipment request number. Thanks<BR>";}else{$e9="";}
if(!$ncas_remit_code){$e17="Remit Code Customer# required";}
 
if($received_by=="" AND $received_byAlt==""){$e11=" [received_by]<BR>";}else{$e11="";}
if($prepared_by=="" AND $prepared_byAlt==""){$e12=" [prepared_by]<BR>";}else{$e12="";}
if($approved_by=="" AND $approved_byAlt==""){$e13=" [approved_by]<BR>";}else{$e13="";}
if($comments==""){$e13a=" [comments]<BR>";}else{$e13a="";}
if($vendor_number=="" and $prefix != '43'){$e13b=" [vendor_number]<BR>";}else{$e13b="";}

$passQuery=str_replace("%5Cr%5Cn"," ",$passQuery);
if(!isset($e15)){$e15="";}

 if($e0.$e1.$e2.$e3.$e4.$e5.$e6.$e7.$e8.$e9.$e10.$e11.$e12.$e13.$e13a.$e13b.$e14.$e15.$e16.$e17)
	{
		echo "<table><tr><td><font color='red' size='6'>Form missing data.<br /> DO NOT Hit Back Button on Browser. <br />Use LINK below to return to FORM. Thanks<br /></font></td></tr></table><br /><br />";
	 $e="You failed to include or incorrectly entered a value for:<br /><font color='red'><b>$e0 $e1 $e2 $e3 $e4 $e5 $e6 $e7 $e8 $e9 $e10 $e11 $e12 $e13 $e13a $e13b $e14 $e15 $e16 $e17</b></font><br><br>Click this <a href='acs.php?$passQuery'><font size='6'>LINK</font></a> to correct the code sheet. You will not lose any previously entered values.";
	echo "$e";
	 exit;
	}
 
 
// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType
$sql = "SHOW COLUMNS FROM cid_vendor_invoice_payments";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
{
extract($row);
if($row['Field']!="dateCreate" and $row['Field']!="ncas_center")
	{
	$fieldArray[]=$row['Field'];
	}
// remove dateCreat & ncas_center to prevent dupe entry-see line 132
//$fieldType[]=$row[Type];
}

// ****** Any modifications to variables **********
//session_start();
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];

If($level==1){$parkcode=$_SESSION['budget']['select'];}

$ncas_invoice_amount=str_replace(",","",$ncas_invoice_amount);
//$vendor_address=nl2br($vendor_address);
//$vendor_name=addslashes($vendor_name);
//$ncas_remit_code=addslashes($ncas_remit_code);
$pcard_holder=urldecode(@$pcard_holder);// necessary for O'Neal
//$pcard_sum=addslashes(@$pcard_sum);
//$pcard_just=addslashes(@$pcard_just);
//$comments=addslashes($comments);
if($project_number!=""){$ncas_rcc="";}

if($ncas_fund=="2803"){
	$ncas_budget_code="24817";
	$ncas_company="4602";
	$ncas_rcc="";}
	
if($ncas_fund=="2801"){
	$ncas_budget_code="24310";
	$ncas_company="1602";
	$ncas_rcc="";}	
	
if($ncas_fund=="2823"){
	$ncas_budget_code="24310";
	$ncas_company="1602";}		

if($ncas_fund=="2605"){
	$ncas_budget_code="24805";
	$ncas_company="4602";}
	

$invoice_total=$ncas_invoice_amount+@$ncas_freight;

if($ncas_number=="4410"){$prefix="43";}
$ncas_account=$prefix.$ncas_number;

$dateSQL=date("Ymd",strtotime($ncas_invoice_date));

$pcard_holder=str_replace("\n"," ",$pcard_holder);
$pcard_holder=str_replace("\r"," ",$pcard_holder);
if(@$pcard_holderAlt)
	{
	$pcard_holderAlt=str_replace("\n"," ",$pcard_holderAlt);
	$pcard_holderAlt=str_replace("\r"," ",$pcard_holderAlt);
	$pcard_holder=$pcard_holderAlt;
	}
$pcard_holder=(trim($pcard_holder));
if($received_byAlt){$received_by=(trim($received_byAlt));}
if($prepared_byAlt){$prepared_by=$prepared_byAlt;}
if($approved_byAlt){$approved_by=$approved_byAlt;}
$prepared_by=(trim($prepared_by));
$approved_by=(trim($approved_by));
$user_id=substr($tempID,0,-2);

	if($energy){
		$query = "SELECT upper(concat(energy_group,'-',energy_subgroup)) as concat_energy,cdcs_uom FROM energy where 1";
		$result = mysqli_query($connection, $query);
		while($row=mysqli_fetch_assoc($result)){
				$cdcs[$row['concat_energy']]=$row['cdcs_uom'];
				}
				
		$en=explode("-",$energy);
		
		}


//ECHO "<PRE>";PRINT_R($cdcs);echo "</pre>";//exit;

sort($fieldArray);
//ECHO "<PRE>";PRINT_R($fieldArray);echo "</pre>";exit;

if($_POST['ncas_credit']=="x")
	{
	$ncas_invoice_amount=-abs($_POST['ncas_invoice_amount']);
	$invoice_total=-abs($_POST['invoice_total']);
	}
//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
$removeFld=array("CIA","caa","caa6","caa_count","charge_year","ciaa","ciaa_count","controller_approve","temp_match","temp_match2","posted","TAX_Hwy_Use_AMT","acct6","post2ncas","document_location");
//print_r($fieldArray);exit;
for($i=1;$i<count($fieldArray);$i++)
	{
	if(in_array($fieldArray[$i],$removeFld)){continue;}
		if($fieldArray[$i]!="due_date" and $fieldArray[$i]!="id")
			{
			
			@$val=${$fieldArray[$i]};// force the variable
			$multiArray[$fieldArray[$i]]=$val;
			
			if($fieldArray[$i]=="energy_group"){$val=@$en[0];}
			if($fieldArray[$i]=="energy_subgroup"){$val=@$en[1];}
			if($fieldArray[$i]=="cdcs_uom"){
					$indice=@$en[0]."-".@$en[1];
					$val=@$cdcs[$indice];}
			
			if($fieldArray[$i]=="energy_quantity")
				{$val=str_replace(",","",$val);}
			
			// textarea input doesn't need slashes
		//	if($fieldArray[$i]!="comments" and $fieldArray[$i]!="vendor_name")
		//		{$val=addslashes($val);}
			$val="'".$val."'";
			
			if($i!=1)
				{@$arraySet.=",".$fieldArray[$i]."=".$val;}
				else
				{@$arraySet.=$fieldArray[$i]."=".$val;}
			}		
	}

if($submit_acs=="Submit")
	{
	if(!$due_date||$due_date=="will be calculated")
		{		$due_date=",due_date='".DateAdd(14,$ncas_invoice_date)."-".$parkcode."'";
		}
		else
		{
		$due_date=",due_date='".$due_date."'";
		}
	
	
	 if(@$branch>1){include("acs_multi.php");exit;}
	 
	 
	$query = "INSERT into cid_vendor_invoice_payments SET $arraySet $due_date,ncas_center=concat(ncas_fund,ncas_rcc), document_location='$document_location'";
	
	//echo "insert $query"; exit;
	
	$result = mysqli_query($connection, $query) or die ("Invoice has already been entered for payment. Please click <a href='http://www.dpr.ncparks.gov/budget/acs/acsFind.php?ncas_invoice_amount=$ncas_invoice_amount&ncas_rcc=$ncas_rcc&ncas_invoice_number=$ncas_invoice_number&submit_acs=Find'>here</a> to view Invoice. Please Contact Tony Bass if Invoice has not been paid, & you are still getting an Error Message.<br /><br />$query");
	$id=mysqli_insert_id($connection);
	/*
	if($check_num!=''){
	$query = "UPDATE cid_vendor_invoice_payments SET posted='x' where id='$id'";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");}
	*/
	}

if($submit_acs=="Update"){
$query = "UPDATE cid_vendor_invoice_payments SET $arraySet,due_date='$due_date',system_entry_date=system_entry_date, post2ncas=post2ncas,ncas_center=concat(ncas_fund,ncas_rcc),ncas_remit_park='$ncas_remit_park' where id='$id'";

//echo "update $query";  exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


// override the original system_entry_date if User is Updating a Record in TABLE=cid_vendor_invoice_payments
$system_entry_date2=date("Ymd");
$query = "UPDATE cid_vendor_invoice_payments SET system_entry_date='$system_entry_date2' where id='$id'";

//echo "update $query";  exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

/*
$query = "UPDATE cid_vendor_invoice_payments SET ncas_fund='1685'
          where (ncas_rcc='588' or ncas_rcc='589' or ncas_rcc='590') ";

//echo "update $query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
*/



/*
if($check_num!=''){
$query = "UPDATE cid_vendor_invoice_payments SET posted='x',due_date='$due_date',system_entry_date=system_entry_date, post2ncas=post2ncas where id='$id'";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");}
*/
}

/*
$query = "UPDATE cid_vendor_invoice_payments SET ncas_fund='1685'
          where (ncas_rcc='588' or ncas_rcc='589' or ncas_rcc='590' or ncas_rcc='199') ";
*/

// changed 12/18/19-tbass
$query = "UPDATE cid_vendor_invoice_payments SET ncas_fund='1685'
          where (ncas_rcc='588' or ncas_rcc='589' or ncas_rcc='590') ";

		  

//echo "update $query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

/*
$query = "UPDATE cid_vendor_invoice_payments SET ncas_fund='1680'
          where ncas_fund='1685'
          and (ncas_rcc != '588' and ncas_rcc != '589' and ncas_rcc != '590' and ncas_rcc != '199') ";
*/

// changed 12/18/19-tbass
	  
$query = "UPDATE cid_vendor_invoice_payments SET ncas_fund='1680'
          where ncas_fund='1685'
          and (ncas_rcc != '588' and ncas_rcc != '589' and ncas_rcc != '590') ";  
		  
		  

//echo "update $query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


$query = "UPDATE cid_vendor_invoice_payments SET ncas_center=concat(ncas_fund,ncas_rcc)
          where 1 ";

//echo "update $query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");





//echo "line 335"; exit;

if(!isset($branch)){$branch="";}
header("Location: /budget/acs/acs.php?id=$id&num_invoice=$branch");

?>
