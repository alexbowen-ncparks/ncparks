<?php

session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

/*
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];


extract($_REQUEST);

//echo "level=$level<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

//include("../../../budget/~f_year.php");
*/
$table="menu_add_records1";



$query5a="SELECT  DISTINCT concat( parkcode, '-', center_desc ) AS 'parkcode'
FROM crj_centers
where 1 
ORDER BY parkcode";


//echo "query5a=$query5a<br />";


$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");
while ($row5a=mysqli_fetch_array($result5a))
	{
	$tnArray[]=$row5a['parkcode'];
	}
//source for datepicker: http://jqueryui.com/datepicker/
/*
echo "<html lang=\"en\">
<head>
<meta charset=\"utf-8\" />
<title>jQuery UI Datepicker - Default functionality</title>
*/
/*
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

*/

//echo "</head>";


//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";
if($level>3)
{

//echo "<form  method='post' autocomplete='off' action='bank_deposits_add_record.php'>";

echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='videos_update.php'>";
//echo "<form method='post' autocomplete='off' action='menu_add_records2_update.php'>";
echo "<table border=1 align='center'>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   //echo "<th><font color='brown'>Park</font></th>";
	   //echo "<th><font color='brown'>Center</font></th>";
	   echo "<th><font color='brown'>Label</font></th>";
	   echo "<th><font color='brown'>Comments</font></th>";
	   //echo "<th><font color='brown'>Deposit Amount</font></th>";
	   //echo "<th><font color='brown'>Bank Deposit Date</font></th>";
	   //echo "<th><font color='brown'>Collection Start Date</font></th>";
	   //echo "<th><font color='brown'>Collection End Date</font></th>";
	   //echo "<th><font color='brown'>BO Receipt Date</font></th>";
	   echo "<th><font color='brown'>Image</font></th>";
	   
	   
	   
	   echo "</tr>";
   
	   echo "<tr bgcolor='$table_bg2'>";
	   //echo "<td><input name='park' type='text' size='15' id='park'></td>"; 
	   /*
	   echo "<td><select name=\"park\"><option></option>"; 
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];

		echo "<option>$tnArray[$n]\n";
       }
   echo "</select></td>"; 
   */
	   //echo "<td><input name='center' type='text' size='15' id='center'></td>"; 
	   echo "<td><input name='label' type='text' size='30' id='label'></td>"; 
	   echo "<td><textarea name= 'comments2' rows='6' cols='60' placeholder='Type Comment here' id='comments2' ></textarea></td>"; 
	  // echo "<td><input name='deposit_amount' type='text' size='15' id='deposit_amount'></td>"; 
	   //echo "<td><input name='bank_deposit_date' type='text' id='datepicker' size='15'></td>"; 
	   //echo "<td><input name='collection_start_date' type='text' id='datepicker2' size='15'></td>"; 
	   //echo "<td><input name='collection_end_date' type='text' id='datepicker3' size='15'></td>"; 
	   //echo "<td><input name='bo_receipt_date' type='text' id='datepicker4' size='15'></td>"; 
	    echo "<td><input type='file' id='document' name='document'>
                 <input type='hidden' name='user_name' value='$myusername' />
                 <input type='hidden' name='f_year' value='$f_year' />
                 <input type='hidden' name='content_mode' value='$content_mode' />
                 <input type='hidden' name='MAX_FILE_SIZE' value='20000000'></td>";   
	   
	   
	  // echo "<td><input type=submit name=record_insert submit value=add></td>";
	   echo "<td><input type=submit name=submit value=add></td>";
	   
	   echo "</tr>";

	  echo "</table>";
	  

echo "</form>";	  
echo "<br />";
	  

}



//echo "</html>";

?>



















	














