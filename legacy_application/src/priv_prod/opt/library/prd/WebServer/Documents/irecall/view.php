<?php

extract($_REQUEST);


if(@$var=="former_emp"){header("Location: search.php?search=all_emp");exit;}
if(@$var=="missed_emp"){header("Location: missed_emp.php");exit;}

echo "<html>
<head>
<title>Faces & Places</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
</head>
<body bgcolor=\"beige\">
<div align=\"center\">";
include("header.php"); 
include("footer.php"); // link to The Transition
include_once("../../include/iConnect.inc");

echo "<table width='680'>";
$type="tradition"; returnNum($type);
echo "<tr><th>Traditions: $numrow $view";
$type="person"; returnNum($type);
echo "<th>Special People: $numrow $view";
$type="change1"; returnNum($type);
echo "<th>Changes: $numrow $view";
$type="photos"; returnNum($type);
echo "<th>Photos: $numrow $view";
$type="sound"; returnNum($type);
echo "<th>Audio/Video: $numrow $view";
$type="former_emp"; returnNum($type);
echo "<th>Former Employees: $numrow $view";
$type="missed_emp"; returnNum($type);
echo "<th>Will Be Missed: $numrow $view";
echo "</tr>
<table>";

echo "<div align='center'><table>";
// *********** Search Form ***************
/*
echo "<form action='search.php'><tr>
<td><input type='text' name='search' size='15'>
<input type='submit' name='submit' value='Search'></form></td></tr></table>
<form></td></tr></table></div>";
*/
mysqli_select_db($connection,"irecall");
if(@$var)
	{
	if($var=="photos"){$display_number=20;
	
		// Calculate the number of pages required.
	if (!isset($num_pages))
		{
		$sql="SELECT pid FROM irecall.$var where mark='' order by date DESC";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$numrow=mysqli_num_rows($result);
			if ($numrow > $display_number) {
				$num_pages = ceil ($numrow/$display_number);
			} elseif ($numrow > 0) {
				$num_pages = 1;
			} 
			$start = 0; // Currently at item 0.
		}
	
	$sql="SELECT * FROM irecall.$var where mark='' order by date DESC LIMIT $start,$display_number";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$numrow=mysqli_num_rows($result);
	}
	else	
	{// not photos
	$sql="SELECT * FROM irecall.$var where mark='' order by date DESC";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}
	
	echo "<hr><table border='1'>";
	while($row = mysqli_fetch_array($result)){
	extract($row);
	
	if($var=="person")
		{
		$sql1="SELECT count(type) as num FROM irecall.comment where type='$var' and typeid='$personid'";
		$result1 = @mysqli_query($connection,$sql1) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));$row1 = mysqli_fetch_array($result1);
		extract($row1);if($num>0){$com="<td>Comments: $num</td>";}else{$com="";}
		
		$subtext=substr($persontext,0,50);
		$line="<tr><td><b>$personname</b></td><td><a href='show.php?var=$var&personid=$personid'>Read</a></td><td>$subtext...</td><td>submitted by: $authorname</td>$com</tr>";
		}
	
	if($var=="tradition")
		{
		$sql1="SELECT count(type) as num FROM irecall.comment where type='$var' and typeid='$traditionid'";
		$result1 = @mysqli_query($connection,$sql1) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));$row1 = mysqli_fetch_array($result1);
		extract($row1);if($num>0){$com="<td>Comments: $num</td>";}else{$com="";}
		$subtext=substr($tradtext,0,50);
		$line="<tr><td><b>$title</b></td><td><a href='show.php?var=$var&traditionid=$traditionid'>Read</a></td><td>$subtext...</td><td>submitted by: $authorname</td>$com</tr>";
		}
	
	if($var=="change1")
		{
		$subtext=substr($changetext,0,50);
		$line="<tr><td><b>$changename</b></td><td><a href='show.php?var=$var&change1id=$change1id'>Read</a></td><td>$subtext...</td><td>submitted by: $authorname</td></tr>";
		}
	
	if($var=="photos")
		{
		$sql1="SELECT count(type) as num FROM irecall.comment where type='$var' and typeid='$pid'";
		$result1 = @mysqli_query($connection,$sql1) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));$row1 = mysqli_fetch_array($result1);
		extract($row1);if($num>0){$com="<td>Comments: $num</td>";}else{$com="";}
		
		$fs=round($filesize/1024);
		$base="photos/ztn."; $photoLink=$base.$pid.$filename;
		$subtext=substr($caption,0,50);
		$line="<tr><td align='center'><a href='getData.php?pid=$pid&location=$link&size=640'><img src='$photoLink'></a></td><td><b>$phototitle</b></td><td>$parkX<br />$subtext...</td><td>submitted by: $submitter</td><td>($fs kb)</td>$com</tr>";
		}
	
	if($var=="sound")
		{
		if(!empty($pid)){
		$sql1="SELECT count(type) as num FROM irecall.comment where type='$var' and typeid='$pid'"; //echo "$sql1";
		$result1 = @mysqli_query($connection,$sql1) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$row1 = mysqli_fetch_array($result1);
		extract($row1); }
		if(@$num>0)
			{$com="<td>Comments: $num</td>";}else{$com="";}
		$park=strtoupper($park);
		$line="<tr><td align='center'><a href='$link'>Link</a></td><td width='500'><b>$comment</b></td><td>$file_size kb</td><td>$park</td><td>submitted by: $source</td><td>$dateSound</td></tr>";
		}
	
	echo "$line";
	}// end while
	
	echo "</table>";
	if (@$num_pages > 1) {
	echo "<table align='center'>";
		echo "<tr align='center'>
			<td align='center' colspan='2'>";
			
		// Determine what page the script is on.	
		if ($start == 0) {
			$current_page = 1;
		} else {
			$current_page = ($start/$display_number) + 1;
		}
		
		// If it's not the first page, make a Previous button.
		if ($start != 0) {
		$next_start=$start - $display_number;
		$linkPrev="<a href='view.php?start=$next_start&num_pages=$num_pages&var=photos'>Previous</a>&nbsp;";
		echo "$linkPrev";
		}
	
		// Make all the numbered pages.
		for ($i = 1; $i <= $num_pages; $i++) {
			if ($i != $current_page) { // Don't link the current page.
		$next_start=$display_number * ($i - 1);
		$linkPage="<a href='view.php?start=$next_start&num_pages=$num_pages&var=photos'>$i</a>&nbsp;";
		echo "$linkPage";
				
			} else {
				echo "$i&nbsp;";
			}
		}
		
		// If it's not the last page, make a Next button.
		if ($current_page != $num_pages) {
		$next_start=$start + $display_number;
		$linkNext="<a href='view.php?start=$next_start&num_pages=$num_pages&var=photos'>Next</a>&nbsp;";
		echo "$linkNext";
		}
		
		echo '</td>
		</tr>';
	}
	
	}// end if $var


function returnNum($type)
	{
	global $numrow,$connection,$view;
	$sql="SELECT * FROM irecall.$type where mark=''";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$numrow = mysqli_num_rows($result);
	if($numrow>0){$view="<br><a href='view.php?var=$type'>List</a></th>";}else{$view="<br>&nbsp;";}
	}
?>


</div>
</body></html>

