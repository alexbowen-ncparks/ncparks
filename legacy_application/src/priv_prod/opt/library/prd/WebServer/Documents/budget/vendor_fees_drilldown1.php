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
echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";


include("../../budget/menus2.php");


include ("widget1.php");

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

//echo "records=$num5";exit;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "query5=$query5";
}
*/

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
*/echo "<table><tr><td><font class=cartRow>Park: $park</font></td></tr>
               <tr><td><font class=cartRow>Vendor: $vendor_name</font></td>";
echo "<td>";
include ("report_header_fiscal3yrhistory.php");
echo "</td>";			   
echo "</tr>";
echo "</table>";
echo "<br />";
/*
echo "<h2 ALIGN=left><font color=red class=cartRow>";   echo "Under Construction. Data still being entered & validated</font></h2>";
*/
echo "<table border=5 cellspacing=5>";
if($edit_record==''){
echo "<tr><th><A href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$f_year&ncas_center=$ncas_center&ncas_account=$ncas_account&add_your_own=y'>Add Record</A></th></tr>";	
} 	  
echo "</table>";

//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";
if($add_your_own=='y'){
echo "<form  method='post' autocomplete='off' action='vendor_fee_add_record.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Fyear</font></th><th><font color='brown'>Fee<br />Period<a href='/budget/admin/weekly_updates/stepG8a1_matches.php' onclick=\"return popitup('/budget/admin/weekly_updates/stepG8a1_matches.php')\">Possible Matches</a></font></th><th><font color='brown'>Fee</font></th><th><font color='brown'>Check#</font></th><th><font color='brown'>Deposit#</font></th><th><font color='brown'>NCAS<br />center</font></th><th><font color='brown'>NCAS<br />account</font></th>";
if($level>'1'){$concession_center="";}
/*	   
if($level=='5')
{	  echo "<th><font color='brown'>NCAS<br />post_date<br />yyyy-mm-dd<br />ie.2012-05-25</font></th>	   
	   <th><font color='brown'>NCAS<br />invoice_num</font></th></tr>";
}	
*/
if($ncas_center=='12802902' or $ncas_center=='12802903' or $ncas_center=='12802904'){$ncas_account='434196001';} else {$ncas_account='434196002';}
   
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='f_year' type='text' size='5' id='f_year' value='$f_year' readonly='readonly' ></td>
			 <td><input name='fee_period' type='text' size='10' id='fee_period'></td> 
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

if($edit_record=='')
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
	   <th align=center><font color=brown>Post2<br />NCAS</font></th>
	   <th align=center><font color=brown>NCAS<br />post_date</font></th>
       <th align=center><font color=brown>NCAS<br />invoice_num</font></th>       
       <th align=center><font color=brown>Verified by</font></th>
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
$deposit_amount=number_format($deposit_amount,2);
$fee_amount=number_format($fee_amount,2);
$other_amount=number_format($other_amount,2);
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>

       <td>$f_year</th>
       <td>$fee_period</th>
       <td>$fee_amount</th>
	   <td>$vendor_ck_num</th>
	   <td>$internal_deposit_num</th>	   
	   <td>$ncas_center</th>
       <td>$ncas_account</th> 
	   <td>$entered_by</th>
	   <td>$post2ncas</th>
	   <td>$ncas_post_date</th>
       <td>$ncas_invoice_num</th>       
       <td>$verified_by</th>";
if($post2ncas!='y' or $level=='5')	{   
      echo"<td><a href='delete_record_concessions_vendor_fees_verify.php?&id=$id'>delete</a></td>
       <td><a href='vendor_fees_drilldown1.php?&edit_record=y&park=$park&vendor_name=$vendor_name&f_year=$f_year&fee_amount=$fee_amount&vendor_ck_num=$vendor_ck_num&internal_deposit_num=$internal_deposit_num&ncas_post_date=$ncas_post_date&ncas_center=$ncas_center&ncas_account=$ncas_account&ncas_invoice_num=$ncas_invoice_num&fee_period=$fee_period&post2ncas=$post2ncas&id=$id'>edit</a></td>";}
              
                    
      
           
              
           
echo "</tr>";


}


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

echo "<form  method='post'  autocomplete='off' action='edit_record_concession_vendor_fees.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>
	   <th align=center><font color=brown>Fyear</font></th>
	   <th align=center><font color=brown>Fee<br />Period</font></th>
       <th align=center><font color=brown>Fee</font></th>
	   <th align=center><font color=brown>Check#</font></th>
	   <th align=center><font color=brown>Deposit#</font></th>	   
	   <th align=center><font color=brown>NCAS<br />center</font></th>
       <th align=center><font color=brown>NCAS<br />account</font></th>";
if($level=='5')	
{   
	   echo "<th align=center><font color=brown>NCAS<br />post_date</font></th>
       <th align=center><font color=brown>NCAS<br />invoice_num</font></th></tr>"; 
}
	   
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='f_year' type='text' size='5' id='f_year' value='$f_year' readonly='readonly' ></td>
			 <td><input name='fee_period' type='text' size='10' id='fee_period' value='$fee_period'></td> 
             <td><input name='fee_amount' type='text' size='10' id='fee_amount' value='$fee_amount'></td> 
             <td><input name='check_num' type='text' size='10' id='check_num' value='$vendor_ck_num'></td> 
             <td><input name='internal_deposit_num' type='text' size='10' id='$internal_deposit_num' value='$internal_deposit_num'></td> 
             <td><input name='ncas_center' type='text' size='10' id='ncas_center' value='$ncas_center' readonly='readonly'></td> 			 
             <td><input name='ncas_account' type='text' size='10' id='ncas_account' value='$ncas_account' readonly='readonly'></td>";
			 
if($level=='5')	
{		 
			echo "<td><input name='ncas_post_date' type='text' size='13' id='ncas_post_date' value='$ncas_post_date'></td>			 
             <td><input name='ncas_invoice_num' type='text' size='17' id='ncas_invoice_num' value='$ncas_invoice_num'></td>";
}			 
			 
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

 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














