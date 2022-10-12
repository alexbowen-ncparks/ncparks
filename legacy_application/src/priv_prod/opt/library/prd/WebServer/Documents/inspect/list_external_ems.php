<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$passFile=$_SERVER['PHP_SELF'];
$passPark=$_SESSION['inspect']['select'];

// *************** Retrieve Topics
$topic_array=array("NC OEMS"=>"a_external_nc_oems");

$f1="<font color='green'>";$f2="</font>";

echo "<table border='1' align='center'><tr valign='top'>";
foreach($topic_array as $topic_name=>$topic)
	{
	$sql="SELECT * FROM $topic order by id";
	$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$x=array();
	while($row=mysqli_fetch_assoc($result))
		{
		$id=$row['id'];
		$x[$id]=array($row['title'],$row['url'],$row['comments']);
		${$topic."_array"}=$x;
		}
// 		echo "<pre>"; print_r(${$topic."_array"}); echo "</pre>"; // exit;
	echo "<td><table><tr valign='top'><td>$f1 $topic_name:$f2</td></tr>";
	if(!empty(${$topic."_array"}))
		{
		$i=0;
		foreach(${$topic."_array"}as $k=>$array)
			{
			$i++;
			$title=$array[0];
			$url=$array[1];
			$comments=$array[2];
			echo "<table border='0' cellpadding='3' >";
			if(!empty($url))
				{$title="<a href='$url' target='_blank'>$title</a>";}
			echo "<tr><td align='left'>•$i &nbsp;$title</td>";
			if(!empty($comments))
				{
				echo "<td>
				<a onclick=\"toggleDisplay('comments');\" href=\"javascript:void('')\">Comment</a>
	<div id=\"comments\" style=\"display: none\">$comments</div></td>";
				}
			if($level>2)
				{
				echo "<td><a href='delete_external_ems.php?table=$topic&id=$k' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Del</a></td>";
				}
			echo "</tr></table>";
			}
		if($level>2 AND $passFile=="/inspect/home.php")
			{
			echo "<br /><font size='-2'><a href='add_file_external.php?add_external=$topic'>Add</a> an Item for this section.</font>";
			}
		}
		else
		{
		echo "<table border='0' cellpadding='3' >
		<tr><td align='right'>";
		if($level>2)
			{
			echo "<font size='-2'><a href='add_file_external.php?add_external=$topic'>Add</a> an Item for this section.</font>";
			}
		echo "</td></tr></table>";
		}
	}
echo "</tr></table>";


?>