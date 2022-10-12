<html><head><title>Faces & Places</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="beige"><div align="center">
<?php include("header.php"); include("footer.php"); 
include_once("../../include/connectROOT.inc");
mysql_select_db("irecall",$connection);
//print_r($_REQUEST);
extract($_REQUEST);
// *********** Search Form ***************
/*
echo "<div align='center'><form action='search.php'><table><tr>
<td><input type='text' name='search' size='15'>
<input type='submit' name='submit' value='Search'></form></td></tr></table></div>
</form>";
*/
// *********** Perform Search ***************
if($search)
	{
	$search=addslashes($search);
	
	// ****** Former Employees ********
	if($search=="all_emp"){$sql="SELECT * FROM irecall.former_emp 
	WHERE 1 order by last_name, first_name";
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result);}
	else{
	$sql="SELECT * FROM irecall.former_emp 
	WHERE last_name like '%$search%' or first_name like '%$search%' or last_pos like '%$search%'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result);}
	
	if($num>0)
		{
		echo "<div align='left'><hr><table border='1' cellpadding='5'><tr><td><font color='red'><b>Former Employee</b></font></td><td colspan='3'>View list of <a href='search.php?search=all_emp'>ALL</a> former employees.</td></tr>";
		
		while($row = mysql_fetch_array($result))
		{
		extract($row);
		@$i++;
//		$tradtext=substr($tradtext,0,50);
		echo "<tr><td align='right'><a href='show.php?var=former_emp&formerid=$formerid'>Address</a>&nbsp;&nbsp;&nbsp;$i</td><td><b>$first_name $last_name</b></td><td align='right'>$phone</td><td>$email</td><td>$last_pos</td>";
		echo "</tr>";}
		echo "</table></div>";
		}// end if $num
	
	// ****** Tradition ********
	$sql="SELECT * FROM irecall.tradition 
	WHERE tradtext like '%$search%' or title like '%$search%' or comment like '%$search%'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result);
	if($num>0){
	echo "<div align='left'><hr><table><tr><td><font color='red'><b>Tradition</b></font></td></tr>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	$tradtext=substr($tradtext,0,50);
	echo "<tr><td align='center'><a href='show.php?var=tradition&traditionid=$traditionid'>View</a></td><td><b>$title</b></td><td align='right'>Submitted by: $authorname => </td><td>$tradtext . . . .</td>";
	if($comment){echo "<td>Submitter's Comment: $comment</td>";}
	echo "</tr>";}
	echo "</table></div>";
	}// end if $num
	
	// ****** Special People ********
	$sql="SELECT * FROM irecall.person 
	WHERE persontext like '%$search%' or personname like '%$search%' or comment like '%$search%'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result);
	if($num>0){
	echo "<div align='left'><hr><table><tr><td colspan='2'><font color='red'><b>Special Person</b></font></td></tr>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	$persontext=substr($persontext,0,50);
	echo "<tr><td align='center'><a href='show.php?var=person&personid=$personid'>View</a></td><td><b>$personname</b></td><td align='right'>Submitted by: $authorname => </td><td>$persontext . . . .</td>";
	if($comment){echo "<td>Submitter's Comment: $comment</td>";}
	echo "</tr>";}
	echo "</table></div>";
	}
	
	
	// ****** Change ********
	$sql="SELECT * FROM irecall.change1 
	WHERE changetext like '%$search%' or changename like '%$search%' or comment like '%$search%'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result);
	if($num>0){
	echo "<div align='left'><hr><table><tr><td><font color='red'><b>Change</b></font></td></tr>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	$changetext=substr($changetext,0,50);
	echo "<tr><td align='center'><a href='show.php?var=change1&change1id=$change1id'>View</a></td><td><b>$changename</b></td><td align='right'>Submitted by: $authorname => </td><td>$changetext . . . .</td>";
	if($comment){echo "<td>Submitter's Comment: $comment</td>";}
	echo "</tr>";}
	echo "</table></div>";
	}
	
	// ****** Photos ********
	$sql="SELECT * FROM irecall.photos 
	WHERE phototitle like '%$search%' or caption like '%$search%' or comment like '%$search%'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result);
	if($num>0){
	echo "<div align='left'><hr><table><tr><td><font color='red'><b>Photos</b></font></td></tr>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	$base="photos/ztn."; $photoLink=$base.$pid.$filename;
	$caption=substr($caption,0,50);
	$comment=substr($comment,0,50);
	echo "<tr><td align='center'><a href='getData.php?pid=$pid&location=$link&size=640' target='_blank'><img src='$photoLink'><br><b>$phototitle</b></a></td><td align='left'>Submitted by:<br>$submitter</td><td align='left'>Photo by:<br>$photographer</td><td><b>Caption:</b><br>$caption . . . .</td>";
	if($comment){echo "<td>Submitter's Comment: $comment . . . .</td>";}
	echo "</tr>";}
	echo "</table></div>";
	}
	
	}// end if $search
?>
</body></html>

