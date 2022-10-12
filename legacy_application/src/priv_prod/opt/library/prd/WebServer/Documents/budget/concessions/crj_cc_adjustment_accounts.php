<?php



session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "postitle=$posTitle";exit;


extract($_REQUEST);
//if($step != '1'){echo "<pre>";print_r($_REQUEST);"</pre>";}//exit;
//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");






$query11="SELECT `new_center` as 'center',`parkcode`,`crj_cc_account2adjust`,`park_acct_desc`
FROM `center`
left join coa on center.crj_cc_account2adjust=coa.ncasnum2
WHERE 1 and fund='1280' and stateparkyn='y' and actcenteryn='y'
order by parkcode ";	


/*
$query11="SELECT depositid_cc,sum(amount) as 'amount',f_year
            from crs_tdrr_cc_all
			WHERE 1 
			group by depositid_cc
			order by id desc ";
	
*/


	
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

echo "<br />Query11=$query11<br />";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";

echo "<table align='center' cellpadding='10' border=1>";

echo "<tr>";

echo "<th align=left><font color=brown>center</font></th>";
echo "<th align=left><font color=brown>parkcode</font></th>";
echo "<th align=left><font color=brown>crj_cc_account2adjust</font></th>";
echo "<th align=left><font color=brown>account description</font></th>";

echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
if($crj_cc_account2adjust=='434410003'){echo "<tr>";}		
if($crj_cc_account2adjust!='434410003'){echo "<tr bgcolor='yellow'>";}		
echo "<td>$center</td>";			
echo "<td>$parkcode</td>";
if($crj_cc_account2adjust=='434410003') {echo "<td>$crj_cc_account2adjust</td>";}			
if($crj_cc_account2adjust!='434410003') {echo "<td><font class='cartRow'>$crj_cc_account2adjust</font></td>";}			
echo "<td>$park_acct_desc</td>";			
echo "</tr>";
}		                      
    
       
              
           







 echo "</table>";
 
//echo "Query11=$query11"; 
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



?>