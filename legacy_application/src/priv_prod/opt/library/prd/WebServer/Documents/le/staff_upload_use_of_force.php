<?php

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

// *********** Display ***********

$passYear=date('Y'); // used to create file storage folder hierarchy

$sql="Select ci_num, id as file_id, link, title  From `attachment_uof` where 1 AND ci_num='$ci_num' $limit_park";
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
				$v4.= "Attachment: $link &nbsp;&nbsp;&nbsp;&nbsp;";
				if(($level==1 and empty($pasu_approve)) OR $level>1)
					{
					$v4.= "<a href='delete_attachment_uof.php?pass_id=$file_id&id=$id' onClick=\"return confirmFile()\">Delete</a><br />";
					}
				$j++;
				}
		}
	}
		
		$forms_array=array("USOF"=>"Use of Force Form");
		
		$form_name=$forms_array['USOF'];
		$v4.= "
Upload - <font color='red'>$form_name</font>
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='file' name='file_upload_uof'  size='40'>
		";		 
	

?>