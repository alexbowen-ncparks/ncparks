<?php

echo "
	<tr><td><font color='brown'>Resoure Management Review form</font></td><td><form method='POST' action='upload_rmr_form.php' enctype='multipart/form-data'>
	<input type='file' name='rmr_form'>
	<input type='hidden' name='proj_id' value=\"$id\">
	<input type='hidden' name='proj_number' value=\"$proj_number\">
	<input type='submit' name='submit' value=\"Upload\">
	</form>
	</td>
	<td>";
	
	$sql="SELECT * FROM upload_rmr_form where proj_id='$id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY_rmr_form[]=$row;}
		}
		
	if(!empty($ARRAY_rmr_form))
		{
		$skip_rmr_form=array("id_rmr_form","proj_id","proj_number");
		echo "<table cellpadding='3'>";
		foreach($ARRAY_rmr_form AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY_rmr_form[0] AS $fld=>$value)
					{
					if(in_array($fld,$skip_rmr_form)){continue;}
					if($fld=="link"){$fld="download";}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip_rmr_form)){continue;}
				if($fld=="link")
					{
					$value="<a href='$value' target='_blank'>link</a>";
					if($level>4)
						{
						$id_type="rmr_form";
						$pass_id_rmr_form=$array['id_rmr_form'];
						$proj_id=$array['proj_id'];
						if(!empty($proj_id))
							{
							$value.="</td><td><form method='POST' action='project.php' onClick=\"confirm('Do you really want to delete this File?')\">
							<input type='hidden' name='type' value='$id_type'>
							<input type='hidden' name='pass_id_rmr_form' value='$pass_id_rmr_form'>
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