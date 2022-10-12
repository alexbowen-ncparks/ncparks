<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); // used to authenticate users

include_once("../../include/get_parkcodes.php");
mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');
include_once("menu.php");

//echo "<pre>"; print_r($_SESSION); echo "</pre>";
$testPark=$_SESSION['war']['select'];
$warLevel=$_SESSION['war']['level'];
//print_r($all_parks); echo "t=$testPark";exit;
if(in_array($testPark,$all_parks)){$ckSECT="ope";}else{$ck="";}

$sql = "SELECT * FROM style order by topic";//echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
while ($row=mysql_fetch_row($result))
{$idArray[]=$row[0];$topicArray[]=$row[1];}

echo "<html>
<head>
<title>New Record</title>
</head><body> 
<table><tr><td><font size=\"3\" color=\"004400\">New WAR Record</font></td>
<td><form name=form> <select name=\"site\" size=\"1\" onChange=\"formHandler(this.form)\">";

echo "<option value=''>Style Topics\n";
for ($i=0;$i<count($topicArray);$i++){
     echo "<option value='style.php?c=1&submit_label=Find&id=$idArray[$i]'>$topicArray[$i]\n";
}
echo "</select></form></td><td><form name=popupform>
<input type=button name=choice onClick=\"window.open('tips.php','popuppage','width=750,height=600,top=100,left=500,scrollbars=yes');\" value=\" >> WAR Tips << \">

</form>
</td></tr>
<tr><td>Please fill in the following information:</td></tr></table>";

echo "<form method=\"post\" action=\"addWar.php\"><table width='50%' cellpadding='7'>
<tr><td><b>Program:</b></td></tr>";
  
$programArray=array("adm"=>"Administration","con"=>"Design and Development","exh"=>"Exhibits","ie"=>"I&E","ope"=>"Operations","pla"=>"Planning","res"=>"Resource Management","tra"=>"Trails");
echo "<tr>";
$i=1;
while (list($key,$val)=each($programArray))
	{
	if($i==5){echo "</tr><tr>";}
	if($key==@$ckSECT){$ck="checked";}else{$ck="";}
	echo "<td><input type='radio' name='section' value='$key'$ck> $val</td>";
	$i++;
	}
echo "</tr></table>";
?>

    <table><tr> 
      <td height="19"><b>Entered by:</b></td>
      <td colspan="5" height="19"> 
        <input type="text" name="enter_by"
        
 <?php 
 $u=$_SESSION['war']['tempID'];
 echo "value='$u'";?>  
        >
      </td></tr></table>
  <table width="100%" cellpadding="1">
    <tr><td align='right'><b>Date of Activity:</b></td>
<td>     
<?php

$thisMonth = date('n');
$monthArray=array(""=>"","Jan"=>"1","Feb"=>"2","Mar"=>"3","Apr"=>"4","May"=>"5","Jun"=>"6","Jul"=>"7","Aug"=>"8","Sep"=>"9","Oct"=>"10","Nov"=>"11","Dec"=>"12");
echo "<select name='month'>\n";
//$numArray=array_values($monthArray);
//$keyArray=array_keys($monthArray);
foreach($monthArray as $key=>$val)
	{
	$v="value";
	  echo "<option $v='$val'>$key</option>";
	}
echo "</select> Month &nbsp;&nbsp;";


$dayArray = range(1,31);
echo "<select name='day'>\n";
 echo "<option value=''>\n";
for ($i=0; $i <=30; $i++)
	{
	$day = $dayArray[$i];
		 echo "<option value='$day'>$day";
	}
echo "</select> Day &nbsp;";
?>

 <?php $thisYear = date('Y'); 
if ($thisMonth == 1)
	{
		$thisYear = $thisYear-1; 
		echo "<input type='radio' name='year' value='$thisYear'>";
	
	echo "$thisYear";
	$thisYear = $thisYear+1; 
			echo "&nbsp;&nbsp;<input type='radio' name='year' value='$thisYear'>";
	echo "$thisYear";
	}
elseif ($thisMonth !=1) {
        echo "&nbsp;&nbsp;<input type='radio' name='year' value='$thisYear' checked>";
echo "$thisYear";
}
?>

</td></tr>
    <tr> 
      <td align='right'><b>Park:</b></td>
      <td colspan="3">
<?php
// $testPark loaded above

echo "<select name='park'><option selected=''></option>";
foreach($parkCode as $index=>$park_code)
	{
	if($park_code==$testPark and $warLevel=="1")
		{$v="selected";}else{$v="value";}
		 echo "<option $v='$park_code'>$park_code</option>\n";
	}
echo "</select>\n";

?>
  <font size="-2">(Only needed for FIELD OPERATIONS entries.)</font></td>
      <td width="5%">&nbsp;</td>
      <td width="9%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
    </tr>
<tr>&nbsp;</tr>
    <tr> 
      <td align='right'><b>Title:</b></td>
      <td colspan="5"> 
        <input type="text" name="title" size="80" maxlength="100">
      </td>
    </tr>
    <tr> 
      <td align="right"><b>Body:</b></td>
      <td colspan="5" rowspan="3"> 
        <textarea name="body" cols="80" rows="20"></textarea>
      </td>
    </tr>
    <tr> 
      <td align="center"><br><input type="submit" name="Submit" value="Submit">
</form></td>
    </tr>
    <tr> 
      <td width="9%" height="125"> 
        
      </td>
    </tr>
  </table>
</body>
</html>