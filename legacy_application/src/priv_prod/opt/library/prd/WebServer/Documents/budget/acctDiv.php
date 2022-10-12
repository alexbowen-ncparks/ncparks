<?php
//These are placed outside of the webserver directory for security
include("../../include/connectBUDGET.inc");// database connection parameters

extract($_REQUEST);
//echo "Hello";
?>
<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
//-->
</script>

<?php        
$sql = "SELECT center as pn From accounts ORDER BY center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);$centerCode[]=$pn;
}
$pa=array_unique($centerCode);sort($pa);

echo "<html><header></header<title></title><body><table><td><form>Pick a 
 <select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Center</option>";
for ($n=0;$n<count($pa);$n++){$scode=$pa[$n];$s="value";
if($scode==$Xcenter){$s="selected";}// use $center for value in pulldown
		echo "<option $s='acctDiv.php?center=$scode'>$scode\n";
       }
   echo "</select></form></td>";

if($center){
$sql = "SELECT fund as et From acctDiv ORDER BY fund";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);$exty[]=$et;
}
$ea=array_unique($exty);sort($ea);

echo "<td><form>Pick an 
 <select name=\"expenseType\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>ExpenseType</option>";
for ($n=0;$n<count($ea);$n++){$scode=$ea[$n];$s="value";
if($scode==$rcc){$s="selected";}
		echo "<option $s='trans.php?park=$park&rcc=$rcc&expenseType=$scode'>$scode\n";
       }
   echo "</select></form></td>";
   }

echo "<td><form action='series.php'><input type='hidden' name='park' value='$park'><input type='submit' name='submit' value='Return'></form></td>";
// ***** Pick display function and set sql statement

if($park!="" || $rcc!=""){
include_once("transHeader.php");include_once("functionTrans.php");
$z=$park;

//,sum(charges) as sumCharge,sum(credits) as sumCredit GROUP BY rcc 
$sql1 = "SELECT * From parktrans WHERE rcc='$rcc' and expenseType='$expenseType' ORDER BY rcc";}// file for display

include_once("../../include/parkcountyRCC.inc");
$parkRCC=array_flip($parkRCC);
$z=$parkRCC[$rcc];

if($sql1){
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
$num=mysqli_num_rows($result);
if($num>1){echo "<font color='green'>$num Items for $z Expense Type=$expenseType</font><hr>";
}

$var=$_SESSION[budget][select];

// Park Level access
if($var==$park){$accessLevel="2";}else
{$accessLevel="1";}

// District wide access
if($_SESSION[budget][level]=="2"){
include_once("../../include/parkcodesDiv.inc");
$a="array";$b="$var";$distArray=${$a.$b};
if(in_array($park,$distArray)){$accessLevel="2";}else
{$accessLevel="1";}
}

// System wide access
if($_SESSION[budget][level]=="3"){$accessLevel="2";}

$accessLevel=1;
switch($accessLevel){
	case "1":
while ($row=mysqli_fetch_array($result))
{extract($row);
$t=$charges+$credits;
$tot=$tot+$t;
itemShow($rcc,$expenseType,$ncasacct,$effdate,$charges,$credits,$transtype,$invoiceNum,$vendor);}
	break;
	case "2":
while ($row=mysqli_fetch_array($result))
{extract($row);
itemEdit($rcc,$expenseType,$ncasacct,$effdate,$charges,$credits,$transtype,$invoiceNum,$vendor);}
	break;
	default:
	echo "Access denied";exit;
	}// end Switch

}
$tot=number_format($tot,2);
//$newTotal=$sumCharge+$sumCredit;ch=$sumCharge cr=$sumCredit total=$newTotal
echo "Total NCAS Charges = <font color='red'>$tot</font>";
?>