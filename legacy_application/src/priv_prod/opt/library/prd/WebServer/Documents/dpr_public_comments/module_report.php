<?php

echo "
	<tr><td><font color='brown'>Monitoring Reports</font></td><td>
	<input type='file' name='report'>
	<input type='hidden' name='proj_id' value=\"$id\">
	<input type='hidden' name='proj_number' value=\"$proj_number\">
	</td>
	<td>";
	
	$sql="SELECT * FROM upload_report where proj_id='$id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY_report[]=$row;}
		}
		
	if(!empty($ARRAY_report))
		{
		$skip_report=array("id_report","proj_id","proj_number");
		echo "<table cellpadding='3'>";
		foreach($ARRAY_report AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY_report[0] AS $fld=>$value)
					{
					if(in_array($fld,$skip_report)){continue;}
					if($fld=="link"){$fld="";}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip_report)){continue;}
				if($fld=="link")
					{
					$value="<a href='$value' target='_blank'>download</a>";
					if($level>3 OR $_SESSION['dpr_rema']['emid']==$submitted_by)
						{
						$id_type="report";
						$pass_id_report=$array['id_report'];
						$proj_id=$array['proj_id'];
						if(!empty($proj_id))
							{
							$value.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='project.php?type=$id_type&pass_id_report=$pass_id_report&proj_id=$proj_id&submit=Delete' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a>";
							
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