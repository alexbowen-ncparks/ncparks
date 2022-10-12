<?php
//ini_set('display_errors',1);
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

//echo "line 16 part2=$part2 <br />";
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

if($part2 == '')
{
echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker2\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker3\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker4\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";






echo "<font color='brown'>Please enter info below and click Update Button. Thanks!</font>";
echo "<br /><br />";

echo "<form action='stepB2a.php' method='post'>";
echo "<table>";
echo "<tr>";
echo "<td>Invoice#</td><td>Invoice Date</td><td>Admin Fee</td><td>Comments</td>";
echo "</tr>";
echo "<tr>";
echo "<td><input type='text' name='invoice_number'></td><td><input type='text' name='invoice_date' id='datepicker' size='15'></td>
      <td><input type='text' name='admin_fee'><td><input type='text' name='comments'></td>";
echo "</tr>";

echo "<tr><td><input type='submit' name='submit2' value='Update'></td></tr>";	   
echo "</table>";
echo "<input type='hidden' name='part2' value='y'>";
//echo "<input type='hidden' name='num7b' value='$num7b'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='step_group' value='$step_group'>";
echo "<input type='hidden' name='step_num' value='$step_num'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='start_date' value='$start_date'>";
echo "<input type='hidden' name='end_date' value='$end_date'>";
exit;
}

if($part2 == 'y')

{

//echo "line 70 part2=$part2 <br />";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

//exit;

//extract($_REQUEST);

$invoice_date2=str_replace("-","",$invoice_date);
/*
$calyear=substr($invoice_date2,0,4);
$calmonth=substr($invoice_date2,4,2);
if($calmonth == '01'){$calmonth_alpha='january';}
if($calmonth == '02'){$calmonth_alpha='february';}
if($calmonth == '03'){$calmonth_alpha='march';}
if($calmonth == '04'){$calmonth_alpha='april';}
if($calmonth == '05'){$calmonth_alpha='may';}
if($calmonth == '06'){$calmonth_alpha='june';}
if($calmonth == '07'){$calmonth_alpha='july';}
if($calmonth == '08'){$calmonth_alpha='august';}
if($calmonth == '09'){$calmonth_alpha='september';}
if($calmonth == '10'){$calmonth_alpha='october';}
if($calmonth == '11'){$calmonth_alpha='november';}
if($calmonth == '12'){$calmonth_alpha='december';}
//echo "calyear=$calyear<br />";
//echo "calmonth=$calmonth<br />";
//echo "calmonth_alpha=$calmonth_alpha<br />";
*/

$comments2=addslashes($comments); //comments
$invoice_number2=addslashes($invoice_number);  //90531086
$admin_fee2=$admin_fee;                        //59.90
$admin_fee2=str_replace(",","",$admin_fee2);   //59.90
$admin_fee2=str_replace("$","",$admin_fee2);   //59.90

$query4="update dot_gas_detail
         set invoice_number='$invoice_number2',
		     invoice_date='$invoice_date',
			 admin_fee='$admin_fee2',
			 comments='$comments2'
             where valid='n' ";

//echo "query4=$query4<br />";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


//exit;


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
		 
		 
//echo "query23a=$query23a<br />"; exit;		 
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

}


{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form ");}



 ?>




















