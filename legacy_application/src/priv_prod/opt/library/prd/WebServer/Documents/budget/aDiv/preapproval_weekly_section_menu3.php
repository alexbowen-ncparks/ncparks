<?php

if($drill!='y')
{
//echo "<table align='center'><tr><th>Section Manager Report</th></tr></table>";
$where_and=" and (district='east' or district='north' or district='south' or district='west' or district='stwd') ";


$sql = "SELECT district,region_approved,region_approver as 'region_approver'
        from preapproval_report_dates_compliance where report_date='$report_date' $where_and group by district order by district ";
		
//echo "preapproval_weekly_section_menu3.php LINE 10:<br />sql=$sql<br />";	

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$region_unapproved_total=0;
echo "<table align='center'>";
echo "<tr>";	
while($row=mysqli_fetch_array($result)){
extract($row);
if($region_approved == 'n'){$region_unapproved_total++;}
if($region_approved == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
$region_approver2=substr($region_approver,0,-2);
if($region_approved=='y')
{
echo "<td$t><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><a href='preapproval_weekly_section.php?report_date=$report_date&district_code_drill=$district&drill=y&report=y'>$district</a><br />$region_approver2<br /></td>";
}

if($region_approved!='y')
{

//echo "<td$t>$district</td>";
echo "<td$t><br /><a href='preapproval_weekly_section.php?report_date=$report_date&district_code_drill=$district&drill=y&form=y'>$district</a><br />$region_approver2<br /></td>";
}

}
echo "</tr>";
echo "</table>";


//allows chop and budget officer( as backup chop) to see all requests for April 2020 thru June 2020 prior to "rolling out" new procedures in July 2020....
//.... Allows Chop to "approve all requests" for April thru June  1) regardless of dollar amount and 2) regardless of District Approval 
//....Starting in July 2020, CHOP will ONLY see Pre-Approval Requests >= 2500.01  AND  District Approved=y
if(
($beacnum=='60033018' or $beacnum=='60032781')
	and 
($report_date=='2020-06-25'
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
 ) 
{$region_unapproved_total=0;}
//$region_unapproved_total=0;
//echo "<br />beacnum=$beacnum<br />"; 
//echo "<br />report_date=$report_date<br />"; 
//echo "<br />region_unapproved_total=$region_unapproved_total<br />"; 



//exit;

if($region_unapproved_total!=0)
{

echo "<table align='center'><tr><th><font color='red'>District Managers must approve before Section Manager Approves</th></tr></table>"; exit;

}

}

if($drill=='y')
{
$district=$district_code_drill;

if($district=='east'){$district_office='EADI';}
if($district=='north'){$district_office='NODI';}
if($district=='south'){$district_office='SODI';}
if($district=='west'){$district_office='WEDI';}


$where_and=" and district='$district' ";


$sql = "SELECT center_code,center_approved,manager as 'center_manager'
        from preapproval_report_dates_compliance where report_date='$report_date' $where_and group by center_code order by center_code ";
		
//echo "preapproval_weekly_menu2.php LINE 10:<br />sql=$sql<br />";	

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$center_unapproved_total=0;
echo "<table align='center'>";
echo "<tr>";	
while($row=mysqli_fetch_array($result)){
extract($row);
if($center_approved == 'n'){$center_unapproved_total++;}
if($center_approved == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
$center_manager2=substr($center_manager,0,-2);
if($center_approved=='y')
{
echo "<td$t><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><a href='preapproval_weekly_section.php?report_date=$report_date&park_code_drill=$center_code&drill=y&report=y'>$center_code</a><br />$center_manager2<br /></td>";
}

if($center_approved!='y')
{
if($center_code=='EADI' or $center_code=='NODI' or $center_code=='SODI' or $center_code=='WEDI'){echo "<td$t><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><a href='preapproval_weekly_section.php?report_date=$report_date&park_code_drill=$center_code&drill=y&form=y'>$center_code</a><br />$center_manager2<br /></td>";}
else
//{echo "<td$t>$center_code</td>";}
{echo "<td$t><br /><a href='preapproval_weekly_section.php?report_date=$report_date&park_code_drill=$center_code&drill=y&report=y'>$center_code</a><br />$center_manager2<br /></td>";}
}

}
echo "</tr>";
echo "</table>";


$do_unreviewed="select count(id) as 'do_unreviewed_count' from purchase_request_3 where report_date='$report_date' and center_code='$district_office' and district_approved='u' ";

$result_do_unreviewed=mysqli_query($connection, $do_unreviewed) or die ("Couldn't execute query do_unreviewed. $do_unreviewed");

$row_do_unreviewed=mysqli_fetch_array($result_do_unreviewed);

extract($row_do_unreviewed);
//echo "<br />do_unreviewed=$do_unreviewed<br />";
//echo "<br />do_unreviewed_count=$do_unreviewed_count<br />"; 

//exit;





//310 echo "<br />preapproval_weekly_menu2.php LINE 25: center_unapproved_total=$center_unapproved_total<br />";
if($center_unapproved_total!=0)
{
echo "<br />";
echo "<table align='center'><tr><th><font color='red'>Park Managers at ALL Parks must approve before District Manager Approves</th></tr></table>"; exit;

}	
	
	
}



?>