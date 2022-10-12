<?php

$database="cite";
include("../../include/auth.inc"); // used to authenticate users
include_once("menu.php");
include_once("../../include/get_parkcodes_dist.php");
date_default_timezone_set('America/New_York');

extract($_REQUEST);

/*
ECHO "<pre>";
print_r($_REQUEST);
print_r($_SESSION);
echo "</pre>";
*/
//exit;
//echo "</pre>";exit;

echo "<div align='center'>
<p><font size=\"3\" color=\"004400\">New CITE Record</font><br>
  Please fill in the following information:";
  if(!empty($message)){echo "<br><font color='red'>$message</font>";}
  
echo "<form name='citeForm' method=\"post\" action=\"addCite.php\">";

/* Use the INCLUDE statement to both CONNECT and SELECT the correct database*/
 include ("../../include/iConnect.inc");
 mysqli_select_db($connection,$database);

$enter_by=$_SESSION['cite']['tempID'];
   echo "<table align='center'><tr> 
      <td height='39' align='center' width='100'><b>Entered by:</b><br>$enter_by</td>
        <input type='hidden' name='enter_by' value='$enter_by'>
      </td>";


if($_SESSION['cite']['level']=="1")
	{
	if($_SESSION['cite']['select']=="JORD")
		{$_SESSION['cite']['accessPark']="JORD,DERI";}

	$pc=explode(",",$_SESSION['cite']['accessPark']);
	$num_park=count($pc);
	$clause="";
	if($num_park>1)
		{
		unset($parkCode);
		foreach($pc as $k=>$v)
			{
			@$i++;
			$parkCode[$i]=$v;
			// used for Officer name
			$clause.="position.park='$v' OR ";
			}
		if(empty($testPark)){$testPark=$_SESSION['cite']['parkS'];}
		}
		else
		{
		$testPark=$_SESSION['cite']['parkS'];
		}
  	}
 
 
if(!empty($park))
	{$testPark=$park;}// passed back from error check in addCite.php
      
      
// park array from parkcodesDiv.inc
echo "<td><b>Park Name</b><br><select name='park' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";
//for ($i=1;$i<=count($parkCode);$i++)
foreach($parkCode as $k=>$v)
	{
	if($v==@$testPark)
		{$s="selected";}else{$s="value";}
		 echo "<option $s='cite_new.php?testPark=$v'>$v</option>\n";
	}
echo "</select>\n</td>";
$database="cite";
 mysqli_select_db($connection,$database);
if(@$testPark)
	{
	$sql="SELECT * FROM location where parkcode='$testPark'";
	$result = @mysqli_query($connection,$sql) or die($sql." ".mysqli_error($connection));
	while ($row=mysqli_fetch_array($result))
		{
		$menuArray[$row['loc_code']]=$row['location'];
		}
	
	echo "<td align='center'><b>Location</b><br><select name=\"loc_code\">
	<option selected></option>";
	foreach ($menuArray as $k=>$v)
		{
		if(@$loc_code=="$k-$v"){$s="selected";}else{$s="value";}
		echo "<option $s='$k'>$k-$v</option>\n";
		}
	   echo "</select></td>";
	/*
	$menuArray=array("EADI","NODI","SODI","WEDI");
	echo "<td align='center'><b>District</b><br><select name=\"dist\">
	<option selected></option>";
	foreach ($menuArray as $v){
	if($dist==$v){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>\n";
		   }
	   echo "</select></td>";
	*/
	if(!isset($citation)){$citation="";}
	echo "</tr></table>
	<table align='center'><tr> 
		  <td align='right'><b>Citation Number: </b></td>
		  <td> &nbsp;&nbsp;C-
			<input type='text' name='citation' value='$citation' size='25'>
		  </td>";
	
	echo "<td align='right'><b>Date of Citation:</b></td>";
	//$thisMonth = date('n');
	$monthArray=array("Jan"=>"1","Feb"=>"2","Mar"=>"3","Apr"=>"4","May"=>"5","Jun"=>"6","Jul"=>"7","Aug"=>"8","Sep"=>"9","Oct"=>"10","Nov"=>"11","Dec"=>"12");
	echo "<td><select name='month'>\n";
	 echo "<option value=''>\n";
	while (list($key,$val)=each($monthArray))
		{
		if(@$month=="$val-$key")
			{$v="selected";}
			else
			{$v="value";}
		  echo "<option $v='$val-$key'>$val-$key";
		}
	echo "</select> Month &nbsp;&nbsp;";
	
	$dayArray = range(1,31);
	echo "<select name='day'>\n";
	 echo "<option value=''>\n";
	for ($i=0; $i <=30; $i++)
		{
		$val = $dayArray[$i];
		if(@$day==$val)
			{$v="selected";}
			else
			{$v="value";}
			 echo "<option $v='$val'>$val";
		}
	echo "</select> Day &nbsp;";
	?>
	
	 <?php
	 $thisYear = date('Y'); 
	$prevYear = $thisYear-1; 
	$earlyYear = $thisYear-2; 
			echo "&nbsp;&nbsp;<input type='radio' name='year' value='$thisYear' checked>";
	echo "$thisYear";
	echo "&nbsp;&nbsp;<input type='radio' name='year' value='$prevYear'>";
	echo "$prevYear";
	echo "&nbsp;&nbsp;<input type='radio' name='year' value='$earlyYear'>";
	echo "$earlyYear";
	
	echo "</tr>";
	
	unset($menuArray);
 mysqli_select_db($connection,'divper');
	
	if(@$clause!="")
		{
		$pp=rtrim($clause," OR ");
		}
		else
		{
		$pp="position.park='$testPark'";
		}
	
	$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle
	FROM position
	LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
	LEFT JOIN empinfo on empinfo.emid=emplist.emid
	where $pp and position.posTitle LIKE 'Park %'
	order by empinfo.Lname,empinfo.Fname";
	
	//echo "$sql";//exit;
	$result = @mysqli_query($connection,$sql) or die($sql);
	while ($row=mysqli_fetch_array($result))
		{
		if($row['tempID'])
			{$menuArray[$row['tempID']]=$row['Lname'].", ".$row['Fname']." ".$row['Mname'];}
		}
	if($testPark=="ENRI")
		{$menuArray['Langdon5804']="Langdon, David";}
		
	if($_SESSION['cite']['level']==2)
		{	
		$menuArray[$_SESSION['cite']['tempID']]=$_SESSION['cite']['last'].", ".$_SESSION['cite']['first'];
		}
	echo "<tr><td align='center' colspan='4' height='33'>";
	if($_SESSION['cite']['level']>"3")
		{
		echo "<input type='button' value='Officer Override' onclick=\"return popitup('parkOverride.php?parkcode=$parkcode')\">";
		
		$overrideOfficer="&nbsp;&nbsp;&nbsp;&nbsp;<input name='overOfficer' type='text' value=''>";
		$voidCITE="&nbsp;&nbsp;&nbsp;&nbsp;<input name='voidCITE' type='checkbox' value='x'> Void this Citation";
		}
	echo " <b>Officer's Name:</b> <select name=\"empID\">
	<option selected></option>";
	if(!isset($overrideOfficer)){$overrideOfficer="";}
	if(!isset($voidCITE)){$voidCITE="";}
	if(!isset($violator)){$violator="";}
	foreach ($menuArray as $k=>$v)
		{
		if(@$empID=="$k-$v"){$s="selected";}else{$s="value";}
		echo "<option $s='$k-$v'>$k-$v</option>\n";
		}
		
	   echo "</select>$overrideOfficer $voidCITE</td></tr></table>	   
	<table>
		<tr> 
		  <td align='left' height='60' colspan='4'><b>Violator's Last, First, Middle Name:<br>
		  <input type='text' name='violator' value='$violator' size='50' maxlength='80'>";
	
	$menuArray=array("M","F");
	echo "&nbsp;&nbsp;&nbsp;<b>Sex</b>:<select name=\"sex\">
	<option selected></option>";
	foreach ($menuArray as $v)
		{
		if(@$sex==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
		}
	   echo "</select>";
		  
	$menuArray=array("White","Black","Hispanic","Native American", "Asian/Pacific Islander", "Other");
	echo "&nbsp;&nbsp;&nbsp;<b>Race</b>:<select name=\"race\">
	<option selected></option>";
	foreach ($menuArray as $v)
		{
		if(@$race==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
		}
	   echo "</select></td>";
		  
	echo "</tr>
		<tr>";
	  
	//unset($menuArray);
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database0");
	$sql="SELECT * FROM violation order by id";
	$result = @mysqli_query($connection,$sql) or die($sql);
	while ($row=mysqli_fetch_array($result))
		{$menuArrayVio[$row['chargeID']]=$row['charge'];}
	
	echo "<td align='right' height='80' valign='top'><b>Primary Violation: </b><td align='center' valign='top'><select name=\"charge1\">
	<option selected></option>";
	foreach ($menuArrayVio as $k=>$v)
		{
		if(@$charge1=="$k-$v"){$s="selected";}else{$s="value";}
		if($k!=57)
			{
			echo "<option $s='$k-$v'>$k-$v</option>\n";
			}
			else
			{
			echo "<option $s='$k-$v'>*******$v</option>\n";
			}
		
		if($v=="Other violation - Write in")
			{
		//	echo "<option $s=''>[STANDARD Violations above <----> PARK Violations below]</option>\n";
			}
		}
	if(!isset($charge1_other)){$charge1_other="";}
	   echo "</select><br>
			<input type='text' name='charge1_other' value='$charge1_other' size='45' maxlength='80'><br><b>Enter violation if \"Other\"</b></td>";
		 
	$menuArray=array("Guilty","Not Guilty","PJC","Failure_to_Appear","Deferred_Prosecution","Dismissed","Unknown","Other");
	
	echo "<td align='right' height='63'><b>Primary Disposition: </b></td>
		  <td colspan='5'><select name=\"disposition1\">
	<option selected></option>";
	foreach ($menuArray_disposition as $v)
		{
		if(@$disposition1==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
		}
		if(!isset($disposition_other)){$disposition_other="";}
	   echo "</select><br>
			<input type='text' name='disposition1_other' size='45' maxlength='80' value='$disposition_other'><br><b>Enter disposition if \"Other\"</b></td></tr>";
	   
	echo "<tr><td align='right' valign='top'><b>Secondary Violation: </b><td align='center'><select name=\"charge2\">
	<option selected></option>";
	foreach ($menuArrayVio as $k=>$v)
		{
		if(@$charge2==$k-$v){$s="selected";}else{$s="value";}
		if($k!=57)
			{
			echo "<option $s='$k-$v'>$k-$v</option>\n";
			}
			else
			{
			echo "<option $s='$k-$v'>*******$v</option>\n";
			}
		if($v=="Other violation - Write in")
			{
	//		echo "<option $s=''>[STANDARD Violations above <----> PARK Violations below]</option>\n";
			}
		}
	if(!isset($charge2_other)){$charge2_other="";}
	   echo "</select><br>
			<input type='text' name='charge2_other' value='$charge2_other' size='45' maxlength='80'><br><b>Enter violation if \"Other\"</b></td>";
	   
	echo "<td align='right' height='33'><b>Secondary Disposition: </b></td>
		  <td colspan='5'><select name=\"disposition2\">
	<option selected></option>";
	foreach ($menuArray as $v)
		{
		if(@$disposition2==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
		}
	if(!isset($disposition_other)){$disposition_other="";}
	   echo "</select><br>
			<input type='text' name='disposition2_other' size='45' maxlength='80' value='$disposition_other'><br><b>Enter disposition if \"Other\"</b></td></tr>";
		 
	echo "<tr> 
		  <td align='center' colspan='4'><br><input type='submit' name='Submit' value='Submit'>
	</form></td>";
	}
echo "</tr></table></div></body></html>";
?>