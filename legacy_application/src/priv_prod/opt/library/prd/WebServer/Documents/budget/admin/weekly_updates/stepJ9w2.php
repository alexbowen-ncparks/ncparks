<?php

echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters



$project_category='fms';
$project_name='weekly_updates';
$step_group='J';
$step_num='9w2';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);





/*
echo "<html>";
echo "<head>";
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>";
	


echo "</head>";
*/
if($submit=='ADD')
{
	
	
$system_entry_date=date("Ymd");	
	
	
//echo "Line 31: query to update COA";
$query1="update center
         set center='$centerF',
		     new_center='$centerF',
		     center_desc='$center_descF',
			 budcode='$budcodeF',
			 new_budcode='$budcodeF',
			 company='$companyF',
			 new_company='$companyF',
			 parkcode='$parkcodeF',
			 dist='$distF',
			 stateparkyn='$stateparkynF',
			 f_year_funded='$f_year_fundedF',
			 cyinitfund='$cyinitfundF',
			 type='$typeF',
			 center_verified='y',
             center_verified_by='$tempid',
             center_verified_date='$system_entry_date'	
             where ceid='$ceidF'			 ";


//echo "<br />query1=$query1<br />";  exit;

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

/*
$query2="update exp_rev_dncr_temp_part2_dpr
         set valid_account_dpr='y'
		 where account='$ncasnumF' ";
		 
//echo "<br />query2=$query2<br />";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

*/



}
//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

//echo "<br /><br />";

//5/1/20
/*
$query3="select account,account_description 
         from exp_rev_dncr_temp_part2_dpr
		 where valid_account='' and valid_account_dpr='n'
         order by account limit 1 ";
		 
*/

//5/1/20

/*
$query3="select account,account_description 
         from exp_rev_dncr_temp_part2_dpr
		 where valid_account_dpr='n'
         order by account limit 1 ";
		 
*/


$query3="select center,center_desc,budcode,company,parkcode,dist,stateparkyn,f_year_funded,cyinitfund,type,ceid
         from center where center_verified='n'
         order by center limit 1 ";





		 

echo "<br />Query3=$query3<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$row3=mysqli_fetch_array($result3);
//$missing_accounts=$row3;
$missing_centers=$num3;
extract($row3);//brings back max (end_date) as $end_date
$center_first4=substr($center,0,4);

echo "<br />Line88: missing centers=$missing_centers<br />"; //exit;

if($missing_centers != 0)
{
$query4="select center,center_desc,budcode,company,parkcode,dist,stateparkyn,f_year_funded,cyinitfund,type,ceid
         from center where center like '$center_first4%' and center_verified='y'  ";

//echo "<br />Query4=$query4<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//////mysql_close();


echo "<html>";
echo "<head>";
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>";
	


echo "</head>";

echo "<table align='center'>";
echo "<tr><th><font color='red'>XTND Download includes Centers which are are not located in MoneyCounts. Please ADD Center Below. Thanks</font></th></tr>";
echo "</table>";
echo "<br />";
echo "<table border=1>";
 
echo "<tr>"; 
echo "<th>Center</th>";      
//echo "<th>Account Description per XTND</th>";      
echo "<th>Center Description<br >per MoneyCounts</th>";      
echo "<th>Budget Code</th>";      
echo "<th>Company</th>";      
echo "<th>ParkCode</th>";      
echo "<th>District</th>";      
echo "<th>StatePark</th>";      
echo "<th>Fiscal<br />Year<br />Funded</th>";      
echo "<th>First<br />Calendar<br />Year</th>";      
echo "<th>Type</th>";      
     
echo "</tr>";
echo "<form>";
echo "<tr>";

//echo "<td>$account</td>";
//echo "<td>$account_description</td>";
echo "<td><input type='text' name='centerF' size='10' value='$center' readonly='readonly'></td>";
//echo "<td><input type='text' name='descriptionF' size='45' value='$account_description' readonly='readonly'></td>";

//echo "<form>";
echo "<td><input type='text' name='center_descF' value='$center_desc' size='45'></td>";
echo "<td><input type='text' name='budcodeF' size='10' value='$budcode'></td>";
echo "<td><input type='text' name='companyF' size='8' value='$company'></td>";
echo "<td><input type='text' name='parkcodeF' size='8' value='$parkcode'></td>";
echo "<td><input type='text' name='distF' size='8' value='$dist'></td>";
echo "<td><input type='text' name='stateparkynF' size='8' value='$stateparkyn'></td>";
echo "<td><input type='text' name='f_year_fundedF' size='8' value='$f_year_funded'></td>";
echo "<td><input type='text' name='cyinitfundF' size='8' value='$cyinitfund'></td>";
echo "<td><input type='text' name='typeF' size='8' value='$type'></td>";
echo "<td><input type='submit' name='submit' value='ADD' ></td>";
echo "</tr>";
echo "<input type='hidden' name='ceidF' value='$ceid'>";
echo "</form>";



while ($row4=mysqli_fetch_array($result4)){


extract($row4);

if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	

$query4="select center,center_desc,budcode,company,parkcode,dist,stateparkyn,f_year_funded,cyinitfund,type,ceid";

echo "<tr$t>";	
echo "<td>$center</td>";      
//echo "<td>$description</td>";      
echo "<td>$center_desc</td>";      
echo "<td>$budcode</td>";      
echo "<td>$company</td>";      
echo "<td>$parkcode</td>";      
echo "<td>$dist</td>";      
echo "<td>$stateparkyn</td>";      
echo "<td>$f_year_funded</td>";      
echo "<td>$cyinitfund</td>";      
echo "<td>$type</td>";      

  
echo "</tr>";



}


echo "</table>";



echo "</body></html>";
}

if($missing_centers == 0)
{
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

}



?>