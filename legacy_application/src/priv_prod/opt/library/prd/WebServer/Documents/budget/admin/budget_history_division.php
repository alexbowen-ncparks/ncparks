<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/authBUDGET.inc");extract($_REQUEST);//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;echo "<table align='center'>";// Menu item 0$sql="SELECT DISTINCT f_yearFROM report_budget_historyWHERE 1 AND f_year != '' AND f_year != '9900'ORDER BY f_year"; $result = @mysqli_query($connection, $sql,$connection); while($row=mysqli_fetch_assoc($result)){$menuArray0[]=$row['f_year'];}echo "<pre>f_year ";print_r($menuArray0);echo "<pre>";// Menu item 1$menuArray1[]="disburse";$menuArray1[]="receipt";echo "<pre>cash_type ";print_r($menuArray1);echo "<pre>";// ******** Display Menus **********echo "<tr><td colspan='8' align='center'><form action='/budget/menu.php?forum=blank'><input type='submit' name='submit' value='Return to Home Page'></td></tr></form>";echo "<form method='POST'><tr>";echo "<td>Fiscal Year<br /><select name=\"fiscal_year\">";foreach($menuArray0 as $k => $v){	if($v==$fiscal_year){$s="selected";}else{$s="value";}		echo "<option $s='$v'>$v\n";       }   echo "</select></td>";   echo "<td>Cash Type<br /><select name=\"cash_type\">";foreach($menuArray1 as $k => $v){	if($v==$cash_type){$s="selected";}else{$s="value";}		echo "<option $s='$v'>$v\n";       }   echo "</select></td>";                     echo "<td><input type='submit' name='submit' value='Filter'></td></form>";echo "</form></tr>";if($submit!="Filter"){exit;}$query = "select f_year,cash_type,parkcode,sum(amount) as 'amount'from report_budget_historywhere 1and f_year='$fiscal_year'and cash_type='$cash_type'group by f_year,cash_type,parkcode ";  $result = @mysqli_query($connection, $query,$connection);    echo "<table border=1>";  echo "<tr>        <th>f_year</th>       <th>cash_type</th>	   <th>parkcode</th>	   <th>amount</th>       </tr>";      while ($row=mysqli_fetch_array($result)){    extract($row);echo "<tr>       <td>$f_year</td>	   <td>$cash_type</td>	   <td>$parkcode</td>	   <td>$amount</td>	   	   	 </tr>";} echo "</table></body></html>";  	   	   	   ?>