<?phpheader ("Pragma: no-cache"); header ("Cache-Control: no-cache, must-revalidate, max_age=0"); header ("Expires: 0"); $database="pac";include("../../include/iConnect.inc"); // database connection parametersmysqli_select_db($connection,$database);ini_set('display_errors',1);extract($_REQUEST);if (@$submit)	{		  $sql = "UPDATE chop_comment set chop='$chop' where id='1'";	//  echo "$sql";exit;	$result = mysqli_query($connection,$sql) or die("$sql Error 1#");		}  $sql = "SELECT * FROM chop_comment";//  echo "$sql";exit;$result = @mysqli_query($connection,$sql) or die("$sql Error 1#");$row=mysqli_fetch_array($result);extract($row);echo "<html><head><script language=\"JavaScript\">function confirmLink()	{	 bConfirm=confirm('Are you sure you want to delete this record?')	 return (bConfirm);	}</SCRIPT></head><form><table align='center'><tr>";echo "<td>Message which is automatically added to CHOP comments section of PAC calendar entry.<br /><textarea name='chop' rows='45' cols='100'>$chop</textarea></td></tr>";echo "<tr><td align='center'><input type='submit' name='submit' value='Update'>";echo "</td></tr><tr><td>Close this window when done.</td></tr></table></form>";echo "<table border='1' align='center' cellpadding='2'>";	$files=explode(",",$file_link);	foreach($files as $K=>$v)		{		if(empty($v))			{continue;}		echo "<tr><td>		<a href='$v'>$v</a>		&nbsp;&nbsp;&nbsp;<a href='dpr_pac_meet_del_file.php?source=CHOP&link=$v' onClick='return confirmLink()'>delete</a>		</td></tr>";				}echo "</table>";    $parkcode="CHOP";	echo "<table align='center'><tr><td valign='top' colspan='8' align='center'><b>CHOP FILE UPLOAD</b>    <form method='post' action='dpr_pac_meet_add_file.php' enctype='multipart/form-data'>   <INPUT TYPE='hidden' name='source' value='CHOP'>  <br>1. Click to select your file.     <input type='file' name='file_upload'  size='40'><br />    2. Then click this button.     <input type='hidden' name='parkcode' value='CHOP'>	<input type='submit' name='submit' value='Add File'>    </form></td></tr></table></html>"; //?>