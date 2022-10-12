<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

<head>
<title>Multiple file upload script from plus2net.com</title>
</head>

<body bgcolor="#ffffff" text="#000000" link="#0000ff" vlink="#800080" alink="#ff0000">
<?
//echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
$year=date(Y);
$folder="/Library/WebServer/Documents/divper/parse_phone/".$year;

//$file=$folder."apr09.txt";
//unlink($file);
exit;



if (!file_exists($folder)) {mkdir ($folder, 0777);}
//exit;
while(list($key,$value) = each($_FILES['files']['name']))
		{
			if(!empty($value))
			{
				$filename = $value;
					$add = $folder.$filename;
                       //echo $_FILES[images][type][$key];
			     // echo "<br>";
					copy($_FILES['files']['tmp_name'][$key], $add);
					chmod("$add",0777);
			

			}
		}

$database="phone_bill";
include("../../../include/connectROOT.inc"); //echo "c=$connection";
  $sql = "REPLACE phone_bill set bill_txt='$filename'";
//  echo "$sql";exit;
$result = @mysql_query($sql, $connection) or die("c=$connection $sql Error 1#". mysql_errno() . ": " . mysql_error());

echo "$filename was successfully uploaded<br /><br />
<a href='/divper/parse_phone/phone_parse.php'>Return</a>";
?>

</body>

</html>
