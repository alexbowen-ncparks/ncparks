<?php
//echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	

if(@$row['other_file_2']!="")
	{
	if($level>3)
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_2']."' target='_blank'>File A</a>
	(pdf or word doc e-memorandum) ";
	
$item.="<a href='edit_award_given.php?del=y&id=$row[id]&fld=other_file_2' onClick='return confirmLink()'><font size='-2'>Delete</font></a>";}
	$item.="<br /><br />";
	}
	else
	{
	if($level>3)
		{
		$item.= "<br /><font color='brown'>Upload File A (pdf or word doc)</font>
			<input type='file' name='file_upload[other_file_2]' size='10'>";
		}
	}	
	
if(@$row['other_file_3']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_3']."' target='_blank'>Other File B</a>
	(pdf or word doc e-memorandum) <a href='edit_award_given.php?del=y&id=$row[id]&fld=other_file_3' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	if($level>3)
		{
	$item.= "<br /><font color='brown'>Upload Other File B (pdf or word doc)</font>
			<input type='file' name='file_upload[other_file_3]' size='10'>";
		}
	}	
	
if(@$row['other_file_4']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_4']."' target='_blank'>Other File C</a>
	(pdf or word doc) <a href='edit_award_given.php?del=y&id=$row[id]&fld=other_file_4' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	if($level>3)
		{
	$item.= "<br /><font color='brown'>Upload Other File C (pdf or word doc) </font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_4]' size='10'>";
		}
	}	
		
if(@$row['other_file_1']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_1']."' target='_blank'>Photo </a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit_award_given.php?del=y&id=$row[id]&fld=other_file_1' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	if($level>3)
		{
	$item.= "<br /><font color='brown'>Upload Photo (if you wish)</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_1]' size='10'>";
		}
	}	
	
?>