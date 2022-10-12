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
if($level==1){$parkcode=$concession_location;}
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
//echo "f_year=$f_year";
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
//$table="rbh_multiyear_concession_fees3";

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
include ("test_style.php");

include("../../../budget/menu1314.php");
//if($center==''){$center=$concession_center;}
//if($park==''){$park=$concession_location;}
//include ("park_deposits_report_menu_v2.php");
//include("/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php");
//include ("park_posted_deposits_widget1.php");

//include("../../../budget/park_deposits_report_menu_v3.php");

//include ("park_deposits_report_menu_v3.php");

echo "<br />";





//include ("park_posted_deposits_fyear_header2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";


if($park!=''){$parkcode=$park;}


if($parkcode=='')
{
$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id
from cash_summary
where valid='y'
and weekend='n'
group by park,effect_date desc
";
}
else
{


$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


$query4="select park,count(id) as 'complianceYes' 
from cash_summary
where valid='y'
and weekend='n'
and compliance='y'
and park='$parkcode'
group by park
";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);
extract($row4);
if($complianceYes==''){$complianceYes='0';}

$query4a="select park,count(id) as 'complianceNo' 
from cash_summary
where valid='y'
and weekend='n'
and compliance='n'
and park='$parkcode'
group by park
";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);

if($complianceNo==''){$complianceNo='0';}

$total_scorable_recs=$complianceYes+$complianceNo;

$score=($complianceYes/$total_scorable_recs)*100;
$score=number_format($score,0);

$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id
from cash_summary
where valid='y'
and weekend='n'
and park='$parkcode'
group by park,effect_date desc
";
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

/*
$query6="SELECT sum(crs_tdrr_division_history_parks.amount) as 'total'
FROM crs_tdrr_division_history_parks
WHERE crs_tdrr_division_history_parks.deposit_id='$deposit_id'";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
*/
echo "<table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'><font color='blue'>$center_location $center</font></img><br /><font color='brown' size='5'><b>Bank Deposit Compliance Report (Daily)</b></font></th></tr></table>";
echo "<br /><br />";
//echo "<br />";
//echo "<td><font size=4 color=brown >$park-$center</font></td>";
/*
echo "<table><tr><td><font color='red'>Records: $num5</font></td></tr></table>";
*/
echo "<table border=1>";

echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: $score</b></font></font></th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$complianceYes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$complianceNo</td></tr>";
//echo "<tr><th><font color='blue'>total</font></th><th><font color='blue'>$num5</font></th></tr>";

              
echo "</table><br />";
echo "<table>";
echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  //echo "<th align=left><font color=brown>Fyear</font></th>";
 echo "<th align=left><font color=brown>Park</font></th>
	   <th align=left><font color=brown>Date</font></th>
       <th align=left><font color=brown>Beg Balance</font></th>
       <th align=left><font color=brown>Deposit Amount</font></th>
       <th align=left><font color=brown>Transaction Amount</font></th>
       <th align=left><font color=brown>End Balance</font></th>
       <th align=left><font color=brown>Days Elapsed (earliest undeposited transaction) </font></th>
       <th align=left><font color=brown>Compliance</font></th>
       <th align=left><font color=brown>ID</font></th>";
       
      
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$amount=number_format($amount,2);
//$amount_2751=number_format($amount_2751,2);
//$amount_1000=number_format($amount_1000,2);
//$amount_total=number_format($amount_total,2);

$effect_date_dow=date('l',strtotime($effect_date));


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

if($compliance == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}



echo 

"<tr$t>";

       //echo "<td>$category</td>";
     //echo "<td>$f_year</td>";
     echo "<td>$park</td>		   
           <td>$effect_date<br />$effect_date_dow</td>		   
           <td>$beg_bal</td>		   
           <td>$deposit_amount</td>		   
           <td>$transaction_amount</td>	           		   
           <td>$end_bal</td>
		   <td>$days_elapsed2</td>	
           <td><a href='compliance.php?parkcode=$park'>$compliance</a>";
		   if($compliance=='n'){echo "<br /><form><textarea rows='4' cols='30' placeholder='Enter Park Justification for non-compliance. Then click Update Button'>$park_compiance_comment</textarea><input type=submit name=submit_compliance submit value=update></form>";}
		   echo "</td>   
            <td>$id</td>";  
           	   
             
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
      
           
              
           
echo "</tr>";




}
//if($level>1)
//{


while ($row6=mysqli_fetch_array($result6)){





extract($row6);

$total=number_format($total,2);
//$amount_2751T=number_format($amount_2751T,2);
//$amount_1000T=number_format($amount_1000T,2);
//$grand_total=number_format($grand_total,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	

           <td>$total</td> 
           
         
           
           

           		  

</tr>";



}

//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














