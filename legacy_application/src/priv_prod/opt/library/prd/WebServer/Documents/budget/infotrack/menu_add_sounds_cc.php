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

echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='sounds_cc_update.php'>";
//echo "<form method='post' autocomplete='off' action='menu_add_records2_update.php'>";
echo "<table border=1 align='center'>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   //echo "<th><font color='brown'>Park</font></th>";
	   //echo "<th><font color='brown'>Center</font></th>";
	   echo "<th><font color='brown'>Audio Type</font></th>";
	   echo "<th><font color='brown'>Source Name</font></th>";	  
	   echo "<th><font color='brown'>Source Link</font></th>";
	   echo "<th><font color='brown'>Author Name</font></th>";
	   echo "<th><font color='brown'>Author Link</font></th>";
	   echo "<th><font color='brown'>License</font></th>";
	   
	   
	   
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
	   echo "<td><input name='audio_type' type='text' size='5' id='audio_type'></td>"; 
	   echo "<td><input name='source_name' type='text' size='30' id='source_name'></td>"; 
	   echo "<td><input name='source_link' type='text' size='30' id='source_link'></td>"; 
	   echo "<td><input name='author_name' type='text' size='30' id='author_name'></td>"; 
	   echo "<td><input name='author_link' type='text' size='30' id='author_link'></td>"; 
	   echo "<td><input name='license' type='text' size='30' id='license'></td>"; 
	  
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



















	














