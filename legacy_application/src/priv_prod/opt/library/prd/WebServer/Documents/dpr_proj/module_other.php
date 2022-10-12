<?php
$VAR="other";
$upload_table="upload_".$VAR;
$action="upload_".$VAR.".php";
$display_name=ucwords($VAR);
echo "
	<tr><td><font color='brown'>$display_name</font></td><td>
	<input type='file' name='$VAR'>
	<input type='hidden' name='VAR' value=\"$VAR\">
	<input type='hidden' name='proj_id' value=\"$id\">
	<input type='hidden' name='proj_number' value=\"$proj_number\">
	</td>
	<td>";
	
	unset($ARRAY);
	$sql="SELECT * FROM $upload_table where proj_id='$id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY[]=$row;}
		}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;		
	if(!empty($ARRAY))
		{
		$var_id="id_".$VAR;
		$skip=array("$var_id","proj_id","proj_number");
		echo "<table cellpadding='3'>";
		foreach($ARRAY AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY[0] AS $fld=>$value)
					{
					if(in_array($fld,$skip)){continue;}
					if($fld=="link"){$fld="";}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if($fld=="link")
					{
					$share_docs[$array['file_name']]="https://10.35.152.9/dpr_proj/".$value;
					$share_docs[$array['file_name']]="https://10.35.152.9/dpr_proj/".$value;
					$value="<a href='$value' target='_blank'>download</a>";
					if($level>3 OR $_SESSION['dpr_proj']['emid']==$submitted_by)
						{
						$id_type=$VAR;
						$var_fld="id_".$VAR;
						$pass_fld="pass_id_".$VAR;
						$pass_id=$array[$var_fld];
						$proj_id=$array['proj_id'];
						if(!empty($proj_id))
							{
							$value.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='project.php?type=$id_type&$pass_fld=$pass_id&proj_id=$proj_id&submit=Delete' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a>";
							
							}
						}
					}
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table>";
		}
	echo "</td>
	</tr>
";
?>