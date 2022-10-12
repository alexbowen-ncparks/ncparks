<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

//echo "line19 concession_location=$concession_location";






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
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



//echo "concession_location=$concession_location";

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

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//echo "line 114 concession_location=$concession_location<br />";
include("../../budget/menu1314.php");
include ("vm_report_menu_v2.php");
include ("vm_widget2_v2.php");
//echo "line 118 concession_location=$concession_location<br />";

if($concession_location=='ADM')
{
$query9="select parkcode as 'concession_location'
from budget.center where center='$center';
";
//echo "query10=$query10<br />";
$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$row9=mysqli_fetch_array($result9);

extract($row9);

}
//echo "line 133 concession_location=$concession_location<br />";

//echo "concession_location=$concession_location";

//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";

/*
if($level<3)
{
$query5="select * from vmc_posted7_v2
where f_year='$f_year'
and center='$center'
order by acctdate;";
}
else
{
$query5="select * from vmc_posted7_v2
where f_year='$f_year'
and center='$center'
order by acctdate;";
}

*/

//echo "line 163 concession_location=$concession_location<br />";

if($center==''){$center=$concession_center;}

$query5="select * from vmc_posted7_v2
where f_year='$f_year'
and center='$center'
and id='$id'
;";

//echo "query5=$query5";

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

//echo "line 189 concession_location=$concession_location<br />";

//echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
//echo "</table>";
//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";

$query6="select sum(amount) as 'amount_parkT' from vmc_posted7_v2
where f_year='$f_year'
and center='$center'
and id='$id' ;";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$row6=mysqli_fetch_array($result6);
extract($row6);
$amount_parkT=number_format($amount_parkT,2);

echo "<br />";
//echo "<td><font size=4 color=brown >$park-$center</font></td>";
//echo "<table><tr><td><font size='4' color='red'>$num5 Records </font></td></tr></table>";
echo "<table><tr><td><font size='4' color='red'>Amount $amount_parkT</font></td></tr></table>";

echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Month</font></th>
	   <th align=left><font color=brown>Day</font></th>
	   <th align=left><font color=brown>Description</font></th>
	   <th align=left><font color=brown>NCAS Account <br />Description</font></th>
	   <th align=left><font color=brown>DescriptionF5</font></th>
	   <th align=left><font color=brown>Comments</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>ID</font></th>
       <th align=left><font color=brown>Tag Number</font></th>
       ";
      
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);
//echo "concession_location=$concession_location";
//echo "f_year=$f_year<br />park=$park<br />center=$center<br />";exit;
include("tag_view_menu2.php");    

//echo  "<form method='post' autocomplete='off' action='vmc_tag_update.php'>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
//$amount_park=number_format($amount_park,2);
///$amount_2751=number_format($amount_2751,2);
//$amount_1000=number_format($amount_1000,2);
$amount=number_format($amount,2);

$descriptionF5=substr($description,0,5);

if($descriptionF5=='PCARD')
{$comments2=$pcu_item_purchased;}
else
{$comments2=$cvip_comments;}



if($acct=='532331'){$acct_description="Repairs";}
if($acct=='533330'){$acct_description="Fluids";}
if($acct=='533340'){$acct_description="Tires";}
if($acct=='533350'){$acct_description="Parts";}



if($description=='warehouse'){$description=$description.'-'.$invoice;}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


if($record_complete=="y"){$bgc="lightgreen";} else {$bgc="lightpink";}


echo 

"<tr bgcolor='$bgc'>";

       //echo "<td>$category</td>";
     echo "<td>$f_year</td>
           <td>$month</td>		   
           <td>$day</td>		   
           <td>$description</td>		   
           <td>$acct <br />$acct_description</td>		   
           <td>$descriptionF5</td>		   
           <td>$comments2</td>		   
           <td>$amount</td>";	  
   echo  "<td>$id</td>";
   echo  "<td>$license_tag</td>";
			
		  
  
	echo "</tr>";

	}	 
echo  "<form method='post' autocomplete='off' action='vmc_tag_split_update.php'>";
echo "<tr><td colspan='8' align='right'></td>";
echo "<td colspan='9' align='right'><input type='text' size='3' name='id' value='$id' readonly='readonly'</td>";
echo "</form";
		   
        
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
  echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














