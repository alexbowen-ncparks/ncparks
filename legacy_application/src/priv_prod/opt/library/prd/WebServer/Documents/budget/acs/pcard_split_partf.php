<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // database//include("../../../include/parkcodesDiv.inc");session_start();$level=$_SESSION[budget][level];extract($_REQUEST);//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;if($id){$sql ="SELECT max(projnum) as maxProj FROM `partf_projects`";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$row=mysqli_fetch_array($result); extract($row);$max=substr($maxProj,0,2);//echo "m=$max";exit;}//print_r($_REQUEST);//print_r($_SESSION);echo "<script language=\"JavaScript\"><!--function setForm() {    opener.document.pcardSplitForm.projnum_$transid.value = document.inputForm1.inputField1.value;    opener.document.pcardSplitForm.center_$transid.value = document.inputForm1.inputField2.value;    self.close();    return false;}function MM_jumpMenu(targ,selObj,restore){ //v3.0  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");  if (restore) selObj.selectedIndex=0;}//--></script>";$sql = "SELECT distinct park from partf_projects ORDER BY park";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//$num=mysqli_num_rows($result);	while($row=mysqli_fetch_array($result)){	extract($row);$park=strtoupper($park);	$parkCode[]=$park;	}	echo "<table><tr><td><A HREF=\"javascript:window.print()\"><IMG SRC=\"../bar_icon_print_2.gif\" BORDER=\"0\"</A></td><td><select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";                 for ($n=0;$n<count($parkCode);$n++)          {$scode=$parkCode[$n];$parkArray[]=$scode;    //    if($scode=="ARCH"){$scode="ADM";}if($scode==$parkcode){$s="selected";}else{$s="value";}echo "<option $s='pcard_split_partf.php?parkcode=$scode&transid=$transid'>$scode\n";          }echo "</select></form></td></tr></table>";if($id){$checkBalance=x;include("../b/prtf_center_budget_menu.php");//echo "Hello";exit;$sql = "SELECT projnum,projname,comp,center,budgcode FROM `partf_projects` WHERE partfid='$id'";}else{if($_SESSION[budget][partf]=="CONS"){$parkcode="";$menuCI=1;$where="projcat='ci' and projyn='y' order by center desc";}	else{if($_SESSION[budget][select]=="ADM"||$level==5){$where="park='$parkcode' and projyn='y' order by center desc";}else{$where="park='$parkcode' and (projcat='mm' or projcat='tm' or projcat='er' or projcat='de') and projyn='y' order by center desc";}}// end CONS else$sql = "SELECT projnum,projname,comp,center,center_year_type,budgcode,partfid FROM `partf_projects` WHERE $where";}// end id elseif($parkcode){$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");}//echo "$sql";exit;if($menuCI){ foreach (range('10', $max) as $numBegin) {$numArray1[]=$numBegin."00";$numArray2[]=$numBegin; }//print_r($numArray2);exit;echo "<html><table>";echo "<tr><td><form><select name=\"parkCI\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>[Park] Project Name Begins With:</option>";$s="value";for ($n=0;$n<count($parkArray);$n++){$con="pcard_split_partf.php?parkCI=".$parkArray[$n];		echo "<option $s='$con'>$parkArray[$n]\n";       }          echo "</select></form></td>   <td><form><select name=\"vendor_number\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>[Numeric] Project Number Like:</option>";$s="value";//$numArray1=array("1000","1100","1200","1300","1400","1500","1600","1700","1800","1900","2000");//$numArray2=array("10","11","12","13","14","15","16","17","18","19","20");for ($n=0;$n<count($numArray1);$n++){$con="pcard_split_partf.php?numeric=".$numArray2[$n]."&pc=1";		echo "<option $s='$con'>$numArray1[$n]\n";       }          echo "</select></td></tr></form>";}if($parkCI){$sql = "SELECT park as parkcode,projnum,projname,comp,center,budgcode,partfid FROM `partf_projects` WHERE park ='$parkCI' and projcat='ci' order by projname";}if($numeric){$sql = "SELECT park as parkcode,projnum,projname,comp,center,budgcode,partfid FROM `partf_projects` WHERE projnum LIKE '$numeric%' and projcat='ci' order by projnum";}if($parkCI or $numeric){$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");}//echo "$sql";//exit;if(!$parkcode){$pc="<th>Park</th>";}else{$pc="<th></th>";}echo "<table cellpadding='2'><tr><td align='center' colspan='4'>PARTF Projects for $parkcode</td></tr><tr>$pc<th>Proj. Num.</td><th>Center_Year_Type</th><th>Project Name</th></tr>";$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);$p=strtoupper($projname);$parkcode=strtoupper($parkcode);$center_year_type=strtoupper($center_year_type);if($parkcode){$pc="<td>$parkcode</td>";//$parkcode=$park;}if($num==1){$sel="<br>Show List of Projects";}else{$sel="Select";}echo "<tr>$pc<td><b>$projnum</b></td><td>$center_year_type</td><td>$p <a href='pcard_split_partf.php?id=$partfid&parkcode=$parkcode&center=$center&acs=1&transid=$transid'>$sel</a></td></tr>";}echo "</table>";if($id){echo "<table><form name='inputForm1' onSubmit='return setForm();'>";echo "<tr><td><input name='inputField1' type='text' value='$projnum' size='8' READONLY> Project Number</td></tr><tr><td><input name='inputField2' type='text' value='$center' size='8' READONLY> Center</td></tr>";if($balance>0){echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";}else{$sql = "Select centerman from center where center='$center'";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//echo "$sql";exit;$row=mysqli_fetch_array($result);extract($row);$name=explode("_",$centerman);$fname=ucfirst($name[0]); $lname=ucfirst($name[1]);echo "<tr><td>There are <font color='red'>NO remaining funds</font> in this Center.<br><br><a href='mailto:$name[0].$name[1]@ncmail.net?subject=Insufficient funds for Project $projnum in Center $center for $parkcode'>Email</a> - $fname $lname  if you need to make a payment for this project.</td></tr>";}echo "</table>";}?>