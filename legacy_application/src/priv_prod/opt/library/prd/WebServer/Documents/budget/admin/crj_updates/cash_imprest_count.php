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
$system_entry_date=date("Ymd");
/*
if($posTitle=='park superintendent'){echo "<font color='brown'><b>hello park superintendent</b></font>";}
*/

if($posTitle=='park superintendent'){$pasu_role='y';}


extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
if(@$f_year==""){include("../../~f_year.php");}
//echo "f_year=$f_year";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
if($mode==''){$mode='report';}
//echo "mode=$mode";
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

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//include("../../../budget/menu1314.php");
include ("../../../budget/menu1415_v1.php");
//include ("park_deposits_report_menu_v2_test.php");
//include ("park_posted_deposits_widget1_v2_test.php");
//include ("park_posted_deposits_widget2_v2_test.php");


//include ("cash_imprest_count_widget1.php");
//include ("cash_imprest_count_widget2.php");

if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


echo "<br /><table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><font color='brown'></b>Cash Imprest Count </font>(Monthly)-<font color='green'>$center_location</font></b></th></tr></table>";
include("../../../budget/infotrack/slide_toggle_procedures_module2.php");
include ("cash_imprest_count_fyear_module.php");

include ("cash_imprest_count_widget3.php");



//include ("park_posted_deposits_monthly_distmenu_v2.php");
//include ("park_posted_deposits_fyear_header.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
/*
if($level<2)
{

$query5="select park,center,f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from cash_imprest_count
where 1
and f_year='$f_year' and center='$concession_center'
group by center,f_year
order by park;";

}

if($level==2 and $concession_location=='NODI')
{
$query5="select cash_imprest_count.park,cash_imprest_count.center,cash_imprest_count.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and f_year='$f_year' 
group by cash_imprest_count.center,cash_imprest_count.f_year
order by cash_imprest_count.park;";
}

if($level==2 and $concession_location=='SODI')
{
$query5="select cash_imprest_count.park,cash_imprest_count.center,cash_imprest_count.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
and f_year='$f_year' 
group by cash_imprest_count.center,cash_imprest_count.f_year
order by cash_imprest_count.park;";
}

if($level==2 and $concession_location=='EADI')
{
$query5="select cash_imprest_count.park,cash_imprest_count.center,cash_imprest_count.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='east' and fund='1280' and actcenteryn='y'
and f_year='$f_year' 
group by cash_imprest_count.center,cash_imprest_count.f_year
order by cash_imprest_count.park;";
}

if($level==2 and $concession_location=='WEDI')
{
$query5="select cash_imprest_count.park,cash_imprest_count.center,cash_imprest_count.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='west' and fund='1280' and actcenteryn='y'
and f_year='$f_year' 
group by cash_imprest_count.center,cash_imprest_count.f_year
order by cash_imprest_count.park;";

}


if($level>2)

{

$query5="select park,center,f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from cash_imprest_count
where 1
and f_year='$f_year'
group by center,f_year
order by park;";

}



$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);




if($level==2 and $concession_location=='NODI')

{
$query6="select sum(jul) as 'julT',
sum(aug) as 'augT',sum(sep) as 'sepT',sum(oct) as 'octT',sum(nov) as 'novT',sum(dece) as 'deceT',sum(jan) as 'janT',sum(feb) as 'febT',sum(mar) as 'marT',sum(apr) as 'aprT',sum(may) as 'mayT',sum(jun) as 'junT',sum(total) as 'Gtotal'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and f_year='$f_year';";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}

if($level==2 and $concession_location=='SODI')

{
$query6="select sum(jul) as 'julT',
sum(aug) as 'augT',sum(sep) as 'sepT',sum(oct) as 'octT',sum(nov) as 'novT',sum(dece) as 'deceT',sum(jan) as 'janT',sum(feb) as 'febT',sum(mar) as 'marT',sum(apr) as 'aprT',sum(may) as 'mayT',sum(jun) as 'junT',sum(total) as 'Gtotal'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
and f_year='$f_year';";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}

if($level==2 and $concession_location=='EADI')

{
$query6="select sum(jul) as 'julT',
sum(aug) as 'augT',sum(sep) as 'sepT',sum(oct) as 'octT',sum(nov) as 'novT',sum(dece) as 'deceT',sum(jan) as 'janT',sum(feb) as 'febT',sum(mar) as 'marT',sum(apr) as 'aprT',sum(may) as 'mayT',sum(jun) as 'junT',sum(total) as 'Gtotal'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='east' and fund='1280' and actcenteryn='y'
and f_year='$f_year';";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}

if($level==2 and $concession_location=='WEDI')

{
$query6="select sum(jul) as 'julT',
sum(aug) as 'augT',sum(sep) as 'sepT',sum(oct) as 'octT',sum(nov) as 'novT',sum(dece) as 'deceT',sum(jan) as 'janT',sum(feb) as 'febT',sum(mar) as 'marT',sum(apr) as 'aprT',sum(may) as 'mayT',sum(jun) as 'junT',sum(total) as 'Gtotal'
from cash_imprest_count
left join center on cash_imprest_count.center=center.center
where 1
and dist='west' and fund='1280' and actcenteryn='y'
and f_year='$f_year';";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}


if($level>2)
{
$query6="select sum(jul) as 'julT',
sum(aug) as 'augT',sum(sep) as 'sepT',sum(oct) as 'octT',sum(nov) as 'novT',sum(dece) as 'deceT',sum(jan) as 'janT',sum(feb) as 'febT',sum(mar) as 'marT',sum(apr) as 'aprT',sum(may) as 'mayT',sum(jun) as 'junT',sum(total) as 'Gtotal'
from cash_imprest_count
where 1
and f_year='$f_year';";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}
*/


if($park != '')
{
$query6a="select center as 'concession_center' from center where parkcode='$park' and fund='1280' and actcenteryn='y' ";
$result6a=mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a. $query6a");

$row6a=mysqli_fetch_array($result6a);

extract($row6a);
}

$query6b="update cash_imprest_count,cash_imprest_authorized
          set cash_imprest_count.authorized=cash_imprest_authorized.grand_total
		  where cash_imprest_count.center=cash_imprest_authorized.center
          and cash_imprest_count.fyear='$fyear'
          and cash_imprest_authorized.fyear='$fyear' ";		

//echo "query6b=$query6b<br />";		  
$result6b=mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b. $query6b");


$query6c="select cash_count_month,start_date from cash_imprest_count_scoring
          where fyear='$fyear'  and score='100'";		

//echo "query6b=$query6b<br />";		  
$result6c=mysqli_query($connection, $query6c) or die ("Couldn't execute query 6c. $query6c");

while ($row=mysqli_fetch_assoc($result6c))
	{
	$header_array[$row['cash_count_month']]=$row['start_date'];;
	}
//echo "<pre>"; print_r($header_array); echo "</pre>";  exit;		
		  
foreach($header_array AS $month=>$start_date)
	{
	$field=$month._valid;
	//echo "<tr><th>$index</th></tr>";
	$start_date=str_replace("-","",$start_date);
	if($system_entry_date >= $start_date)
	{
	$query2="update cash_imprest_count
	         set $field='y'";
	echo "query2=$query2 $start_date $system_entry_date<br /><br />";		 
	 
     $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
	}
	}
//exit;	
$query5="select park,center,location,fyear,sum(authorized) as 'authorized',sum(jul) as 'jul',jul_valid,
sum(aug) as 'aug',aug_valid,sum(sep) as 'sep',sep_valid,sum(oct) as 'oct',oct_valid,sum(nov) as 'nov',nov_valid,sum(dece) as 'dece',dece_valid,sum(jan) as 'jan',jan_valid,sum(feb) as 'feb',feb_valid,sum(mar) as 'mar',mar_valid,sum(apr) as 'apr',apr_valid,sum(may) as 'may',may_valid,sum(jun) as 'jun',jun_valid,sum(total) as 'total'
from cash_imprest_count
where 1
and fyear='$fyear' 
and center='$concession_center' ;";

echo "query5=$query5<br />";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



echo "<table>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>Location</font></th>
	   <th align=left><font color=brown>Fyear</font></th>
	   <th align=left><font color=brown>Authorized<br />Amount</font></th>
       <th align=left><font color=brown>Jul</font></th>
       <th align=left><font color=brown>Aug</font></th>
       <th align=left><font color=brown>Sep</font></th>
       <th align=left><font color=brown>Oct</font></th>
       <th align=left><font color=brown>Nov</font></th>
       <th align=left><font color=brown>Dec</font></th>
       <th align=left><font color=brown>Jan</font></th>
       <th align=left><font color=brown>Feb</font></th>
       <th align=left><font color=brown>Mar</font></th>
       <th align=left><font color=brown>Apr</font></th>
       <th align=left><font color=brown>May</font></th>
       <th align=left><font color=brown>Jun</font></th>";
       
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

if($mode=='edit')
{
echo  "<form method='post' autocomplete='off' action='cash_imprest_count_update.php'>";
//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$jul=number_format($jul,2);
$aug=number_format($aug,2);
$sep=number_format($sep,2);
$oct=number_format($oct,2);
$nov=number_format($nov,2);
$dece=number_format($dece,2);
$jan=number_format($jan,2);
$feb=number_format($feb,2);
$mar=number_format($mar,2);
$apr=number_format($apr,2);
$may=number_format($may,2);
$jun=number_format($jun,2);





//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
     echo "<td><a href=''>$park</a></td>
           <td>$center</td>		   
           <td>$location</td>		   
           <td>$f_year</td>		   
           <td>$authorized</td>";	

	if($jul_valid=='y' and $jul=='0.00')
	{echo "<td><input type='text' size='10' name='jul[]' value='$jul'</td>";}	
  	else {echo "<td>$jul</td>";}
         echo "<td><input type='text' size='10' name='aug[]' value='$aug'</td>		   
           <td><input type='text' size='10' name='sep[]' value='$sep'</td>		   
           <td><input type='text' size='10' name='oct[]' value='$oct'</td>		   
           <td><input type='text' size='10' name='nov[]' value='$nov'</td>		   
           <td><input type='text' size='10' name='dece[]' value='$dece'</td>		   
           <td><input type='text' size='10' name='jan[]' value='$jan'</td>		   
           <td><input type='text' size='10' name='feb[]' value='$feb'</td>		   
           <td><input type='text' size='10' name='mar[]' value='$mar'</td>		   
           <td><input type='text' size='10' name='apr[]' value='$apr'</td>		   
           <td><input type='text' size='10' name='may[]' value='$may'</td>		   
           <td><input type='text' size='10' name='jun[]' value='$jun'</td>		   
           		   
              
           	   
          
                    
      
           
              
           
</tr>";




}
if($pasu_role=='y')
{
echo "<tr><td colspan='9' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
}
echo "<input type='hidden' name='fiscal_year' value='$f_year'>	   
	  <input type='hidden' name='num6' value='$num5'>";


echo   "</form>";
}

if($mode=='report')
{
while ($row=mysqli_fetch_array($result5)){

extract($row);
$jul=number_format($jul,2);
$aug=number_format($aug,2);
$sep=number_format($sep,2);
$oct=number_format($oct,2);
$nov=number_format($nov,2);
$dece=number_format($dece,2);
$jan=number_format($jan,2);
$feb=number_format($feb,2);
$mar=number_format($mar,2);
$apr=number_format($apr,2);
$may=number_format($may,2);
$jun=number_format($jun,2);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr bgcolor='lightgreen'>";

       //echo "<td>$category</td>";
	   
 	   
	   
     echo "<td>$park</td>
           <td>$center</td>		   
           <td>$location</td>		   
           <td>$f_year</td>		   
           <td>$authorized</td>";		   
     if($jul_valid=='y' and $jul=='0.00'){echo "<td bgcolor='lightpink'>$jul</td>";}	else {echo "<td bgcolor='lightgreen'>$jul</td>";}	   
     if($aug_valid=='y' and $aug=='0.00'){echo "<td bgcolor='lightpink'>$aug</td>";}	else {echo "<td bgcolor='lightgreen'>$aug</td>";}	   
     if($sep_valid=='y' and $sep=='0.00'){echo "<td bgcolor='lightpink'>$sep</td>";}	else {echo "<td bgcolor='lightgreen'>$sep</td>";}	   
     if($oct_valid=='y' and $oct=='0.00'){echo "<td bgcolor='lightpink'>$oct</td>";}	else {echo "<td bgcolor='lightgreen'>$oct</td>";}	   
     if($nov_valid=='y' and $nov=='0.00'){echo "<td bgcolor='lightpink'>$nov</td>";}	else {echo "<td bgcolor='lightgreen'>$nov</td>";}	   
     if($dece_valid=='y' and $dece=='0.00'){echo "<td bgcolor='lightpink'>$dece</td>";}	else {echo "<td bgcolor='lightgreen'>$dece</td>";}	   
     if($jan_valid=='y' and $jan=='0.00'){echo "<td bgcolor='lightpink'>$jan</td>";}	else {echo "<td bgcolor='lightgreen'>$jan</td>";}	   
     if($feb_valid=='y' and $feb=='0.00'){echo "<td bgcolor='lightpink'>$feb</td>";}	else {echo "<td bgcolor='lightgreen'>$feb</td>";}	   
     if($mar_valid=='y' and $mar=='0.00'){echo "<td bgcolor='lightpink'>$mar</td>";}	else {echo "<td bgcolor='lightgreen'>$mar</td>";}	   
     if($apr_valid=='y' and $apr=='0.00'){echo "<td bgcolor='lightpink'>$apr</td>";}	else {echo "<td bgcolor='lightgreen'>$apr</td>";}	   
     if($may_valid=='y' and $may=='0.00'){echo "<td bgcolor='lightpink'>$may</td>";}	else {echo "<td bgcolor='lightgreen'>$may</td>";}	   
     if($jun_valid=='y' and $jun=='0.00'){echo "<td bgcolor='lightpink'>$jun</td>";}	else {echo "<td bgcolor='lightgreen'>$jun</td>";}	   
              
              
           
echo "</tr>";
}
}
 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














