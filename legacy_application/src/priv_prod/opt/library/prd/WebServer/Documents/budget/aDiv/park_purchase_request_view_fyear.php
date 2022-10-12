<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
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
echo "<body>";
//$menu_new='MAppr';
include ("../../budget/menu1415_v1.php");

//include("1418.html");
//echo "<style>";
//echo "input[type='text'] {width: 200px;}";

//echo "</style>";


echo "<br />";

include("preapproval_yearly_menu1.php");

//exit;
//echo "<br />Hello Line 123<br />";

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


//CHOP and Budget Officer(as backup CHOP)
if($beacnum=='60033018' or $beacnum=='60032781'){$section='operations'; $section_chief='yes';}


echo "<br />";
if($region_man=='yes' or $region_aa=='yes'){$center_code=ucfirst($district).' District';}
if($section_chief=='yes'){$center_code=ucfirst($section).' Section';}



	echo "<table cellpadding='5' align='center'>";
	echo "<tr><td colspan='4'><font color='brown'><b>$center_code</b></font><br /><font color='red'>Fiscal Year: $fyear</font></td></tr>";
	echo "</table>";

//310 echo "<br />Line 117: beacnum=$beacnum<br />section=$section<br />section_chief=$section_chief<br />";
if(($region_man=='yes' or $region_aa=='yes') and ($drill !='y')){include("preapproval_weekly_menu2.php");}
if(($section=='operations' and $section_chief=='yes') and ($drill !='y')){include("preapproval_weekly_menu3.php");}

if($level==1)
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and center_code='$center_code' order by report_date desc ";
		
}
// East Super and AA, South Super and AA, West Super and AA, North Super and AA
//echo "<br />Hello Line 230<br />";


if($beacnum=='60032912' or $beacnum=='60032892' or $beacnum=='60033019' or $beacnum=='60033093' or $beacnum=='60032913' or $beacnum=='60032931' or $beacnum=='65030652')
{


$where_and=" and f_year='$fyear' and district='$district'";


$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where 1 $where_and order by report_date desc, center_code asc ";
		
		
//echo "<br />Line 148: sql=$sql<br />";		
		

}




if($beacnum=='60033018' or $beacnum=='60032781')
{	

$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and section='$section' order by report_date desc, center_code asc ";

}





if($beacnum=='60033009') 
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and (center_code='ware' or center_code='fama') order by report_date desc, center_code asc ";


}


if($beacnum=='60032780') 
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and center_code='ined' order by report_date desc, center_code asc ";

}

//Ranger Activities/Law Enforcement (RALE) // keith nealson, chris fox, mike deturo
if($beacnum=='60033165' or $beacnum=='60033146' or $beacnum=='60032881') 
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and center_code='rale' order by report_date desc, center_code asc ";

}









if($beacnum=='60032877' or $beacnum=='60092637' or $beacnum=='60032875'  or $beacnum=='60032907' or $beacnum=='60033135' )
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and (center_code='ined' or purchaser='iema') order by report_date desc, center_code asc ";

}


if($beacnum=='60033012') 
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and center_code='fama' order by report_date desc, center_code asc ";

}


if($beacnum=='60033162') 
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' and center_code='webs' order by report_date desc, center_code asc ";

}



if($beacnum=='60032956' or $beacnum=='60032977' or $beacnum=='60032957' or $beacnum=='60032958')
{	
if($beacnum=='60032956'){$where=" and (center_code='fama' or center_code='sodi') ";} 
if($beacnum=='60032977'){$where=" and (center_code='fama' or center_code='nodi') ";} 
if($beacnum=='60032957'){$where=" and (center_code='fama' or center_code='eadi') ";} 
if($beacnum=='60032958'){$where=" and (center_code='fama' or center_code='wedi') ";} 
{
$sql = "SELECT report_date,pa_number,user_id,center_code,purchase_type,ncas_account,account_description,requested_amount,purchase_description,justification,center_approved,district_approved,section_approved,division_approved,division_app_type,disu_comments,section_comments,id
        from purchase_request_3 where f_year='$fyear' $where order by report_date desc, center_code asc ";

}
}


//echo "Line 216: $sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
//echo "<br />num=$num<br />";
echo "<br />";



if($num==0)
{
	
	echo "<br />";
	echo "<table align='center'>";
	echo "<tr><th><font color='red' class='cartRow'><b>No Purchases to Pre-Approve for this Report Week</b></font></th></tr>";
	echo "</table>";
	//exit;
 	
}
			
if($num!=0)
{	
echo "<br />";		
echo "<table align='center'><tr><th><font color='red' class='cartRow'><b>Yearly Requests: <font color='red'>$num</font></b></font></th></tr></table>";			
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

echo "<th>report<br />date</th>";
echo "<th>pa_number</th>";

if($level != 1)
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


echo "<td>$report_date</td>";
echo "<td>$pa_number</td>";

if($level != 1)
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



echo "</tr>";

}
 echo "</table>"; 
 echo "<br />";
 
} 
 
// if($app=='no'){exit;}
// if($beacnum=='60032833'){$concession_location='dede' ;} //erin lawrence
// if($beacnum=='60033160'){$concession_location='nara' ;} //brian strong



echo "</body></html>";
?>