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
extract($_REQUEST);
$file=$_SERVER['PHP_SELF'];

//$test="warehouse_billings_".$varFY;
$test="warehouse_billings_2";
$sql1 = "SHOW  TABLE  STATUS  FROM budget LIKE '$test'";
$result1 = mysqli_query($connection, $sql1) or die ("Couldn't execute query 1. $sql1");
$row1=mysqli_fetch_array($result1);
extract($row1); if($Name==""){$message="The database does not have any data for that fiscal year. If you know data exist for that year, contact the admin and report the problem.";}

//print_r($_SESSION);//EXIT;
//print_r($_REQUEST);//EXIT;

// ************* Account Display *****************
if($acct){

$sql1 = "SELECT * from warehouse_billings_2 where center='$center' and acct='$acct' and f_year=$varFY";
//echo "$sql1<br>";//EXIT;
$result1 = mysqli_query($connection, $sql1) or die ("Couldn't execute query 1. $sql1");

$colHeaders=array("ACCT.<br>Number","Invoice<br>Number","Product<br>Number","Product<br>Name","Price","Quantity","Price<br>x<br>Quantity");

portalHeader($colHeaders,$center,$varFY);

while ($row1=mysqli_fetch_array($result1))
{extract($row1);
$totalWH=$totalWH+$PricexQuantity;
echo "<tr><td>$acct</td><td>$InvoiceNum</td><td>$ProductNum_0405</td><td>$ProductName</td><td align='right'>$Price</td><td align='right'>$Quantity</td><td align='right'>$PricexQuantity</td></tr>";
}
echo "<tr><td colspan='6'>&nbsp;</td><td align='right'>$totalWH</td></tr><tr><td colspan='7' align='center'>Close this window when done viewing.</td></tr></table></body></html>";
exit;}

// ************* Summary Display *****************
$sql="OPTIMIZE  TABLE  `exp_rev`,`inc_dec`";
$result = mysqli_query($connection, $sql);

// Creates the last 4 Fiscal Years
date_default_timezone_set('America/New_York');

$sql="SELECT min( acctdate )  AS minDate FROM `exp_rev`";
$result = mysqli_query($connection, $sql);
$row=mysqli_fetch_array($result);extract($row);
$year1=substr($minDate,0,4);$year2=date('Y');$numYear=$year2-$year1;
$today=date('Ymd');$compare=$year2."0630";$year3=$year2+1;
if($today<=$compare){
$y0=substr($year2-4,2,4);
$y1=substr($year2-3,2,4);$fy1=$y0.$y1;
$y2=substr($year2-2,2,4);$fy2=$y1.$y2;
$y3=substr($year2-1,2,4);$fy3=$y2.$y3;
$y4=substr($year2,2,4);$fy4=$y3.$y4;
//echo "less t=$today c=$compare 1=$fy1 2=$fy2 3=$fy3 4=$fy4 c=$y4 Y=$year2";
}

else{
$y0=substr($year2-3,2,4);
$y1=substr($year2-2,2,4);$fy1=$y0.$y1;
$y2=substr($year2-1,2,4);$fy2=$y1.$y2;
$y3=substr($year2,2,4);$fy3=$y2.$y3;
$y4=substr($year2+1,2,4);$fy4=$y3.$y4;
//echo "<br>more t=$today c=$compare 1=$fy1 2=$fy2 3=$fy3 4=$fy4 c=$y4 Y=$year2";
}

$currFY=$fy4; $prevFY=$fy3;
$f=array($fy4,$fy3,$fy2,$fy1);
//print_r($f);
if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=warehouse.xls');
}

// *********** Level > 2 ************
if($_SESSION['budget']['level']>2){//print_r($_REQUEST);EXIT;
$sql="SELECT  DISTINCT section FROM  `center`";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);
$sectArray1[]="sect-x-".$section;
$sectArray2[]=$section."-NCAS#";
$sectArray3[]="sect-y-".$section;
$sectArray4[]=$section."-PARK";
}

if($rep==""){
include_once("../menu.php");
echo "<div align='center'><table><form action=\"$file\">";
$array1=array("east-x","north-x","south-x","west-x","east-PARK","north-PARK","south-PARK","west-PARK");
$array2=array("EADI-NCAS#","NODI-NCAS#","SODI-NCAS#","WEDI-NCAS#","EADI-PARK","NODI-PARK","SODI-PARK","WEDI-PARK");

$menuArray1=array_merge($array1,$sectArray1);
$menuArray1=array_merge($menuArray1,$sectArray3);
$menuArray2=array_merge($array2,$sectArray2);
$menuArray2=array_merge($menuArray2,$sectArray4);

// Menu 1
echo "<td>Scope: <select name=\"scopeMenu\"><option selected></option>";$s="value";
for ($n=0;$n<count($menuArray2);$n++){
$con=$menuArray1[$n];
		echo "<option $s='$con'>$menuArray2[$n]\n";
       }
   echo "</select></td>";

// Menu 2
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

echo "<td><select name=\"center\"><option selected>Select Center</option>";$s="value";
for ($n=0;$n<count($c);$n++){
$con=$c[$n];
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
       }
   echo "</select></td>";
  
// Menu 3

echo "<td><select name=\"varFY\">";$s="value";
for ($n=0;$n<count($f);$n++){
$con=$f[$n];if($con==$varFY){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$con\n";
       }
   echo "</select>";
echo "<input type='hidden' name='m' value='trans_post'><input type='submit' name='submit' value='Submit'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='showSQL' value='1'>Show SQL</form></td></tr></table>";
}
// *********** Set Scope
list($dist_sect,$orderByToggle)=explode("-",$scopeMenu);
if($orderByToggle=="x" || $orderByToggle=="NCAS"){
$GroupByToggle="x";
$orderBy="ORDER BY oxt3.ncasnum,center.dist,center.parkcode";
if($dist_sect!="sect"){$limitWhere=" AND center.section='operations'";}
}
else{$orderBy="ORDER BY center.parkcode,oxt3.ncasnum";}

if($scopeMenu){
list($dist_sect,$orderByToggle,$sect)=explode("-",$scopeMenu);
if($dist_sect=="sect"){$whichCenter="AND center.section='$sect'";}
else{$whichCenter="AND center.dist='$dist_sect'";}
}
else{$whichCenter="AND center.center='$center'";$orderBy="ORDER BY oxt3.ncasnum";}

if($center==""){exit;}
}// end Level > 2


// ************* Level 2 *****************
if($_SESSION['budget']['level'] == 2)
	{
	//print_r($_REQUEST);EXIT;
	if($rep=="")
		{
		include_once("../menu.php");
		include_once("../../../include/parkRCC.inc");
		
		$distCode=$_SESSION['budget']['select'];
		echo "<table><form action=\"$file\">";
		switch($distCode){
		case "EADI":
		$distCode="east";
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
		$D=$distCode."-NCAS";
		$DP=$distCode."-PARK";
		
		$array1=array($D,$DP);
		
		// Menu 1
		echo "<td>Scope: <select name=\"scopeMenu\"><option selected></option>";$s="value";
		for ($n=0;$n<count($array1);$n++){
		$con=$array1[$n];if($con==$scopeMenu){$s="selected";}else{$s="value";}
				echo "<option $s='$con'>$array1[$n]\n";
			   }
		   echo "</select></td>";
		   
		$parkList=$_SESSION['budget']['select'];
		$da=${"array".$parkList}; //print_r($da);exit;
		while (list($key,$val)=each($da)){
		$parkList=$parkList.",".$val;}
		$where="where FIND_IN_SET(center.parkCode,'$parkList')>''";
		
		// Menu 2
		$sql="SELECT section,parkcode,center as varCenter from center $where order by section,parkcode,center";
		
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
		while ($row=mysqli_fetch_array($result)){
		extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}
		
		echo "<td><select name=\"center\"><option selected>Select Center</option>";$s="value";
		for ($n=0;$n<count($c);$n++){
		$con=$c[$n];if($con==$center){$s="selected";}else{$s="value";}
				echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
			   }
		   echo "</select></td>";
		   
		
		// Menu 3
		
		echo "<td><select name=\"varFY\">";$s="value";
		for ($n=0;$n<count($f);$n++){
		$con=$f[$n];if($con==$varFY){$s="selected";}else{$s="value";}
				echo "<option $s='$con'>$con\n";
			   }
		   echo "</select></td>";
		   
		$dist_sect=$_SESSION['budget']['select'];
		echo "<td><input type='hidden' name='m' value='trans_post'>
		<input type='hidden' name='dist_sect'value='$dist_sect'>
		<input type='submit' name='submit'value='Submit'></form></td></tr></table>";
		}
	// *********** Set Scope
	list($dist_sect,$orderByToggle)=explode("-",$scopeMenu);
	if($orderByToggle=="NCAS"){
	$GroupByToggle="x";
	$orderBy="ORDER BY oxt3.ncasnum,center.dist,center.parkcode";
	if($dist_sect!="sect"){$limitWhere=" AND center.section='operations'";}
	}
	else{$orderBy="ORDER BY center.parkcode";}
	
	if($scopeMenu)
		{
		list($dist_sect,$orderByToggle,$sect)=explode("-",$scopeMenu);
		if($dist_sect=="sect")
			{$whichCenter="AND center.section='$sect'";}
			else
			{$whichCenter="AND center.dist='$dist_sect'";}
		}
		else
		{$whichCenter="AND center.center='$center'";}
	
	if($center==""){exit;}
	}// end Level = 2


// *********** Level 1 ************
if($_SESSION['budget']['level']==1)
	{
	include_once("../menu.php");
	include_once("../../../include/parkcountyRCC.inc");
	include_once("subDist.php");
	$whichCenter="AND center.center='$center'";
	}// end Level = 1

// *******************

list($distName,$orderBy)=explode("-",$scopeMenu);
if($orderBy=="PARK"){
$g="GROUP  BY warehouse_billings_2.center,warehouse_billings_2.acct";}
else{
$g="GROUP  BY warehouse_billings_2.acct,warehouse_billings_2.center";}

if(!$submit){exit;}
if($message){echo $message;exit;}

// ******** Get Amount Spent in Last Year
mysqli_select_db($connection, $database); // database
$fromSQL1="center.center,description,parkcode,coa.ncasnum,sum(price * quantity) as pq FROM `warehouse_billings_2`";

$join1="LEFT JOIN coa ON coa.ncasnum = warehouse_billings_2.acct";
$join2="LEFT JOIN center ON center.center = warehouse_billings_2.center";

$sql = "SELECT $fromSQL1 $join1 $join2 where 1 and f_year='$varFY' $whichCenter $g";

if($showSQL=="1"){
echo "$sql<br>";//exit;
}

$varQuery=$_SERVER['QUERY_STRING'];

if($rep==""){
echo "<a href='$file?$varQuery&rep=excel'>Excel Export</a><br><br>";}

portalHeader($colHeaders,$center,$varFY);

if($GroupByToggle=="x"){$checkField="ncasnum";}else{$checkField="parkcode";}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql".mysqli_error());
$num=mysqli_num_rows($result);
if($num<1){echo "<br>No warehouse purchases for that Fiscal Year.";exit;}
while($row=mysqli_fetch_array($result)){
extract($row);

$totalWH=$totalWH+$pq;

$link="<a href=\"warehouse.php?center=$center&acct=$ncasnum&varFY=$varFY\" onClick=\"popup = window.open('warehouse.php?center=$center&acct=$ncasnum&varFY=$varFY', 'PopupPage', 'height=800,width=700,scrollbars=yes,resizable=yes'); return false\" target=\"_blank\"> $ncasnum</a>";

if($orderBy=="PARK"){
if($parkcode==$check1 || $check1==""){
$subTot=$subTot+$pq;}
else{
$subTotF=number_format($subTot,2);

echo "<tr><td>&nbsp;</td><td></td><td align='right'>SubTotal:</td>
<td align='right'><b>$subTotF</b></td></tr>";
$Total=$Total+$subTot;
$subTot=$pq;}

echo "<tr><td align='center'>$parkcode</td><td>$link</td><td>$description</td><td align='right'>$pq</td></tr>";
$check1=$parkcode;
}// end PARK
else
{
if($ncasnum==$check2||$check2==""){
$subTot=$subTot+$pq;}
else{
$subTotF=number_format($subTot,2);
echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td align='right'>SubTotal:</td>
<td align='right'><b>$subTotF</b></td></tr>";
$Total=$Total+$subTot;
$subTot=$pq;}

echo "<tr><td align='center'>$parkcode</td><td>$link</td><td>$description</td><td align='right'>$pq</td></tr>";
$check2=$ncasnum;
}// end NCAS
}// end while

$subTotF=number_format($subTot,2);
$TotF=number_format($Total+$subTot,2);
echo "<tr><td>&nbsp;</td><td></td><td align='right'>SubTotal:</td>
<td align='right'><b>$subTotF</b></td></tr>
<tr><td>&nbsp;</td><td></td><td align='right'>Total:</td>
<td align='right'><b>$TotF</b></td></tr>";

echo "</table></div></body></html>";

// ************** Function ******************
function portalHeader($colHeaders,$center,$varFY){

global $numOfColumns;

$fld=explode(",",$colHeaders);// Put Field Names in an Array
$c=count($fld)-1;$lastFld=$fld[$c];
$numOfColumns=count($colHeaders);

//$qString1="portalReport.php?$_SERVER[QUERY_STRING]&orderBy=1";
//$qString2="portalReport.php?$_SERVER[QUERY_STRING]&orderBy=2";

echo "Warehouse Purchases for FY $varFY

<table border='1' cellpadding='3' align='center'><tr>";
for($x=0;$x<$numOfColumns;$x++){
$var=strtoupper($colHeaders[$x]);echo "<th>$var</th>";}
echo "</tr>";
}
?>