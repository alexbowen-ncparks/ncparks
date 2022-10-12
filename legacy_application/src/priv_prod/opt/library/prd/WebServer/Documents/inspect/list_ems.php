<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$passFile=$_SERVER['PHP_SELF'];
$passPark=$_SESSION['inspect']['select'];

// *************** Retrieve Topics
$topic_array=array("EMR training"=>"a_emr_training","AED/CPR training"=>"a_aed_cpr_training","Equipment"=>"a_equipment","Forms"=>"a_forms","Protocols"=>"a_protocols","Lifeguarding"=>"a_lifeguarding");

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
		$x[$id]=array($row['title'],$row['link'],$row['comments']);
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
			$link=$array[1];
			$comments=$array[2];
			echo "<table border='0' cellpadding='3' >";
			if(!empty($link))
				{$title="<a href='$link' target='_blank'>$title</a>";}
			echo "<tr><td align='left'>•$i &nbsp;
			<span title='$comments'>$title</span></td>";
			if($level>2)
				{
				echo "<td><font size='-2'><a href='delete_ems.php?table=$topic&id=$k' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Del</a></font></td>";
				}
			echo "</tr></table>";
			}
		if($level>2 AND $passFile=="/inspect/home.php")
			{
			echo "<br /><font size='-2'><a href='add_file.php?add_ems=$topic'>Add</a> an Item for this section.</font>";
			}
		}
		else
		{
		echo "<table border='0' cellpadding='3' >
		<tr><td align='right'>";
		if($level>2)
			{
			echo "<font size='-2'><a href='add_file.php?add_ems=$topic'>Add</a> an Item for this section.</font>";
			}
		echo "</td></tr></table>";
		}
	}
echo "</tr></table>";


?>