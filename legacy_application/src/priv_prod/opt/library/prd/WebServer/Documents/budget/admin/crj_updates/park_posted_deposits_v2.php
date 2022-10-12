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
//include("../../../budget/menu1314.php");
include("menu1314_cash_receipts.php");
//include("../../../budget/menus2.php");
include ("park_deposits_report_menu_v2.php");
include ("park_posted_deposits_widget1_v2.php");
//include ("park_posted_deposits_fyear_header.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";

if($level<3)
{

$query5="select park,center,sum(cy_amount)as 'cy_amount',sum(py1_amount) as 'py1_amount',sum(py2_amount) as 'py2_amount',sum(py3_amount) as 'py3_amount',sum(py4_amount) as 'py4_amount'
from crj_posted4_v2
where 1 and center='$concession_center'
group by center
order by park;";
}
else
{

$query5="select park,center,sum(cy_amount)as 'cy_amount',sum(py1_amount) as 'py1_amount',sum(py2_amount) as 'py2_amount',sum(py3_amount) as 'py3_amount',sum(py4_amount) as 'py4_amount'
from crj_posted4_v2
where 1 
group by center
order by park;";
}
/*
if($level==1) 

{

$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location'
order by park,vendor ";

}
*/

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

$query6="SELECT sum(cy_amount) as 'cy_amount',sum(py1_amount) as 'py1_amount',
         sum(py2_amount) as 'py2_amount',sum(py3_amount) as 'py3_amount',sum(py4_amount) as 'py4_amount'
         FROM crj_posted4_v2
         WHERE 1 ";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	




echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
	   <th align=left><font color=brown>1314</font></th>
       <th align=left><font color=brown>1213</font></th>
       <th align=left><font color=brown>1112</font></th>
       <th align=left><font color=brown>1011</font></th>
       <th align=left><font color=brown>0910</font></th>";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);
$py2_amount=number_format($py2_amount,2);
$py3_amount=number_format($py3_amount,2);
$py4_amount=number_format($py4_amount,2);



//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
     echo "<td>$park</td>
           <td>$center</td>		   
           <td>$cy_amount</td>		   
           <td>$py1_amount</td>		   
           <td>$py2_amount</td>		   
           <td>$py3_amount</td>   
           <td>$py4_amount</td>";		   
       //echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>
                    
      
           
              
           
echo "</tr>";




}
if($level>2)
{
while ($row6=mysqli_fetch_array($result6)){



// The extract function automatically creates individual variables from the array $row

//These individual variables are the names of the fields queried from MySQL

extract($row6);

$cy_amount=number_format($cy_amount,2);

$py1_amount=number_format($py1_amount,2);

$py2_amount=number_format($py2_amount,2);

$py3_amount=number_format($py3_amount,2);

$py4_amount=number_format($py4_amount,2);





if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	

           <td>Total</td> 	

           <td>$cy_amount</td> 

           <td>$py1_amount</td> 

           <td>$py2_amount</td> 

           <td>$py3_amount</td> 
		   
           <td>$py4_amount</td> 
           
           

           		  

</tr>";



}
}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














