<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";// exit;
$year=date('Y');
$prevYear=date('Y')-1;
echo "<table><form name='form2' action='add_park_inspection.php' method='POST'><tr>";
if(@$subunit=="")
	{
	$subunit="Pick an inspection from the list above.";
	}
echo "<td>Safety Activity Date for <font color='magenta'><b>$subunit:</b></font> </td></tr>";

// check for date sent from PR-63
$exp=explode("-",$date_occur);
list($pr_year,$pr_month,$pr_day)=$exp;

if(!empty($pr_year)){$year=$pr_year;}
echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Year: <select name='year'>
<option selected='$year'>$year</option>
<option value='$prevYear'>$prevYear</option>
</select></td>";

$monthArray=range(1,12);
$cm=date('m');
if(!empty($pr_month)){$cm=$pr_month+0;}
echo "<td>Month: <select name='month'>\n";
foreach($monthArray as $k=>$v)
	{
	if($v==$cm)
		{$s="selected";}
		else
		{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
echo "</select></td>";

$dayArray=range(1,31);
$cd=date('d');
if(!empty($pr_day)){$cd=$pr_day+0;}
echo "<td>Day: <select name='day'>\n";
foreach($dayArray as $k=>$v)
	{
	if($v==$cd)
		{$s="selected";}
		else
		{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
echo "</select></td>";


echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if(!empty($v_pr63))
{
echo "<input type='hidden' name='v_pr63' value='$v_pr63'>
<input type='hidden' name='date_occur' value='$date_occur'>
<input type='hidden' name='pr_id' value='$pr_id'>";
}
echo "<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='subunit' value='$subunit'>
<input type='submit' name='submit' value='Add'>
</td>";

echo "</tr></form></table>";
?>