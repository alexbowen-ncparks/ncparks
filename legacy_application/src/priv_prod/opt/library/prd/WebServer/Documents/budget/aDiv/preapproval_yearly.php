<?php

//if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
$system_entry_date2=date('m-d-y', strtotime($system_entry_date));
$system_entry_date_dow=date('l',strtotime($system_entry_date));
//if($tempID=='McGrath9695'){echo "hello $posTitle Nora Coffey";} else {echo "hello world";}
//310echo "<br />concession_location=$concession_location<br />";
if($concession_location=='ADM'){$concession_location='ADMI';}


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;} 
/*
if($beacnum=='60032780')
{
echo "<br />concession_location=$concession_location<br />";  //0624
echo "<br />park=$park<br />";  //0624
echo "<br />parkcode=$parkcode<br />";  //0624
}
*/









/*
//if($tempID=='Robinson8024' and $concession_location=='STMO'){$posTitle='park superintendent';}
if($tempID=='Church9564' and $concession_location=='LANO'){$posTitle='park superintendent';}
//if($tempID=='Crider2443' and $concession_location=='GOCR'){$posTitle='park superintendent';}
if($tempID=='Rogers2949' and $concession_location=='PETT'){$posTitle='park superintendent';}
if($tempID=='Newsome1830' and $concession_location=='MEMO'){$posTitle='park superintendent';}
if($tempID=='Kendrick3113' and $concession_location=='HABE'){$posTitle='park superintendent';}
if($tempID=='Murr7025' and $concession_location=='MOMO'){$posTitle='park superintendent';}
*/

$menu_new='MAppr';
//310 echo "<br />Line 34: posTitle=$posTitle<br />";
extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//310 echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//if(@$f_year==""){include("../~f_year.php");}
//echo "f_year=$f_year";

//echo "<br />district=$district<br />";
//echo "<br />district_office=$district_office<br />";
//echo "<br />Line 45<br />";
//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
include ("../../budget/menu1415_v1.php");
echo "<br />";
include("preapproval_weekly_menu1.php");
echo "<br />";
include("../../budget/infotrack/slide_toggle_procedures_module2_pid92.php");
//include("preapproval_yearly_fyear.php");
include("preapproval_yearly_fyear_v2.php");


if($beacnum=='60033012'){$concession_location='fama'; $parkcode='fama'; $park='fama'; $stwd1='yes';}
if($beacnum=='60033009'){$concession_location='ware'; $parkcode='ware'; $park='ware'; $stwd1='yes';}
if($beacnum=='60032780'){$concession_location='ined'; $parkcode='ined'; $park='ined'; $stwd1='yes';}
if($beacnum=='60033162'){$concession_location='webs'; $parkcode='webs'; $park='webs'; $stwd1='yes';}
if($beacnum=='60033165'){$concession_location='rale'; $parkcode='rale'; $park='rale'; $stwd1='yes';}





/*
if($beacnum=='60032780')
{
echo "<br />concession_location=$concession_location<br />";  //0624
echo "<br />park=$park<br />";  //0624
echo "<br />parkcode=$parkcode<br />";  //0624
}
*/
echo "<br /><table align='center' border='1' cellspacing='5' cellpadding='5'>";
echo "<tr>";

if($cy==$fyear) // Variables $cy and $fyear set in include file on previous line:  preapproval_yearly_fyear_v2.php
{
$query0="select max(report_date) as 'current_report_date' from purchase_approval_report_dates ";	 

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
		  
$row0=mysqli_fetch_array($result0);

extract($row0);	
//0617 echo "<br />current_report_date=$current_report_date<br />";	
	
	

//echo "<td><font size=4 color='brown' >Current Week</font></td>";
//echo "<th><a href='/budget/aDiv/park_purchase_request.php?submit=Submit'>New Request</a></th>";
//echo "<th><a href='/budget/aDiv/park_purchase_request_view.php?view=all&report_date=$current_report_date&submit=Submit'>View ALL</a></th>";
echo "<th><a href='/budget/aDiv/park_purchase_request_view.php?view=all&report_date=$current_report_date&submit=Submit'>New<br />Request</a></th>";


}
echo "<th><a href='/budget/aDiv/park_purchase_request_view_fyear.php?view=all&fyear=$fyear&center_code=$parkcode&report=y&submit=Submit'>Yearly<br />Requests</th>";
echo "</tr>";
echo "</table>"; 
echo "<br />";




//echo "concession_location=$concession_location<br />";
//310 echo "<br />Line 57: posTitle=$posTitle<br />";

/*
if($cashier_approved=='y')
{
$query1="update preapproval_report_dates_compliance
         set cashier='$cashier',cashier_date='$system_entry_date'
         where center_code='$center_code' and report_date='$report_date' ";	 
		 
//echo "<br />query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	
//{header("location: pcard_recon.php?report_date=$report_date&admin_num=$admin_num&submit=Find&rec_comp=y");}	
	
}
*/
//310 echo "<br />manager_approved=$manager_approved<br />";

if($manager_approved=='y')
{
// 60033012 (Jody Reavis-Chief of Maintenance)
if($beacnum!='60033012')
{	
$query1="update preapproval_report_dates_compliance
         set manager='$manager',manager_date='$system_entry_date',center_approved='y'
         where center_code='$center_code' and report_date='$report_date' ";	 
		 
//310echo "<br /><font color='red'>Line 150: query1=$query1</font><br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	

/*
$query2="update purchase_request_3
         set center_approved='y'
         where center_code='$center_code' and report_date='$report_date'
         and center_approved='u' ";	 
		 
//310 echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");	
*/

$query2="update purchase_request_3
         set division_approved='y',division_app_type='park'
         where center_code='$center_code' and report_date='$report_date'
         and requested_amount <= '1000.00'
		 and center_approved='y' ";


$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");	


$query2a="update purchase_request_3
         set division_approved='n',division_app_type='park'
         where center_code='$center_code' and report_date='$report_date'
         and center_approved='n' ";


$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
}

//60033012 (Jody Reavis-Chief of Maintenance)
if($beacnum=='60033012')
{
$query1="update preapproval_report_dates_compliance
         set manager='$manager',manager_date='$system_entry_date',center_approved='y'
         where (center_code='fama' or center_code='ware') and report_date='$report_date' ";	 
		 
//310echo "<br /><font color='red'>Line 150: query1=$query1</font><br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="update purchase_request_3
         set division_approved='y',division_app_type='park'
         where (center_code='fama' or center_code='ware') and report_date='$report_date'
         and requested_amount <= '1000.00'
		 and center_approved='y' ";


$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");	

$query2a="update purchase_request_3
         set division_approved='n',division_app_type='park'
         where (center_code='fama' or center_code='ware') and report_date='$report_date'
         and center_approved='n' ";


$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");





}	




}


if($region_approved=='y')
{
// NOTE: $region_approved==y does NOT mean that the District Manager approved all Requests for his/her Parks for the Week
// $region_approved==y  indicates that the FORM submission from PHP file: preapproval_weekly.php was successfully provided by the "District Manager"
// Individual pre-approval requests for each Park might be: "unreviewed", "approved", or  "denied"  and those decisions/data updates were made by "District Manager" in PHP file: preapproval_weekly.php (PRIOR to form submission)
// The GOAL here is to mark District Manager in compliance with reviewing weekly pre-approval requests for his/her parks.

	
//echo "<br />Line 124<br />"; exit;


//District Manager Table updates based on "District Manager Form" APPROVAL
if($park_code_drill=='')
{
$query1="update preapproval_report_dates_compliance
         set region_approver='$region_approver',region_approver_date='$system_entry_date',region_approved='y'
         where district='$district' and report_date='$report_date' ";	 
		 
//echo "<br />query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
}

//Park Manager Table updates based on "Park Form" APPROVAL (District Manager acted as "Backup Park Manager")
if($park_code_drill!='')
{
$query1a="update preapproval_report_dates_compliance
         set manager='$region_approver',manager_date='$system_entry_date',center_approved='y'
         where center_code='$park_code_drill' and report_date='$report_date' ";	 
		 
//echo "<br />query1a=$query1a<br />";		 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
}





// Once we know that the District Manager has reviewed the weekly pre-approval requests for his/her parks, we can update the status of TABLE=purchase_request_3
// Unlike TABLE=preapproval_report_dates_compliance (updated above) which ONLY includes 1 record per week per park, TABLE=purchase_request_3 houses the individual pre-approval requests submitted by the Parks
// NOTE: The 2 important Fields in this Table are:  1) district_approved  and  2) division_approved
// IMPORTANT:  PRIOR to Weekly Form Submission, the District Manager ALREADY updated  Field=district_approved in PHP file: preapproval_weekly.php
// The 4 Queries below are using the appropriate LOGIC to update Field=division_approved
// You may be asking why the District Manager is updating a Field named: division_approved
// The reason is that NOT all pre-approval requests are reviewed by ALL Levels: Park/District/Section/Division.  Each Level only sees the pre-approval requests that require their intervention.
// Certain conditions can be met that will eliminate the need for Upstream Approvers (Section Chief, etc..) to REVIEW individual pre-approval requests
// However, we need a way to indicate to the TABLE which "individual requests"  are complete.  A complete record has Field: division_approved=y or division_approved=n  (remember: by default: division_approved=u)
// The 4 Queries below meet the requirements necessary to mark "individual requests" as division_approved=n or division_approved=y.

 


// The Form dislayed to District Managers (preapproval_weekly.php) ONLY shows District Managers those "pre-approval requests" approved by PASU for amounts >= 1000.00
// PASU approved Requests < 1000.00 were NOT REQUIRED to be "reviewed" by District Manager.
// While the District Manager is NOT required to review requests < 1000.00 he/she may decide to review ALL requests by his/her Parks (even requests < 1000.00)
// MoneyCounts basically allows (though does not require), District Managers to "approve" or "disapprove" those requests < 1000.00  It also allows the District Manager to do nothing (because it is not required).
// Because of this, "individual pre-approval requests" for a Park can have 3 possible values in Field: "district_approved" (y=approved, n=disapproved, u=unreviewed)
// Based on the 1) Dollar Amount of the individual request and the 2) Status of Field=district_approved (y,n,u), Field=division_approved and be updated accordingly:

// Condition 1
// Individual pre-approval requests: < 1000 ONLY REQUIRE Approval by Park Manager. So if District Manager did not "approve" (disu_approved=y) or "disapprove" (disu_approved=n)
// ... then no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=y

/*
$query2="update purchase_request_3
         set division_approved='y',division_app_type='park'
         where district='$district' and report_date='$report_date'
         and requested_amount < '1000.00'
		 and center_approved='y'
		 and district_approved='u' ";	 		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

*/	

// Condition 2
// Individual pre-approval requests: < 1000  ONLY REQUIRE Approval by Park Manager. However, District Manager decided to "drilldown" and actually Approve those requests." (disu_approved=y)
// Since request is < 1000 AND District Manager approved (though he/she didn't need to) no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=y


/*
$query2a="update purchase_request_3
         set division_approved='y',division_app_type='dist'
         where district='$district' and report_date='$report_date'
         and requested_amount < '1000.00'
		 and center_approved='y'
		 and district_approved='y' ";	 
		 
//0617 echo "<br />query2a=$query2a<br />";		 

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
*/

// Condition 3
// Individual pre-approval requests: < 1000  ONLY REQUIRE Approval by Park Manager. However, District Manager decided to "drilldown" and actually DisApprove those requests." (disu_approved=y)
// Since request is < 1000 AND District Manager disapproved (though he/she didn't need to) no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=n

/*
$query2b="update purchase_request_3
         set division_approved='n',division_app_type='dist'
         where district='$district' and report_date='$report_date'
         and requested_amount < '1000.00'
		 and center_approved='y'
		 and district_approved='n' ";	 
		 
//0617 echo "<br />query2b=$query2b<br />";		 

$result2b = mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");
*/



// Condition 4
// Individual pre-approval requests: >= 1000 and < 2500  REQUIRE Approval by Park Manager and District Manager. District Manager Approves
// However, no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=y

//District Manager Table updates based on "District Manager Form" APPROVAL

if($park_code_drill=='')
{
$query3="update purchase_request_3
         set division_approved='y',division_app_type='dist'
         where district='$district' and report_date='$report_date'
         and requested_amount >= '1000.01' and requested_amount <= '2500.00'
		 and center_approved='y'
		 and district_approved='y' ";	 
		 
//0617 echo "<br />query3=$query3<br />";		 

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");	

// Condition 5
// Individual pre-approval requests: >= 1000 and < 2500  REQUIRE Approval by Park Manager and District Manager. District Manager DisApproves
// Since District Manager DisApproves no further  "upsteam approval" is required for this request.  Therefore, Field: division_approved=n


$query4="update purchase_request_3
         set division_approved='n',division_app_type='dist'
         where district='$district' and report_date='$report_date'
         and requested_amount >= '1000.01' and requested_amount <= '2500.00'
		 and center_approved='y'
		 and district_approved = 'n' ";	 
		 
//0617 echo "<br />query4=$query4<br />";		 

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


// Condition 6
// Individual pre-approval requests entered by "District Office" which did not receive Center Approval REQUIRE approval by District Manager. District Manager DisApproves
// Since District Manager DisApproves no further  "upsteam approval" is required for this request.  Therefore, Field: division_approved=n

$query4a="update purchase_request_3
         set division_approved='n',division_app_type='dist'
         where district='$district' and center_code='$district_office'
		 and report_date='$report_date' and district_approved = 'n' ";	 
		 
//0617 echo "<br />query4a=$query4a<br />";		 

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");



// Condition 7
// Individual pre-approval requests entered by "District Office" which did not receive Center Approval REQUIRE approval by District Manager. District Manager Approves
// However, no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=y

$query4b="update purchase_request_3
         set division_approved='y',division_app_type='dist'
         where district='$district' and center_code='$district_office'
		 and report_date='$report_date' and district_approved = 'y'
		 and requested_amount <= '2500.00' ";	 
		 
//0617 echo "<br />query4b=$query4b<br />";		 

$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

}

//Park Manager Table updates based on "Park Form" APPROVAL (District Manager acted as "Backup Park Manager")
if($park_code_drill!='')
{

$query2="update purchase_request_3
         set division_approved='y',division_app_type='dist'
         where center_code='$park_code_drill' and report_date='$report_date'
         and requested_amount <= '2500.00'
		 and district_approved='y' ";


$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");	


$query2a="update purchase_request_3
         set division_approved='n',division_app_type='dist'
         where center_code='$park_code_drill' and report_date='$report_date'
         and district_approved='n' ";


$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");



}


}



if($section_approved=='y')
{
	
if($district_code_drill=='')
{	
$query5="update preapproval_report_dates_compliance
         set section_approver='$section_approver',section_approver_date='$system_entry_date',section_approved='y'
         where section='$section' and report_date='$report_date' ";	 
		 
//0617 echo "<br />query5=$query5<br />";		 

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");	

// Condition 1
// Individual pre-approval requests: >= 2500  REQUIRE Approval by Park Manager and District Manager and Section Manager. Section Manager Approves
// However, no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=y


$query5a="update purchase_request_3
         set division_approved='y',division_app_type='sect'
         where report_date='$report_date'
         and requested_amount >= '2500.01' 
		 and center_approved='y'
		 and district_approved='y'
         and section_approved='y' ";	 
		 
//0617 echo "<br />query5a=$query5a<br />";		 

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");

// Condition 2
// Individual pre-approval requests: >= 2500  REQUIRE Approval by Park Manager and District Manager and Section Manager. Section Manager DisApproves
// However, no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=n


$query5b="update purchase_request_3
         set division_approved='n',division_app_type='sect'
         where report_date='$report_date'
         and requested_amount >= '2500.01' 
		 and center_approved='y'
		 and district_approved='y'
         and section_approved='n' ";	 
		 
//0617 echo "<br />query5b=$query5b<br />";		 

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");



//this allows Section Manager CHOP to Approve/Disapprove ALL Requests for June 2020 ONLY (prior to New Procedures that go into effect on July 1 2020)
if(
$report_date=='2020-06-25'
 or $report_date=='2020-06-18'
 or $report_date=='2020-06-11'
 or $report_date=='2020-06-04'
 or $report_date=='2020-05-28'
 or $report_date=='2020-05-21'
 or $report_date=='2020-05-14'
 or $report_date=='2020-05-07'
 or $report_date=='2020-04-30'
 or $report_date=='2020-04-23'
 or $report_date=='2020-04-16'
 or $report_date=='2020-04-09'
 or $report_date=='2020-04-02'
)
{
$query5c="update purchase_request_3
         set division_approved='y',division_app_type='sect'
         where report_date='$report_date'
         and section_approved='y' ";	 
		 
//0617 echo "<br />query5c=$query5c<br />";		 

$result5c = mysqli_query($connection, $query5c) or die ("Couldn't execute query 5c.  $query5c");


$query5d="update purchase_request_3
         set division_approved='n',division_app_type='sect'
         where report_date='$report_date'
         and section_approved='n' ";	 
		 
//0617 echo "<br />query5d=$query5d<br />";		 

$result5d = mysqli_query($connection, $query5d) or die ("Couldn't execute query 5d.  $query5d");

	
	
}


// Condition 3
// Individual pre-approval requests: < 2500  ONLY REQUIRE Approval by Park Manager and District Manager. However, Section Manager decided to "drilldown" and actually DisApprove those requests." (section_approved=n)
// Since request is < 2500 AND Section Manager disapproved (though he/she was not required to) no further "upsteam approval" is required for this request.  Therefore, Field: division_approved=n

/*
$query5c="update purchase_request_3
         set division_approved='n',division_app_type='sect'
         where report_date='$report_date'
         and requested_amount < '2500.00' 
		 and center_approved='y'
		 and district_approved='y'
         and section_approved='n' ";	 
		 
//0617 echo "<br />query5c=$query5c<br />";		 

$result5c = mysqli_query($connection, $query5c) or die ("Couldn't execute query 5c.  $query5c");

*/



}


if($district_code_drill!='')
{	
$query5="update preapproval_report_dates_compliance
         set region_approver='$section_approver',region_approver_date='$system_entry_date',region_approved='y' where district='$district_code_drill' and report_date='$report_date' ";	 
		 
//0617 echo "<br />query5=$query5<br />";		 

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");



$query5a="update purchase_request_3
         set division_approved='y',division_app_type='sect'
         where district='$district_code_drill' and report_date='$report_date'
         and section_approved='y' ";	 
		 
//0617 echo "<br />query5a=$query5a<br />";		 

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");


$query5b="update purchase_request_3
         set division_approved='n',division_app_type='sect'
         where district='$district_code_drill' and report_date='$report_date'
         and section_approved='n' ";	 
		 
//0617 echo "<br />query5b=$query5b<br />";		 

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");



}


	
}


//if($tempID=='Allcox9961' and $concession_location=='HARI'){$posTitle='park superintendent';}
/*
if($beacnum=='60032780')
{
echo "<br />concession_location=$concession_location<br />";  //0624
echo "<br />park=$park<br />";  //0624
echo "<br />parkcode=$parkcode<br />";  //0624
}
*/


/*
if($beacnum=='60033012'){$concession_location='fama'; $stwd1='yes';}
if($beacnum=='60033009'){$concession_location='ware'; $stwd1='yes';}
if($beacnum=='60032780'){$concession_location='ined'; $stwd1='yes';}
*/

//echo "<br />stwd1=$stwd1<br />";
if($level==1 or $stwd1=='yes')
{

//310 echo "park=$park<br />";
if($park != ''){$concession_location=$park;}

$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempID' ";	 

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_count==1){$pasu_role='y';}

//echo "query1b=$query1b<br />";
/*
if($beacnum=='60033012' or $beacnum=='60033009' or $beacnum=='60032780' or $beacnum=='60033162')
{
echo "<br />concession_location=$concession_location<br />";  //0624
echo "<br />park=$park<br />";  //0624
echo "<br />parkcode=$parkcode<br />";  //0624
}
*/

if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;} 
//310 echo "<br />parkcode=$parkcode<br />";


$system_entry_date=date("Ymd");


echo "<br />";

if($beacnum!='60033012')
{
$query11="SELECT center_code,admin_num,report_date,sum(record_count) as 'record_count',cashier,cashier_date,manager,manager_date,center_approved,region_approver,region_approver_date,region_approved,section_approver,section_approver_date,section_approved,deadline_ok2
from preapproval_report_dates_compliance
WHERE 1
and (center_code='$parkcode' )
and fiscal_year='$fyear'
group by report_date
order by report_date desc ";
}

//60033012 (Jody Reavis-Chief of Maintenance)
if($beacnum=='60033012')
{
$query11="SELECT center_code,admin_num,report_date,sum(record_count) as 'record_count',cashier,cashier_date,manager,manager_date,center_approved,region_approver,region_approver_date,region_approved,section_approver,section_approver_date,section_approved,deadline_ok2
from preapproval_report_dates_compliance
WHERE 1
and (center_code='fama' or center_code='ware' )
and fiscal_year='$fyear'
group by report_date
order by report_date desc ";
}








/*
if($beacnum=='60032780')
{
echo "<br />Line 198: query11==$query11<br />";  //0624
}
*/
//echo "<br />Line 595: query1=$query11<br />";


$query="SELECT count(id) as 'yes_deadline' from preapproval_report_dates_compliance where 1 
        and center_code='$parkcode' and fiscal_year='$fyear'
		and deadline_ok2='y'";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$row=mysqli_fetch_array($result);
extract($row);

$query="SELECT count(id) as 'total_deadline' from preapproval_report_dates_compliance where 1 
        and center_code='$parkcode' and fiscal_year='$fyear'
		and deadline_ok2 != '' ";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$row=mysqli_fetch_array($result);
extract($row);

//310 echo "<br />yes_deadline=$yes_deadline<br />";
//310 echo "<br />total_deadline=$total_deadline<br />";
$score=($yes_deadline/$total_deadline)*100;
if($total_deadline==0){$score='100.00';}
$score=number_format($score,0);
//echo "<br />score=$score<br />";


//$score='100';
//echo "<table align='center'><tr><th><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";
echo "<br />";




//}



 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";


echo "<br />";
//echo "<table align='center'><tr><th><font color='red'>Weekly Approvals ($parkcode)</font></th></tr></table>";
echo "<br />";
//echo "<br /><br />";
echo "<table align='center'>";

echo "<tr>"; 
       
       echo "<th align=left><font color=brown>Report<br />Date</font></th>";       
       //echo "<th align=left><font color=brown>Center</font></th>";       
       echo "<th align=left><font color=brown>Approval<br />Requests</font></th>";
     //echo "<th align=left><font color=brown>Cashier<br />Approval</font></th>";
	   echo "<th align=left><font color=brown>Manager<br />Approval</font></th>";
	   //echo "<th align=left><font color=brown>District<br />Approval</font></th>";
	   //echo "<th align=left><font color=brown>Section<br />Approval</font></th>";
	   //echo "<th align=left><font color=brown>BUOF<br />Deadline OK</font></th>";
	   
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
//$park_oob=$cashier_amount-$manager_amount;
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);
$region_approver3=substr($region_approver,0,-2);
$section_approver3=substr($section_approver,0,-2);
$refund_total=number_format($refund_total,2);

$cashier_date=str_replace("-","",$cashier_date);
$manager_date=str_replace("-","",$manager_date);
$region_approver_date=str_replace("-","",$region_approver_date);
$section_approver_date=str_replace("-","",$section_approver_date);

if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}

if($region_approver_date=='0000-00-00')
{$region_approver_date_dow='';}
else
{$region_approver_date_dow=date('l',strtotime($region_approver_date));}

if($section_approver_date=='0000-00-00')
{$section_approver_date_dow='';}
else
{$section_approver_date_dow=date('l',strtotime($section_approver_date));}




$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$region_approver_date2=date('m-d-y', strtotime($region_approver_date));
$section_approver_date2=date('m-d-y', strtotime($section_approver_date));

if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo"<tr$t>";
echo "<td bgcolor='lightgreen'>$report_date</td>";
//echo "<td bgcolor='lightgreen'>$center_code</td>";
echo "<td bgcolor='lightgreen'>$record_count</td>";
					   
		      
		   //Manager Approval has 3 possible outcomes 
		   if($manager=='' and $pasu_role == 'y')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y' >Update</a></td>";
		   } 
		   
		   
		    if($manager == '' and $pasu_role != 'y')
		   {
		   echo "<td bgcolor='lightpink'></td>";  
		   }
		  		   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2";
		 echo "<br />$manager_date_dow";
		  echo "</td>";
		   }
		 
		
		 
		 
		 
		 
		  //Region Approval has 2 possible outcomes 
/*		   
		   if($region_approved=='n')
			{		   
		   echo "<td bgcolor='lightpink'></td>";  
		   } 
		   
		   if($region_approved=='y')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$region_approver3<br />$region_approver_date2";
		 echo "<br />$region_approver_date_dow";
		  echo "</td>";
		   }
			  
           
		   //Section Approval has 2 possible outcomes 
		   
		   if($section_approved=='n')
			{		   
		   echo "<td bgcolor='lightpink'></td>";  
		   } 
		   
		   if($section_approved=='y')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$section_approver3<br />$section_approver_date2";
		 echo "<br />$section_approver_date_dow";
		  echo "</td>";
		   }
*/		   
		   
		   if($center_approved=='y')
		   {		   
		   echo "<td bgcolor='lightgreen'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&report=y' >VIEW</a></td>";
		   }
		   
		   if($center_approved=='n')
		   {		   
		   echo "<td bgcolor='lightpink'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&report=y' >VIEW</a></td>";
		   }
		   
		   
		   
echo "</tr>";




}

 echo "</table>";
}
//310 echo "<br />beacnum=$beacnum<br />";
// District Staff:  East Super/OA, South Super/OA, West Super/OA, North Super/OA (fullwood,quinn,greenwood,mitchener,mcelhone,bunn,woodruff,mitchener)
if($beacnum=='60032912' or $beacnum=='60032892' or $beacnum=='60033019' or $beacnum=='60033093' or $beacnum=='60032913' or $beacnum=='60032931' or $beacnum=='65030652')
{
	/*
if($beacnum=='60032912' or $beacnum=='60032892'){$where_and=" and district='east' "; $parkcode='core';}
if($beacnum=='60033019' or $beacnum=='60033093'){$where_and=" and district='south' "; $parkcode='pire';}
if($beacnum=='60032913' or $beacnum=='60032931'){$where_and=" and district='west' "; $parkcode='more';}
if($beacnum=='65030652'){$where_and=" and district='north' "; $parkcode='north';}
*/

// East Manager & East Cashier	
if($beacnum=='60032912'){$center_code='EADI'; $district='east'; $region_man='yes'; $district_office='EADI'; $where_and=" and district='east' ";}
if($beacnum=='60032892'){$center_code='EADI'; $district='east'; $region_aa='yes'; $district_office='EADI'; $where_and=" and district='east' ";}

//South Manager & South Cashier
if($beacnum=='60033019'){$center_code='SODI'; $district='south'; $region_man='yes'; $district_office='SODI'; $where_and=" and district='south' ";}
if($beacnum=='60033093'){$center_code='SODI'; $district='south'; $region_aa='yes'; $district_office='SODI'; $where_and=" and district='south' ";}

// West Manager & West Cashier
if($beacnum=='60032913'){$center_code='WEDI'; $district='west'; $region_man='yes'; $district_office='WEDI'; $where_and=" and district='west' ";}
if($beacnum=='60032931'){$center_code='WEDI'; $district='west'; $region_aa='yes'; $district_office='WEDI'; $where_and=" and district='west' ";}

//$beacnum==65030652 is the North District Superintendent  
// There is currently no beacon number for North District OA.
// Acting North District OA Val Mitchener is granted the same beacnum Session Variable (65030652) as North District Superintendent...
// ...when she logs in as Mitchener1111  (see budget.php)
// North Manager & North Cashier  
if($beacnum=='65030652' and $tempID != 'Mitchener1111'){$center_code='NODI'; $district='north'; $region_man='yes'; $district_office='NODI'; $where_and=" and district='north' ";}
if($beacnum=='65030652' and $tempID == 'Mitchener1111'){$center_code='NODI'; $district='north'; $region_aa='yes'; $district_office='NODI'; $where_and=" and district='north' ";}






//310 echo "Code for Regions and Chop";


$query11="SELECT report_date,region_approver,region_approver_date,region_approved
          from preapproval_report_dates_compliance where fiscal_year='$fyear'
		  $where_and
		  group by report_date
		  order by report_date desc ";
		  

//310 echo "<br />Line 436: query11=$query11<br />";
//exit;



 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";


echo "<br />";
//echo "<table align='center'><tr><th><font color='red'>Weekly Approvals ($parkcode)</font></th></tr></table>";
echo "<br />";
//echo "<br /><br />";
echo "<table align='center'>";

echo 

"<tr> 
       
       <th align=left><font color=brown>Report Date</font></th>       
       <th align=left><font color=brown>District<br />Approval</font></th>";
       	   
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
//$park_oob=$cashier_amount-$manager_amount;

$region_approver2=substr($region_approver,0,-2);
$region_approver_date=str_replace("-","",$region_approver_date);
$region_approver_date2=date('m-d-y', strtotime($region_approver_date));

if($region_approved == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}

echo 

"<tr$t>
		   	
		    <td bgcolor='lightgreen'>$report_date</td>";
		    	   
		      
		   //Manager Count has 3 possible outcomes 
		   if($region_approved=='n')//(manager_count == 1)
			{		   
		   //echo "<td bgcolor='lightpink'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code' >Manager<br />Update</a></td>";
		   if($region_man=='yes')
		   {
		   echo "<td bgcolor='lightpink'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&submit=Find'>Update</a></td>";
		   }
		   if($region_man!='yes')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   }
		   
		   
		   } 
		   
		   if($region_approved=='y')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$region_approver2<br />$region_approver_date2</td>";
		   }
		 
		  echo "<td><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&report=y' >VIEW</a></td>";
		  
		
			  
           
echo "</tr>";




}

 echo "</table>";

}


//CHOP and Budget Officer(as backup CHOP)
if($beacnum=='60033018' or $beacnum=='60032781')
{


$query11="SELECT report_date,section_approver,section_approver_date,section_approved
          from preapproval_report_dates_compliance where fiscal_year='$fyear'
		  group by report_date
		  order by report_date desc ";
		  





//echo "<br /><font color='brown'>Line 649: query11=$query11</font><br />";



 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";


echo "<br />";
//echo "<table align='center'><tr><th><font color='red'>Weekly Approvals ($parkcode)</font></th></tr></table>";
echo "<br />";
//echo "<br /><br />";
echo "<table align='center'>";

echo 

"<tr> 
       
       <th align=left><font color=brown>Report Date</font></th>       
       <th align=left><font color=brown>Section<br />Approval</font></th>";
       	   
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
//$park_oob=$cashier_amount-$manager_amount;

$section_approver2=substr($section_approver,0,-2);
$section_approver_date=str_replace("-","",$section_approver_date);
$section_approver_date2=date('m-d-y', strtotime($section_approver_date));

if($section_approved == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}

echo 

"<tr$t>
		   	
		    <td bgcolor='lightgreen'>$report_date</td>";
		    	   
		      
		   //Manager Count has 3 possible outcomes 
		   if($section_approved=='n')//(manager_count == 1)
			{		   
		   //echo "<td bgcolor='lightpink'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code' >Manager<br />Update</a></td>";
		   echo "<td bgcolor='lightpink'><a href='preapproval_weekly_section.php?report_date=$report_date&center_code=$center_code&form=y&submit=Find'>Update</a></td>";
		   } 
		   
		   if($section_approved=='y')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$section_approver2<br />$section_approver_date2</td>";
		   }
		 
		  echo "<td><a href='preapproval_weekly_section.php?report_date=$report_date&center_code=$center_code&report=y' >VIEW</a></td>";
		  
		
			  
           
echo "</tr>";




}

 echo "</table>";

}


?>