<?phpsession_start();$dbTable="stats";$file=$PHP_SELF;$fileMenu="../menu.php";extract($_REQUEST);include("../../../include/parkcodesDiv.inc");// database connection parameterinclude("../../../include/connectATTEND.inc");// database connection parameters$passPark=$parkcode;$level=$_SESSION[attend][level];if($level==1){$parkcode=$_SESSION[attend][select];$parkCode=array("","",$parkcode);}if($level==2){$distCode=$_SESSION[attend][select];$menuList="array".$distCode; $parkCode=${$menuList};sort($parkCode);}// Workaround for ENRI and OCMOif($_SESSION[attend][select]=="ENRI"||$_SESSION[attend][select]=="OCMO"){$parkCode=array("ENRI","OCMO");$parkcode=$passPark;}// Workaround for MOJE and NERIif($_SESSION[attend][select]=="NERI"||$_SESSION[attend][select]=="MOJE"){$parkCode=array("MOJE","NERI");$parkcode=$passPark;}$year=$y;if($passPark!="Division"){$parkVar="and park='$passPark'";$where="WHERE park_id =  '$passPark'";$group=" GROUP  BY `year_month`";}else{$where="WHERE 1";$group=" GROUP  BY park";$entireYear=1;}$sql="SELECT distinct fld_nameFROM  `categories` LEFT  JOIN park_category ON categories.category_id = park_category.category$where";$result = mysql_query($sql);while($row=mysql_fetch_array($result)){$fldName[]=$row[0];}$sql="SELECT left( year_month_week, 6 ) as `year_month`,park";for($i=0;$i<count($fldName);$i++){switch($fldName[$i]){case "comm_hi_temp";$sql.=",max(".$fldName[$i].") as $fldName[$i]";break;case "comm_low_temp";$sql.=",min(".$fldName[$i].") as $fldName[$i]";break;default:$sql.=",sum(".$fldName[$i].") as $fldName[$i]";}}if(!$year){$year=date(Y);}$sql.=" FROM  `stats` WHERE left( year_month_week, 4  ) = '$year' $parkVar$group";//echo "$sql";//exit;$result = mysql_query($sql) or die ("Query failed.");include("$fileMenu");echo "<div align='center'><table>";echo "<tr><th>Division of Parks and Recreation</th></tr>";// Menu 1echo "<tr><td align='center'>Activity for ";echo " <select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">"; echo "<option value='' selected>";                for ($n=0;$n<count($parkCode);$n++)          {$scode=$parkCode[$n];        if($scode=="nonDPR"){$scode="Division";}if($scode==$parkcode){$s="selected";}else{$s="value";}echo "<option $s='$file?y=$y&parkcode=$scode&passM=$month'>$scode\n";          }echo "</select><font color='blue'> $parkCodeName[$parkcode]</font> ";// Menu 2$curYear=date(Y);echo "<select name='year' onChange=\"MM_jumpMenu('parent',this,0)\">";               for ($n=2000;$n<=$curYear;$n++)             //  for ($n=$curYear;$n>=2000;$n--)          {$scode=$n;if($scode==$y){$s="selected";}else{$s="value";}echo "<option $s='$file?y=$scode&parkcode=$parkcode'>$scode\n";          }echo "</select> </form>";echo "</td></tr></table>";if(!$parkcode){exit;}// *********** Show Results *************//print_r($fldName);$numFld=count($fldName)+2;echo "<hr><table cellpadding='1' border='1'>";echo "<tr><td colspan='$numFld' align='center'><font color='purple'>$parkcode for Year $y</font></td></tr>";echo "<tr>";echo "<th>Year_Month</th><th>Park</th>";for($j=0;$j<$numFld-2;$j++){echo "<th>$fldName[$j]</th>";}echo "</tr>";while ($row=mysql_fetch_assoc($result)){// get ASSOC arrayecho "<tr>";for($z=0;$z<count($row);$z++){list($key,$val)=each($row);switch($key){case "year_month";	if($entireYear==1){echo "<td align='right'>Year Total</td>";}else{echo "<td align='right'>$val</td>";}		break;case "park";	echo "<td align='right'>$val</td>";	break;case "comm_precip";	$tot_comm_precip+=$val;	$val=number_format($val,1);case "csw_hours";	$tot_csw_hours+=$val;	$val=number_format($val,1);	echo "<td align='right'>$val</td>";	break;default:	$f="tot_".$key;	${$f}+=$val;	$val=number_format($val);echo "<td align='right'>$val</td>";}	}// end field forecho "</tr>";}// end whileecho "<tr><td>&nbsp;</td><td>&nbsp;</td>";for($j=0;$j<$numFld-2;$j++){switch($fldName[$j]){case "comm_precip";$f="tot_".$fldName[$j];$v=number_format(${$f},1);break;case "csw_hours";$f="tot_".$fldName[$j];$v=number_format(${$f},1);break;default:$f="tot_".$fldName[$j];$v=number_format(${$f});			}echo "<th>$v</th>";}echo "</tr>";echo "</table></div></body></html>";?>