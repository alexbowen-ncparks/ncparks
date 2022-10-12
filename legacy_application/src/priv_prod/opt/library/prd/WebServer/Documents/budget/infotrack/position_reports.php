<?php

/*   *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../../include/activity.php")
include ("../../budget/menu1415_v1.php")
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];

$tempID2=substr($tempID,0,-2);
if($tempID2=='Kno'){$tempID2='Knott';}


extract($_REQUEST);


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
/*
if($beacnum=='60032793')
{
echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;


echo "<br />menu=$menu>";
echo "<br />access_update=$access_update>";
echo "<br />repid=$repid>";
//exit;
}
*/
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database); // database 

//include("../../../../include/activity.php");// database connection parameters

include("../../../include/activity.php");// database connection parameters
//echo "f_year=$f_year";

if($submit_report=='Add')
{
$query217="insert into position_report
           set report_name='$report_nameF',report_location='$report_linkF'
    ";
	
//echo "<br />query217=$query217<br />";	
$result217 = mysqli_query($connection, $query217) or die ("Couldn't execute query 217.  $query217");	


$query225="select max(report_id) as 'reportid_max'
           from position_report where 1";
		   
$result225 = mysqli_query($connection, $query225) or die ("Couldn't execute query 225.  $query225");		   

$row225=mysqli_fetch_array($result225);
extract($row225);

//echo "<br />reportid_max=$reportid_max<br />";


//echo "<br />Query Successful<br />";


$query239="insert into position_report_users
           set beacnum='$beacnum',tempid='$tempID',report_id='$reportid_max',downloaded='y'
    ";
	
//echo "<br />query239=$query239<br />";	


$result239 = mysqli_query($connection, $query239) or die ("Couldn't execute query 239.  $query239");	


//echo "<br />Query Successful<br />";



//exit;
$menu=1;
$access_update='y';
$repid=$reportid_max;

	
}



$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$tempID'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);	
extract($row11);

//echo "beacnum=$beacnum";
echo"
<html>
<head>
<title>MC Procedures</title>";
echo "</head>";
//include("../../budget/menu1314_procedures.php");
//include("../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");

if($submit_access=='Add')
{
$query181="insert ignore into position_report_users
           set beacnum='$beacnumF2',first_name='$first_nameF2',last_name='$last_nameF2',
		   report_id='$report_idF2',downloaded='$downloadedF2',tempid='$tempidF2' ";
	
//echo "<br />Line 185: query181=$query181<br />";	
$result181 = mysqli_query($connection, $query181) or die ("Couldn't execute query 181.  $query181");	
	
}

if($access_update=='y')
{
//echo "Access Update";
$query92="select report_id as 'repid',report_name
      from position_report
	  where report_id='$repid' ";

$result92 = mysqli_query($connection, $query92) or die ("Couldn't execute query 92.  $query92");

$row92=mysqli_fetch_array($result92);
extract($row92);//brings back max (fiscal_year) as $fiscal_year
echo "<br />";	  
echo "<table align='center'><tr>";
echo "<th>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img><br />MyReports</th>";
//echo "<img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th>";
echo "<th>Report# $repid ($report_name)</th>";
echo "</tr>";

echo "</table>";

$query110="select beacnum as 'beacnumF',first_name as 'first_nameF',last_name as 'last_nameF',
           report_id as 'report_idF',downloaded as 'downloadedF',tempid as 'tempidF',id as 'idF'
           from position_report_users
		   where report_id='$repid' order by idF asc ";
/*
if($beacnum=='60032793')
{
echo "<br />query110=$query110<br />"; //exit;
}
*/
$result110 = mysqli_query($connection, $query110) or die ("Couldn't execute query 110.  $query110");
echo "<br />";
echo "<table align='center'>";
echo "<tr>";
echo "<th>beacnum</th>";
echo "<th>first_name</th>";
echo "<th>last_name</th>";
echo "<th>report_id</th>";
echo "<th>downloaded</th>";
echo "<th>tempid</th>";







while ($row110=mysqli_fetch_array($result110)){
extract($row110);


if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t  align='left'>";


echo "<td>$beacnumF</td>";
echo "<td>$first_nameF</td>";
echo "<td>$last_nameF</td>";
echo "<td>$report_idF</td>";
echo "<td>$downloadedF</td>";
echo "<td>$tempidF</td>";






	   
echo "</tr>";
}

echo "<tr>";
//FORM to give Individuals access to a Position Report
echo "<form method='post' action='position_reports.php' autocomplete='off'>";
echo "<td><input type='text' name='beacnumF2' size='10'></td>";
echo "<td><input type='text' name='first_nameF2' size='10'></td>";
echo "<td><input type='text' name='last_nameF2' size='10'></td>";
echo "<td><input type='text' name='report_idF2' size='10'></td>";
echo "<td><input type='text' name='downloadedF2' size='10'></td>";
echo "<td><input type='text' name='tempidF2' size='10'></td>";
echo "<td><input type='submit' name='submit_access' value='Add' size='10'></td>";
echo "<input type='hidden' name='menu' value='1'>";
echo "<input type='hidden' name='access_update' value='y'>";
echo "<input type='hidden' name='repid' value='$repid'>";
echo "</form>";
echo "</tr>";




echo "</table>";
// exit;
	
	
	}
/*	
if($submit_access=='Add')
{
$query181="insert ignore into position_report_users
           set beacnum='$beacnumF2',first_name='$first_nameF2',last_name='$last_nameF2',
		   report_id='$report_idF2',downloaded='$downloadedF2',tempid='$tempidF2' ";
	
//echo "<br />Line 185: query181=$query181<br />";	
$result181 = mysqli_query($connection, $query181) or die ("Couldn't execute query 181.  $query181");	
	
}
*/

if($add_report=='y')
{
//echo "<br />create form</br />";	

echo "<br />";
echo "<table align='center'>";
echo "<tr>";
echo "<th>report_name</th>";
echo "<th>report_link</th>";
echo "</tr>";

echo "<tr>";
//FORM to ADD a New Position Report
echo "<form method='post' action='position_reports.php' autocomplete='off'>";
echo "<td><input type='text' name='report_nameF' size='30'></td>";
echo "<td><input type='text' name='report_linkF' size='60'></td>";
echo "<td><input type='submit' name='submit_report' value='Add' size='10'></td>";
echo "</form>";
echo "</tr>";

echo "</table>";	
//exit;	
}

/*
if($submit_report=='Add')
{
$query217="insert into position_report
           set report_name='$report_nameF',report_location='$report_linkF'
    ";
	
echo "<br />query217=$query217<br />";	
$result217 = mysqli_query($connection, $query217) or die ("Couldn't execute query 217.  $query217");	


$query225="select max(report_id) as 'reportid_max'
           from position_report where 1";
		   
$result225 = mysqli_query($connection, $query225) or die ("Couldn't execute query 225.  $query225");		   

$row225=mysqli_fetch_array($result225);
extract($row225);

echo "<br />reportid_max=$reportid_max<br />";


echo "<br />Query Successful<br />";


$query239="insert into position_report_users
           set beacnum='$beacnum',tempid='$tempID',report_id='$reportid_max',downloaded='y'
    ";
	
echo "<br />query239=$query239<br />";	


$result239 = mysqli_query($connection, $query239) or die ("Couldn't execute query 239.  $query239");	


echo "<br />Query Successful<br />";



exit;

	
}

*/












	
if($tempID=='Knott'){$beacnum="Knott";}
//echo "beacnum=$beacnum<br />";

$query3="select report_group from position_report_users2
         where beacnum='$beacnum' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);
$report_group=strtoupper($report_group);

if($report_group==''){$report_group=$pcode;}

echo "<br />";


$query32="insert ignore into position_report_users
          (beacnum,report_id)
		  select '$beacnum',report_id
		  from position_report
		  where download_available='y' ";
		  
		  
$result32 = mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");


$query33="SELECT count(position_report.report_id) as 'reports_downloadable'
FROM position_report
WHERE 1 and download_available='y' ";


$result33 = mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");

$row33=mysqli_fetch_array($result33);
extract($row33);//brings back max (end_date) as $end_date



$query34="SELECT count(position_report_users.report_id) as 'reports_downloaded'
FROM position_report_users
left join position_report on position_report_users.report_id=position_report.report_id
WHERE 1 and position_report.download_available='y'
and position_report_users.downloaded='y'
and beacnum='$beacnum' ";


$result34 = mysqli_query($connection, $query34) or die ("Couldn't execute query 34.  $query34");

$row34=mysqli_fetch_array($result34);
extract($row34);//brings back max (end_date) as $end_date



//if($beacnum=='60032793' or $beacnum=='60032984' or $beacnum=='60032934')
/*
{

echo "<br />";
echo "<table align='center'>
<tr><th><a href='/budget/infotrack/position_reports.php?DL=y'>Add to Favorites</th></tr>";
echo "</table>";
}
*/


//echo "<br />";
//brings back Division Reports available for Download
if($DL=='y')
{
/*
if($beacnum=='60032793' or $beacnum=='60032984' or $beacnum=='60032934')
{
*/



$query5="
SELECT sed, report_name, report_location, position_report.report_id,position_report.description FROM position_report LEFT JOIN position_report_users ON position_report.report_id = position_report_users.report_id WHERE 1 AND
(position_report.download_available = 'y' AND (beacnum = '$beacnum') and position_report_users.downloaded='n')
or
(position_report.download_available = 'n' AND (beacnum = '$beacnum') and position_report_users.downloaded='n' and position_report_users.override='y')

 ";

//echo "query5=$query5<br /><br />";
 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//if($beacnum=='60032793')
//{
//echo "query5=$query5";
//}
$num5=mysqli_num_rows($result5);
//echo "<br />";
echo "<table align='center' cellspacing='10'>";
/*
echo "<tr>";       
 echo "<th>Page Name</th>
       <th>ID</th><th></th> ";
 echo "</tr>";
 */
while ($row=mysqli_fetch_array($result5)){
extract($row);
$sed2=date('m-d-y', strtotime($sed));
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t  align='left'>";


echo "<td>#$report_id</td><td title='$description'>$report_name</td><td><a href='position_reports_add.php?report_id=$report_id&add=y'><img height='20' width='20' src='/budget/infotrack/icon_photos/download_icon.png' alt='download icon' title='Add to Favorites'></img></a></td>";






	   
echo "</tr>";
}
 echo "</table>";
//echo "<br />";
//}
;}

echo "<br />";

if($purchasing_guidelines=='y'){$pg_filter=" and t1.purchasing_guidelines='y' ";}

{

$query4="select t1.report_id,t1.report_name,t1.report_location,t1.status_ok,t1.new_tab,t1.description,t1.dpr from position_report as t1
         left join position_report_users as t2 on t1.report_id=t2.report_id
		 where (((t2.beacnum='$beacnum' and downloaded='y') or (t1.dpr='y')) and (active='y'))
		 $pg_filter
		 order by t1.report_name asc; ";
		 
//ccooper
//		 echo "query4=$query4<br /><br />";
}

	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "<br />";
//echo "<table><tr><td><font size='4' color='red'>$num4 Reports</font></td></tr></table>";
echo "<table align='center'><tr>";
echo "<th>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img><br />MyReports</th>";
//echo "<img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th>";
echo "<td><font color=brown class='cartRow'>$tempID2 Favorites</font>";

echo "</td><td><font size='4' color='red'>$num4 Reports</font></td>";

echo "</tr>";
/*
if($level==5)
{
echo "<tr><table border='1' align='center'><tr><th><a href='position_reports.php?menu=1&cat=daily'>Daily</a></th><th><a href='position_reports.php?menu=1&cat=weekly'>Weekly</a></th><th><a href='position_reports.php?menu=1&cat=monthly'>Monthly</a></th><th><a href='position_reports.php?menu=1&cat=yearly'>Yearly</a></th><th><a href='position_reports.php?menu=1&cat=other'>Other</a></th><th><a href='position_reports.php?menu=1&cat=archive'>Archive</a></th></tr></table></tr>";	
	
	
}
*/
echo "</table>";

echo "<br />";
echo "<table border='1' align='center'>";
echo "<tr><th>Report Name";

/* give user the ADD BUTTON on My Reports screen */

//accountant-bass  budget_officer-dodd  accounting clerk-rumble
if($beacnum=='60032793' or
   $beacnum=='60032781' or
   $beacnum=='60036015' or
   $beacnum=='65032850' or
   $beacnum=='65027689')
{
echo "<br /><a href='position_reports.php?add_report=y'>ADD Report</a>";	
}
echo "</th>";
echo "<th>ID</th></tr>";

while ($row4=mysqli_fetch_array($result4)){


extract($row4);

if($status_ok=="n"){$status_message="<font color='red'>(pending)</font>";} else {$status_message="";}

//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}


echo 

"<tr$t>";


/*
if($new_tab != 'y')
{
echo "<td><a href='$report_location' title='$description'>$report_name</a></td>";
//if($beacnum=='60032793')
{
echo "<td><font color='brown'>$report_id</font>beacnum=$beacnum</td>";
}
if($report_id==$report_ck_id)
{
echo "<td><img height='20' width='20' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='upload icon' title='Remove From Favorites'></img></a></td>"; 
}

}
else
*/	

{
/* list reports for My Reports*/
echo "<td>
        <a href='$report_location' title='$description' target='_blank'>$report_name</a>
      </td>";
//if($beacnum=='60032793')
{
//accountant-bass,budget officer-dodd, accounting clerk-rumble
if(($beacnum=='60032793' or 
    $beacnum=='60032781' or 
    $beacnum=='60036015' or 
    $beacnum=='65032850' or 
    $beacnum=='65027689') 
    and $dpr != 'y')
{
echo "<td>
        <font color='brown'>
        <a href='position_reports.php?menu=1&access_update=y&repid=$report_id'>$report_id</a>
        </font>
      </td>";
}
else
{
echo "<td>
        <font color='brown'>$report_id</font>
      </td>";
}	
}

if($report_id==$report_ck_id)
{
echo "<td>
        <img height='20' width='20' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='upload icon' title='Remove From Favorites'></img></a>
      </td>"; 
}


}

 
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 //echo "hello";
 echo "</html>";
 
 
 ?>