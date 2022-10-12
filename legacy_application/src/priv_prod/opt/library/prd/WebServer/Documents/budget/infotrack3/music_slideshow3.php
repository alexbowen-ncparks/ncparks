<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}




extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 


//include("../../budget/menu1314.php");




$query4="select gid,game_name,overview,author,status,embed_address
         from music
		 where 1
		 and status='show'
		 and (scope='all' or scope='$concession_location')
         order by music.game_name asc ";
		 
		 
//echo "query4=$query4<br />";  exit;		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


while ($row4=mysqli_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$MySlides[]=$row4['game_name'];
	$Embed_address2[]=$row4['embed_address'];
	$Gid[]=$row4['gid'];
	//$MyComments[]=$row4['comments2'];
	//$label[]=$row4['label'];
	//$id[]=$row4['id'];
	}	
//echo "<pre>"; print_r($MySlides); echo "</pre>";  //exit;
//echo "<pre>"; print_r($MyComments); echo "</pre>";  //exit;


echo "<html>";
?>


<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title>Create a Session</title>

<script type="text/javascript">

var randomStrings = <?php echo json_encode($Embed_address2) ?>;
//var randomStrings = <?php json_encode($column) ?>;


function RndMsg() {

  var msg = randomStrings[Math.floor(Math.random()*randomStrings.length)];

  document.getElementById('randomDiv').innerHTML = msg;

}

</script>

</head>


<body>

<form action="" method="post" onsubmit="return false">

<input type="button" value="Get Session ID" name="sessionid" onclick="RndMsg()"/>

<div id="randomDiv">Random text</div>

</form>

</body>

</html>




