<?php

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

// *********** Display ***********

echo "<table>";

$passYear=date('Y'); // used to create file storage folder hierarchy

$sql="Select ci_num, id as file_id, link, title  From `attachment_pio` where 1 AND ci_num='$ci_num' $limit_park";
// echo "$sql";
$result = @mysqli_QUERY($connection,$sql);
$j=1;
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
			if($row['link']!="")
				{
				$link="$ci_num  $j: <a href='$link'>$title</a>";
				echo "<tr><td>Attachment: $link</td><td>&nbsp;&nbsp;&nbsp;&nbsp;";
if(($level==1 and empty($pasu_approve)) OR $level>1)
	{
	echo "<a href='delete_attachment_pio.php?pass_id=$file_id&id=$id' onClick=\"return confirmFile()\">Delete</a>";
	}
echo "</td></tr>";
				$j++;
				}
		}
	}
		
		$forms_array=array("PR-63_attachment"=>"Word document or PDF with your text for the incident. ","image_artwork"=>"Each separate original image file");
		
		$form_name=$forms_array['PR-63_attachment'];
		echo "<tr>
		<td colspan='4'>Upload <font color='red'>Attachment</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='file' name='file_upload'  size='40'>
		</td>";		 
		echo "</tr>";
	
echo "</table>";

?>