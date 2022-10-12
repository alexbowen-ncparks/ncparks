<?php
ini_set('display_errors',1);
$database="work_comp";
include("../_base_top.php");

if($_SESSION['work_comp']['level'] <1)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Worker Compensation Tracking Application</font></h2></th></tr></table>";

echo "<table align='center'><tr><td>
1. Select Manage Forms from the drop-down.<br />
2. All WC forms need to be stored in the FIND db. Specifically FIND ID number 511.<br /><br />
Add New Forms:<br />
3. To update the forms in FIND, click on the 511 link under forumID. (You may need to login to the FIND before clicking on the link.)<br />
4. Click on the Edit link on the far right.<br />
5. Click on any form(s) that needs to replaced and delete it.<br />
6. Upload any new form using the buttons at the bottom of the screen.<br />
7. Return to the WC db.<br />
8. <strong> By clicking on the Replace All Forms button the existing forms will be replaced by those stored in the FIND. (This will also remove the sort order AND the Form Name. These will need to be reentered.)</strong>

</td></tr></table>";

echo "</html>";
?>