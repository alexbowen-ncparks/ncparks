<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/authBUDGET.inc");extract($_REQUEST);//print_r($_SESSION);EXIT;//print_r($_REQUEST);//EXIT;//print_r($revArrayKey);//EXIT;//echo "<pre>";print_r($revArray);echo "</pre>";//EXIT;$reportTitle=$revArray[$scopeMenu];$fileName=$reportTitle;// *********** Set Scopeif($scopeMenu){list($sect,$scope)=explode("-",$scopeMenu);switch($sect){	case "OPERrev":	$whereSect="AND oxt3_od.section =  'operations'";	$reportTitleSect="Operations";	break;	case "PLADrev":	$whereSect="AND (oxt3_od.section != 'construction' AND oxt3_od.section !=  'operations')";	$reportTitleSect="Planning and Admin";	break;	case "CONSrev":	$whereSect="AND oxt3_od.section = 'Construction'";	$reportTitleSect="Construction";	break;	}switch($scope){	case "east":	$whereScope="AND oxt3_od.dist =  'east'";	$reportTitleScope="East";	break;	case "north":	$whereScope="AND oxt3_od.dist =  'north'";	$reportTitleScope="North";	break;	case "south":	$whereScope="AND oxt3_od.dist =  'south'";	$reportTitleScope="South";	break;	case "west":	$whereScope="AND oxt3_od.dist =  'west'";	$reportTitleScope="West";	break;	case "stwd":	$whereScope="AND oxt3_od.dist =  'stwd'";	$reportTitleScope="STWD";	break;	case "all":	$whereScope="";	$reportTitleScope="All";	break;	}}$sql = "SELECT oxt3_od.parkcode, oxt3_od.ncasnum, oxt3_od.description, oxt3_od.available, parkcode_funding, ncasnum_fundingFROM  `oxt3_od`LEFT  JOIN center ON oxt3_od.center = center.centerWHERE 1  $whereSect $whereScopeAND oxt3_od.available <  '0.00'ORDER  BY oxt3_od.parkcode, oxt3_od.ncasnum ASC";if($showSQL=="1"){echo "$sql<br>";//exit;}$varQuery=$_SERVER[QUERY_STRING];if($rep==""){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='budget_summary.php?$varQuery&rep=excel'>Excel Export</a><br>";}//if($GroupByToggle=="x"){$checkField="ncasnum";}else{$checkField="parkcode";}$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);if($totAvailable==""){$reportTitle=$reportTitleSect." (".$reportTitleScope.")-Revisions Required";echo "<table border='1'><tr><th colspan='8'>$reportTitle</th></tr><tr><th>PARK<BR>CODE</th><th>NCASNUM</th><th>DESCRIPTION</th><th>AVAILABLE</th><th>PARKCODE<br>Funding</th><th>NCASNUM<br>Funding</th></tr>";}$totAvailable=$totAvailable+$available;/*// Track Totals$totAvailable=$totAvailable+$available;// 1// Display SubTotalsif($check!="" AND $check!=$$checkField){$subspent0203totF=number_format($subspent0203tot,2);echo "<tr><td align='right' colspan='7'><b>$subspent0203totF</td></tr>";$subspent0203grand=$subspent0203grand+$subspent0203tot; $subspent0203tot="";}// Format for display$spent0203F=number_format($spent0203,2);*/$available=number_format($available,2);echo "<tr><td align='center'>$parkcode</td><td>$ncasnum</td><td>$description</td><td align='right'>$available</td><td align='right'>$parkcode_funding</td><td align='right'>$ncasnum_funding</td></tr>";/*// Track SubTotals// $subx is used to hold value for last subTotal$subspent0203tot=$subspent0203tot+$spent0203;$check=$$checkField;*/}// end while/*// Format and Display Totals$spent0203totF=number_format($spent0203tot,2);// Print Final SubTotalsecho "<tr><td align='right' colspan='4'><b>$sub1</td></tr>";// Print Grand Totalsif($_SESSION[budget][level]>2){$addText="<br>Addition of displayed subtotals: ";$subspent0203grandF=number_format($subspent0203grand+$subspent0203tot,2);}*/$totAvailableF=number_format($totAvailable,2);echo "<tr><td align='right' colspan='4'>Total: <b>$totAvailableF</b></td><td>&nbsp;</td><td>&nbsp;</td></tr>";echo "</table></body></html>";?>