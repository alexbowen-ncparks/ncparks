<?php
// ini_set('display_errors',1);
// echo "list_separation_forms.php<pre>"; print_r($_REQUEST); echo "</pre>var=$pass_emp_id"; 
// exit;
	if(empty($pass_emp_id))
		{
		echo "<table><tr><td>Use <strong>Find Employee</strong> to select an employee for separation.</td></tr></table>"; exit;
		}
		else
		{
		
mysqli_select_db($connection, "divper");
		$sql = "SELECT Fname, Mname as M_initial, Lname, tempID  FROM empinfo where emid='$pass_emp_id'";
		$result = @mysqli_query($connection,$sql) or die();
		$row=mysqli_fetch_assoc($result);
		extract($row);
// 		echo "$pass_emp_id<pre>"; print_r($row); echo "</pre>"; // exit;
		$forms_array=array();
mysqli_select_db($connection, "hr_perm");
		$sql = "SELECT *  FROM separation_forms where employee_id='$pass_emp_id'";
		$result = mysqli_query($connection,$sql) or die();
		while($row=mysqli_fetch_assoc($result))
			{
			$forms_array[$row['form_number']]=$row;
			}
// 		echo "22<pre>"; print_r($forms_array); echo "</pre>"; // exit;
		}
		
// echo "26<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	$page_display="<form method='POST' action='upload_separation_forms.php' enctype='multipart/form-data'>
	<table cellpadding='5'>";
	echo "<tr><td><strong>$Fname $M_initial $Lname - $tempID</strong></td></tr>";
	foreach($ARRAY as $index=>$array)
			{
			if(!in_array($submit_form,$array)){continue;}
			extract($array);
			$display=$tab_content;
			if(!empty($tab_content_link))
				{$page_display.="<a href='$tab_content_link'>$tab_content</a>";}
			if($submit_form=="Separation Forms")
				{
				$display.="</td><td><input type='file' name='files[$id]'>";
				if(array_key_exists($id,$forms_array))
					{
					$efi=$forms_array[$id]['employee_forms_id'];
					$fl=$forms_array[$id]['form_link'];
					$fm=$forms_array[$id]['upload_form_name'];
					$display.="</td><td><a href='$fl' target='_blank'>$fm</a>";
					$display.="</td><td><a href='delete_separation_form.php?pass_emp_id=$pass_emp_id&efi=$efi' onclick=\"return confirm('Are you sure you want to delete this Document?')\"><img src='../button_drop.png'></a>";
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