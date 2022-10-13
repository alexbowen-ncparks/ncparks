<?php
// Read the database hostname and port from env vars.
$host = getenv("DB_HOST");
$port = getenv("DB_PORT");

// Read db secrets.
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");

if (!empty($db)) {
  $database = $db;
}

//echo "host=$host | port=$port | user=$user | password=$password | database=$database"; exit;
$connection = mysqli_connect($host,$user,$password,$database,$port);
/* check connection */
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
// include("/opt/Library/WebServer/Documents/no_inject_i.php");
include("/opt/library/prd/WebServer/Documents/no_inject_i.php");
