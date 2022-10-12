<?php

session_start();

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;


echo "<html>";
echo "<head> <title>document_add</title></head>";
echo "<body>";
echo "<h1>ADD Document</h1>";
echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='2000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='cid' value='$cid'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>
	   <input type='hidden' name='tabname' value='project_steps'>";

echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";
echo "</html>";



?>