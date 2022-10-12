<?php
// echo "<pre>"; print_r($_POST);  echo "</pre>"; // exit;

if(!empty($_POST))
	{
	$database="inspect";
	session_start();
	$level=$_SESSION[$database]['level'];

	if($level==""){echo "You do not have authorization for this database."; exit;} // used to authenticate users
	include("../../include/iConnect.inc"); // database connection parameters
	mysqli_select_db($connection,$database);

	$TABLE =$add_external;

	$i=0;
	foreach($_POST['url'] as $i=>$value)
		{

		$title=$_POST['title'][$i];
		$url=$_POST['url'][$i];
		if(empty($url)){continue;}
		$comments=$_POST['comments'][$i];

		$title=htmlspecialchars_decode($title);
		$sql="INSERT into $TABLE SET record_type='$TABLE', title='$title', url='$url', comments='$comments'"; 
		echo "$sql<br />"; 
	// 	exit;
		$result = @mysqli_query($connection,$sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$id= mysqli_insert_id($connection);
			
		}
	}

if(!empty($id))
	{
	header("Location: home.php");
	exit;
	}
	
	
include("pm_menu_new.php");
echo "<style>
td {padding: 5px;}
</style>";

echo "
Upload Links to External EMS Resources

<form method='post' action='add_file_external.php' enctype='multipart/form-data'>
<table style='margin-right:auto; margin-left:auto; padding: 50px;'>
<tr><td>Submission Type: <input type='text' name='add_external' value=\"$add_external\" size='15' readonly></td></tr>
<tr><td>Title of Website 1: <input type='text' name='title[]' value=\"\" size='33'></td></tr>
<tr><td>URL of Website 1: <input type='text' name='url[]' value=\"\" size='33'></td></tr>
<tr><td>Comments on Website 1:<br /><textarea name='comments[]' cols='55' rows='2'></textarea></td></tr>

<tr><td><h2>&nbsp;</h2></td></tr>

<tr><td>Title of Website 2: <input type='text' name='title[]' value=\"\" size='33'></td></tr>
<tr><td>URL of Website 2: <input type='text' name='url[]' value=\"\" size='33'></td></tr>
<tr><td>Comments on Website 2: <br /><textarea name='comments[]' cols='55' rows='2'></textarea></td></tr>

<tr><td><h2>&nbsp;</h2></td></tr>

<tr><td>Title of Website 3: <input type='text' name='title[]' value=\"\" size='33'></td></tr>
<tr><td>URL of Website 3: <input type='text' name='url[]' value=\"\" size='33'></td></tr>
<tr><td>Comments on Website 3:<br /><textarea name='comments[]' cols='55' rows='2'></textarea></td></tr>

<tr><td><input type='submit' name='submit_form' value=\"Add\"></td></tr>
</table>
</form>
</td></tr></table>";

?>