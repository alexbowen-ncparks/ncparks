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



extract($_REQUEST);

//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

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

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}
*/
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../budget/menus2.php");
//include("../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");
//include ("widget1.php");
include ("widget1_concessionaire_fees.php");
echo "<br />";
include ("widget3_concessionaire_fees.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";

if($level>1)

{
if($category3=='all')
{

$query5="SELECT *
FROM $table
WHERE 1 
order by park,vendor ";
}

if($category3!='all')
{

$query5="SELECT *
FROM $table
WHERE 1 and ncas_account='$category3'
order by park,vendor ";
}





}








if($level==1) 

{
if($category3=='all')
{
$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location'
order by park,vendor ";
}

if($category3!='all')
{
$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location' and ncas_account='$category3'
order by park,vendor ";
}




}

echo "query5=$query5";
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
if($category3=='all')
{
$query6="SELECT sum(cy_amount) as 'cy_amount',sum(py1_amount) as 'py1_amount',
         sum(py2_amount) as 'py2_amount',sum(py3_amount) as 'py3_amount',sum(py4_amount) as 'py4_amount',sum(py5_amount) as 'py5_amount',sum(py6_amount) as 'py6_amount',
		 sum(py7_amount) as 'py7_amount',sum(py8_amount) as 'py8_amount',sum(py9_amount) as 'py9_amount',sum(py10_amount) as 'py10_amount',sum(py11_amount) as 'py11_amount',sum(py12_amount) as 'py12_amount'
         FROM $table
         WHERE 1 ";
		 
}		 
	

if($category3!='all')
{
$query6="SELECT sum(cy_amount) as 'cy_amount',sum(py1_amount) as 'py1_amount',
         sum(py2_amount) as 'py2_amount',sum(py3_amount) as 'py3_amount',sum(py4_amount) as 'py4_amount',sum(py5_amount) as 'py5_amount',sum(py6_amount) as 'py6_amount',
		 sum(py7_amount) as 'py7_amount',sum(py8_amount) as 'py8_amount',sum(py9_amount) as 'py9_amount',sum(py10_amount) as 'py10_amount',sum(py11_amount) as 'py11_amount',sum(py12_amount) as 'py12_amount'
         FROM $table 
         WHERE 1 and ncas_account='$category3' ";
		 
}	








	
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	



$query6a="SELECT min(start_date)as 'since_last_update' from project_steps_detail where project_name='weekly_updates' and project_category='fms'";

$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$row6a=mysqli_fetch_array($result6a);
extract($row6a);//brings back max (end_date) as $end_date









echo "<table border=1><tr><td><td>Receipts since $since_last_update -<a href='' target='_blank'>VIEW</a></td></tr></table>";
echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Park_Location</font></th>
       <th align=left><font color=brown>Vendor</font></th>
       <th align=left><font color=brown>Revenue_Account_Description</font></th>
	   <th align=left><font color=brown>1718</font></th>
	   <th align=left><font color=brown>1617</font></th>
	   <th align=left><font color=brown>1516</font></th>
	   <th align=left><font color=brown>1415</font></th>
       <th align=left><font color=brown>1314</font></th>
       <th align=left><font color=brown>1213</font></th>
       <th align=left><font color=brown>1112</font></th>
       <th align=left><font color=brown>1011</font></th>
       <th align=left><font color=brown>0910</font></th>
       <th align=left><font color=brown>0809</font></th>
       <th align=left><font color=brown>0708</font></th>
       <th align=left><font color=brown>0607</font></th>
       <th align=left><font color=brown>0506</font></th>";
       	   
	   
	   
	   
       
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
$py5_amount=number_format($py5_amount,2);
$py6_amount=number_format($py6_amount,2);
$py7_amount=number_format($py7_amount,2);
$py8_amount=number_format($py8_amount,2);
$py9_amount=number_format($py9_amount,2);
$py10_amount=number_format($py10_amount,2);
$py11_amount=number_format($py11_amount,2);
$py12_amount=number_format($py12_amount,2);


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
     echo "<td>$park-$center</td>
           <td>$vendor</td>		   
           <td><a href='vendor_fees_drilldown1.php?vendor_name=$vendor&f_year=$f_year&park=$park&ncas_center=$center' target='_blank'>$ncas_account</font>-$account_description</a></td>		   
           <td>$cy_amount</td>		   
           <td>$py1_amount</td>		   
           <td>$py2_amount</td>		   
           <td>$py3_amount</td>		   
           <td>$py4_amount</td>		   
           <td>$py5_amount</td>         
           <td>$py6_amount</td>         
           <td>$py7_amount</td>         
           <td>$py8_amount</td>         
           <td>$py9_amount</td>         
           <td>$py10_amount</td>         
           <td>$py11_amount</td>         
           <td>$py12_amount</td>         
           <td><a href='vendor_fees_drilldown1.php?vendor_name=$vendor&f_year=$f_year&park=$park&ncas_center=$center' target='_blank'>transactions</a></td>
                    
      
           
              
           
</tr>";




}
if($level>1)
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
$py5_amount=number_format($py5_amount,2);
$py6_amount=number_format($py6_amount,2);
$py7_amount=number_format($py7_amount,2);
$py8_amount=number_format($py8_amount,2);
$py9_amount=number_format($py9_amount,2);
$py10_amount=number_format($py10_amount,2);
$py11_amount=number_format($py11_amount,2);
$py12_amount=number_format($py12_amount,2);




if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	

           <td>Total</td> 
           <td></td>		   

           <td>$cy_amount</td> 

           <td>$py1_amount</td> 

           <td>$py2_amount</td> 

           <td>$py3_amount</td> 
           <td>$py4_amount</td> 
           <td>$py5_amount</td> 
           <td>$py6_amount</td> 
           <td>$py7_amount</td> 
           <td>$py8_amount</td> 
           <td>$py9_amount</td> 
           <td>$py10_amount</td> 
           <td>$py11_amount</td> 
           <td>$py12_amount</td> 
           

           		  

</tr>";



}
}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>