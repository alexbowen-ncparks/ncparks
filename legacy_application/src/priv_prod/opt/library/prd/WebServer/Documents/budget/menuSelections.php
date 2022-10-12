<?php
//session_start();
extract($_REQUEST);
//if ($level=='5'){print_r($_REQUEST);}
//print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "<pre>";
//if ($level=='5'){echo "<pre>";print_r($_SESSION);echo "<pre>";}//exit;
$active_file=$_SERVER['SCRIPT_NAME'];
//echo "<br />active_file=$active_file<br />";
// ******** CID Main Menu *************   Non-Admin  Invoices

if(!isset($centerS)){$centerS="";}
$menuArray0=array("Home Page"=>"/budget/menu.php?forum=blank","Budget Forum"=>"/budget/forum.php?m=1","Chart of Accounts"=>"/budget/coa.php","Invoices"=>"/budget/menu.php?m=invoices","PARK BUDGETS"=>"/budget/a/current_year_budget.php?center=$centerS&budget_group_menu=operating_expenses&submit=x", "Park Projects"=>"/budget/b/park_project_balances.php?m=1","Purchase Orders"=>"/budget/c/XTND_po_encumbrances.php?center=$centerS&submit=Find","Transactions Posted"=>"/budget/exp_rev_query.php?m=trans_post","Transactions Unposted"=>"/budget/c/transactions_unposted.php?m=trans_unpost","PCARD "=>"/budget/acs/pcard_recon_menu.php?m=pcard",
"Pre-approval for purchases"=>"/budget/aDiv/park_purchase_request_menu.php?submit=Submit",
"Vendor Payments"=>"/budget/portal.php?dbTable=xtnd_vendor_payments");

//echo "<pre>"; print_r($menuArray0); echo "</pre>"; // exit;

if(@$_SESSION['budget']['manager']!="" || @$level>2)
	{
	$menuArray0['Contracts']="/budget/c/DPR_Contract_Balances.php";
	}
//if(@$level>2){$menuArray0['Receipts']="/budget/receipts/home.php";}
if(@$level>1){$menuArray0['Concessions']="/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&accounts=gmp&section=all&history=10yr&period=fyear";}
//if($level>4){$menuArray0['testing-tbass']="/budget/aDiv2/park_purchase_request_menu.php?submit=Submit";}
//if($level>4){$menuArray0['testing-tbass2']="/budget/acs/pcard_fixed_assets_document_add.php";}
if(@$level>0){$menuArray0['Equipment Invoices-Lookup']="/budget/acs/fixed_assets_doc_lookup.php";}

if(@$level==1){$menuArray0['Budget History-Matrix']="/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&accounts=all&section=operations&history=3yr&period=fyear";}

if(@$level>1){$menuArray0['Budget History-Matrix']="/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&accounts=all&section=all&history=3yr&period=fyear";}

//if(@$level>0){$menuArray0['Cash Receipts Report-ORMS']="/budget/concessions/bank_deposits_menu.php";}

if(@$level>0){$menuArray0['Cash Receipts Report-ORMS']="/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y";}

if(@$level>0){$menuArray0['Quizzes & Games']="/budget/games/multiple_choice/games.php";}
if(@$level>3){$menuArray0['Cash Receipts Journal-Credit Card']="/budget/concessions/bank_deposits_menu_cc_test.php?step=1";}

if(@$level>3){$menuArray0['fixed_asset_weekly']="/budget/admin/fixed_asset_updates/report_view.php";}

/*
if(@$level>3){$menuArray0['Cash Receipts Journal CC-Reports']="/budget/concessions/bank_deposits_menu_cc_reports.php?menu_id=a&menu_selected=y&step=4";}
*/
if(@$level>2){$menuArray0['Project Reports-Matrix']="/budget/projects/project_reports_matrix2.php?report=project";}
if(@$level>3){$menuArray0['UserActivity_Report']="/budget/admin/user_activity/user_activity_matrix.php?period=range&report=user&user_level=all&section=all";}
if(@$level>3){$menuArray0['Energy Reports']="/budget/energy/energy_main.php";}
if(@$level>3){$menuArray0['Service Contracts']="/budget/service_contracts/service_contracts.php";}
/*
if(@$level>4){$menuArray0['TonyTest-Cash Receipts Journal CC']="/budget/concessions/bank_deposits_menu_cc_test.php?step=1";}
*/
//parks with concessions contracts (chro,fala,jord,jori,kela)
if(@$_SESSION['budget']['select']=="CHRO"){$menuArray0['Concession Contracts']="/budget/concessions/vendor_fees_menu.php";}
if(@$_SESSION['budget']['select']=="FALA"){$menuArray0['Concession Contracts']="/budget/concessions/vendor_fees_menu.php";}
if(@$_SESSION['budget']['select']=="JORD"){$menuArray0['Concession Contracts']="/budget/concessions/vendor_fees_menu.php";}
if(@$_SESSION['budget']['select']=="JORI"){$menuArray0['Concession Contracts']="/budget/concessions/vendor_fees_menu.php";}
if(@$_SESSION['budget']['select']=="KELA"){$menuArray0['Concession Contracts']="/budget/concessions/vendor_fees_menu.php";}
if(@$_SESSION['budget']['select']=="CABE"){$menuArray0['Concession Contracts']="/budget/concessions/vendor_fees_menu.php";}
if(@$_SESSION['budget']['select']=="HABE"){$menuArray0['Concession Contracts']="/budget/concessions/vendor_fees_menu.php";}


//if($level>4){$menuArray0['Project_Tracker']="/budget/infotrack/projects_menu.php?folder=community";}
/*
if($_SESSION['budget']['beacon_num']=="60033169"){
	//Facility Construction Eng II position
	$menuArray0['Cash Receipts']="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y";
	}
*/
if(@$level>0){$menuArray0['Cash Receipts']="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y";}

if(@$level>0){$menuArray0['Service Contracts']="/budget/service_contracts/service_contracts.php";}




/*
//warehouse accounting position#60033009
if($_SESSION['budget']['beacon_num']=="60033009"){$menuArray0['Warehouse']="/budget/warehouse/reports_menu.php";}
//accounting specialist i #60032793
if($_SESSION['budget']['beacon_num']=="60032793"){$menuArray0['Warehouse']="/budget/warehouse/reports_menu.php";}
*/

if(@$_SESSION['budget']['report'][0]=="prtf_center_budget"){$menuArray0['Projects_Center_Level']="/budget/b/prtf_center_budget.php?m=1";}
//exhibits curator
if($_SESSION['budget']['beacon_num']=="60032877"){$menuArray0['Projects_Center_Level']="/budget/b/prtf_center_budget.php?m=1";}
//exhibit tech
if($_SESSION['budget']['beacon_num']=="60092637"){$menuArray0['Projects_Center_Level']="/budget/b/prtf_center_budget.php?m=1";}

if($_SESSION['budget']['beacon_num']=="60033162"){$menuArray0['Players']="/budget/home.php";}

if($_SESSION['budget']['beacon_num']=="60032833"){
	//Facility Construction Eng II position
	$menuArray0['Project_Budget_History']="/budget/aProj/dede_reports.php";
	$menuArray0['Projects_Center_Level']="/budget/b/prtf_center_budget.php?m=1";
	}
	
//echo "<pre>"; print_r($menuArray0); echo "</pre>";  //exit;

   
$parkList=explode(",",@$_SESSION['budget']['accessPark']);// set in budget.php from db divper.emplist
//print_r($parkList);
if($parkList[0]!="")
	{
	//if($report==2){exit;}
//	include("../../../include/connectBUDGET.inc");// database connection parameters
	foreach($parkList as $k=>$v){
	$sql="SELECT new_center as 'center',parkCode from center where parkCode='$v' and (new_center like '1680%') ";
	//echo "<br />line 118:sql=$sql<br />";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_array($result);
	$daCode[$v]=$v;$daCenter[$v]=$row['center'];
	}
	
	
	$file0="/budget/menu.php";
	$file=$file0."?passParkcode=";
	if(@$passParkcode==""){$passParkcode=$_SESSION['budget']['select'];
	}
	else{
		$parkcode=$passParkcode;
		$_SESSION['budget']['centerSess_new']=$daCenter[$passParkcode]; //$forum='blank';
		$_SESSION['budget']['select']=$daCode[$passParkcode];
		$query10="SELECT center.old_center
		          from center where parkcode='$parkcode' and fund='1280' ";

//echo "query10=$query10";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);
		$_SESSION['budget']['centerSess']=$old_center;
		//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
		
		}
		
		echo "<td><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";
	foreach($daCode as $k=>$v){
	$con1=$file.$daCode[$v];
		if($daCode[$v]==$_SESSION['budget']['select']){$s="selected";}else{$s="value";}
			echo "<option $s='$con1'>$daCode[$v]-$daCenter[$v]\n";
		   }
	   echo "</select></td></form></tr>"; //echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
	  // }// end in_array
	 }// end $parkList
  

include("menu1314.php");

echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>CID Main Menu</option>";$s="value";
foreach($menuArray0 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";
  

if($_SESSION['budget']['beacon_num']=="60033160"){
	//Environmental Bio Supv II
	include("menuNatRes.php");}
if($_SESSION['budget']['beacon_num']=="60032790"){
	// Parks Resource Mgmt Spec
	include("menuLandRes.php");}

  
   
if(@$m=="park_budget")
	{
	// ******** Invoices *************
	$menuArray0=array("Operating_Expenses_NEW"=>"/budget/a/op_exp_approval.php?m=park_budget");
	
	echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Request for:</option>";$s="value";
	foreach($menuArray0 as $k => $v){
			echo "<option $s='$v'>$k\n";
		   }
	   echo "</select></form></td>";
	}

if(@$m=="invoices")
	{
	// ******** Invoices *************
	$menuArray0=array("Pay Invoice"=>"/budget/acs/acs.php?m=invoices","Find Invoice"=>"/budget/acs/acsFind.php?m=invoices","Find/Add Vendor"=>"/budget/acs/editVendor.php?m=invoices","Reports"=>"/budget/acs/acsReports.php?m=invoices");
	
	echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Invoices</option>";$s="value";
	foreach($menuArray0 as $k => $v){
			echo "<option $s='$v'>$k\n";
		   }
	   echo "</select></form></td>";
	}

if(@$m=="pcard"){
// ******** Invoices *************
$menuArray0=array("Reconcile Pcards"=>"/budget/acs/pcard_recon.php?m=pcard","View Pcard Holders"=>"/budget/acs/editPcardHolders.php?m=pcard","Lookup Transactions"=>"/budget/acs/pcard_trans_lookup.php?m=pcard","Cardholder Documents"=>"/budget/acs/cardholder_documents.php?submit=search","Request PCARD"=>"/budget/acs/pcard_request1.php?edit=y");

echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>PCARDS</option>";$s="value";
foreach($menuArray0 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";
}

if(@$m=="trans_post"){
// ******** Transactions Posted *************
$menuArray0=array("Park Expenses & Revenues"=>"/budget/exp_rev_query.php?m=trans_post","Project Charges"=>"/budget/portalReport.php?dbReport=&form=10&m=trans_post","Warehouse Charges"=>"/budget/a/warehouse.php?m=trans_post");

echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Transactions Posted</option>";$s="value";
foreach($menuArray0 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";
}


// ******** District Reports *************
if(@$level==2)
	{
	unset($menuArray0);
	$menuArray0['Approved Equipment Budget']="/budget/aDiv/dist_equip_request.php?division_approved=y";
	
	$menuArray0['PARTF Projects']="/budget/b/prtf_center_budget.php";
	
	$menuArray0['Report=Equipment Requests']="/budget/aDiv/dist_equip_request.php";
	
	$menuArray0['Budgets by Center']="/budget/a/current_year_budget_div.php?budget_group_menu=operating_expenses&submit=Submit";
	
	$menuArray0['Budget History']="/budget/aDiv/budget_history.php";
	
	$menuArray0['Opex_Requests']="/budget/aDiv/opex_requests.php";
	
	
	echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>District Reports</option>";$s="value";
	foreach($menuArray0 as $k => $v){
			echo "<option $s='$v'>$k\n";
		   }
	   echo "</select></form></td>";
	   }
/*   
if(@$level>3)
	{
	// ******** District / Division Reports *************
	$menuArray0=array("Report=Equipment"=>"/budget/aDiv/equipment_division.php");
	$menuArray0['Equipment_Request']="/budget/aDiv/park_equip_request.php?submit=Submit";
	$menuArray0['Report=pcard_weekly_reports']="/budget/aDiv/pcard_weekly_reports.php";
	$menuArray0['Budgets by Center']="/budget/a/park_budget_menu.php?report=5";
	$menuArray0['Budget History']="/budget/aDiv/budget_history.php";
	$menuArray0['Project_Budget_History']="/budget/aProj/dede_reports.php";
	$menuArray0['DENR Report']="/budget/aDiv/denr_report.php";
	$menuArray0['Report=Division_Budget_Used']="/budget/aDiv/division_budget_used.php";
	$menuArray0['Opex_Requests']="/budget/aDiv/opex_requests.php";
	$menuArray0['year2year_comparison']="/budget/aDiv/year2year_comparison.php";
	$menuArray0['TESTING']="/budget/admin/testing/main.php?project_category=fms&project_name=testing";
	
	
	if(@$level>4){
	$menuArray0['-----------------']="";
	$menuArray0['Weekly PCARD Transactions-DENR BPA']="/budget/aDiv/pcard_weekly_reports_DENR.php";
	
	$menuArray0['Budgets by Account']="/budget/a/current_year_budget_div_by_acct.php?budget_group_menu=operating_expenses&submit=Submit";
	$menuArray0['Report=Equipment Requests (Div. Level)']="/budget/aDiv/div_equip_request.php?submit=Submit";
	
	$menuArray0['Report=Division_Budget']="/budget/aDiv/division_budget.php";
	$menuArray0['Report=Manual_Allocations']="/budget/aDiv/manual_transfer.php";
	
	$menuArray0['Operating_Expenses_TRANSFER']="/budget/a/op_exp_transfer.php";
	$menuArray0['Operating_Expenses_NEW']="/budget/a/op_exp_approval.php";
	$menuArray0['Account_Deficits']="/budget/a/park_budget_menu.php?report=6";
	$menuArray0['Budget_totals_by_Center']="/budget/aDiv/budget_totals_by_center.php";
	
	//  ****** Admin Menu
	$menuAdmin['Administrator Menu']="/budget/menu.php?adminMenu=Administrator Menu";
	$menuAdmin['Import CSV Files']="/budget/admin/stepL3a2.php";
	$menuAdmin['Upload Text Files']="/budget/admin/document_add.php";
	$menuAdmin['Budget History']="/budget/admin/budget_history_division.php";
	$menuAdmin['ProjectManager']="/budget/admin/project_manager/main.php";
	$menuAdmin['Budget History-Projects']="/budget/admin/budget_history_division_projects.php";
	$menuAdmin['WeeklyUpdates']="/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates";
	$menuAdmin['TESTING']="/budget/admin/testing/main.php?project_category=fms&project_name=testing";
	$menuAdmin['Equipment_Division_Budget_test']="/budget/admin/equipment/equipment_division_bo.php";
	$menuAdmin['Receipt_Contracts']="/budget/admin/receipt_contracts/main.php?project_category=receipt&project_name=contract_leases";
	$menuAdmin['Messaging']="/budget/admin/messaging/main.php?project_category=fms&project_name=messaging";
	$menuAdmin['PcardWeekly']="/budget/admin/pcard_updates/step_group.php?project_category=fms&project_name=pcard_updates&step_group=L";
	$menuAdmin['Fixed Asset Weekly']="/budget/admin/fixed_asset_updates/step_group.php?project_category=fms&project_name=fixed_asset_updates&step_group=M";
	$menuAdmin['TEMPLATES']="/budget/admin/templates/main.php?project_category=fms&project_name=templates";
	$menuAdmin['TableTools']="/budget/admin/table_tools/main.php?project_category=fms&project_name=table_tools";
	$menuAdmin['Main']="/budget/main.php";
	//$menuAdmin['Home']="/budget/concessions/reports_all_centers_summary_by_division.php";
	$menuAdmin['Home']="/budget/home.php";
	$menuAdmin['Home2']="/budget/2224.html";
		
	$menuAdmin['UserActivity']="/budget/admin/user_activity/main.php?project_category=fms&project_name=user_activity";
	$menuAdmin['UserActivity_Report']="/budget/admin/user_activity/user_activity_matrix.php?period=range&report=user&user_level=all&section=all";
	//$menuAdmin['Mamajo_messages']="http://mamajo.net/projects/welcome.php";
	$menuAdmin['Mamajo']="/budget/admin/mamajo/step_group.php?project_category=fms&project_name=mamajo&step_group=A";
	$menuAdmin['Pay Contract Invoices']="/budget/contract_exp/pay_invoice.php";	
	
	//  ****** In-progress
	$menuInProgress['In-Progress Menu']="/budget/menu.php?in_progMenu=In-Progress Menu";
	$menuInProgress['Dist-All Approved Budgets-Summary']="/budget/aDiv/division_budget_group.php";
	$menuInProgress['Dist-Operating Expense Budget-Summary']="/budget/c/opex_available_center_totals.php?submit=Submit";
	$menuInProgress['Dist-equipment_0607']="/budget/aDiv/equipment_division.php";
	$menuInProgress['Projects-Avail_Funds_by_Center-Summary']="/budget/accounting/project_avail_fund_center_sum.php";
	$menuInProgress['Projects-Avail_Funds_by_Center-Detail']="/budget/accounting/project_avail_fund_center_detail.php";
	$menuInProgress['Report=Equipment_Available_Center_Totals']="/budget/aDiv/equip_available_center_totals.php";
	$menuInProgress['Report=Division_Budget_by_Group']="/budget/aDiv/division_budget_group.php";
	$menuInProgress['Operating_Expenses_Available']="/budget/c/operating_expense_available.php";
	$menuInProgress['Opex_Available_Center_Totals']="/budget/c/opex_available_center_totals.php?submit=Submit";
	}
	
	if($_SESSION['budget']['beacon_num']!='60033136'){// HR Super.
	
	echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Division Reports</option>";$s="value";
	foreach($menuArray0 as $k => $v){
			echo "<option $s='$v'>$k\n";
		   }
	   echo "</select></form></td>";}
	  } 
 */ 

/* 
if(@$level>4)
	{
	echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\">";
	$a=@urldecode($adminMenu);
	foreach($menuAdmin as $k => $v)
		{
		if($k==$a){$s="selected";}else{$s="value";}
				echo "<option $s='$v'>$k\n";
		}
	   echo "</select></form></td>";
	   
	echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\">";
	$a=@urldecode($menuInProgress);
	foreach($menuInProgress as $k => $v)
		{
		if($k==$a){$s="selected";}else{$s="value";}
				echo "<option $s='$v'>$k\n";
		}
	   echo "</select></form></td>";
	   
	 if(@$adminMenu=="Download XTND Reports")
		 {
		$menuAdmin1['Download XTND Reports']="/budget/menu.php?adminMenu=Download XTND Reports";
		$menuAdmin1['Capital Improvements Curr Mnth']="/budget/admin/cap_imp_cur_mth.php?adminMenu=Download XTND Reports";
		$menuAdmin1['Cert Auth Budg Fund Det Cur Mnth']="/budget/admin/cer_aut_bud_fun_det_cur.php?adminMenu=Download XTND Reports";
		$menuAdmin1['Encumbrance by Center (Division)']="/budget/admin/enc_by_cen_div.php?adminMenu=Download XTND Reports";
		$menuAdmin1['PC Unreconciled Trans by Date']="/budget/admin/pc_unrecon/pc_unrecon_00.php?adminMenu=Download XTND Reports";
		$menuAdmin1['Rev Exp Trans YTD-CY']="/budget/admin/rev_exp_tra_ytd_cy.php?adminMenu=Download XTND Reports";
		
		echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\">";
		$a=urldecode($menuAdmin1);
		
		//echo "<pre>"; print_r($menuAdmin1); echo "</pre>";  exit;
		
		foreach($menuAdmin1 as $k => $v){
		if($k==$a){$s="selected";}else{$s="value";}
				echo "<option $s='$v'>$k\n";
			   }
		   echo "</select></form>$a</td>";
		 
		 }  
	   
	   }
 */ 
if($active_file=='/budget/menu.php'){$forum='blank';} 
if(@$forum=="blank")
	{
	$d=date('l, F jS, Y'); 
	$menuMessage="<font color='blue'>".$d."</font>";
	//echo "<td colspan='4' align='center'>$menuMessage</td></tr></table>";
	
	// Budget Summary
	if($_SESSION['budget']['level']<3){include("budget_summary.php");}
	//if($_SESSION['budget']['level']<3){include("gmp_revenues2.php");}
    if($_SESSION['budget']['level']<3){include("concessions/gmp_revenues.php");}

//echo "<pre>";print_r($menuArray0);echo "</pre>";//exit;
}
if(@$forum=="blank"){exit;}
?>