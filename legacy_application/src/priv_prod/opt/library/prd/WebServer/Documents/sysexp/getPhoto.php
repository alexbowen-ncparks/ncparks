<?phpextract($_REQUEST);// include("include/auth.inc");// getdata.php3 - by Florian Dittmer <dittmer@gmx.net>// Example php script to demonstrate the direct passing of binary data// to the user. More infos at http://www.phpbuilder.com// Syntax: getdata.php3?id=<id>if($pid) {include("../../include/authSYSEXP.inc");include("../../include/connectSYSEXP.inc");$sql = "select * from sysexp.photos where pid=$pid";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());    $data = @MYSQL_RESULT($result,0,"photo");    $type = @MYSQL_RESULT($result,0,"filetype");    Header( "Content-type: $type");    echo $data;};?> 