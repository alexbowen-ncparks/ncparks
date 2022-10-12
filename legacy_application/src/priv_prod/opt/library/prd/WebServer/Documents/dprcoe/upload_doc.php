<?php

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

// *********** Display ***********

echo "<table border='1'>";

if(!empty($eid))
	{
	$sql="Select *  From `file_upload` where 1 AND eid='$eid'";
	$result = @MYSQL_QUERY($sql,$connection);
	$j=1;
	if(mysql_num_rows($result)>0)
		{
		while($row=mysql_fetch_assoc($result))
			{
			extract($row);
				if($row['link']!="")
					{
					$link="$j: <a href='$link' target='_blank'>$file_name</a>";
					echo "<tr><td>Attachment: $link</td><td>&nbsp;&nbsp;&nbsp;&nbsp;";

		echo "<a href='delete_ann_100_attachment.php?pass_fid=$fid' onclick=\"return confirm('Are you sure you want to delete this File?')\">Delete</a>";
	
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
	if(empty($fid))
		{
		echo "<tr>
		<td colspan='4'>Upload any file, photo, flyer, etc. associated with event - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='file' name='file_upload'  size='40'>
		</td>";		 
		echo "</tr>";
		}
	
echo "</table>";

?>