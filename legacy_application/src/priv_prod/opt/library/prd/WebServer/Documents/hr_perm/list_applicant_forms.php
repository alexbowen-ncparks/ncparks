<?php

	if(empty($pass_emp_id))
		{
		echo "<table><tr><td>Use <strong>Find Applicant</strong> to select an applicant.</td></tr></table>"; exit;
		}
		else
		{
		$sql = "SELECT Fname, M_initial, Lname, tempID  FROM applicants where id='$pass_emp_id'";
		$result = @mysqli_query($connection,$sql) or die();
		$row=mysqli_fetch_assoc($result);
		extract($row);
		$forms_array=array();
		$sql = "SELECT *  FROM employee_forms where employee_id='$pass_emp_id'";
		$result = @mysqli_query($connection,$sql) or die();
		while($row=mysqli_fetch_assoc($result))
			{
			$forms_array[$row['form_number']]=$row;
			}
// 		echo "<pre>"; print_r($forms_array); echo "</pre>"; // exit;
		}
	$page_display="<form method='POST' action='upload_employee_forms.php' enctype='multipart/form-data'>
	<table cellpadding='5'>";
	echo "<tr><td><strong>$Fname $M_initial $Lname - $tempID</strong></td></tr>";
	foreach($ARRAY as $index=>$array)
			{
			if(!in_array($submit_form,$array)){continue;}
			extract($array);
			$display=$tab_content;
			if(!empty($tab_content_link))
				{$page_display.="<a href='$tab_content_link'>$tab_content</a>";}
			if($submit_form=="Upload Forms")
				{
				$display.="</td><td><input type='file' name='files[$id]'>";
				if(array_key_exists($id,$forms_array))
					{
					$efi=$forms_array[$id]['employee_forms_id'];
					$fl=$forms_array[$id]['form_link'];
					$fm=$forms_array[$id]['upload_form_name'];
					$display.="</td><td><a href='$fl' target='_blank'>$fm</a>";
					$display.="</td><td><a href='delete_emp_form.php?pass_emp_id=$pass_emp_id&efi=$efi' onclick=\"return confirm('Are you sure you want to delete this Document?')\"><img src='../button_drop.png'></a>";
					}
				}
			$page_display.="<tr><td>$display</td>";
			$page_display.="<td><input type='hidden' name='form_name[$id]' value=\"$tab_content\"></td></tr>";
			}
		$page_display.="<tr><td colspan='2' align='center'>
		<input type='hidden' name='pass_emp_id' value=\"$pass_emp_id\">
		<input type='hidden' name='tempID' value=\"$tempID\">
		<input type='submit' name='submit_form' value=\"Upload\">
		</td></tr>";
		$page_display.="</table>";

?>