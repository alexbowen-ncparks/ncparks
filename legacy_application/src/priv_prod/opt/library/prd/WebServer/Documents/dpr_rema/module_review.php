<?php

echo "<form method='POST' action='upload_review.php' enctype='multipart/form-data'>
	<tr><td><font color='brown'>Reviews</font></td><td>
	<input type='file' name='draw'>
	<input type='hidden' name='proj_id' value=\"$id\">
	<input type='hidden' name='proj_number' value=\"$proj_number\">
	<input type='submit' name='submit' value=\"Upload\">
	</form>
	</td>
	<td>";
	
	$sql="SELECT * FROM upload_draw where proj_id='$id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY_draw[]=$row;}
		}
		
	if(!empty($ARRAY_draw))
		{
		$skip_draw=array("id_draw","proj_id","proj_number");
		echo "<table cellpadding='3'>";
		foreach($ARRAY_draw AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY_draw[0] AS $fld=>$value)
					{
					if(in_array($fld,$skip_draw)){continue;}
					if($fld=="link"){$fld="download";}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip_draw)){continue;}
				if($fld=="link")
					{
					$value="<a href='$value' target='_blank'>link</a>";
					if($level>3 OR $_SESSION['dpr_rema']['emid']==$submitted_by)
						{
						$id_type="draw";
						$pass_id_draw=$array['id_draw'];
						$proj_id=$array['proj_id'];
						if(!empty($proj_id))
							{
							$value.="</td><td><form method='POST' action='project.php' onClick=\"confirm('Do you really want to delete this File?')\">
							<input type='hidden' name='type' value='$id_type'>
							<input type='hidden' name='pass_id_draw' value='$pass_id_draw'>
							<input type='hidden' name='proj_id' value='$proj_id'>
							<input type='submit' name='submit' value='Delete'>
							</form>";
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