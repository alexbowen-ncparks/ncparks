<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); // used to authenticate users
mysql_select_db($database,$connection);

//print_r($_SESSION);
//print_r($_REQUEST);

extract($_REQUEST);

$useDB="style";
$textArray=array("body"=>"15");// fields to be formatted as textarea

extract($_REQUEST);
	date_default_timezone_set('America/New_York');
	
//print_r($_REQUEST);//EXIT;
// ****** Delete a Record **********
if(@$submit_label=="Delete")
	{	
	$sql = "DELETE FROM $useDB where id='$id'";//echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	echo "Record deleted.<br><A HREF=\"javascript:window.close()\">Close</A> the popup.";
	exit;
	}

if(@!$c){include("menu.php");}else{include("css/TDscript.inc");
$close="<A HREF=\"javascript:window.close()\">Close</A> the popup.";}

// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType
$sql = "SHOW COLUMNS FROM $useDB";//echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$numFlds=mysql_num_rows($result);
while ($row=mysql_fetch_assoc($result))
	{
//	extract($row);//print_r($row);
	$fieldArray[]=$row['Field'];
	}
//print_r($fieldArray);exit;

// ****** Default Page **********
if(@$submit_label=="")
	{
	$sql = "SELECT * FROM $useDB order by id";//echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysql_num_rows($result);
	echo "<table border='1' cellpadding='2'>";
	for($i=1;$i<count($fieldArray);$i++){
	echo "<th>$fieldArray[$i]</th>";}
	
	echo "</tr>";
	while ($row=mysql_fetch_assoc($result))
	{
	echo "<tr>";
	for($i=1;$i<count($fieldArray);$i++){
	$k=$fieldArray[$i];
	$val=$row[$k];
	if($k=="topic"){
	echo "<td align='center'><a href='style.php?submit_label=Find&id=$row[id]'>$val</a></td>";}else
	{
	$val=nl2br($val);
	echo "<td>$val</td>";}
	}
	echo "</tr>";
	}
	echo "<form action=''><tr><td>
	<input type='submit' name='submit_label' value='Add Style'></td>
	</tr></form></table>";
	exit;}

// ****** Any modifications to variables **********
/*
$first_name=addslashes($first_name);
$last_name=addslashes($last_name);
$soccer_bio=addslashes($soccer_bio);
$achievements=addslashes($achievements);
$height=addslashes($height);
*/
// ****** Display for Add Form **********
if($submit_label=="Add Style")
	{
	echo "<html><head><title></title></head><body><table>
	<tr><td colspan='2'><font color='brown'>Style Sheet for WAR</font></td></tr>
	<form action='' method='POST'>";
	
	for($i=1;$i<count($fieldArray);$i++){
	$test=$fieldArray[$i];
	
	//if($test=="parent_guardian"){$plural="(s)";}else{$plural="";}
	//if($test=="password"){$val="";$pref="Your";$post="<br>(required)";}else{$pref="";$post="";}
	
	if(!isset($pref)){$pref="";}
	if(!isset($plural)){$plural="";}
	if(!isset($post)){$post="";}
	echo "<tr><td>$pref $fieldArray[$i]$plural$post</td>";
	
	if(@$textArray[$test]>-1)
		{
		$rows=$textArray[$fieldArray[$i]];
		if($test=="height"){$cols=7;}else{$cols=85;}
		
		echo "<td><textarea name='$fieldArray[$i]' cols='$cols' rows='$rows'></textarea></td></tr>";}
	else
	{
	if($test=="state"){$val="NC";}else{$val="";}
	if($test=="weight"){$lbs="lbs.";$size="size='10'";}else{$lbs="";$size="size='28'";}
	echo "<td><input type='text' name='$fieldArray[$i]' value='$val' $size> $lbs</td></tr>";}
	}// end for
	
	echo "<tr><td align='right'>
	<td align='right'>
	<input type='submit' name='submit_label' value='Add'></td>
	</tr></form></table></body></html>";
	exit;}

// ****** Display for Edit Form **********
if(@$id!=""&&$submit_label!="Update")
	{
	$sql = "SELECT * FROM $useDB where id='$id'";//echo "$sql";EXIT;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysql_num_rows($result);
	$row=mysql_fetch_assoc($result);
	extract($row);
	IF(!isset($m)){$m="";}
	echo "<html><head><title></title></head><body><table><tr><td colspan='2'><font color='brown'>Style Sheet for WAR</font></td></tr>
	<font color='purple'>$m</font>
	<form action='' method='POST'>";
	for($i=1;$i<count($row);$i++){
	
	$val=${$fieldArray[$i]};// force the variable
	
	$test=$fieldArray[$i];
	$length=str_word_count($val);
	
	if($fieldArray[$i]=="parent_guardian"){$plural="(s)";}else{$plural="";}
	if($test=="password"){$val="";$pref="Your";$post="<br>(required)";}else{$pref="";$post="";}
	
	echo "<tr><td>$pref $fieldArray[$i]$plural$post</td>";
	
	if(@$textArray[$test]>-1)
		{
		$rows=$textArray[$fieldArray[$i]];
		if($test=="height"){$cols=7;}else{$cols=85;}
		
		echo "<td><textarea name='$fieldArray[$i]' cols='$cols' rows='$rows'>$val</textarea></td></tr>";
		}
	else
	{
	if($test=="weight"){$lbs="lbs.";$size="size='10'";}else{$lbs="";$size="size='28'";}
	echo "<td><input type='text' name='$fieldArray[$i]' value='$val' $size> $lbs</td></tr>";}
	}// end for
	
	$sql = "SELECT * FROM style order by topic";//echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while ($row=mysql_fetch_row($result))
	{$idArray[]=$row[0];$topicArray[]=$row[1];}
	
	echo "<tr><td colspan='2'><select name='StyleTopic' onChange=\"MM_jumpMenu('parent',this,0)\">\n"; echo "<option value=''>Style Topics\n";
	for ($i=0;$i<count($topicArray);$i++){
	//if($parkCode[$i]==$testPark and $warLevel=="1"){$v="selected";}else{
	$v="value";
	//}
		 echo "<option $v='style.php?c=1&submit_label=Find&id=$idArray[$i]'>$topicArray[$i]\n";
	}
	echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$close</td></tr>";
	
	if($_SESSION['war']['level']==5){
	if($c){$c="<input type='hidden' name='c' value='1'>";}
	echo "<tr><td colspan='2' align='right'>
	$c
	
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit_label' value='Update'></td>
	</tr></form>
	<form action=''><tr><td>
	<input type='submit' name='submit_label' value='Add Style'></td>
	</tr></form>
	<form action=''><tr><td>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit_label' value='Delete'></td>
	</tr></form>";}
	
	echo "</table></body></html>";
	exit;}

// ****** Find Info **********
if($submit_label=="Find")
	{
	
	// ****** Create Array of couplets for Find **********
	$where= "where 1";
	for($i=0;$i<count($fieldArray);$i++){
	if($_REQUEST[$fieldArray[$i]]!=""){
	$val=${$fieldArray[$i]};// force the variable
	$val="'".$val."'";
	$where.=" and ".$fieldArray[$i]."=".$val;
	}// end if $_REQUEST
	}
	
	$sql = "SELECT * from $useDB $where";
	//echo $where; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysql_num_rows($result);
	if($numFlds==1){
	$row=mysql_fetch_assoc($result);extract($row);
	header("Location: /war/style.php?id=$id");exit;}
	
	echo "<html><head><title></title>
	
	<style type=\"text/css\">
	tr.d0 td {
			background-color: beige; color: black;
	}
	tr.d1 td {
			background-color: #FFFFCC; color: black;
	}
	</style>
	<script language=\"javascript\" type=\"text/javascript\">
	<!--
	function popitup(url)
	{
			newwindow=window.open(url,'name','height=550,width=450');
			if (window.focus) {newwindow.focus()}
			return false;
	}
	
	// -->
	</script>
	</head><body><table>";
	$j=0;
	echo "<tr><td align='center' colspan='4'>$numFlds Records Found:</td></tr>";
	while($row=mysql_fetch_assoc($result)){
	extract($row);
	$link="<a href=\"style.php\" onclick=\"return popitup('style.php?id=$id&c=1')\">$id</a>";
	$j++;
	echo "<tr class=\"d".($j & 1)."\">";
	echo "<td>$First_name $M_initial</td><td>$Last_name</td><td>$address $city $state $zip</td><td>$park</td><td>$affiliation_code $affiliation_name</td><td>$link</td></tr>";}
	echo "</table>";
	exit;
	}


// ****** Create Array of couplets for Insert/Update **********
for($i=1;$i<count($fieldArray);$i++)
	{
	$val=${$fieldArray[$i]};// force the variable
	$val="'".addslashes($val)."'";
	if($i!=1)
		{@$arraySet.=",`".$fieldArray[$i]."`=".$val;}
	else
		{@$arraySet.="`".$fieldArray[$i]."`=".$val;}
	}

if($submit_label=="Add")
	{
	$query = "INSERT into $useDB SET $arraySet";
//	echo $query; exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	$id=mysql_insert_id();
	$message="Submission successful.";
	}

if($submit_label=="Update")
	{
	$query = "UPDATE $useDB SET $arraySet where id='$id'";
	//echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	$message="Update successful.";
	if($c){$c="&c=1";}
	}
header("Location: /war/style.php?submit_label=Find&id=$id&m=$message$c");

?>