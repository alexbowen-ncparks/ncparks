 <?php
$passQuery="fld1=val1&fld2=val2&fld3=val3";

$exp=explode("&",$passQuery);
echo "<pre>"; print_r($exp); echo "</pre>"; // exit;

echo "<form method='post' action='acs_add_test.php'><table><tr><td>



<input type='submit' name='submit' value=\"Return to Form\">
</form></table>";
?>
	