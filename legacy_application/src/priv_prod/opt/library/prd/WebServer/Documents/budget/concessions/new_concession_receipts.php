<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
//echo "<br />fyear=$fyear<br />";
//echo "<br />f_year=$f_year<br />";

//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
$checkmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
.normal {background-color:#ffffff;}
.highlight {background-color:#ff0000;} 
</style>

<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>
</head>";

include ("../../budget/menu1415_v1.php");

/*
$query1="SELECT cy from fiscal_year where active_year_concession_fees='y' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "<br />cy=$cy<br />";
*/
echo "<br /><br />";
include("fyear_concessions_receipts_ncas.php");
//exit;

{	
//echo "<br /><font color='red'>fyear=cy</font><br />";

/*
$query="update crs_tdrr_division_deposits_checklist,crs_tdrr_division_deposits
        set crs_tdrr_division_deposits_checklist.controllers_deposit_id=crs_tdrr_division_deposits.controllers_deposit_id
		where 
		crs_tdrr_division_deposits_checklist.orms_deposit_id=crs_tdrr_division_deposits.orms_deposit_id
		and crs_tdrr_division_deposits_checklist.f_year='$cy'
		and crs_tdrr_division_deposits.f_year='$cy'
		and crs_tdrr_division_deposits_checklist.controllers_deposit_id = '' ";
		
//echo "<br />Line 89: query=$query<br />"; 

// exit;


$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query ");
*/


//$query6a="SELECT min(start_date)as 'since_last_update' from project_steps_detail where project_name='weekly_updates' and project_category='fms'";
$query6a="SELECT max(acctdate)as 'since_last_update' from exp_rev where sys != 'wa'";

//echo "<br /><br />Line 100: query6a=$query6a<br /><br />"; 

$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$row6a=mysqli_fetch_array($result6a);
extract($row6a);//brings back max (end_date) as $end_date

$since_last_update2=str_replace("-","",$since_last_update);
//echo "<br /><br /><font color='red' class='cartRow' size='4'>Last Update from NCAS=$since_last_update2</font><br /><br />";




}


echo "<br /><br />";
echo "<table align='center'><tr><td><font color='red' class='cartRow' size='4'>Last Update from NCAS=$since_last_update2</font></td></tr></table>";
//exit;
echo "<table border='2' cellspacing='5' align='center'>";
echo "<tr><td>center</td><td>parkcode</td><td>account</td><td>account_description</td><td>total</td></tr>";

$query3="select center.parkcode,exp_rev.center,center.parkcode,exp_rev.acct,coa.park_acct_desc,sum(credit-debit) as 'park_total'
        from exp_rev
		left join center on exp_rev.center=center.new_center
		left join coa on exp_rev.acct=coa.ncasnum
		where f_year='$fyear' and (acct='434196002' or acct='434196001' or acct='434150920')
        group by exp_rev.center,center.parkcode,exp_rev.acct
		order by center.parkcode
		";

echo "<br /><br />Line 129: query3=$query3<br /><br />"; 

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);

echo "<tr>";	
echo "<td>$center</td>";
echo "<td>$parkcode</td>";
echo "<td>$acct</td>";
echo "<td>$park_acct_desc</td>";
if($center==$centerS and $acct==$acctS)
{
echo "<td><a href='new_concession_receipts.php?centerS=$center&acctS=$acct&drill=y&fyear=$fyear'>$park_total</a>$checkmark</td>";
$park_selected=$parkcode;
}
else
{
echo "<td><a href='new_concession_receipts.php?centerS=$center&acctS=$acct&drill=y&fyear=$fyear'>$park_total</a></td>";
}
echo "</tr>";




}

echo "</table>";

if($drill=='')
{
$query4="select sum(credit-debit) as 'total_amount'
        from exp_rev
		where f_year='$fyear' and (acct='434196002' or acct='434196001' or acct='434150920') ";
}


if($drill=='y')
{
$query4="select sum(credit-debit) as 'total_amount'
        from exp_rev
		where f_year='$fyear' and exp_rev.center='$centerS' and exp_rev.acct='$acctS' ";
}



		

//echo "<br /><br />Line 118: query4=$query4<br /><br />"; 

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);
extract($row4);//brings back max (end_date) as $end_date

$total_amount=number_format($total_amount,2);



//434196002 special attractions
//434196001 marina
//434150920 food and vending

if($drill=='')
{
$query5="select f_year,sum(credit-debit) as 'amount',exp_rev.description,mid(exp_rev.description,1,6) as 'deposit_id',exp_rev.center,center.parkcode,acct,coa.park_acct_desc,acctdate,invoice,whid
        from exp_rev
		left join center on exp_rev.center=center.new_center	
        left join coa on exp_rev.acct=coa.ncasnum		
		where f_year='$fyear' and (acct='434196002' or acct='434196001' or acct='434150920') group by whid order by acctdate desc     ";
		
}		
		
if($drill=='y')
{
$query5="select f_year,sum(credit-debit) as 'amount',exp_rev.description,mid(exp_rev.description,1,6) as 'deposit_id',exp_rev.center,center.parkcode,acct,coa.park_acct_desc,acctdate,invoice,whid
        from exp_rev
		left join center on exp_rev.center=center.new_center	
        left join coa on exp_rev.acct=coa.ncasnum		
		where f_year='$fyear' and exp_rev.center='$centerS' and exp_rev.acct='$acctS' group by whid order by acctdate desc     ";
		
}			
		


echo "query5=$query5"; //exit;
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$num5=mysqli_num_rows($result5);

if($num5=='0'){echo "<font color='red'>NO Records for this time period</font>"; exit;}
if($drill!='y'){echo "<table align='center'><tr><td>Total All Parks: $total_amount</td></tr></table>";}
if($drill=='y'){echo "<table align='center'><tr><td>Total $park_selected: $total_amount</td></tr></table>";}
echo "<table border=1>";


echo "<tr>";
//echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";	
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>Description</font></th>
       <th align=left><font color=brown>Deposit ID</font></th>
	   <th align=left><font color=brown>Park</font></th>
	   <th align=left><font color=brown>NCAS Center</font></th>
	   <th align=left><font color=brown>NCAS Account</font></th>
	   <th align=left><font color=brown>Account Description</font></th>
	   <th align=left><font color=brown>NCAS Post Date</font></th>
       <th align=left><font color=brown>NCAS Invoice#</font></th>
      ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
/*
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);
$py2_amount=number_format($py2_amount,2);
$py3_amount=number_format($py3_amount,2);
$py4_amount=number_format($py4_amount,2);
$py5_amount=number_format($py5_amount,2);
$py6_amount=number_format($py6_amount,2);
$py7_amount=number_format($py7_amount,2);
$py8_amount=number_format($py8_amount,2);
$py9_amount=number_format($py9_amount,2);
$py10_amount=number_format($py10_amount,2);
$py11_amount=number_format($py11_amount,2);
$py12_amount=number_format($py12_amount,2);
*/

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
echo "<tr class=\"normal\" id=\"row$whid\" onclick=\"onRow(this.id)\">";	

       //echo "<td>$category</td>";
     echo "<td>$f_year</td>
           <td>$amount</td>		   
           <td>$description</td>		   
           <td>$deposit_id</td>		   
           <td>$parkcode</td>		   
           <td>$center</td>		   
           <td>$acct</td>		   
           <td>$park_acct_desc</td>		   
           <td>$acctdate</td>		   
           <td>$invoice</td>	           
      
           
              
           
</tr>";
if($deposit_id != '')
{
$deposit_id2.=$deposit_id." or controllers_deposit_id=";
}
//echo "<br />deposit_id2=$deposit_id2<br />";


}
$deposit_id3=substr($deposit_id2,0,-26);
$deposit_id4="controllers_deposit_id=".$deposit_id3;
//echo "<br />deposit_id4=$deposit_id4<br />";

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 /*
 $query4="select id,orms_deposit_id,controllers_deposit_id,checknum,payor,payor_bank,amount,description,bank_deposit_date,system_entry_date,f_year,cashier
         from crs_tdrr_division_deposits_checklist
         where f_year='$f_year'
         and ($deposit_id4)
         order by controllers_deposit_id  ";		 
	
	
echo "<br />query4=$query4<br />";





$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);	
	
echo "<table border='1' align='center'>";	
echo "<tr>";
echo "<th colspan='7'>Records: $num4</th>";
echo "</tr>";
echo "<tr>";


echo "<th>id</th>";
echo "<th>orms_deposit_id</th>";
echo "<th>controllers_deposit_id</th>";
echo "<th>checknum</th>";
echo "<th>payor</th>";
echo "<th>payor_bank</th>";
echo "<th>amount</th>";
echo "<th>description</th>";
echo "<th>bank_deposit_date</th>";
echo "<th>system_entry_date</th>";
echo "<th>f_year</th>";
echo "<th>cashier</th>";

echo "</tr>";




while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";		


echo "<td>$id</td>";	
echo "<td>$orms_deposit_id</td>";	
echo "<td>$controllers_deposit_id</td>";	
echo "<td>$checknum</td>";	
echo "<td>$payor</td>";	
echo "<td>$payor_bank</td>";	
echo "<td>$amount</td>";	
echo "<td>$description</td>";	
echo "<td>$bank_deposit_date</td>";	
echo "<td>$system_entry_date</td>";	
echo "<td>$f_year</td>";	
echo "<td>$cashier</td>";	


echo "</tr>";	
	
	
}

echo "</table>";
 
 */
 
  
 
echo "</body></html>";



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>