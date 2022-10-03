<?php
include("../../../include/connectROOT.inc");
include("../../no_inject.php");
include("../../../include/get_parkcodes.php");
mysql_select_db("photos",$connection);

$session_database="photos";
$database=$session_database;
session_start();
@$level=$_SESSION['photos']['level'];

echo "<html>";
	extract($_REQUEST);
if($level>2)
	{
$title="The ID";
include("/opt/library/prd/WebServer/Documents/_base_top.php");
	
	if(@$del=="y")
		{
		$sql = "DELETE from `publish_hi-res` where id='$id'";
		//echo "$sql";exit;
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		}
	
	if(@$submit=="Enter_PIDs")
		{	
		$sql = "Insert into `publish_hi-res` set pid='$pid', email='$email'";
		//echo "$sql";exit;
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		}
	
	//echo "<br>Old: <pre>";print_r($photoArray);echo "</pre>";
	echo "<form action='hi-rez.php'>
	email <input type='text' name='email' value='' size='45'>
	<input type='text' name='pid' value='' size='55'>
	<input type='submit' name='submit' value='Enter_PIDs'>Separate by comma</form>";
//	echo "http://www.dpr.ncparks.gov/photos/a/hi-rez.php";
	}

else
{
echo "<body bgcolor='beige'><table align='center'><tr><td><a href='http://ncparks.gov' target='_blank'><img src=\"/inc/css/images/dpr_1.jpg\"></a></td></tr></table>";
}

$sql = "select id,email,pid,retrievals from `publish_hi-res` order by id desc";
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
while ($row=mysql_fetch_assoc($result))
	{
	extract($row);
	$emailArray[]=$email;
	$pa=explode(",",$pid);
	foreach($pa as $k=>$v)
		{
		$v=trim($v);
		$photoArray[$v]=$email;
		$idArray[$v]=$id;
			if($level>3){$retr[$v]=$retrievals;}
		}
	}
//echo "<pre>";print_r($photoArray);echo "</pre>"; //exit;


echo "<div><table align='center'><tr><td colspan='3' align='center'>Please credit the use of any photo to:<br>
<b>NC State Parks photo by:</b> (photographer)</td></tr>";

if(!isset($photoArray)){exit;}

foreach($photoArray as $pid=>$email)
	{
		$sql = "select park,photog,height,width,sciName,photoname from `images` where pid='$pid'";
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
//		echo "$level $sql<br />";
		$row=mysql_fetch_array($result);
		extract($row);
		
		$link="<img src=\"http://www.dpr.ncparks.gov/photos/getPhoto.php?pid=$pid\">";
		
		if($level>3)
			{
			$pid_list="";$count_pid=0;
			foreach($photoArray as $k1=>$var1)
				{
				if($var1==$email)
					{
					$pid_list.=$k1.",";
					$count_pid++;
					}
				}
			$pid_list=rtrim($pid_list,",");
			if($count_pid>1)
				{
				$ph="photos";
				$ver="high-res versions";
				}
				else
				{
				$ph="photo";
				$ver="a high-res version";
				}
		$reply_text="You will be able to obtain $ver of the listed $ph by going to this link:%0d%0dhttp://www.dpr.ncparks.gov/photos/a/hi-rez.php%0d%0dEnter your email address in the field next to the photo and click the &quot;Get This Photo&quot; button. The photo will now download to your computer.%0d%0dInfo on how to credit the use of the $ph is at the top of that page. Get back in touch if you have any questions.%0d%0dTom%0dNC State Parks System";
			$delThis="<a href=\"http://www.dpr.ncparks.gov/photos/a/hi-rez.php?del=y&id=$idArray[$pid]\">del</a> all $email";
			$mail_this=" <a href=\"mailto:$email?subject=Request for high resolution $ph from The ID&body=Hi nnn,%0d%0d The ID $ph: $pid_list%0d%0d$reply_text\">email</a>";
			}
		
		$pc=$parkCodeName[$park];
		if(isset($retr[$pid])){$retrieve=$retr[$pid];}else{$retrieve="";}
		echo "<tr><td>$retrieve<br>If you have been granted access to photo # $pid<br>enter your email address <form action='get-hi.php' method=\"post\" ONSUBMIT=\"openTarget(this, 'width=300,height=300,resizable=1,scrollbars=1'); return true;\" target=\"winone\" name=\"frmPoll\"> <input type='text' name='email' value='' size='30'>
		<br>to <input type='hidden' name='pid' value='$pid'>
		<input type='submit' name='submit' value='Get This Photo'></form></td>
		<td>";
		$source="admin";
		include('../getPhoto.php');
		if(!isset($mail_this)){$mail_this="";}
		if(!isset($delThis)){$delThis="";}
		echo "</td>
		<td>$photoname<br />$pc <b><i>$sciName</i></b><br />($width x $height pixels) from photographer: <b>$photog</b><br />$delThis $mail_this</td></tr>";
	}

if($level>2)
	{
	if(!isset($reply_text)){$reply_text="";}
	echo "<tr><td colspan='4'>$reply_text</td></tr>";
	}
?>
</table></div></body>
</html>