<?php// This site is a complete mess. It was quickly thrown together by cloning the Staff Directive and then modifying. It needs major help. Tom H.$database="pr_news";include("../../include/iConnect.inc");// database connection parameters//print_r($_SERVER);exit;//print_r($_SESSION);//exit;//print_r($_REQUEST);//exit;//$k=urldecode($_SERVER[QUERY_STRING]);$level=$_SESSION[div_cor][level];include("menu.php");//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;//********** SET Variables **********$checkName=$_SESSION[div_cor][tempID];// FIELD NAMES are stored in $fieldArray// FIELD TYPES and SIZES are stored in $fieldType$sql = "SHOW COLUMNS FROM news";//echo "$sql";$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SHOW2. $sql ");$numFlds=mysqli_num_rows($result);while ($row=mysqli_fetch_assoc($result)){$fieldArray[]=$row[Field];$fieldType[]=$row[Type];}$recordIDfld=$fieldArray[$numFlds-1];makeUpdateFields($fieldArray);// MAKE FIELD=VALUE FOR ADD/UPDATEfor($dk=0;$dk<count($fieldType);$dk++){$varD=substr($fieldType[$dk],0,7);//if($varD=="decimal"){$fieldDecimal[]=$dk;}if($varD=="varchar"){$size=substr(substr($fieldType[$dk],8,7),0,-1);if($size>30){$size=30;}$fieldSize[]=$size;}else{$fieldSize[]=12;}}//print_r($fieldSize);//exit; //**** Process any Delete ******if($submit=="Delete"){$query = "DELETE FROM news where $recordIDfld='$deleteRecordID'";//echo "$query";exit;$result = mysqli_query($connection,$query) or die ("Couldn't execute query Delete. $query");//header("Location: forum.php?action=del");//exit;}//**** Formulate a Reply ******if($submit=="reply"){$sql = "SELECT * from news where forumID='$var' group by forumID";//echo "s=$sql";exit;$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Select. $sql");$row=mysqli_fetch_array($result);extract($row);$displaySubmitter=substr($submitter,0,-2);echo "<table><tr><td colspan='3'>You are replying to this submission:</td></tr><tr><td>Topic: $topic</td><td>Submitted by: $displaySubmitter</td></tr><tr><td>Comment: $submission</td></tr>";echo "</table><hr>";//echo "<form action=\"forum.php\" method=\"post\">";echo "<form action=\"forum.php\"";// Used to debugecho "<table><tr><td colspan='3'>Enter your reply below:</td></tr><tr><td>Reply from: $checkName</td></tr><tr><td>Re: $topic</td></tr><tr><td>Submission: <br><textarea name=\"submission\" cols=\"80\" rows=\"10\"></textarea></td></tr>";echo "<tr><td>Website(s):<input type=\"text\" name=\"web_link\" size=\"50\" value=\"\"></td></tr>";$pos=strpos($topic,"Re: ");if($pos>-1){$topic=$topic;}else{$topic="Re: ".$topic;}if($submisID>0){$forumID=$submisID;}echo "<td width='30%'>&nbsp;<input type='hidden' name='checkName' value='$checkName'><input type='hidden' name='submitter' value='$submitter'><input type='hidden' name='submisID' value='$forumID'><input type='hidden' name='topic' value='$topic'><input type='submit' name='submitReply' value='Submit'></form></td>";echo "</tr></table>";exit;} //**** Process any Edit or Add ******if($submit=="Update"){//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;$v=${$lastFld};//$updateThese="topic,submitter,submission,web_link";$updateThese="topic,submission,web_link_2";$arr1=explode(",",$updateThese);for($j=0;$j<count($arr1);$j++){$arr2=explode("=",$arr1[$j]);$arr3[]=$arr2[0];}for($j=0;$j<count($arr1);$j++){$val1=addslashes($_REQUEST[$arr3[$j]]);$newQuery[$arr3[$j]]=$val1;}$arrKeys=array_keys($newQuery);$queryString=$arrKeys[0]."='".$newQuery[$arrKeys[0]]."'";for($j=1;$j<count($arrKeys);$j++){switch ($arrKeys[$j]) {		case "dateCreate":$queryString.=", ".$arrKeys[$j]."=now()";			break;			case "personID":$personID=$_SESSION[div_cor][tempID];$queryString.=", ".$arrKeys[$j]."='$personID'";			break;				default:			$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";}// end Switch}//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";//print_r($newQuery);exit;$query = "Update news set $queryStringwhere $lastFld='$v'";//echo "$query";exit;$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");$sql="SELECT forumID as checkID from category where forumID='$v'";$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql");$row=mysqli_fetch_array($result);extract($row);if($checkID!=""){$sql = "Update category set acct_bud='$acct_bud',admin_op='$admin_op',apc='$apc',dpr_ea='$dpr_ea',hr='$hr',ie='$ie',law='$law',safe='$safe',ware='$ware',other='$other'where $lastFld='$v'";//echo "$query";exit;$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $query");}else{$query = "INSERT into category set acct_bud='$acct_bud',admin_op='$admin_op',apc='$apc',dpr_ea='$dpr_ea',hr='$hr',ie='$ie',law='$law',safe='$safe',ware='$ware',other='$other',forumID='$v'";//echo "$query";exit;$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");	}}//**** Process any Add ******if($submit=="Add"){// note capital A, see add with lower case$arr1=explode(",",$updateFields);for($j=0;$j<count($arr1);$j++){$arr2=explode("=",$arr1[$j]);$arr3[]=$arr2[0];}for($j=0;$j<count($arr1);$j++){$val1=addslashes($_REQUEST[$arr3[$j]]);$newQuery[$arr3[$j]]=$val1;}$arrKeys=array_keys($newQuery);$queryString=$arrKeys[0]."='".$newQuery[$arrKeys[0]]."'";for($j=1;$j<count($arrKeys);$j++){switch ($arrKeys[$j]) {		case "dateCreate":$queryString.=", ".$arrKeys[$j]."=now()";			break;			case "personID":$personID=$_SESSION[div_cor][tempID];$queryString.=", ".$arrKeys[$j]."='$personID'";			break;				default:			$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";}// end Switch}//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";//print_r($queryString);exit;$query = "INSERT INTO news set $queryString";//echo "$query";exit;$result = mysqli_query($connection,$query) or die ("Couldn't execute query Insert. $query");$v=mysqli_insert_id($connection);$query = "INSERT into category set acct_bud='$acct_bud',admin_op='$admin_op',apc='$apc',dpr_ea='$dpr_ea',hr='$hr',ie='$ie',law='$law',safe='$safe',ware='$ware',other='$other',forumID='$v'";//echo "$query";exit;$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");if($difFile){header("Location: forumReport.php?dbReport=Center&center=$center&submit=Submit&rccYN=Y");}else{//ECHO "test";exit;//header("Location: /find/forum.php?action=Add");}//exit;}//**** Prepare To Find, Update OR Delete******if($lastFld){//print_r($_REQUEST);exit;$formType="Update";$passSQLedit=urlencode($passSQL);$addDeleteButton="<td><form><input type='hidden' name='passSQL' value='$passSQLedit'><input type='hidden' name='$lastFld' value='$var'><input type='hidden' name='deleteRecordID' value='$var'><input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></form></td>";$catFlds="category.acct_bud,category.admin_op,category.apc,category.dpr_ea,category.hr,category.ie,category.law,category.safe,category.ware,category.other";$sql0 = "SELECT news.*,map.mid,map.filename, $catFlds from newsLEFT JOIN map ON map.forumID = forum.forumIDLEFT JOIN category on category.forumID=forum.forumIDwhere forum.$lastFld='$var'order by mid";$result = mysqli_query($connection,$sql0) or die ("Couldn't execute query 0. $sql0");while($row=mysqli_fetch_array($result)){extract($row);//$midArray[$filename]=$mid;$fileArray[$mid]=$filename;}//print_r($row);exit;//print_r($fileArray);echo "<br />$sql0<br />"; print_r($midArray);//exit;}if($submit=="add"){$addButton="<td><input type='submit' name='submit' value='Add'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}echo "<form action=\"forum.php\" method=\"post\">";//include("categories.php");if($submit=="add"||$submit=="edit"){if($submit=="add" and $level<1){echo "<br><br><font color='red'>You do not the access level necessary to add an item.</font>";exit;}if($submit=="edit" AND ($checkName!=$personID) AND $level<5){echo "<br><br><font color='red'>Reminder: You can only edit/delete messages which you have added.</font>";exit;}echo "<form action=\"forum.php\" method=\"post\">";//echo "<form action=\"forum.php\"";// Used to debug// Set fieldSizes - if not defined then it defaults$fieldSize[0]=55;// topic$fieldCol[2]=120;// col width submission$fieldRow[3]=15;// number of rows submission$fieldSize[3]=100;// web_link$fileTitle=${$fieldArray[0]};$fileTitle=str_replace(" ","_",$fileTitle);$fileTitle=str_replace("\"","",$fileTitle);$fileTitle=str_replace("\'","",$fileTitle);$rem="<table><tr><td>1. Enter your Topic.<br> 2. Type in your Submission.<br>3. If you would like to attach a document, first Add the topic and then you will be able to add any documents.</td></tr></table><hr>";echo "$rem";//print_r($fieldArray);echo "<table><tr><td>$fieldArray[0]: ";$topic=${$fieldArray[0]};echo "<textarea name=\"topic\" cols=\"40\" rows=\"1\">$topic</textarea></td></tr>";echo "<tr><td colspan='3'>$fieldArray[2]: ";echo "<br><textarea name=\"$fieldArray[2]\" cols=\"$fieldCol[2]\" rows=\"$fieldRow[3]\">${$fieldArray[2]}</textarea></td></tr>";echo "<tr><td>Link to a web page(s): <textarea name=\"web_link_2\" cols=\"100\" rows=\"2\">$web_link_2</textarea><br />separate multiple links with a comma - ,</td>";echo "</table>";//include("categories.php");$checkName=$_SESSION[div_cor][tempID];echo "<table><tr><td><input type='hidden' name='dbTable' value='news'><input type='hidden' name='passSQL' value='$passSQLedit'><input type='hidden' name='lastFld' value='$lastFld'><input type='hidden' name='recordIDfld' value='$lastFld'><input type='hidden' name='personID' value='$checkName'><input type='hidden' name='submitter' value='$checkName'><input type='hidden' name='var' value='$var'></td><td>$addButton</td>";if(($submit=="edit" AND $checkName==$personID) OR ($submit=="edit" AND $level>4)){echo "<td width='30%'><input type='hidden' name='checkName' value='$checkName'><input type='hidden' name='$lastFld' value='$var'><input type='hidden' name='lastFld' value='$lastFld'><input type='hidden' name='personID' value='$checkName'><input type='submit' name='submit' value='Update'></form></td><td>&nbsp;<form>$addDeleteButton</form></td></tr></table>";echo "<hr><table><tr bgcolor='brown'><td></td></tr>";if($web_link){ $fileTitle=""; $exist="y";$split=explode(",",$web_link);$listFiles="<tr><td>Existing documents (Click on doc to delete.): <font color='green'>";foreach($fileArray as $k=>$v){$deleteLink="[<a href='deleteDoc.php?forumID=$forumID&mid=$k' onClick='return confirmLink()'>$fileArray[$k]</a>] ";$listFiles.=$deleteLink;}echo "$listFiles</font></td></tr>";}echo "<tr><td>    <form method='post' action='adminMenu.php' enctype='multipart/form-data'>    <INPUT TYPE='hidden' name='exist' value='$exist'>    <INPUT TYPE='hidden' name='forumID' value='$var'>    <INPUT TYPE='hidden' name='admin' value='graphic'>    <br>1. Click the BROWSE button and select your JPEG, PDF, WORD or EXCEL file.<br>    <input type='file' name='map'  size='40'>    <p>2. Then click this button.     <input type='submit' name='submit' value='Add File'>    </form><br><br>Make sure your File is less than or equal to 3 MB. If you need to add a file larger than 3 MB, contact the administrator.";echo "</td></tr></table>";exit;}echo "</tr></table>";EXIT;}echo "</tr></table>";  // ***** Pick display function and set sql statement$co=count($_REQUEST); //print_r($_REQUEST);echo "c=$co";exit;$from="*";// Default - gets used if not Group By// ******* Group By Variables*******// *** Make list of Fields to pass to GroupBy and Function forumHeader$passFields=$fieldArray[0];for($pf=1;$pf<count($fieldArray);$pf++){$passFields.=",".$fieldArray[$pf];}$from.=" From news";// ********* Assign passed Values by Fieldfor($j=0;$j<count($fieldArray);$j++){$passVal[$j]=${$fieldArray[$j]};}//                     **************************         Create WHERE statementfor($k=0;$k<count($fieldArray);$k++){if($passVal[$k]!=""){$dbFld=$fieldArray[$k];$dbVal=addslashes($passVal[$k]);if($like[$k]==""){$where.=" and $dbFld = '$dbVal'";}if($like[$k]==1){$where.=" and $dbFld like '%$dbVal%'";}if($like[$k]==2){$rangeDate=explode("*",$dbVal);if($rangeDate[0]!=""&&$rangeDate[1]==""){$where.=" and $dbFld='$rangeDate[0]'";}else{$where.=" and $dbFld>='$rangeDate[0]' and $dbFld<='$rangeDate[1]'";}}if($like[$k]=="3"){$where.=" and $dbFld != '$dbVal'";}}// order by $dbFld}// end for loopif($where==" WHERE 1"){exit;}if($where==" WHERE 1"&&$g=='Group by '&&$passSQL==''){exit;}if($submit=="Search"||$submit=="Go"){if($submit=="Search"){$a=$searchterm;$where="where (topic like '%$a%' or submission like '%$a%' or submitter like '%$a%')";$excludeArray=array("searchterm","submit","PHPSESSID",);foreach($_REQUEST AS $k=>$v){if(!in_array($k,$excludeArray)){$findCat.=$k."='".$v."' or ";} 	}if($findCat){$JOIN="LEFT JOIN category on category.forumID=forum.forumID";$where.=" and (".trim($findCat,"' or ")."')";}//echo "f=$where";exit;}else{$where="where forumID = '$forumID'";}$sql1 = "SELECT $from $JOIN$where order by dateCreate DESC";//echo "$sql1";exit;}if($passSQL){$sql1=urldecode($passSQL);}//echo "$sql1<br>";//echo "<pre>";print_r($fieldArray);echo "</pre>";exit;if($sql1){// ********** This displays the result **********include_once("forumFunctions.php");echo "<table border='1' cellpadding='3'>";$result = mysqli_query($connection,$sql1) or die ("Couldn't execute query SQL1 2. $sql1");$num=mysqli_num_rows($result);//echo "$sql1";if($num>100){$sql1 .= " limit 100";$result = mysqli_query($connection,$sql1) or die ("Couldn't execute query SQL1 3. $sql1");echo "<hr><font color='red'>$num</font> records were found. However, only the first <font color='red'>100</font> are being displayed. Let Tom Howard know if you need to view more than 100 at a time.<br>";}else{echo "<hr>$num <font color='green'>$z Items Found</font>";}while ($row=mysqli_fetch_array($result)){//extract($row);//print_r($row);//exit;itemShow($row);}exit;}// end sql1// ********** This displays all entries in DESC order **********$sql1 = "SELECT *,substring_index(web_link,'=',-1) as dirNum from news order by route_status desc";echo "$sql1";include_once("forumFunctions.php");echo "<table border='1' cellpadding='5'>";$sql = "SHOW COLUMNS FROM news";//echo "$sql";$result = mysqli_query($connection,$sql) or die ("Couldn't execute query	SHOW1. $sql");$numFlds=mysqli_num_rows($result);$result = mysqli_query($connection,$sql1) or die ("Couldn't execute query SQL1. $sql1");$num=mysqli_num_rows($result);$ii=0;while ($row=mysqli_fetch_array($result)){itemShow($row);}exit;echo "</table></body></html>";//}// **************  FUNCTIONS *******************function makeUpdateFields($fieldArray){global $updateFields;for($i=0;$i<count($fieldArray);$i++){if($i!=0){$updateFields.=",".$fieldArray[$i]."=$".$fieldArray[$i];}else{$updateFields.=$fieldArray[$i]."=$".$fieldArray[$i];}}// end for}// end makeUpdateFields// Make Group By selection checkboxesfunction makeGroupBySelect($fieldArray,$ckbx){global $updateFields;echo "<table>";for($i=0;$i<count($fieldArray);$i++){$t=fmod($i,6);$name="ckbx[".$i."]";if($ckbx[$i]==$fieldArray[$i]){$c="checked";}else{$c="";}echo "<td><input type='checkbox' name='$name' value='$fieldArray[$i]' $c>$fieldArray[$i]</td>";if($i!=0 and $t==0){echo "<tr></tr>";}}// end forecho "</table>";}// end makeGroupBySelect?>