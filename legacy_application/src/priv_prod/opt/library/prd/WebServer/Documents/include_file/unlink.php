<?php
$uploaddir = '/opt/library/prd/WebServer/Documents/';
$uploadfile = "photos/2011/04/123_test.jpg";
unlink($uploadfile);
echo "$uploadfile";

$uploadfile = "photos/2011/04/640.123_test.jpg";
unlink($uploadfile);
echo "$uploadfile";

$uploadfile = "photos/2011/04/ztn.123_test.jpg";
unlink($uploadfile);
echo "$uploadfile";
?>