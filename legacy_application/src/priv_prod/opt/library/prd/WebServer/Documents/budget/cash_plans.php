<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


extract($_REQUEST);

/*
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
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
*/
//echo "beacnum=$beacnum";
echo"
<html>
<head>
<title>Cash Handling Plans</title>";
echo "</head>";
//include("../../budget/menu1314_procedures.php");
include("../../../budget/menu1314.php");
//if($tempID=='Knott'){$beacnum="Knott";}
//echo "beacnum=$beacnum<br />";


echo "<br />";


//echo "beacnum=$beacnum<br />";
//echo "add=$add<br />";

if($level==2 and $concession_location=='WEDI')
{
//$query4="select park,pid from procedures where cash_plan='y' and district='west'
        // order by park ";
		
$query4="select procedures.park,docname,document_location,pid
 from procedures
 left join cash_handling_plan_docs on procedures.pid=cash_handling_plan_docs.chp_id
 where cash_plan='y'
 and district='west'
         order by park asc,docname asc";		
		
		
		
}		

if($level==2 and $concession_location=='EADI')
{
$query4="select park,pid from procedures where cash_plan='y' and district='east'
         order by park ";
}	

if($level==2 and $concession_location=='NODI')
{
$query4="select park,pid from procedures where cash_plan='y' and district='north'
         order by park ";
}	

if($level==2 and $concession_location=='SODI')
{
$query4="select park,pid from procedures where cash_plan='y' and district='south'
         order by park ";
}	

if($level>4)
{
$query4="select procedures.park,pid
 from procedures
 left join cash_handling_plan_docs on procedures.pid=cash_handling_plan_docs.chp_id
 where cash_plan='y'
         order by park ";
}		 
		 
		 
		 
		 
		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "<br />";
//echo "<table><tr><td><font size='4' color='red'>$num4 Reports</font></td></tr></table>";

while ($row=mysqli_fetch_assoc($result4))
	{
	$ARRAY[$row['docname']][$row['park']]=$row['document_location'];
	//$header_array[$row['park']]="";
	$header_array[$row['park']]=$row['pid'];
	}

echo "<table border='1'><tr>";
echo "<th><img height='50' width='50' src='/budget/infotrack/icon_photos/money_safe_copper1.png  ' alt='picture of safe'></img></th>";
foreach($header_array AS $index=>$header)
	{
$header2="/budget/infotrack/procedures.php?comment=y&add_comment=y&folder=community&pid=$header";	
	echo "<th>$index<br /><a href='$header2'>CHP</a></th>";
	}
	//echo "<th>Total</th>";
echo "</tr>";
foreach($ARRAY AS $index=>$array)
	{
	echo "<tr><th>$index</th>";
	foreach($array as $fld=>$value)
		{
		$i++;
		//$j++;
		$var_tot+=$value;
		
		//$location[$i]="tony";
$value2="/budget/infotrack/".$value;
if($value!='')
{		
echo "<td><a href='$value2'>View</a></td>";
}

if($value=='')
{		
echo "<td>NONE</td>";
}

}		
echo "</tr>";

	}	
	
	
echo "</table>";	



	

	
echo "</table>";




 
 ?>
 