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
/*
echo "level=$level<br />";
echo "posTitle=$posTitle<br />";
echo "tempID=$tempID<br />";
echo "beacnum=$beacnum<br />";
echo "concession_location=$concession_location<br />";
echo "concession_center=$concession_center<br />";
*/






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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


if($center_code != ''){$where_park=" and park='$center_code'";}

$query1="select sum(amount) as 'total_532331'
         from vmc_posted7_v2
		 where acct='532331'
		 and f_year='$f_year'
		 and parent_record != 'y' 
		 $where_park ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);
$total_532331=number_format($total_532331,2);
//echo "total_532331=$total_532331";

$query1a="select sum(amount) as 'total_533330'
         from vmc_posted7_v2
		 where acct='533330'
		 and f_year='$f_year'
		 and parent_record != 'y'
         $where_park ";
		 
//echo "query1=$query1<br />";		 

$result1a = mysql_query($query1a) or die ("Couldn't execute query 1a.  $query1a");

$row1a=mysql_fetch_array($result1a);
extract($row1a);
$total_533330=number_format($total_533330,2);


$query1b="select sum(amount) as 'total_533340'
         from vmc_posted7_v2
		 where acct='533340'
		 and f_year='$f_year'
         and parent_record != 'y'
         $where_park ";
		 
//echo "query1=$query1<br />";		 

$result1b = mysql_query($query1b) or die ("Couldn't execute query 1b.  $query1b");

$row1b=mysql_fetch_array($result1b);
extract($row1b);
$total_533340=number_format($total_533340,2);


$query1c="select sum(amount) as 'total_533350'
         from vmc_posted7_v2
		 where acct='533350'
		 and f_year='$f_year'
         and parent_record != 'y'
         $where_park ";
		 
//echo "query1=$query1<br />";		 

$result1c = mysql_query($query1c) or die ("Couldn't execute query 1c.  $query1c");

$row1c=mysql_fetch_array($result1c);
extract($row1c);
$total_533350=number_format($total_533350,2);



$query1d="select sum(amount) as 'grand_total'
         from vmc_posted7_v2
		 where 1
		 and f_year='$f_year'
         and parent_record != 'y'
         $where_park ";
		 
//echo "query1=$query1<br />";		 

$result1d = mysql_query($query1d) or die ("Couldn't execute query 1d.  $query1d");

$row1d=mysql_fetch_array($result1d);
extract($row1d);
$grand_total=number_format($grand_total,2);




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
$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

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

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

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
include ("vm_report_menu_division_weekly.php");

include ("vm_widget2_division_weekly.php");
//echo "line 118 concession_location=$concession_location<br />";

/*
if($concession_location=='ADM')
{
$query9="select parkcode as 'concession_location'
from budget.center where center='$center';
";
//echo "query10=$query10<br />";
$result9=mysql_query($query9) or die ("Couldn't execute query 9. $query9");

$row9=mysql_fetch_array($result9);

extract($row9);

}
*/





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

//if($park==''){$park=$concession_location;}

//if($center_code != ''){$where_park=" and park='$center_code'";}

$query5="select * from vmc_posted7_v2
where f_year='$f_year'
and parent_record != 'y'
$where_park
order by acctdate desc;";
echo "query5=$query5";

$query5_yes="select count(id) as 'yes',sum(amount) as 'yes_amount' from vmc_posted7_v2
where f_year='$f_year'
and parent_record != 'y'
and record_complete='y'
$where_park
;";

$result5_yes = mysql_query($query5_yes) or die ("Couldn't execute query 5_yes.  $query5_yes");
$row5_yes=mysql_fetch_array($result5_yes);
extract($row5_yes);
$yes_amount=number_format($yes_amount,2);
//echo "yes=$yes";


$query5_no="select count(id) as 'no',sum(amount) as 'no_amount' from vmc_posted7_v2
where f_year='$f_year'
and parent_record != 'y'
and record_complete !='y'
$where_park
;";

$result5_no = mysql_query($query5_no) or die ("Couldn't execute query 5_no.  $query5_no");
$row5_no=mysql_fetch_array($result5_no);
extract($row5_no);
$no_amount=number_format($no_amount,2);

$yesandno=$yes+$no;
//echo "yesandno=$yesandno<br />";
//echo "f_year=$f_year<br />";
//echo "no=$no";

/*
if($f_year=='1314')

{
*/
/*
$mission_scores_update="update mission_scores set complete='$yes',total='$yesandno'
                      where gid='1' and playstation='$concession_location'  ";
					  



$result = mysql_query($mission_scores_update) or die ("Couldn't execute mission_scores_update  $mission_scores_update");
*/

//}



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

$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);

//echo "line 189 concession_location=$concession_location<br />";

//echo "<table border=5 cellspacing=5>";

//$row=mysql_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
//echo "</table>";
//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";

$query6="select sum(amount) as 'amount_parkT' from vmc_posted7_v2
where f_year='$f_year'
and parent_record != 'y' ;";
		 
$result6 = mysql_query($query6) or die ("Couldn't execute query 6.  $query6");
$row6=mysql_fetch_array($result6);
extract($row6);
$amount_parkT=number_format($amount_parkT,2);

echo "<br />";
//echo "<td><font size=4 color=brown >$park-$center</font></td>";
//echo "<table><tr><td><font size='4' color='red'>$num5 Records </font></td></tr></table>";
//echo "<table><tr><td><font size='4' color='red'>Amount $amount_parkT</font></td></tr></table>";
/*
echo "<table><tr><th colspan='2'><font color=blue>Matches</font></th></tr>
              <tr><td  bgcolor='lightgreen'>yes $yes<br /><br />$yes_amount</td><td bgcolor='lightpink'>no $no<br /><br />$no_amount</td></tr>";              
echo "</table>";
*/
echo "<table>";
echo "<tr>";
echo "<td  bgcolor='lightgreen' align='center'>$yes yes<br />$yes_amount</td>";
echo "<td></td><td></td>";
echo "<td  bgcolor='lightpink' align='center'>$no no <br />$no_amount</td>";
echo "</tr>";
echo "</table>";
echo "<br />";
echo "<table><tr><th>Records: $num5</th>";

echo "<form method='post' action='vm_costs_center_daily_division_weekly.php?f_year=$f_year'>";
if($level==1)
{
echo "<td><input name='center_code' type='text' value='$concession_location' readonly='readonly'></td>";
}
else
{
echo "<td><input name='center_code' type='text' value='$center_code'></td>";
}
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";


echo "</tr></table>";


echo "<br />";
echo "<table><tr><th><font size='6' class='cartRow'>Under Construction-Coming Soon</font></th></tr></table>";
echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Month</font></th>
	   <th align=left><font color=brown>Day</font></th>
	   <th align=left><font color=brown>Description</font></th>
	   <th align=left><font color=brown>NCAS Account <br />Description</font></th>
	   <th align=left><font color=brown>DescriptionF5</font></th>
	   <th align=left><font color=brown>Comments</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>ID</font></th>
       <th align=left><font color=brown>Tag Number</font></th>
       <th align=left><font color=brown>Matched<br />by</font></th>
       ";
      
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysql_fetch_array($result);
//echo "concession_location=$concession_location";
//echo "f_year=$f_year<br />park=$park<br />center=$center<br />";exit;
include("tag_view_menu2.php");    

echo  "<form method='post' autocomplete='off' action='vmc_tag_update.php'>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
while ($row=mysql_fetch_array($result5)){

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
	       <td>$park</td>	
           <td>$month</td>		   
           <td>$day</td>		   
           <td>$description</td>		   
           <td>$acct <br />$acct_description</td>		   
           <td>$descriptionF5</td>		   
           <td>$comments2</td>		   
           <td>$amount</td>";	
		   
		   // echo "<td><input type='text' size='1' name='id[]' value='$id' readonly='readonly'</td>";
			//echo "<td>$id</td>";
			echo "<td><input type='text' size='3' name='id[]' value='$id' readonly='readonly'</td>";
			
		   //echo "<td><input type='text' size='10'  name='tag_num[]' </td>";
		    echo "<td><select name=\"tag_num[]\"><option value=''></option>";
			
if($license_tag=='none')
{$s="selected";}else{$s="value";}			
			echo "<option $s='none'>none</option>"; 
			
			
if($license_tag=='multiple')
{$s="selected";}else{$s="value";}			
			echo "<option $s='multiple'>multiple</option>"; 			
			
			
			
			
			
			
			
for ($n=0;$n<count($tagArray);$n++){
$con=$tagArray[$n];
if($license_tag==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$tagArray[$n]</option>\n";
       }
   echo "</select>";
   
if($license_tag=='multiple'){echo "<a href='vm_costs_center_daily_split.php?id=$id'>Split Record</a>";}
echo "</td>"; 
echo "<td>$player</td>";  
	echo "</tr>";

	}	 


		   
        
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
  echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='num5' value='$num5'>";
echo "<input type='hidden' name='f_year' value='$f_year'>";
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='center' value='$center'>";
echo   "</form>";	 

  
 
//if($level>1)
//{


 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














