<?php

date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

include("_base_top.php");
//$pass_park_code=@$_SESSION[$database]['select'];

//include("../../include/get_parkcodes_i.php");
include("../../include/iConnect.inc");
$sql="SELECT t1.project_name
from account_info as t1
 WHERE t1.project_file_name='$project_file_name'"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);


// Form to edit an item
echo "<style>
.head {
font-size: 22px;
color: #999900;

.ui-datepicker {
  font-size: 80%;
}
</style>";

$pfn=$project_name." - ".$project_file_name;
if($var=="scores"){$pfn="Scores";}

echo "<div>";
echo "<table border='1'>
<tr><td align='center' colspan='11'><font size='6' color='#cc0000'>$pfn</font> </td></tr>
<tr>
<td><a href='edit_form.php?var=account_info&project_file_name=$project_file_name'>account_info</a></td>
<td><a href='edit_form.php?var=applicant_info&project_file_name=$project_file_name'>applicant_info</a></td>
<td><a href='edit_form.php?var=project_info&project_file_name=$project_file_name'>project_info</a></td>
<td><a href='edit_form.php?var=project_location&project_file_name=$project_file_name'>project_location</a></td>
<td><a href='edit_form.php?var=project_funding&project_file_name=$project_file_name'>project_funding</a></td>
<td><a href='edit_form.php?var=project_budget&project_file_name=$project_file_name'>project_budget</a></td>
<td><a href='edit_form.php?var=project_description&project_file_name=$project_file_name'>project_description</a></td>
<td><a href='edit_form.php?var=environmental_info&project_file_name=$project_file_name'>environmental_info</a></td>
<td><a href='edit_form.php?var=authorization&project_file_name=$project_file_name'>authorization</a></td>
<td><a href='edit_form.php?var=scores&project_file_name=$project_file_name'>scores</a></td>
</tr>
</table>";
echo "</div>";



?>