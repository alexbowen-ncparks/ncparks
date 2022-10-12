<?php
//extract($_REQUEST);
if(!isset($pid)){extract($_REQUEST);}


if(!empty($_POST['delete']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	ini_set('display_errors',1);
	extract($_POST);
	$database="facilities";
	if(!isset($connection))
		{
		include("/opt/library/prd/WebServer/include/connectROOT.inc");
		}
	if(!is_numeric($pid)){exit;}
	//$pid=mysql_real_escape_string($pid);
	mysql_select_db($database,$connection);
//	$sql="UPDATE facilities.housing set photo_1='' WHERE photo_1='$pid'";
//		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
//	$sql="UPDATE facilities.housing set photo_2='' WHERE photo_2='$pid'";
//		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$sql="DELETE FROM facilities.fac_photos WHERE pid='$pid'";
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	mysql_select_db('photos',$connection);
	
	$sql = "UPDATE photos.images SET mark='x' WHERE pid='$pid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	if(!empty($gis_id))
		{
	echo "Photo has been deleted. <a href='/facilities/edit_fac.php?gis_id=$gis_id'>Return</a>";
		exit;
		}
	}
	
if($pid)
	{
//	ini_set('display_errors',1);
	$database="photos";
	if(!isset($connection))
		{
		include("/opt/library/prd/WebServer/include/connectROOT.inc");
		}
	mysql_select_db($database,$connection);
	if(!is_numeric($pid)){exit;}
//	$pid=mysql_real_escape_string($pid);
	$sql="SELECT park, photoname, link, comment FROM images WHERE pid=$pid and mark=''"; //echo "$sql";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());

		$row=mysql_fetch_assoc($result);
		if(mysql_num_rows($result)>0)
			{
			extract($row); 
			$var=explode("/",$link);
			$file=array_pop($var);
			$a="/640.".$file;
			$var1=implode("/",$var);
			$link=$var1.$a;
			$link="/photos/".$link;

			if(!isset($park)){$park="";}
			if(!isset($source)){$source="";}

			echo "$park Housing<br />$photoname<br />$comment<br />
			
			<img src='$link'>";
			echo "<form method='POST' onclick=\"javascript:return confirm('Are you sure you want to delete this photo?')\"><table>
			<tr>
			<td><input type='hidden' name='$pid' value='$pid'></td>";
			if($source!="budget")
				{echo "<td><input type='submit' name='delete' value='Delete'></td>";}
			
			echo "<td width='35%'>&nbsp;</td>
			<td>Close window when done viewing.</td>
			</tr>
			</table></form>";
			}
		else
			{
			echo "That photo no longer exits. You can close this window.";
			}
	}
?> 