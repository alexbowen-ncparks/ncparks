<?php

session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];


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
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

include("../../../budget/~f_year.php");

$table="bank_deposits";

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
include ("test_style.php");

include("../../../budget/menu1314.php");
//include("menu1314_cash_receipts.php");
//include("../../../budget/menus2.php");
//exit;

//include ("widget1.php");

//include("widget2.php");
include ("park_deposits_report_menu_final.php");

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";



if($level<2)
{
$query5="SELECT *
FROM $table
WHERE 1 and center='$concession_center'
order by bank_deposit_date desc";
}

if($level==2)

{

//$dist_where=" and dist='west' and fund='1280' and actcenteryn='y' ";



if($level==2 and $pcode=='EADI'){$dist_where=" and dist='east' and fund='1280' and actcenteryn='y' ";}

if($level==2 and $pcode=='NODI'){$dist_where=" and dist='north' and fund='1280' and actcenteryn='y' and center.parkcode != 'mtst' and center.parkcode != 'harp' ";}

if($level==2 and $pcode=='SODI'){$dist_where=" and dist='south' and fund='1280' and actcenteryn='y' and center.parkcode != 'boca' ";}

if($level==2 and $pcode=='WEDI'){$dist_where=" and dist='west' and fund='1280' and actcenteryn='y' ";}



if($level==2){$dist_join=" left join center on bank_deposits.park=center.parkcode ";}

if($sortA=='')
{
$query5="SELECT *
FROM $table
$dist_join
WHERE 1 $dist_where 
order by park asc, bank_deposit_date desc";
//echo "query5=$query5";
}

}

if($level==3)
{
$query5="SELECT *
FROM $table
WHERE 1 and center='$concession_center'
order by bank_deposit_date desc";
}

if($level>3)
{
if($sortA=='')
{
$query5="SELECT *
FROM $table
WHERE 1 
order by id desc";
}
else
{
$query5="SELECT *
FROM $table
WHERE 1 
order by park asc,deposit_id desc ";
}
}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);


$query5a="SELECT  DISTINCT concat( parkcode, '-', center_desc ) AS 'parkcode'
FROM crj_centers
where 1 
ORDER BY parkcode";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");
while ($row5a=mysqli_fetch_array($result5a))
	{
	$tnArray[]=$row5a['parkcode'];
	}
//source for datepicker: http://jqueryui.com/datepicker/
echo "<html lang=\"en\">
<head>
<meta charset=\"utf-8\" />
<title>jQuery UI Datepicker - Default functionality</title>
<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker2\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker3\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker4\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";

echo "<table border=5 cellspacing=5>";
if($edit_record=='' and $verify_record==''){
//echo "<tr><th><A href='bank_deposits.php?add_your_own=y'>Add Record</A></th></tr>";	
} 	  
echo "</table>";

//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";
if($level>3)
{
if($add_your_own=='y'){
//echo "<form  method='post' autocomplete='off' action='bank_deposits_add_record.php'>";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='bank_deposits_add_record.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th>";
	   //echo "<th><font color='brown'>Center</font></th>";
	   echo "<th><font color='brown'>Deposit ID</font></th>";
	   echo "<th><font color='brown'>Deposit Amount</font></th>";
	   echo "<th><font color='brown'>Bank Deposit Date</font></th>";
	   echo "<th><font color='brown'>Collection Start Date</font></th>";
	   echo "<th><font color='brown'>Collection End Date</font></th>";
	   echo "<th><font color='brown'>BO Receipt Date</font></th>";
	   echo "<th><font color='brown'>Locate File</font></th>";
	   //echo "<th><font color='brown'>Upload File</font></th>";
	   echo "<th><font color='brown'>Add Record</font></th>";
	   
	   
	   
	   echo "</tr>";
   
	   echo "<tr bgcolor='$table_bg2'>";
	   //echo "<td><input name='park' type='text' size='15' id='park'></td>"; 
	   echo "<td><select name=\"park\"><option></option>"; 
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];
//if($player_view_menu==$con){$s="selected";}else{$s="value";}
//if($park==$con){$s="selected";}else{$s="value";}
		//echo "<option $s='$con'>$tnArray[$n]\n";
		echo "<option>$tnArray[$n]\n";
       }
   echo "</select></td>"; 
	   //echo "<td><input name='center' type='text' size='15' id='center'></td>"; 
	   echo "<td><input name='deposit_id' type='text' size='15' id='deposit_id'></td>"; 
	   echo "<td><input name='deposit_amount' type='text' size='15' id='deposit_amount'></td>"; 
	   echo "<td><input name='bank_deposit_date' type='text' id='datepicker' size='15'></td>"; 
	   echo "<td><input name='collection_start_date' type='text' id='datepicker2' size='15'></td>"; 
	   echo "<td><input name='collection_end_date' type='text' id='datepicker3' size='15'></td>"; 
	   echo "<td><input name='bo_receipt_date' type='text' id='datepicker4' size='15'></td>"; 
	   echo "<td><input type='file' id='document' name='document'>
                 <input type='hidden' name='user_name' value='$myusername' />
                 <input type='hidden' name='content_mode' value='$content_mode' />
                 <input type='hidden' name='MAX_FILE_SIZE' value='20000000'></td>";

      // echo "<td><input type='submit' name='submit' value='submit' ></td>";
	  
             
	 
            echo "<td><input type=submit name=record_insert submit value=add></td>
			  </tr>";

	  echo "</table>";
	  

echo "</form>";	  

	  
}
}
if($edit_record=='' and $verify_record=='')
{
if($alt_view==""){$switch='y';}
if($alt_view=="y"){$switch='';}


if($level>'3'){echo "<table border='3'><tr><td><a href='bank_deposits.php?add_your_own=y&sortA=y&alt_view=$alt_view'>Sort by Park</td><td><a href='bank_deposits.php?add_your_own=y&alt_view=$switch'>Alternate View</td> </tr></table>";}

if($num5==0){echo "<br /><table><tr><td><font  color=red>No Cash Receipt Journal Documents </font></td></tr></table>";}
if($num5!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
if($num5==1)
{echo "<br /><table><tr><td><font  color=red>Cash Receipt Journal Documents: $num5</font></td></tr></table>";}

if($num5>1)
{echo "<br /><table><tr><td><font  color=red>Cash Receipt Journal Documents: $num5  </font></td></tr></table>";}

//echo "<br /><table><tr><td><font class=cartRow>$num5 records for Fiscal Year $f_year</font></td></tr></table>";

echo "<table border=1>";

echo 

"<tr>"; 
      
  echo "<th><font color='brown'>Park</font></th>";
	   echo "<th><font color='brown'>Center</font></th>";
	   echo "<th><font color='brown'>Deposit_ID</font></th>";
	   echo "<th><font color='brown'>Deposit Amount</font></th>";
	   echo "<th><font color='brown'>Bank Deposit Date</font></th>";
	   echo "<th><font color='brown'>Collection Start Date</font></th>";
	   echo "<th><font color='brown'>Collection End Date</font></th>";
	   echo "<th><font color='brown'>BO Receipt Date</font></th>";      
	   echo "<th><font color='brown'>NCAS Post Date</font></th>";      
	   echo "<th><font color='brown'>Entered By</font></th>";      
	   echo "<th><font color='brown'>BO Comments</font></th>";      
	   echo "<th><font color='brown'>Document</font></th>";      
	   echo "<th><font color='brown'>ID</font></th>";      
       
       
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

if($document_location != ""){$document="yes";} else {$document="";}
if($document_renewal != ""){$doc_renewal="yes";} else {$doc_renewal="";}
if($post_date=="0000-00-00"){$post_date="";}
if($collection_start_date=="0000-00-00"){$collection_start_date="";}
if($collection_end_date=="0000-00-00"){$collection_end_date="";}
// 3/4/13: Most records in TABLE=concessions_vendor_fees have been Verified by Bass (Accounting Specialist) which means $verified_by !="". In the future this will be the ONLY IF condition needed to "turn a record" GREEN.
//This means that Accounting Specialist Bass has Verified the completeness & accuracy of User Record & that Receipt of Funds has POSTED to NCAS
// However, since Parks are currently being asked by Budget Officer Dodd to "upload documents"-NEW Requirement and Update NEW Field called "Fee Period", it is currently necessary for 2 additional IF Statements: $document_location != "" and $fee_period !="" to prevent line from turning GREEN.  

//if($verified_by != "" and $document_location != "" and $fee_period != ""){$bgc="lightgreen";} else {$bgc="lightpink";}

//if($record_complete=="y"){$bgc="lightgreen";} else {$bgc="lightpink";}

$deposit_amount=number_format($deposit_amount,2);
$park=strtoupper($park);

//$fee_amount=number_format($fee_amount,2);
//$other_amount=number_format($other_amount,2);
$system_entry_date=date('m-d-y', strtotime($system_entry_date));
/*
if($bank_deposit_date != '0000-00-00')
{$bank_deposit_date=date('m-d-y', strtotime($bank_deposit_date));}
else
{$bank_deposit_date="";}

if($bo_receipt_date != '0000-00-00')
{$bo_receipt_date=date('m-d-y', strtotime($bo_receipt_date));}
else
{$bo_receipt_date="";}

*/


//if($post2ncas == "y"){$bgc="lightgreen";} else {$bgc="lightpink";}


if($alt_view == "y")
{
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';} 
}
else
{
if($post2ncas == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
}



//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';} 10/22/13

echo 

"<tr$t>

       <td>$park</td>
       <td>$center</td>
       <td>$deposit_id</td>
       <td>$deposit_amount</td>
       <td>$bank_deposit_date</td>
       <td>$collection_start_date</td>
       <td>$collection_end_date</td>
       <td>$bo_receipt_date</td>       
       <td>$post_date</td>       
       <td>$entered_by</td>       
       <td>$bo_comments</td>       
       <td><a href='$document_location'>View</td>       
       <td>$id</td>
       
	   ";
/*	   
if($document=="yes" and $record_complete!="y"){
echo "<td><a href='$document_location' target='_blank'>View</a><br /><br /><a href='service_contract_document_add.php?source_id=$id'>Reload</a></td>";}

if($doc_renewal=="yes" and $record_complete!="y"){
echo "<td><a href='$document_renewal' target='_blank'>View</a><br /><br /><a href='sc_doc_renewal_add.php?source_id=$id'>Reload</a></td>";}
*/



/*
if($document=="yes" and $record_complete=="y"){
echo "<td><a href='$document_location' target='_blank'>View</a></td>";}
*/


/*
if($document!="yes"){
echo "<td><a href='service_contract_document_add.php?source_id=$id'>Upload</a></td>";} 

if($doc_renewal!="yes"){
echo "<td><a href='sc_doc_renewal_add.php?source_id=$id'>Upload</a></td>";} 
*/


	   
	   
	   
	   
	   
//if($post2ncas!='y' or $level=='5')	{ 

if($level>3)
{
echo"<td><a href='delete_record_bank_deposits_verify.php?&id=$id'>delete</a></td>";
	  
echo "<td><a href='bank_deposits.php?&edit_record=y&park=$park&deposit_id=$deposit_id&deposit_amount=$deposit_amount&bank_deposit_date=$bank_deposit_date&collection_start_date=$collection_start_date&collection_end_date=$collection_end_date&bo_receipt_date=$bo_receipt_date&id=$id'>edit</a></td>";
}
/*	   
if($level=='5' and $verified_by==""){
echo "<td><a href='bank_deposits.php?&verify_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&document_location=$document_location&id=$id'>Verify</a></td>";
}
*/
/*
if($level=='5' and $record_complete!="y"){
echo "<td><a href='bank_deposits.php?&verify_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&document_location=$document_location&id=$id'>Verify</a></td>";
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

echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='edit_record_bank_deposits.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	  echo "<tr>";
echo "<th><font color='brown'>Park</font></th>";
	   echo "<th><font color='brown'>Deposit_ID</font></th>";
	   echo "<th><font color='brown'>Deposit Amount</font></th>";
	   echo "<th><font color='brown'>Bank Deposit Date</font></th>";
	   echo "<th><font color='brown'>Collection Start Date</font></th>";
	   echo "<th><font color='brown'>Collection End Date</font></th>";
	   echo "<th><font color='brown'>BO Receipt Date</font></th>"; 	   
	   echo "<th><font color='brown'>Locate File</font></th>"; 	   
	   echo "<th><font color='brown'>Update Record</font></th>"; 	   
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
	         <td><input name='deposit_id' type='text' size='15' id='deposit_id' value='$deposit_id' ></td>
	         <td><input name='deposit_amount' type='text' size='15' id='deposit_amount' value='$deposit_amount' ></td>
	         <td><input name='bank_deposit_date' type='text' size='15' id='datepicker' value='$bank_deposit_date' ></td>
	         <td><input name='collection_start_date' type='text' size='15' id='datepicker2' value='$collection_start_date' ></td>
	         <td><input name='collection_end_date' type='text' size='15' id='datepicker3' value='$collection_end_date' ></td>			 
	         <td><input name='bo_receipt_date' type='text' size='15' id='datepicker4' value='$bo_receipt_date' ></td>";
			 echo "<td><input type='file' id='document' name='document'>
                 <input type='hidden' name='user_name' value='$myusername' />
                 <input type='hidden' name='content_mode' value='$content_mode' />
                 <input type='hidden' name='MAX_FILE_SIZE' value='20000000'></td>";
             
           
/*			 
if($level=='5')	
{		 
			echo "<td><input name='ncas_post_date' type='text' size='13' id='ncas_post_date' value='$ncas_post_date'></td>			 
             <td><input name='ncas_invoice_num' type='text' size='17' id='ncas_invoice_num' value='$ncas_invoice_num'></td>";
}	
*/		 
			 
            echo "<td><input type=submit name=submit  value=update_record></td>";
			
			echo " <td><input name='id' type='text' size='5' id='id' value='$id' readonly='readonly'></td>";
			echo "</tr>";
		echo "</table>";	  
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	 
//echo "<input type='hidden' name='park' value='$park'>";
//echo "<input type='hidden' name='vendor_name' value='$vendor_name'>";
//echo "<input type='hidden' name='id' value='$id'>";
	 
	 // echo "<input type='hidden' name='id' value='$id'>";
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



















	














