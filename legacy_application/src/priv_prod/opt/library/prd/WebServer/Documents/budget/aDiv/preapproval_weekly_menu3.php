<?php
echo "<br />";
//echo "<table align='center'><tr><th>Section Manager Report</th></tr></table>";
$where_and=" and (district='east' or district='north' or district='south' or district='west' or district='stwd') ";


$sql = "SELECT district,region_approved,region_approver as 'region_approver'
        from preapproval_report_dates_compliance where report_date='$report_date' $where_and group by district order by district ";
		
//0617 echo "preapproval_weekly_menu3.php LINE 10:<br />sql=$sql<br />";	

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
echo "<td$t><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><a href='preapproval_weekly.php?report_date=$report_date&park_code_drill=$district&drill=y&report=y'>$district</a><br />$region_approver2<br /></td>";
}

if($region_approved!='y')
{

//echo "<td$t>$district</td>";
echo "<td$t><br /><a href='preapproval_weekly.php?report_date=$report_date&park_code_drill=$district&drill=y&form=y'>$district</a><br />$region_approver2<br /></td>";
}

}
echo "</tr>";
echo "</table>";

//echo "<br />preapproval_weekly_menu2.php LINE 25: center_unapproved_total=$center_unapproved_total<br />";
//allows chop and budget officer( as backup chop) to see all requests for June 2020 prior to "rolling out" new procedures in July 2020 (per chop request)
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
?>