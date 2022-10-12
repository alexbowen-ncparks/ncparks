<?php
ini_set('display_errors',1);
$database="hr_perm";
include("../../include/auth.inc");

include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("../_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY as $index=>$array)
	{
	if(in_array("welcome",$array))
		{
		$section_array[]=$array;
		}
	}
// echo "<pre>"; print_r($welcome_array); echo "</pre>"; // exit;
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>Welcome to the DPR HR website for Hiring/Separating Permanent Staff.</td></tr>";
echo "<tr><td>
<hr /><table align='center' cellpadding='15'><tr>";

foreach($section_array as $index=>$array)
	{
	extract($array);
	if(in_array("Governor",$array))
		{
		echo "<td align='center'>Governor <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("Secretary DNCR",$array))
		{
		echo "<td align='center'>Secretary DNCR <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("DPR Director",$array))
		{
		echo "<td align='center'>DPR Director <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("DNCR HR Director",$array))
		{
		echo "<td align='center'>DNCR HR Director <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("DPR HR Manager",$array))
		{
		echo "<td align='center'>DPR HR Manager <br /><strong>$tab_content</strong></td>";
		}
	}
echo "</tr></table></td></tr>";

include("includes/get_scenics.php");

echo "<tr><td>
<hr /><table cellpadding='5' align='center'>";

foreach($section_array as $index=>$array)
	{
	if(in_array("welcome_file",$array))
		{
		extract($array);
		echo "<tr><td><a href='$tab_content_link' target='_blank'>$tab_content</a></td></tr>";
		}
	if(in_array("welcome_text",$array))
		{
		extract($array);
		echo "<tr><td>$tab_content_link</td></tr>";
		}
	}
echo "</table></td></tr>";

include("includes/get_map.php");

echo "</table>";
echo "</div>";
?>