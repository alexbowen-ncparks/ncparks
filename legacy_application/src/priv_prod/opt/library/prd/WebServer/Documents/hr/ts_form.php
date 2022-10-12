<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="hr";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_i.php"); // database connection parameters
mysqli_select_db($connection,"hr"); // database

//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

		$skip_unit=array("WOED");
if(empty($_REQUEST))
	{
	$database="hr"; // prevents menu.php from being skipped
	include("../_base_top.php");
	echo "<form action='ts_form.php' method='POST'>";
	echo "<table>";
	echo "<tr><td><h3>Online Application - Temporary Solutions Job Request</h3></td></tr>";
	echo "<tr><td>Select your Park:</td></tr>";
	$parkCodeName['ARCH']="Nature Research Center";
	echo "<tr>
	<td><select name='division'><option value='' selected></option>\n";
	foreach($parkCodeName as $k=>$v)
		{
		if(in_array($k,$skip_unit)){continue;}
		echo "<option value=\"$k\">$v</option>\n";
		}
	echo "</select></td></tr>
	<tr><td><input type='submit' name='add' value='Start'></td></tr></table>";
	echo "</form>";
	exit;
	}

$query="SHOW 	COLUMNS from temp_solutions"; //echo "$query";exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

extract($_REQUEST);
	
$rename1=array("date_job_order"=>"Date of Job Order","division"=>"Agency/Division", "billing_contact"=>"Billing contact for agency", "billing_phone"=>"Billing Phone","billing_email"=>"Billing email","billing_fax"=>"Billing Fax","hr_contact"=>"HR Contact","hr_phone"=>"HR Phone","hr_email"=>"HR Email","hr_fax"=>"HR Fax",
"supervisor"=>"Supervisor", "supervisor_phone"=>"Supervisor Phone", "supervisor_email"=>"Supervisor Email",
"supervisor_fax"=>"Supervisor Fax", "address"=>"Address to report to","email_account"=>"Will temp employee receive email account?");

$rename2=array("start_date"=>"Start Date","end_date"=>"End Date","work_hours"=>"Work Hours per Week","job_title"=>"Job Title","pay_grade"=>"Pay Grade","hourly_rate"=>"Hourly Rate","billing_rate"=>"Billing Rate (Hourly Rate*1.0765)+2","employee_name"=>"If applicable, employee name","contact_info"=>"Employee Contact Info","job_description"=>"Job Description");

$rename=array_merge($rename1,$rename2);

$skip=array("id","submit");

if(!empty($_POST))
	{
	$clause="set ";
	foreach($ARRAY as $index=>$fld)
		{
		if(in_array($fld,$skip)){continue;}
		if(!array_key_exists($fld, $_POST) OR $_POST[$fld]=="No")
			{ // track errors
			$error_fld[]=$fld;
			$error[]=$rename[$fld];
			}
			else
			{ // create update clause which will be used if no errors
			$val=mysqli_real_escape_string($connection,$_POST[$fld]);
			$clause.="$fld='$val', ";
			}
		}
	$clause=rtrim($clause,", ");
	}



if(!empty($error) OR empty($_POST['submit']))
	{
	if(!empty($error))
		{
		$error_message="<font color='magenta'>Submission halted.</font> You failed to answer items <font color='red'>marked in red</font>.";
		}
	if(!empty($id) or !empty($division))
		{
		if(!empty($id))
			{
			$sql="SELECT * FROM `temp_solutions` where  id='$id'";
			$result=mysqli_query($connection,$sql);
			$row=mysqli_fetch_assoc($result);
			extract($row); //print_r($row);
			}
		
		$sql="SELECT add1,add2,city,zip FROM dpr_system.`dprunit` where  parkcode='$division'";
		$result=mysqli_query($connection,$sql) or die(mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		extract($row); //print_r($row);
		$address=$add1;
		if(!empty($add2)){$address.=", ".$add2;}
		$address.=" $city, NC $zip";
		$pass_address=$address;
		
		$park_code=$division;
		$sql="SELECT group_concat(t3.Fname, ' ', t3.Lname order by t1.current_salary desc) as name, group_concat(t3.email order by t1.current_salary desc) as email, t4.ophone, t4.fax
		FROM divper.position as t1 
		LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num 
		LEFT JOIN divper.empinfo as t3 on t2.emid=t3.emid 
		LEFT JOIN dpr_system.dprunit as t4 on t1.park=t4.parkcode
		where t1.park='$park_code' and t1.posTitle='Park Superintendent'
		";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Select 85. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		$exp1=explode(",",$row['name']);
		$exp2=explode(",",$row['email']);
		$supervisor=$row['name'];
		$supervisor_email=$row['email'];
		$supervisor_phone=$row['ophone'];
		$supervisor_fax=$row['fax'];
		}
	}
	else   // only if $error is empty and $_POST[submit] is NOT empty
	{
	IF(!empty($id)){$clause.=", id='$id'";}
	$sql="REPLACE temp_solutions $clause "; //echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//	echo "$sql"; exit;
	$result=mysqli_query($connection,$sql);
		$sql="SELECT add1,add2,city,zip FROM dpr_system.`dprunit` where  parkcode='$division'";
		$result=mysqli_query($connection,$sql) or die(mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		extract($row); //print_r($row);
		$address=$add1;
		if(!empty($add2)){$address.=", ".$add2;}
		$address.=", $city, NC $zip";
		$pass_address=$address;
		// PASU
		$park_code=$division;
		$sql="SELECT group_concat(t3.Fname, ' ', t3.Lname order by t1.current_salary desc) as name, group_concat(t3.email order by t1.current_salary desc) as email
		FROM divper.position as t1 
		LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num 
		LEFT JOIN divper.empinfo as t3 on t2.emid=t3.emid 
		where t1.park='$park_code' and t1.posTitle='Park Superintendent'
		";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Select 85. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		$exp1=explode(",",$row['name']);
		$exp2=explode(",",$row['email']);
		$supervisor=$row['name'];
		$supervisor_email=$row['email'];
		
	IF(empty($id))
		{
		$sql="SELECT MAX(`id`) as id FROM `temp_solutions`";
		$result=mysqli_query($connection,$sql);
		$row=mysqli_fetch_assoc($result);
		extract($row);  //echo "id=$id";
		}
	
	$ts_form_upload=1;
	}
$database="hr";
include("../_base_top.php");

?>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
$hard_wired=array("billing_contact"=>"Tammy Dodd","billing_phone"=>"919-707-9359", "billing_email"=>"Tammy.Dodd@ncparks.gov","billing_fax"=>"919-707-9359","hr_contact"=>"Teresa McCall","hr_phone"=>"(919) 707-9355","hr_email"=>"Teresa.McCall@ncparks.gov","hr_fax"=>"(919) 715-5160");
$td_size=array("address"=>"65","start_date"=>"11","end_date"=>"11","job_title"=>"","pay_grade"=>"5","work_hours"=>"5","hourly_rate"=>"5","billing_rate"=>"5","date_job_order"=>"11","contact_info"=>"55");
$readonly=array("job_title","hourly_rate","billing_rate");

//$skip_fld=array("id","billing_rate","billing_phone","billing_fax","hr_phone","hr_fax");
$skip_fld=array("id","billing_phone","billing_fax","hr_phone","hr_fax");
$stop_at="supervisor";
echo "<body1 style=\"font-size:90%\";>";
echo "<form name='ts_form' action='ts_form.php' method='POST'>
<fieldset><legend><b>Temp Solutions Job Request Form</b></legend><table cellpadding='3'><tr>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip_fld))
		{
		continue;
		}
	if($fld=="supervisor" and empty(${$fld}))
		{		
		echo "<tr><td><input type='submit' name='submit' value='Submit'>
		</td></tr></table></form>";
		exit;
		}
	
	$fld_name=$fld;
	if(array_key_exists($fld,$rename))
		{$fld_name=$rename[$fld];}
	
	if($fld=="date_job_order")
		{
		echo "<td bgcolor='beige'>
		<table>";
		if(empty(${$fld}))
			{
			$value=date("Y-m-d");
			${$fld}=$value;
			}
		
		}
		
	$size="";	
	if(array_key_exists($fld, $hard_wired))
		{
		@$value=$hard_wired[$fld];
		}
		else
		{
		@$value=${$fld};
		}
		
	if($fld=="billing_contact")
		{
		$billing_contact=$value;
		$billing_phone=$hard_wired["billing_phone"];
		$billing_fax=$hard_wired["billing_fax"];
		echo "<tr><td>$fld_name</td>
		<td><input type='text' name='billing_contact' value='$billing_contact'> Billing Phone <input type='text' name='billing_phone' value='$billing_phone'> Billing Fax <input type='text' name='billing_fax' value='$billing_fax'></td>
		</tr>";
		continue;
		}
		
	if($fld=="hr_contact")
		{
		$hr_contact=$value;
		$hr_phone=$hard_wired["hr_phone"];
		$hr_fax=$hard_wired["hr_fax"];
		echo "<tr><td>$fld_name</td>
		<td><input type='text' name='hr_contact' value='$hr_contact'> HR Phone <input type='text' name='hr_phone' value='$hr_phone'> HR Fax <input type='text' name='hr_fax' value='$hr_fax'></td>
		</tr>";
		continue;
		}
		
	if($fld=="address")
		{
		@$value=$pass_address;
		}
	if($fld=="division")
		{
		$skip_unit=array("WOED");
		$parkCodeName['ARCH']="Nature Research Center";
		echo "<tr><td>$fld_name</td>
		<td><select name='$fld'><option value='' selected></option>\n";
		foreach($parkCodeName as $k=>$v)
			{
			if(in_array($k,$skip_unit)){continue;}
			if($division==$k){$s="selected";}else{$s="";}
			echo "<option value=\"$k\" $s>$v</option>\n";
			}
		echo "</select></td></tr>";
		continue;
		}
		
	if($fld=="email_account")
		{
		if(@${$fld}=="Y"){$cky="checked";$ckn="";}else{$ckn="checked";$cky="";}
		echo "<tr><td>$fld_name</td>
		<td><input type='radio' name='$fld' value='Y' $cky>Y <input type='radio' name='$fld' value='N' $ckn>N";
		echo "</td></tr>";
		continue;
		}
	$input_id=$fld;
	if($fld=="start_date")
		{
		$input_id="datepicker1";
		@$date1=str_replace("-",",",$start_date);
		@$date2=str_replace("-",",",$end_date);
		?>
		
		<script>
			var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
			var date1="<?php echo "$date1";?>";
			var date2="<?php echo "$date2";?>";
			var firstDate = new Date(date1);
			var secondDate = new Date(date2);

			var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			var months = (diffDays/30).toFixed(1);
			
		</script>
		
		<?php
		}
	if($fld=="end_date")
		{
		$input_id="datepicker2";
		?><script>
		z="number of days = " + diffDays + " (months = " + months + ")";
		</script>
		<?php
		}
	if($fld=="job_title")
		{
		 echo "<tr><td>$fld_name <input type=\"button\" value=\"List of Job Titles/Rates/Descriptions\" onClick=\"return popitup('job_desc.php?park_code=$division')\"></td><td><input id='$input_id' type='text' name='$fld' value=\"$value\" size='55'></td></tr>";
		 continue;
		}
		
	if($fld=="job_description")
		{
		if(!empty($billing_rate))
			{
			$exp=explode("-",$job_description);
			$exp1=explode(",",$exp[0]);
			$num=count($exp1);
			$weekly_cost=number_format($billing_rate*$work_hours*$num,2);
			$sum_position=($num==1?"1 position":$num." positions");
			}
			else
			{
			$weekly_cost="";
			$sum_position="";
			}
		$tot_cost="<br />Cost per week for $sum_position: <input type='text' name='cost_week' value='$weekly_cost' readonly>";
		echo "<tr><td>$fld_name<td><textarea name=$fld cols='95' rows='5'>$value</textarea> $tot_cost</td></tr>";
		continue;
		}
		
	$size="size='30'";
	if(array_key_exists($fld,$td_size)){$size="size='".$td_size[$fld]."'";}
	if(in_array($fld,$readonly)){$ro="readonly";}else{$ro="";}
	
	echo "<tr><td>$fld_name</td><td><input id='$input_id' type='text' name='$fld' value=\"$value\" $size $ro>";
	if($fld=="end_date")
		{
		echo " - ";
		?>
		<script>document.write(z);</script>
		<?php
		}
	
	echo "</td></tr>";
	
	}
echo "<tr><td colspan='2'>";

if(!empty($id))
	{echo "<input type='hidden' name='id' value='$id'>";}

	echo "
	<input type='submit' name='submit' value='Submit'>";
	
echo "</td></tr></table></td>

</tr></table>";

echo "</td></tr></table></form>";

if(!empty($id) and !empty($job_title))
	{
	echo "<table align='center' bgcolor='yellow'>
	<tr><td><a href='ts_form_pdf.php?id=$id'>Produce PDF</a></td></tr>
	</table>";
	}

echo "</fieldset>
</body1>";


echo "<instructions>&nbsp;<font color='red'>Completing the Temporary Solutions Job Request Form - </font><a onclick=\"toggleDisplay('instruction');\" href=\"javascript:void('')\">
Click for Instructions</a>
      <div id=\"instruction\" style=\"display: none; padding:7px;\">
You must respond to each item listed below to successfully submit your Job Request.  For incomplete response(s), you will be prompted to complete before proceeding.<br />
Instructions:<br />
1.
2.
3.
4.
5.

Click the \"Instructions\" link to hide them.
         </div> </instructions>";


echo "</body></html>";
?>