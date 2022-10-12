<?php
//echo "2<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "2<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

echo "<form method='POST' action='hiring_form.php'>";
echo "<input type='hidden' name='beacon_num' value=\"$var\">";
echo "<table>";

$working_title=$position_array[$var]['working_title'];
if(empty($working_title)){$working_title="<font color='red'>No working title has been entered into the Position table.</font>";}
echo "<tr><td>Working Title: <font color='blue'><b>$working_title</b></font></td>";
$beacon_title=$position_array[$var]['beacon_title'];
if(empty($beacon_title)){$beacon_title="<font color='red'>The official position title has not been entered into the Position table.</font>";}
echo "<td>Classification: <font color='blue'><b>$beacon_title</b></font></td>";

$code=$position_array[$var]['code'];
if(empty($code)){$code="<font color='red'>The location code has not been entered into the Position table.</font>";}
echo "<td>Location: <font color='blue'><b>$code</b></font></td>";

if(!isset($supervisor)){$supervisor="";}
echo "<td>Supervisor: <input type='text' id='supervisor' name='supervisor' value=\"$supervisor\" size='84' required></td></tr>";
echo "</table><hr />";

if(!isset($pass_version))
	{
	$sql = "SELECT version as pass_version From hiring_actions
	WHERE 1 
	ORDER by version desc
	limit 1";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	}
$sql = "SELECT * FROM hiring_actions where version='$pass_version' order by action_id";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$summary_days[$row['action_id']]=$row['days'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$skip=array("id","days");

if(empty($bus_days))
	{$bus_days=5;}
	else
	{
	IF($completed_date_4=="0000-00-00")
		{
		if(!empty($_REQUEST['bus_days']))
			{$bus_days=$_REQUEST['bus_days'];}
		}
	$ARRAY[10]['days']=$bus_days;
	}
//echo "$bus_days<pre>";   print_r($ARRAY); echo "</pre>"; // exit;
	if(!empty($process_complete))
		{
		echo "<a onclick=\"toggleDisplay('show_data');\" href=\"javascript:void('')\">Show / Hide Details</a>";
		echo "<div id=\"show_data\" style=\"display: none\">";
		}	
echo "<table cellpadding='2'>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$fld=ucwords($fld);
			echo "<th>$fld</th>";
			}
		echo "<th>Target Date</th>";
		echo "<th>Completed Date</th>";
		echo "<th>Signature</th>";
		echo "<th>Bus. Days + -</th>";
		echo "</tr>";
		}
		
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$td="";
		if(in_array($fld,$skip)){continue;}
		if($array['action_id']>98){continue;}
		
		if($array['action_id']==5.0)
			{$value=str_replace("5 BD",$bus_days." BD", $value);}
		$display_value="<b>".$value."</b>";
		if($array['action_id']==3.6 and $fld=="action")
			{
			$display_value.=" <input type='text' name='bus_days' value=\"$bus_days\" size='3' onchange=\"this.form.submit()\">";
			}
			if(!empty($_REQUEST['target_date']))
				{$target_date=@$_REQUEST['target_date'];}
			
			$log_emid=$_SESSION['logemid'];
		if($array['action_id']==1.0 and $fld=="action")
			{
			if(!empty($pass_target_date_0) and empty($target_date)){$target_date=$pass_target_date_0;}
			if(!empty($completed_date_0)){$cd_0=$completed_date_0;}else{$cd_0="";}
			if(empty($target_date)){$target_date=date('Y-m-d');}
			$num=round($array['action_id'])-1;
			@$sig_val=${"signature_".$num};
			if(empty($sig_val))
				{
				$sig_val=substr($_SESSION['logname'],0,-3);
				}
			if(empty($pass_id))
				{$ro=""; $dp="datepicker0";}
				else
				{$ro="readonly";$dp="readonly";}
			$display_value.="</td><td><input type='text' id='$dp' name='target_date' value=\"$target_date\" onchange=\"this.form.submit()\" $ro>
		<input type='hidden' name='pass_action[]' value='$value'>
			<input type='hidden' name='pass_target_date[]' value='$target_date'>";
			
			if(@$completed_date_2=="0000-00-00" or @$completed_date_2=="")
				{$ro=""; $dp="datepicker1";}
				else
				{$ro="readonly";$dp="readonly";}
			$display_value.="</td><td><input type='text' id='$dp' name='completed_date[]' value=\"$cd_0\" $ro>";
			
			$display_value.="</td><td><input type='text' name='signature[]' value=\"$sig_val\" size='15' readonly>";
			
			}
			else  //*****************
			{
			$td="";
			if($fld=="action")
				{
				if(fmod($array['action_id'],1)!=0.0)
					{
					$display_value="&nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;".$display_value;
					}
					else
					{
					$day_count=$array['days'];
					$num_days=$array['days']." days";
			//		echo "t=$target_date d=$display_target_date"; EXIT;
					include("hiring_form_dates.php");   // ***********
			$var_id="datepicker".($index+2);
			$exp=explode("-",$display_target_date);
			$dtd=date("D. M. j, Y", mktime(0,0,0, $exp[1], $exp[2], $exp[0]));
			$display_value.="</td><td>$dtd ";
			$display_value.="<input type='hidden' name='pass_target_date[]' value='$display_target_date'>";
			$num=round($array['action_id'])-1;
			@$cd_val=${"completed_date_".$num};
			@$sig_val=${"signature_".$num};
			if($cd_val=="0000-00-00")
				{
				$sig_val=substr($_SESSION['logname'],0,-3);
				}
			
			@$next_cd_value=${"completed_date_".($num+1)};
			if($next_cd_value=="0000-00-00" or ($num+1)==12)
				{$ro=""; $dp=$var_id;}
				else
				{$ro="readonly";$dp="readonly";}
			if($level<3 and $index>1){$dp="readonly";$ro="readonly";} // readonly for parks and district
			$display_value.="</td><td><input type='text' id='$dp' name='completed_date[]' value=\"$cd_val\" $ro>";
			
			$display_value.="</td><td><input type='text' name='signature[]' value=\"$sig_val\" size='15' readonly>";
			
			if(!empty($cd_val) and $cd_val!="0000-00-00")
				{
				$act_days=days_target_complete($display_target_date,$cd_val);
				}
				else
				{$act_days="";}
		@$total_bds+=$act_days;
		$display_value.="<input type='hidden' name='pass_action[]' value='$value'> </td><td align='right'>".$act_days;
					}
				}
			}
		
		if($array['version']==1 and $index>0 and $fld=="version")
			{
			$display_value="";
			}
		if($fld=="action_id")
			{$td=" align='center'";}
		echo "<td$td>$display_value</td>";
		}
	echo "</tr>";
	}
if(!isset($total_bds)){$total_bds="";}
$color="black";
if($total_bds<0){$color="green";}
if($total_bds>0){$color='red';}
echo "<tr><td colspan='7' align='right'><font color='$color'><b>$total_bds</b></font></td></tr>";

if(!isset($hire_comments)){$hire_comments="";}
echo "<tr><td colspan='6' align='center'>Comments:
<textarea name='hire_comments' cols='99' rows='6'>$hire_comments</textarea>
</td></tr>";

echo "<tr><td colspan='5' align='center'>";
if(!empty($pass_id))
	{
	echo "<input type='hidden' name='pass_id' value=\"$pass_id\">";
	echo "<input type='hidden' name='tempID' value=\"$sig_val\">";
	}
if(!empty($pass_f_year))
	{
	echo "<input type='hidden' name='pass_f_year' value=\"$pass_f_year\">";
	}
if(!empty($pass_version))
	{
	echo "<input type='hidden' name='version' value=\"$pass_version\">";
	}
echo "<input type='submit' name='update' value=\"Update\">
</td></tr>";
echo "</table><hr />";



echo "<table cellpadding='2'>";
foreach($ARRAY AS $index=>$array)
	{
	if(@$array['action_id']<99){continue;}
	foreach($array as $k=>$v)
		{
		if($k!="action"){continue;}
		echo "<tr><td>$v</td></tr>";
		}
	}
echo "</table>";
echo "</form>";

?>