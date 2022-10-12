<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_note_id=$_POST['project_note_id'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];

echo "<html>";

echo "<form method=post action=document_delete.php>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";

echo "<font color='red' size='3'><b>CAUTION! Are you sure you want to delete Document for record $project_note_id ?</b></font>";
echo "<br /><br />";	   
echo "<input type='submit' name='submit' value='YES-DELETE Document for Record $project_note_id'>";
echo "</form>";
//echo "<br />";

echo "<form method=post action=search_notes.php>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
	   
echo "<input type='submit' name='submit' value='NO-Return to Note Search'>";

echo "</form>";
echo "</html>";
?>