<?php

session_start();


if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

include("../../../budget/menus2.php");

include ("widget1.php");
include("report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
if($report_date==""){exit;}


$query50="update fixed_assets_unreconciled,center
          set fixed_assets_unreconciled.fa_reconciler=center.fa_reconciler
		  where fixed_assets_unreconciled.center=center.center";
		  
$result50 = mysqli_query($connection, $query50) or die ("Couldn't execute query 50.  $query50");		  


$query5="SELECT *
FROM fixed_assets_unreconciled
where report_date='$report_date'; ";

//echo "query5=$query5";


$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



//echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
//echo "</table>";
//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";

echo "<br />";
if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}

echo "<table><tr><td><font color='red'>Records: $num5</font></td></tr></table>";
echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>LVL1</font></th>
       <th align=left><font color=brown>LVL2</font></th>
       <th align=left><font color=brown>Temp AN</font></th>
       <th align=left><font color=brown>Reconciler</font></th>
       <th align=left><font color=brown>Perm AN</font></th>
       <th align=left><font color=brown>Comments</font></th>
       <th align=left><font color=brown>Asset Descript</font></th>
       <th align=left><font color=brown>Budget Code</font></th>";
       //echo "<th align=left><font color=brown>Buy Entity</font></th>";
       echo "<th align=left><font color=brown>Center</font></th>";
	   echo "<th align=left><font color=brown>Center Name</font></th>";
       //echo "<th align=left><font color=brown>Pay Entity</font></th>":
       echo "<th align=left><font color=brown>PO Number</font></th>
       <th align=left><font color=brown>Invoice</font></th>
       <th align=left><font color=brown>Check Num</font></th>
       <th align=left><font color=brown>Account</font></th>
       <th align=left><font color=brown>Std Description</font></th>
       <th align=left><font color=brown>Control Date</font></th>
       <th align=left><font color=brown>Vendor Num</font></th>
       <th align=left><font color=brown>Control Group</font></th>
       <th align=left><font color=brown>Acq Date</font></th>
       <th align=left><font color=brown>Cost</font></th>
       <th align=left><font color=brown>Vendor Name</font></th>
       <th align=left><font color=brown>Document</font></th>";
       //echo "<th align=left><font color=brown>Report Date</font></th>";       
       //echo "<th align=left><font color=brown>Center Mgr</font></th>";
       echo "<th align=left><font color=brown>ID</font></th>";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";
echo  "<form method='post' autocomplete='off' action='report_view_update.php'>";
//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
if($document_location != ""){$document="yes";} else {$document="";}
$cost=number_format($cost,2);


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
     echo "<td>$lvl1</td>
           <td>$lvl2</td>		   
           <td>$temp_an</td>		   
           <td>$fa_reconciler</td>		   
           <td><input type='text' size='10' name='perm_an[]' value='$perm_an'</td>	   
           <td><textarea name='comments[]' cols='15' rows='3'>$comments</textarea></td>  
           <td>$asset_descript</td>		   
           <td>$budget_code</td>";		   
           //echo "<td>$buy_entity</td>";		   
           echo"<td>$center</td>";	
		   echo "<td>$center_name</td>";	
           //echo "<td>$pay_entity</td>";		   
           echo "<td>$po_number</td>		   
           <td>$invoice</td>		   
           <td>$check_num</td>		   
           <td>$account</td>		   
           <td>$std_descript</td>		   
           <td>$control_date</td>		   
           <td>$vendor_num</td>		   
           <td>$control_group</td>		   
           <td>$acq_date</td>		   
           <td>$cost</td>		   
           <td>$vendor_name</td>";	
if($document=="yes"){
echo "<td><a href='$document_location' target='_blank'>View</a><br /><br /><a href='fixed_assets_document_add.php?source_id=$id&report_date=$report_date'=>Reload</a></td>";}

if($document!="yes"){
echo "<td><a href='fixed_assets_document_add.php?source_id=$id&report_date=$report_date'>Upload</a></td>";} 

		   
           //echo "<td>$report_date</td>";           	   
           //echo "<td>$center_mgr</td>";		   
           echo "<td><input type='text' size='5' name='id[]' value='$id' readonly='readonly'</td>";
             
echo "</tr>";

}
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='num5' value='$num5'>";
echo   "</form>";
 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>



















	














