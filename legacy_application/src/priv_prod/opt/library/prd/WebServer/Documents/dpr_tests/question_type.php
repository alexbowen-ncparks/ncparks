<?php
if($fld=="question_type")
	{
	$val=$_POST['question_type'];
	$var_fld=$rename_array[$fld];
	echo "<td><select name='$fld'><option value=\"\" selected=''></option>\n";
	foreach($question_type_array as $k=>$v)
		{
		if($val==$v){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
		}
	echo "</select></td></tr>";
// 	continue;
	}

?>