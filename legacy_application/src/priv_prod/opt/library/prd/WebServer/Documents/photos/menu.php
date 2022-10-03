<?php
echo "<table>
<tr><td align=\"center\"></td></tr>
<tr><td align=\"center\">
  <a href=\"/photos/index.php?source=photos\">Personnel/Archive</a>
  <a href=\"/photos/store.php?source=photos&submit=Add a Photo\">Add Image</a>
	<a href=\"/photos/search.php?source=photos\">Search Images</a><br />
<br />";
//   <a href=\"/photos/video.php?source=photos&submit=Add a Video\">Upload Video Link</a><br />
//   <a href=\"/photos/video_links.php\">View Videos</a>
  if($level>0)
	{
	echo "<a href=\"/photos/archive.php\"><font color='brown'>Photo Archive</font></a>";
	}
  if($level>4)
	{
	echo "<a href=\"/photos/admin.php?source=photos\">Admin Function</a>";
	}
echo "</td></tr>
</table>";

?>

