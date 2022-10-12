<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}


extract($_REQUEST);
session_start();
//echo "<pre>";print_r($_SERVER);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;

$tempID=$_SESSION['budget']['tempID'];
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//echo "<br />tempID=$tempID<br />";

//echo "<br />tempID=$tempID<br />";

if($tempID=='Lequire7043')
{
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
}






include("../../../include/auth.inc");

include("../../../include/activity.php");
/*
echo "<br />beacnum=$beacnum<br />";	
if($beacnum=='60032780' or $beacnum=='60032851')
{
echo "<br />form=$form<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
}
*/

if($submit=='AddComment')
{
//echo "<br />Line29: Add Disu Comment";	
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//comment_id
$query_disu_comment="update purchase_request_3 set disu_comments='$disu_comments' where id='$comment_id' ";
//echo "<br />query_disu_comment=$query_disu_comment<br />";
$result_disu_comment=mysqli_query($connection, $query_disu_comment) or die ("Couldn't execute query_disu_comment. $query_disu_comment");

}


if($submit2=='AddComment')
{
//echo "<br />Line29: Add Disu Comment";	
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//comment_id
$query_section_comment="update purchase_request_3 set section_comments='$section_comments' where id='$comment_id' ";
//echo "<br />query_disu_comment=$query_disu_comment<br />";
$result_section_comment=mysqli_query($connection, $query_section_comment) or die ("Couldn't execute query_section_comment. $query_section_comment");

}













if($center_app != '')
{
if($approved_all != 'y')
{	
if($center_app=='y'){$query_center_app="update purchase_request_3 set center_approved='y' where id='$Eid' ";}
if($center_app=='n'){$query_center_app="update purchase_request_3 set center_approved='n' where id='$Eid' ";}

$result_center_app=mysqli_query($connection, $query_center_app) or die ("Couldn't execute query_center_app. $query_center_app");

echo "<br />query_center_app=$query_center_app<br />";
}

if($approved_all == 'y')
{	
$query_center_app="update purchase_request_3 set center_approved='y' where center_code='$center_code' and report_date='$report_date' ";


$result_center_app=mysqli_query($connection, $query_center_app) or die ("Couldn't execute query_center_app. $query_center_app");

echo "<br />query_center_app=$query_center_app<br />";
}





}





if($disu_app != '')
{
if($park_code_drill=='')
{	
if($disu_app=='y'){$query_disu_app="update purchase_request_3 set district_approved='y' where id='$Eid' ";}
if($disu_app=='n'){$query_disu_app="update purchase_request_3 set district_approved='n' where id='$Eid' ";}

$result_disu_app=mysqli_query($connection, $query_disu_app) or die ("Couldn't execute query_disu_app. $query_disu_app");
}

if($park_code_drill!='')
{	
if($disu_app=='y'){$query_disu_app="update purchase_request_3 set center_approved='y',district_approved='y' where id='$Eid' ";}
if($disu_app=='n'){$query_disu_app="update purchase_request_3 set center_approved='n',district_approved='n' where id='$Eid' ";}

$result_disu_app=mysqli_query($connection, $query_disu_app) or die ("Couldn't execute query_disu_app. $query_disu_app");
}






//310 echo "<br />query_disu_app=$query_disu_app<br />";
}


if($section_app != '')
{	
if($section_app=='y'){$query_section_app="update purchase_request_3 set section_approved='y' where id='$Eid' ";}
if($section_app=='n'){$query_section_app="update purchase_request_3 set section_approved='n' where id='$Eid' ";}

$result_section_app=mysqli_query($connection, $query_section_app) or die ("Couldn't execute query_section_app. $query_section_app");

//310 echo "<br />query_section_app=$query_section_app<br />";
}



$query_compliance_approval="select center_approved as 'center_compliance_approval',region_approved as 'region_compliance_approval',section_approved as 'section_compliance_approval',record_complete from preapproval_report_dates_compliance where report_date='$report_date' and center_code='$center_code'";
          
//echo "query_compliance_approval=$query_compliance_approval";
	  
$result_query_compliance_approval = mysqli_query($connection, $query_compliance_approval) or die ("Couldn't execute query_compliance_approval.  $query_compliance_approval");
		  
$row_query_compliance_approval=mysqli_fetch_array($result_query_compliance_approval);

extract($row_query_compliance_approval);
//0617 echo "<br />report_date=$report_date<br />center_code=$center_code<br />center_compliance_approval=$center_compliance_approval<br />region_compliance_approval=$region_compliance_approval<br />section_compliance_approval=$section_compliance_approval<br />record_complete=$record_complete<br />";


$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

		//print_r($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$concession_location=$_SESSION['budget']['select'];
$level=$_SESSION['budget']['level'];
$beacnum=$_SESSION['budget']['beacon_num'];

echo "<html>";
echo "<head>";
echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete Purchase Pre-Approval Request?')
 return (bConfirm);
}


";
echo "</script>";
echo "</head>";
echo "<body>";
$menu_new='MAppr';
/*
echo "<br />beacnum=$beacnum<br />";
if($beacnum=='60032780' or $beacnum=='60032851')
{
echo "<br />Line 186: form=$form<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
}
*/
include ("../../budget/menu1415_v1.php");
/*
echo "<br />beacnum=$beacnum<br />";	
if($beacnum=='60032780' or $beacnum=='60032851')
{
echo "<br />Line 195: form=$form<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
}
*/
//include("1418.html");
//echo "<style>";
//echo "input[type='text'] {width: 200px;}";

//echo "</style>";


echo "<br />";
/*
if($beacnum=='60032780' or $beacnum=='60032851')
{
echo "<br />form=$form<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
}
*/
include("preapproval_weekly_menu1.php");


//echo "<br />beacnum=$beacnum<br />";

//FAMA mgr (reavis6725), WARE mgr (chandler1195), INED mgr (higgins6125), WEBS manager (gallagher9613), RALE manager (nealson7511)
if($beacnum=='60033012' or $beacnum=='60033009' or $beacnum=='60032780' or $beacnum=='60033162' or $beacnum=='60033165')
{
if($beacnum=='60033012'){$center_code='FAMA'; $concession_location='FAMA'; $stwd1='yes'; $level=1; $manager_count=1;}
if($beacnum=='60033009'){$center_code='WARE'; $stwd1='yes'; $level=1; }
if($beacnum=='60032780'){$center_code='INED'; $concession_location='INED'; $stwd1='yes'; $level=1; $manager_count=1;}
if($beacnum=='60033162'){$center_code='WEBS'; $concession_location='WEBS'; $stwd1='yes'; $level=1; $manager_count=1;}
if($beacnum=='60033165'){$center_code='RALE'; $concession_location='RALE'; $stwd1='yes'; $level=1; $manager_count=1;}

}
/*
if($beacnum=='60033165')
{
echo "<br />beacnum=$beacnum<br />";	
echo "<br />center_code=$center_code<br />";	
echo "<br />concession_location=$concession_location<br />";	
echo "<br />stwd1=$stwd1<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
	
}
*/
//echo "<br />Hello Line 123<br />";
//echo "<br />Line 235: manager_count=$manager_count<br />";
//echo "<tr><td colspan='4'><font color='red'><a href='pcard_recon_approval.php?report_id=$id'></a>Report Date: $report_date</font></td></tr>";
//echo "<tr><td colspan='4'><font color='brown'><b>$admin_num</b></font><br /><font color='red'>$report_date</font></td></tr>";
//60032912=East Super //60032892=East OA //60033019=South Super //60033093=South OA //60032913=West Super //60032931=West OA //65030652=North Super.  Currently, no Position# for North OA (TBASS-6/3/20)
if($beacnum=='60032912' or $beacnum=='60032892' or $beacnum=='60033019' or $beacnum=='60033093' or $beacnum=='60032913' or $beacnum=='60032931' or $beacnum=='65030652')
{
// East Manager & East Cashier	
if($beacnum=='60032912'){$center_code='EADI'; $district='east'; $region_man='yes'; $district_office='EADI';}
if($beacnum=='60032892'){$center_code='EADI'; $district='east'; $region_aa='yes'; $district_office='EADI';}

//South Manager & South Cashier
if($beacnum=='60033019'){$center_code='SODI'; $district='south'; $region_man='yes'; $district_office='SODI';}
if($beacnum=='60033093'){$center_code='SODI'; $district='south'; $region_aa='yes'; $district_office='SODI';}

// West Manager & West Cashier
if($beacnum=='60032913'){$center_code='WEDI'; $district='west'; $region_man='yes'; $district_office='WEDI';}
if($beacnum=='60032931'){$center_code='WEDI'; $district='west'; $region_aa='yes'; $district_office='WEDI';}

//$beacnum==65030652 is the North District Superintendent  
// There is currently no beacon number for North District OA.
// Acting North District OA Val Mitchener is granted the same beacnum Session Variable (65030652) as North District Superintendent...
// ...when she logs in as Mitchener1111  (see budget.php)
// North Manager & North Cashier  
if($beacnum=='65030652' and $tempID != 'Mitchener1111'){$center_code='NODI'; $district='north'; $region_man='yes'; $district_office='NODI';}
if($beacnum=='65030652' and $tempID == 'Mitchener1111'){$center_code='NODI'; $district='north'; $region_aa='yes'; $district_office='NODI';}





}

//echo "<br />level=$level<br />";
//echo "<br />manager_count=$manager_count<br />";
//echo "<br />region_man=$region_man<br />";
//echo "<br />section_chief=$section_chief<br />";
/*
if($beacnum=='60032780' or $beacnum=='60032851')
{
echo "<br />form=$form<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
}
*/
//CHOP and Budget Officer(as backup CHOP)
if($beacnum=='60033018' or $beacnum=='60032781'){$section='operations'; $section_chief='yes';}
echo "<br />";
	echo "<table cellpadding='5' align='center'>";
	echo "<tr>";
	if($park_code_drill=='')
	{
	echo "<td colspan='4'><font color='brown'><b>$center_code</b></font><br /><font color='red'>$report_date</font></td>";
	}
	else
	{
	echo "<td colspan='4'><font color='brown'><b>$park_code_drill</b></font><br /><font color='red'>$report_date</font></td>";
	}
	
	
	echo "</tr>";
	echo "</table>";

//310 echo "<br />Line 117: beacnum=$beacnum<br />section=$section<br />section_chief=$section_chief<br />";
if(($region_man=='yes' or $region_aa=='yes') and ($drill !='y')){include("preapproval_weekly_menu2.php");}
if(($section=='operations' and $section_chief=='yes') and ($drill !='y')){include("preapproval_weekly_menu3.php");}

if($level==1 or $stwd1=='yes')
{
if($beacnum != '60033012')
{	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and center_code='$center_code' ";
}
//Jody Reavis (Chief of Maintenance)
if($beacnum == '60033012')
{	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and (center_code='fama' or center_code='ware') "; 
}


		
}
// East Super and AA, South Super and AA, West Super and AA, North Super and AA
//echo "<br />Line 320: sql=$sql<br />";
if($beacnum=='60032912' or $beacnum=='60032892' or $beacnum=='60033019' or $beacnum=='60033093' or $beacnum=='60032913' or $beacnum=='60032931' or $beacnum=='65030652')
{
if($drill != 'y')
{	

//$where_and=" and district='$district' and center_approved='y' and district_approved!='n' and requested_amount >= '1000.00' ";
//$where_and=" and ((district='$district' and center_approved='y' and requested_amount >= '1000.01' and center_code != '$center_code') or (center_code='$center_code')) ";
$where_and=" and ((district='$district' and center_approved='y' and requested_amount >= '1000.01' and center_code != '$district_office') or (center_code='$district_office')) ";


$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' $where_and order by center_code ";
		
		
//echo "<br />Line 243: sql=$sql<br />";		
		
}

if($drill == 'y')
{	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and center_code='$park_code_drill' ";

//echo "<br />Line 252: sql=$sql<br />";
}


}
//echo "<br />Line 253: sql=$sql<br />";
//CHOP and Budget Officer(as backup CHOP)
if($beacnum=='60033018' or $beacnum=='60032781')
{
	
	
	
if($drill != 'y')
{	

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
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and (district='east' or district='north' or district='south' or district='west') order by center_code ";
}
else
{	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and (district='east' or district='north' or district='south' or district='west') and center_approved='y' and district_approved='y' and requested_amount >= '2500.01' order by center_code ";
}	
		
}



if($drill == 'y')
{	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and district='$park_code_drill' order by center_code ";
}


echo "<br />Line 384: sql=$sql<br />";

}
/*
if($beacnum=='60032780' or $beacnum=='60032851')
{
echo "<br />form=$form<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
}
*/


//310 echo "<br />level=$level<br />";
//310 echo "<br />region_man=$region_man<br />";


//echo "Line 300: $sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
//echo "<br />num=$num<br />";
echo "<br />";



if($num==0)
{
	
	echo "<br />";
	echo "<table align='center'>";
	echo "<tr><th><font color='red' class='cartRow'><b>No Purchases for Pre-Approval for this Report Week</b></font></th></tr>";
	echo "</table>";
	//exit;
 	
}
			
if($num!=0)
{	
echo "<br />";		
echo "<table align='center'><tr><th><font color='red' class='cartRow'><b>Requests <font color='red'>($num)</font></b></font></th></tr></table>";			
echo "<br />";
//echo "<table cellpadding='5' align='center'>";
//echo "<tr><td colspan='11'><font color='brown'><b>$center_code</b></font><br /><font color='red'>$report_date</font></td></tr>";
//echo "</table>";
echo "<br />";
echo "<table align='center'>";

echo "<tr>";
//extra blank column header for Users who have permission to DELETE Purchase request (trash can for delete shows in this column)
/*
if($level==1 and $report=='y' and $center_compliance_approval=='n'){echo "<th></th>";}
*/

echo "<th>pa_number</th>";

//60033012 (Jody Reavis-Chief of Maintenance)
if($level != 1 or $beacnum=='60033012')
{
echo "<th>center_code</th>";
}

echo "<th>Entered By</th>";

//echo "<th>purchase_type</th><th>ncas_account</th><th>requested<br />amount</th><th>purchase_description</th><th>justification</th>";
echo "<th>purchase_type</th><th>requested<br />amount</th><th>purchase_description</th><th>justification</th>";
//if($level != 1)
if($report=='y')
{
echo "<th>Manager<br />Approval</th>";
echo "<th>District<br />Approval</th>";
echo "<th>Section<br />Approval</th>";
echo "<th>FINAL<br />Approval</th>";
}
/*
if($report=='y' and $section_chief=='yes')
{
echo "<th>Section<br />Approval</th>";
}
*/
/*
if($beacnum=='60032780' or $beacnum=='60032851')
{
echo "<br />form=$form<br />";	
echo "<br />level=$level<br />";	
echo "<br />manager_count=$manager_count<br />";	
	
}
*/
//echo "<br />Line 484: manager_count=$manager_count<br />";
if($form=='y' and $level==1 and $manager_count==1)
{
echo "<th>Manager<br />Approval</th>";
}


if($form=='y' and $region_man=='yes')
{
if($park_code_drill=='')
{
echo "<th>DISU<br />Approval</th>";
}

if($park_code_drill!='')
{
echo "<th>Park Mgr<br />Approval</th>";
}



}

if($form=='y' and $section_chief=='yes')
{
echo "<th>DISU<br />Approval</th>";	
echo "<th>Section<br />Approval</th>";
}


echo "</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
//$parkcode=strtoupper($parkcode);
//$last_name=strtoupper($last_name);
//$first_name=strtoupper($first_name);
//$admin=strtoupper($admin);
//$monthly_limit=number_format($monthly_limit,2);

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo "<tr$t>";
// Trash Can for Users with permission to Delete Record
//if(($level==1) and ($cashier_count==1 or $manager_count==1) and ($region_compliance_approval=='n'))
	/*
if($level==1 and $report=='y' and $center_compliance_approval =='n')
{
echo "<td><a href=\"preapproval_request_delete_rec.php?center_del=y&id=$id&center_code=$center_code&report_date=$report_date\" onClick='return confirmLink()'><img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_218.png' alt='picture of trash can' title='Delete Record'></img></a></td>";
}
*/
/*
if(($level==2) and ($region_man=='yes'))
{


if($report=='y')
{
echo "<td></td>";
}



}
*/


echo "<td>$pa_number</td>";

//if($level != 1)
if($level != 1 or $beacnum=='60033012')
{
echo "<td>$center_code</td>";
}


echo "<td>$user_id</td>";
//echo "<td>$center_code</td>";
//echo "<td>$purchase_type</td><td>$ncas_account<br />$account_description</td><td>$requested_amount</td><td>$purchase_description</td><td>$justification</td>";
echo "<td>$purchase_type</td><td>$requested_amount</td><td>$purchase_description</td><td>$justification</td>";
if($report=='y')
{
	
	
if($center_approved=='y')
{
echo "<td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";	
}

if($center_approved=='n')
{
echo "<td><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></td>";	
}

if($center_approved=='u')
{
echo "<td></td>";	
}	
	

	
	
if($district_approved=='y')
{
echo "<td>";
echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
echo "</td>";	
}

if($district_approved=='n')
{
echo "<td><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></td>";	
}

if($district_approved=='u')
{
echo "<td></td>";	
}


if($section_approved=='y')
{
echo "<td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";	
}

if($section_approved=='n')
{
echo "<td><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></td>";	
}

if($section_approved=='u')
{
echo "<td></td>";	
}


if($division_approved=='y')
{
echo "<td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";	
}

if($division_approved=='n')
{
echo "<td><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></td>";	
}

if($division_approved=='u')
{
echo "<td></td>";	
}











//echo "<td>$section_approved</td>";	
	
}

if($form=='y')
{

//echo "<br />Line 652: manager_count=$manager_count<br />";
if($form=='y' and $level==1 and $manager_count==1)
{
if($center_approved=='u')
{
echo "<td><table><tr><td><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&center_app=y&submit=Find'>Y</a></td><td><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&center_app=n&submit=Find'>N</a></td></tr></table></td>";
}

if($center_approved=='y'){echo "<td><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&center_app=n&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a></td>";}
if($center_approved=='n'){echo "<td><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&center_app=y&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></a></td>";}




}

if($region_man=='yes')
{
	
if($district_approved=='y')
{
	
//if $park_code_drill=='' means the District Manager is using regular "District Manager" Form to Approve/Dis-Approve
//if $park_code_drill!='' means the District Manager has "drilled down as a Park Manager" and is acting as a "backup Park Manger" to Approve/Dis-Approve	
echo "<td>";
if($park_code_drill=='')
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=n&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a>";
}
else
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=n&park_code_drill=$park_code_drill&drill=$drill&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a>";	
}
if($region_man=='yes' and $id==$Eid)
{
//echo "<br />region_man=$region_man";
//echo "<br />id=$id";
//echo "<br />Eid=$";
echo "<br />";
echo "<form action='preapproval_weekly.php' method='post'>";
echo "<textarea id='disu_comments' name='disu_comments' placeholder='Comment Optional' rows='4' cols='50'>$disu_comments</textarea>";

//echo "<input type='hidden' name='fyear' value='$fyear'>";
//echo "<input type='hidden' name='center_code' value='$center_code'>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='form' value='y'>";
echo "<input type='hidden' name='formS' value='disu_comment'>";
echo "<input type='hidden' name='comment_id' value='$id'>";
echo "<input type='submit' name='submit' value='AddComment'>";
echo "</form>";
}
else
{
echo "<br />$disu_comments";	
	
	
}
echo "</td>";
}
if($district_approved=='n')
{
//if $park_code_drill=='' means the District Manager is using regular "District Manager" Form to Approve/Dis-Approve
//if $park_code_drill!='' means the District Manager has "drilled down as a Park Manager" and is acting as a "backup Park Manger" to Approve/Dis-Approve
echo "<td>";
if($park_code_drill=='')
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=y&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></a>";
}
else
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=y&park_code_drill=$park_code_drill&drill=$drill&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></a>";
}

// Opens up District Manager comments box for the last item approved/dis-approved by District Manager
if($region_man=='yes' and $id==$Eid)
{
//echo "<br />region_man=$region_man";
//echo "<br />id=$id";
//echo "<br />Eid=$";
echo "<br />";
echo "<form action='preapproval_weekly.php' method='post'>";
echo "<textarea id='disu_comments' name='disu_comments' placeholder='Comment Optional' rows='4' cols='50'>$disu_comments</textarea>";

//echo "<input type='hidden' name='fyear' value='$fyear'>";
//echo "<input type='hidden' name='center_code' value='$center_code'>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='form' value='y'>";
echo "<input type='hidden' name='formS' value='disu_comment'>";
echo "<input type='hidden' name='comment_id' value='$id'>";
echo "<input type='submit' name='submit' value='AddComment'>";
echo "</form>";
}
else
{
echo "<br />$disu_comments";	
	
	
}

echo "</td>";
}
if($district_approved=='u')
{
echo "<td>";
echo "<table>";
echo "<tr>";

//if $park_code_drill=='' means the District Manager is using regular "District Manager" Form to Approve/Dis-Approve
//if $park_code_drill!='' means the District Manager has "drilled down as a Park Manager" and is acting as a "backup Park Manger" to Approve/Dis-Approve

echo "<td>";
if($park_code_drill=='')
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=y&submit=Find'>Y</a>";
}
else
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=y&park_code_drill=$park_code_drill&drill=$drill&submit=Find'>Y</a>";	
}
echo "</td>";

//if $park_code_drill=='' means the District Manager is using regular "District Manager" Form to Approve/Dis-Approve
//if $park_code_drill!='' means the District Manager has "drilled down as a Park Manager" and is acting as a "backup Park Manger" to Approve/Dis-Approve
echo "<td>";
if($park_code_drill=='')
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=n&submit=Find'>N</a>";
}
else
{
echo "<a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&disu_app=n&park_code_drill=$park_code_drill&drill=$drill&submit=Find'>N</a>";
}	


echo "</td>";
echo "</tr>";
echo "</table>";
echo "</td>";
}
}

if($section_chief=='yes')
{
echo "<td>$district_approved</td>";
if($section_approved=='y')
{echo "<td>";
echo "<a href='preapproval_weekly.php?report_date=$report_date&form=y&Eid=$id&section_app=n&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a>";

if($id==$Eid)
{
//echo "<br />region_man=$region_man";
//echo "<br />id=$id";
//echo "<br />Eid=$";
echo "<br />";
echo "<form action='preapproval_weekly.php' method='post'>";
echo "<textarea id='section_comments' name='section_comments' placeholder='Comment Optional' rows='4' cols='50'>$section_comments</textarea>";

//echo "<input type='hidden' name='fyear' value='$fyear'>";
//echo "<input type='hidden' name='center_code' value='$center_code'>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='form' value='y'>";
echo "<input type='hidden' name='formS' value='section_comment'>";
echo "<input type='hidden' name='comment_id' value='$id'>";
echo "<input type='submit' name='submit2' value='AddComment'>";
echo "</form>";
}
else
{
echo "<br />$section_comments";	
	
	
}


echo "</td>";}

if($section_approved=='n')
{echo "<td>";
echo "<a href='preapproval_weekly.php?report_date=$report_date&form=y&Eid=$id&section_app=y&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></a>";

if($id==$Eid)
{
//echo "<br />region_man=$region_man";
//echo "<br />id=$id";
//echo "<br />Eid=$";
echo "<br />";
echo "<form action='preapproval_weekly.php' method='post'>";
echo "<textarea id='section_comments' name='section_comments' placeholder='Comment Optional' rows='4' cols='50'>$section_comments</textarea>";

//echo "<input type='hidden' name='fyear' value='$fyear'>";
//echo "<input type='hidden' name='center_code' value='$center_code'>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='form' value='y'>";
echo "<input type='hidden' name='formS' value='section_comment'>";
echo "<input type='hidden' name='comment_id' value='$id'>";
echo "<input type='submit' name='submit2' value='AddComment'>";
echo "</form>";
}
else
{
echo "<br />$section_comments";	
	
	
}



echo "</td>";}






if($section_approved=='u')
{
echo "<td><table><tr><td><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&section_app=y&park_code_drill=$park_code_drill&drill=$drill&submit=Find'>Y</a></td><td><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&section_app=n&submit=Find'>N</a></td></tr></table></td>";
}


}




}

echo "</tr>";

}
 echo "</table>"; 
 echo "<br />";
 
} 
 
// if($app=='no'){exit;}
// if($beacnum=='60032833'){$concession_location='dede' ;} //erin lawrence
// if($beacnum=='60033160'){$concession_location='nara' ;} //brian strong
if($form=='y')
{
$query1b="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//echo "query1b=$query1b";
	  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($cashier_nick){$cashier_first=$manager_nick;}	

//echo "<br />cashier_count=$cashier_count<br />";
//echo "<br />cashier_first=$cashier_first<br />";
//echo "<br />cashier_last=$cashier_last<br />";
/*
if($cashier_count==1)
{
echo "<form action='preapproval_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='center_code' value='$center_code'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='cashier' value='$tempID'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";
 
} 
*/ 
//if($app=='no'){exit;}
 if($beacnum=='60032833'){$concession_location='dede' ;} //erin lawrence
 if($beacnum=='60033160'){$concession_location='nara' ;} //brian strong
 
$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//echo "query1b=$query1b";
	  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	
 
 //if($beacnum=='60032786' and $admin_num='WAHO'){$manager_count=1;}
//echo "<br />Line 953: manager_count=$manager_count<br />";
if($manager_count==1 and $region_man != 'yes' and $section_chief != 'yes')
{
if($beacnum!='60033012')
{	
$query="select count(id) as 'center_pending_request'
          from purchase_request_3
		  where center_approved='u' and report_date='$report_date' and center_code='$center_code' ";	
}

//60033012 (Jody Reavis-Chief of Maintenance)
if($beacnum=='60033012')
{	
$query="select count(id) as 'center_pending_request'
          from purchase_request_3
		  where center_approved='u' and report_date='$report_date' and (center_code='fama' or center_code='ware') ";	
}
		  

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//echo "<br />Line 973: query=$query<br />";
	  
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);
//0617 echo "<br />Line 541: center_pending_request=$center_pending_request<br />";	
//if($tempID=='Fleming0643')
{echo "<table align='center'><tr><td><font class='cartRow'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y&approved_all=y&center_app=y'>Approve ALL</a></font></td></tr></table>";}
if($center_pending_request==0)
{	
if($app!='y')
{	

echo "<form action='preapproval_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='center_code' value='$center_code'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='manager' value='$tempID'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";
}
}
}

if($manager_count==1 and $region_man == 'yes')
{
if($app!='y')
{
if($park_code_drill=='')
{
// $center_unapproved_total is SET in Include File:  /budget/aDiv/preapproval_weekly_menu2.php	
if($center_unapproved_total==0 and $do_unreviewed_count==0)
{
	
$query="select count(id) as 'region_unapproved_total'
          from purchase_request_3
		  where district_approved='u' and ((district='$district' and center_approved='y' and requested_amount >= '1000.01' and center_code != '$district_office') or (center_code='$district_office'))  and report_date='$report_date'  ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//echo "<br />query=$query<br />";
	  
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);

//echo "<br />region_unapproved_total=$region_unapproved_total<br />";		
	
	
if($region_unapproved_total==0)
{	

echo "<form action='preapproval_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>District Manager: $manager_first $manager_last</th>";
echo "<td>Approved:<input type='checkbox' name='region_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='district' value='$district'>
<input type='hidden' name='district_office' value='$district_office'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='region_approver' value='$tempID'>
<input type='hidden' name='park_code_drill' value='$park_code_drill'>
<input type='hidden' name='drill' value='$drill'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";

}


}

}


if($park_code_drill!='')
{

$query="select count(id) as 'center_pending_request'
          from purchase_request_3
		  where center_approved='u' and report_date='$report_date' and center_code='$park_code_drill' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//0617 echo "<br />query=$query<br />";
	  
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);
//0617 echo "<br />Line 541: center_pending_request=$center_pending_request<br />";	
if($center_pending_request==0)
{	


echo "<form action='preapproval_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>District Manager: $manager_first $manager_last</th>";
echo "<td>Approved:<input type='checkbox' name='region_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='district' value='$district'>
<input type='hidden' name='district_office' value='$district_office'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='region_approver' value='$tempID'>
<input type='hidden' name='park_code_drill' value='$park_code_drill'>
<input type='hidden' name='drill' value='$drill'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";
}

}

}

}

if($manager_count==1 and $section_chief == 'yes')
{
if($app!='y')
{
// $center_unapproved_total is SET in Include File:  /budget/aDiv/preapproval_weekly_menu2.php	
echo "<br />section_unapproved_total(1st)=$region_unapproved_total<br />";


if(	$report_date=='2020-06-25'
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
$query="select count(id) as 'region_unapproved_total'
          from purchase_request_3
		  where section_approved='u' and (district='east' or district='north' or district='south' or district='west' or district='stwd') and report_date='$report_date'  ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
echo "<br />query=$query<br />";
	  
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);

echo "<br />section_unapproved_total(2nd)=$region_unapproved_total<br />";

 }	 
else
{
	
$query="select count(id) as 'region_unapproved_total'
          from purchase_request_3
		  where section_approved='u' and (district='east' or district='north' or district='south' or district='west' or district='stwd') and report_date='$report_date'  ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
echo "<br />query=$query<br />";
	  
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);

echo "<br />section_unapproved_total(2nd)=$region_unapproved_total<br />";	
	
	
	
	
}

if($region_unapproved_total==0)
{
		
	
	
echo "<form action='preapproval_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>Section Manager: $manager_first $manager_last</th>";
echo "<td>Approved:<input type='checkbox' name='section_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='section' value='$section'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='section_approver' value='$tempID'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";
}


/*
if($center_unapproved_total!=0)
{

echo "<table align='center'><tr><th><font color='red'>Park Managers at ALL Parks must approve all Pre-Approvals before Region Manager Approves</th></tr></table>";

}
*/

}

}


}
if($report=='y')	
{
	

	
	
$query1c="select cashier,cashier_date,manager,manager_date,region_approver,region_approver_date,center_approved,region_approved,section_approver,section_approver_date,section_approved,record_complete from preapproval_report_dates_compliance where report_date='$report_date' and center_code='$center_code'";
          
//0617 echo "query1c=$query1c";
	  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);

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


if($level==1)
{	
echo "<table align='center'>";
echo "<tr><th>Manager<br />Approval</th><th>District<br />Approval</th><th>Section<br />Approval</th></tr>";



echo "<tr>";
/*
// Cashier 
if($cashier==''){echo "<td bgcolor='lightpink'></td>";}
if($cashier!='')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$cashier3<br />$cashier_date2<br />$cashier_date_dow</td>";
}
*/
//Manager
if($center_approved=='n'){echo "<td bgcolor='lightpink'></td>";}
if($center_approved=='y')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
}

//Region Approver
if($region_approved=='n'){echo "<td bgcolor='lightpink'></td>";}
if($region_approved=='y')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$region_approver3<br />$region_approver_date2<br />$region_approver_date_dow</td>";
}

//Section Approver
if($section_approved=='n'){echo "<td bgcolor='lightpink'></td>";}
if($section_approved=='y')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$section_approver3<br />$section_approver_date2<br />$section_approver_date_dow</td>";
}






echo "</tr>";
echo "</table>";
}


if($region_man=='yes' or $region_aa=='yes')
{	
echo "<table align='center'>";
echo "<tr><th>Region<br />Approval</th><th>Section<br />Approval</th></tr>";



echo "<tr>";


//Region Approver
if($region_approved=='n'){echo "<td bgcolor='lightpink'></td>";}
if($region_approved=='y')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$region_approver3<br />$region_approver_date2<br />$region_approver_date_dow</td>";
}

//Section Approver
if($section_approved=='n'){echo "<td bgcolor='lightpink'></td>";}
if($section_approved=='y')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$section_approver3<br />$section_approver_date2<br />$section_approver_date_dow</td>";
}






echo "</tr>";
echo "</table>";
}

if($section_chief=='yes' or $section_aa=='yes')
{	
echo "<table align='center'>";
echo "<tr><th>Section<br />Approval</th></tr>";



echo "<tr>";

//Section Approver
if($section_approved=='n'){echo "<td bgcolor='lightpink'></td>";}
if($section_approved=='y')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$section_approver3<br />$section_approver_date2<br />$section_approver_date_dow</td>";
}

echo "</tr>";
echo "</table>";



}


}

echo "</body></html>";
?>