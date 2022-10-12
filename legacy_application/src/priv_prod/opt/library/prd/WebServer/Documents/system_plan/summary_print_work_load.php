<?php

//print_r($_REQUEST);
extract($_REQUEST);

include("menu.php"); // includes auth and session_start

include("../../include/get_parkcodes.php");
session_start();
$level=$_SESSION['system_plan']['level'];

$unitArray=array("State Natural Area", "State Park", "State Recreation Area");
echo "<form><table cellpadding='2'><tr>";

echo "<td align='center'><select name=\"parkcode\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Unit Type...</option>";
foreach($unitArray as $k=>$v){
	if($unit_type==$v){$s="selected";}else{$s="value";}
		echo "<option $s='summary_print_work_load.php?unit_type=$v'>$v</option>";
       }
	if($unit_type=="all"){$s="selected";}else{$s="value";}
		echo "<option $s='summary_print_work_load.php?unit_type=all'>All</option>";
   echo "</select></td></tr></table></form>";


	
if(!$unit_type){exit;}


$database="system_plan";
include("../../include/connectROOT.inc"); // database connection parameters
//echo "c1=$connection";//exit;
  $db = mysql_select_db($database,$connection)
       or die ("Couldn't select database");
$sql="SELECT distinct parkcode
from fac
where 1
order by fld_name";
//echo "$sql"; //exit;
$result = @MYSQL_QUERY($sql,$connection);	
while($row=mysql_fetch_assoc($result)){$printThese[]=$row['parkcode'];}


$skip=array("nonDPR","ARCH","EADI","NODI","SODI","WEDI","PRTF","YORK","WARE");

if($unit_type=="all"){
	foreach($parkCodeName as $k=>$v){
		if($k AND !in_array($k,$skip)){
			$menuArrayPark[]=$k;
		}
	}
	
		$unit_type="Unit";
}

else
{
	foreach($parkCodeName as $k=>$v){
		if($k AND !in_array($k,$skip))
		{
		if(strpos($parkCodeName[$k],$unit_type)>-1){$menuArrayPark[]=$k;}
		if($unit_type=="State Natural Area" and $k=="WEWO"){$menuArrayPark[]=$k;}
		}
	}
}

$count=count($menuArrayPark);
$t1=ceil($count/2)-1; $ut=$unit_type."s";

if($level>4){$file="print_pdf_work_load.php";}else{$file="print_pdf_work_load.php";}
//if($level>4){$file="print_pdf_cell_1.php";}else{$file="print_pdf_cell_1.php";}
//	$file="print_pdf.php";
	echo "<div align='center'><form name='form_2' action='$file' method='POST'>
	<table><tr><td align='center' colspan='5' valign='bottom' height='40'>Print <b>$unit_type</b> Profiles<br />$ut which show a default checkmark have entries for their FACILITIES.</td></tr>
	<tr><td align='center'><input name=\"btn\" type=\"button\" onclick=\"CheckAll_2()\" value=\"Check All\"></td>
	<td align='center'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"reset\" type=\"reset\" value=\"Default\"></td>
	<td align='center'><input name=\"btn\" type=\"button\" onclick=\"UncheckAll_2()\" value=\"Uncheck All\"></td>
	</tr></table>
	";

echo "<table><tr>
<td valign='top'><table border='1' cellpadding='10'>";
foreach($menuArrayPark as $k=>$v){
		echo "<tr>";
		if(in_array($v, $printThese)){$ck="checked";}else{$ck="";}
				echo "<td><input type='checkbox' name='parkcode[$v]' value='x' $ck>&nbsp;$parkCodeName[$v]</td>";
		echo "</tr>";
		if($k==$t1){break;}
		}		
echo "</table></td>";

echo "<td valign='top'><table border='1' cellpadding='10'>";

foreach($menuArrayPark as $k=>$v){
	if($k<=$t1){continue;}
		echo "<tr>";
		if(in_array($v, $printThese)){$ck="checked";}else{$ck="";}
				echo "<td><input type='checkbox' name='parkcode[$v]' value='x' $ck>&nbsp;$parkCodeName[$v]</td>";
		echo "</tr>";				
		}
echo "</table></td>";
	
echo "</tr></table>";

echo "<table align='center'><tr><td align='center'>
<input type='hidden' name='rep' value='1'>
<input type='hidden' name='multi' value='1'>
<input type='submit' name='submit' value='Make PDF for Checked Parks'>
</td></form></tr>
<tr><td>It is best to print in small groups of 5 parks at a time.</td></tr></table>";

echo "</div></html>";
?>