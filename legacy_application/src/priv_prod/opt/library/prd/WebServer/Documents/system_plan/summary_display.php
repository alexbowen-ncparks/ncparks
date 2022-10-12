<?php

//print_r($_REQUEST);
extract($_REQUEST);

include("menu.php"); // includes auth and session_start

include("../../include/parkcodesDiv.inc");


// ******** Enter your SELECT statement here **********

foreach($parkCodeName as $k=>$v){
	if($k){$menuArrayPark[]=$k;}
}
	
echo "<form><table cellpadding='2'><tr>";

echo "<td align='center'><select name=\"parkcode\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Unit...</option>";
foreach($menuArrayPark as $k=>$v){
	if($parkcode==$v){$s="selected";}else{$s="value";}
		echo "<option $s='print_pdf_cell.php?parkcode=$v&rep=1'>$parkCodeName[$v]</option>";
       }
   echo "</select></td></tr></table></form>";



?>