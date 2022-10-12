<?php

session_start();

if (!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$tempid_pcard=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$pcard_recon_version='1';
//$pcard_recon_version='2';

if($tempid_pcard=='Dillard6097'){$pcard_recon_version='2';}

//include("../../../include/authBUDGET.inc");// start_session and gets $level
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
/*
if($tempid_pcard=='Dillard6097')
{
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
}
*/
if($_SESSION['budget']['level']<1)
	{
	echo "You do not have access privileges for this database [budget] report at level . Contact Tony Bass tony.p.bass@ncdenr.gov or Tom Howard tom.howard@ncdenr.gov if you wish to gain access.";
	exit;
	}
	else
	{
	$level=$_SESSION['budget']['level'];
	}


$file="pcard_recon.php";
$fileMenu="pcard_recon_menu.php";
if(!isset($m)){$m="";}
$varQuery=$_SERVER['QUERY_STRING']."&m=$m";
if(!empty($_SERVER['HTTP_REFERER']))
	{
	$var_q=explode("?",$_SERVER['HTTP_REFERER']);
	$varQuery=$var_q[1];
	}
if(@$varQueryPass){$varQuery=$varQueryPass;}
// ECHO "v=$varQuery";//exit;
// ECHO "$_SERVER[QUERY_STRING]";//exit;
//$reportHeader=explode("&",$_SERVER[QUERY_STRING]);
//print_r($reportHeader);

// **** Allow processing assistant access to all centers
if($level<5)
	{
	if($_SESSION['budget']['select']=="ARCH"){$level=3;}
	}
extract($_REQUEST);

if(@$admin_num){$parkcode=$admin_num;}

// *************

@$distPark=strtoupper($parkcode);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

include("../../../include/activity.php");



$query1="SELECT first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count' from cash_handling_roles where role='cashier' and tempid='$tempid_pcard' ";
        
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
//echo "<br />cashier_count=$cashier_count<br />";
if($cashier_nick){$cashier_first=$cashier_nick;}	
//echo "<pre>";print_r($arrayTransID);echo "</pre>";
// ******** Edit/Update Status ***********
if(@$submit=="Update")
	{
	//echo "<pre>";print_r($arrayLocation);echo "</pre>";
//	echo "<pre>";print_r($_POST);echo "</pre>"; exit;



	$pass_admin_num=$_POST['admin_num'];
	
	if(isset($_POST['pa_re_number']))
		{
		foreach($_POST['pa_re_number'] as $k=>$v)
			{
			$var1=explode("*",$v);
			$sql="SELECT re_number,pa_number
			FROM `approved_re`
			WHERE division_approved='y' and pa_number='$var1[0]'";
			$result1 = mysqli_query($connection, $sql);
			$row=mysqli_fetch_array($result1);
				if($row['pa_number']==""){$v="error";}
				$new_pa_re_number[$k]=$v."*".$row['re_number'];
				//echo "$sql<br />";
			}
		//echo "<pre>";print_r($new_pa_re_number);echo "</pre>"; exit;
		}
	$today=date("Y-m-d");
	
	for($i=0;$i<count($arrayTransID);$i++)
		{
		$id=$arrayTransID[$i];
		if(!@$budget_ok[$id])
			{$updateBudget_OK="";}
			else
			{
			$updateBudget_OK=",budget_ok='$budget_ok[$id]'";
				if(@$budget_ok[$id]=="Y")
					{$updateBudget_OK.=",budget2controllers='$today'";}
					else
					{$updateBudget_OK.=",budget2controllers=''";}
			}
		$testCenter="center_".$id;
		$center[$id]=$_REQUEST[$testCenter];
		$testNCAS="ncasnum_".$id; //echo "$testNCAS<br>";
		$ncasnum[$id]=$_REQUEST[$testNCAS]; //echo "$ncasnum[$id]<br>";
		$testEquipNum="equipnum_".$id;
		$equipnum[$id]=$_REQUEST[$testEquipNum];
		
		if($item_purchased[$id]!="" AND $ncasnum[$id]!="" AND $center[$id]!="")
		{$updatepark_recondate=", park_recondate='$today'";}else{$updatepark_recondate=", park_recondate=''";}
		
		$testProjNum="projnum_".$id;
		if($arrayLocation[$i]=="1629"||$arrayLocation[$i]=="1669"){
		$projnum[$id]=$_REQUEST[$testProjNum];
		if($center[$id]!="" AND $projnum[$id]!="")
		{$updatepark_recondate=",park_recondate='$today'";}else{$updatepark_recondate=", park_recondate=''";}
		}
		else{
		$check1616Center=substr($center[$id],0,4);
		if($check1616Center!="1280" AND $check1616Center!="2605" AND $check1616Center!="2803" and $check1616Center!="2801" and $check1616Center!="1680" and $check1616Center!="1685"){$center[$id]="INCORRECT";$m=1;}
		}
		
		// format a correct NCAS number
		$ck_ncasnum=$ncasnum[$id];
		$ck_ncasnum=str_replace("-","",$ck_ncasnum);
		if(strlen($ck_ncasnum)==4 || strlen($ck_ncasnum)==7){$ck_ncasnum="53".$ck_ncasnum;}
		
		// Verify the NCAS number
		$ckSelect="SELECT coaid FROM `coa` WHERE ncasNum ='$ck_ncasnum' and valid_div='y'";
		//echo "$ckSelect";exit;
		$result1 = mysqli_query($connection, $ckSelect);
		$valid=mysqli_num_rows($result1);
		if($valid!=1 AND $ck_ncasnum!=""){
		$e1="bogus";
		$ck_ncasnum="bogus";}
		
		// PA Approval Number
		$pa_number=""; $re_number="";
		if(@$new_pa_re_number[$id]!=""){
			$pare=explode("*",$new_pa_re_number[$id]);
			$pa_number=$pare[0];
			$re_number=$pare[1];
				}
		
		// Check for equip number
		$find="4";// force $find to be a string and not an integer
		$nn=strpos($ck_ncasnum,$find);// value of 0 means first char = 4
		$ncas_fund=substr($center[$id],0,4);
		$prefix=substr($ck_ncasnum,0,2);
		if((!$equipnum[$id] OR $equipnum[$id]=="needed") AND $nn==2 AND ($ncas_fund=="1280" OR $ncas_fund=="1680" OR $ncas_fund=="1932") AND $prefix=="53"){$e2="1";$equipnum[$id]="needed";}
		
		IF($center[$id]=="2803"){$updateCompany=", company='1612'";} else{$updateCompany="";}
		IF($center[$id]=="2801"){$updateCompany=", company='1602'";} else{$updateCompany="";}
		
		$item_pur=html_entity_decode(htmlspecialchars_decode($item_purchased[$id]));
// 		$item_pur=htmlspecialchars_decode($item_purchased[$id]);
		$code_1099=trim($_POST['code_1099'][$id]);
		
		//echo "a=$code_1099 i=$id c=$code_1099<br />";
		
		$query="UPDATE `pcard_unreconciled` 
		set ncas_description='',item_purchased='$item_pur', ncasnum='$ck_ncasnum', center='$center[$id]', projnum='$projnum[$id]', equipnum='$equipnum[$id]', pa_number='$pa_number', re_number='$re_number',code_1099='$code_1099'
		$updatepark_recondate $updateBudget_OK $updateCompany
		WHERE id='$id'";
		//	echo "$query<br>";  //exit;
		$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
		}// end for
	
	$query="update pcard_unreconciled,coa
	 set pcard_unreconciled.ncas_description=coa.park_acct_desc
	 where pcard_unreconciled.ncasnum=coa.ncasnum";
	//echo "$query<br>";//exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
	
	
	
	
	//added 11/4/20
	$query="update pcard_unreconciled,coa
	 set pcard_unreconciled.travel='n'
	 where pcard_unreconciled.ncasnum=coa.ncasnum and coa.budget_group!='travel' and pcard_unreconciled.admin_num='$admin_num' and pcard_unreconciled.report_date='$report_date' ";
	//echo "$query<br>";//exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
	
	
	
	//added 11/4/20
	$query="update pcard_unreconciled,coa
	 set pcard_unreconciled.travel='y'
	 where pcard_unreconciled.ncasnum=coa.ncasnum and coa.budget_group='travel' and coa.valid_div='y' and pcard_unreconciled.admin_num='$admin_num' and pcard_unreconciled.report_date='$report_date' ";
	//echo "$query<br>";//exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");	
	 
	 // added 10/19/16
	
	 $query="update pcard_unreconciled,center
	 set pcard_unreconciled.company=center.new_company
	 where pcard_unreconciled.center=center.new_center
	 and pcard_unreconciled.transdate_new >= '20160701' ";
	//echo "$query<br>";//exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
	
	  $query="update pcard_unreconciled
	 set equipnum=''
	 where equipnum='needed'
	 and transdate_new >= '20160701'
	 and ncasnum not like '534%' ";
	//echo "$query<br>";//exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
	
//if($beacnum=='60032994')
{		

// Changes made on 5/16/20 (Start)-TBass
// Fund used by Pcard Reconciler is determined by looking at the first 4 characters of the Center field. (ie. Center=1680512 equals Fund=1680)	
// (ALL DPR Funds - fund 1680 - fund 1685 - fund 2802 - fund 2803) = CI Funds
// towards the end of the fiscal year (usually May), DNCR-Controllers may restrict DPR from using "CI Funds" when reconciling Pcard transactions
// By default, each week's reconcilement sets $fund_ci==y (ci funds are permitted).  See TABLE=pcard_report_dates. Field=fund_ci
// Budget Office Staff(Dodd-Budget Officer-60032781,Gooding-PCARD Administrator-60032997) can use Administrator Tool in MoneyCounts to restrict
// .... the use of CI Funds by setting $fund_ci==n.  This is accomplished thru URL: /budget/aDiv/pcard_weekly_reports.php?report_date=$report_date


//query1a determines whether current Report Week includes restriction on using CI Funds
$query1a="SELECT fund_ci from pcard_report_dates where report_date='$report_date' ";		 
//echo "query1a=$query1a<br />";	
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
$row1a=mysqli_fetch_array($result1a);
extract($row1a);
//if($beacnum=='60032994')
//{	
//echo "<br />fund_ci=$fund_ci"; 
//exit;
//}

// If current "Report Date" restricts using CI Funds ($fund_ci==n) and Pcard Reconciler uses a CI Fund on Reconcilement Form, Field=center will be updated with Value=invalid
// Pcard Reconciler will see this on the Form and will need to re-enter a Valid Center. A valid center in this context is defined as a center whose first 4 characters are a valid fund
	if($fund_ci=='n')
	{
	$query="update pcard_unreconciled set center='invalid'
        	where report_date='$report_date' and (mid(center,1,4) != '1680' and mid(center,1,4) != '1685' and mid(center,1,4) != '2802' and mid(center,1,4) != '2803' and center != 'incorrect' and center != '' )";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

    $query="update pcard_unreconciled set center='invalid'
        	where report_date='$report_date' and center = '' ";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


	}		
	 
// Changes made on 5/16/20 (End)-TBass		 
}	 
	 
	 
	// echo "<pre>"; print_r($_POST['code_1099']); echo "</pre>";  exit;
	// exit;
	 
	// ECHO "v=$varQuery";exit;
	if(@$e1){$addE1="&e1=$e1";}else{$addE1="";}
	if(@$e2){$addE2="&e2=$e2";}else{$addE2="";}
	//if($pe){$PA_num_error="&pe=$pe";}//$PA_num_error

if($pcard_recon_version=='1')
{
//echo "pcard_recon_version=$pcard_recon_version"; exit;


//if($tempid_pcard!='Dillard6097' and $tempid_pcard!='Goss0610'  )
//{	
	$query3="
	select 
	id,vendor_name,amount,ncasnum
	from pcard_unreconciled
	where admin_num='$pass_admin_num'
	and report_date='$report_date'
	and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
	and document_location = ''
	order by vendor_name,amount,ncasnum
	";
//}


//if( $tempid_pcard!='Dillard6097' and $tempid_pcard!='Goss0610' )
//{	
	$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
	$invoices_remaining=mysqli_num_rows($result3);
//echo "$query3 n=$invoices_remaining";exit;
	if($invoices_remaining>0)
		{
		header("Location: pcard_fixed_assets_document_add.php?admin_num=$admin_num&report_date=$report_date");exit;
		}
//}

		
}


		
		
	$msg2="&msg2=Success"; //exit;
	header("Location: pcard_recon.php?$varQuery$addE1$addE2$msg2");exit;
	}

// **************  Show Results ***************

$sql = "SELECT DISTINCT ncas_account as OK_account
FROM `pa_approval_exceptions` 
WHERE 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql".mysqli_error());
while($row=mysqli_fetch_array($result))
	{
	$approved_accounts[]=strtoupper($row['OK_account']);
	}

//echo "<pre>";print_r($approved_accounts);print_r($_REQUEST);echo "</pre>";exit;

// Determine access
if($beacnum=='60032981'){$level=4; } //bonita meeks
if($beacnum=='60033110'){$level=4; } //so gaylene goodwin can backup WAHO Cashier (kelly chandler)
if($beacnum=='60033009'){$level=1; $parkcode='WAHO'; } //jessie summers (waho)
if($level>2 AND @$parkcode!="all")
{@$WHERE.=" where pcard_unreconciled.admin_num='$parkcode'";}

if($level==2)
	{
		//$level=4;
	include_once("../../../include/get_parkcodes.php");
	$parkList=$_SESSION['budget']['select'];// Get district
	if(!$parkcode){$parkcode=$parkList;}
	$da=${"array".$parkList}; //print_r($da);exit;
	if(in_array($parkList,$da))
		{
		$parkcode=strtoupper($parkcode);
		if(in_array($parkcode,$da) or $level=2)
			{
			$WHERE.=" where pcard_unreconciled.admin_num='$parkcode'";
			}
			else
			{
			echo "<br>No access for $parkcode";exit;
			}
		}
		else
		{
		echo "<br><br>Line 269: You do not have access privileges for this database [$db] report at $level $posTitle. Contact Tom Howard tom.howard@ncmail.net if you wish to gain access.<br>park_project_balances.php<br>budget.php<br>dist=$parkList $distPark";exit;
		}
	mysql_select_db("budget",$connection);
	}

if($level==1)
	{
	@$parkcode=strtoupper($parkcode);
	$parkSession=$_SESSION['budget']['select'];
	if($beacnum=='60033009'){$parkSession='WAHO'; } //jessie summers (waho)
	@$WHERE.=" where pcard_unreconciled.admin_num='$parkSession'";
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
	{
	$rep=$_SESSION['budget']['report'];
	echo "You do not have access privileges for this database [$db] report $rep at level $level $posTitle. Contact Tony Bass tony.p.bass@ncmail.net if you wish to gain access.<br><br>budget.php<br>";
	print_r($a);print_r($_SESSION['budget']['report']);
	exit;}
	}


// ******** Show Results ***********
// Parse any PA Approval Number errors
//echo "<br />Line345: level=$level<br />";
//echo "<br />Line346: cashier_count=$cashier_count<br />";
if(@$rep=="")
	{
	$varQuery=$_SERVER['QUERY_STRING'];
	include("$fileMenu");
	if(@$e1){$msg="<font color='red'> WARNING: Invalid NCAS number. Correct any <font color='green'>bogus</font> ncasnum.</font>";}
	if(@$e2){$msg.=" <font color='red' size='+1'> WARNING: Your Equipment Item requires an Equipment Request Number.</font><br />Please Select the Approved Equip Button where <font color='green'>equipnum is \"needed\"</font>. Thanks";}
	
	// Excel link
if(!isset($msg)){$msg="";}
	if(@$submit=="Find"){echo "<tr><td><a href='pcard_recon.php?$varQuery&rep=excel'>Excel</a> Export </td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$msg</td></tr>";}
	}
//echo "<br />Line316: level=$level<br />";
if(@$rep=="excel")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=pcard_recon_all.xls');
	$forceText="pc-";
	}

//echo "hello=$admin_num";exit;
if(@$submit=="Find" || @$submit=="Produce_Page_to_Print")
	{// another name for parkcode
	
	if($cardholder){$WHERE.=" AND pcard_unreconciled.cardholder='$cardholder'";
	$passCardholder="$cardholder";}
	/*
	if($reconcilStatus){$WHERE.=" and pcard_unreconciled.reconciled='$reconcilStatus'";$passCardholder="$cardholder";}
	*/
	if($report_type)
		{
		if($report_type=="1656-Travel"){$loc="1656";}else{$loc=$report_type;}
		$WHERE.=" and pcard_unreconciled.location='$loc'";
		$passCardholder="$cardholder";
		}
	
	if($report_type)
		{$newPage="target='_blank'";
		
		 $query = "SELECT  ncasNum 
		FROM coa
		WHERE budget_group =  'TRAVEL' AND valid_div =  'y'
		ORDER  BY ncasNum";
		//echo "$query<br><br>"; exit;
		   $result = @mysqli_query($connection, $query);
		while($row = mysqli_fetch_assoc($result))
			{
			@$ncas_a.=$row['ncasNum'].",";
			}
		$ncas_a=trim($ncas_a,",");
		//echo "$ncas_a<br>";
		if($report_type=="1656-Travel"){$findNCAS=" and FIND_IN_SET(ncasNum,'$ncas_a')>0";}else{$findNCAS=" and FIND_IN_SET(ncasNum,'$ncas_a')<1";}
		}
	
	//if($_SESSION['budget']['tempID']=="Howard6319"){$limit="limit 500";}
	
if(!isset($limit)){$limit="";}
	$sql = "SELECT concat( center_code, '*', pa_number, '*', re_number ) as app, concat( pa_number, '*', re_number ) as app_menu
	FROM approved_re
	WHERE 1 
	ORDER BY center_code, pa_number
	$limit"; //echo "$sql";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql".mysqli_error());
	while($row=mysqli_fetch_array($result))
		{
		$APPROVAL[]=strtoupper($row['app']);
		$APPROVAL_menu[]=strtoupper($row['app_menu']);
		}
	
	if(@$rep=="")
		{
		echo "<html><body>";
		echo "<table border='1' cellpadding='3' align='center'>";
	
		if(!isset($newPage)){$newPage="";}
		echo "<form action='pcard_recon.php' name='pcardForm' method='POST'$newPage>";
		
		}
	
	if(!isset($findNCAS)){$findNCAS="";}
	 $query = "SELECT pcard_unreconciled.admin_num,
	pcard_unreconciled.cardholder,
	pcard_unreconciled.pcard_num,
	pcard_unreconciled.location,
	pcard_unreconciled.transid_new AS 'transid',
	pcard_unreconciled.transdate_new AS 'transdate',
	pcard_unreconciled.vendor_name,
	pcard_unreconciled.item_purchased,
	pcard_unreconciled.company,
	pcard_unreconciled.ncasnum,
	pcard_unreconciled.center,
	pcard_unreconciled.code_1099,
	pcard_unreconciled.amount,
	pcard_unreconciled.ncas_description,
	pcard_unreconciled.projnum,
	pcard_unreconciled.equipnum,
	pcard_unreconciled.pa_number,
	pcard_unreconciled.re_number,
	pcard_unreconciled.xtnd_rundate_new,
	pcard_unreconciled.report_date,
	pcard_unreconciled.park_recondate,
	pcard_unreconciled.budget_ok,
	pcard_unreconciled.budget2controllers,
	pcard_unreconciled.reconcilement_date,
	pcard_unreconciled.center as pc_center,
	pcard_unreconciled.document_location,
	pcard_unreconciled.document_location2,
	pcard_unreconciled.id as pc_id
	FROM pcard_unreconciled
	$WHERE 
	and xtnd_rundate_new>='$xtnd_start' and xtnd_rundate_new<='$xtnd_end'
	$findNCAS
	order by admin_num,pcard_num,cardholder,transid_new,amount";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query".mysqli_error());

/*
if($beacnum=='60032997')
{	
echo "Line 418: $query<br>"; //exit;
}
*/	
	if($rep=="excel")
		{
		while($row = mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		$header_array[]=array_keys($ARRAY[0]);
		
		$filename="P_CARD_".$xtnd_end.".csv";
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=$filename");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies

		function outputCSV($header_array, $data) {
			$output = fopen("php://output", "w");
			foreach ($header_array as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			fclose($output);
		}

		outputCSV($header_array, $ARRAY);

		exit;
		}
	$num=mysqli_num_rows($result);
	if($level>3){$cr="<a href='pcard_recon_bo.php?$varQuery'>Controller Report</a>";}
	if($num>1){$s="s";}
if(!isset($msg2)){$msg2="";}

if(!isset($cr)){$cr="";}
	$numHeader="<font color='purple'>$num</font> record$s. <font color='green'>$msg2</font>&nbsp;&nbsp;&nbsp;&nbsp;$cr";
	if(@$showReportHeader and @$rep==""){echo "$showReportHeader";}
	
	if($m==1 and $rep==""){echo "<tr><td colspan='16' align='center'><blink><font color='magenta'>An incorrect Center was entered. Please make the correction.</font></blink></td></tr>";}
	//echo "<br />Line461: level=$level<br />";	
$pcard_report_type="pcard_weekly_reconcile";
//echo "<br />pcard_report_type=$pcard_report_type<br />";
	if($report_type==""){
		if($level<3)
			{
			//removed pa_number from $header after <th>equipnum</th> on 5/20/11-TB
/*			
			if($tempid_pcard!=='Dillard6097')
			{
			$header="<tr><th>admin #</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid<br />transdate</th>
			<th>vendor&nbsp;name</th><th>amount</th><th>item purchased</th><th>ncasnum</th><th>ncas_description</th><th>center</th><th>projnum</th><th>equipnum</th>";
			}
*/			
			
			$header="<tr><th>admin #</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid<br />transdate</th>
			<th>vendor&nbsp;name</th><th>amount</th><th>item purchased</th><th>ncasnum</th><th>ncas_description</th><th>center</th><th>projnum</th><th>equipnum</th>";
			
			
			
			
			
			
			//if($tempid_pcard=='Dillard6097')
			//{echo "<th>Invoices</th>";}
			echo "</tr>";
			if(@$rep==""){echo "$numHeader";}
				echo "1 $header"; 
			include("pcard_recon_L1.php");
			}
echo "<br />level=$level<br />";
			if($level>2)
			{
			// pa_number (after equipnum) removed from $header on 5/20/11-TB
			$header="<tr><th>admin #</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid<br />transdate</th>
			<th>vendor&nbsp;name</th><th>amount</th><th>item purchased</th><th>ncasnum</th><th>ncas_description</th><th>&nbsp;&nbsp;&nbsp;center&nbsp;&nbsp;&nbsp;</th><th>projnum</th><th>equipnum</th></tr>";
			if(@$rep==""){echo "$numHeader";}
			echo "$header";
			//if($_SESSION['budget']['tempID']=="Howard6319"){
			//include("pcard_recon_L5.php");}else{
			include("pcard_recon_L3.php");
			//}
			}
		}// end display Form
	
		else
		//last 2 header values: 1)pa_number and 2)re_number removed from $header on 5/20/11-TB
		{
		$header="<tr><th>admin #</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid</th><th>&nbsp;&nbsp;transdate&nbsp;</th>
		<th>vendor&nbsp;name</th><th>1099</th><th>amount</th><th>item purchased</th><th>ncas_description</th><th>company</th><th>ncasnum</th><th>&nbsp;&nbsp;&nbsp;center&nbsp;&nbsp;&nbsp;</th></tr>";
		echo "$numHeader $header";
		include("pcard_recon_controller.php");
	
		}// end else = Report
	echo "</div></body></html>";
	}
?>
