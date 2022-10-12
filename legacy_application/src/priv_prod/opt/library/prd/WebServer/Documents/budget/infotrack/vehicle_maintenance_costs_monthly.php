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
include("../../budget/menu1314.php");
include ("vehicle_maintenance_report_menu_v2.php");
include ("vehicle_maintenance_widget1_v2.php");
//include ("park_posted_deposits_monthly_distmenu_v2.php");
//include ("park_posted_deposits_fyear_header.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";

if($level<2)
{

$query5="select park,center,f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from crj_posted5_v2
where 1
and f_year='$f_year' and center='$concession_center'
group by center,f_year
order by park;";

}
/*
if($level==2)

{

$query5="select park,center,f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from crj_posted5_v2
where 1
and f_year='$f_year' and park='$distparkS'
group by center,f_year
order by park;";

}
*/
if($level==2 and $concession_location=='NODI')
{
$query5="select crj_posted5_v2.park,crj_posted5_v2.center,crj_posted5_v2.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
where 1
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and f_year='$f_year' 
group by crj_posted5_v2.center,crj_posted5_v2.f_year
order by crj_posted5_v2.park;";
}

if($level==2 and $concession_location=='SODI')
{
$query5="select crj_posted5_v2.park,crj_posted5_v2.center,crj_posted5_v2.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
where 1
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
and f_year='$f_year' 
group by crj_posted5_v2.center,crj_posted5_v2.f_year
order by crj_posted5_v2.park;";
}

if($level==2 and $concession_location=='EADI')
{
$query5="select crj_posted5_v2.park,crj_posted5_v2.center,crj_posted5_v2.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
where 1
and dist='east' and fund='1280' and actcenteryn='y'
and f_year='$f_year' 
group by crj_posted5_v2.center,crj_posted5_v2.f_year
order by crj_posted5_v2.park;";
}

if($level==2 and $concession_location=='WEDI')
{
$query5="select crj_posted5_v2.park,crj_posted5_v2.center,crj_posted5_v2.f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
where 1
and dist='west' and fund='1280' and actcenteryn='y'
and f_year='$f_year' 
group by crj_posted5_v2.center,crj_posted5_v2.f_year
order by crj_posted5_v2.park;";

}


if($level>2)

{

$query5="select park,center,f_year,sum(jul) as 'jul',
sum(aug) as 'aug',sum(sep) as 'sep',sum(oct) as 'oct',sum(nov) as 'nov',sum(dece) as 'dece',sum(jan) as 'jan',sum(feb) as 'feb',sum(mar) as 'mar',sum(apr) as 'apr',sum(may) as 'may',sum(jun) as 'jun',sum(total) as 'total'
from crj_posted5_v2
where 1
and f_year='$f_year'
group by center,f_year
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


if($level==2 and $concession_location=='NODI')

{
$query6="select sum(jul) as 'julT',
sum(aug) as 'augT',sum(sep) as 'sepT',sum(oct) as 'octT',sum(nov) as 'novT',sum(dece) as 'deceT',sum(jan) as 'janT',sum(feb) as 'febT',sum(mar) as 'marT',sum(apr) as 'aprT',sum(may) as 'mayT',sum(jun) as 'junT',sum(total) as 'Gtotal'
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
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
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
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
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
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
from crj_posted5_v2
left join center on crj_posted5_v2.center=center.center
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
from crj_posted5_v2
where 1
and f_year='$f_year';";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}



echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
	   <th align=left><font color=brown>Fyear</font></th>
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
       <th align=left><font color=brown>Jun</font></th>
       <th align=left><font color=brown>Total</font></th>";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

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
$total=number_format($total,2);




//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
     echo "<td><a href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center'>$park</a></td>
           <td>$center</td>		   
           <td>$f_year</td>		   
           <td>$jul</td>		   
           <td>$aug</td>		   
           <td>$sep</td>		   
           <td>$oct</td>		   
           <td>$nov</td>		   
           <td>$dece</td>		   
           <td>$jan</td>		   
           <td>$feb</td>		   
           <td>$mar</td>		   
           <td>$apr</td>		   
           <td>$may</td>		   
           <td>$jun</td>		   
           <td>$total</td>		   
           	   
          
                    
      
           
              
           
</tr>";




}
if($level>1)
{
while ($row6=mysqli_fetch_array($result6)){



// The extract function automatically creates individual variables from the array $row

//These individual variables are the names of the fields queried from MySQL

extract($row6);

$julT=number_format($julT,2);
$augT=number_format($augT,2);
$sepT=number_format($sepT,2);
$octT=number_format($octT,2);
$novT=number_format($novT,2);
$deceT=number_format($deceT,2);
$janT=number_format($janT,2);
$febT=number_format($febT,2);
$marT=number_format($marT,2);
$aprT=number_format($aprT,2);
$mayT=number_format($mayT,2);
$junT=number_format($junT,2);
$Gtotal=number_format($Gtotal,2);





if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	
           <td></td> 	

           <td>Total</td> 	

           <td>$julT</td> 
           <td>$augT</td> 
           <td>$sepT</td> 
           <td>$octT</td> 
           <td>$novT</td> 
           <td>$deceT</td> 
           <td>$janT</td> 
           <td>$febT</td> 
           <td>$marT</td> 
           <td>$aprT</td> 
           <td>$mayT</td> 
           <td>$junT</td> 
           <td>$Gtotal</td> 

          
           
           

           		  

</tr>";



}
}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














