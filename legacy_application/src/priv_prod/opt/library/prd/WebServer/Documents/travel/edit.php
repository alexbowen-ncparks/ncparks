<?php
//echo "Hello edit";
if(empty($connection))
	{
// 	include("../../include/get_parkcodes_reg.php");// database connection parameters
	include("../../include/get_parkcodes_dist.php");// database connection parameters
// 	echo "<pre>"; print_r($region); echo "</pre>";  exit;
// 	include("../../include/iConnect.inc");// database connection parameters
	$database="travel";
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database $database");
	}
//        extract($_REQUEST);
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
 if(@$del=="y")
       		{
			$sql = "SELECT $fld FROM tal where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
			$row=mysqli_fetch_assoc($result);
			unlink($row[$fld]);
			$sql = "UPDATE tal set $fld='' where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
//echo "$sql"; exit;			
       			header("Location:edit.php?edit=$id&submit=edit");
       		exit;
       		}
       		
include("menu.php");

//   echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
   if(@$_POST['submit']=="Delete")
		{
		$sql = "DELETE FROM tal where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		echo "Record was successfully deleted.";exit;
		}
       
   if(@$_POST['submit']=="Update")
		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		$skip1=array("year","month","day","submit","id");
		$skip2=array("submit","id");
		if(!key_exists("category",$_POST))
			{$blank_cat=", category=''";}
			else
			{$blank_cat="";}
			
		foreach($_POST AS $num=>$array)
			{
			$test=explode("-",$num);
			if(in_array($test[0],$skip1)){continue;}
			if($num=="tadpr"){$pass_tadpr=$array;}
			
			if($num=="category")
				{
				foreach($array as $ind1=>$val1)
					{
					$val1=str_pad($val1,2,"0",STR_PAD_LEFT);
					@$value1.=$val1.",";
					}
					
				$array=rtrim($value1,",");
				$value1="";
				}
				
			// menu.php has the javascript that controls calendars				
			$date_array=array("date_from"=>'1',"date_to"=>'2',"approv_OPS"=>'3',"approv_DPR_BO"=>'4',"approv_DIR"=>'5',"to_BPA"=>'6',"approv_BPA"=>'7',"staff_notify"=>'8');
			$temp="";
			//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;			
			foreach($_POST AS $k=>$v)
				{
				if(in_array($k,$skip2))
				{continue;}
				foreach($date_array as $k1=>$v1)
					{
					if($k=="year-field".$v1)
						{$temp=$k1."='".$v."-";}
					if($k=="month-field".$v1)
						{$temp.=$v."-";}
					if($k=="day-field".$v1)
						{$temp.=$v."',";}
						
					@$clause.=$temp; 
					$temp="";
					}
				}
				// if($num=="purpose"){$array=addslashes($array);}
// 				if($num=="comments"){$array=addslashes($array);}
				$clause.=$num."='".$array."',";
			}
				
				$id=$_POST['id'];
				$clause="set ".rtrim($clause,",")." $blank_cat where id='$id'";
		$sql = "Update tal $clause";
//echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
		$clause="";
				
			// ****** uploads
			include("upload_code.php");
			
		$edit=$id;
		$message="<td><font color='purple'>Update was successful.</font></td>";
		}
       
$display_fields="*";

if(@$edit)
	{
			if($level<2)
				{
				$limit_park=$_SESSION['travel']['select'];
					if($_SESSION['travel']['accessPark'] != "")
						{
						$limit_park=$_SESSION['travel']['accessPark'];
						}
				$lp=explode(",",$limit_park);
				foreach($lp as $k=>$v)
					{
					@$clause1.=" location='$v' OR ";
					$clause1.=" purpose like '%$v%' OR ";
					}
					$clause1=rtrim($clause1," OR ");
					@$clause.=" AND (".$clause1.")";
				}
	if(!isset($clause)){$clause="";}
	$sql = "SELECT $display_fields FROM tal as t1 
	WHERE  id='$edit' $clause
	"; 
// 	echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
	
	while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
	}

	$sql = "SELECT * FROM category as t1 
	WHERE  1 order by id_sort";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$category_array[$row['name']]=$row['id_string'];
		}
	
echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

if(@$edit)
	{$action="edit.php";}else{$action="add_request.php";}

echo "<form method='POST' name='contactForm' action='$action' enctype='multipart/form-data'>";

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";

$skip=array("id","TA","justification","register","response","other_file_1","other_file_2","to_BPA", "staff_notify");

// added tom_20221216
// fields to be hidden in new form
$skip_new_request_form=array("region","category","approv_OPS","approv_DPR_BO","approv_DIR","approv_BPA","pending_BPA","comments");
$skip=array_merge($skip,$skip_new_request_form);
// end tom

$checkbox=array("category");
$read_only=array("tadpr");

// menu.php has the javascript that controls calendars
if($level==1)
	{
	$date_array=array("date_from"=>'1',"date_to"=>'2');	$read_only=array("id","tadpr","approv_OPS","approv_DPR_BO","approv_DIR","to_BPA","pending_BPA","approv_BPA","staff_notify");
	}
if($level==2)
	{
	$date_array=array("date_from"=>'1',"date_to"=>'2',"approv_OPS"=>'3');	$read_only=array("id","tadpr","approv_DPR_BO","approv_DIR","to_BPA","pending_BPA","approv_BPA","staff_notify");
	}
if($level>2)
	{	$date_array=array("date_from"=>'1',"date_to"=>'2',"approv_OPS"=>'3',"approv_DPR_BO"=>'4',"approv_DIR"=>'5',"to_BPA"=>'6',"approv_BPA"=>'7',"staff_notify"=>'8');
	}

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	
	foreach($ARRAY as $num=>$row)
		{ 
			foreach($row as $fld=>$value)
				{
					
					if(in_array($fld,$skip)){continue;}
						if(@$edit=="")
							{
							$value="";
							if($fld=="tadpr")
								{								
								$sql = "SELECT $fld FROM tal
								WHERE 1 order by id desc limit 1
								";
// 								echo "$sql";
								$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
								$row=mysqli_fetch_assoc($result);
								$value=$row[$fld];								$value="TA_".date('Y')."_".str_pad((substr($value,-4)+1),4,0,STR_PAD_LEFT);
								$pass_tadpr=$value;
								}
							}
											
					if(in_array($fld,$read_only)){$RO="readonly";}else{$RO="";}
					
					$rename=$fld;
					if($fld=="location")
						{
						$rename="4-letter park code or section name";
						$pass_location=$value;
						}
					if($fld=="tadpr")
						{
						$rename="Tracking Authorization #";
						}
					if($fld=="pending_BPA")
						{
						$rename="Status";
						}
					if($fld=="approv_BPA")
						{
						$rename="Final Approval";
						}
					if($fld=="approv_OPS")
						{
						$rename="DISU Approval";
						$forward="BO Approval";
						}
					if($fld=="approv_DIR")
						{
						$rename="approv_DPR_BO_DIR";
						}
					if($fld=="approv_DPR_BO")
						{
						$rename="Supervisor_approve";
						$forward="BO Approval";
						}
					if($fld=="to_BPA")
						{
						$forward="BPA Approval";
						}

					if($fld=="approv_BPA")
						{
						$forward="Staff Notification";
						@$to_address=$row['email'];
						}
						
					echo " <tr valign='top'><td align='right'>$rename</td>";
					
					if($fld=="tadpr")
						{$pass_tadpr=$value;}
						
					if($fld=="amount")
						{
						$pass_amount=$value;
						$explain="Do not enter a $ sign.";
						}else{$explain="";}
					
					$item="<input type='text' name='$fld' value=\"$value\" size='37'$RO> $explain";
						
					if($fld=="district")
						{
						$dist_array=array("EADI","NODI","SODI","WEDI","STWD");
						$item="<select name='district'><option selected=''></option>";
						foreach($dist_array as $da_key=>$da_value)
							{
							if($value==$da_value)
								{
								$pass_dist=$value;
								$s="selected";}else{$s="value";}
							$item.="<option $s='$da_value'>$da_value</option>";
							}
						$item.="</select>";
						}
					
// 					if($fld=="region")
// 						{
// 						$reg_array=array("CORE","PIRE","MORE","STWD");
// 						$item="<select name='region'><option selected=''></option>";
// 						foreach($reg_array as $da_key=>$da_value)
// 							{
// 							if($value==$da_value)
// 								{
// 								$pass_reg=$value;
// 								$s="selected";}else{$s="value";}
// 							$item.="<option $s='$da_value'>$da_value</option>";
// 							}
// 						$item.="</select>";
// 						}
							
					if($fld=="purpose")
						{
						$d="block";
				// commented our tom_20221216
// 						$item="<div id=\"$fld\">   ... <a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'></font></div>
// 							<div id=\"fieldDetails[$fld]\" style=\"display: $d\"><br><textarea name='$fld' cols='55' rows='4'>$value</textarea><br />";
							
		// mod tom_20221216  removed the purpose textarea
						$item="<div>";
						include("uploads.php");
							echo "</div>";
						
						}
								
					if($fld=="comments")
						{
						if($value){$d="block";}else{$d="none";}
						//$related
						$item="<div id=\"$fld\">   ... <a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'></font></div>
	
						<div id=\"fieldDetails[$fld]\" style=\"display: $d\"><br><textarea name='$fld' cols='55' rows='15'>$value</textarea></div>";
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
								echo "<td><input type='checkbox' name='$fa' value='$ck_value'$ck>$ck_fld ";
								if(fmod(($i+1),3)==0)
									{echo "</tr><tr>";}
									$i++;
								}
							echo "</tr></table></td></tr>";
							continue;
						}
					
					if(array_key_exists($fld,$date_array))
						{
						if($value!="0000-00-00")
							{
							$var_df=explode("-",$value);
							$var_yf=$var_df[0];
							@$var_mf=$var_df[1];
							@$var_df=$var_df[2];
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
						@$subject="$pass_dist $pass_location Request for Travel Authorization $pass_tadpr -  Amount: $pass_amount";
						
						if($fld=="approv_BPA")
							{}
							else
							{$to_address="";}
						if($level>1 AND $fld=="approv_OPS")
							{
							$to_address="angela.boggus@ncparks.gov";
							}
						
						if($level>1 AND $fld=="approv_DPR_BO")
							{
							$to_address="angela.boggus@ncparks.gov";
							}
							
						if(!isset($forward)){$forward="";}
						if(!isset($edit)){$edit="";}
						$email_to="&nbsp;&nbsp;&nbsp;<font color='green'>Email for $forward: </font><a href='mailto:$to_address?subject=$subject&body=/travel/edit.php?edit=$edit&submit=edit'>email</a>";
						$email_to="&nbsp;&nbsp;&nbsp;<font color='green'>Email for $forward: </font><a href='mailto:$to_address?subject=$subject&body=/travel/edit.php?edit=$edit&submit=edit'>email</a>";
						if($fld=="date_from"||$fld=="date_to"||$fld=="approv_DIR")
							{
							$email_to="";
							}
						
							
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
					if($value=="Approved")
						{$radio_app="checked";}else{$radio_app="";}
					if($value=="Not Approved")
						{$radio_not_app="checked";}else{$radio_not_app="";}
					if($value=="Pending")
						{$radio_pending="checked";}else{$radio_pending="";}
					$item="<input type='radio' name='$fld' value=\"Approved\"$RO $radio_app><font color='green'>Approved</font> <input type='radio' name='$fld' value=\"Not Approved\"$RO $radio_not_app><font color='red'>Not Approved</font> <input type='radio' name='$fld' value=\"Pending\"$RO $radio_pending>Pending";
					}
				
				if($fld=="approv_OPS" and $level<2)
					{
					$pass_OPS=$value;
					$notice="<br />Any TA approved by OPS cannot be edited or deleted.<br />Contact the CHOP office for details.";
					}
				if($fld=="approv_OPS" and $level>1)
					{
					$item="<marquee width='80%'>RESU MUST click the Update button after entering a date.</marquee>".$item;
					}
							
				echo "<td>$item</td></tr>";
				
				
				
				if($fld=="comments"){echo "</table></td><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";}
								
				}
		}
		
	if(@$message==1)
		{
		$message="<td>Your request has been entered.<br />Review for completeness/correctness.</td>";
		}
	
	if(@$edit){$action="Update";}else{$action="Submit";}
	
if(!isset($notice)){$notice="";}
if(!isset($pass_OPS)){$pass_OPS="";}
if(!isset($message)){$message="";}
echo "<tr><th colspan='3'>$action Travel Request $notice</th></tr>";
if($pass_OPS=="" OR $pass_OPS=="0000-00-00" OR $level>2)
	{
		echo "<tr><td align='center'>
		<input type='submit' name='submit' value='$action'>
		</td>
		$message $pass_OPS";
		if($action=="Update")
			{echo "<td>
			<input type='hidden' name='id' value='$edit'>
			<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td>";
			}
		echo "</tr>";
	}
	echo "</table></td></tr>";
	echo "</table></form></html>";

?>