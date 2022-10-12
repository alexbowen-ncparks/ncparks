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
//include("../../budget/~f_year.php");

//brings back the fiscal year for last record entered into TABLE=concessions_vendor_fees
/*
$query1="SELECT max(f_year) as 'fyear_last' from concessions_vendor_fees where 1";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);
*/

//echo "<br />fyear_last=$fyear_last<br />";



//brings back the ACTIVE fiscal year needed for entering a NEW Record into TABLE=concessions_vendor_fees
$query1a="SELECT report_year as 'fyear_active',cy,py1,py2,py3,py4,py5,py6,py7,py8,py9,py10,py11,py12 from fiscal_year where active_year_concession_fees='y' ";

$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

$row1a=mysqli_fetch_array($result1a);

extract($row1a);

/*
echo "<br />fyear_active=$fyear_active<br />";
echo "<br />cy=$cy<br />";
echo "<br />py1=$py1<br />";
echo "<br />py2=$py2<br />";
echo "<br />py3=$py3<br />";
echo "<br />py4=$py4<br />";
echo "<br />py5=$py5<br />";
echo "<br />py6=$py6<br />";
echo "<br />py7=$py7<br />";
echo "<br />py8=$py8<br />";
echo "<br />py9=$py9<br />";
echo "<br />py10=$py10<br />";
echo "<br />py11=$py11<br />";
echo "<br />py12=$py12<br />";
*/



$f_year=$fyear_active;


//echo "<br />f_year=$f_year<br />";


$query1="truncate table rbh_multiyear_concession_fees2";
		 
//echo "<br />query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$row1=mysqli_fetch_array($result1);
//extract($row1);	

$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,cy_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$cy'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//exit;


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py1_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py1'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//exit;


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py2_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py2'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py3_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py3'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py4_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py4'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py5_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py5'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py6_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py6'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py7_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py7'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py8_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py8'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py9_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py9'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py10_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py10'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py11_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py11'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,py12_amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$py12'
		 group by ncas_center,park,vendor_name";
		 
//echo "<br />query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2a="update rbh_multiyear_concession_fees2 as t1,concessions_vendors as t2
          set t1.ncas_account=t2.ncas_account,t1.account_description=t2.account_description
          where t1.center=t2.center
          and t1.park=t2.park
          and t1.vendor=t2.vendor_name		  ";
		 
//echo "query2a=$query2a<br />";		 

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");




//exit;


$query3="truncate table rbh_multiyear_concession_fees3 ";
		 
//echo "query3=$query3<br />";		 

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

//exit;


$query3a="insert into rbh_multiyear_concession_fees3(center,ncas_account,account_description,park,vendor,cy_amount,py1_amount,py2_amount,py3_amount,py4_amount,py5_amount,py6_amount,py7_amount,py8_amount,py9_amount,py10_amount,py11_amount,py12_amount) 
          select center,ncas_account,account_description,park,vendor,sum(cy_amount),sum(py1_amount),sum(py2_amount),sum(py3_amount),sum(py4_amount),sum(py5_amount),sum(py6_amount),sum(py7_amount),sum(py8_amount),sum(py9_amount),sum(py10_amount),sum(py11_amount),sum(py12_amount)
          from rbh_multiyear_concession_fees2
          where 1
          group by center,ncas_account,park,vendor
          order by park,vendor";

		  
//echo "query3a=$query3a<br />";		 

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3");






//exit;

/*
$query3="update rbh_multiyear_concession_fees3 as t1,rbh_multiyear_concession_fees2 as t2
         set t1.cy_amount=t2.cy_amount
		 where t1.center=t2.center
		 and t1.ncas_account=t2.ncas_account
		 and t1.park=t2.park
		 and t1.vendor=t2.vendor ";
		 
echo "query3=$query3<br />";		 

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

*/



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

echo "<br />query5=$query5<br />";
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

$since_last_update2=str_replace("-","",$since_last_update);
//echo "since_last_update2=$since_last_update2";


$query_fy_header="SELECT cy,py1,py2,py3,py4,py5,py6,py7,py8,py9,py10,py11,py12 from fiscal_year where active_year_concession_fees='y' ";

//echo "<br />Line 246: query_fy_header=$query_fy_header<br />";

$result_fy_header = mysqli_query($connection, $query_fy_header) or die ("Couldn't execute query_fy_header.  $query_fy_header");




echo "<table border=1><tr><td>View Receipts for Fiscal Year $f_year (Source: TABLE=exp_rev)  -<a href='new_concession_receipts.php' target='_blank'>VIEW</a></td></tr></table>";
echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Park_Location</font></th>
       <th align=left><font color=brown>Vendor</font></th>
       <th align=left><font color=brown>Revenue_Account_Description</font></th>";
	   
while ($fy_header_row=mysqli_fetch_array($result_fy_header)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($fy_header_row); 
	   
	   
	   
	   echo "<th align=left><font color=brown>$cy</font></th>
	   <th align=left><font color=brown>$py1</font></th>
	   <th align=left><font color=brown>$py2</font></th>
	   <th align=left><font color=brown>$py3</font></th>
	   <th align=left><font color=brown>$py4</font></th>
	   <th align=left><font color=brown>$py5</font></th>
       <th align=left><font color=brown>$py6</font></th>
       <th align=left><font color=brown>$py7</font></th>
       <th align=left><font color=brown>$py8</font></th>
       <th align=left><font color=brown>$py9</font></th>
       <th align=left><font color=brown>$py10</font></th>
       <th align=left><font color=brown>$py11</font></th>
       <th align=left><font color=brown>$py12</font></th>    
       ";
       	   
	   
}	   
	   
       
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