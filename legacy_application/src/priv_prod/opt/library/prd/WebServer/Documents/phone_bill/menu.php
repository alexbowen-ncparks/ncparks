<?php
$title="DPR Phone Logs";
include("../inc/_base_top_dpr.php");
ini_set('display_errors',1);
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;
extract($_REQUEST);
@$level=$_SESSION['phone_bill']['level'];
@$tempID=$_SESSION['phone_bill']['tempID'];
date_default_timezone_set('America/New_York');

if($level<1)
	{
	echo "Your access level is zero. You will need to <a href='http://10.35.152.9/phone_bill/index.html'>login</a> to access this database."; exit;
	echo "Your access level is zero. You will need to <a href='http://10.35.152.9/phone_bill/index.html'>login</a> to access this database."; exit;
	}

$menu_array=array("View Phone Bill"=>"phone_parse.php","Search Phone Database"=>"search.php");

if($level>3)
	{
	$menu_array=array("Upload Phone Bill"=>"addPhoneTXT_form.php","View Phone Bill"=>"phone_parse.php","Electronic Device Agreement-Individual"=>"agreement.php","Electronic Device Agreement-Park"=>"agreement_park.php","Search Phone Database"=>"search.php","Upload .csv"=>"upload_sips.php");
	}




echo "<form><table>
<tr><td><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Phone Bill Menu</option>";
foreach($menu_array as $item=>$file)
	{
	echo "<option value='$file'>$item</option>";
	}
echo "</select></td>
</tr>
</table></form>";

?>