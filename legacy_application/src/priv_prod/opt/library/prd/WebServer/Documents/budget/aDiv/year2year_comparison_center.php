<?php
//ini_set('display_errors',1);

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


include("../../../include/authBUDGET.inc");
include("../~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//include("../../../include/activity.php");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

//$showSQL=1;

extract($_REQUEST);
if(@$center){$c=explode("-",$center);
$center=$c[1];}

if($level==1){$center=$_SESSION['budget']['centerSess'];}

$file="year2year_comparison_center.php";
$varQuery=$_SERVER['QUERY_STRING'];// ECHO "v=$varQuery";//exit;

if(!isset($rep)){$rep="";}

// **************  Show Results ***************

if($rep=="excel")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=year2year_comparison_center.xls');
	echo "<html><body>";
	echo "<table border='1' cellpadding='3' align='center'>";	
	}

echo "<table border='1' cellpadding='3' align='center'>";

// ******** Show Results ***********

if(@$rep=="")
	{
	include("../menu.php");
	if(@!$budget_group){$budget_group="operating_expenses";}
	
	$sql="SELECT center,parkCode
	FROM center
	WHERE 1 and fund='1280'
	ORDER BY parkCode
	";
	
	unset($menuArray);
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result)){
	$k=$row['center'];
	$menuArray[$k]=$row['parkCode'];}
	
	
	echo "<table border='1' cellpadding='3' align='center'>";
	echo "<form><tr>";
	
	// onChange=\"MM_jumpMenu('parent',this,0)\"
	echo "<td align='center'>Center<br><select name=\"center\">";
	
	foreach($menuArray as $k=>$v){
	if(@$center==$k){$s="selected";}else{$s="value";}
	$con=$v."-".$k;
			echo "<option $s='$con'>$con</option>\n";
		   }
	   echo "</select></td>";
	   
	//echo "<td><a href='$file?budget_group=$budget_group&rep=excel'>Excel Export</a></td>";
	
	//echo "</tr>";
	
	// Menu 1
	$sql="SELECT DISTINCT budget_group
	FROM coa
	WHERE 1 
	and budget_group != 'aid'
	and budget_group != 'buildings/other_structures'
	and budget_group != 'funding'
	and budget_group != 'land'
	and budget_group != 'none'
	and budget_group != 'reserves'
	ORDER BY budget_group
	";
	unset($menuArray);
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result)){
	$menuArray[]=$row['budget_group'];}
	
	if($budget_group){$budget_group_ck=$budget_group;}else{$budget_group_ck="operating_revenues";}
	
	//onChange=\"MM_jumpMenu('parent',this,0)\"
	echo "<td align='center'>Budget Group<br><select name=\"budget_group\">";
	for ($n=0;$n<count($menuArray);$n++){
	if($budget_group_ck==$menuArray[$n]){$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
			echo "<option $s='$con'>$menuArray[$n]</option>\n";
		   }
	   echo "</select></td>";
	   
	echo "<td><input type='submit' name='submit' value='Submit'></td>";
	
	   echo "</tr></form></table>";
	
	}

//exit;

$query="CREATE temporary TABLE `budget`.`year2year_center_level1` (
`center` varchar( 15 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`py1_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`cy_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`lytt_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`budget_group` varchar( 30 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;
";
   $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL){echo "$query<br><br>";};

$query="insert into budget.year2year_center_level1( center, account, py1_amount, cy_amount,lytt_amount ) select center, ncasnum, sum(amount_py1), sum(amount_cy),sum(amount_lytt) from act3 where 1 
and center='$center'
group by ncasnum;
";
   $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL){echo "$query<br><br>";};

$query="update budget.year2year_center_level1,coa set budget.year2year_center_level1.budget_group=coa.budget_group where budget.year2year_center_level1.account=coa.ncasnum;
";
   $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL){echo "$query<br><br>";};

//exit;

$revArray=array("operating_revenues","purchase4resale","grants","reimbursements");


// ****** Body Query
$whereFilter="where 1";

if(!$budget_group){$whereFilter.=" AND year2year_1.budget_group='operating_revenues'";}
else
{$whereFilter.=" AND year2year_1.budget_group='$budget_group'";}

if(in_array($budget_group,$revArray))
	{
	 $query="SELECT -sum( py1_amount ) AS 'py_posted', -sum( lytt_amount ) AS 'lytt_posted', -sum( cy_amount ) AS 'cy_posted', sum(lytt_amount-cy_amount) AS 'yearly_variance' FROM budget.year2year_center_level1 LEFT JOIN coa ON budget.year2year_center_level1.account = coa.ncasnum WHERE 1 AND budget.year2year_center_level1.budget_group='$budget_group'  GROUP BY budget.year2year_center_level1.budget_group;
	";
	}
else
	{
	$query="SELECT sum( py1_amount ) AS 'py_posted', sum( lytt_amount ) AS 'lytt_posted', sum( cy_amount ) AS 'cy_posted', sum(lytt_amount-cy_amount) AS 'yearly_variance' FROM budget.year2year_center_level1 LEFT JOIN coa ON budget.year2year_center_level1.account = coa.ncasnum WHERE 1 AND budget.year2year_center_level1.budget_group='$budget_group'  GROUP BY budget.year2year_center_level1.budget_group;
	";
	}
   $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL){echo "$query<br><br>";};

//Explicitly populate $headerArray instead of dynamic
unset($headerArray);
unset($header);
//$headerArray=array("account","park_acct_desc","py_posted","lytt_posted","cy_posted","yearly_variance");

$headerArray=array("py_posted","lytt_posted","cy_posted","yearly_variance");

$count=count($headerArray);
for($i=0;$i<$count;$i++)
	{
	$h=$headerArray[$i];
	@$header.="<th>".$h."</th>";
	}

echo "<table border='1' align='center'><tr>$header</tr>";

$j=1;
if(@$rep=="excel"){$forceText="'";}
while($row = mysqli_fetch_array($result))
	{
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
	$linkAccount="<a href='year2year_comparison_center_drill.php?account=$account&budget_group=$budget_group' target='_blank'>$account</a>";
	
	echo "
	<td align='right'>$py_posted</td>
	<td align='right'>$lytt_posted</td>
	<td align='right'>$cy_posted</td>";
	echo "<td align='right'>$f1$yearly_variance$f2</td>
	</tr>";
		}// end while
echo "</table>";

// ********************************** Account Query

if(@$showSQL==1){$p="method='POST'";}

echo "<hr><table align='center'><tr>";

$revArray=array("operating_revenues","purchase4resale","grants","reimbursements");


// ****** Body Query
$whereFilter="where 1";

if(!$budget_group){$whereFilter.=" AND year2year_1.budget_group='operating_revenues'";}
else
{$whereFilter.=" AND year2year_1.budget_group='$budget_group'";}

if(in_array($budget_group,$revArray)){
 $query="SELECT budget.year2year_center_level1.account, coa.park_acct_desc, -sum( py1_amount ) AS 'py_posted', -sum( lytt_amount ) AS 'lytt_posted', -sum( cy_amount ) AS 'cy_posted', sum(lytt_amount-cy_amount) AS 'yearly_variance' FROM budget.year2year_center_level1 LEFT JOIN coa ON budget.year2year_center_level1.account = coa.ncasnum where 1 AND budget.year2year_center_level1.budget_group='$budget_group'  GROUP BY budget.year2year_center_level1.account ORDER BY budget.year2year_center_level1.account;
";
}
else
{$query="SELECT budget.year2year_center_level1.account, coa.park_acct_desc, sum( py1_amount ) AS 'py_posted', sum( lytt_amount ) AS 'lytt_posted', sum( cy_amount ) AS 'cy_posted', sum(lytt_amount-cy_amount) AS 'yearly_variance' FROM budget.year2year_center_level1 LEFT JOIN coa ON budget.year2year_center_level1.account = coa.ncasnum where 1 AND budget.year2year_center_level1.budget_group='$budget_group'  GROUP BY budget.year2year_center_level1.account ORDER BY budget.year2year_center_level1.account;
";
}
   $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL){echo "$query<br><br>";}

//Explicitly populate $headerArray instead of dynamic
unset($headerArray);
unset($header);
$headerArray=array("account","park_acct_desc","py_posted","lytt_posted","cy_posted","yearly_variance");

$count=count($headerArray);
for($i=0;$i<$count;$i++)
	{
	$h=$headerArray[$i];
	@$header.="<th>".$h."</th>";
	}

echo "<table border='1' align='center'><tr>$header</tr>";

$j=1;
if(@$rep=="excel"){$forceText="'";}
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
$link_py_posted="<a href='year2year_comparison_py_drill.php?center=$center&account=$account&f_year=$pf_year&desc=$park_acct_desc' target='_blank'>$py_posted</a>";

$link_lytt_posted="<a href='year2year_comparison_lytt_drill.php?center=$center&account=$account&desc=$park_acct_desc' target='_blank'>$lytt_posted</a>";

$link_cy_posted="<a href='year2year_comparison_cy_drill.php?center=$center&account=$account&desc=$park_acct_desc' target='_blank'>$cy_posted</a>";

echo "
<td align='right'>$account</td>
<td align='right'>$park_acct_desc</td>
<td align='right'>$link_py_posted</td>
<td align='right'>$link_lytt_posted</td>
<td align='right'>$link_cy_posted</td>";
echo "<td align='right'>$f1$yearly_variance$f2</td>
</tr>";
	}// end while
echo "</table>";


echo "</body></html>";

?>