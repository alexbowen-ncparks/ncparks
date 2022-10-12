<?php

if($submit_form=="Balance")
	{
	$message= "The need for this tab - $submit_form - is uncertain.";
	}

$view_table="sql_".$var.".php";

//  echo "$view_table"; exit;

if(empty($message))
	{
	include($view_table);
	}

//echo "view_action <pre>"; print_r($ARRAY); echo "</pre>";  exit;

?>