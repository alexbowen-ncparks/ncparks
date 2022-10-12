<?php

session_start();

$project_note_id=$_POST['project_note_id'];

echo "<html>";
echo "<head> <title>document_add</title></head>";
echo "<body>";
echo "<h1>ADD Document</h1>";
echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='2000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";
echo "</html>";

?>