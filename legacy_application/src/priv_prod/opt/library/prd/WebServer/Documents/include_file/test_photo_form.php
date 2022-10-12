<?php

	// *********** Blank form
	echo "<h3>Add a Photo</h3>";
	 
	 echo "<hr /><form method='post' name='mainform' action='store.php' enctype='multipart/form-data' onsubmit=\"validate();\">";
	

	echo "<br>
	Date of Photo: 
		<input type='text' name='datePhoto' value='$year' size='16'>
		$employeeID<br><br>";
	if($majorGroup)
		{
		echo "
			SciName: <i>$sciName</i>
			<br>
			ComName: <b>$comName</b>
			<br><br>";}
	if($observer){$observer=urldecode($observer);$photog=$observer;}// passed from NRID
	echo "Name of Photo: <input type='text' name='photoname' value='$photoname' size='75'><br><br>
		Photographer(s): <input type='text' name='photog' value='$photog' size='50'><br><br>
		Comment(s): <textarea cols='40' rows='5' name='comment'>$comment</textarea><br /><br />
	<input type='text' name='lat' value='$lat' size='10'> Latitude
	<input type='text' name='lon' value='$lon' size='10'> Longitude in degrees decimal, e.g., 34.258621, -78.490335 for Google Earth/Map
	<hr>
		<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='30000000'>
		<br>1. Click the BROWSE (or Choose File) button and select your photo.<br>
		<input type='file' name='photo'  size='40'>
	<input type='hidden' name='source' value='$source'>
	<input type='hidden' name='sciName' value='$sciName'>
	<input type='hidden' name='comName' value=\"$comName\">
		<p>2. Then click this button. <input type='submit' name='submit' value='Add Photo'>
		</form>";
	echo "</BODY></HTML>";

?>
