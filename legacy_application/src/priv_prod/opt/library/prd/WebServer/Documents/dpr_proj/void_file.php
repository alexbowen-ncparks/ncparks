<?php
echo "hello<pre>"; print_r($_POST); echo "</pre>";  exit;
$id=$_POST['id'];
$sql="Update project set proj_status='void' where 1 and id='$id'"; // echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));

?>