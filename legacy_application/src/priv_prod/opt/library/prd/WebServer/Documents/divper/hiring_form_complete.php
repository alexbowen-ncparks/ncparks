<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters

// extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;

mysqli_select_db($connection,'divper'); // database

$sql = "SELECT t1.id, t1.f_year, t1.beacon_num, t1.pass_target_date_0 as resignation_date, completed_date_10 as completed_date, datediff(completed_date_10, pass_target_date_0) as Cal_days, t2.beacon_title, t2.working_title, t2.park, t1.supervisor
FROM hiring_form as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
where t1.completed_date_10!='0000-00-00' and t1.signature_10!=''
order by t1.id desc";  //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(!empty($ARRAY)){$c=count($ARRAY);}

include("menu.php");

include("hiring_form_menu.php");

if(empty($ARRAY)){echo "There are no completed hiring process forms."; exit;}
$c=count($ARRAY);
$c==1?$h="Process":$h="Processes";
echo "<table border='1' cellpadding='2'><tr><td colspan='10'><font color='magenta'>$c Hiring $h complete</font></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			$var_fld=str_replace("pass_","",$fld);
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$display_value=$value;
		if($fld=="beacon_num")
			{
			$pass_f_year=$array['f_year'];
			$pass_id=$array['id'];
			$display_value="<a href='hiring_form.php?pass_f_year=$pass_f_year&pass_id=$pass_id'>$value</a>";
			}
		echo "<td valign='top'>$display_value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

echo "</body></html>";

?>