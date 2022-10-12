<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
/*
$var_total_gallons="";
$var_total_cost="";
$var_total_average_cost="";
$var_total_administrative_fee="";
$var_total_refund="";

*/
//$deposit_id='104885853';

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//if($tempid=='McGrath9695'){echo "tempid=$tempid<br />";}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


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

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

/*
if($park!=''){$concession_location=$park;}
$query1="SELECT sum(score) as 'score_total'
from concessions_pci_compliance
WHERE 1
and park='$concession_location'
and fyear='$fyear'
and valid='y'
";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


$query2="SELECT count(id) as 'score_records'
from concessions_pci_compliance
WHERE 1
and park='$concession_location'
and fyear='$fyear'
and valid='y'
";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);



$score=$score_total/$score_records;

$score=round($score);




//echo "hello cash_imprest_count2_report.php<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//if($tempid=='McGrath9695'){echo "cashier_count=$cashier_count<br />";}


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "manager_count=$manager_count<br />";


if($pasu_comment != '')
{
$pasu_comment=addslashes($pasu_comment);
$pasu_comment_query="update concessions_pci_compliance set manager_comment='$pasu_comment',manager_comment_name='$tempID',manager_comment_date='$system_entry_date' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}


if($fs_comment != '')
{
$fs_comment=addslashes($fs_comment);
$fs_comment_query="update concessions_pci_compliance set fs_comment='$fs_comment',fs_comment_name='$tempID',fs_comment_date='$system_entry_date' where id='$comment_id' ";

$result_fs_comment_query=mysqli_query($connection, $fs_comment_query) or die ("Couldn't execute query fs comment query. $fs_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}

*/







/*
$query10a="select SUM( reimbursement_gallons ) as 'total_gallons'
FROM  `concessions_pci_compliance` 
WHERE 1 
AND fyear = '$fyear'
AND cash_month = '$cash_month' ";


$result10a = mysqli_query($connection, $query10a) or die ("Couldn't execute query 10a.  $query10a");
		  
$row10a=mysqli_fetch_array($result10a);

extract($row10a);


$total_gallons=number_format($total_gallons,2);
*/



$query10="select count(manager) as 'complete'
from concessions_pci_compliance
where manager != ''
and fyear='$fyear' and cash_month='$cash_month'
";


$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
		  
$row10=mysqli_fetch_array($result10);

extract($row10);


$query10a="select count(manager) as 'total_records'
from concessions_pci_compliance
where 1
and fyear='$fyear' and cash_month='$cash_month'
";


$result10a = mysqli_query($connection, $query10a) or die ("Couldn't execute query 10a.  $query10a");
		  
$row10a=mysqli_fetch_array($result10a);

extract($row10a);

$score=round((($complete/$total_records)*100),0);


//echo "<br />complete=$complete<br />";
//echo "<br />total_records=$total_records<br />";
//echo "<br />score=$score<br />";











$query11="select 
concessions_pci_compliance.center,
concessions_pci_compliance.park,
concessions_pci_compliance.cashier,
concessions_pci_compliance.cashier_date,
concessions_pci_compliance.manager,
concessions_pci_compliance.manager_date,
concessions_pci_compliance.id,
center.park_name as 'parkcode'
from concessions_pci_compliance
left join center on concessions_pci_compliance.center=center.new_center
where fyear='$fyear' and cash_month='$cash_month'
group by concessions_pci_compliance.center order by parkcode ";



//echo "query11=$query11<br />";

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";

/*
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
*/
//echo "<table align='center'><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: &nbsp;&nbsp; $score</b></font></th></tr></table><br />";


//include ("../../budget/menu1415_v1.php");
include ("../../budget/menu1415_v1_style.php");
echo "<br />";

if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

/*
echo "<br /><table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><font color='brown'></b>Cash Imprest </font>(Monthly)-<font color='green'>$center_location</font></b></th></tr></table>";
*/
$calyear1='20'.substr($fyear,0,2);
$calyear2='20'.substr($fyear,2,2);
//echo "calyear1=$calyear1<br /><br />";
//echo "calyear2=$calyear2<br /><br />";

if($cash_month=='july' or $cash_month=='august' or $cash_month=='september' or $cash_month=='october' or $cash_month=='november' or $cash_month=='december') {$calyear=$calyear1;}
if($cash_month=='january' or $cash_month=='february' or $cash_month=='march' or $cash_month=='april' or $cash_month=='may' or $cash_month=='june') {$calyear=$calyear2;}

//echo "calyear=$calyear<br /><br />";

$query8a="select text_code from svg_graphics where id='2'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	




echo "<br /><table align='center'><tr><th>$text_code<br />($cash_month $calyear)</th></tr></table>";

echo "<br />";
echo "<table align='center'><tr><th>Completed: $complete of $total_records</th></tr></table>";
echo "<br />";

//include("mfm_summary_header1.php");

echo "<table align='center'>";
if($num11>0)
{
echo 

"<tr> 
       
       <th align=left><font color=brown>Park Name</font></th>       
       <th align=left><font color=brown>Cashier</font></th>
       <th align=left><font color=brown>Manager</font></th>
	   <th align=left><font color=brown>Document</font></th>
	   ";
	   /*
	   echo "<th align=left><font color=brown>Park<br />Match</font></th>
	   <th align=left><font color=brown>Authorized<br />Match</font></th>
	   <th align=left><font color=brown>BUOF<br />Comments</font></th>";
	   */
	   //echo "<th align=left><font color=brown>BUOF<br />Verify</font></th>";
	   //echo "<th align=left><font color=brown>Score</font></th>";
	//echo "<th align=left><font color=brown>Cash<br />Receipts<br />Journal</font></th>";
	   
       
      
       
              
echo "</tr>";
}
//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

$var_total_gallons="";
$var_total_cost="";
$var_grand_total="";

while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);

$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);

//$park_oob=$cashier_amount-$manager_amount;
//$cashier3=substr($cashier,0,-2);
//$manager3=substr($manager,0,-2);
//$refund_total=number_format($refund_total,2);
//$manager_comment_name3=substr($manager_comment_name,0,-2);
//$fs_comment_name3=substr($fs_comment_name,0,-2);
//$fs_approver3=substr($fs_approver,0,-2);
//$manager_comment_date_dow=date('l',strtotime($manager_comment_date));
/*
if($deposit_date == '0000-00-00')
{
$deposit_date2='';
}
else
{
$deposit_date2=date('m-d-y', strtotime($deposit_date));
}
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_date=date('m-d-y', strtotime($deposit_date));



if($deposit_date=='0000-00-00')
{$deposit_date_dow='';}
else
{$deposit_date_dow=date('l',strtotime($deposit_date));}
*/
/*
if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}

*/

/*
if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}

*/

//$cashier_date2=date('m-d-y', strtotime($cashier_date));
//$manager_date2=date('m-d-y', strtotime($manager_date));
//$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));
//$fs_comment_date2=date('m-d-y', strtotime($fs_comment_date));
//$fs_approver_date2=date('m-d-y', strtotime($fs_approver_date));

/*
echo "cashier=$cashier<br />";
echo "cashier_count=$cashier_count<br />";
echo "manager=$manager<br />";
echo "manager_count=$manager_count<br />";
*/



//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_id2 = substr($deposit_id, 0, 8);
//$deposit_idL8 = substr($deposit_id, -8, 8);
//if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($manager != ''){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo "<tr$t>";

//echo "<td bgcolor='lightgreen'><a href='page1.php?fyear=$fyear&park=$park' target='_blank'>$parkcode</td>";  
echo "<td>$parkcode</td>";  
echo "<td>$cashier3</td>";  
echo "<td>$manager3</td>";  

if($manager == '')
{
echo "<td></td>";  
}
if($manager != '')
{
 echo "<td bgcolor='lightgreen'><a href='pci_documents/concessions_pci_compliance_$id.pdf' target='_blank'>View</a></td>";
}		  
		    		  
			  
			  
			  
			  
			  
           
echo "</tr>";


$var_grand_total+=$grand_total;

}

$var_grand_total=number_format($var_grand_total,2);
//echo "<tr><td></td><td></td><td></td><td></td><td></td><th>Total Refund</th><td>$var_grand_total</td></tr>";
 echo "</table>";
 //echo "var_grand_total=$var_grand_total<br />";
//echo "<br /><br />";
/*
$var_total_gallons=number_format($var_total_gallons,2);
$var_total_cost2=number_format($var_total_cost,2);
$var_total_average_cost=number_format($var_total_cost/$var_total_gallons,4);
$var_total_administrative_fee=number_format($var_total_gallons*.12,2);
$var_total_refund=$var_total_cost+$var_total_administrative_fee;
$var_total_refund2=number_format($var_total_refund,2);
*/

 //echo "<table align='center'>";
 /*
  echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Total Gallons</td><td>$var_total_gallons</td></tr>";
  echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Average Price per Gallon</td><td>$var_total_average_cost</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Total Cost</td><td>$var_total_cost2</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Administrative Fee<br />(12 cents per gallon)</td><td>$var_total_administrative_fee</td></tr>";
 */
 //echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Total Refund</td><td>$var_grand_total</td></tr>";
 //echo "</table>";

?>



















	














