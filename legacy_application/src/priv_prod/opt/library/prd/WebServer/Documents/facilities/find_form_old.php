<?php
if($message){echo "<tr><td colspan='$cells' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

//$exclude=array("id");
//if($level<4){$exclude[]="pac_nomin_comments";}

	$distArray=array("EADI","NODI","SODI","WEDI",);
	
	$sql = "SELECT distinct park_code FROM housing order by park_code";//echo "$sql";
		$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
		while ($row=mysql_fetch_assoc($result))
			{
			$park_codeArray[]=$row['park_code'];
			}

$drop_menu=array("park_code");
$sortArray=array("park_code","tempID");
$cells=5;
echo "<tr>";
foreach($fieldArray as $k=>$fld)
	{
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
		echo "<td>$fld<br />
		<input type='text' name='$fld' value='$value' $RO></td>";
		}
	}// end foreach
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
echo "</tr>";

?>