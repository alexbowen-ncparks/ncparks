<?php

//	ini_set('display_errors',1);

$database = "budget";
//	$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");	//	connection parameters

mysqli_select_db($connection, $database);	//	database

session_start();

/*	
	echo "<pre>";
		print_r($_REQUEST);
	echo "</pre>";
	//	exit;
*/
/*
	echo "<pre>";
		print_r($_SESSION);
	echo "</pre>";
	//	exit;
*/

$level = $_SESSION['budget']['level'];
$beacnum = $_SESSION['budget']['beacon_num'];

// **************  Show Results ***************
$WHERE = "";

extract($_REQUEST);

$sql = "SELECT DISTINCT ncas_account AS OK_account
		FROM `pa_approval_exceptions` 
		";
$result = mysqli_query($connection, $sql)
		OR
		DIE ("Couldn't execute query on Line ". __LINE__ . ":<br /> $sql");

while ($row = mysqli_fetch_array($result))
{
	$approved_accounts[] = strtoupper($row['OK_account']);
}

//	Determine access
if ($level > 2 AND $parkcode != "all")
{
	$WHERE .= " WHERE pcard_unreconciled.admin_num = '$parkcode'";
}

//	comment out if ($level == 2) on 7/19/18

/*
	if($level==2)
	{
		include_once("../../../include/get_parkcodes.php");
		
		$parkList = $_SESSION['budget']['select'];	//	Get District
		
		if (!$parkcode)
		{
			$parkcode = $parkList;
		}
		
		$da = ${"array".$parkList};
		//	print_r($da);
		//	exit;
		
		if (in_array($parkList,$da))
		{
			$parkcode = strtoupper($parkcode);
			if (in_array($parkcode,$da))
			{
				$WHERE .= " where pcard_unreconciled.admin_num='$parkcode'";
			}
			
		}
	}
*/

//	mysqli_select_db($connection, $database);	//	database

//	level == 2 //	added on 7/19/18

if ($level == 2)
{
	$parkcode = strtoupper($parkcode);
	$WHERE = " WHERE pcard_unreconciled.admin_num = '$parkcode'";
	
}

if ($level == 1)
{
	$parkcode = strtoupper($parkcode);
	$parkSession = $_SESSION['budget']['select'];
	if ($parkSession == "ARCH")
	{
		$parkSession = "ADMN";
	}
	
	$WHERE .= " WHERE pcard_unreconciled.admin_num = '$parkSession'";
	
	//	Workaround for NERI/MOJE
	if ($_SESSION['budget']['select'] == "NERI" AND ($parkcode == "NERI" OR $parkcode == "MOJE"))
	{
		$WHERE = " WHERE pcard_unreconciled.admin_num = '$parkcode'";
	}
}

if ($WHERE == "")
{
	if ($admin_num == "all")
	{
		$passAdmin_num = "all";
		$WHERE = "";
	}
	else
	{
		$rep = $_SESSION['budget']['report'];
		echo "You do not have access privileges for this database [$db] report $rep at level $level $posTitle.
			<br />
			Contact DPR Budget Office for assistance with budgetary needs.
			<br />
			Contact <a href='mailto:database.support@ncparks.gov'>database.support@ncparks.gov</a> for technical assistance with this application.
			<br>
			<br>
				budget.php
			<br>
			";
		print_r($a);
		print_r($_SESSION['budget']['report']);
		exit;
	}
}

mysqli_select_db($connection, $database);	//	database

//	******** Show Results ***********
//	Parse any PA Approval Number errors

if ($cardholder)
{
	$WHERE .= " AND pcard_unreconciled.cardholder = '$cardholder'";
	$passCardholder = "$cardholder";
}

if ($beacnum != '60032988')
{
	if ($report_type)
	{
		if ($report_type == "1656-Travel")
		{
			$loc = "1656";
		}
		else
		{
			$loc = $report_type;
		}
	
		$WHERE .= " AND pcard_unreconciled.location = '$loc'";
		$passCardholder = "$cardholder";
	}
}

if ($beacnum == '60032988')
{
	if ($report_type)
	{
		if ($report_type == "1656-Travel")
		{
			$loc = "1656";
		}
		else
		{
			$loc = $report_type;
		}

		$WHERE .= " AND pcard_unreconciled.location = '$loc'";
		$passCardholder = "$cardholder";
	}
}

/*
	if ($beacnum == '60032988')
	{
		if ($report_type)
		{
			$passCardholder = "$cardholder";
		}
	}
*/

if ($report_type)
{
	$newPage = "target='_blank'";

	$query = "SELECT ncasNum
			FROM coa
			WHERE budget_group = 'TRAVEL'
				AND valid_div = 'y'
				AND ((left(ncasNum,6) >= '532700')
					OR (ncasNum = '532181900'))
			ORDER BY ncasNum
			";
	/*
		echo "$query
			<br>
			<br>
			";
	*/
   	$result = @mysqli_query($connection, $query)
   			OR
   			DIE ("Couldn't execute query on Line " . __LINE__ . ":<br /> $sql" . mysqli_error());

	while ($row = mysqli_fetch_assoc($result))
	{
		@$ncas_a .= $row['ncasNum'] . ",";
	}
	
	@$ncas_a = trim($ncas_a,",");
	/*
		echo "$ncas_a
			<br>
			";
	*/

	if ($report_type == "1656-Travel")
	{
		$findNCAS = " AND FIND_IN_SET(ncasNum,'$ncas_a')>0";
	}
	else
	{
		$findNCAS = " AND FIND_IN_SET(ncasNum,'$ncas_a')<1";
	}
}

/*	if ($_SESSION['budget']['tempID'] == "Howard6319")
	{
		$limit = "limit 500";
	}
*/

$sql = "SELECT concat( center_code, '*', pa_number, '*', re_number ) AS app,
			concat( pa_number, '*', re_number ) AS app_menu
		FROM approved_re
		ORDER BY center_code,
				pa_number
		";
$result = mysqli_query($connection, $sql)
		OR
		DIE ("Couldn't execute query on Line " . __LINE__ . ":<br/> $sql");

while ($row = mysqli_fetch_array($result))
{
	$APPROVAL[] = strtoupper($row['app']);
	$APPROVAL_menu[] = strtoupper($row['app_menu']);
}

//	TBASS 5/24/17

//	if ($beacnum == '60032984' OR $beacnum == '60032874')
//	{
//		include("pcard_signatures.php");
//		exit;

include("pcard_signatures.php"); 

//	$cashier = 'George0267';
/*
	echo "<br />beacnum = $beacnum<br />";
	echo "<br />cashier:$cashier
		<br />cashier_date:$cashier_date
		<br />cashier_name:$cashier_name
		<br />cashier_sig_location:$cashier_sig_location";
		//exit;
	echo "<br />manager:$manage
		r<br />manager_date:$manager_date
		<br />manager_name:$manager_name
		<br />manager_sig_location:$manager_sig_location
		"; 
	exit;
*/

/*
	$cashier = 'George0267';
	$cashier_date = '2017-05-22';
	$cashier_name = 'Candis George';
	$cashier_sig_location = '/divper/signature/George0267.jpg';
	$manager = 'Greenwood3182';
	$manager_date = '2017-05-24';
	$manager_name = 'Joy Greenwood';
	$manager_sig_location = '/divper/signature/Greenwood3182.jpg';
*/

if ($cashier == '')
{
	echo "<font color='brown' size='5'>
			Cashier has not Approved Reconcilement.<br />
			Click Back Button on Browser to Return to Reconcilement Form
		</form>
		";
		exit;
}

if ($manager == '')
{
	echo "<font color='brown' size='5'>
			Manager has not Approved Reconcilement.<br />
			Go to Weekly Approvals <a href='pcard_recon_yearly.php?m=pcard&menu_new=MAppr'> Click here </a> to complete Manager Approval
		</font>
		";
	exit;
}

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
				pcard_unreconciled.center AS pc_center,
				pcard_unreconciled.id as pc_id,
				pcard_unreconciled.last_name,
				pcard_unreconciled.first_name,
				pcard_unreconciled.code_1099,
				pcard_unreconciled.contract_num
		FROM pcard_unreconciled
		$WHERE 
			AND xtnd_rundate_new >= '$xtnd_start'
			AND xtnd_rundate_new <= '$xtnd_end'
			$findNCAS
		ORDER BY admin_num,
				cardholder,
				transid_new,
				amount
		";

/*
	echo "xtnd_end = $xtnd_end
			<br />
			<br />
			";
	EXIT;
*/

/*
	if ($beacnum == '60032988')
	{
		echo "$query
				<br />
				<br />
				";
		EXIT;
	}
*/

$result = @mysqli_query($connection, $query);

// echo "f=$form_type c=$cashier"; exit;
if ($form_type == "controller")
{
	//	if ($beacnum == '60032984' OR $beacnum == '60032874')
	//	{

	if ($cashier == '' OR $manager == '')
	{
		include("pcard_recon_pdf_vert.php");
	}

	if($cashier != '' AND $manager != '')
	{
		include("pcard_recon_pdf_vert2.php");
	}
}
//	else
//	{	 	
//		include("pcard_recon_pdf_vert.php");
//	}

if ($form_type == "dpr")
{
	include("pcard_recon_pdf_print.php");
}

?>