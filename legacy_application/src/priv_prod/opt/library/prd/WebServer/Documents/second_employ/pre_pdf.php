<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$database="second_employ";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

include("menu.php");

$sql = "SELECT * FROM se_list as t1 
	WHERE  id='$id'
	";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$id."; exit;}	
	$row=mysqli_fetch_assoc($result);
	
echo "<table align='center'><tr><td>Please check to make sure all information is complete and accurate.</td></tr></table>";		

$skip=array("id","se_dpr","notify_supervisor","supervisor_approval","PASU_approval","DISU_approval","CHOP_approval","HR_approval","Director_approval","status","id");
echo "<table>";
foreach($row as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	echo "<tr><th align='left'>$k</th><td>$v</td></tr>";
	}
echo "</table>";

echo "<table><tr><td>If any change is necessary, click this <a href='edit.php?edit=$id&submit=edit'>link</a>.</td></tr>
<tr><td> </td></tr>
<tr><td> </td></tr>

<tr><td>If all info is accurate and complete, click this link to create your request. <a href='se_pdf.php?id=$id' target='_blank'>Create PDF</a></td></tr>

<tr><td>1. Your PDF will either open in a new tab/window OR you will be asked to save the PDF to your computer.</td></tr>
<tr><td>2. If the PDF is shown in a new tab/window, right click on the form and print the PDF.</td></tr>
<tr><td>3. If the PDF is saved to your computer, remember its location so that you can find the file and print the PDF.</td></tr>
<tr><td> </td></tr>
<tr><td>After printing the request, sign and date the request.</td></tr>
<tr><td>Scan the signed and dated form to create a PDF.</td></tr>
<tr><td>Click on the \"Track a Request\" to find the record for your request and click on the link in the left column.</td></tr>
<tr><td>Using the button next to \"Upload Signed and Dated Request\", find your PDF on your computer.</td></tr>
<tr><td>Next enter a date for \"notify supervisor\" AND click the Update button. (Nothing is saved unless you click the Update button.)</td></tr>
<tr><td>Email your supervisor to let them know that you have submitted a request.</td></tr>
</table></body></html>";
?>