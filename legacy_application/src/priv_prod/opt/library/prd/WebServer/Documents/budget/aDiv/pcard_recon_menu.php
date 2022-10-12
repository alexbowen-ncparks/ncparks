<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}
$tempID=$_SESSION['budget']['tempID'];
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$m="pcard";
if(!isset($parkcode)){$parkcode="";}
//extract($_REQUEST);
if($level==1)
	{
	$admin_num=$_SESSION['budget']['select'];
	if($_SESSION['budget']['select']=="NERI" and ($parkcode=="NERI" or $parkcode=="MOJE"))
		{$admin_num=$parkcode;}
	}

if($level>1){$admin_num=$parkcode;}
if($beacnum=='60033009'){$admin_num='WAHO'; $parkcode='WAHO'; } //jessie summers (waho)

if(@$submit=="Produce_Page_to_Print"){
$sql = "SELECT xtnd_start,xtnd_end
from pcard_report_dates
where report_date='$report_date'";
$total_result = @mysqli_query($connection, $sql) or die("Error #1". mysql_errno() . ": " . mysqli_error());

//print_r($_REQUEST);echo "$sql a=$admin_num";exit;

$row = mysqli_fetch_array($total_result);
extract($row);

echo "<table><tr><td>Div. of Parks & Recreation PCARD Reconciliation for period from $xtnd_start to $xtnd_end</td></tr></table>";
}
else
{
include("../menu_js.php");
//include("../menu.php");
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;

//Allow Level>1 to have correct park show in input box

// Make f_year
if(@$f_year==""){
include("../~f_year.php");
}
$menu_new='RPurc';
include ("../../budget/menu1415_v1.php");
if($beacnum=='60033009'){$level=1; } //jessie summers (waho)
//include("1418.html");
echo "<style>";
//echo "input[type='text'] {width: 200px;}";

echo "</style>";


echo "<br />";

include("../../budget/acs/pcard_new_menu1.php");
echo "<br />";
//include("../../budget/infotrack/slide_toggle_procedures_module2_pid74.php");

echo "<div align='center'><br><font color='green'>PCARD Reconciliation ONLINE Form</font><hr><font size='-1'>Please email Tony Bass with any problems you encounter. Email comments to <a href='mailto:tony.p.bass@ncmail.net?subject=Comments to Administrator-PCARD Reconciliation Tool'>Administrator</a></font>";

echo "<table><form><tr>";

// Menu 1
$sql = "Select distinct(report_date) as rd
from pcard_report_dates
where 1 and active='y'
order by report_date desc";
$total_result = @mysqli_query($connection, $sql) or die("Error #1". mysql_errno() . ": " . mysqli_error());
//echo "$sql";exit;

while($row = mysqli_fetch_array($total_result)){
$menuArray[]=$row['rd'];}
//print_r($menuArray);exit;
echo "<td align='center'>Report Date<br><select name=\"report_date\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if(@$report_date==$menuArray[$n]){$s="selected";}else{$s="value";}
$con="/budget/acs/pcard_recon.php?report_date=$menuArray[$n]";
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";

if(@$report_date)
	{
	// Menu 2
	$sql = "SELECT xtnd_start,xtnd_end
	from pcard_report_dates
	where report_date='$report_date'";
	$total_result = @mysqli_query($connection, $sql) or die("Error #1". mysql_errno() . ": " . mysqli_error());
	//echo "$sql";exit;
	
	$row = mysqli_fetch_array($total_result);
	extract($row);
	
	echo "<td align='center'>Xtnd Start:<br><input type='text' name='xtnd_start' value='$xtnd_start' size='12'></td>";
	
	echo "<td align='center'>Xtnd End:<br><input type='text' name='xtnd_end' value='$xtnd_end' size='12'></td>";
	
	if(!isset($cardholder)){$cardholder="";}
	//echo "<td>Admin Unit:<br><input type='text' name='admin_num' value='$admin_num' size='6'></td><td>Cardholder Last Name:<br><input type='text' name='cardholder' value='$cardholder' size='17'></td>";
	echo "<td>Admin Unit:<br><input type='text' name='admin_num' value='$admin_num' size='6'></td><td>Cardholder Last Name:<br><input type='text' name='cardholder' value='$cardholder' size='17'></td>";
	
	unset($menuArray);$menuArray=array("1656","1669","1656-Travel");
	//print_r($menuArray);exit;
	echo "<td align='center'>Report Type<br><select name=\"report_type\">
	<option selected></option>";
	for ($n=0;$n<count($menuArray);$n++){
	if(@$report_type==$menuArray[$n]){$s="selected";}else{$s="value";}
	$con="$menuArray[$n]";
			echo "<option $s='$con'>$menuArray[$n]</option>\n";
		   }
	   echo "</select></td>";
	   
	echo "<td><input type='submit' name='submit' value='Find'>
	</form></td>";
	}
echo "</tr></table><hr>";
}// end else Print
?>