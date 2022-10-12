<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

include("../../../include/authBUDGET.inc");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//$dbTable="partf_payments";

$file="year2year_comparison.php";
$varQuery=$_SERVER['QUERY_STRING'];// ECHO "v=$varQuery";//exit;

extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

// **************  Show Results ***************

if($rep=="excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=year2year_comparison.xls');
echo "<html><body>";
echo "<table border='1' cellpadding='3' align='center'>";

}

echo "<table border='1' cellpadding='3' align='center'>";

// ******** Show Results ***********

if($rep==""){
include("../menu.php");
if(!$budget_group){$budget_group="operating_revenues";}
echo "<table border='1' cellpadding='3' align='center'>";
echo "<tr><td><a href='$file?budget_group=$budget_group&rep=excel'>Excel Export</a></td></tr>";


//$showSQL=1;

if($showSQL==1){$p="method='POST'";}
echo "<hr><table align='center'><form action='year2year_comparison.php' $p><tr>";


// Menu 1
$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings/other_structures' AND budget_group != 'reserves' AND budget_group != 'funding'
ORDER BY budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$menuArray[]=$row[budget_group];}

if($budget_group){$budget_group_ck=$budget_group;}else{$budget_group_ck="operating_revenues";}

echo "<td align='center'>Budget Group<br><select name=\"budget_group\" onChange=\"MM_jumpMenu('parent',this,0)\">";
for ($n=0;$n<count($menuArray);$n++){
if($budget_group_ck==$menuArray[$n]){$s="selected";}else{$s="value";}
$con="year2year_comparison.php?budget_group=".$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td></tr></table>";

}

//exit;

$query="truncate table year2year_1;";
   $result = @mysqli_query($connection, $query,$connection);
if($showSQL){echo "$query<br><br>";};

$query="insert into year2year_1( center, account, py1_amount,  cy_amount,lytt_amount ) select center, ncasnum, sum(amount_py1), sum(amount_cy),sum(amount_lytt) from act3 where 1 group by center,ncasnum;
";
   $result = @mysqli_query($connection, $query,$connection);
if($showSQL){echo "$query<br><br>";};

$query="update year2year_1,coa set year2year_1.budget_group=coa.budget_group where year2year_1.account=coa.ncasnum;
";
   $result = @mysqli_query($connection, $query,$connection);
if($showSQL){echo "$query<br><br>";};


$revArray=array("operating_revenues","purchase4resale","grants","reimbursements");

// ********** Summary Header
if(in_array($budget_group,$revArray)){
$query="SELECT  -sum( py1_amount ) AS 'py_posted', -sum( lytt_amount ) AS 'lytt_posted',  -sum( cy_amount ) AS 'cy_posted',  sum(lytt_amount-cy_amount) AS 'yearly_variance' FROM year2year_1  LEFT JOIN coa ON year2year_1.account = coa.ncasnum WHERE 1 AND year2year_1.budget_group='$budget_group' AND year2year_1.center like '1280%' GROUP BY year2year_1.budget_group
";
}
else
{$query="SELECT  sum( py1_amount ) AS 'py_posted', sum( lytt_amount ) AS 'lytt_posted', sum( cy_amount ) AS 'cy_posted',  sum(lytt_amount-cy_amount) AS 'yearly_variance' FROM year2year_1 LEFT JOIN coa ON year2year_1.account = coa.ncasnum WHERE 1 AND year2year_1.budget_group='$budget_group' AND year2year_1.center like '1280%' GROUP BY year2year_1.budget_group
";
}
   $result = @mysqli_query($connection, $query,$connection);
if($showSQL){echo "$query<br><br>";};
$row=mysqli_fetch_array($result);extract($row);

if($yearly_variance<0){
$f1="<font color='red'>";$f2="</font>";
}
$py_posted=number_format($py_posted,2);
$lytt_posted=number_format($lytt_posted,2);
$cy_posted=number_format($cy_posted,2);
$yearly_variance=number_format($yearly_variance,2);

//Explicitly populate $headerArray instead of dynamic
$headerArray=array("py_posted","lytt_posted","cy_posted","yearly_variance");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
$header.="<th>".$h."</th>";}

echo "<div align='center'><table border='1'><tr>$header</tr>";
echo "<tr><td>$py_posted</td><td>$lytt_posted</td><td>$cy_posted</td><td align='right'>$f1$yearly_variance$f2</td></tr></table>";

// ****** Body Query
$whereFilter="where 1";

if(!$budget_group){$whereFilter.=" AND year2year_1.budget_group='operating_revenues'";}
else
{$whereFilter.=" AND year2year_1.budget_group='$budget_group'";}

if(in_array($budget_group,$revArray)){
 $query = "SELECT year2year_1.account, coa.park_acct_desc, -sum( py1_amount ) AS 'py_posted', -sum( lytt_amount ) AS 'lytt_posted',  -sum( cy_amount ) AS 'cy_posted',  sum(lytt_amount-cy_amount) AS 'yearly_variance'
 FROM year2year_1
 LEFT JOIN coa ON year2year_1.account = coa.ncasnum
 $whereFilter AND year2year_1.center like '1280%'
 GROUP BY year2year_1.account
 ORDER BY year2year_1.account
";
}
else
{
 $query = "SELECT year2year_1.account, coa.park_acct_desc, sum( py1_amount ) AS 'py_posted', sum( lytt_amount ) AS 'lytt_posted', sum( cy_amount ) AS 'cy_posted',  sum(lytt_amount-cy_amount) AS 'yearly_variance'
 FROM year2year_1
 LEFT JOIN coa ON year2year_1.account = coa.ncasnum
 $whereFilter AND year2year_1.center like '1280%'
 GROUP BY year2year_1.account
 ORDER BY year2year_1.account
";
}
   $result = @mysqli_query($connection, $query,$connection);
if($showSQL){echo "$query<br><br>";};

//Explicitly populate $headerArray instead of dynamic
unset($headerArray);
unset($header);
$headerArray=array("account","park_acct_desc","py_posted","lytt_posted","cy_posted","yearly_variance");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
$header.="<th>".$h."</th>";}

echo "<div align='center'><table border='1'><tr>$header</tr>";

$j=1;
if($rep=="excel"){$forceText="'";}
while($row = mysqli_fetch_array($result)){
extract($row);

$py_postedTOT+=$py_posted;
$lytt_postedTOT+=$lytt_posted;
$cy_postedTOT+=$cy_posted;
$yearly_varianceTOT+=$yearly_variance;

if($rep==""){if(fmod($j,20)==0){echo "$header";}$j++;}

if($yearly_variance<0){
$f1="<font color='red'>";$f2="</font>";
$tr=" bgcolor='AliceBlue'";}
else{$f1="";$f2="";$tr="";}

$py_posted=number_format($py_posted,2);
$lytt_posted=number_format($lytt_posted,2);
$cy_posted=number_format($cy_posted,2);
$yearly_variance=number_format($yearly_variance,2);

echo "<tr$tr>";
$linkAccount="<a href='year2year_comparison_drill.php?account=$account&budget_group=$budget_group' target='_blank'>$account</a>";
echo "<td align='left'>$linkAccount</td>
<td align='left'>$park_acct_desc</td>
<td align='right'>$py_posted</td>
<td align='right'>$lytt_posted</td>
<td align='right'>$cy_posted</td>";
echo "<td align='right'>$f1$yearly_variance$f2</td>
</tr>";
	}// end while

// ****** Totals
$py_postedTOT=number_format($py_postedTOT,2);
$lytt_postedTOT=number_format($lytt_postedTOT,2);
$cy_postedTOT=number_format($cy_postedTOT,2);
$yearly_varianceTOT=number_format($yearly_varianceTOT,2);

if($yearly_varianceTOT<0){
$f1="<font color='red'>";$f2="</font>";
}
else{$f1="";$f2="";}

echo "<tr><td colspan='3' align='right'>$py_postedTOT</td>
<td align='right'>$lytt_postedTOT</td>
<td align='right'>$cy_postedTOT</td>
<td align='right'>$f1$yearly_varianceTOT$f2</td>
</tr>";
echo "</table></div></body></html>";

?>