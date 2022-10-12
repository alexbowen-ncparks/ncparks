<?php
	include("menu.php");

	
	echo "<table>";
/*	
	echo "<tr><form action='report_pdf_base.php' method='POST'>
	<td colspan='3'>Graph <strong>Material</strong> donations by Donor Type.</td>";
	echo "<td>
	<input type='hidden' name='file' value='donor_type_amount'>
	<input type='hidden' name='donation_type' value='material'>
	<input type='submit' name='submit' value='Submit'>
	</td></form></tr>";
	
	echo "<tr><form action='report_pdf_base.php' method='POST'>
	<td colspan='3'>Graph <strong>Financial</strong> donations by Donor Type.</td>";
	echo "<td>
	<input type='hidden' name='file' value='donor_type_amount'>
	<input type='hidden' name='donation_type' value='financial'>
	<input type='submit' name='submit' value='Submit'>
	</td></form></tr>";
	
	echo "<tr><td><br /><br /></td></tr>";
	
	
	echo "<tr><form action='report_pdf_base.php' method='POST'>
	<td colspan='3'>Graph <strong>Financial</strong> donations by Park.</td>";
	echo "<td>
	<input type='hidden' name='file' value='park_amount'>
	<input type='hidden' name='donation_type' value='financial'>
	<input type='submit' name='submit' value='Submit'>
	</td></form></tr>";
*/	
	
	echo "<tr><form action='park_amount_online.php' method='POST'>
	<td colspan='3'>$pass_park Display <strong>Financial</strong> donations to Park by Year.</td>";
	echo "<td>
	<input type='hidden' name='file' value='park_amount'>
	<input type='hidden' name='donation_type' value='financial'>
	<input type='submit' name='submit' value='Submit'>
	</td></form></tr>";
	
	
	
	echo "</table></div></body></html>";


?>