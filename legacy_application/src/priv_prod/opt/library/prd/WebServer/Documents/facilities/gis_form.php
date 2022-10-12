<?php
if(@$message){echo "<tr><td colspan='$cells' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

//$exclude=array("id");
//if($level<4){$exclude[]="pac_nomin_comments";}

	$distArray=array("EADI","NODI","SODI","WEDI",);
	
$sql = "SELECT occupant, id as z_id FROM facilities.housing where park_code='$PARK_ABBR'"; echo "$sql";
		$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
		while ($row=mysql_fetch_assoc($result))
			{
			$z_idArray[$row['z_id']]=$row['occupant'];
			}
$fieldArray[]="z_id";
$drop_menu=array("z_id");
$sortArray=array("PARK_ABBR","tempID");
$cells=5;
echo "<tr>";
foreach($fieldArray as $k=>$fld)
	{
	@$value=${$fld};
	if(fmod($k,$cells)==0){echo "</tr><tr>";}
	if(isset($readonly) AND in_array($fld,$readonly))
		{$RO="readonly";}else{$RO="";}
		
		if(in_array($fld,$drop_menu))
			{
			@$value=${$fld};
			$fldName=$fld;
			if($fld=="z_id"){$fldName="Designate Occupant";}
			echo "<td>$fldName<br /><select name='$fld'><option selected=''></option>";
			$array=${$fld."Array"};
			foreach($array as $k1=>$v1)
				{
				if($value==$v1){$s="selected";}else{$s="value";}
				echo "<option $s='$k1'>$v1</option>";
				}
			echo "</select></td>";
			}
		else
		{
		echo "<td>$fld<br />";
		IF($value==""){$value="no data";}
		echo "<b>$value</b></td>";
//		echo "<input type='text' name='$fld' value='$value' $RO></td>";
		}
	}// end foreach
/*
$fld="sort";
if(@$id==""){
echo "</tr><tr><td>$fld by:<br /><select name='$fld'>";
			$array=${$fld."Array"};
			foreach($array as $k1=>$v1)
				{
				echo "<option value='$v1'>$v1</option>";
				}
			echo "</select></td>";
			}
*/
echo "</tr>";

?>