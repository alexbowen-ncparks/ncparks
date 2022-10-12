<?php
$database="cite";
include("../../include/auth.inc"); // used to authenticate users
include_once("menu.php");
include_once("../../include/get_parkcodes.php");

if(!empty($_SESSION['cite']['accessPark']))
	{
	$parkList=explode(",",$_SESSION['cite']['accessPark']);
// 	echo "<pre>"; print_r($parkList); echo "</pre>"; // exit;
	}

extract($_REQUEST);
//echo "e=$varEdit <pre>";print_r($_REQUEST);echo "</pre>";
// echo "<pre>";print_r($_SESSION);echo "</pre>";
if(@$parkList[0]!="")
	{
	if(!isset($testPark)){$testPark="";}
	if($testPark AND in_array($testPark,$parkList))
		{$_SESSION['cite']['parkS']=$testPark;}
	}
?>

<html>
<head>
<title>Search CITE database</title>
</head>
<body><div align="center">

<?php
/* Use the INCLUDE statement to both CONNECT and SELECT the correct database*/
 include ("../../include/connectROOT.inc");
 mysql_select_db($database,$connection);
/* Use the INCLUDE statement to load a Function file*/
date_default_timezone_set('America/New_York');
include ("include/functions.php");
?>
<p><font size="3" font color="#004201">CITE Search Page
<br>
  Please enter your search criteria(um):</font><form method="post" action="find.php">

<table border='1'>
   
<?php 

echo "<tr> 
      <td align=\"right\"><b>Date of Activity:</b></td>
      <td height=\"29\"> 
        <input type=\"text\" name=\"month\" size=\"3\" maxlength=\"2\">
        Month</td>
<td> Year:";

$thisYear = date('Y'); 
$thisMonth = date('M');
//$thisMonth = 1;  // for testing purpose
if ($thisMonth == 1) {
        $thisYear = $thisYear-1; 
        echo "<input type='radio' name='yearRadio' value='$thisYear'>";
echo "$thisYear";

$thisYear = $thisYear+1; 
        echo "</td><td><input type='radio' name='yearRadio' value='$thisYear'></td>";
echo "$thisYear";
        echo "<td width='18%'><input type='text' name='yearText' size='4' maxlength='4'>
        Enter Any Year <="; echo "$thisYear </td>";
}
elseif ($thisMonth != 1) {
$thisYear = $thisYear; 
        echo "<input type='radio' name='yearRadio' value='$thisYear'>";
echo "$thisYear";
echo "&nbsp;&nbsp;<input type='text' name='yearText' size='8' maxlength='4'>
        Enter any year <="; echo "$thisYear</td>";
}
echo "</tr></table>
    
<table border='1'><tr>";
if($_SESSION['cite']['level']=="1")
	{
	$checkPark=$_SESSION['cite']['select'];
	$var_accessPark=$_SESSION['cite']['accessPark'];
	if(!empty($var_accessPark))
		{
		$exp=explode(",",$var_accessPark);
		foreach($exp as $k=>$v)
			{
			$temp_park_array[]=$v;
			}
		}
	$ck_tempID=$_SESSION['cite']['tempID'];
	$temp_ENRI=array("FALA","ENRI","OCMO");
	@$temp_park=$testPark;
	if((in_array($checkPark,$temp_park_array)) and in_array($testPark,$temp_park_array))
		{
		// do nothing
		}
		else
		{
		$testPark=$_SESSION['cite']['parkS'];
		}

	if($ck_tempID=="LastName1234") // LEO helping out at ENRI for summer 2015
		{
		if(in_array($temp_park,$temp_ENRI))
			{$testPark=$temp_park;}
		
		}
		else
		{$testPark=$_SESSION['cite']['parkS'];}
	}
      
      
if(!isset($varEdit)){$varEdit="";}

echo "<td align='right'><b>Park Name: </b></td><td><select name='park' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";
foreach($parkCode as $index=>$value)
	{
	if($value==@$testPark)
		{$v="selected";}else{$v="value";}
		 echo "<option $v='index.php?testPark=$value&varEdit=$varEdit'>$value</option>\n";
	}
echo "</select>";
if(@$testPark)
	{
	$sql="SELECT * FROM location where parkcode='$testPark' order by location";
	$result = @mysql_query($sql, $connection) or die($sql);
	while ($row=mysql_fetch_array($result))
		{$menuArray[$row['loc_code']]=$row['location'];}
	
	echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Location</b> <select name=\"loc_code\">
	<option selected></option>";
	foreach ($menuArray as $k=>$v)
		{
		if(@$loc_code==$k)
			{$s="selected";}else{$s="value";}
			echo "<option $s='$k'>$v</option>\n";
		}
	   echo "</select>";
	}
     
echo "</td><td><b>District:</b>
<select name='dist'>
<option value=''>
<option value='EADI'>EADI
<option value='NODI'>NODI
<option value='SODI'>SODI
<option value='WEDI'>WEDI
</select></td>

<td><b>Region:</b>
<select name='region'>
<option value=''>
<option value='CORE'>CORE
<option value='MORE'>MORE
<option value='PIRE'>PIRE
</select></td>
    </tr>
    <tr> 
      <td align='right'><b>Citation Number:</b></td>
      <td colspan='5'> 
        C-<input type='text' name='citation' size='20'> Group by: <input type='radio' name='groupCite'> Voided: <input type='checkbox' name='voidCITE'>
      </td>
    </tr>
    <tr> 
      <td align='right'><b>Officer's Last Name:</b></td>
      <td colspan='5'> 
        <input type='text' name='ranger' size='20'>
      </td>
    </tr>
    <tr> 
      <td align='right'><b>Violator's Name:</b><br>Any part of their name.</td>
      <td colspan='5'> 
        <input type='text' name='violator' size='25' maxlength='50'>";
        
$menuArray=array("M","F");
echo "&nbsp;&nbsp;&nbsp;<b>Sex</b>:<select name=\"sex\">
<option selected></option>";
foreach ($menuArray as $v)
	{
	if(@$sex==$v)
		{$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
	}
   echo "</select>";
      
$menuArray=array("White","Black","Hispanic","Native American", "Asian/Pacific Islander", "Other");
echo "&nbsp;&nbsp;&nbsp;<b>Race</b>:<select name=\"race\">
<option selected></option>";
foreach ($menuArray as $v)
	{
	if(@$race==$v)
		{$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
	}
   echo "</select></td>
    </tr>
    <tr>";
      
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database0");
$sql="SELECT * FROM violation order by id";
$result = @mysql_query($sql, $connection) or die($sql);
while ($row=mysql_fetch_array($result))
	{
	$menuArrayVio[$row['chargeID']]=$row['charge'];
	}

echo "<td align='right' height='80' valign='top'><b>Specific Charge: </b><td align='center' valign='top'><select name=\"chargeBoth\">
<option selected></option>";
foreach ($menuArrayVio as $k=>$v)
	{
	if(@$charge1==$k)
		{$s="selected";}else{$s="value";}
		echo "<option $s='$k'>$v</option>\n";
	if($v=="Other violation - Write in")
		{
	//	echo "<option $s=''>[STANDARD Violations above <----> PARK Violations below]</option>\n";
		}
	}
   echo "</select><br><b>All Types of a Charge</b> (e.g. alcohol): <input type='text' name='chargeLike'>
      </td>
    </tr>
    <tr> 
      <td align='right'><b>Disposition:</b>
        </td>
      <td>"; 
$menuArray=array("Guilty","Not Guilty","PJC","G.S. 90-96 Referral Program","Pending","Dismissed","Unknown","Other");
echo "<select name=\"disposition1\">
<option selected></option>";
foreach ($menuArray_disposition as $v)
	{
	if(@$disposition1==$v)
		{$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
       }
   echo "</select>
</td></tr></table>

<table><tr><td width = '55%' align='right'>
<input type='reset' name='Reset' value='Reset'></td>";
if(@$varEdit==1)
	{
	$varEdit="<input type='hidden' name='editRecord' value='yes'>";
	}
	else
	{$varEdit="";}
	
echo "<td width = '25%'>
$varEdit
<input type='submit' name='Submit' value='Search'></td>
</form></tr></table></div>
</body>
</html>";
?>
