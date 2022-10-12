<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}


extract($_REQUEST);
session_start();
//echo "<pre>";print_r($_SERVER);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$tempID=$_SESSION['budget']['tempID'];
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database



include("../../../include/auth.inc");

include("../../../include/activity.php");



if($submit2=='AddComment')
{
//echo "<br />Line29: Add Disu Comment";	
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//comment_id
$query_section_comment="update purchase_request_3 set section_comments='$section_comments' where id='$comment_id' ";
//echo "<br />query_disu_comment=$query_disu_comment<br />";
$result_section_comment=mysqli_query($connection, $query_section_comment) or die ("Couldn't execute query_section_comment. $query_section_comment");

}



if($section_app != '')
{
if($district_code_drill=='')
{

	
if($section_app=='y'){$query_section_app="update purchase_request_3 set section_approved='y' where id='$Eid' ";}
if($section_app=='n'){$query_section_app="update purchase_request_3 set section_approved='n' where id='$Eid' ";}

$result_section_app=mysqli_query($connection, $query_section_app) or die ("Couldn't execute query_section_app. $query_section_app");
}


if($district_code_drill!='')
{

	
if($section_app=='y'){$query_section_app="update purchase_request_3 set district_approved='y',section_approved='y' where id='$Eid' ";}
if($section_app=='n'){$query_section_app="update purchase_request_3 set district_approved='n',section_approved='n' where id='$Eid' ";}

$result_section_app=mysqli_query($connection, $query_section_app) or die ("Couldn't execute query_section_app. $query_section_app");
}



//310 echo "<br />query_section_app=$query_section_app<br />";


}


/*
$query_compliance_approval="select center_approved as 'center_compliance_approval',region_approved as 'region_compliance_approval',section_approved as 'section_compliance_approval',record_complete from preapproval_report_dates_compliance where report_date='$report_date' and center_code='$center_code'";
          
$result_query_compliance_approval = mysqli_query($connection, $query_compliance_approval) or die ("Couldn't execute query_compliance_approval.  $query_compliance_approval");
		  
$row_query_compliance_approval=mysqli_fetch_array($result_query_compliance_approval);

extract($row_query_compliance_approval);
*/


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

include ("../../budget/menu1415_v1.php");


echo "<br />";

include("preapproval_weekly_menu1.php");


//CHOP and Budget Officer(as backup CHOP)

//echo "<br />district_code_drill=$district_code_drill<br />";
//echo "<br />park_code_drill=$park_code_drill<br />";



if($beacnum=='60033018' or $beacnum=='60032781'){$section='operations'; $section_chief='yes';}
echo "<br />";
echo "<table cellpadding='5' align='center'>";
echo "<tr>";
if($drill!='y')
{
if($district_code_drill=='' and $park_code_drill==''){echo "<td colspan='4'><font color='brown'><b>$section</b></font><br /><font color='red'>$report_date</font></td>";}
}
if($drill=='y')
{
if($district_code_drill!=''){echo "<td colspan='4'><font color='brown'><b>$district_code_drill</b></font><br /><font color='red'>$report_date</font></td>";}
if($park_code_drill!=''){echo "<td colspan='4'><font color='brown'><b>$park_code_drill</b></font><br /><font color='red'>$report_date</font></td>";}
}

	
	echo "</tr>";
	echo "</table>";

//310 echo "<br />Line 117: beacnum=$beacnum<br />section=$section<br />section_chief=$section_chief<br />";
//if(($region_man=='yes' or $region_aa=='yes') and ($drill !='y')){include("preapproval_weekly_menu2.php");}
//if(($section=='operations' and $section_chief=='yes') and ($drill !='y')){include("preapproval_weekly_section_menu3.php");}
if($section=='operations' and $section_chief=='yes'){include("preapproval_weekly_section_menu3.php");}


//echo "<br />Line 253: sql=$sql<br />";
//CHOP and Budget Officer(as backup CHOP)
if($beacnum=='60033018' or $beacnum=='60032781')
{
	
//echo "<br />Hello LINE 177<br />";	
	
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
//4/15/21
/*	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and (district='east' or district='north' or district='south' or district='west') and center_approved='y' and district_approved='y' and requested_amount >= '2500.01' order by center_code ";
*/		

$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and (district='east' or district='north' or district='south' or district='west' or district='stwd') and district_approved='y' and requested_amount >= '2500.01' order by center_code ";



		
//echo "<br />Line 206: sql=$sql<br />";
}	
		
}



if($drill == 'y')
{
if($district_code_drill != '')
{	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and district='$district_code_drill' and requested_amount >= '1000.01' order by center_code ";
}


if($park_code_drill != '')
{	
$sql = "SELECT pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where report_date='$report_date' and center_code='$park_code_drill'  order by center_code ";
}










}


//echo "<br />Line 384: sql=$sql<br />";

}

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

echo "<br />";
echo "<table align='center'>";

echo "<tr>";

echo "<th>pa_number</th>";

//if($level != 1)
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

if($form=='y')
{
//echo "<th>DISU<br />Approval</th>";	
if($drill!='y')
{
echo "<th>Section<br />Approval</th>";
}

if($drill=='y')
{
echo "<th>District<br />Approval</th>";
}



}


echo "</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo "<tr$t>";

echo "<td>$pa_number</td>";

//if($level != 1)
{
echo "<td>$center_code</td>";
}

echo "<td>$user_id</td>";

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

	
}

if($form=='y')
{


//if($section_chief=='yes')
{
//echo "<td>$district_approved</td>";

//echo "<br />section_approved=$section_approved<br />";
if($section_approved=='y')
{echo "<td>";
echo "<a href='preapproval_weekly_section.php?report_date=$report_date&form=y&Eid=$id&section_app=n&drill=$drill&district_code_drill=$district_code_drill&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a>";

if($id==$Eid)
{
echo "<br />";
echo "<form action='preapproval_weekly_section.php' method='post'>";
echo "<textarea id='section_comments' name='section_comments' placeholder='Comment Optional' rows='4' cols='50'>$section_comments</textarea>";
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
echo "<a href='preapproval_weekly_section.php?report_date=$report_date&form=y&Eid=$id&section_app=y&drill=$drill&district_code_drill=$district_code_drill&submit=Find'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img></a>";

if($id==$Eid)
{
echo "<br />";
echo "<form action='preapproval_weekly_section.php' method='post'>";
echo "<textarea id='section_comments' name='section_comments' placeholder='Comment Optional' rows='4' cols='50'>$section_comments</textarea>";
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
echo "<td><table><tr><td><a href='preapproval_weekly_section.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&section_app=y&drill=$drill&district_code_drill=$district_code_drill&submit=Find'>Y</a></td><td><a href='preapproval_weekly_section.php?report_date=$report_date&center_code=$center_code&form=y&Eid=$id&section_app=n&drill=$drill&district_code_drill=$district_code_drill&submit=Find'>N</a></td></tr></table></td>";
}

}
}
echo "</tr>";
}
 echo "</table>"; 
 echo "<br />"; 
} 
 
if($form=='y')
{
 
$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	

//echo "Line 434: query1b=$query1b";
  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	

if($manager_count==1 and $section_chief == 'yes')
{
//if($app!='y')
//{
if($district_code_drill=='')
{	

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
$query="select count(id) as 'section_unapproved_total'
          from purchase_request_3
		  where section_approved='u' and (district='east' or district='north' or district='south' or district='west' or district='stwd') and report_date='$report_date'  ";	 

	  
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);

 }	 
else
{
	
$query="select count(id) as 'section_unapproved_total'
          from purchase_request_3
		  where section_approved='u' and (district='east' or district='north' or district='south' or district='west' or district='stwd') and district_approved='y' and report_date='$report_date' and requested_amount >= '2500.01'  ";	 

$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);
//echo "<br />Line 536: query=$query<br />";
//echo "<br />Line 537: section_unapproved_total(2nd)=$section_unapproved_total<br />";	
	
	
}

if($section_unapproved_total==0)
{
	
echo "<form action='preapproval_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>Section Manager: $manager_first $manager_last</th>";
echo "<td>Approved:<input type='checkbox' name='section_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='district_code_drill' value='$district_code_drill'>
<input type='hidden' name='section' value='$section'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='section_approver' value='$tempID'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";
}

//}
}
if($district_code_drill!='')
{	
$query="select count(id) as 'district_unapproved_total'
          from purchase_request_3
		  where district_approved='u' and district='$district_code_drill' and report_date='$report_date' and requested_amount >= '1000.01'  ";	 

$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
		  
$row=mysqli_fetch_array($result);

extract($row);

if($district_unapproved_total==0)
{
	
echo "<form action='preapproval_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>Section Manager: $manager_first $manager_last</th>";
echo "<td>Approved:<input type='checkbox' name='section_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='district_code_drill' value='$district_code_drill'>
<input type='hidden' name='section' value='$section'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='section_approver' value='$tempID'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";
}

}




}


}
if($report=='y')	
{
	
//$query1c="select cashier,cashier_date,manager,manager_date,region_approver,region_approver_date,center_approved,region_approved,section_approver,section_approver_date,section_approved,record_complete from preapproval_report_dates_compliance where report_date='$report_date' and center_code='$center_code'";


if($drill=='y' and $district_code_drill != '')
{
	
}

         
//echo "query1c=$query1c";



//exit;

//echo "<br />section_chief=$section_chief<br />";

if($section_chief=='yes')
{	
echo "<table align='center'>";




echo "<tr>";
if($drill != 'y')
{
	
	
$query1c="select section_approver,section_approver_date,section_approved from preapproval_report_dates_compliance where report_date='$report_date' ";

echo "<br />Line 587: query1c=$query1c<br />";
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);







$section_approver3=substr($section_approver,0,-2);
$section_approver_date=str_replace("-","",$section_approver_date);

if($section_approver_date=='0000-00-00'){$section_approver_date_dow='';}
else
{$section_approver_date_dow=date('l',strtotime($section_approver_date));}

$section_approver_date2=date('m-d-y', strtotime($section_approver_date));

//echo "<br />section_approved=$section_approved<br />";	
	
echo "<tr>";
echo "<th>Section<br />Approval</th>";
echo "</tr>";	
	

//Section Approver
if($section_approved=='n'){echo "<td bgcolor='lightpink'></td>";}
if($section_approved=='y')
{
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$section_approver3<br />$section_approver_date2<br />$section_approver_date_dow</td>";
}
}

if($drill=='y' and $district_code_drill != '')
{
$query1c="select region_approver,region_approver_date,region_approved,section_approver,section_approver_date,section_approved from preapproval_report_dates_compliance where report_date='$report_date' and district='$district_code_drill' ";	

//echo "<br />Line 627: query1c=$query1c<br />";

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);	
	
$region_approver3=substr($region_approver,0,-2);
$region_approver_date=str_replace("-","",$region_approver_date);

if($region_approver_date=='0000-00-00'){$region_approver_date_dow='';}
else
{$region_approver_date_dow=date('l',strtotime($region_approver_date));}

$region_approver_date2=date('m-d-y', strtotime($region_approver_date));
//echo "<br />region_approved=$region_approved<br />";

	
	
$section_approver3=substr($section_approver,0,-2);
$section_approver_date=str_replace("-","",$section_approver_date);

if($section_approver_date=='0000-00-00'){$section_approver_date_dow='';}
else
{$section_approver_date_dow=date('l',strtotime($section_approver_date));}

$section_approver_date2=date('m-d-y', strtotime($section_approver_date));

//echo "<br />section_approved=$section_approved<br />";	
echo "<tr>";
echo "<th>District<br />Approval</th>";
echo "<th>Section<br />Approval</th>";
echo "</tr>";	
	
	
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
	
}






echo "</tr>";
echo "</table>";



}


}

echo "</body></html>";
?>