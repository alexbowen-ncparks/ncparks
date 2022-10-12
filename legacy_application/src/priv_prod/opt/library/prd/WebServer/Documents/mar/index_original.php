<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
date_default_timezone_set('America/New_York');
include_once("menu.php");
?>

<html>
<head>
<title>Search WAR database</title>
</head>
<body><div align="center">

<?php
/* Use the INCLUDE statement to load a Function file*/
include ("include/functions.php");
?>
<p><font size="3" font color="#004201">WAR Search Page
<br>
  Please enter your search criteria(um):</font>
  <form method="post" action="find.php">
<?php
/*
echo "<input type='radio' name='compare' value='OR'>OR<br>
<input type='radio' name='compare' value='AND' checked> AND";
*/

echo "<table width='50%'>
<tr><td><b>Program:</b></td>";
  
$programArray=array("adm"=>"Administration","con"=>"Design and Development","exh"=>"Exhibits","ie"=>"I&E","ope"=>"Operations","pla"=>"Planning","res"=>"Resource Management","tra"=>"Trails");

$i=1;
while (list($key,$val)=each($programArray)){
if($i==5){echo "</tr><tr><td>&nbsp;</td>";}
echo "<td><input type='radio' name='section' value='$key'> $val</td>";
$i++;
}
echo "</tr></table>";

?>

<table>
    <tr>
      <td height="39"><b>Week:</b>
  <select name="weekTest">
<?php
$week = date('W'); 
$week_1 = $week-2; 

//if(date(n)<7){$n1="-2";$n2=26;}else{$n1=24;$n2=54;}
$n1=-1;$n2=$week;

for ($n=$n1;$n<=$n2;$n++)
{
$weekList=getWeekNumber($n);
if ($n == $week_1){echo "<option value='$n' selected>$weekList\n";} ELSE {echo "<option value='$n'>$weekList\n";}
}
echo "</select></td><td>Ignore Week <input type='checkbox' name='ignore' value='1'></td>";


$thisYear = date('Y'); 
$thisMonth = date('n');
if($thisMonth==1){$prevMonth=13-$thisMonth;}else{$prevMonth=$thisMonth-1;}

echo "</tr>
    <tr> 
      <td align=\"right\"><b>Date of Activity:</b></td>
      <td height=\"29\"> 
        <input type=\"text\" name=\"month\" size=\"3\" maxlength=\"2\">
        Month</td>
<td> Year:";

//echo "t=$thisMonth";exit;
//$thisMonth = 1;  // for testing purpose
if ($thisMonth == 1 and $week==1) {
        $thisYear = $thisYear-1; 
        echo "<input type='radio' name='yearRadio' value='$thisYear'checked>";
echo "$thisYear";

$thisYear = $thisYear+1; 
        echo "</td><td><input type='radio' name='yearRadio' value='$thisYear' ></td>";
echo "$thisYear";
        echo "<td width='18%'><input type='text' name='yearText' size='4' maxlength='4'>
        Enter Any Year <="; echo "$thisYear </td>";
}
else {
$thisYear = $thisYear; 
        echo "<input type='radio' name='yearRadio' value='$thisYear' checked>";
echo "$thisYear";
echo "&nbsp;&nbsp;<input type='text' name='yearText' size='8' maxlength='4'>
        Enter any year <="; echo "$thisYear</td>";
}
?> <br>
      </td>
      <td width="19%" height="29">&nbsp;</td>
    </tr>
    <tr> 
      <td align="right"><b>Park:</b></td>
      <td colspan="3" height="39"> 
        <input type="text" name="park" size="7" maxlength="4"> 
&nbsp;&nbsp;&nbsp; <b>District:</b>
<select name="dist">
<option value="">
<option value="EADI">EADI
<option value="NODI">NODI
<option value="SODI">SODI
<option value="WEDI">WEDI
</select></td>

    </tr>
    <tr> 
      <td align="right"><b>Title:</b></td>
      <td colspan="5"> 
        <input type="text" name="title" size="25" maxlength="50"> Any word or phrase from the title.
      </td>
    </tr>
    <tr> 
      <td align="right"><b>Body:</b>
        </td>
      <td colspan="5" rowspan="3" valign="top"> 
         <input type="text" name="body" size="25" maxlength="50"> Any word or phrase from the body.</td></tr></table>

<table><tr><td width = "25%"><input type="reset" name="Reset" value="Reset"></td width = "25%"><td width = "25%"><input type="submit" name="Submit" value="Search"></td><td>
</form>
   </tr></table></div>
</body>
</html>
