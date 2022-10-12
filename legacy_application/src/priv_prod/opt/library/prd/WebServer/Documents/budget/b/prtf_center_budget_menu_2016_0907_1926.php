<?php
//These are placed outside of the webserver directory for security
include("../../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database


//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
extract($_REQUEST);

if(!$acs){include("../menu.php");}else{$dbTable="partf_payments";}

// ***** Get most recent PARTF_PAY date
if($datenew==""){
$sql = "SELECT max(datenew) as datenew FROM $dbTable";
$total_result = @mysql_query($sql, $connection) or die("Error #1". mysql_errno() . ": " . mysql_error());
$row = mysql_fetch_array($total_result);
 extract($row);
}

echo "<div align='center'>";

if($checkBalance){
if($center){

//include("centerQuery.php");
include("project_fundscheck.php");

//echo "$sql";exit;
$result = @mysql_query($sql);
$row = mysql_fetch_array($result);
 extract($row);
 $funds_allocated=number_format($funds_allocated,2);
 $payments=number_format($payments,2);
 $balance=number_format($balance,2);
 
/*
echo "<br>DPR PARTF BUDGETS LOOKUP BY CENTERS<hr>
<table><tr><th>center_desc</td><th>funds_allocated</td><th width='90'>payments</td><th width='90'>Center balance on $datenew</th></tr><tr><td>$center_desc</td><td align='center'>$funds_allocated</td><td align='center'>$payments</td><td align='center'>$balance</td></tr></table>";
*/

 $posted_payments=number_format($posted_payments,2);
 $posted_balance=number_format($posted_balance,2);
 $unposted_payments=number_format($unposted_payments,2);
 $available_funds=number_format($available_funds,2);
echo "<br>DPR PARTF BUDGETS LOOKUP BY CENTERS<hr>
<table border='1'><tr><th>center_desc</td><th>funds_allocated</td>
<th width='90'>posted_payments</td>
<th width='90'>Center posted_balance on $datenew</th>
<th width='90'>unposted_payments</td>
<th width='90'>available_funds</td>
</tr>

<tr><td>$center_desc</td><td align='center'>$funds_allocated</td><td align='center'>$posted_payments</td>
<td align='center'>$posted_balance</td>
<td align='center'><a href='partf_payments_unposted.php?new_center=$funds_check_center_new' target='_blank'>$unposted_payments</a></td>
<td align='center'>$available_funds</td>
</tr></table>";

}
}// end checkBalance
if($beacnum==60032913){$level=4;}  //wedi disu (mcelhone8290)
if($beacnum==60032912){$level=4;}  //eadi disu (fullwood1940)
if($beacnum==60033019){$level=4;} //sodi disu (greenwood3841)
if($beacnum==60032956){$level=4;} //sodi district maintenance (mitchell9781)
if($beacnum==60032958){$level=4;} //wedi district maintenance (baumgardner4159)
if($beacnum==60032977){$level=4;} //nodi district maintenance (noel4543)
if($beacnum==60032957){$level=4;} //eadi district maintenance (johnson4374)
if($beacnum==60033135){$level=4;} //nodi district I&E (bockhahn1844)
if($beacnum==60032875){$level=4;} //wedi district I&E (becker7900)
if($beacnum==60032907){$level=4;} //sodi district I&E (hurtado0730)
if($beacnum==60032931){$level=4;} //wedi oa (bunn8227)
if($beacnum==60032892){$level=4;} //eadi oa (quinn0398)
if($beacnum==60033148){$level=4;} //nodi oa (brown4109)
if($beacnum==60033093){$level=4;} //sodi oa (mitchener8455)










//echo "<br />Line 65: level=$level<br />";
if(!$acs){
echo "<table><tr>";

$where="where projYN='y'";
if($level==2){
$distCode=$_SESSION[budget][select];
switch($distCode){
case "EADI":
$menuList="array".$distCode; $parkList=${$menuList};
break;
case "NODI":
$distCode="north";
break;
case "SODI":
$distCode="south";
break;
case "WEDI":
$distCode="west";
break;
}
$where.=" and dist='$distCode'";}

$sql = "SELECT distinct park from partf_projects $where ORDER BY park";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysql_fetch_array($result)){
	extract($row);$park=strtoupper($park);
	$parkCode[]=$park;
	}
//	echo "$sql";

echo "<td><form action='prtf_center_budget.php'>Park: <select name='parkcode'>";
echo "<option $s=''>\n";      
        for ($n=0;$n<count($parkCode);$n++)  
        {$scode=$parkCode[$n];$parkArray[]=$scode;
if($scode==@$parkcode){$s="selected";}else{$s="value";}
echo "<option $s='$scode'>$scode\n";
          }
echo "</select> Show SQL <input type='checkbox' name='showSQL' value='1'><input type='submit' name='submit' value='Submit'></form></td></tr>";

$sql = "select distinct yearfundf as yf from partf_projects
where 1 and projyn='y' order by yearfundf asc";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysql_fetch_array($result)){
	extract($row);$yf=strtoupper($yf);
	$yfArray[]=$yf;
	}
echo "<tr><td><form action='prtf_center_budget.php'>YearFund: <select name='yearfundf'>";
echo "<option $s=''>\n";      
        for ($n=0;$n<count($yfArray);$n++)  
        {$scode=$yfArray[$n];
if($scode==@$yearfundf){$s="selected";}else{$s="value";}
echo "<option $s='$scode'>$scode\n";
          }
echo "</select> Show SQL <input type='checkbox' name='showSQL' value='1'><input type='submit' name='submit' value='Submit'></form></td></tr>";

$sql = "Select distinct(centerman) as man
from center
where type='project'
order by centerman asc";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysql_fetch_array($result)){
	extract($row);$man=strtoupper($man);
	$manArray[]=$man;
	}
echo "<tr><td><form action='prtf_center_budget_b.php'>Manager: <select name='centerman'>";
echo "<option $s=''>\n";      
        for ($n=0;$n<count($manArray);$n++)  
        {$scode=$manArray[$n];
if($scode==@$centerman){$s="selected";}else{$s="value";}
echo "<option $s='$scode'>$scode\n";
          }
echo "</select> Show SQL <input type='checkbox' name='showSQL' value='1'><input type='submit' name='submit' value='Submit'></form></td></tr>";

if(!isset($center)){$center="";}
if(!isset($statusFilter)){$statusFilter="";}
echo "<tr><td><form action='prtf_center_budget_a.php'>Center: <input type='text' name='center' value='$center' size='10'> Status (ip,fi,etc.)<input type='text' name='statusFilter' value='$statusFilter' size='10'></td><td>";
echo "Show SQL <input type='checkbox' name='showSQL' value='1'><input type='submit' name='submit' value='Submit'>
</td></form>";
/*
echo "<form><td>";
echo "<input type='submit' name='reset' value='Reset'>
</td></form>";
*/
}
echo "</tr></table><hr>";


?>