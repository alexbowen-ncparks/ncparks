<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



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
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

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
$table="service_contracts";

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


include("../../../budget/menus2.php");


//include ("widget1.php");

include("widget2.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";









/*
$query5="SELECT *
FROM $table
WHERE 1 
and vendor_name='$vendor_name'
and f_year='$f_year'
order by ncas_post_date desc ";
*/

$query5="SELECT *
FROM $table
WHERE 1 
order by park,vendor";







$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

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
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
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
echo "<table border=5 cellspacing=5>";
if($edit_record=='' and $verify_record==''){
echo "<tr><th><A href='service_contracts.php?add_your_own=y'>Add Record</A></th></tr>";	
} 	  
echo "</table>";

//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";
if($add_your_own=='y'){
echo "<form  method='post' autocomplete='off' action='service_contract_add_record.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th>";
	   echo "<th><font color='brown'>Center</font></th>";
	   echo "<th><font color='brown'>Type</font></th>";
	   echo "<th><font color='brown'>Contract Num</font></th>";
	   echo "<th><font color='brown'>PO Num</font></th>";
	   echo "<th><font color='brown'>Vendor</font></th>";
	   echo "<th><font color='brown'>Monthly Cost</font></th>";
	   echo "<th><font color='brown'>Yearly Cost</font></th>";
	   echo "<th><font color='brown'>Original Contract Date</font></th>";
	   echo "<th><font color='brown'>First Renewal Requested</font></th>";
	   echo "<th><font color='brown'>First Renewal Date</font></th>";
	   echo "<th><font color='brown'>Second Renewal Requested</font></th>";
	   echo "<th><font color='brown'>Second/Final Renewal Date</font></th>";
	   echo "<th><font color='brown'>Comments</font></th>"; 
	   
	   
	   
	   echo "</tr>";
   
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
	  
             
	 
            echo "<td><input type=submit name=record_insert submit value=add></td>
			  </tr>";

	  echo "</table>";
	  

echo "</form>";	  

	  
}

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
       <th align=center><font color=brown>Park</font></th>
       <th align=center><font color=brown>Center</font></th>
       <th align=center><font color=brown>Type</font></th>
	   <th align=center><font color=brown>Contract Num</font></th>
	   <th align=center><font color=brown>PO Num</font></th>	   
	   <th align=center><font color=brown>Vendor</font></th>
       <th align=center><font color=brown>Monthly Cost</font></th> 
	   <th align=center><font color=brown>Yearly Cost</font></th>
	   <th align=center><font color=brown>Original Contract Date</font></th>	   
	   <th align=center><font color=brown>First Renewal Requested</font></th>
	   <th align=center><font color=brown>First Renewal Date</font></th>
       <th align=center><font color=brown>Second Renewal Requested</font></th>       
       <th align=center><font color=brown>Second Final Renewal Date</font></th>
       <th align=center><font color=brown>Comments</font></th>
       <th align=center><font color=brown>ID</font></th>	   
       <th align=center><font color=brown>Original Contract</font></th>
       <th align=center><font color=brown>Renewal Letter</font></th>
       
       
       
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

if($document_location != ""){$document="yes";} else {$document="";}
if($document_renewal != ""){$doc_renewal="yes";} else {$doc_renewal="";}

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

echo 

"<tr$t>

       <td>$park</td>
       <td>$center</td>
       <td>$type</td>
       <td>$contract_num</td>
       <td>$po_num</td>
       <td>$vendor</td>
       <td>$monthly_cost</td>
       <td>$yearly_cost</td>
       <td>$original_contract_date</td>
       <td>$first_renewal_requested</td>
       <td>$first_renewal_date</td>
       <td>$second_renewal_requested</td>
       <td>$second_final_renewal_date</td>
       <td>$comments</td>
       <td>$id</td>
       
	   ";
	   
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
	  
	  
if($record_complete!="y")  
	  
       {echo "<td><a href='service_contracts.php?&edit_record=y&park=$park&center=$center&type=$type&contract_num=$contract_num&po_num=$po_num&vendor=$vendor&monthly_cost=$monthly_cost&yearly_cost=$yearly_cost&original_contract_date=$original_contract_date&first_renewal_requested=$first_renewal_requested&first_renewal_date=$first_renewal_date&second_renewal_requested=$second_renewal_requested&second_renewal_date=$second_final_renewal_date&comments=$comments&id=$id'>edit</a></td>";}

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


while ($row6=mysqli_fetch_array($result6)){

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
 echo "</table>";
 }
 }
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";

 //echo "</body></html>";
if($edit_record=='y')
{

echo "<form  method='post'  autocomplete='off' action='edit_record_service_contracts.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	  echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th>";
	   echo "<th><font color='brown'>Center</font></th>";
	   echo "<th><font color='brown'>Type</font></th>";
	   echo "<th><font color='brown'>Contract Num</font></th>";
	   echo "<th><font color='brown'>PO Num</font></th>";
	   echo "<th><font color='brown'>Vendor</font></th>";
	   echo "<th><font color='brown'>Monthly Cost</font></th>";
	   echo "<th><font color='brown'>Yearly Cost</font></th>";
	   echo "<th><font color='brown'>Original Contract Date</font></th>";
	   echo "<th><font color='brown'>First Renewal Requested</font></th>";
	   echo "<th><font color='brown'>First Renewal Date</font></th>";
	   echo "<th><font color='brown'>Second Renewal Requested</font></th>";
	   echo "<th><font color='brown'>Second/Final Renewal Date</font></th>";
	   echo "<th><font color='brown'>Comments</font></th>"; 
	   echo "<th><font color='brown'>ID</font></th>"; 
	   
/*	   
if($level=='5')	
{   
	   echo "<th align=center><font color=brown>NCAS<br />post_date</font></th>
       <th align=center><font color=brown>NCAS<br />invoice_num</font></th></tr>"; 
}
*/
	   
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='park' type='text' size='5' id='park' value='$park' ></td>
			 <td><input name='center' type='text' size='15' id='center' value='$center'></td> 
             <td><input name='type' type='text' size='15' id='type' value='$type' ></td> 
             <td><input name='contract_num' type='text' size='15' id='contract_num' value='$contract_num' ></td> 
             <td><input name='po_num' type='text' size='15' id='$po_num' value='$po_num' ></td> 
             <td><input name='vendor' type='text' size='15' id='vendor' value='$vendor' ></td> 			 
             <td><input name='monthly_cost' type='text' size='15' id='monthly_cost' value='$monthly_cost' ></td>
             <td><input name='yearly_cost' type='text' size='15' id='yearly_cost' value='$yearly_cost' ></td>
             <td><input name='original_contract_date' type='text' size='15' id='original_contract_date' value='$original_contract_date' ></td>
             <td><input name='first_renewal_requested' type='text' size='15' id='first_renewal_requested' value='$first_renewal_requested' ></td>
             <td><input name='first_renewal_date' type='text' size='15' id='first_renewal_date' value='$first_renewal_date' ></td>
             <td><input name='second_renewal_requested' type='text' size='15' id='second_renewal_requested' value='$second_renewal_requested' ></td>
             <td><input name='second_renewal_date' type='text' size='15' id='second_renewal_date' value='$second_renewal_date' ></td>
             <td><input name='comments' type='text' size='30' id='comments' value='$comments' ></td>
             <td><input name='id' type='text' size='5' id='id' value='$id' readonly='readonly'></td>";
/*			 
if($level=='5')	
{		 
			echo "<td><input name='ncas_post_date' type='text' size='13' id='ncas_post_date' value='$ncas_post_date'></td>			 
             <td><input name='ncas_invoice_num' type='text' size='17' id='ncas_invoice_num' value='$ncas_invoice_num'></td>";
}	
*/		 
			 
            echo "<td><input type=submit name=submit  value=update_record></td>
			  </tr>";
		echo "</table>";	  
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	 
//echo "<input type='hidden' name='park' value='$park'>";
//echo "<input type='hidden' name='vendor_name' value='$vendor_name'>";
//echo "<input type='hidden' name='id' value='$id'>";
	 
	 
	  echo "</form>";
	  
}

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
       
	   
/*	   
if($level=='5')	
{   
	   echo "<th align=center><font color=brown>NCAS<br />post_date</font></th>
       <th align=center><font color=brown>NCAS<br />invoice_num</font></th></tr>"; 
}
*/
	   
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
/*			 
if($level=='5')	
{		 
			echo "<td><input name='ncas_post_date' type='text' size='13' id='ncas_post_date' value='$ncas_post_date'></td>			 
             <td><input name='ncas_invoice_num' type='text' size='17' id='ncas_invoice_num' value='$ncas_invoice_num'></td>";
}	
*/		 
			 
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



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














