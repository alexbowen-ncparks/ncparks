<?php

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

// *********** Display ***********

echo "<table border='1' align='center'>";

$passYear=date('Y'); // used to create file storage folder hierarchy

if(!empty($id))
	{
	$sql="Select *  From `uploads` where 1 AND id='$id'";
	$result = @mysqli_QUERY($connection,$sql);
	$j=1;
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);
				if($row['link']!="")
					{
					$link="$id  $j: <a href='$link' target='_blank'>$original_name</a>";
					echo "<tr><td>Attachment: $link</td><td>&nbsp;&nbsp;&nbsp;&nbsp;";

		echo "<a href='delete_ann_100_attachment.php?pass_id=$upid&id=$id' onclick=\"return confirm('Are you sure you want to delete this File?')\">Delete</a>";
	
	echo "</td></tr>";
					$j++;
					}
			}
		}
	}
	else
	{$j=1;}
		
		$forms_array=array("Ann_100"=>"Word, Excel, PDF or JPEG. ","image_artwork"=>"Each separate original image file");
		
		$form_name=$forms_array['Ann_100'];
		echo "<tr>
		<td colspan='4'>Upload <font color='red'>File</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='file' name='file_upload'  size='40'>
		</td>";		 
		echo "</tr>";
	
echo "</table>";

?>