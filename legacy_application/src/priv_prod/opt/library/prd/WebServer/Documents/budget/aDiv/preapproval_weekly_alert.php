<?php

//if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
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


$menu_new='MAppr';
//310 echo "<br />Line 34: posTitle=$posTitle<br />";
extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//310 echo "<pre>";print_r($_SESSION);"</pre>";//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//include ("../../budget/menu1415_v1.php");
echo "<br />";
/*
include("preapproval_weekly_menu1.php");
echo "<br />";
include("../../budget/infotrack/slide_toggle_procedures_module2_pid92.php");
//include("preapproval_yearly_fyear.php");
include("preapproval_yearly_fyear_v2.php");
*/

if($beacnum=='60033012'){$concession_location='fama'; $parkcode='fama'; $park='fama'; $stwd1='yes';}
if($beacnum=='60033009'){$concession_location='ware'; $parkcode='ware'; $park='ware'; $stwd1='yes';}
if($beacnum=='60032780'){$concession_location='ined'; $parkcode='ined'; $park='ined'; $stwd1='yes';}
if($beacnum=='60033162'){$concession_location='webs'; $parkcode='webs'; $park='webs'; $stwd1='yes';}




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
and fiscal_year>='2021' and center_approved='n'
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



//echo "<br />";

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";

}
//echo "<br />";
//echo "<table align='center'><tr><th><font color='red'>Weekly Approvals ($parkcode)</font></th></tr></table>";
//echo "<br />";
//echo "<br /><br />";
if($num11==0)
{
echo "<table align='center'><tr><th>Weekly Purchase Pre-Approvals</th><th><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></th></tr></table>";

}

if($num11!=0)
{
echo "<table align='center'>";

echo "<tr>"; 
/*
       
       echo "<th align=left><font color=brown>Report<br />Date</font></th>";        
	   echo "<th align=left><font color=brown>Manager<br />Approval</font></th>";
*/
	   
echo "<th colspan='2'><font color=brown>Weekly Purchase Pre-Approvals</font></th>";  	   
              
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
//echo "<td bgcolor='lightgreen'>$record_count</td>";
					   
		      
		   //Manager Approval has 3 possible outcomes 
		   if($manager=='' and $pasu_role == 'y')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='aDiv/preapproval_weekly.php?report_date=$report_date&center_code=$center_code&form=y' >Update</a></td>";
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
		 
		/*	
		   
		   if($center_approved=='y')
		   {		   
		   echo "<td bgcolor='lightgreen'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&report=y' >VIEW</a></td>";
		   }
		   
		   if($center_approved=='n')
		   {		   
		   echo "<td bgcolor='lightpink'><a href='preapproval_weekly.php?report_date=$report_date&center_code=$center_code&report=y' >VIEW</a></td>";
		   }
		   
		  */ 
		   
echo "</tr>";




}

 echo "</table>";
}



//310 echo "<br />beacnum=$beacnum<br />";
// District Staff:  East Super/OA, South Super/OA, West Super/OA, North Super/OA (fullwood,quinn,greenwood,mitchener,mcelhone,bunn,woodruff,mitchener)
/*
if($beacnum=='60032912' or $beacnum=='60032892' or $beacnum=='60033019' or $beacnum=='60033093' or $beacnum=='60032913' or $beacnum=='60032931' or $beacnum=='65030652')
{
	
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

*/



?>