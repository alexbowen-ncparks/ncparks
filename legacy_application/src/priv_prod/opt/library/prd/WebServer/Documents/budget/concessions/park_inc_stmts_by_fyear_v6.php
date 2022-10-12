<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];


extract($_REQUEST);

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
//echo "f_year=$f_year<br />";
if($fyear==''){$fyear=$f_year;}
if($scope==''){$scope='park';}
if($scope=='park'){$where_scope=" and scope='park' ";}
if($report_type==''){$report_type='all';}


$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent',sum(camping_cabin) as 'camping_cabin',sum(concessions) as 'concessions',sum(other) as 'other',id
FROM report_budget_history_inc_stmt_by_fyear_net
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY receipt_percent desc";



echo "query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

echo "<html>";
?>
<head>
<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getuser.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>

<?php



echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Rank</font></th>
        <th align=left><font color=brown>Center Name</font></th>
       <th align=left><font color=brown>Center</font></th>
	   <th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Expenditures<br />(ex pfr exp)</font></th>
       <th align=left><font color=brown>Receipts <br />(net of pfr exp)</font></th>
       <th align=left><font color=brown>Receipt%</font></th> 
       <th align=left><font color=brown>Camping/Cabins</font></th>
       <th align=left><font color=brown>3rd Party <br />Concessions</font></th>
       <th align=left><font color=brown>Other</font></th> ";
      
              
echo "</tr>";


while ($row=mysqli_fetch_array($result5)){


extract($row);
$expenditures=number_format($expenditures,2);
$receipts=number_format($receipts,2);
$camping_cabin=number_format($camping_cabin,2);
$concessions=number_format($concessions,2);
$other=number_format($other,2);


$rank=@$rank+1;

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
    //echo "<td><a href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center'>$park</a></td>";
	echo "<td>$rank</td>";
     echo "<td>$center_description ($parkcode)</td>";
     echo "<td>$center</td>		   
           <td>$f_year</td>		   
           <td>$expenditures</td>		   
           <td>$receipts</td>		   
           <td align='center'>$receipt_percent</td>	
           <td>$camping_cabin</td>			   
           <td>$concessions</td>			   
           <td>$other</td>";	
		   
echo "<td>
      $id
	  <form>
      <select name='users' onchange='showUser(this.value)'>
      <option value=''>Select a person:</option>
      <option value='1'>Tammy</option>
      <option value='2'>Tom</option>
      <option value='3'>Tony</option>
      </select>
      </form>
	  <br>
      <div id='txtHint'><b>Person info will be listed here.</b></div> 		   
      </td>";			   
                       
           
echo "</tr>";




}


 echo "</table>";
 
  
 
 echo "</body></html>";



?>


 


























	














