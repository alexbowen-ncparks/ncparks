<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$level=$_SESSION['budget']['level'];
//$posTitle=$_SESSION['budget']['position'];
//$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
//extract($_REQUEST);
//$database="budget";
//$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$query8="select comment_id as 'comment_id_list' from infotrack_projects_community_com_search
         where search_keyword='$keyword_chosen'
		 order by comment_id";
//echo "query8=$query8";exit;
$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");
//9-27-14
//$values=array();
while ($row8=mysqli_fetch_array($result8))
	{
	$choices8[]=$row8['comment_id_list'];
	}	

//print_r($choices8);exit;	
//echo "<pre>";print_r($choices8);"</pre>";//exit;	

$choices8a = implode(",",$choices8);//exit;
$choices8a = "'".$choices8a."'";
//$choices8a = str_replace(",","','",$choices8a);
$choices8a = str_replace(",","' or comment_id='",$choices8a);
//$search_query = "select comment_note from infotrack_projects_community_com where comment_id=";

if($level==1)
{
$search_query = "select * from infotrack_projects_community_com where 1 and system_entry_date <= '$today' and (park='$concession_location' or park='dpr')and comment_id=";
}

if($level==5)
{
$search_query = "select * from infotrack_projects_community_com where 1 and system_entry_date <= '$today' and comment_id=";
}



//echo "search_query=$search_query<br />";

//echo "$choices8a<br />";
$order_by=" order by comment_id desc";
$search_query2=$search_query.$choices8a.$order_by;
//echo "search_query2=$search_query2<br />";
$query4b=$search_query2;
//echo "query4b=$query4b<br />";

//exit;

//"select comment_note from infotrack_projects_community_com
//where comment_id='534' or comment_id='552'";
/*
$query1="update crs_tdrr_division_deposits SET";
for($j=0;$j<$num_lines;$j++){
$query2=$query1;
	$query2.=" orms_depositor_lname='$orms_depositor_lname[$j]'";	
	$query2.=" where id='$id[$j]'";	

//echo "query2=$query2";exit;	

//$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}

//echo "Query2 successful<br />";//exit;

$query3="update crs_tdrr_division_deposits,cash_handling_crs_depositors
         set crs_tdrr_division_deposits.orms_depositor=cash_handling_crs_depositors.tempid
		 where crs_tdrr_division_deposits.orms_depositor=''
		 and crs_tdrr_division_deposits.park=cash_handling_crs_depositors.park
		 and crs_tdrr_division_deposits.orms_depositor_lname=cash_handling_crs_depositors.last_name
		 ";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

//echo "Query3 successful<br />";exit;




header("location: bank_deposits_menu_division_final2.php?menu_id=a&menu_selected=y");

*/

 
 ?>

