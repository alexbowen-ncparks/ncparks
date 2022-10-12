<?php

include("menu.php");

echo "<table>
<tr><td><form action='/cite/users.php'>
<tr><td><form action='/cite/users.php'>
    CITE Database&raquo;
<input type='submit' name='submit' value='Go'>
</form></td></tr>
<tr><td><form action='/le/pr63_users.php'>
<tr><td><form action='/le/pr63_users.php'>
    PR-63 Database&raquo;
<input type='submit' name='submit' value='Go'>
</form></td></tr>
</table>";

$database="le";
include("../../include/iConnect.inc"); // database connection parameters

// Get latest update to background investigation
mysqli_select_db($connection,"find")
       or die ("Couldn't select database FIND");
$sql="SELECT timeMod from forum where topic like '%BACKGROUND INVESTIGATION PACKET%'";
$result = mysqli_query($connection,$sql);
$row=mysqli_fetch_assoc($result);




?>