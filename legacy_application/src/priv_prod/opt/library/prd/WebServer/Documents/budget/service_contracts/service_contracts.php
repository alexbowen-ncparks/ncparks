<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//echo "beacnum=$beacnum<br />";


extract($_REQUEST);
//echo "tempid=$tempid";
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

echo "Line 34=park=$park";


$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");

echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
//echo "<link rel=\"stylesheet\" href=\"test_style_1657.css\" />";
echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker2\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker3\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker4\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker5\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker6\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker7\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";
echo "</head>";



include("../../budget/~f_year.php");




$table="service_contracts";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection,$query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection,$query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);


$query11a="update service_contracts 
           set pending_budget_approval='n' where 1 ";

$result11a=mysqli_query($connection,$query11a) or die ("Couldn't execute query 11a. $query11a");

$row11a=mysqli_fetch_array($result11a);

extract($row11a);

/*
$query11b="update service_contracts,service_contracts_invoices 
           set service_contracts.pending_budget_approval='y' 
           where service_contracts.id=service_contracts_invoices.scid
           and service_contracts_invoices.park_approved='y'
           and (service_contracts_invoices.puof = '' or service_contracts_invoices.buof = '')  ";
		   */
		   
$query11b="update service_contracts,service_contracts_invoices 
           set service_contracts.pending_budget_approval='y' 
           where service_contracts.id=service_contracts_invoices.scid
           and service_contracts_invoices.park_approved='y'
           and service_contracts_invoices.puof = ''  ";		   
		   
		   
		   
		   

$result11b=mysqli_query($connection,$query11b) or die ("Couldn't execute query 11b. $query11b");

$row11b=mysqli_fetch_array($result11b);

extract($row11b);




$query12a="update service_contracts 
           set pending_park_approval='n' where 1 ";

$result12a=mysqli_query($connection,$query12a) or die ("Couldn't execute query 12a. $query12a");

$row12a=mysqli_fetch_array($result12a);

extract($row12a);



$query12b="update service_contracts,service_contracts_invoices 
           set service_contracts.pending_park_approval='y' 
           where service_contracts.id=service_contracts_invoices.scid
           and service_contracts_invoices.park_approved='n'
            ";

$result12b=mysqli_query($connection,$query12b) or die ("Couldn't execute query 12b. $query12b");

$row12b=mysqli_fetch_array($result12b);

extract($row12b);



if($level != 1)
{
$query11c="select count(id) as 'pending_budget_approval_count' from service_contracts where pending_budget_approval='y' ";
}

if($level == 1)
{
$query11c="select count(id) as 'pending_park_approval_count' from service_contracts where pending_park_approval='y' and park='$concession_location' ";
}



$result11c=mysqli_query($connection,$query11c) or die ("Couldn't execute query 11c. $query11c");

$row11c=mysqli_fetch_array($result11c);

extract($row11c);



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


//include("../../budget/menus2.php");


//include ("widget1.php");
/*
include("../../budget/menu1314.php");
include("widget2.php");
*/

include ("../../budget/menu1415_v1_new.php");
//echo "<br />Line 206<br />";
if($edit_record=='y')
{
$query10="SELECT * from service_contracts where id='$id' ";

$result10=mysqli_query($connection,$query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);
echo "<form  method='post'  autocomplete='off' action='edit_record_service_contracts.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	  echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th><td><input name='park' type='text' size='5' id='park' value='$park' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Contract Type</font></th><td><input name='type' type='text' size='30' id='type' value='$type' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   //echo "<th><font color='brown'>Comments</font></th><td><input name='comments' type='text' size='30' id='comments' value='$comments' ></td>"; 
	   echo "<th><font color='brown'>Contract Purpose</font></th><td><textarea rows='6' cols='70' name='purpose'>$purpose</textarea></td>"; 
	   echo "</tr>";
	  /*
	   echo "<tr>";
	   echo "<th><font color='brown'>Contract Administrator</font></th><td><input name='contract_administrator' type='text' size='30' id='contract_administrator' value='$contract_administrator' ></td>";
	   echo "</tr>";
	  */
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Contractor Name</font></th><td><input name='vendor' type='text' size='35' id='vendor' value='$vendor' ></td>";
	   echo "</tr>";
	   
	   /*
	    echo "<tr>";
	   //echo "<th><font color='brown'>Comments</font></th><td><input name='comments' type='text' size='30' id='comments' value='$comments' ></td>"; 
	   echo "<th><font color='brown'>Contractor-Remit to Address</font></th><td><textarea rows='6' cols='70' name='remit_address'>$remit_address</textarea></td>"; 
	   echo "</tr>";
	   */
	   
	    echo "<tr>";
	   echo "<th><font color='brown'>Contractor-FID#</font></th><td><input name='fid_num' type='text' size='15' id='fid_num' value='$fid_num'></td> ";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Contractor-Group#</font></th><td><input name='group_num' type='text' size='15' id='group_num' value='$group_num'></td> ";
	   echo "</tr>";
	   
	   	   
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Contract Num</font></th><td><input name='contract_num' type='text' size='15' id='contract_num' value='$contract_num' ></td> ";	   
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Number</font></th><td><input name='po_num' type='text' size='25' id='po_num' value='$po_num' ></td> ";
	   echo "</tr>";
	   
	    echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Number</font></th><td><input name='line_num' type='text' size='15' id='line_num' value='$line_num' ></td> ";
	   echo "</tr>";
	   
	   
	    echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Company</font></th><td><input name='company' type='text' size='15' id='company' value='$company' ></td> ";
	   echo "</tr>";
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Account</font></th><td><input name='ncas_account' type='text' size='15' id='ncas_account' value='$ncas_account' ></td> ";
	   echo "</tr>";
	   
	   	   	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Center</font></th><td><input name='center' type='text' size='15' id='center' value='$center'></td> ";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Original Balance</font></th><td><input name='line_num_beg_bal' type='text' size='15' id='line_num_beg_bal' value='$line_num_beg_bal'></td> ";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Buy Entity</font></th><td><input name='buy_entity' type='text' size='15' id='buy_entity' value='$buy_entity'></td> ";
	   echo "</tr>";
	   
	  
	   
	   
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Monthly Cost</font></th><td><input name='monthly_cost' type='text' size='15' id='monthly_cost' value='$monthly_cost' ></td>";	   
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Yearly Cost</font></th><td><input name='yearly_cost' type='text' size='15' id='yearly_cost' value='$yearly_cost' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Original Contract Date</font></th><td><input name='original_contract_date' type='text' size='15' id='original_contract_date' value='$original_contract_date' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Original Contract Date2</font></th><td><input name='original_contract_date2' type='text' size='15' id='datepicker' value='$original_contract_date2' ></td>";
	   echo "</tr>";
	   
	   
	   
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>First Renewal Requested</font></th><td><input name='first_renewal_requested' type='text' size='15' id='first_renewal_requested' value='$first_renewal_requested' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>First Renewal Date</font></th><td><input name='first_renewal_date' type='text' size='15' id='first_renewal_date' value='$first_renewal_date' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>First Renewal Date2</font></th><td><input name='first_renewal_date2' type='text' size='15' id='datepicker2' value='$first_renewal_date2' ></td>";
	   echo "</tr>";
	   
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Second Renewal Requested</font></th><td><input name='second_renewal_requested' type='text' size='15' id='second_renewal_requested' value='$second_renewal_requested' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Second/Final Renewal Date</font></th><td><input name='second_final_renewal_date' type='text' size='15' id='second_final_renewal_date' value='$second_final_renewal_date' ></td>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Second/Final Renewal Date2</font></th><td><input name='second_final_renewal_date2' type='text' size='15' id='datepicker3' value='$second_final_renewal_date2' ></td>";
	   echo "</tr>";
	   
	   
	   
	   
	   echo "<tr>";
	   //echo "<th><font color='brown'>Comments</font></th><td><input name='comments' type='text' size='30' id='comments' value='$comments' ></td>"; 
	   echo "<th><font color='brown'>Comments</font></th><td><textarea rows='6' cols='70' name='comments'>$comments</textarea></td>"; 
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Active Contract</font></th><td><input name='active' type='text' size='5' value='$active'></td>"; 
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>ID</font></th><td><input name='id' type='text' size='5' id='id' value='$id' readonly='readonly'></td>"; 
	   echo "</tr>";
	   
	   echo "<td><input type=submit name=submit  value=update_record></td>";
	   echo "</tr>";
		echo "</table>";	  
	   
	 
	 
	  echo "</form>";
	  
exit;}










//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection,$query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

/*
echo "<br /><table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><font color='brown'></b>Cash Imprest </font>(Monthly)-<font color='green'>$center_location</font></b></th></tr></table>";
*/


echo "<br /><table align='center'><tr><th><img height='75' width='75' src='dumpster1.jpg' alt='picture of fuel tank'></img><font color='brown'></b>Park Service Contracts</font></b></th></tr></table>";









/*
$query5="SELECT *
FROM $table
WHERE 1 
and vendor_name='$vendor_name'
and f_year='$f_year'
order by ncas_post_date desc ";
*/


/* moved after include: status_header_service_contracts.php on 1/24/16
if($level==1)
{
$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location'
order by park,vendor";
}

if($level!=1)
{
$query5="SELECT *
FROM $table
WHERE 1 
order by park,vendor";
}






$result5 = mysqli_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

*/


//echo "records=$num5";exit;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "query5=$query5";
}
*/
/*
$query6="select
         sum(deposit_amount) as 'deposit_amount',
         sum(fee_amount) as 'fee_amount',
		 sum(other_amount) as 'other_amount'
		 from $table where 1 
        and vendor_name='$vendor_name'
        and f_year='$f_year'		
		 ";
		 
		 
		 
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query6";//exit;	
}
*/
/*	
$result6 = mysqli_query($query6) or die ("Couldn't execute query 6.  $query6");
$num6=mysqli_num_rows($result6);
*/


/*
echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
echo "</table>";
*/
/*
echo "<table><tr><td><font class=cartRow>Park: $park</font></td></tr>
               <tr><td><font class=cartRow>Vendor: $vendor_name</font></td>";
			   
			   */
//echo "<td>";
//include ("report_header_fiscal3yrhistory.php");
//echo "</td>";			   
//echo "</tr>";
//echo "</table>";
//echo "<br />";
/*
echo "<h2 ALIGN=left><font color=red class=cartRow>";   echo "Under Construction. Data still being entered & validated</font></h2>";
*/
if($level!=1)
{
echo "<table border=5 cellspacing=5>";

if($edit_record=='' and $verify_record==''){
echo "<tr><th><A href='service_contracts.php?add_your_own=y'>Add Record</A></th></tr>";	
} 	  
echo "</table>";
}
//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";
if($add_your_own=='y'){
echo "<form  method='post' autocomplete='off' action='service_contract_add_record.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th><td><input name='park' type='text' size='25' id='park'></td>";
	   echo "</tr>";
	   /*
	   echo "<tr>";
	   echo "<th><font color='brown'>Contract Type</font></th><td><input name='type' type='text' size='25' id='type'></td>";
	   echo "</tr>";
	   */
	  echo "<tr>";
	  echo "<th>Contract Type</th>";
	  echo "<td>";
	  echo "<select name='contract_type'>
	        <option value=''></option>
            <option value='original'>Original</option>
            <option value='first_renewal'>First Renewal</option>
            <option value='second_renewal'>Second Renewal</option>
            </select>";
		echo "</td>";
        echo "</tr>";   
	   
	   echo "<tr>";
	  echo "<th>Service Type</th>";
	  echo "<td>";
	  echo "<select name='service_type'>
	        <option value=''></option>
			<option value='pest_control'>Pest Control</option>
			 <option value='portajon'>Port A Jon</option>
			 <option value='septic_pumping'>Septic Pumping</option>
			 <option value='waste_debirs'>Waste Debris</option>
            <option value='waste_normal'>Waste Normal</option>           
            <option value='water_testing'>Water Testing</option>           
            </select>";
		echo "</td>";
        echo "</tr>";   
	   
	   
	   
	   
	   
	   
	    //echo "<tr>";
	   //echo "<th><font color='brown'>Comments</font></th><td><input name='comments' type='text' size='30' id='comments' value='$comments' ></td>"; 
	   /*
	   echo "<th><font color='brown'>Contract Purpose</font></th><td><textarea rows='6' cols='70' name='purpose'></textarea></td>"; 
	   echo "</tr>";
	   */
	   /*
	   echo "<tr>";
	   echo "<th><font color='brown'>Contract Administrator</font></th><td><input name='contract_administrator' type='text' size='30' id='contract_administrator'  ></td>";
	   echo "</tr>";
	   */
	   echo "<tr>";
	   echo "<th><font color='brown'>Contractor Name</font></th><td><input name='vendor' type='text' size='25' id='vendor'></td>";
	   echo "</tr>";
	   /*
	   echo "<tr>";
	   //echo "<th><font color='brown'>Comments</font></th><td><input name='comments' type='text' size='30' id='comments' value='$comments' ></td>"; 
	   echo "<th><font color='brown'>Contractor-Remit to Address</font></th><td><textarea rows='6' cols='70' name='remit_address'></textarea></td>"; 
	   echo "</tr>";
	   */
	   /*
	    echo "<tr>";
	   echo "<th><font color='brown'>Contractor-FID#</font></th><td><input name='fid_num' type='text' size='15' id='fid_num' ></td> ";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Contractor-Group#</font></th><td><input name='group_num' type='text' size='15' id='group_num' ></td> ";
	   echo "</tr>";
	   */
	   echo "<tr>";
	   echo "<th><font color='brown'>Contract Num</font><td><input name='contract_num' type='text' size='25' id='contract_num'></td></th>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Number</font></th><td><input name='po_num' type='text' size='25' id='po_num'></td>";
	   echo "</tr>";
	   
	   /*
	    echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Number</font></th><td><input name='line_num' type='text' size='15' id='line_num'  ></td> ";
	   echo "</tr>";
	   */
	   
	   /*
	    echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Company</font></th><td><input name='company' type='text' size='15' id='company' ></td> ";
	   echo "</tr>";
	   */
	   
	   /*
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Account</font></th><td><input name='ncas_account' type='text' size='15' id='ncas_account'  ></td> ";
	   echo "</tr>";
	   */
	     
	   /*
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Line-Center</font></th><td><input name='center' type='text' size='15' id='center' ></td> ";
	   echo "</tr>";
	   */
	  
	    echo "<tr>";
	   echo "<th><font color='brown'>PO Original Grand Total</font></th><td><input name='original_total' type='text' size='15' id='original_total' ></td> ";
	   echo "</tr>";
	  
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Buy Entity</font></th><td><input name='buy_entity' type='text' size='15' id='buy_entity' ></td> ";
	   echo "</tr>";
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Monthly Cost</font></th><td><input name='monthly_cost' type='text' size='25' id='monthly_cost'></td>";
	   echo "</tr>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Yearly Cost</font></th><td><input name='yearly_cost' type='text' size='25' id='yearly_cost'></td>";
	   echo "</tr>";
	   
	   /*
	    echo "<tr>";
	   echo "<th><font color='brown'>Second/Final Renewal Date2</font></th><td><input name='second_final_renewal_date2' type='text' size='15' id='datepicker3' value='$second_final_renewal_date2' ></td>";
	   echo "</tr>";
	   */
	   
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Original Contract Start Date</font></th><td><input name='original_contract_start_date' type='text' size='25' id='datepicker4'></td>";
	   echo "</tr>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Original Contract End Date</font></th><td><input name='original_contract_end_date' type='text' size='25' id='datepicker5'></td>";
	   echo "</tr>";
	   
	   
	   
	   /*
	   echo "<tr>";	  
	   echo "<th><font color='brown'>First Renewal Requested</font></th><td><input name='first_renewal_requested' type='text' size='25' id='first_renewal_requested'></td>";
	   echo "</tr>";
	   */
	   echo "<tr>";
	   echo "<th><font color='brown'>Initiate Renewal Bid<br />(90 days prior to end of Original Contract End Date)</font></th><td><input name='first_renewal_date' type='text' size='25'  readonly='readonly'></td>";
	   echo "</tr>";
	   /*
	   echo "<tr>";
	   echo "<th><font color='brown'>Second Renewal Requested</font></th><td><input name='second_renewal_requested' type='text' size='25' id='second_renewal_requested'></td>";
	   echo "</tr>";
	   */
	   /*
	   echo "<tr>";
	   echo "<th><font color='brown'>Initiate Second/Final Renewal Date</font></th><td><input name='second_final_renewal_date' type='text' size='25' id='datepicker7'></td>";
	   echo "</tr>";
	   */
	   echo "<tr>";
	   //echo "<th><font color='brown'>Comments</font></th><td><input name='comments' type='text' size='25' id='comments'></td>"; 
	   echo "<th><font color='brown'>Comments</font></th><td><textarea rows='4' cols='50' name='comments'></textarea></td>"; 
	   echo "</tr>";
	   
	   
	   
/*	  
   
	   echo "<tr bgcolor='$table_bg2'>";
	   echo "<td><input name='park' type='text' size='15' id='park'></td>"; 
	   echo "<td><input name='center' type='text' size='15' id='center'></td>"; 
	   echo "<td><input name='type' type='text' size='15' id='type'></td>"; 
	   echo "<td><input name='contract_num' type='text' size='15' id='contract_num'></td>"; 
	   echo "<td><input name='po_num' type='text' size='15' id='po_num'></td>"; 
	   echo "<td><input name='vendor' type='text' size='15' id='vendor'></td>"; 
	   echo "<td><input name='monthly_cost' type='text' size='15' id='monthly_cost'></td>"; 
	   echo "<td><input name='yearly_cost' type='text' size='15' id='yearly_cost'></td>"; 
	   echo "<td><input name='original_contract_date' type='text' size='15' id='original_contract_date'></td>"; 
	   echo "<td><input name='first_renewal_requested' type='text' size='15' id='first_renewal_requested'></td>"; 
	   echo "<td><input name='first_renewal_date' type='text' size='15' id='first_renewal_date'></td>"; 
	   echo "<td><input name='second_renewal_requested' type='text' size='15' id='second_renewal_requested'></td>"; 
	   echo "<td><input name='second_renewal_date' type='text' size='15' id='second_renewal_date'></td>"; 
	   echo "<td><input name='comments' type='text' size='15' id='comments'></td>"; 
	  
 */            
	 
            echo "<tr><th><input type=submit name=record_insert submit value=add></th></tr>";
echo "</table>";			

echo "</form>";	  

	  
}


include("status_header_service_contracts.php");
if($pending_budget_approval_count > 0 and $level != 1)
{
echo "<table align='center'><tr><th><font size='6'><img height='50' width='50' src='/budget/infotrack/icon_photos/info1.png' alt='picture of fuel tank'></img>Invoices Pending Budget Office Approval: $pending_budget_approval_count<br /><a href='service_contracts.php?pen=y'>VIEW</a></font></th></tr></table>";
}

if($pending_park_approval_count > 0 and $level == 1)
{
echo "<table align='center'><tr><th><font size='6'><img height='50' width='50' src='/budget/infotrack/icon_photos/info1.png' alt='picture of fuel tank'></img>Invoices Pending Park Approval: $pending_park_approval_count</font></th></tr></table>";
}



// 60032781-Budget Officer (Dodd)   60032791-Purchasing Officer (Hunt)
if($beacnum=='60032781' or $beacnum=='60032791')
{echo "<table><tr><td><form action='service_contracts.php'>
  Park: <input type='text' name='parkS' value='$parkS' autocomplete='off'><br>
  <input type='hidden' name='status_active' value='$status_active'>
  <input type='submit' value='Submit'>
</form></td></tr></table>";
}





if($level==1)
{
$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location'
and active='$status_active'
order by park,vendor";
}

if($pen=='y' and $level==1){$pen_items=" and pending_park_approval='y' ";}
if($pen=='y' and $level!=1){$pen_items=" and pending_budget_approval='y' ";}

if($level!=1)
{
if($parkS=='')
{
$query5="SELECT *
FROM $table
WHERE 1 
and active='$status_active'
$pen_items
order by park,vendor";
}

if($parkS!='')
{
$query5="SELECT *
FROM $table
WHERE 1 
and active='$status_active'
and park='$parkS'
$pen_items
order by park,vendor";
}


}


//echo "query5=$query5<br />";

$result5 = mysqli_query($connection,$query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);


if($edit_record=='' and $verify_record=='')
{



if($num5==0){echo "<br /><table><tr><td><font class=cartRow>No records </font></td></tr></table>";}
if($num5!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
if($num5==1)
{echo "<br /><table><tr><td><font class=cartRow>$num5 record </font></td></tr></table>";}

if($num5>1)
{echo "<br /><table><tr><td><font class=cartRow>$num5 records </font></td></tr></table>";}

//echo "<br /><table><tr><td><font class=cartRow>$num5 records for Fiscal Year $f_year</font></td></tr></table>";

echo "<table border=1>";

echo 

"<tr> 
       <th align=center><font color=brown>ID</font></th>
       <th align=center><font color=brown>Active</font></th>
       <th align=center><font color=brown>Park</font></th>
       <th align=center><font color=brown>Center</font></th>
       <th align=center><font color=brown>Type</font></th>
	   <th align=center><font color=brown>Vendor</font></th>
	   <th align=center><font color=brown>Contract Num</font></th>
	   <th align=center><font color=brown>PO Num</font></th>	   
	   <th align=center><font color=brown>PO Line</font></th>   
	   <th align=center><font color=brown>PO Line<br />(Begin Balance)</font></th>  
	   <th align=center><font color=brown>PO Line<br />Total Paid (Old Method)</font></th>";	   
	   //echo "<th align=center><font color=brown>Fyear</font></th>";	   
       echo "<th align=center><font color=brown>Monthly Cost</font></th> 
	   <th align=center><font color=brown>Yearly Cost</font></th>
	   <th align=center><font color=brown>Original Contract Date</font></th>	   
	   <th align=center><font color=brown>Original Contract Date2</font></th>	   
	   <th align=center><font color=brown>First Renewal Requested</font></th>
	   <th align=center><font color=brown>First Renewal Date</font></th>
       <th align=center><font color=brown>Second Renewal Requested</font></th>       
       <th align=center><font color=brown>Second Final Renewal Date</font></th>
       <th align=center><font color=brown>Comments</font></th>";
       

	   if($level!=1)
	   {
      echo "<th align=center><font color=brown>Original Contract</font></th>
       <th align=center><font color=brown>Renewal Letter</font></th>";
       }
       
       
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$line_num_beg_bal_verified_date2_success='';
if($document_location != ""){$document="yes";} else {$document="";}
if($document_renewal != ""){$doc_renewal="yes";} else {$doc_renewal="";}
if($line_num_beg_bal_verified_date=='0000-00-00'){$line_num_beg_bal_verified_date2='';}
if($line_num_beg_bal_verified_date!='0000-00-00')
{$line_num_beg_bal_verified_date2=date('m/d/y', strtotime($line_num_beg_bal_verified_date));
$line_num_beg_bal_verified_date2_success=" <img height='30' width='30' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of fuel tank'></img>";
}

{$line_num_beg_bal_verified_date=date('m-d-y', strtotime($ncas_post_date));}
// 3/4/13: Most records in TABLE=concessions_vendor_fees have been Verified by Bass (Accounting Specialist) which means $verified_by !="". In the future this will be the ONLY IF condition needed to "turn a record" GREEN.
//This means that Accounting Specialist Bass has Verified the completeness & accuracy of User Record & that Receipt of Funds has POSTED to NCAS
// However, since Parks are currently being asked by Budget Officer Dodd to "upload documents"-NEW Requirement and Update NEW Field called "Fee Period", it is currently necessary for 2 additional IF Statements: $document_location != "" and $fee_period !="" to prevent line from turning GREEN.  

//if($verified_by != "" and $document_location != "" and $fee_period != ""){$bgc="lightgreen";} else {$bgc="lightpink";}

//if($record_complete=="y"){$bgc="lightgreen";} else {$bgc="lightpink";}

$deposit_amount=number_format($deposit_amount,2);
$fee_amount=number_format($fee_amount,2);
$other_amount=number_format($other_amount,2);
$system_entry_date=date('m-d-y', strtotime($system_entry_date));
if($ncas_post_date != '0000-00-00')
{$ncas_post_date=date('m-d-y', strtotime($ncas_post_date));}
else
{$ncas_post_date="";}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
/*
if($edit_id != '' and $id==$edit_id)
{$t=" bgcolor='salmon'"; $image_verify=" <img src='/budget/infotrack/icon_photos/green_checkmark1.png' height='25' width='25'>";}
else {$t="";$image_verify="";}
*/

if($edit_id != '' and $id==$edit_id)
{$image_verify=" <img src='/budget/infotrack/icon_photos/green_checkmark1.png' height='40' width='40'>";}
else {$image_verify="";}
$pending_approval_icon = '';
if($level==1 and $pending_park_approval=='y'){$pending_approval_icon=" <img src='/budget/infotrack/icon_photos/info1.png' height='40' width='40'>";}


if($level!=1 and $pending_budget_approval=='y'){$pending_approval_icon=" <img src='/budget/infotrack/icon_photos/info1.png' height='40' width='40'>";}

echo"<tr$t>";

if($record_complete!="y")  
	  
       {echo "<td>";
	   
	   
	   // 60032781-Budget Officer (Dodd)   60032791-Purchasing Officer (Hunt)
	   if($beacnum=='60032791' or $beacnum=='60032781')
	   {
	   /*
	   echo "<a href='service_contracts.php?&edit_record=y&park=$park&center=$center&type=$type&contract_num=$contract_num&po_num=$po_num&vendor=$vendor&monthly_cost=$monthly_cost&yearly_cost=$yearly_cost&original_contract_date=$original_contract_date&first_renewal_requested=$first_renewal_requested&first_renewal_date=$first_renewal_date&second_renewal_requested=$second_renewal_requested&second_renewal_date=$second_final_renewal_date&comments=$comments&active=$active&id=$id'>edit</a><br />";
	   */
	   echo "<form action=service_contracts.php>";
	   echo "<input type='hidden' name='edit_record' value='y'>";
	   echo "<input type='hidden' name='id' value='$id'>";
	   echo "<input type='submit' name='submit' value='Edit'>";
	   echo "</form>";   
	   }
	    echo "$id $image_verify</td>";}



echo "
       <td align='center'>$active</td>
       <td>$park</td>
       <td>$center</td>
       <td>$type</td>
	   <td><font color='brown'>$vendor</font></td>
       <td>$contract_num</td>
       <td>$po_num</td>       
       <td>$line_num</td>       
       <td>$line_num_beg_bal $line_num_beg_bal_verified_date2_success<br /><font color='brown'>$line_num_beg_bal_verified_by</font><br /><font color='brown'>$line_num_beg_bal_verified_date2</font></td>     
       <td>$total_paid_old_method $line_num_beg_bal_verified_date2_success<br /><font color='brown'>$line_num_beg_bal_verified_by</font><br /><font color='brown'>$line_num_beg_bal_verified_date2</font></td>";       
     //echo "<td>$fyear</td>";       
       echo "<td>$monthly_cost";
	   	   
	   // 60032781-Budget Officer (Dodd)   60032791-Purchasing Officer (Hunt)  60033169-MOMO OA (Ake)   60033171-MOMO PASU (Anundson)
	   //if($beacnum=='60032781' or $beacnum=='60032791' or $beacnum=='60033169' or $beacnum=='60033171')
	   //{
	   echo "<br /><a href='/budget/service_contracts/all_invoices.php?report_type=reports&id=$id'>Invoices $pending_approval_icon</a>";
	   //}
       echo "</td>";
       echo "<td>$yearly_cost</td>
       <td>$original_contract_date</td>
	   <td>$original_contract_date2</td>
       <td>$first_renewal_requested</td>
       <td>$first_renewal_date</td>
       <td>$second_renewal_requested</td>
       <td>$second_final_renewal_date</td>
       <td>$comments</td>
       
       
	   ";
	   
if($level!=1)
{
	   
if($document=="yes" and $record_complete!="y"){
echo "<td><a href='$document_location' target='_blank'>View</a><br /><br /><a href='service_contract_document_add.php?source_id=$id'>Reload</a></td>";}

if($doc_renewal=="yes" and $record_complete!="y"){
echo "<td><a href='$document_renewal' target='_blank'>View</a><br /><br /><a href='sc_doc_renewal_add.php?source_id=$id'>Reload</a></td>";}




/*
if($document=="yes" and $record_complete=="y"){
echo "<td><a href='$document_location' target='_blank'>View</a></td>";}
*/



if($document!="yes"){
echo "<td><a href='service_contract_document_add.php?source_id=$id'>Upload</a></td>";} 

if($doc_renewal!="yes"){
echo "<td><a href='sc_doc_renewal_add.php?source_id=$id'>Upload</a></td>";} 



	   
	   
	   
	   
	   
//if($post2ncas!='y' or $level=='5')	{ 
if($record_complete!="y")  
      {echo"<td><a href='delete_record_service_contracts_verify.php?&id=$id'>delete</a></td>";}
	  
/*	 moved to first column on 1/24/16 
if($record_complete!="y")  
	  
       {echo "<td><a href='service_contracts.php?&edit_record=y&park=$park&center=$center&type=$type&contract_num=$contract_num&po_num=$po_num&vendor=$vendor&monthly_cost=$monthly_cost&yearly_cost=$yearly_cost&original_contract_date=$original_contract_date&first_renewal_requested=$first_renewal_requested&first_renewal_date=$first_renewal_date&second_renewal_requested=$second_renewal_requested&second_renewal_date=$second_final_renewal_date&comments=$comments&id=$id'>edit</a></td>";}
*/	   
	   
	   
}
/*	   
if($level=='5' and $verified_by==""){
echo "<td><a href='service_contracts.php?&verify_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&document_location=$document_location&id=$id'>Verify</a></td>";
}
*/
/*
if($level=='5' and $record_complete!="y"){
echo "<td><a href='service_contracts.php?&verify_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&document_location=$document_location&id=$id'>Verify</a></td>";
}
*/
                   
}     
           
              
           
echo "</tr>";


//}

/*
while ($row6=mysqli_fetch_array($connection,$result6)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row6);
$deposit_amount=number_format($deposit_amount,2);
$fee_amount=number_format($fee_amount,2);
$other_amount=number_format($other_amount,2);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td>
           <td>Total</td> 	
           <td>$fee_amount</td> 
           
           			  
			  
</tr>";

}
*/
 echo "</table>";
 }
 }
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";

 //echo "</body></html>";

/*
if($verify_record=='y')
{

echo "<form  method='post'  autocomplete='off' action='verify_record_concession_vendor_fees.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>
	   <th align=center><font color=brown>Fyear</font></th>
	   <th><font color='brown'>Fee<br />Period<br /><a href='/budget/concessions/help/fee_period.php' onclick=\"return popitup('/budget/concessions/help/fee_period.php')\">Instructions</a></font></th>
       <th align=center><font color=brown>Fee</font></th>
	   <th align=center><font color=brown>Check#</font></th>
	   <th align=center><font color=brown>Deposit#</font></th>	   
	   <th align=center><font color=brown>NCAS<br />center</font></th>
       <th align=center><font color=brown>NCAS<br />account</font></th>
       <th align=center><font color=brown>Verify<br />Document</font></th>
       <th align=center><font color=brown>NCAS<br />Post<br />Date</font></th>
       <th align=center><font color=brown>NCAS<br />Invoice<br />Number</font></th>
       ";
 */      
	   
/*	   
if($level=='5')	
{   
	   echo "<th align=center><font color=brown>NCAS<br />post_date</font></th>
       <th align=center><font color=brown>NCAS<br />invoice_num</font></th></tr>"; 
}
*/
/*	   
	   echo "<tr bgcolor='$table_bg2'>
	         <td>$f_year</td>
			 <td>$fee_period</td> 
             <td>$fee_amount</td> 
             <td>$vendor_ck_num</td> 
             <td>$internal_deposit_num</td> 
             <td>$ncas_center</td> 			 
             <td>$ncas_account</td>
             <td><a href='$document_location' target='_blank'>";
			 if($document_location!=""){echo "view";}
			 
			 echo "</a></td>
             <td><input name='ncas_post_date' type='text' size='10' id='ncas_post_date' value='$ncas_post_date'></td>
             <td><input name='ncas_invoice_num' type='text' size='10' id='ncas_invoice_num' value='$ncas_invoice_num'></td>
            ";
*/
/*			 
if($level=='5')	
{		 
			echo "<td><input name='ncas_post_date' type='text' size='13' id='ncas_post_date' value='$ncas_post_date'></td>			 
             <td><input name='ncas_invoice_num' type='text' size='17' id='ncas_invoice_num' value='$ncas_invoice_num'></td>";
}	
*/		 
/*			 
            echo "<td><input type=submit name=submit  value=Verify_record></td>
			  </tr>";
		echo "</table>";	  
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	 
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='ncas_center' value='$ncas_center'>";
echo "<input type='hidden' name='vendor_name' value='$vendor_name'>";
echo "<input type='hidden' name='f_year' value='$f_year'>";
echo "<input type='hidden' name='id' value='$id'>";
	 
	 
	  echo "</form>";
	  
}
*/


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














