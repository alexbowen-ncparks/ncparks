<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$parkcode=$_SESSION['budget']['select'];
if($level==1){$center_code=$parkcode;}
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

echo "
<style>

table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
.normal {background-color:#B4CDCD;}
.highlight {background-color:#ff0000;} 
</style>";



echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>";




/*
echo "<script language='JavaScript' type='text/javascript'>

function popitup(url) {
	newwindow=window.open(url,'name','height=200,width=150');
	if (window.focus) {newwindow.focus()}
	return false;
}

</script>";
*/



echo "<script language='JavaScript' type='text/javascript'>
function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=800,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}
</script>";








//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";



//echo "</H3>";

echo "<br />";
if($f_year >= '1314')
{
if($valid_account=='n')
{
if($center_code=='')
{
$query3="
select 
center_code,id,ncas_account,park_acct_desc,prepared_by,ncas_invoice_date,datesql,system_entry_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,vendor_name,vendor_number,group_number,ncas_center,energy_group,energy_subgroup,cdcs_uom,energy_quantity,account_number,cvip_id,valid_account
from energy1
left join coa on energy1.ncas_account=coa.ncasnum
where 1 and valid_account='n'
and ncas_account='532210'
and f_year='$f_year'
order by ncas_account,center_code,datesql;
";
}

if($center_code!='')
{
$query3="
select 
center_code,id,ncas_account,park_acct_desc,prepared_by,ncas_invoice_date,datesql,system_entry_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,vendor_name,vendor_number,group_number,ncas_center,energy_group,energy_subgroup,cdcs_uom,energy_quantity,account_number,cvip_id,valid_account
from energy1
left join coa on energy1.ncas_account=coa.ncasnum
where 1 and valid_account='n'
and ncas_account='532210'
and center_code='$center_code'
and f_year='$f_year'
order by ncas_account,center_code,datesql;
";
}

}

if($valid_account=='y')
{
if($center_code=='')
{
$query3="
select 
center_code,id,ncas_account,park_acct_desc,prepared_by,ncas_invoice_date,datesql,system_entry_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,vendor_name,vendor_number,group_number,ncas_center,energy_group,energy_subgroup,cdcs_uom,energy_quantity,account_number,cvip_id,valid_account
from energy1
left join coa on energy1.ncas_account=coa.ncasnum
where 1 and valid_account='y'
and ncas_account='532210'
and f_year='$f_year'
order by ncas_account,center_code,datesql;
";
}

if($center_code!='')
{
if($account_number=='')
{
$query3="
select 
center_code,id,ncas_account,park_acct_desc,prepared_by,ncas_invoice_date,datesql,system_entry_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,vendor_name,vendor_number,group_number,ncas_center,energy_group,energy_subgroup,cdcs_uom,energy_quantity,account_number,cvip_id,valid_account
from energy1
left join coa on energy1.ncas_account=coa.ncasnum
where 1 and valid_account='y'
and ncas_account='532210'
and center_code='$center_code'
and f_year='$f_year'
order by ncas_account,center_code,datesql;
";
}
else
{
$query3="
select 
center_code,id,ncas_account,park_acct_desc,prepared_by,ncas_invoice_date,datesql,system_entry_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,vendor_name,vendor_number,group_number,ncas_center,energy_group,energy_subgroup,cdcs_uom,energy_quantity,account_number,cvip_id,valid_account
from energy1
left join coa on energy1.ncas_account=coa.ncasnum
where 1 and valid_account='y'
and ncas_account='532210'
and center_code='$center_code'
and f_year='$f_year'
and account_number='$account_number'
order by ncas_account,center_code,datesql;
";
}






}


}






$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);
//echo $num3;exit;
//mysql_close();


$query3a="select max(system_entry_date) as 'last_update', max(cvip_id) as 'last_cdcs' from energy1 where ncas_account='532210' ";
		  
$result3a = mysql_query($query3a) or die ("Couldn't execute query 3a.  $query3a");

$row3a=mysql_fetch_array($result3a);
extract($row3a);		  
		  
if($beacnum != '60032793')
{
echo "<table border='1'><tr><th>Last<br />CDCS<br /> Update</th><td>$last_update<br />#$last_cdcs</td></tr></table>";
}

if($beacnum == '60032793')
{
echo "<table border='1'><tr><th>Last<br />CDCS<br />Import</th><td>$last_update<br />#$last_cdcs<br />";

echo "<form method='post' action='electricity_cdcs_import.php?f_year=$f_year&egroup=$egroup&report=$report&valid_account=$valid_account&last_cdcs=$last_cdcs'>";

echo "<td><input type='submit' name='submit' value='update'></td>";
echo "</form>";

echo "</td></tr></table>";
}



echo "<br />";
echo "<table><tr><th>Records: $num3</th>";

echo "<form method='post' action='energy_reporting.php?f_year=$f_year&egroup=$egroup&report=$report&valid_account=$valid_account'>";
if($level==1)
{
echo "<td><input name='center_code' type='text' value='$center_code' readonly='readonly'></td>";
}
else
{
echo "<td><input name='center_code' type='text' value='$center_code'></td>";
}
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";


echo "</tr></table>";
//echo "query3=$query3<br />";
echo "<table border=1>";
 
echo "<tr>"; 
    
 //echo " <th><font color=blue>Company</font></th>";
 //echo " <th><font color=blue>Park</font></th>";
 echo " <th><font color=blue>Park<br />Center<br />Prepared by</font></th>";   
 echo " <th><font color=blue>NCAS Account</font></th>";
 //echo " <th><font color=blue>Account Description</font></th>";
 //echo " <th><font color=blue>Prepared by</font></th>";
 //echo " <th><font color=blue>Invoice Date</font></th>";
 //echo " <th><font color=blue>Sign</font></th>";
 //echo " <th><font color=blue>Account_Description</font></th>";
  //echo " <th><font color=blue>DateSQL</font></th>"; 
  //echo " <th><font color=blue>SED</font></th>"; 
  
 //echo " <th><font color=blue>Pcard_transid</font></th>";
// echo " <th><font color=blue>Transid verified</font></th>";
// echo " <th><font color=blue>DENR Paid</font></th>";
 //echo " <th><font color=blue>Invoice Amount</font></th>";
 //echo " <th><font color=blue>Invoice Total</font></th>";           
 echo " <th><font color=blue>Energy Vendor<br />Energy Group<br />Energy Quantity<br />Energy Cost<br />Energy Rate</font></th>";echo " <th><font color=blue>Invoice Number<br />Invoice Date (Month)<br />Entered Date<br />Energy Account#</font></th>";            
 //echo " <th><font color=blue>Vendor Number</font></th>";           
 //echo " <th><font color=blue>Group#</font></th>";           
     
         
 //echo " <th><font color=blue>Energy Group</font></th>";           
 //echo " <th><font color=blue>Energy SubGroup</font></th>";           
 //echo " <th><font color=blue>UOM</font></th>";           
 //echo " <th><font color=blue>Energy Quantity</font></th>";           
 //echo " <th><font color=blue>Energy Account#</font></th>";           
 echo " <th><font color=blue>CDCS ID</font></th>";           
 echo " <th><font color=blue>Valid Account</font></th>";           
   echo " <th><font color=blue>ID</font></th>";     
   echo " <th><font color=blue>Valid Account#</font></th>";     
// echo " <th><font color=blue>Action</font></th>";           
  
echo "</tr>";
echo  "<form method='post' autocomplete='off' action='electricity_cdcs_update.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
if($ncas_account=='532210'){$egroup='electricity';}
if($sign=="credit"){$amount="-".$amount;}
//if($sign=="credit"){$oft="<font color='red'>";} else {$oft="<font color='black'>";}
if($ncas_account=='532210'){$park_acct_desc='electricity';}
if($ncas_account=='532220'){$park_acct_desc='natural gas <br /> propane';}
if($ncas_account=='532230'){$park_acct_desc='water';}
if($ncas_account=='532241'){$park_acct_desc='fuel oil';}
$rate=round(($ncas_invoice_amount/$energy_quantity),2);
$datesql2=date('Y-m-d', strtotime($datesql));
$date_sql_year=substr($datesql,2,2);
$date_sql_month=substr($datesql,4,2);
if($date_sql_month=='01'){$invoice_month='jan';}
if($date_sql_month=='02'){$invoice_month='feb';}
if($date_sql_month=='03'){$invoice_month='mar';}
if($date_sql_month=='04'){$invoice_month='apr';}
if($date_sql_month=='05'){$invoice_month='may';}
if($date_sql_month=='06'){$invoice_month='jun';}
if($date_sql_month=='07'){$invoice_month='jul';}
if($date_sql_month=='08'){$invoice_month='aug';}
if($date_sql_month=='09'){$invoice_month='sep';}
if($date_sql_month=='10'){$invoice_month='oct';}
if($date_sql_month=='11'){$invoice_month='nov';}
if($date_sql_month=='12'){$invoice_month='dec';}


//echo "date_sql_month=$date_sql_month<br />";
//if($date_sql_month=='8'){$date_sql_month2="aug";} 

//if($date_sql_month==08){$date_sql_month2='aug';}
//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";	      
//echo "<form method=post action=stepG5_update.php>";





//echo  "<td>$parkcode</td>";
echo  "<td>$center_code<br />$ncas_center<br />$prepared_by</td>"; 
echo  "<td>$ncas_account<br />$park_acct_desc</td>"; 
//echo  "<td>$park_acct_desc</td>"; 
//echo  "<td>$prepared_by</td>"; 
//echo  "<td>$ncas_invoice_date</td>"; 
//echo  "<td>$datesql</td>"; 
//echo  "<td>$system_entry_date</td>"; 
 
//echo  "<td>$ncas_invoice_amount</td>"; 
//echo  "<td>$invoice_total</td>"; 
echo  "<td>$vendor_name<br />$energy_group<br />$energy_quantity $cdcs_uom<br />$ncas_invoice_amount dollars<br />$rate dollars per $cdcs_uom</td>"; 
//echo  "<td>$vendor_number</td>"; 
//echo  "<td>$group_number</td>"; 
echo  "<td>$ncas_invoice_number<br />$datesql2 ($invoice_month$date_sql_year)<br />$system_entry_date<br /><a href='/budget/energy/energy_reporting.php' onclick=\"return popitup('/budget/energy/energy_reporting.php?f_year=$f_year&center_codeS=$center_code&egroup=$egroup&report=accounts')\">$account_number</a></td>";

//echo  "<td>$energy_group</td>"; 
//echo  "<td>$energy_subgroup</td>"; 
//echo  "<td>$cdcs_uom</td>"; 
//echo  "<td>$energy_quantity</td>"; 

//echo  "<td>$account_number</td>"; 

/*
echo  "<td><a href='/budget/energy/energy_reporting.php' onclick=\"return popitup('/budget/energy/energy_reporting.php?f_year=1314&center_codeS=$center_code&egroup=$egroup&report=accounts')\">$account_number</a></td>";
*/



echo  "<td><a href='/budget/acs/acs.php?id=$cvip_id&m=invoices' target='_blank'>$cvip_id</a></td>"; 
echo  "<td>$valid_account</td>"; 
echo  "<td><input type='text' size='5' readonly='readonly' name='id[]' value='$id'></td>";
/*
echo  "<td><a href='/budget/admin/weekly_updates/stepG8a1_matches.php' onclick=\"return popitup('/budget/energy/stepG8a1_matches.php?account=$acct&center=$center&trans_amount=$amount')\">$amount</a></td>";
*/
//echo  "<td>$sign</td>";

echo  "<td><input type='text' size='20' name='valid_account_number[]' value='$valid_account_number'></td>";

//echo  "<td><input type='text' size='10 name='company[]' value='$company'</td>";

//echo  "<td><input type='text' size='30' name='account_description[]' value='$account_description'</td>";
//echo  "<td><input type='text' size='20' name='pcard_trans_id[]' value='$pcard_trans_id'</td>";
//echo  "<td><input type='text' size='10' name='transid_verified[]' value='$transid_verified'</td>";
//echo  "<td><input type='text' size='10' name='denr_paid[]' value='$denr_paid'</td>";
//echo  "<td><input type='text' size='10' name='id1646[]' value='$id1646'></td>";
//echo  "<td><input type='text' size='10' readonly='readonly' name='id[]' value='$id'></td>";
   
	      
echo "</tr>";

}
if($beacnum=='60032793')
{
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
}
echo "<input type='hidden' name='num3' value='$num3'>";
echo "<input type='hidden' name='f_year' value='$f_year'>";

/*
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num3' value='$num3'>";
	   */
echo   "</form>";	 
echo "</table>";
	
}
else
{
echo "<table><tr><th>Message: This Application does not include CDCS records prior to Fiscal Year 1314</th></tr></table>";
}




?>

























