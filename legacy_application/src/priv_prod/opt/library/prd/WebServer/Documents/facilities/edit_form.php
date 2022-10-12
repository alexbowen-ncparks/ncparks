<?php
if(@$message){echo "<tr><td colspan='$cells' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

$drop_menu=array("park_code");
$park_codeArray=$parkCode;
$cells=5;
echo "<tr>";
foreach($fieldArray as $k=>$fld)
	{
	$fld=str_replace("t1.","",$fld);
	$value=${$fld};
	if(fmod($k,$cells)==0){echo "</tr><tr>";}
	if(isset($readonly) AND in_array($fld,$readonly))
		{$RO="readonly";}else{$RO="";}
		
		if(in_array($fld,$drop_menu))
			{
			$value=${$fld};
			echo "<td>$fld<br /><select name='$fld'><option selected=''></option>";
			$array=${$fld."Array"};
			foreach($array as $k1=>$v1)
				{
				if($value==$v1){$s="selected";}else{$s="value";}
				echo "<option $s='$v1'>$v1</option>";
				}
			echo "</select></td>";
			}
		else
		{
		echo "<td>$fld<br />";
		$display="<input type='text' name='$fld' value='$value' $RO>";
		if($fld=="photo"){$display="<a href='$value' target='_blank'>view</a>";}
		echo "$display</td>";
		}
	}// end foreach
$fld="sort";
if($id==""){
echo "</tr><tr><td>$fld by:<br /><select name='$fld'>";
			$array=${$fld."Array"};
			foreach($array as $k1=>$v1)
				{
				echo "<option value='$v1'>$v1</option>";
				}
			echo "</select></td>";
			}
echo "</tr>";

?>