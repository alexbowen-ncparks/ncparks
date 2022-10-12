<html><head><title>Faces & Places</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="beige"><div align="center">
<?php
include("header.php"); 
include("footer.php");
if(empty($_SESSION)){session_start();}
if($_SESSION['irecall']['level']<1){exit;}
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

$database="irecall";
include_once("../../include/connectROOT.inc");
mysql_select_db($database,$connection);
extract($_REQUEST);
echo "<table width='660'>";
$type="former_emp"; returnNum($type);
$type="tradition"; returnNum($type);
echo "<tr><th>Traditions: $numrow $view";
$type="person"; returnNum($type);
echo "<th>Special People: $numrow $view";
$type="change1"; returnNum($type);
echo "<th>Changes: $numrow $view";
$type="photos"; returnNum($type);
echo "<th>Photos: $numrow $view";
$type="sound"; returnNum($type);
echo "<th>Audio/Video: $numrow $view</tr>";
echo "</table>";

echo "<div align='center'><table>";
// *********** Search Form ***************
/*
echo "<form action='search.php'><tr>
<td><input type='text' name='search' size='15'>
<input type='submit' name='submit' value='Search'></form></td></tr></table>
<form></td></tr></table></div>";
*/
//print_r($_SESSION);
if(@$var)
	{
	$valueArray=array_values($_REQUEST);
	$keyArray=array_keys($_REQUEST);
	$where="where $keyArray[1]=$valueArray[1]";
	$sql="SELECT * FROM irecall.$var $where";
//	echo "$sql";//exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	echo "<hr><table>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	
	if($var=="former_emp")
		{
		if($_SESSION['irecall']['level']>3)
			{
			$edit="<br><a href='former_add.php?sub=Add&formerid=$formerid' target='_blank'>Edit</a>";
			$add_person="<br><a href='former_add.php?sub=Add'>Add</a>";
			}
		echo "<tr><td><b>$first_name $last_name</b></td></tr><tr><td>$add1</td></tr><tr><td>$city, $state  $zip</td></tr><tr><td>$phone</td><td>$email</td></tr><tr><td>$last_pos</td></tr>";

if(!isset($edit)){$edit="";}
if(!isset($add_person)){$add_person="";}
		echo "<tr><td>$edit</td><td>$add_person</td></tr>";
		
		echo "</table>";
		}
	
	if($var=="tradition"){
	$tradtext=nl2br($tradtext);
	if($_SESSION['irecall']['level']>3)
		{
		$edit="<br><a href='honor_add.php?traditionid=$traditionid'>Edit</a>";
		}
	echo "<tr><td><b>$title</b></td></tr><tr><td>Submitted by: $authorname</td></tr><tr><td>$tradtext</td><td></tr><tr><td>";
	if($comment){echo "Submitter's Comment: $comment";}
	echo "$edit</td></tr><tr><td><a href='addComment.php?var=$var&$keyArray[1]=$valueArray[1]&title=$title'>Add Your Comment</a>";
	$sql1="SELECT * FROM irecall.comment where type='$var' and typeid='$traditionid' and mark=''";
	//echo "$sql";exit;
	$result1 = @mysql_query($sql1, $connection) or die("$sql1 Error 2#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result1);
	if($num>0){
	echo "<hr><table><tr><td colspan='2'>Other people's comment:</td></tr>";
	while($row1 = mysql_fetch_array($result1)){
	extract($row1);
	if($_SESSION['irecall']['level'])
		{
		$editComment="<td><a href='addComment.php?commentid=$commentid'>Edit</a>
		</td>";
		}
	echo "<tr><td><b>$authorname</b></td>$editComment<td>$comment</td></tr>";}
	}
	echo "</table>";
	}
	
	if($var=="person")
		{
		$persontext=nl2br($persontext);
		if($_SESSION['irecall']['level']>3)
			{
			$edit="<a href='person_add.php?personid=$personid'>Edit</a>";
			}
		echo "<tr><td><b>$personname</b></td></tr><tr><td>Submitted by: $authorname</td></tr><tr><td>$persontext</td><td></tr><tr><td>";
		$personname=urlencode($personname);
		if($comment)
			{
			echo "Submitter's Comment: $comment";
			}
		echo "$edit</td></tr><tr><td><a href='addComment.php?var=$var&$keyArray[1]=$valueArray[1]&title=$personname'>Add Your Comment</a>";
		$sql1="SELECT * FROM irecall.comment where type='$var' and typeid='$personid'";
		//echo "$sql";exit;
		$result1 = @mysql_query($sql1, $connection) or die("$sql1 Error 2#". mysql_errno() . ": " . mysql_error());
		$num=mysql_num_rows($result1);
		if($num>0)
			{
			echo "<hr><table><tr><td>Other people's comment:</td></tr>";
			while($row1 = mysql_fetch_array($result1))
				{
				extract($row1);if($_SESSION['irecall']['level']>3)
					{
					$editComment="<td><a href='addComment.php?commentid=$commentid'>Edit</a>
					</td>";
					}
				echo "<tr><td><b>$authorname</b></td>$editComment<td>$comment</td></tr>";}
			}
		echo "</table>";
		}
	
	if(@$var=="change1")
		{
		$changetext=nl2br($changetext);
		if($_SESSION['irecall']['level']>3)
			{
			$edit="<a href='change_add.php?change1id=$change1id'>Edit</a>";
			}
		echo "<tr><td><b>$changename</b></td></tr><tr><td>Submitted by: $authorname</td></tr><tr><td>$changetext</td><td></tr><tr><td>";
		$changename=urlencode($changename);
		if($comment)
			{echo "Submitter's Comment: $comment";}
		echo "$edit</td></tr><tr><td><a href='addComment.php?var=$var&$keyArray[1]=$valueArray[1]&title=$changename'>Add Your Comment</a>";
		$sql1="SELECT * FROM irecall.comment where type='$var' and typeid='$change1id'";
		//echo "$sql";exit;
		$result1 = @mysql_query($sql1, $connection) or die("$sql1 Error 2#". mysql_errno() . ": " . mysql_error());
		$num=mysql_num_rows($result1);
		if($num>0)
			{
			echo "<hr><table><tr><td>Other people's comment:</td></tr>";
			while($row1 = mysql_fetch_array($result1)){
			extract($row1);
			if($_SESSION['irecall']['level']>3)
				{
				$editComment="<td><a href='addComment.php?commentid=$commentid'>Edit</a>
				</td>";
				}
				else
				{$editComment="";}
			echo "<tr><td><b>$authorname</b></td>$editComment<td>$comment</td></tr>";}
			}
		echo "</table>";
		}
	
	if($var=="photos")
		{
		$base="photos/ztn."; $photoLink=$base.$pid.$filename;
		$subtext=substr($caption,0,25);
		echo "<tr><td><img src='$photoLink'></td><td><b>$phototitle</b></td><td>$subtext...</td><td>Submitted by: $submitter</td></tr>";
		}
//	echo "$line";
	}// end while
	echo "</table>";
	}// end if


function returnNum($type)
	{
	global $numrow,$connection,$view;
	$sql="SELECT * FROM irecall.$type where mark=''";
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	$numrow = mysql_num_rows($result);
	if($numrow>0){$view="<br><a href='view.php?var=$type'>List</a></th>";}else{$view="<br>&nbsp;";}
	}
?>


</div>
</body></html>

