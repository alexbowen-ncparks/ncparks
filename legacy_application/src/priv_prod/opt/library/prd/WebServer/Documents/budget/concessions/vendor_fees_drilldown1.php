<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}



$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

$concession_admins_beacnum=array(
	'60032793', //Tony Bass's position beacon number, as Div accountant, as of 20210806
	'60032781', //Tammy Dodd's position beacon number, as Div BO Mngr, as of 20210806
	'60036015', //Heidi Rumble's position beacon number, as Div BO staffer
	'65027689'  //John Carter's position beacon number, as Div db-group liason to DPR BO
);


extract($_REQUEST);
//echo "tempid=$tempid";


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "ncas_center=$ncas_center";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
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
$table="concessions_vendor_fees";

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

//include("../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");


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

include ("widget1_concessionaire_fees.php");
//include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";










$query5="SELECT *
FROM $table
WHERE 1 
and vendor_name='$vendor_name'
and f_year='$f_year'
order by ncas_post_date desc ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

//echo "records=$num5"; //exit;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "query5=$query5";
}
*/

//echo "query5=$query5";



$query6="select
         sum(deposit_amount) as 'deposit_amount',
         sum(fee_amount) as 'fee_amount_total',
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
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$num6=mysqli_num_rows($result6);



/*
echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
echo "</table>";
*/echo "<table>";
//echo "<tr><td><font class=cartRow>Park: $park</font></td></tr>";
echo "<tr><td><font class=cartRow>$vendor_name</font></td>";
echo "<td>";
include ("report_header_fiscal3yrhistory.php");
echo "</td>";			   
echo "</tr>";
echo "</table>";
echo "<br />";

//accounting specialist bass, budget officer dodd, accounting tech Heide rumble
if($beacnum=='60032793' or $beacnum=='60032781' or $beacnum=='60036015'){$budget_access='y';}	

//echo "<br />budget_access=$budget_access<br />";
//echo "<br />cy=$cy<br />";
//echo "<br />f_year=$f_year<br />";
//echo "<br /><br />";





/*
echo "<h2 ALIGN=left><font color=red class=cartRow>";   echo "Under Construction. Data still being entered & validated</font></h2>";
*/
//echo "<br />f_year=$f_year<br />";
//echo "<br />fyear=$fyear<br />";
//echo "<br />beacon number = $beacnum<br />";
//if($edit_record=='' and $verify_record=='' and (in_array($beacnum,$concession_admins_beacnum)){
//echo "<table border=5 cellspacing=5>";
if($edit_record=='' and $verify_record==''){
if($budget_access=='y')
{
echo "<table border=5 cellspacing=5>";	
echo "<tr><th><A href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$f_year&ncas_center=$ncas_center&ncas_account=$ncas_account&add_your_own=y'>Add Record</A></th></tr>";	
echo "</table>";
}
if($budget_access!='y' and $cy==$f_year)
{
echo "<table border=5 cellspacing=5>";	
echo "<tr><th><A href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$f_year&ncas_center=$ncas_center&ncas_account=$ncas_account&add_your_own=y'>Add Record</A></th></tr>";	
echo "</table>";
}
//echo "</table>";
}

//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";
if($add_your_own=='y'){
echo "<form  method='post' autocomplete='off' action='vendor_fee_add_record.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Fyear</font></th><th><font color='brown'>Fee<br />Period<br />Month(s)<br /><a href='/budget/concessions/help/fee_period.php' onclick=\"return popitup('/budget/concessions/help/fee_period.php')\">Instructions</a></font></th><th><font color='brown'>Fee</font></th><th><font color='brown'>Check#</font></th><th><font color='brown'>Deposit#</font></th><th><font color='brown'>NCAS<br />center</font></th><th><font color='brown'>NCAS<br />account</font></th>";
if($level>'1'){$concession_center="";}
/*	   
if($level=='5')
{	  echo "<th><font color='brown'>NCAS<br />post_date<br />yyyy-mm-dd<br />ie.2012-05-25</font></th>	   
	   <th><font color='brown'>NCAS<br />invoice_num</font></th></tr>";
}	
*/

// (ncas_account 434196001 Sales Commissions-Marina)  (434196002 Sales Commisions-Special Attractions)  (434150920 Fuel & Vending-Outside Sales)



if($ncas_center=='1680555'){$ncas_account='434150920';}
else
{
if($ncas_center=='1680570' or $ncas_center=='1680571' or $ncas_center=='1680572'){$ncas_account='434196001';} else {$ncas_account='434196002';}
}
//echo "vendor_name=$vendor_name<br /><br />";  
if($vendor_name=='hole_in_the_wall'){$ncas_account='434150920';}
if($vendor_name=='mulligans'){$ncas_account='434150920';}
if($vendor_name=='mikes_bites'){$ncas_account='434150920';}
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='f_year' type='text' size='5' id='f_year' value='$f_year' readonly='readonly' ></td>
			 <td><input name='fee_period' type='text' size='15' id='fee_period'></td> 
             <td><input name='fee_amount' type='text' size='10' id='fee_amount'></td> 
             <td><input name='check_num' type='text' size='10' id='check_num'></td> 
             <td><input name='internal_deposit_num' type='text' size='10' id='internal_deposit_num'></td>              
			 <td><input name='ncas_center' type='text' size='10' id='ncas_center' value='$ncas_center' readonly='readonly'></td> 			 
             <td><input name='ncas_account' type='text' size='10' id='ncas_account' value='$ncas_account' readonly='readonly'></td>";
/*			 
if($level=='5')
{           echo "<td><input name='ncas_post_date' type='text' size='17' id='ncas_post_date'></td>             
             <td><input name='ncas_invoice_num' type='text' size='17' id='ncas_invoice_num'></td>";
}	
*/		 
            echo "<td><input type=submit name=record_insert submit value=add></td>
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	  
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='vendor_name' value='$vendor_name'>";
echo "<input type='hidden' name='tempid' value='$tempid'>";
echo "</form>";	  

	  
}

if($edit_record=='' and $verify_record=='')
{



if($num5==0){echo "<br /><table><tr><td><font class=cartRow>No records for Fiscal Year $f_year</font></td></tr></table>";}
if($num5!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
if($num5==1)
{echo "<br /><table><tr><td><font class=cartRow>$num5 record for Fiscal Year $f_year</font></td></tr></table>";}

if($num5>1)
{echo "<br /><table><tr><td><font class=cartRow>$num5 records for Fiscal Year $f_year</font></td></tr></table>";}

//echo "<br /><table><tr><td><font class=cartRow>$num5 records for Fiscal Year $f_year</font></td></tr></table>";

echo "<table border=1>";

echo 

"<tr> 
       <th align=center><font color=brown>Fyear</font></th>
       <th align=center><font color=brown>Fee<br />Period</font></th>
       <th align=center><font color=brown>Fee</font></th>
	   <th align=center><font color=brown>Check#</font></th>
	   <th align=center><font color=brown>Deposit#</font></th>	   
	   <th align=center><font color=brown>NCAS<br />center</font></th>
       <th align=center><font color=brown>NCAS<br />account</font></th> 
	   <th align=center><font color=brown>Entered by</font></th>
	   <th align=center><font color=brown>DateEntered</font></th>	   
	   <th align=center><font color=brown>Post2<br />NCAS</font></th>
	   <th align=center><font color=brown>NCAS<br />post_date</font></th>
       <th align=center><font color=brown>NCAS<br />invoice_num</font></th>       
       <th align=center><font color=brown>NCAS<br />Verified by</font></th>
       <th align=center><font color=brown>Document</font></th>
       <th></th>
       <th></th>
       
       
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

if($document_location != ""){$document="yes";} else {$document="";}

// 3/4/13: Most records in TABLE=concessions_vendor_fees have been Verified by Bass (Accounting Specialist) which means $verified_by !="". In the future this will be the ONLY IF condition needed to "turn a record" GREEN.
//This means that Accounting Specialist Bass has Verified the completeness & accuracy of User Record & that Receipt of Funds has POSTED to NCAS
// However, since Parks are currently being asked by Budget Officer Dodd to "upload documents"-NEW Requirement and Update NEW Field called "Fee Period", it is currently necessary for 2 additional IF Statements: $document_location != "" and $fee_period !="" to prevent line from turning GREEN.  

//if($verified_by != "" and $document_location != "" and $fee_period != ""){$bgc="lightgreen";} else {$bgc="lightpink";}

if($record_complete=="y"){$bgc="lightgreen";} else {$bgc="lightpink";}

$deposit_amount=number_format($deposit_amount,2);
$fee_amount=number_format($fee_amount,2);
$other_amount=number_format($other_amount,2);
if($system_entry_date != '0000-00-00')
{
$system_entry_date=date('m-d-y', strtotime($system_entry_date));
}
else
{
$system_entry_date='' ;
}
if($ncas_post_date != '0000-00-00')
{$ncas_post_date=date('m-d-y', strtotime($ncas_post_date));}
else
{$ncas_post_date="";}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr bgcolor='$bgc'>

       <td>$f_year</td>
       <td>$fee_period</td>
       <td>$fee_amount</td>
	   <td>$vendor_ck_num</td>
	   <td>$internal_deposit_num</td>	   
	   <td>$ncas_center</td>
       <td>$ncas_account</td> 
	   <td>$entered_by</td>
	   <td>$system_entry_date</td>
	   <td>$post2ncas</td>
	   <td>$ncas_post_date</td>
       <td>$ncas_invoice_num</td>       
       <td>$verified_by</td>";
	   
if($document=="yes" and $record_complete!="y"){
echo "<td><a href='$document_location' target='_blank'>View</a><br /><br /><a href='concessions_vendor_fees_document_add.php?source_id=$id'>Reload</a></td>";}

if($document=="yes" and $record_complete=="y"){
echo "<td><a href='$document_location' target='_blank'>View</a></td>";}



if($document!="yes"){
echo "<td><a href='concessions_vendor_fees_document_add.php?source_id=$id'>Upload</a></td>";} 
	   
	   
	   
   
	   
if($budget_access=='y')
{	
echo "<td><a href='delete_record_concessions_vendor_fees_verify.php?&id=$id'>delete</a></td>";
}	  

if($budget_access!='y')
{	
if($record_complete!="y" and $f_year==$cy)  
{
echo "<td><a href='delete_record_concessions_vendor_fees_verify.php?&id=$id'>delete</a></td>";
}
}

if($budget_access=='y')
{	
echo "<td><a href='vendor_fees_drilldown1.php?&edit_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&id=$id'>edit</a></td>";
}	   

if($budget_access!='y')
{	
if($record_complete!="y" and $f_year==$cy)  
{
echo "<td><a href='vendor_fees_drilldown1.php?&edit_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&id=$id'>edit</a></td>";
}
}	   



/*	   
if($level=='5' and $verified_by==""){
echo "<td><a href='vendor_fees_drilldown1.php?&verify_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&document_location=$document_location&id=$id'>Verify</a></td>";
}
*/
// accounting specialist Bass 
//if(($beacnum=='60032793') and $record_complete!="y")
	

if($budget_access=='y' and $record_complete!="y")
{
echo "<td><a href='vendor_fees_drilldown1.php?&verify_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&document_location=$document_location&id=$id'>Verify</a></td>";
}



                   
}     
           
              
           
echo "</tr>";


//}


while ($row6=mysqli_fetch_array($result6)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row6);
$deposit_amount=number_format($deposit_amount,2);
$fee_amount_total=number_format($fee_amount_total,2);
$other_amount=number_format($other_amount,2);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td>
           <td>Total</td> 	
           <td>$fee_amount_total</td> 
           
           			  
			  
</tr>";

}
 echo "</table>";
 }
 }
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";

 //echo "</body></html>";
if($edit_record=='y')
{
$fee_amount=str_replace(",","",$fee_amount);
echo "<form  method='post'  autocomplete='off' action='edit_record_concession_vendor_fees.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>
	   <th align=center><font color=brown>Fyear</font></th>
	   <th><font color='brown'>Fee<br />Period<br /><a href='/budget/concessions/help/fee_period.php' onclick=\"return popitup('/budget/concessions/help/fee_period.php')\">Instructions</a></font></th>
       <th align=center><font color=brown>Fee</font></th>
	   <th align=center><font color=brown>Check#</font></th>
	   <th align=center><font color=brown>Deposit#</font></th>	   
	   <th align=center><font color=brown>NCAS<br />center</font></th>
       <th align=center><font color=brown>NCAS<br />account</font></th>";
	   
/*	   
if($level=='5')	
{   
	   echo "<th align=center><font color=brown>NCAS<br />post_date</font></th>
       <th align=center><font color=brown>NCAS<br />invoice_num</font></th></tr>"; 
}
*/
	   
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='f_year' type='text' size='5' id='f_year' value='$f_year' readonly='readonly' ></td>
			 <td><input name='fee_period' type='text' size='15' id='fee_period' value='$fee_period'></td>"; 
			 
             echo "<td><input name='fee_amount' type='text' size='10' id='fee_amount' value='$fee_amount' ></td>"; 
						 			 
             echo "<td><input name='check_num' type='text' size='10' id='check_num' value='$vendor_ck_num' ></td>";
			
             echo "<td><input name='internal_deposit_num' type='text' size='10' id='$internal_deposit_num' value='$internal_deposit_num'></td>"; 
			 	 	 
			 
             echo "<td><input name='ncas_center' type='text' size='10' id='ncas_center' value='$ncas_center' readonly='readonly'></td> 			 
             <td><input name='ncas_account' type='text' size='10' id='ncas_account' value='$ncas_account' readonly='readonly'></td>";
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
	 
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='vendor_name' value='$vendor_name'>";
echo "<input type='hidden' name='id' value='$id'>";
	 
	 
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
$query15="select f_year,sum(credit-debit) as 'amount',description,center,acct,acctdate,invoice
         from exp_rev
         where f_year='$f_year' and center='$ncas_center' and acct='$ncas_account'
         group by whid
         order by acctdate desc		 
		 ";

	echo "<br />$query15<br />";//exit;	
	
$result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");
$num15=mysqli_num_rows($result15);	

echo "<br />";
echo "<table><tr><th>Possible Matches: $num15</th></tr></table>";
echo "<table border=1>";

echo 

"<tr> 
       <th align=center><font color=brown>Fyear</font></th>
       <th align=center><font color=brown>Amount<br />Period</font></th>
       <th align=center><font color=brown>Description</font></th>
	   <th align=center><font color=brown>NCAS Center</font></th>
	   <th align=center><font color=brown>NCAS Account</font></th>	
	   <th align=center><font color=brown>NCAS Post Date</font></th>	
	   <th align=center><font color=brown>NCAS Invoice Number</font></th>	
       
       
       
              
</tr>";

while ($row15=mysqli_fetch_array($result15)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row15);
$amount=number_format($amount,2);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td>$f_year</td>
           <td>$amount</td>
           <td>$description</td>
           <td>$center</td>
           <td>$acct</td>
           <td>$acctdate</td>
           <td>$invoice</td>
          
           
           			  
			  
</tr>";

}

}

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














