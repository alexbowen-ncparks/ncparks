<?phpextract($_REQUEST);session_start();	if($runStep11=="x"){	$_SESSION['budget']['backup']['step'][$aVar2]=1;	$_SESSION['budget']['backup']['D']=1;	header("Location: menu_backup.php");exit;	}	include("../../~f_year.php");$r1="<font color='red'>"; $f="</font>";$b1="<font color='blue'>"; $g1="<font color='green'>"; $p1="<font color='purple'>"; if($varFY){$_SESSION['budget']['backup']['fy']=$varFY;}if($varDC){$_SESSION['budget']['backup']['date_clean']=$varDC;}if($varDS){$_SESSION['budget']['backup']['date_start']=$varDS;}if($varDE){$_SESSION['budget']['backup']['date_end']=$varDE;}if($varDR){$_SESSION['budget']['backup']['date_report']=$varDR;}//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;$fy=$_SESSION['budget']['backup']['fy'];$dc=$_SESSION['budget']['backup']['date_clean'];$ds=$_SESSION['budget']['backup']['date_start'];$de=$_SESSION['budget']['backup']['date_end'];$dr=$_SESSION['budget']['backup']['date_report'];echo "<html><table>";echo "<tr><th colspan='5'>Establish Variables for Pcard Recon<th></tr>";echo "<form><tr><td align='right'>Fiscal Year => <input type='text' name='varFY' value='$fy' size='5'></td></tr><tr><td>PC Recon Date => <input type='text' name='varDC' value='$dc' size='8'></td></tr><tr><td>pcard_recon_start_date => <input type='text' name='varDS' value='$ds' size='8'></td></tr><tr><td>pcard_recon_end_date => <input type='text' name='varDE' value='$de' size='8'></td></tr><tr><td>pcard_recon_report_date => <input type='text' name='varDR' value='$dr' size='8'></td></tr><tr><td><input type='submit' name='submit' value='Set Variables'></form></td></tr>";if(!$_SESSION['budget']['backup']['fy']){exit;}else{$fy=$_SESSION['budget']['backup']['fy'];}if(!$_SESSION['budget']['backup']['date_clean']){exit;}if(!$_SESSION['budget']['backup']['date_start']){exit;}if(!$_SESSION['budget']['backup']['date_end']){exit;}if(!$_SESSION['budget']['backup']['date_report']){exit;}echo "<pre>";print_r($_SESSION);echo "</pre>";exit;// Step 0$aVar1="array";$aVar2=0; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("delete from budget.cab_dpr where f_year='$fy'","truncate table budget.cab_dpr_center","delete from budget.bd725_dpr where f_year='$fy'","truncate table budget.xtnd_po_encumbrances","truncate table budget.pcard_unreconciled_xtnd","truncate table xtnd_ci_monthly_manual");	if($thisStep=="x"){	$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // database		foreach($thisArray as $k=>$v){		$sql=$thisArray[$k]; //echo "$sql</br>";		//$result = mysqli_query($connection, $sql);		//$array0[$k].="</font> <font color='green'>completed";		}		$_SESSION['budget']['backup']['step'][$aVar2]=1;	}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>0.</td><td>$p1 Delete OLD Data from existing Tables:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][0]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Run Queries'></form>	</td></tr>";}// Step 1$aVar1="array";$aVar2=1; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open XTND Report=Cert Auth Budg Fund Det Cur Mnth (filter: fund 2235)<br />Retrieve current balance in Fund<br />Type fund balance in TABLE=xtnd_ci_monthly_manual","Open XTND Report=Capital Improvements Curr Mnth (filter: fund 4g26)<br />Retrieve current balance in Fund<br />Type fund balance in TABLE=xtnd_ci_monthly_manual");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Update Table=xtnd_ci_monthly_manual as follows:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}// Step 2$aVar1="array";$aVar2=2; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open SQL Table=cab_dpr & Insert TEXT File= cab_fund");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}// Step 3$aVar1="array";$aVar2=3; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open SQL Table=cab_dpr_center & Insert TEXT File= cab_center");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}	// Step 4$aVar1="array";$aVar2=4; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open SQL Table=bd725_dpr & Insert TEXT File=bd725");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}	// Step 5$aVar1="array";$aVar2=5; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open SQL Table=xtnd_po_encumbrances & Insert TEXT File=encumbrances");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}	// Step 6$aVar1="array";$aVar2=6; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open SQL Table=pcard_unreconciled_xtnd & Insert TEXT File=pcu");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}	// Step 7$aVar1="array";$aVar2=7; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open SQL Table=warehouse_billings_2 & Insert TEXT File=warehouse");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}// Step 8$aVar1="array";$aVar2=8; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Open SQL Table=warehouse_billings_2 & Insert TEXT File=warehouse");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}	// Step 9$aVar1="array";$aVar2=9; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Go to Admin LINK & dowload data from Tab le=exp_rev_down to Table=exp_rev");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Insert TEXT File:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}// Step 10$aVar1="array";$aVar2=10; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Rename Table=exp_rev as exp_rev_ws");	if($thisStep=="x"){$_SESSION['budget']['backup']['step'][$aVar2]=1;}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Rename Table:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}// Step 11$aVar1="array";$aVar2=11; $script_name="runStep".$aVar2;$thisArray=${$aVar1.$aVar2};$thisStep=$_REQUEST[$script_name];$thisArray=array("Rename Table=exp_rev backup as exp_rev");	if($thisStep=="x"){	$_SESSION['budget']['backup']['step'][$aVar2]=1;	$_SESSION['budget']['backup']['C']=1;	//include("menu_backup.php");exit;	}		if($_SESSION['budget']['backup']['step'][$aVar2]==1){	foreach($thisArray as $k=>$v){$thisArray[$k].="</font> <font color='green'>completed";}	}echo "<tr><td align='right'>$aVar2.</td><td>$p1 Rename Table:$f</td></tr>";	foreach($thisArray as $key=>$value){	echo "<tr><td></td><td align='right' valign='top'>$key.</td><td>$b1 $thisArray[$key]$f</td></tr>";}	if(!$_SESSION['budget']['backup']['step'][$aVar2]){echo "<tr><td></td>	<td><form><input type='hidden' name='$script_name' value='x'>	<td><form><input type='submit' name='submit' value='Steps Completed'></form>	</td></tr>";}echo "</table></html>";?>