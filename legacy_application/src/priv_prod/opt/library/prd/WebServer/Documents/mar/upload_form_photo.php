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
	$sql="Select id, family_id_photo, tempID, photo_link , photo_name 
	From `family_upload_photo` 
	where 1 AND family_id_photo='$id'";
	// echo "$sql";
	$result = @MYSQLI_QUERY($connection,$sql);

	if($result)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);
			$photo="";
				if($photo_link!="")
					{
					$exp=explode("/",$photo_link);
					$ext=explode(".",array_pop($exp));
					if($ext[1]=="jpg" OR $ext[1]=="jpeg" OR $ext[1]=="JPG")
						{
						$var_p="ztn.".$ext[0].".".$ext[1];
						$img=implode("/",$exp)."/".$var_p;
						$photo="<a href='$photo_link'><img src='$img'></a>";
						$link="";
						}
				
					if($j==1)
						{$da="Photo";}
						else
						{$da="";}
			echo "<tr><td>$da</td><td align='left'>$photo</td>";
	
				if($level>4 OR $tempID==$_SESSION['war']['tempID'])
					{
				echo "<td><a href='delete_attachment.php?pass_record_id=$pass_record_id&pass_photo_id=$id' onClick=\"return confirmLink()\">Delete</a></td>";
				}
			echo "</tr>";
					$j++;
					}
			}
		}
	}
		
		$form_name="Photo";
		echo "<tr>
		<td colspan='4'>Upload <font color='red'>Photo</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='file' name='file_upload_photo'  size='40'>
		</td>";		 
		echo "</tr>";
	
//echo "</table>";

?>