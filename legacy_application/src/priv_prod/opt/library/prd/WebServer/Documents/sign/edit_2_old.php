<?php
$database="sign";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

extract($_REQUEST);
      
if($_POST['submit']=="Submit")
	{
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	$skip1=array("year","month","day","submit","id","category_standard");
	$skip2=array("submit","id");
	if($_POST['category_standard']!="")
		{
		$_POST['category']=$_POST['category_standard'];
		}
		foreach($_POST AS $k=>$v)
			{
		if(in_array($k,$skip1) OR $v=="")
			{continue;}
		
		$test=explode("-",$k);
		if(in_array($test[0],$skip1)){continue;}
		
		if($k=="dpr"){$pass_dpr=$v;}
		if($k=="PASU_approv")
			{
			foreach($v as $ind1=>$val1)
				{
				$value1.=$val1.",";
				}
			$v=rtrim($value1,",");
			$value1="";
		
			}
	//	$v=mysql_real_escape_string($v);				
		$clause.=$k."='".$v."',";
		}

// menu.php has the javascript that controls calendars - calendar(x)
	$date_array=array("date_needed"=>'2',"approv_PASU"=>'3',"approv_DISU"=>'4',"approv_PIO"=>'5',"approv_CHOP_DIR"=>'6',"approv_BPA"=>'7',"staff_notify"=>'8');
		
	foreach($_POST AS $k=>$v)
			{
		if(in_array($k,$skip2) OR $v=="")
			{continue;}
		foreach($date_array as $k1=>$v1)
			{
			if($k=="year-field".$v1)
				{$temp=$k1."='".$v."-";}
			if($k=="month-field".$v1)
				{$temp.=$v."-";}
			if($k=="day-field".$v1)
				{$temp.=$v."',";}
				
			$clause.=$temp; $temp="";
			}
		}
		
		$clause="set ".rtrim($clause,",");
	$sql = "UPDATE sign_list_1 $clause WHERE id='$id'";
//echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection"); 
	$clause="";
	
	// ****** uploads
	include("upload_code.php");
	//exit;
	
	}
       		
include("menu.php");


	$sql = "SELECT * FROM sign_list_1
	WHERE id='$id'";// echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
		while($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
	
	$sql = "SELECT * FROM status as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
	if(mysql_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysql_fetch_assoc($result))
		{
		$status_array[$row['name']]=$row['name'];
		}
	
	$sql = "SELECT * FROM new_replace as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
	if(mysql_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysql_fetch_assoc($result))
			{$new_replace_array[$row['name']]=$row['name'];}
			
	
	$sql = "SELECT * FROM sign_type as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
	if(mysql_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysql_fetch_assoc($result))
		{
		$sign_type_array[$row['name']]=$row['name'];
		}	
		
	$sql = "SELECT * FROM district as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
	if(mysql_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysql_fetch_assoc($result))
		{
		$district_array[$row['name']]=$row['name'];
		}	
	
		
	$source_array=array("DPR Sign Shop"=>"DPR Sign Shop","Outside Vendor"=>"Outside Vendor");
		
		
echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

echo "<form method='POST' name='contactForm' action='update_1.php' enctype='multipart/form-data'>";

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";

echo "<h2>Sign Request for <font color='blue'>Non-standard Sign</font></h2>";

$skip=array("id","SR","justification","register","response","other_file_1","other_file_2","other_file_3","other_file_4","cr_form","outside_vendor_details","pio_comment");
$checkbox=array("PASU_approv");
$PASU_approv_array=array("y");
$radio=array("category","sign_type","status","new_replace","source");
$pull_down=array("district");

$read_only=array("dpr","date_of_request",);

// menu.php has the javascript that controls calendars
if($level==1)
	{
	$access=$_SESSION['sign']['accessPark'];
	$location_array=explode(",",$access);
	$park_count=count($location_array);
	if($park_count>1){$pull_down[]="location";}
	$read_only=array("location","id","dpr","approv_DISU","approv_CHOP_DIR","approv_PIO","pending_BPA","approv_BPA","staff_notify","requested_by","date_of_request","status");
	}
if($level==2)
	{
	$date_array=array("approv_DISU"=>'4',);	//,"approv_PASU"=>'3'
	$read_only=array("id","dpr","approv_CHOP_DIR","approv_PIO","pending_BPA","approv_BPA","staff_notify","requested_by","date_of_request","status");
	}
if($level>2)
	{
	//"date_needed"=>'2',"approv_PASU"=>'3',
	$date_array=array("approv_DISU"=>'4',"approv_CHOP_DIR"=>'5',"approv_PIO"=>'6',"approv_BPA"=>'7',"staff_notify"=>'8'); $read_only=array("requested_by","date_of_request","dpr");
	}


$skip_1=array("id","SR","category","justification","register","response","other_file_1","other_file_2","other_file_3","other_file_4","cr_form","outside_vendor_details","pio_comment");

	foreach($ARRAY as $num=>$row)
		{ 
		foreach($row as $fld=>$value)
			{
				
				if(in_array($fld,$skip_1)){continue;}
								
				if(in_array($fld,$read_only))
					{
					if($fld=="status"){$RO="disabled";}else{$RO="readonly";}
					}
					else
					{
					$RO="";
					}
				
				$rename=$fld;
				$explain="";//	$explain="Do not enter a $ sign.";
				if($fld=="location")
					{
					$rename="4-letter park code<br />or section name";
					if($level==1){$value=$_SESSION['sign']['select'];}
					$pass_location=$value;
					}
				if($fld=="email")
					{
					$email=$value;
					}
				if($fld=="phone")
					{
					$explain="(area code and best phone# for contact)";
					}
				if($fld=="pending_BPA")
					{
					$rename="Status";
					}
				if($fld=="approv_BPA")
					{
					$rename="Received at sign shop";
					}
				if($fld=="purpose")
					{
					$rename="Description";
					}
					
				echo " <tr valign='top'><td align='right'>$rename</td>";
				
				if($fld=="dpr")
					{$pass_dpr=$value;}
					
				if($fld=="date_of_request")
					{
					if($value==""){$value=date("Y-m-d");}					
					}
				
				if($fld=="PASU_approv")
					{
					$explain="I'm indicating that I have the  approval of the Park Superintendent.";
					}
					
				if($fld=="requested_by")
					{$value=$_SESSION['sign']['tempID'];}
					
					
				$item="<input type='text' name='$fld' value=\"$value\" size='37'$RO> $explain";
					
				if(in_array($fld,$pull_down))
					{
					$pd_array=${$fld."_array"};
					$item="<select name='$fld'><option selected=''></option>";
					foreach($pd_array as $da_key=>$da_value)
						{
						if($value==$da_value)
							{
							if($fld=="district"){$pass_dist=$value;}
							$s="selected";}else{$s="value";}
						$item.="<option $s='$da_value'>$da_value</option>";
						}
					$item.="</select>";
					}
					
				if($fld=="purpose")
					{
				//	if($value){$d="block";}else{$d="none";}
					$d="block";
					$item="<div id=\"$fld\">   ... <a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'>$related</font></div>
						<div id=\"fieldDetails[$fld]\" style=\"display: $d\">
					<br />Enter the text that will appear on the sign (Not needed IF a \"Standard Sign\"). Provide any Special Instructions after the text.<br /><textarea name='$fld' cols='55' rows='4'>$value</textarea>PIO_comment<textarea name='pio_comment' cols='55' rows='2'>$pio_comment</textarea><br />";
//***********************					
					include("uploads.php");
						echo "</div>";
					
					}
							
				if($fld=="comments")
					{
					if($value){$d="block";}else{$d="none";}
					$item="<div id=\"$fld\">   ... <a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'>$related</font></div>

					<div id=\"fieldDetails[$fld]\" style=\"display: $d\"><br><textarea name='$fld' cols='55' rows='15'>$value</textarea></div>";
					}
							
				if($fld=="sign_size")
					{
					$item="<textarea name='$fld' cols='35' rows='1'>$value</textarea> Height and Width in inches";
					}			
				if($fld=="date_needed")
					{
					$item="<textarea name='$fld' cols='35' rows='1'>$value</textarea> Indicate how quickly the sign(s) are needed.";
					}		
				if($fld=="letter_size")
					{
					$item="<textarea name='$fld' cols='15' rows='1'>$value</textarea> in inches";
					}
				if(in_array($fld,$radio))
					{
					$rad=0;
					$ck_array=${$fld."_array"};
						$ck_db_value=$value;
						echo "<td><table><tr>";
						foreach($ck_array as $ck_fld=>$ck_value)
							{
							$rad++;
							$add_cat="";
							$add_vendor="";
							$add_direction="";
								if($ck_value=="3" AND $fld=="category")
								{
								$add_cat="<select name='category_standard'>
								<option value=''></option>";									foreach($standard_sign_array as $k1=>$v1)
									{
									$k2="3.".$k1;
									$values=explode(".",$ck_db_value);						if($values[1]=="")
										{$s="value";}
										else
										{
										$ck_value=$values[0];
									//	echo "$values[1] ";
								if($values[1]==$k1)
										{$s="selected";}else{$s="value";}
										}
									$add_cat.="<option $s=\"$k2\">$k2</option>";
										
									}
									$ck_db_value=$values[0];
								$add_cat.="</select></td>";									}
								
								if($ck_value=="Outside Vendor" AND $fld=="source")
									{
									$value=$row['outside_vendor_details'];
									$add_vendor=" <textarea name='outside_vendor_details' cols='70' rows='5'>$value</textarea> Enter Details and Justification";
									}
								
								if($ck_value=="5" AND $fld=="category")
									{
									$add_direction="  [<font color='red'>Sketch upload is required.</font> Designate direction arrow points using: N (straight ahead), S (straight back), E (go right), W (go left), NE (angle ahead to right),SE,SW,NW in purpose description w/text, e.g., \"New Trail (ARROW POINT E)\"] - (no approval required)";
									}
							if($ck_db_value==$ck_value)
								{$ck="checked";}else{$ck="";}
							echo "<tr><td colspan='3' align='top'>$rad. <input type='radio' name='$fld' value=\"$ck_value\"$ck $RO>$ck_fld $add_cat $add_vendor $add_direction</td></tr>";
							
							if($ck_value=="1" AND $fld=="category")
								{
								echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type='checkbox' name='cr_form' value='$row[cr_form]'><font color='brown'>I have obtained a Construction Renovation permit for the Park Entrance Sign.</font></td></tr>";									}
							}
						echo "</table></td></tr>";
						continue;
					}
					
				if(in_array($fld,$checkbox))
					{	
						$ck_array=${$fld."_array"};
						$ck_db_value=explode(",",$value);
						echo "<td><table><tr>";
						$i=0;
						foreach($ck_array as $ck_fld=>$ck_value)
							{
							$fa=$fld."[]";
							if(in_array($ck_value,$ck_db_value))
								{$ck="checked";}else{$ck="";}
							echo "<td><input type='checkbox' name='$fa' value=\"$ck_value\"$ck> $explain";
							if(fmod(($i+1),3)==0)
								{echo "</tr><tr>";}
								$i++;
							}
						echo "</tr></table></td></tr>";
						continue;
					}
				
				if(@array_key_exists($fld,$date_array))
					{
					if($value!="0000-00-00")
						{
						$var_df=explode("-",$value);
						$var_yf=$var_df[0];
						$var_mf=$var_df[1];
						$var_df=$var_df[2];
						$var_check="";
						}
						else
						{
						$var_yf="";
						$var_mf="";
						$var_df="";
						$var_check="n/a <input type='checkbox' name='' value='' checked>";
						}
						
					$i=$date_array[$fld];
					$date_field="datefields".$i;
					$year_field="year-field".$i;
					$month_field="month-field".$i;
					$day_field="day-field".$i;
					$subject="$pass_dist $pass_location Request for Sign Authorization $pass_dpr";
					$body="Link to sign request $pass_dpr: http://149.168.1.197/sign/edit.php?edit=$edit&submit=edit You will need to login to the Sign Database if requested.";
					$mailto="";
					if($fld=="staff_notify"){$mailto=$email;}
					$email_to="&nbsp;&nbsp;&nbsp;<font color='green'>Email from $fld: </font><a href=\"mailto:$mailto?subject=$subject&body=$body\">email</a>";
					if($fld=="approv_BPA")
					{$email_to="";}
					//||$fld=="date_needed"
					$item="<div><span id=\"$date_field\" class=\"fromdate\">
						<label for=\"year-field\">
						$var_check 
						Year: </label><input id=\"$year_field\" type=\"text\" name=\"$year_field\" value=\"$var_yf\" style=\"width: 4em;\">
						<label for=\"month-field\">Month: </label><input id=\"$month_field\" type=\"text\" name=\"$month_field\" value=\"$var_mf\"style=\"width: 2em;\">
						<label for=\"day-field\">Day: </label><input id=\"$day_field\" type=\"text\" name=\"$day_field\" value=\"$var_df\"style=\"width: 2em;\">
							</span>$email_to</div>";
					}
					
			if($fld=="pending_BPA")
				{
				if($level<4){$RO=" disabled";}
				if($value=="Completed"){$radio_app="checked";}
				if($value=="Pending"){$radio_pending="checked";}
				$item="<input type='radio' name='$fld' value=\"Pending\"$RO $radio_pending>Pending <input type='radio' name='$fld' value=\"Completed\"$RO $radio_app><font color='green'>Completed</font> ";
				}
				
			echo "<td>$item</td></tr>";
	//		if($fld=="comments"){echo "</table></td><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";}
							
			}
		}
		
	if($message==1){$message="<tr><td colspan='2'>Your request has been entered.<br />Review for completeness/correctness.</td></tr>";}
	
	echo "<tr><th colspan='3'>Update Sign Request</th></tr>
	<tr><td align='center' colspan='2'>
		<input type='hidden' name='pass_category' value='2'>
		<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='Update'>
	</td>";
	echo "<td>
		<input type='hidden' name='id' value='$id'>
		<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td>";
		
	echo "</tr>
	$message";
	echo "</table></td></tr></form>";
	
	$page="http://149.168.1.196/sign/print_report_single.php";
		//if($level>3){$page="http://149.168.1.196/annual_report/print_report_uni.php";}
		echo "<tr bgcolor='white'><td align='center'><form method='POST' action='$page'>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Print'></form></td></tr></table></html>";

?>