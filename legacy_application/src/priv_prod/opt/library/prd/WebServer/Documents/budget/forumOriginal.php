<?php//These are placed outside of the webserver directory for securityinclude("../../include/authBUDGET.inc"); // used to authenticate usersinclude("../../include/connectBUDGET.inc");// database connection parameters//include("menu.php");//echo "<pre>";print_r($_REQUEST);//print_r($_SESSION);echo "</pre>";//exit;//print_r($_SERVER);exit;//$k=urldecode($_SERVER[QUERY_STRING]);extract($_REQUEST);//include("css/TDnull.inc");include("menu.php");//********** SET Variables **********$dbName="budget";// DATABASE NAME$dbTable="forum";// TABLE NAME could be passed from URL, but we want to lock in a table for this file//**** PROCESS  a Reply ******if($submitReply=="Submit"){$topic=addslashes($topic);$submission=addslashes($submission);$query = "INSERT INTO forum set topic='$topic',submitter='$checkName',submission='$submission', weblink='$weblink',submisID='$submisID', personID='$checkName',dateCreate=now(),replier='$submitter'";//echo "$query";exit;$result = mysqli_query($connection, $query) or die ("Couldn't execute query Update. $query");$v=mysql_insert_id();//header("Location: forum.php?dbTable=$dbTable&$recordIDfld=$v");//exit;}if($submit==""){// ********** This displays all entries in DESC order **********$sql1 = "SELECT * from forum order by dateCreate desc";include_once("forumFunctions.php");echo "<table><h3>The BUDGET Forum</h3><h4>Information to help you manage your budget.</h4></table>";echo "<table border='1' cellpadding='5'><tr>";$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$numFlds=mysqli_num_rows($result);$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");$num=mysqli_num_rows($result);while ($row=mysqli_fetch_array($result)){itemShow($row);}exit;}// FIELD NAMES are stored in $fieldArray// FIELD TYPES and SIZES are stored in $fieldType$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$numFlds=mysqli_num_rows($result);while ($row=mysqli_fetch_assoc($result)){extract($row);$fieldArray[]=$row[Field];$fieldType[]=$row[Type];}$recordIDfld=$fieldArray[$numFlds-1];makeUpdateFields($fieldArray);// MAKE FIELD=VALUE FOR ADD/UPDATEfor($dk=0;$dk<count($fieldType);$dk++){$varD=substr($fieldType[$dk],0,7);//if($varD=="decimal"){$fieldDecimal[]=$dk;}if($varD=="varchar"){$size=substr(substr($fieldType[$dk],8,7),0,-1);if($size>30){$size=30;}$fieldSize[]=$size;}else{$fieldSize[]=12;}}//print_r($fieldSize);//exit; //**** Process any Delete ******if($submit=="Delete"){//print_r($_REQUEST);exit;$query = "DELETE FROM $dbTable where $recordIDfld='$deleteRecordID'";//echo "$query";exit;$result = mysqli_query($connection, $query) or die ("Couldn't execute query Delete. $query");header("Location: forum.php?dbTable=$dbTable");exit;}//**** Formulate a Reply ******if($submit=="reply"){//print_r($_REQUEST);//exit;$sql = "SELECT * from forum where forumID='$var' group by forumID";//echo "s=$sql";exit;$result = mysqli_query($connection, $sql) or die ("Couldn't execute query Select. $sql");$row=mysqli_fetch_array($result);extract($row);$displaySubmitter=substr($submitter,0,-2);echo "<table><tr><td colspan='3'>You are replying to this submission:</td></tr><tr><td>Topic: $topic</td><td>Submitted by: $displaySubmitter</td></tr><tr><td>Comment: $submission</td></tr>";echo "</table><hr>";echo "<form action=\"forum.php\" method=\"post\">";//echo "<form action=\"forum.php\"";// Used to debug$checkName=$_SESSION[budget][tempID];echo "<table><tr><td colspan='3'>Enter your reply below:</td></tr><tr><td>Reply from: $checkName</td></tr><tr><td>Re: $topic</td></tr><tr><td>Submission: <br><textarea name=\"submission\" cols=\"80\" rows=\"10\"></textarea></td></tr>";echo "<tr><td>Website(s):<input type=\"text\" name=\"weblink\" size=\"50\" value=\"\"></td></tr>";$pos=strpos($topic,"Re: ");if($pos>-1){$topic=$topic;}else{$topic="Re: ".$topic;}if($submisID>0){$forumID=$submisID;}echo "<td width='30%'>&nbsp;<input type='hidden' name='checkName' value='$checkName'><input type='hidden' name='submitter' value='$submitter'><input type='hidden' name='submisID' value='$forumID'><input type='hidden' name='topic' value='$topic'><input type='submit' name='submitReply' value='Submit'></form></td>";echo "</tr></table>";exit;} //**** Process any Edit or Add ******if($submit=="Update"){//print_r($_REQUEST);exit;$v=${$lastFld};$arr1=explode(",",$updateFields);for($j=0;$j<count($arr1);$j++){$arr2=explode("=",$arr1[$j]);$arr3[]=$arr2[0];}for($j=0;$j<count($arr1);$j++){$val1=addslashes($_REQUEST[$arr3[$j]]);$newQuery[$arr3[$j]]=$val1;}$arrKeys=array_keys($newQuery);$queryString=$arrKeys[0]."='".$newQuery[$arrKeys[0]]."'";for($j=1;$j<count($arrKeys);$j++){switch ($arrKeys[$j]) {		case "dateCreate":$queryString.=", ".$arrKeys[$j]."=now()";			break;			case "personID":$personID=$_SESSION[budget][tempID];$queryString.=", ".$arrKeys[$j]."='$personID'";			break;				default:			$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";}// end Switch}//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";//print_r($newQuery);exit;$query = "Update $dbTable set $queryStringwhere $lastFld='$v'";//echo "$query";exit;$result = mysqli_query($connection, $query) or die ("Couldn't execute query Update. $query");header("Location: forum.php?dbTable=$dbTable&$lastFld=$v");exit;}//**** Process any Add ******if($submit=="Add"){$arr1=explode(",",$updateFields);for($j=0;$j<count($arr1);$j++){$arr2=explode("=",$arr1[$j]);$arr3[]=$arr2[0];}for($j=0;$j<count($arr1);$j++){$val1=addslashes($_REQUEST[$arr3[$j]]);$newQuery[$arr3[$j]]=$val1;}$arrKeys=array_keys($newQuery);$queryString=$arrKeys[0]."='".$newQuery[$arrKeys[0]]."'";for($j=1;$j<count($arrKeys);$j++){switch ($arrKeys[$j]) {		case "dateCreate":$queryString.=", ".$arrKeys[$j]."=now()";			break;			case "personID":$personID=$_SESSION[budget][tempID];$queryString.=", ".$arrKeys[$j]."='$personID'";			break;				default:			$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";}// end Switch}//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";//print_r($queryString);exit;$query = "INSERT INTO $dbTable set $queryString";//echo "$query";exit;$result = mysqli_query($connection, $query) or die ("Couldn't execute query Update. $query");$v=mysql_insert_id();if($difFile){header("Location: forumReport.php?dbReport=Center&center=$center&submit=Submit&rccYN=Y");}else{header("Location: forum.php?dbTable=$dbTable&$recordIDfld=$v");}exit;}//**** Prepare To Find, Update OR Delete******if($lastFld){//print_r($_REQUEST);exit;$formType="Update";$passSQLedit=urlencode($passSQL);$addDeleteButton="<td><form><input type='hidden' name='passSQL' value='$passSQLedit'><input type='hidden' name='$lastFld' value='$var'><input type='hidden' name='deleteRecordID' value='$var'><input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></form></td>";$sql0 = "SELECT * from $dbTable where $lastFld='$var'";$result = mysqli_query($connection, $sql0) or die ("Couldn't execute query 0. $sql0");$row=mysqli_fetch_array($result);extract($row);//print_r($row);exit;}if($submit=="add"){$addButton="<td><input type='submit' name='submit' value='Add'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}if($submit=="find"){$addButton="<td><input type='hidden' name='personID' value=''><input type='hidden' name='submitter' value=''><input type='hidden' name='like[0]' value='1'><input type='hidden' name='like[2]' value='1'><input type='hidden' name='like[3]' value='1'><input type='submit' name='submit' value='Search'></form></td>";}/*function pullDown($m){global $like,$statusForum;$menu1=array("Is In","Not");// ,"Range"$menu2=array("like","not");// ,"Range"if($like[$m]=="Is In"){$like[$m]=1;}if($like[$m]=="Not"){$like[$m]=2;}//if($like[$m]=="Not"){$like[$m]=3;}echo "<select name=\"like[$m]\"><option selected></option>";for ($n=0;$n<count($menu1);$n++){$con=$n+1;if($con==$like[$m]){$s="selected";}else{$s="value";}echo "<option $s='$con'>$menu1[$n]\n";       }  echo "</select>";  }// end function pullDown}else{*/function pullDown($m){// blank}//}// Used \" instead of ' because of lastname or vendor name containing 'echo "<form action=\"forum.php\" method=\"post\">";//echo "<form action=\"forum.php\"";// Used to debug// Set fieldSizes - if not defined then it defaults$fieldSize[0]=45;// topic//$fieldSize[1]=25;// submitter$fieldCol[2]=80;// col width submission$fieldRow[3]=10;// number of rows submission$fieldSize[3]=100;// weblinkif($submit=="add"){$rem="<table><tr><td>1. Enter your Topic.<br> 2. Type in your Submission.<br>3. If you would like to submit any website(s), copy and paste any link in the Weblink field. If you want to submit more than one, separate each by a comma.</td></tr></table><hr>";}echo "$rem";echo "<table><tr><td>$fieldArray[0]:"; pullDown(0); echo "<input type=\"text\" name=\"$fieldArray[0]\" size=\"$fieldSize[0]\" value=\"${$fieldArray[0]}\"</td></tr>";/*echo "<td>$fieldArray[1]:"; pullDown(1); echo " <input type=\"text\" name=\"$fieldArray[1]\" size=\"$fieldSize[1]\" value=\"${$fieldArray[1]}\"></td></tr><tr>";// submitter*/echo "<tr><td colspan='3'>$fieldArray[2]:"; pullDown(2); echo "<br><textarea name=\"$fieldArray[2]\" cols=\"$fieldCol[2]\" rows=\"$fieldRow[3]\">${$fieldArray[2]}</textarea></td></tr>";for($i=3;$i<4;$i++){echo "<td>$fieldArray[$i]:  "; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\"></td>";}/* NOT used in this instanceecho "</tr></table>";echo "<table><tr>";for($i=3;$i<4;$i++){if($i<$numFlds){echo "<td>$fieldArray[$i]:  "; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\"></td>";}}echo "</tr>";// companyecho "<tr>";for($i=7;$i<10;$i++){if($i<$numFlds){echo "<td>$fieldArray[$i]:  "; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\"></td>";}}echo "</tr><tr>";// amt$j=1;for($i=10;$i<23;$i++){if($i<$numFlds){if($fieldArray[$i]){$f=fmod($j,4);if($f==0){$tagB="<tr><td>";$tagE="</td></tr>";$j++;}else{$tagB="<td>";$tagE="</td>";$j++;}echo "$tagB $fieldArray[$i]:  "; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\">$tagE";}}}*/echo "</table>";$checkName=$_SESSION[budget][tempID];echo "<table><tr><td><input type='hidden' name='dbTable' value='$dbTable'><input type='hidden' name='passSQL' value='$passSQLedit'><input type='hidden' name='lastFld' value='$lastFld'><input type='hidden' name='recordIDfld' value='$lastFld'><input type='hidden' name='personID' value='$checkName'><input type='hidden' name='submitter' value='$checkName'><input type='hidden' name='var' value='$var'></td><td>$addButton</td>";if($submit=="edit" AND $checkName==$personID){echo "<td width='30%'><input type='hidden' name='checkName' value='$checkName'><input type='hidden' name='$lastFld' value='$var'><input type='hidden' name='lastFld' value='$lastFld'><input type='hidden' name='personID' value='$checkName'><input type='submit' name='submit' value='Update'></form></td><td>&nbsp;<form>$addDeleteButton</form></td>";}else{if($submit!="find"){echo "<td><font color='red'>Reminder: You can only edit/delete messages which you have added.</font></td>";}}// end elseecho "</tr></table>";  // ***** Pick display function and set sql statement$co=count($_REQUEST); //print_r($_REQUEST);echo "c=$co";exit;$from="*";// Default - gets used if not Group By// ******* Group By Variables*******// *** Make list of Fields to pass to GroupBy and Function forumHeader$passFields=$fieldArray[0];for($pf=1;$pf<count($fieldArray);$pf++){$passFields.=",".$fieldArray[$pf];}$from.=" From $dbTable";// ********* Assign passed Values by Fieldfor($j=0;$j<count($fieldArray);$j++){$passVal[$j]=${$fieldArray[$j]};}// ********* Where **********if($co>0){$where=" WHERE 1";}else{exit;}//                     **************************         Create WHERE statementfor($k=0;$k<count($fieldArray);$k++){if($passVal[$k]!=""){$dbFld=$fieldArray[$k];$dbVal=addslashes($passVal[$k]);if($like[$k]==""){$where.=" and $dbFld = '$dbVal'";}if($like[$k]==1){$where.=" and $dbFld like '%$dbVal%'";}if($like[$k]==2){$rangeDate=explode("*",$dbVal);if($rangeDate[0]!=""&&$rangeDate[1]==""){$where.=" and $dbFld='$rangeDate[0]'";}else{$where.=" and $dbFld>='$rangeDate[0]' and $dbFld<='$rangeDate[1]'";}}if($like[$k]=="3"){$where.=" and $dbFld != '$dbVal'";}}// order by $dbFld}// end for loopif($where==" WHERE 1"){exit;}if($where==" WHERE 1"&&$g=='Group by '&&$passSQL==''){exit;}if($g=="Group by ,,"){$g="";}$sql1 = "SELECT $from $where $g";if($passSQL){$sql1=urldecode($passSQL);}//echo "$sql1<br>";//echo "<pre>";print_r($fieldArray);echo "</pre>";//exit;if($sql1){// ********** This displays the result **********include_once("forumFunctions.php");$passSQL=urlencode($sql1);//getDecimalFields($varE);//forumHeader($passSQL,$passFields,$countKeys,$sumBy,$totHeader,$countHeader);// Make Headerecho "<table border='1' cellpadding='3'><tr>";$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");$num=mysqli_num_rows($result);//echo "n=$num";if($num>1000){$sql1 = "SELECT $from $where $g limit 1000";$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");echo "<hr><font color='red'>$num</font> records were found. However, only the first <font color='red'>1000</font> are being displayed. Let Tom Howard know if you need to view more than 1000 at a time.<br>";}else{echo "<hr>$num <font color='green'>$z Items Found</font>";}// **********  using forumFunctions.php//print_r($varE);//exit;$decimalValues=array_values($varE);//print_r($decimalValues);//exit;$accessLevel=1;while ($row=mysqli_fetch_array($result)){//extract($row);//print_r($row);//exit;itemShow($row);}echo "</table></body></html>";}// **************  FUNCTIONS *******************function makeUpdateFields($fieldArray){global $updateFields;for($i=0;$i<count($fieldArray);$i++){if($i!=0){$updateFields.=",".$fieldArray[$i]."=$".$fieldArray[$i];}else{$updateFields.=$fieldArray[$i]."=$".$fieldArray[$i];}}// end for}// end makeUpdateFields// Make Group By selection checkboxesfunction makeGroupBySelect($fieldArray,$ckbx){global $updateFields;echo "<table>";for($i=0;$i<count($fieldArray);$i++){$t=fmod($i,6);$name="ckbx[".$i."]";if($ckbx[$i]==$fieldArray[$i]){$c="checked";}else{$c="";}echo "<td><input type='checkbox' name='$name' value='$fieldArray[$i]' $c>$fieldArray[$i]</td>";if($i!=0 and $t==0){echo "<tr></tr>";}}// end forecho "</table>";}// end makeGroupBySelect?>