<?php
ini_set('display_errors', 1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

include("_base_top.php");

echo "<h2>Welcome! What can we do for you?</h2>
 
<p>This database is a new way for the Exhibits Program to track and manage work orders. We hope that your visit here will be pleasant and painless. You can now submit, track and view your work order history all in one place.</p>
 
<p>Please help us in our mission to keep the visiting public informed and inspired!</p>
 
<p>Having a question about the Exhibit Request process? Send an email to <a href='mailto:sean.higgins@ncparks.gov'>sean.higgins@ncparks.gov</a>.</p>
 
<p>Having an issue with the database? Send an email to <a href='mailto:database.support@ncparks.gov'>database.support@ncparks.gov</a>.</p>
";

?>