<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="hr";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
echo "<html><head>";

echo "<script language=\"JavaScript\"><!--
function setForm() {
    opener.document.ts_form.job_description.value = document.inputForm1.inputField0.value;
    opener.document.ts_form.hourly_rate.value = document.inputForm1.inputField1.value;
    opener.document.ts_form.job_title.value = document.inputForm1.inputField2.value;
    opener.document.ts_form.billing_rate.value = document.inputForm1.inputField3.value;
    opener.document.ts_form.work_hours.value=document.inputForm1.inputField4.value;
    opener.document.ts_form.cost_week.value = ((document.inputForm1.inputField3.value * document.inputForm1.inputField4.value*document.inputForm1.inputField5.value).toFixed(3));
    var wh=opener.document.ts_form.work_hours.value;
    self.close();
    return false;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//--></script>";

echo "</head><table>";

$sql="SELECT t1.osbm_title, t2.beacon_posnum, t1.job_description, t2.avg_rate
from seasonal_payroll_justification as t1
left join seasonal_payroll as t2 on t1.osbm_title=t2.osbm_title
where t2.center_code='$park_code'
order by t1.osbm_title";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_array($result))
	{
	$jd_array[$row['beacon_posnum']]=$row['osbm_title'];
	$pay_array[$row['beacon_posnum']]=$row['avg_rate'];
	$title_array[$row['osbm_title']]=$row['osbm_title'];
	$description_array[$row['beacon_posnum']]=$row['job_description'];
	}
//echo "<pre>"; print_r($jd_array); echo "</pre>";  //exit;

echo "<form><tr><td colspan='3'>BEACON Job Titles for $park_code:</td><td><select name='osbm_title' onChange=\"this.form.submit()\">
<option value='' selected></option>\n";         
        foreach($title_array as $k=>$v)
		{
		echo "<option value='$k'>$k</option>\n";
		}
echo "</select>
<input type='hidden' name='park_code' value='$park_code'></td></tr></form>";

if(empty($_REQUEST['osbm_title'])){exit;}
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
echo "<form method='POST'>";
echo "<tr><td colspan='3'>BEACON Position Numbers:</td></tr>";         
        foreach($jd_array as $k=>$v)
		{
		if($v!=$_REQUEST['osbm_title']){continue;}
		if(@in_array($k,$_REQUEST['beacon_posnum'])){$ck="checked";}else{$ck="";}
		echo "<tr><td><input type='checkbox' name='beacon_posnum[]' value='$k' $ck>$k</td><td>$v</td></tr>";
		}
echo "</td></tr>
<tr><td><input type='submit' name='submit' value='Submit Selection'></td></tr>
</table></form>";

if(empty($_REQUEST['beacon_posnum'])){exit;}

$pass_text="";
if(!empty($_POST['beacon_posnum']))
	{
	$num_positions=count($_POST['beacon_posnum']);
	foreach($_POST['beacon_posnum'] as $k=>$v)
		{
		$pass_text.=$v.",";
		}
	$pass_text=rtrim($pass_text,",");
	}
$pos_num=$_POST['beacon_posnum'][0];
$hourly_rate=$pay_array[$pos_num];

	$job_description=$description_array[$pos_num];
	$pass_text.="-".$job_description;
	$billing_rate=number_format(($hourly_rate*1.0765)+2,4);
?>
	
<script>
work_hour = opener.document.ts_form.work_hours.value;
billing_rate = opener.document.ts_form.billing_rate.value;
num_pos = <?php echo $num_positions; ?>;
tc = (work_hour * billing_rate * num_pos).toFixed(4);
</script>
<?php
	echo "<form name=\"inputForm1\" onSubmit=\"return setForm();\">";
	echo "<table border='1'><tr><th>Job Title</th><th>Job Description</th><th>Hourly Rate</th>
	<th>Billing Rate</th><th>Work Hours</th><th>Num Positions</th></tr>";
	echo "<tr>
	<td align='center'><input name='inputField2' name='job_title' value='$_REQUEST[osbm_title]' READONLY></td>
	<td align='center'><textarea name='inputField0' cols='64' rows='10' READONLY>$pass_text</textarea></td>
	<td align='center'><input name='inputField1' name='hourly_rate' value='$hourly_rate' size='5' READONLY></td>
	<td align='center'><input name='inputField3' name='billing_rate' value='$billing_rate' size='5' READONLY></td>
	<td align='center'>";
?>
	<script>
	z="<input name='inputField4' name='work_hours'  value='" + work_hour +"' size='3'>";
	document.write(z);
	</script>
	
<?php
	echo "</td>
	<td align='center'><input type='text' name='inputField5' name='num_positions' value='$num_positions' size='3'></td>
	</tr>
	<tr><td bgcolor='green' colspan='' align='center'>
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='submit' value='Update Job Request Form'>
	</form></td><td>$num_positions positions @";
?>
	<script>
	document.write(work_hour);
	</script>
<?php
echo " hours = ";
?>
	<script>
	document.write(tc);
	</script>
<?php
	
	echo "</td></tr>
	</form>";

	if(!empty($note)){echo "<table border='1'><tr><th>$note</th></tr>";}

	echo "</table>";
	
	

?>