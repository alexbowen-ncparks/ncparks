<?php
$match_array=array("a","b","c","d");
if(in_array($fld, $match_array))
	{
	$fld1=$fld."[]";
	$fld2=$fld."[]";
	echo "<td>List
	<textarea name='$fld1' cols='44' rows='$rows'>$value</textarea>
";
	echo "Procedure
	<textarea name='$fld2' cols='44' rows='$rows'>$value</textarea>
	</td>";
	}
	else
	{
	echo "<td>
	<textarea name='$fld' cols='$cols' rows='$rows'>$value</textarea>
	</td>";
	}
?>