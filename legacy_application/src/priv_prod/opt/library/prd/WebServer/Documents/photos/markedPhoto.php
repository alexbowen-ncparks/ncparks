<?php 
$session_database="photos";
$database=$session_database;
$title="The ID";
include("/opt/library/prd/WebServer/Documents/_base_top.php");// includes session_start()

extract($_REQUEST);

$level=$_SESSION['photos']['level'];


include("../../include/connectROOT.inc");

/*
$db = mysql_select_db("dpr_system",$connection) or die ("Couldn't select database $database");

$sql = "SELECT park_code,park_name FROM parkcode_names WHERE 1";
	$total_result = @mysql_query($sql, $connection) or die("$sql Error 3#". mysql_errno() . ": " . mysql_error());	
	while ($row = mysql_fetch_array($total_result))
	  {
	  $parkCodeName[$row['park_code']]=$row['park_name'];
	  }
*/

$db = mysql_select_db("photos",$connection)       or die ("Couldn't select database $database");


$sql = "SELECT park,pid,sciName,photog,link
FROM images
where mark = 'x'";

$total_result = @mysql_query($sql, $connection) or die("$sql ". mysql_errno() . ": " . mysql_error());
$test = mysql_num_rows($total_result);


echo "<h3>Photos Marked for Deletion in The ID</h3>
<table width='100%' border='1'>";
if($test<1){echo "No photo is marked for deletion.";}

echo "<tr><th>Photo Link</th><th>Park</th><th>sciName</th><th>Photog</th><th>Thumbnail</th></tr>";
while ($row = mysql_fetch_array($total_result))
	{
	 extract($row);
	$la=explode("/",$link);
//	print_r($la);exit;
$domain="https://auth.dpr.ncparks.gov/photos";
	foreach($la as $v=>$k)
		{
		if(strpos($k,".jpg")>0){$k="ztn.".$k;}
		$domain.="/".$k;
		}
		
	 $del_link="<a href='getData.php?pid=$pid&del=y' target='_blank'>";
	 
	echo "<tr><td>View Photo before deleting: $del_link$pid</a></td><td> at $park</td><td><i>$sciName</i></td><td> $photog</td><td align='center'><img src='$domain'></td></tr>";
	}

?>
</table></div>
</body>
</html>