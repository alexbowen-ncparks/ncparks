<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
if(!$f_year){include("../~f_year.php");}
//print_r($_REQUEST);exit;
extract($_REQUEST);
$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from user_activity_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

include("../../budget/menu1314.php");
$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1";
 $result = @mysqli_query($connection, $sql,$connection);
$row=mysqli_fetch_array($result); extract($row);
/*
if($rep==""){
if($budget_group_menu!=""){include("park_budget_menu.php");}
}
*/
//print_r($_REQUEST);
//print_r($_SESSION);

$checkCenter=strpos($center,"-");
if($checkCenter>0){
$parse=explode("-",$center);
$center=$parse[2];}

// Construct Query to be passed to Excel Export
$budget_group_menuEncode=urlencode($budget_group_menu);
$varQuery="submit=Submit&section=$section&dist=$dist&budget_group_menu=$budget_group_menuEncode";

if($rep=="excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=current_year_budget.xls');
}

// Get menu values for Budget Group
//$bgArray[]="";
$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings/other_structures' AND budget_group != 'reserves' AND budget_group != 'funding'
ORDER BY budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){$bgArray[]=$row[budget_group];}
//$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");
// *********** Level > 4 ************
if($_SESSION[budget][level]>4){//print_r($_REQUEST);EXIT;


if($rep==""){
//include_once("../menu.php");
echo "<table align='center'><form action=\"account_deficits.php\">";

// Menu 000
echo "<td>Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";
   
$sql="SELECT distinct section from center where 1 order by section";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$sec[]=$row[section];}

echo "<td>$lev1 $lev2 Section: <select name=\"section\"><option selected></option>";
for ($n=0;$n<count($sec);$n++){
if($section==$sec[$n]){$s="selected";}else{$s="value";}
$con=$sec[$n];
		echo "<option $s='$con'>$sec[$n]</option>\n";
       }
   echo "</select></td>";
   
$sql="select distinct dist from center where 1 order by dist";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$DIST[]=$row[dist];}

echo "<td>District: <select name=\"dist\"><option selected></option>";
for ($n=0;$n<count($DIST);$n++){
if($dist==$DIST[$n]){$s="selected";}else{$s="value";}
$con=$DIST[$n];
		echo "<option $s='$con'>$DIST[$n]</option>\n";
       }
   echo "</select></td>";
         
echo "<td><input type='submit' name='submit' value='Submit'></form></td>";

if($submit){
echo "<td>Excel <a href='account_deficits.php?$varQuery&rep=excel'>export</a></td>";}

echo "</tr></table>";
}
if($dist=="" AND $section=="" AND $budget_group_menu==""){exit;}
}


// ********** Queries ***********
 $query = "truncate table budget1_unposted;";
    $result = @mysqli_query($connection, $query,$connection);
//echo "$query<br><br>";
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts  */
 $query = "insert into budget1_unposted( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' group by id;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_unposted( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
  $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts */
 $query = "insert into budget1_unposted( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat(postitle,'-',posnum,'-',tempid), datework,'na', sum(rate*hr1311),'seapay','seapay_unposted', prid from seapay_unposted where 1 group by prid;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*TRUNCATE */
 $query = "truncate table budget1_available;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
 

/*inserts   */
 $query = "insert into budget1_available( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, ncasnum, sum(amount_py1), '', sum(amount_cy),'','act3' from act3 where 1 group by center,ncasnum;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*inserts   */
 $query = "insert into budget1_available(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source) select center,ncas_acct,'',sum(allocation_amount),'','','budget_center_allocations' from budget_center_allocations where 1 and fy_req='$f_year' group by center,ncas_acct;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts */
 $query = "insert into budget1_available( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, account,'','','', sum(transaction_amount),'budget1_unposted' from budget1_unposted where 1 and post2ncas != 'y' group by center,account;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*UPDATE */
 $query = "update budget1_available,coa set budget1_available.budget_group=coa.budget_group where budget1_available.account=coa.ncasnum;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*TRUNCATE */
 $query = "truncate table budget1_available_od;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*inserts   */
 $query = "insert into budget1_available_od(park,center,district,section,budget_group,account,account_description,available_funds)
 select center.parkcode, budget1_available.center, center.dist, center.section, budget1_available.budget_group, budget1_available.account, coa.park_acct_desc as 'account_description',  sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds' from budget1_available left join center on budget1_available.center=center.center left join coa on budget1_available.account=coa.ncasnum where 1 and budget1_available.center like '1280%'  group by budget1_available.center,budget1_available.account order by parkcode;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*UPDATE */
 $query = "update budget1_available_od
set od='y'
where available_funds < '0';
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}



if($budget_group_menu=="operating_revenues" || $budget_group_menu=="purchase4resale" || $budget_group_menu=="grants" || $budget_group_menu=="reimbursements"){$sign="-";$sign2="-";}else{$sign="";$sign2="+";}


//select query for center budgets

if($dist){$where3=" and district='$dist'";}
if($section){$where3.=" and section='$section'";}

$sql="select park,center,district,section,budget_group,count(od) as 'count_od_items',sum(available_funds) as 'total_amount_od_items'
from budget1_available_od
where 1
and od='y'
and budget_group='$budget_group_menu'
$where3
group by center
order by park;";

//echo "$sql<br>";exit;

if($showSQL=="1"){echo "$sql<br>";}

//$varQuery=$_SERVER[QUERY_STRING];

echo "<table border='1' ><tr>";

$headerArray=array("park","center",
"district","section","budget_group","count_od_items",
"total_amount_od_items");


//$dontShow=array("center","dist","section","budget_group");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
if(!in_array($h,$dontShow)){
	$selectFields.=$h.",";
if($rep==""){$h=str_replace("_","<br>",$h);}
	$header.="<th>".$h."</th>";
					}
	}
	
if($rep=="excel"){echo "$header</tr>";} // see fmod below
echo "<br />";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);

$a_park[]=$park;// 1
$a_center[]=$center;// 2
$a_dist[]=$district;// 3
$a_section[]=$section;// 4
$a_budget_group[]=$budget_group;// 5
$a_count_od_items[]=$count_od_items;// 6
$a_total_amount_od_items[]=$total_amount_od_items;// 7

}// end while

echo "<tr><td colspan='6'><font color='red'>Report Date: $maxDate</font></td><td>$link</td></tr>";

$yy=10;

for($i=0;$i<count($a_park);$i++){
$x=2;

$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
$body ="<tr$bc>";

$center=$a_center[$i];

if(fmod($i,$yy)==0 and $rep==""){echo "$header";}

$fv1="";$fv2="";
$fv11="";$fv21="";
if($a_available_funds[$i]<0){$fv11="<font color='red'>";$fv21="</font>";}
if($a_cy_allocation[$i]<0){$fv1="<font color='red'>";$fv2="</font>";}

$body.="<td align='center'>$a_park[$i]</td>

<td align='right'>$a_center[$i]</td>
<td align='right'>$a_dist[$i]</td>
<td align='right'>$a_section[$i]</a></td>
<td align='right'>$a_budget_group[$i]</td>
<td align='right'>$a_count_od_items[$i]</td>
<td align='right'>$a_total_amount_od_items[$i]</td>

</tr>";


$tot_od_items+=$a_count_od_items[$i];
$tot_available_funds+=$a_total_amount_od_items[$i];

echo "$body";
}

$funds=numFormat($tot_available_funds);


if($allocation<0){$color="red";}else{$color="black";}
echo "<tr><td colspan='2' align='right'><b></b></td>
<td align='right'><b><font color=$color></font></b></td>
<td align='right'><b></b></td>
<td align='right'><b></b></td>
<td align='right'><b>$tot_od_items</b></td>
<td align='right'><b>$funds</b></td>
</tr>";

echo "</table></body></html>";

function numFormat($nf){

if($nf<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}
$nf=$fv1.number_format($nf,2).$fv2;
return $nf;}
?>



