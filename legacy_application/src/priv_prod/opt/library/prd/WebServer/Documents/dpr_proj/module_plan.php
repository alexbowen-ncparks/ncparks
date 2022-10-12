<?php
echo "<tr><td><font color='brown'>Written Plan/Narrative</font></td><td>
	<input type='file' name='plan'>
	<input type='hidden' name='proj_id' value=\"$id\">
	<input type='hidden' name='proj_number' value=\"$proj_number\">
	</td>
	<td>";
	$sql="SELECT * FROM upload_plan where proj_id='$id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY_plan[]=$row;}
		}
	if(!empty($ARRAY_plan))
		{
		$skip_plan=array("id_plan","proj_id","proj_number");
		echo "<table cellpadding='3'>";
		foreach($ARRAY_plan AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY_plan[0] AS $fld=>$value)
					{
					if(in_array($fld,$skip_plan)){continue;}
					if($fld=="link"){$fld="";}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip_plan)){continue;}
				if($fld=="link")
					{
					$share_docs[$array['file_name']]="/dpr_proj/".$value;
					$share_docs[$array['file_name']]="/dpr_proj/".$value;
					$value="<a href='$value' target='_blank'>download</a></td><td>";
					if($level>3 OR $_SESSION['dpr_proj']['emid']==$submitted_by)
						{
						$id_type="plan";
						$pass_id_plan=$array['id_plan'];
						$proj_id=$array['proj_id'];
						if(!empty($proj_id))
							{
							$value.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='project.php?type=$id_type&pass_id_plan=$pass_id_plan&proj_id=$proj_id&submit=Delete' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a>";
							
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