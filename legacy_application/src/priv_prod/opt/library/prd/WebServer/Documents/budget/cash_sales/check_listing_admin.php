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
$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


if($delrecC=='y')
{
$query="update crs_tdrr_division_deposits_checklist
        set delrec='y' where id='$delID' ";		  
	  
		  
//echo "query=$query"; //exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query ");

$delrec_message="<font color='red'>Record ID: $delID has been deleted</font>";

}

$cashier=$tempid;
if($fiscal_year==''){$fiscal_year='1819';}


 
 echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style_overshort.php");
echo "<style>";
echo "#table1{
width:800px;
	margin-left:auto; 
    margin-right:auto;
	}";
echo "</style>";
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
});
</script>";

echo "</head>";

//include("../../../budget/menu1314_tony.html");


 
 echo "<br />";
 echo "<br />";

//if($edit=='y')
	


if($menu_check=='edit_record')
{
	

	
echo "<table align='center'><tr><th>EDIT RECORD</th></tr></table>";
echo "<table border=1 id='table1'>";

echo "<tr>"; 
 
     
echo "<th align=left><font color=brown>Receipt Date</font></th>";
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
//rumble and dodd
if($beacnum=='60036015' or $beacnum=='60032781')
{	
echo "<th align=left><font color=brown>Description</font></th>";
}
      
       
              
echo "</tr>";

$query0="select check_receipt_date as 'check_receipt_dateE',checknum as 'checknumE',payor as 'payorE',payor_bank as 'payor_bankE',amount as 'amountE',description as 'descriptionE',f_year as 'f_yearE'  from crs_tdrr_division_deposits_checklist
          where id='$edit_id' ";
		 
echo "query0=$query0<br />";		 

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);



echo  "<form method='post' autocomplete='off' action='check_listing_admin_update.php'>";


 echo "<tr>";

echo "<td><input type='text' name='check_receipt_date' value='$check_receipt_dateE' id='datepicker' size='15'></td>";  
//echo "<td><input type='text' name='check_receipt_date[]' value='$check_receipt_date'></td>";                      
echo "<td><input type='text' name='checknum' value='$checknumE'></td>";                      
//echo "<td><input type='text' name='payor' value='$payorE'></td>"; 
 echo "<td><textarea rows='2' cols='25' name='payor'>$payorE</textarea></td>";                      
//echo "<td><input type='text' name='payor_bank' value='$payor_bankE'></td>";  
echo "<td><textarea rows='2' cols='25' name='payor_bank'>$payor_bankE</textarea></td>";                     
echo "<td><input type='text' name='amount' value='$amountE'></td>";                      
//echo "<td><input type='text' name='f_year' value='$f_yearE'></td>"; 

if($beacnum=='60036015' or $beacnum=='60032781')
{	                   
//echo "<td><input type='text' name='description' value='$descriptionE'></td>"; 
 echo "<td><textarea rows='2' cols='25' name='description'>$descriptionE</textarea></td>";  
} 
           
echo "</tr>";

//}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";

//echo "<input type='hidden' name='f_year' value='$fiscal_year'>";
echo "<input type='hidden' name='cashier' value='$cashier'>";
echo "<input type='hidden' name='f_year' value='$f_yearE'>";
echo "<input type='hidden' name='budget_office' value='y'>";
echo "<input type='hidden' name='edit_id' value='$edit_id'>";
echo "<input type='hidden' name='menu_check' value='edit_record'>";
echo "<input type='hidden' name='edit_record' value='yes'>";
 
  echo "</table>";

 echo "</form>";






exit;

	
	
}



if($menu_check=='add')
 {
 $system_entry_date=date("Ymd");
 //rebecca owen and rachel gooding and tammy dodd and heide rumble
 if($beacnum == '60033242' or $beacnum=='60032997' or $beacnum=='60032781' or $beacnum=='60036015')
 {
 echo "<table border=1 id='table1'>";

echo "<tr>"; 
 
     
echo "<th align=left><font color=brown>Receipt Date</font></th>";
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";

      
       
              
echo "</tr>";


echo  "<form method='post' autocomplete='off' action='check_listing_admin_update.php'>";


 echo "<tr>";

echo "<td><input type='text' name='check_receipt_date' value='$check_receipt_date' id='datepicker' size='15'></td>";  
//echo "<td><input type='text' name='check_receipt_date[]' value='$check_receipt_date'></td>";                      
echo "<td><input type='text' name='checknum' value='$checknum'></td>";                      
//echo "<td><input type='text' name='payor' value='$payor'></td>";                      
echo "<td><textarea rows='2' cols='25' name='payor'>$payor</textarea></td>";                      
//echo "<td><input type='text' name='payor_bank' value='$payor_bank'></td>"; 
 echo "<td><textarea rows='2' cols='25' name='payor_bank'>$payor_bank</textarea></td>";                     
echo "<td><input type='text' name='amount' value='$amount'></td>";                      
             
           
echo "</tr>";

//}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";

echo "<input type='hidden' name='f_year' value='$fiscal_year'>";
echo "<input type='hidden' name='cashier' value='$cashier'>";
echo "<input type='hidden' name='budget_office' value='y'>";
echo "<input type='hidden' name='menu_check' value='add'>";
 
  echo "</table>";

 echo "</form>";
 
 
 //echo "<pre>";print_r($checknum);"</pre>";//exit;
 }
 
if($update=='yes')
	
{
$query15="select checknum,payor,payor_bank,amount,description,check_receipt_date,cashier,id from crs_tdrr_division_deposits_checklist
          where budget_office='y' and check_receipt_date='$check_receipt_date'  and delrec='n' order by id desc";		  
//}		  
		  
//echo "query15=$query15";//exit;
$result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15 ");
$num15=mysqli_num_rows($result15);		 
	 
	 
//echo "<br />num15=$num15<br />";		
//echo "query15=$query15";//exit;
$result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15 ");
$num15=mysqli_num_rows($result15);		 
	 
	 
//echo "<br />num15=$num15<br />";	 

echo "<br />";
 
 
if($num15 != '0')
{	


echo "<table border=1 align='center'>";
echo "<tr><th>CheckListing</th></tr>";
echo "</table>";
echo "<table border=1 align='center'>";

echo "<tr>"; 
echo "<th align=left><font color=brown>Receipt Date</font></th>";
echo "<th align=left><font color=brown>Entered By</font></th>";
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
echo "<th align=left><font color=brown>Description</font></th>";
echo "</tr>";
}

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row15=mysqli_fetch_array($result15)){
 
extract($row15);
 
$payor=htmlspecialchars_decode($payor); 
$payor_bank=htmlspecialchars_decode($payor_bank); 
$description=htmlspecialchars_decode($description); 
 if($check_receipt_date=='0000-00-00'){$check_receipt_date='';}
 
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
	   
echo "<td>$check_receipt_date</td>";                      
echo "<td>$cashier</td>";                      
echo "<td>$checknum</td>";                      
//echo "<td>$checknum</td>";                      
echo "<td>$payor</td>";                      
echo "<td>$payor_bank</td>";                      
 echo "<td>$amount</td>";                         
echo "<td>$description</td>";    
              
echo "<td>";
 echo "<form method='post' autocomplete='off' action='page2_form.php'>";
 echo "<input type='hidden' name='check_receipt_dateE' value='$check_receipt_date'>";
// echo "<input type='hidden' name='cashier2E' value='$cashier2'>";
 echo "<input type='hidden' name='checknumE' value='$checknum'>";
 echo "<input type='hidden' name='payorE' value='$payor'>";
 echo "<input type='hidden' name='payor_bankE' value='$payor_bank'>";
 echo "<input type='hidden' name='amountE' value='$amount'>";
 echo "<input type='hidden' name='f_yearE' value='$f_year'>";
 //echo "<input type='hidden' name='edit_id' value='$id'>";
 echo "<input type='hidden' name='edit_id' value='$id'>";
 echo "<input type='hidden' name='menu_check' value='edit_record'>";
 echo "<input type='submit' name='submit3' value='Edit'>";
 echo "</form>";
 echo "$id";
 echo "</td>";  
       
              
           
echo "</tr>";




}

  echo "</table>";		
		
}



 }
 
 if($menu_check=='search')
 {
	 
	 
 echo "<table border=1 id='table1'>";

echo "<tr>"; 
 
     
echo "<th align=left><font color=brown>Receipt Date</font></th>";
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";

      
       
              
echo "</tr>";


echo  "<form method='post' autocomplete='off' action='page2_form.php'>";


 echo "<tr>";

echo "<td><input type='text' name='check_receipt_date' value='$check_receipt_date' id='datepicker' size='15'></td>";  
//echo "<td><input type='text' name='check_receipt_date[]' value='$check_receipt_date'></td>";                      
echo "<td><input type='text' name='checknum' value='$checknum'></td>";                      
echo "<td><input type='text' name='payor' value='$payor'></td>";                      
echo "<td><input type='text' name='payor_bank' value='$payor_bank'></td>";                      
echo "<td><input type='text' name='amount' value='$amount'></td>";                      
             
           
echo "</tr>";

//}

echo "<tr>";
echo "<td>SEARCH ALL Checks-DPR<input type='checkbox' name='search_all' value='y' ></td>";
echo "<td colspan='7' align='right'><input type='submit' name='submit2' value='Search'></td>";
echo "</tr>";

echo "<input type='hidden' name='f_year' value='$fiscal_year'>";
echo "<input type='hidden' name='cashier' value='$cashier'>";
echo "<input type='hidden' name='budget_office' value='y'>";
echo "<input type='hidden' name='edit' value='y'>";
echo "<input type='hidden' name='menu_check' value='search'>";
 
  echo "</table>";

 echo "</form>"; 
	 
	 
	 
	 
/*
$query11="select checknum,payor,payor_bank,amount,description,check_receipt_date from crs_tdrr_division_deposits_checklist
          where f_year='$fiscal_year' and budget_office='y' and bo_deposit_complete='n' order by id desc";
		  */
//if($submit2=='Search')
//{	
//if($check_receipt_date != '')
//{
	
if($submit2=='Search')
{
//echo "<br />search_all=$search_all<br />";	
if($check_receipt_date=='' and $checknum=='' and $payor=='' and $payor_bank=='' and $amount=='' and $delrec!='y')
{	
$query11="select checknum,payor,payor_bank,amount,description,check_receipt_date,cashier,id,f_year,controllers_deposit_id from crs_tdrr_division_deposits_checklist
          where budget_office='y' and delrec='n'  order by id desc";	

//echo "<br />Line 415: query11=$query11<br />";			  
//}		  
}
else
{
if($check_receipt_date != ''){$where1=" and check_receipt_date='$check_receipt_date' ";}
if($checknum != ''){$where2=" and checknum='$checknum'  ";}
if($payor != ''){$where3=" and payor like '%$payor%'  ";}
if($payor_bank != ''){$where4=" and payor_bank like '%$payor_bank%'  ";}
if($amount != ''){$where5=" and amount='$amount'  ";}

if($delrec != 'y')
{
//echo "<br />search_all=$search_all<br />";	
	
if($search_all != 'y')
{	
$query11="select checknum,payor,payor_bank,amount,description,check_receipt_date,cashier,id,controllers_deposit_id from crs_tdrr_division_deposits_checklist
          where budget_office='y' $where1 $where2 $where3 $where4 $where5  and delrec='n' order by id desc";
		  
//echo "<br />Line 431: query11=$query11<br />";		  
}

if($search_all == 'y')
{	
$query11="select checknum,payor,payor_bank,amount,description,check_receipt_date,cashier,id,controllers_deposit_id from crs_tdrr_division_deposits_checklist
        where 1 $where1 $where2 $where3 $where4 $where5  and delrec='n' order by id desc";
		  
		  
//echo "<br />Line 440: query11=$query11<br />";			  
}




}

if($delrec == 'y')
{
$query11="select checknum,payor,payor_bank,amount,description,check_receipt_date,cashier,id,controllers_deposit_id from crs_tdrr_division_deposits_checklist
          where 1 and id='$delID' order by id desc";
		  
echo "<br />Line 455: query11=$query11<br />";
		  
		  
}






}	
//echo "query11=$query11";//exit;
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
$num11=mysqli_num_rows($result11);		 
	 
	 
//echo "<br />num11=$num11<br />";	 


 
 
if($num11 != '0')
{	


echo "<table align='center'>";
if($num11 == 1)
{
echo "<tr><td><font color='brown'>Check Search Results:</font> <font color='red'>($num11 Record)</font><br />$delrec_message</td></tr>";
}

if($num11 !=1)
{
echo "<tr><td><font color='brown'>Check Search Results:</font> <font color='red'>($num11 Records)</font><br />$delrec_message</td></tr>";
}



echo "</table>";
echo "<br />";
echo "<table border=1 align='center'>";

echo "<tr>"; 
echo "<th align=left><font color=brown>Receipt Date</font></th>";
echo "<th align=left><font color=brown>Entered By</font></th>";
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
echo "<th align=left><font color=brown>Description</font></th>";
echo "<th align=left><font color=brown>DepositID</font></th>";

echo "</tr>";
}

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){
 
extract($row11);
 
$payor=htmlspecialchars_decode($payor); 
$payor_bank=htmlspecialchars_decode($payor_bank); 
$description=htmlspecialchars_decode($description); 
 if($check_receipt_date=='0000-00-00'){$check_receipt_date='';}
$cashier2=substr($cashier,0,-2 );
// echo substr($string, 0, -3);
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

//if($submit3 != 'Edit')
//{	
 echo "<tr$t>";
 echo "<td>$check_receipt_date</td>";  
 echo "<td>$cashier2</td>";                      
echo "<td>$checknum</td>";                      
//echo "<td>$checknum</td>";                      
echo "<td>$payor</td>";                      
echo "<td>$payor_bank</td>";                      
 echo "<td>$amount</td>";  
 echo "<td>$description</td>"; 
 echo "<td>$controllers_deposit_id</td>"; 

//if($beacnum=='60033242')
 {
 
 echo "<td>";
 echo "<form method='post' autocomplete='off' action='page2_form.php'>";
 echo "<input type='hidden' name='check_receipt_dateE' value='$check_receipt_date'>";
// echo "<input type='hidden' name='cashier2E' value='$cashier2'>";
 echo "<input type='hidden' name='checknumE' value='$checknum'>";
 echo "<input type='hidden' name='payorE' value='$payor'>";
 echo "<input type='hidden' name='payor_bankE' value='$payor_bank'>";
 echo "<input type='hidden' name='amountE' value='$amount'>";
 echo "<input type='hidden' name='f_yearE' value='$f_year'>";
 echo "<input type='hidden' name='edit_id' value='$id'>";
 echo "<input type='hidden' name='menu_check' value='edit_record'>";
 echo "<input type='submit' name='submit3' value='Edit'>";
 echo "</form>";
 echo "$id";
 echo "</td>";  
 } 


//if($beacnum=='60033242')
if($delrec != 'y')	
{
if($search_all != 'y')
{	
echo "<td><a href='page2_form.php?submit2=$submit2&f_year=$f_year&cashier=$cashier&budget_office=$budget_office&&edit=$edit&menu_check=$menu_check&delID=$id&delrec=y'><img height='15' width='15' src='/budget/infotrack/icon_photos/mission_icon_photos_263.png' alt='red trash can' title='delete'></img></a></td>";
}
}

if($delrec == 'y')	
{
/*	
echo "<td><a href='page2_form.php?submit2=$submit2&f_year=$f_year&cashier=$cashier&budget_office=$budget_office&&edit=$edit&menu_check=$menu_check&delID=$id&delrecC=y'><img height='15' width='15' src='/budget/infotrack/icon_photos/mission_icon_photos_263.png' alt='red trash can' title='delete'></img></a></td>";
*/
if($id==$delID)
{
echo "<td>";
echo "<font class='cartRow'><font color='red'>Delete Record?</font><br /><br />";
echo "<table align='center' cellpadding='10'>";
echo "<tr$t>";
echo "<th><a href='page2_form.php?submit2=$submit2&f_year=$f_year&cashier=$cashier&budget_office=$budget_office&&edit=$edit&menu_check=$menu_check&delID=$id&delrecC=y'>Yes</a></th>";
echo "<th><a href='page2_form.php?submit2=$submit2&f_year=$f_year&cashier=$cashier&budget_office=$budget_office&&edit=$edit&menu_check=$menu_check'>No</a></th>";
echo "</tr>";
echo "</table>";
echo "</font>";
echo "</td>";
}
}


/*
{


}	
*/
echo "</tr>";
//}









}

  echo "</table>";
}
//}  
}
 //echo "</div>"; 
 
 
 echo "</body></html>";
 
 
 
 
?>