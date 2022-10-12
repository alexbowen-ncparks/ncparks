<?php

//db connection
//$db="invasive_species";
//require('../../include/iConnect.inc');


// Get the document root
//$doc_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT', FILTER_SANITIZE_STRING);

// Get the application path
//$uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
//$dirs = explode('/', $uri);
//echo "<pre>"; print_r($dirs); echo "</pre>";  exit; 
//$app_path =  $dirs[1] . '/';




//Get Common Code
//require('utilities/tags.php');



//Define some common functions
function display_error($error_message)
{
	//global $app_path;
	include 'errors/error.php';
	exit;
}

function redirect($url)
{
	session_write_close();
	header("Location: " . $url);
	exit;
}


echo "Hello! from main <br/>";
//echo get_include_path();
echo "<br/>";

?>