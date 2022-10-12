<?php

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

// *********** Display ***********
date_default_timezone_set('America/New_York');
//echo "<table>";

$passYear=date('Y'); // used to create file storage folder hierarchy
$j=1;
if(!empty($id))
	{
	$sql="Select id, family_id_file, tempID, file_link , file_name 
	From `family_upload_file` 
	where 1 AND family_id_file='$id'";
//	 echo "$sql";
	$result = @MYSQLI_QUERY($connection,$sql);

	if($result)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);
				if($file_link!="")
					{
					$link="$j: <a href='$file_link' target='_blank'>$file_name</a>";

					if($j==1)
						{$da="File";}
						else
						{$da="";}
			echo "<tr><td>$da</td><td align='left'>$link</td>";
		
			if($level>4 OR $tempID==$_SESSION['war']['tempID'])
				{
				echo "<td><a href='delete_attachment.php?pass_record_id=$pass_record_id&pass_file_id=$id' onClick=\"return confirmLink()\">Delete</a> File</td>";
				}
			echo "</tr>";
					$j++;
					}
			}
		}
	}
		
		$form_name="File";
		echo "<tr>
		<td colspan='4'>Upload <font color='red'>Attachment</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='file' name='file_upload_file'  size='40'>
		</td>";		 
		echo "</tr>";
	
//echo "</table>";

?>