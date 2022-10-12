<?php
echo "<tr><td><font color='brown'>Photos</font></td><td>
	<input type='file' name='photos'>
	<input type='hidden' name='proj_id' value=\"$id\">
	<input type='hidden' name='proj_number' value=\"$proj_number\">
	</td>
	<td>";
	$sql="SELECT * FROM upload_photos where proj_id='$id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY_photos[]=$row;}
		}
	if(!empty($ARRAY_photos))
		{
		$skip_photos=array("id_photos","proj_id","proj_number");
		echo "<table cellpadding='3'>";
		foreach($ARRAY_photos AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY_photos[0] AS $fld=>$value)
					{
					if(in_array($fld,$skip_photos)){continue;}
					if($fld=="link"){$fld="";}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip_photos)){continue;}
				if($fld=="link")
					{
					$value="<a href='$value' target='_blank'>view</a></td><td>";
					if($level>3 OR $_SESSION['dpr_rema']['emid']==$submitted_by)
						{
						$id_type="photos";
						$pass_id_photos=$array['id_photos'];
						$proj_id=$array['proj_id'];
						if(!empty($proj_id))
							{
							$value.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='project.php?type=$id_type&pass_id_photos=$pass_id_photos&proj_id=$proj_id&submit=Delete' onclick=\"return confirm('Are you sure you want to delete this Photos?')\">Delete</a>";
							
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