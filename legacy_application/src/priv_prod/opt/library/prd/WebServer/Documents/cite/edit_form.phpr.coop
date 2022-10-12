<?php
include_once("../../include/get_parkcodes_dist.php");
include_once("menu.php");
//print_r($chargeArray);//exit;
$enter_by=$_SESSION['cite']['tempID'];
$level=$_SESSION['cite']['level'];

if($level<2){$testPark=$_SESSION['cite']['parkS'];}

echo "<html>
<head>
<title>Edit Record</title>
</head>
<body><div align='center'>
<p><font size=\"3\" color=\"004400\">Edit a CITE Record</font>
<form method=\"post\" action=\"updateCite.php\">";

echo "<table align='center' border='1' cellpadding='3'><tr> 
      <td><b>Being Edited by: </b>$enter_by</td>";
      
echo "<td><b>Park: </b>$park</td>";
mysqli_select_db($connection,"cite");
$sql="SELECT * FROM location where parkcode='$park'";
$result = @mysqli_query($connection,$sql) or die($sql." ".mysqli_error($connection));
while ($row=mysqli_fetch_array($result))
	{$menuArray[$row['loc_code']]=$row['location'];}

echo "<td align='center'><b>Location</b><br><select name=\"loc_code\">
<option selected></option>";
foreach ($menuArray as $k=>$v)
	{
	if($loc_code==$k){$s="selected";}else{$s="value";}
	echo "<option $s='$k'>$k-$v</option>\n";
	}
   echo "</select></td>";

echo "<td><b>District: </b>$dist</td></tr></table>";
if($void=="x"){$vck="checked";}else{$vck="";}

echo "<table align='center'><tr> 
      <td align='right'>Check here <input type='checkbox' name='void' value='x' $vck> to void <b>Citation Number: <font size='+2' color='blue'>$citation</font></b></td><td>&nbsp;&nbsp;&nbsp;</td>";

echo "<td align='right'><b>Date of Citation:</b></td>";
$dateArray=explode("-",$date);

echo " <td>Month <input type='text' name='month' value='$dateArray[1]' size='3'> 
Day <input type='text' name='day' value='$dateArray[2]' size='3'> 
Year <input type='text' name='year' value='$dateArray[0]' size='6'> 
      </td>";
echo "</tr>";

unset($menuArray);
mysqli_select_db($connection,"divper");

if(@$testPark=="MOJE" || @$testPark=="NERI"){$pp="(position.park='MOJE' or position.park='NERI')";}else{$pp="position.park='$park'";}

$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle
FROM position
LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
LEFT JOIN empinfo on empinfo.emid=emplist.emid
where $pp and position.posTitle LIKE 'Park%'
order by empinfo.Lname,empinfo.Fname";

//echo "$sql";exit;
$result = @mysqli_query($connection,$sql) or die($sql);
while ($row=mysqli_fetch_array($result))
	{
	if($row['tempID']){$menuArray[$row['tempID']]=$row['Lname'].", ".$row['Fname']." ".$row['Mname'];}
	}
echo "<tr><td align='center' colspan='4' height='33'><b>Citing Officer:</b>";
	if(in_array($empID,$menuArray))
		{
		echo "<select name=\"empID\">
		<option selected></option>";
		foreach ($menuArray as $k=>$v)
			{
			if($empID==$k){$s="selected";}else{$s="value";}
			echo "<option $s='$k'>$k-$v</option>\n";
		  	 }
		   echo "</select></td>";
		}
   	else
		{
		if($level<4){$ro="READONLY";}else{$ro="";}
		echo "<tr><td align='center' colspan='4' height='33'><input type='text' name='empID' value='$empID' $ro></td>";
		}
   	
echo "</tr></table>
<table>
    <tr> 
      <td align='right' height='60'><b>Violator's Complete Name:</b></td>
      <td colspan='5'> 
        <input type='text' name='violator' value='$violator'size='50' maxlength='80'>";

$menuArray=array("M","F");
echo "&nbsp;&nbsp;&nbsp;<b>Sex</b>:<select name=\"sex\">
<option selected></option>";
foreach ($menuArray as $v)
	{
	if($sex==$v)
		{$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
	}
   echo "</select>";
      
$menuArray=array("White","Black","Hispanic","Native American", "Asian/Pacific Islander", "Other");
echo "&nbsp;&nbsp;&nbsp;<b>Race</b>:<select name=\"race\">
<option selected></option>";
foreach ($menuArray as $v)
	{
	if($race==$v)
		{$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
	}
   echo "</select></td>";
      
echo "</tr>
    <tr>";
  
mysqli_select_db($connection,"cite");
$sql="SELECT * FROM violation order by id";
$result = @mysqli_query($connection,$sql) or die($sql);
while ($row=mysqli_fetch_array($result))
	{
	$menuArrayVio[$row['chargeID']]=$row['charge'];
	}

//echo "<pre>"; print_r($chargeArray); echo "</pre>"; // exit;
echo "<td align='right' height='80' valign='top'><b>Primary Violation: </b><td align='center' valign='top'><select name=\"charge1\">
<option selected></option>\n<option value='remove'>Remove Charge</option>";

foreach ($menuArrayVio as $k=>$v)
	{
	if($chargeArray[0]==$k)
		{$s="selected";}else{$s="value";}
		echo "<option $s='$k'>$k-$v</option>\n";
		//if($v=="Other violation - Write in"){echo "<option $s=''>[STANDARD Violations above <----> PARK Violations below]</option>\n";}
       }
   echo "</select><br>
        <input type='text' name='charge1_other' size='45' maxlength='80' value='$chargeOtherArray[0]'><br><b>Enter violation if \"Other\"</b></td>";
     
$menuArray=array("Guilty","Not Guilty","PJC","Failure_to_Appear","Deferred_Prosecution","Dismissed","Unknown","Other");
echo "<td align='right' height='63'><b>Primary Disposition: </b></td>
      <td colspan='5'><select name=\"disposition1\">
<option selected></option>";
foreach ($menuArray_disposition as $v){
if($disposArray[0]==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
       }
   echo "</select><br>
        <input type='text' name='disposition1_other' size='45' maxlength='80' value='$disposOtherArray[0]'><br><b>Enter disposition if \"Other\"</b></td></tr>";
   
echo "<tr><td align='right' valign='top'><b>Secondary Violation: </b><td align='center'><select name=\"charge2\">
<option selected></option>\n<option value='remove'>Remove Charge</option>";
foreach($menuArrayVio as $k=>$v)
	{
	if(@$chargeArray[1]==$k){$s="selected";}else{$s="value";}
		echo "<option $s='$k'>$k-$v</option>\n";
		//if($v=="Other violation - Write in"){echo "<option $s=''>[STANDARD Violations above <----> PARK Violations below]</option>\n";}
       }
	$value_charg=@$chargeOtherArray[1];
   echo "</select><br>
        <input type='text' name='charge2_other' size='45' maxlength='80' value='$value_charg'><br><b>Enter violation if \"Other\"</b></td>";
   
echo "<td align='right' height='33'><b>Secondary Disposition: </b></td>
      <td colspan='5'><select name=\"disposition2\">
<option selected></option>";
foreach($menuArray_disposition as $v)
	{
	if(@$disposArray[1]==$v){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>\n";
	}
	$value_disp=@$disposOtherArray[1];
   echo "</select><br>
        <input type='text' name='disposition2_other' size='45' maxlength='80' value='$value_disp'><br><b>Enter disposition if \"Other\"</b></td></tr>";
        
     $u=$_SESSION['cite']['tempID'];
echo "<tr> 
      <td align='center' colspan='4'><br>
      Update by: $u<br>
      <input type='hidden' name='update_by' value='$u'>
      <input type='hidden' name='enter_by' value='$enter_by'>
      <input type='hidden' name='date' value='$date'>
      <input type='hidden' name='park' value='$park'>
      <input type='hidden' name='dist' value='$dist'>
      <input type='hidden' name='citation' value='$citation'>
      <input type='submit' name='update' value='Update'>
</form></td><td><a href='updateCite.php?citation=$citation&del=y&update_by=$u' onClick='return confirmLink()'>Delete</a></td>
    </tr>
  </table></div></body></html>";
?>