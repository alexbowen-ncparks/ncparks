<?php
echo "<div align='center'><table bgcolor='#ABC578' cellpadding='5'>";

$level=@$_SESSION['training']['level'];  // echo "l=$level";

echo "<tr><td><a href='track.php'>Search Training</a></td></tr>";

echo "<tr><td><a href='update.php'>Update Training</a></td></tr>";

	
if($level>2) // 0
	{
	$append=array("view_class.php"=>"View Courses");
	
	if($level>3)
		{
		$append['add_class.php']="Add Course";
		$append['edit_class.php']="Edit Course";
		}
	
	if($level>4)
		{
		$append['migrate_training.php']="Migrate Fire db";
		$append['migrate_course.php']="Migrate Course";
		}	
		
	echo "<form><td align='center' bgcolor='#ABC578'><select name='admin' onChange=\"MM_jumpMenu('parent',this,0)\">";
	echo "<option selected>Admin Functions</option>";
	foreach($append as $k=>$v)
		{
		echo "<option value=\"$k\">$v</option>\n";
		}
	
	echo "</select></td></form></tr>";
	
	}

echo "</table></div>";
?>