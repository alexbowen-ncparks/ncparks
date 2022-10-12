<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

<head>
<title>Multiple file upload script from plus2net.com</title>
</head>

<body bgcolor="#ffffff" text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000">
<?
$max_no_file=1;  // Maximum number of files value to be set here
echo "<form method=post action=addPhoneTXT_file.php enctype='multipart/form-data'>";
echo "<table border='0' width='400' cellspacing='0' cellpadding='0' align=center>";
for($i=1; $i<=$max_no_file; $i++){
echo "<tr><td>Files $i</td><td>
	<input type='file' name='files[]' class='bginput'></td></tr>";
}
echo "<tr><td colspan=2 align=center><input type=submit value='Add File'></td></tr>"; 

echo "</form> </table>";



?>

</body>

</html>
