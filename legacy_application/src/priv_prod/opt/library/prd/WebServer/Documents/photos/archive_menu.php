<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<table cellpadding='5'>";
	echo "<tr><td bgcolor='yellow' align='center' width='10%'><a href=archive_search.php>Search</a></td>
	<td bgcolor='#66FF66' align='center' width='10%'><a href='archive.php?find=50'>Recent 50</a></td>";
	
if($level>2)
	{
	echo "<td bgcolor='#CC99FF' align='center' width='10%'><a href='archive_insert.php'>Insert</a></td>
	<td bgcolor='#FFCC00' align='center' width='10%'><a href='archive_subjects.php' target='_blank'>Edit Subjects</a></td>
	<td bgcolor='#99CCFF' align='center' width='10%'><a href='archive_creators.php' target='_blank'>Edit Creators</a></td>
	<td bgcolor='#FF99FF' align='center' width='10%'><a href='archive_periods.php' target='_blank'>Edit Time Periods</a></td>
	<td bgcolor='#00FFFF' align='center' width='10%'><a href='archive_characteristics.php' target='_blank'>Edit Physical Char.</a></td>";
	IF($_SERVER['PHP_SELF']=="/photos/archive.php")
		{
		echo "<td bgcolor='#FFB4CD' align='center' width='10%'><a href='archive.php?rep=1'>Export</a></td>";
		}
	}
	
echo "</tr></table>";
?>