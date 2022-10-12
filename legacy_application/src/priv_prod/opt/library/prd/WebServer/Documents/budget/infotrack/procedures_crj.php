<?php
//echo "hello world";exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$beacnum2=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];
$position=$_SESSION['budget']['beacon_num'];
$comment='y';
$add_comment='y';
$folder='community';
$cash_plan='y';

if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($beacnum=='60032813' and $tempID=='Jones6793'){$pasu_role='y';}


/*echo "<br /> beacnum=$beacnum<br />";
echo "<br /> tempID=$tempid<br />";
echo "<br /> posTitle=$posTitle<br />";
echo "<br /> pasu_role=$pasu_role<br />"; */
//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "f_year=$f_year";
if($park==''){$park=$pcode;}

$query1="SELECT lead_superintendent as 'LS_role' from cash_handling_roles where park='$park' and tempid='$tempID' ";
		 
//echo "<br />query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

//echo "<br />LS_role=$LS_role<br />";

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
/*
$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";
*/

//10/15/14

$query11="SELECT filegroup,report_name
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);


echo"
<html>
<head>
<title>MC Procedures</title>";

//include("../../budget/menu1314_procedures.php");

//include("../../budget/menu1314.php");




include ("../../budget/menu1415_v2.php");







 
 
if($comment=='y') 

 {

if($park==''){$park=$infotrack_location;}


$query3="SELECT pid
         from procedures
         where park='$park'
		 and cash_plan='y'
         ";

//echo "query3=$query3<br />";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);



$query4a="select procedure_name,procedure_document,cash_plan,fiscal_year_chp,park from procedures where pid='$pid' ";

//echo $query4a;echo "<br />";		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);


$query4b="select * from procedures_comments where 1 and pid='$pid' $order2 ";

//echo "$query4b";		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
//echo "query4b=$query4b";//exit;



$row4a=mysqli_fetch_array($result4a);
extract($row4a);
$procedure_document=str_replace('  ','&nbsp;&nbsp;',$procedure_document);
$procedure_document=nl2br($procedure_document);
//10/15/14

//echo "cash_plan=$cash_plan<br />";

echo "<br />";
if($level==1 or $beacnum=='60036015'){include("../../budget/admin/crj_updates/park_deposits_report_menu_v3.php");}



echo "<br />";



echo "<table border='1'>";
echo "<tr>";
echo "<td><font color=brown class='cartRow'>$procedure_name FY:$fiscal_year_chp ($park)</font></td>";
if($level=='5')
{
echo "
<td><font color=brown class='cartRow'>(pid $pid)</font></td>
<td><a href='procedures_crj.php?comment=y&add_comment=y&folder=community&pid=$pid&editP=y'>Edit</a></font></td>";
/*
if($pid=='12'){
echo "pid=$pid";
include("/budget/infotrack/bright_idea_steps2_v2.php?cid=295");
//{echo "hello pid 12";}
}
*/
}
if($cash_plan=='y')
{
//doc_id1=daily sales report
//doc_location1 is the document location for daily sales report


$query_chp_docs="select chp_id,document_location as 'doc_location1',id as 'chpd1_id' from cash_handling_plan_docs where chp_id='$pid' and doc_id='1' ";

//echo $query4a;echo "<br />";		 
$result_chp_docs = mysqli_query($connection, $query_chp_docs) or die ("Couldn't execute query query_chp_docs.  $query_chp_docs");
//$num4a=mysqli_num_rows($result4a);
$row_chp_docs=mysqli_fetch_array($result_chp_docs);
extract($row_chp_docs);

//doc_id2=Sales Locations
//doc_location2 is the document location for sales locations

$query_chp_docs2="select chp_id,document_location as 'doc_location2',id as 'chpd2_id' from cash_handling_plan_docs where chp_id='$pid' and doc_id='2' ";

//echo $query4a;echo "<br />";		 
$result_chp_docs2 = mysqli_query($connection, $query_chp_docs2) or die ("Couldn't execute query query_chp_docs2.  $query_chp_docs2");
//$num4a=mysqli_num_rows($result4a);
$row_chp_docs2=mysqli_fetch_array($result_chp_docs2);
extract($row_chp_docs2);


//Graphic for Sales Locations
if($doc_location1==''){$doc_location1_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img>";}
if($doc_location1 != ''){$doc_location1_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

//Graphic for Daily Sales Reports
if($doc_location2==''){$doc_location2_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img>";}
if($doc_location2!=''){$doc_location2_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}




//echo "doc_location1=$doc_location1<br />doc_location2=$doc_location2<br />";
//echo "doc_location1_graphic=$doc_location1_graphic<br />doc_location2_graphic=$doc_location2_graphic<br />";


echo "<td align='center'>";
echo "<font color='brown'>Sales Locations $doc_location2_graphic<br /> (ALL)<br />";
echo "<table border='1' cellpadding='10'><tr><td></font><a href='$doc_location2' target='_blank'>Download</a></td><td><a href='chp_document_add.php?chp_id=$chp_id&chpd_id=$chpd2_id' target='_blank'>Upload</a></td></tr></table>";
echo "</td>";

echo "<td align='center'>";
echo "<font color='brown'>Daily Sales Reports $doc_location1_graphic<br />(Non-CRS Locations)<br /><table border='1' cellpadding='10'><tr><td></font><a href='$doc_location1' target='_blank'>Download</a></td><td><a href='chp_document_add.php?chp_id=$chp_id&chpd_id=$chpd1_id' target='_blank'>Upload</a>";
echo "</td>";






echo "</tr></table></td>";
echo "<td>";
include ("cashiers.php");
echo "</td>";
echo "<td>";
include ("managers.php");
echo "</td>";

}
echo "</tr>";
echo "</table>";




echo "<table align='center'>";
echo "<tr>";
echo "<th>";
include ("imprest_cash.php");
echo "</th>";
echo "</table>";

if($editP=='')
{




echo "<table>";
echo "<tr>";
echo "<td>$procedure_document</td>";

echo "</tr>";

echo "</table>";
}

if($editP=='y')
{

$query4c="select procedure_name,procedure_document from procedures where pid='$pid' ";

//echo $query4a;echo "<br />";		 
$result4c = mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");
$num4c=mysqli_num_rows($result4c);
$row4c=mysqli_fetch_array($result4c);
extract($row4c);





echo "<form method='post' action='procedures_edit.php'>";
//echo "<td><input type='text' name= 'alert_location' placeholder='kela,jord,etc'></input></td>";  
echo "<td><textarea name= 'procedure_document' rows='100' cols='120' >$procedure_document</textarea></td>";            
      
	  echo "<td><input type='submit' name='submit' value='Update_Procedure'></td>";
	  
     echo "<input type='hidden' name='pid' value='$pid'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";
}




echo "</html>";
 }
 ?>
 