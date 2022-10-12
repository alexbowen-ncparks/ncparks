<?php

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

// *********** Display ***********
date_default_timezone_set('America/New_York');
//echo "<table>";

$passYear=date('Y'); // used to create file storage folder hierarchy

if(!isset($limit_park)){$limit_park="";}
$sql="Select gis_id, file_id, link, title, housing_agreement  
From `housing_attachment` 
where 1 AND gis_id='$gis_id' $limit_park";
//  echo "$sql";
$result = @MYSQLI_QUERY($connection,$sql);
$j=1;

echo "<table border='1'>";
if($result)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
			if($row['link']!="")
				{
				$link="$j: <a href='$link' target='_blank'>$title</a>";
				if($j==1){$da="Facility Attachment";}else{$da="";}
				echo "<tr><td>$da</td><td align='left'>$link</td>";
				if(!empty($housing_agreement)){$ck="checked";}else{$ck="";}
				echo "<td>Check if this is a <font color='red'>Notarized Lease</font> <input type='checkbox' name='housing_agreement[$file_id]' value=\"x\" $ck onclick=\"this.form.submit()\"> 
				<input type='hidden' name='file_id[$file_id]' value='$file_id'></td>";
if($level>1 or ($park_abbr==$_SESSION['facilities']['select']))
	{
	echo "<td><a href='delete_attachment.php?pass_id=$file_id&gis_id=$gis_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a></td>";
	}
echo "</tr>";
				$j++;
				}
		}
	}
		
$forms_array=array("Housing Attachment"=>"Housing Agreement must be a <font color='red'>PDF</font><br />Inspection Report must be a <font color='red'>Word .doc</font>","image_artwork"=>"Each separate original image file");
		
		$form_name=$forms_array['Housing Attachment'];
		echo "<tr>
		<td colspan='5'>Upload <font color='red'>Attachment</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='file' name='file_upload'  size='40'>
		</td>";
$to="jerry.howerton@ncparks.gov";
$to.=";Denr.dpr-hr-staff@lists.ncmail.net";
$to.=";denise.williams@ncparks.gov";
// $to.=";cara.hadfield@ncparks.gov";
//$to.=";maria.cucurullo@ncparks.gov";
$subject="Housing Change for $gis_id";
$body="";
$email="<a href=\"mailto:$to?Subject=$subject\">Email Interested Parties</a>";	
echo "<td>$email</td>";

		echo "</tr>";
	
//echo "</table>";

?>