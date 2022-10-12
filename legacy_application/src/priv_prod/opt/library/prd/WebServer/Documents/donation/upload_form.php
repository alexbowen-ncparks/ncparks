<?php

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

// *********** Display ***********
date_default_timezone_set('America/New_York');
//echo "<table>";

$passYear=date('Y'); // used to create file storage folder hierarchy

if(!isset($limit_park)){$limit_park="";}

$j=1;
if(!empty($donor_unique_id))
	{
	$sql="Select donor_unique_id, file_id, donor_id, link, title  From `donor_attachment` where 1 AND donor_id='$id' and donor_unique_id='$donor_unique_id' $limit_park";
	 //echo "$sql";
	$result = @mysqli_QUERY($connection,$sql);

	if($result)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);
				if($row['link']!="")
					{
					$link="$j: <a href='$link' target='_blank'>$title</a>";
					if($j==1){$da="Donation Attachment";}else{$da="";}
					echo "<tr><td>$da</td><td>$link</td>";
	if($level>0)
		{
		echo "<td><a href='delete_attachment.php?pass_id=$file_id&id=$id' onClick=\"return confirmFile()\">Delete</a></td>";
		}
	echo "</tr>";
					$j++;
					}
			}
		}
	}		
		$forms_array=array("Donation Attachment"=>"Word document or PDF","image_artwork"=>"Each separate original image file");
		
		$form_name=$forms_array['Donation Attachment'];
		echo "<tr>
		<td colspan='4'>Upload <font color='red'>Attachment</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='hidden' name='donor_id'  value='$id'>
		<input type='file' name='file_upload'  size='40'>
		</td>";		 
		echo "</tr>";
	
//echo "</table>";

?>