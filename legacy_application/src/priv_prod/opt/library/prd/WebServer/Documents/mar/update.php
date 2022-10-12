<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); 
include_once("../../include/get_parkcodes.php");
mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');
extract($_REQUEST);
//print_r($_SESSION);
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

$warLevel=$_SESSION['war']['level'];
$scopeLevel=$_SESSION['war']['parkS'];
$sectLevel=$_SESSION['war']['sect_prog'];
if($sectLevel){$sectLevel="OPE";}

$whereLevel="(weekentered='$thisWeek')";

switch ($warLevel) {
		case "1":		
$whereLevel.=" and park='$scopeLevel' and distApprov='' and sectApprov='' and direApprov=''";
			break;	
		case "2":			
$whereLevel.=" and dist='$scopeLevel' and distApprov='' and sectApprov='' and direApprov=''";
			break;		
		case "3":
		if(@$dist){$andDIST=" and dist='$dist'";}	else{$andDIST="";}
$whereLevel.=" and section='$sectLevel' and sectApprov='' and direApprov='' $andDIST";
			break;		
		case "4":
		if(@$dist){$andDIST=" and dist='$dist'";}else{$andDIST="";}
$whereLevel.=" and direApprov='' $andDIST";
			break;			
		case "5":
		if(@$dist){$andDIST="dist='$dist'";}else{$andDIST="";}
$whereLevel.=" and direApprov='' $andDIST";
			break;	
	}
?>
<html>
<head>
<title>Approve/Edit/Delete Record</title>
</head>
<body>
<?php
if(@$id AND @$m!=1)
	{
	unset($_SESSION['war']['editID']);
	$query = "select * FROM report WHERE id=$id";
	$query1 = "select id as trid FROM report 
	WHERE $whereLevel and section='$s'
	order by dist desc,park desc,date desc,id";
	//echo "$message";//exit;
	$result1 = mysql_query($query1) or die ("Couldn't execute query1 1.");
	while($row1 = mysql_fetch_array($result1)){
	extract($row1);
	$_SESSION['war']['editID'][]=$trid;
	}
	if(isset($_SESSION['war']['editID']))
		{
		$flipArray=array_flip($_SESSION['war']['editID']);
		$deleteThis=$flipArray[$id];//echo "d=$deleteThis";
		unset($_SESSION['war']['editID'][$deleteThis]);
		}
	//print_r($_SESSION[war][editID]);
	}
else
	{
	$thisID=@array_pop($_SESSION['war']['editID']);
	$s=$_SESSION['war']['editSect'];
	$query = "select * FROM report WHERE id='$thisID'";
	//print_r($_SESSION[war][editID]);
	}

//echo "<br><br>q=$query q1=$query1";

$result = mysql_query($query) or die ("Couldn't execute query 1.");
$num=mysql_num_rows($result);
if($num<1){
if(@$m==2)
	{
	$message="Previous record was successfully deleted.<br><br>";
	}
@$message.="<font color='red'>No Entries Found that need to be edited for $section.</font>";echo "$message";exit;}

$row = mysql_fetch_array($result);
extract($row);
//echo "$query1";

$_SESSION['war']['editSect']=$section;
$year = substr($date, 0, 4);
$month = substr($date, 5, 2);
$day = substr($date, 8, 2);

if(!isset($m)){$m="";}
if($m=="1"){$m="<font color='red'>Previous record was successfully updated.</font>";}
if($m=="2"){$m="<font color='red'>Previous record was successfully deleted.</font>";}
echo "$m
<p><font size='2' color='purple'>WAR Approve/Edit/Delete Page</font>";
?>
<br>
  Either make necessary changes and click "...Save..." button OR click the "Delete..." button:
<form method="post" action="updateWar.php"> 
<b>Section:</b>
  <table cellpadding="1">
    <tr><td>
<?php if ($section == "ADM"){$sect = $section;$check = "checked"; } else {$sect = "Adm"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>Administration<br>
<?php if ($section == "CON"){$sect = $section;$check = "checked"; } else {$sect = "Con"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>Design and Development </td>
      <td>
<?php if ($section == "EXH"){$sect = $section;$check = "checked"; } else {$sect = "Exh"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>Exhibits <br>

<?php if ($section == "I&E"){$sect = $section;$check = "checked"; } else {$sect = "I&amp;E"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>I &amp; E
      </td>
      <td>

<?php if ($section == "OPE"){$sect = $section;$check = "checked"; } else {$sect = "Ope"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>Operations <br>

<?php if ($section == "PLA"){$sect = $section;$check = "checked"; } else {$sect = "Pla"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>Planning </td>
      <td>
<?php if ($section == "RES"){$sect = $section;$check = "checked"; } else {$sect = "Res"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>Resource Management <br>
      
<?php if ($section == "TRA"){$sect = $section;$check = "checked"; } else {$sect = "Tra"; 
$check = "";} 
echo "<input type='radio' name='section' value='$sect'"; echo " $check>"; ?>Trails
      </td>
    </tr></table>
    <table><tr> 
      <td width="9%" height="39"><b>Entered by:</b></td>
      <td colspan="5" height="39"><?php 
        echo " 
        <input type='text' name='enter_by' value='$enter_by'>"; ?>
<?php
if($distApprov){$cbDist="checked";}else{$cbDist="";}
if($sectApprov){$cbSect="checked";}else{$cbSect="";}
if($direApprov){$cbDire="checked";}else{$cbDire="";}
switch($warLevel)
	{
	case "5":
		 echo " Reviewed by District:<input type='checkbox' name='distApprov' value='x' $cbDist>
		 Section:<input type='checkbox' name='sectApprov' value='x' $cbSect>
		 Director:<input type='checkbox' name='direApprov' value='x' $cbDire>
		 ";
		 break;
	case "4":
		 echo " Reviewed by District:<input type='checkbox' name='distApprov' value='x' $cbDist>
		 Section:<input type='checkbox' name='sectApprov' value='x' $cbSect>
		 Director:<input type='checkbox' name='direApprov' value='x' $cbDire>
		 ";
		 break;
	case "3":
		 echo " Reviewed by District:<input type='checkbox' name='distApprov' value='x' $cbDist>
		 Section:<input type='checkbox' name='sectApprov' value='x' $cbSect>
		 ";
		 break;
	case "2":
		 echo " Reviewed by District:<input type='checkbox' name='distApprov' value='x' $cbDist>
		 ";
	}
?>
      </td></tr>
    <tr> 
      <td width="9%" height="29"><b>Date of Activity:</b></td>
      <td colspan="4"><?php 
        echo " 
        <input type='text' name='month' size='3' maxlength='2'  value='$month'>"; ?> 
        Month &nbsp;&nbsp; <?php 
        echo "
        <input type='text' name='day' size='3' maxlength='2'  value='$day'>"; ?> 
        Day
    <?php 
        echo "&nbsp;&nbsp;&nbsp;<input type='text' name='year' size='6' value='$year'> Year"; ?> 
    </tr>
    <tr> 
      <td width="9%"><b>Park:</b></td>
      <td colspan="3"> <?php echo "
        <input type='text' name='park' size='7' maxlength='4' value='$park'>" ?>
 <font size="-2">(Only needed for Field Operations entries.)</font></td>
      <td width="19%">&nbsp;</td>
      <td width="10">&nbsp;</td>
      <td width="6%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
    </tr>
<tr>&nbsp;</tr>
    <tr> 
      <td width="9%"><b>Title:</b></td>
      <td colspan="5"> <?php
      echo "
        <input type='text' name='title' size='80' maxlength='100' value=\"$title\">" ?>
      </td>
    </tr>
    <tr> 
      <td width="9%"><b>Body:</b></td>
      <td colspan="5" rowspan="3"> <?php echo "
        <textarea name='body' cols='80' rows='10'>$body</textarea>" ?>
      </td>
    </tr>
    <tr> 
      <td width="9%">&nbsp;<?php
      echo "<input type='hidden' name='thisWeek' value='$thisWeek'>
        <input type='hidden' name='id' value='$id'>"; ?></td>
    </tr>
    <tr> 
     
    </tr>
<tr>  <td colspan='5'>
        <input type="submit" name="submit" value="Click to Save Changes">
      </td>
      <td> 
        <input type="submit" name="submit" value="Delete This Record" onClick="return confirmLink()">
      </td>
    </tr>
</form>
<?php

echo "<tr><form action='update.php'><td colspan='5' align='center'>
<input type='hidden' name='section' value='$section'>
<input type='hidden' name='dist' value='$dist'>
<input type='hidden' name='thisWeek' value='$thisWeek'>
        <input type=\"submit\" name=\"submit\" value=\"Next Entry to Edit\">
</form></td>
    </tr>";
?>
  </table>
</body>
</html>
