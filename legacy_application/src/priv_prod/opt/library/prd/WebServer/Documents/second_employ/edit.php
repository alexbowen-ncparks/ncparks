<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
if(@$_REQUEST['submit']=="Create Request Form")
	{
	$database="second_employ";
	include("../../include/iConnect.inc");// database connection parameters
	$db = mysqli_select_db($connection,$database);
//	echo "<pre>"; print_r($_POST); echo "</pre>";
	$skip1=array("year","month","day","submit","id");
		$skip2=array("submit","id");
		foreach($_POST AS $num=>$array)
			{
			$test=explode("-",$num);
			if(in_array($test[0],$skip1)){continue;}
			if($num=="se_dpr"){$pass_se_dpr=$array;}
					
			
		//	$array=addslashes($array);
			@$clause.=$num."='".$array."',";
			}
		$id=$_POST['id'];
		$clause="set ".rtrim($clause,",")." where id='$id'";
		$sql = "Update se_list $clause";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection)); 
	header("Location: pre_pdf.php?id=$_REQUEST[id]");
	exit;
	}
	
if(!isset($connection))
	{
	$database="second_employ";
	include("../../include/iConnect.inc");// database connection parameters
	extract($_REQUEST);
	}


$db = mysqli_select_db($connection,'divper')
       or die ("Couldn't select database $database");
$sql = "SELECT distinct code FROM position where 1 order by code";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$parkCode[]=$row['code'];
	}
$sql = "SELECT t1.email 
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where 1 and t2.beacon_num='60033136'";  // Bev Blue position
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$hr_email=$row['email'];
	}

$sql = "SELECT t1.email, t3.beacon_num
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where 1 and t2.beacon_num='60033018' or t2.beacon_num='60033148'";  // Adrian O'Neal and Pacita Grimes positions
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$chop_email_array[$row['beacon_num']]=$row['email'];
	}

$sql = "SELECT t1.email, t3.beacon_num
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where 1 and t2.beacon_num='60032778' or t2.beacon_num='60033202'";  // Director and Deput Deputy Directory positions
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$dir_email_array[$row['beacon_num']]=$row['email'];
	}
				
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       extract($_REQUEST);
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
 if(@$del=="y")
       		{
       		echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
			$sql = "SELECT $fld FROM se_list where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
			$row=mysqli_fetch_assoc($result);
			unlink($row[$fld]);
			$sql = "UPDATE se_list set $fld='' where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
//echo "$sql"; exit;			
       			header("Location:edit.php?edit=$id&submit=edit");
       		exit;
       		}

 if(@$act=="del")
       		{
       	//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
			$sql = "SELECT link FROM upload_final where final_id='$edit'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); $row=mysqli_fetch_assoc($result);
			unlink($row['link']);
			$sql = "DELETE FROM upload_final where final_id='$edit'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
//echo "$sql"; //exit;	
       		}
       		    		
include("menu.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$working_title=$_SESSION['second_employ']['working_title'];
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
   if(@$_POST['submit']=="Delete")
		{
		$sql = "SELECT `request` FROM se_list where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); $row=mysqli_fetch_assoc($result);
			@unlink($row['request']);
			$sql = "UPDATE se_list set `request`='' where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
			
		$sql = "DELETE FROM se_list where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		echo "Record was successfully deleted.";exit;
		}
       
if(@$_POST['submit']=="Update")
		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		$skip1=array("year","month","day","submit","id");
		$skip2=array("submit","id");
			foreach($_POST AS $num=>$array)
				{
			$test=explode("-",$num);
			if(in_array($test[0],$skip1)){continue;}
			if($num=="se_dpr"){$pass_se_dpr=$array;}
			
							
		// menu.php has the javascript that controls calendars				
		$date_array=array("notify_supervisor"=>'1',"supervisor_approval"=>'2',"PASU_approval"=>'3',"DISU_approval"=>'4',"CHOP_approval"=>'5',"HR_approval"=>'6',"Director_approval"=>'7',"staff_notify"=>'8');
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
							
						@$clause.=$temp; $temp="";
						}
					}
			//	$array=addslashes($array);
				$clause.=$num."='".$array."',";
				}
						$id=$_POST['id'];
				$clause="set ".rtrim($clause,",")." where id='$id'";
		$sql = "Update se_list $clause";
//echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
		$clause="";
				
			// ****** uploads
//	echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>";  exit;
		$tempID=$_POST['tempID'];
			include("upload_code.php");
		
		$edit=$id;
		$clause="";
		$message="<td><font color='purple'>Update was successful.</font></td>";
		}
       
$display_fields="*";

if(@$edit)
	{
	if($level<2)
		{
//		echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		$limit_park=$_SESSION['second_employ']['select'];
		if($_SESSION['second_employ']['beacon_num']=="60092637")
			{$limit_park="OPER";} // WORK AROUND for Martin Kane
		if($_SESSION['second_employ']['beacon_num']=="60032997")
			{$limit_park="ACCO";} // WORK AROUND for Rachel Gooding
			
			if($_SESSION['second_employ']['accessPark'] != "")
				{
				$limit_park=$_SESSION['second_employ']['accessPark'];
				}
		$lp=explode(",",$limit_park);
		foreach($lp as $k=>$v)
			{
			@$clause1.=" park_code='$v' OR ";
			}
			$clause1=rtrim($clause1," OR ");
			@$clause.=" AND (".$clause1.")";
		}
		
		if(!isset($clause)){$clause="";}
		$sql = "SELECT * FROM se_list as t1 
		WHERE  id='$edit' $clause
		";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY[]=$row;}
			
		// get any final uploads
		$sql = "SELECT * FROM upload_final as t1 
		WHERE  final_id='$edit'
		";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		if(mysqli_num_rows($result)>0)
			{
			$final_upload_array=mysqli_fetch_assoc($result);
			}
	}
	else
	{
	if(empty($id))
		{
		extract($_SESSION['second_employ']);
		$name=$full_name;
		$db = mysqli_select_db($connection,'divper') or die ("Couldn't select database");
		$sql="SELECT t1.email, t1.add1 as address, t1.city, t1.zip, t3.working_title as position, t3.code as park_code
		from divper.empinfo as t1
		LEFT JOIN divper.emplist as t2 on t1.tempID=t2.tempID
		LEFT JOIN divper.position as t3 on t2.beacon_num=t3.beacon_num
		where t1.tempID='$tempID'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
		extract($row);
		$pass_email=$email;
		if(empty($pass_email))
			{
//			echo "Before you can submit a request, we must have your <b>work email</b> address. Log in to the <a href='https://www.ncstateparks.net/divper/index.html'>Personnel database</a> and update your \"Contact Info\". Once that is complete, you will be able to submit a request.";
//			exit;
			}
		$pass_position=$position;
		$pass_park_code=$park_code;
		$pass_address=$address;
		$pass_city=$city;
		$pass_zip=$zip;
		@$pass_location=$parkCodeName[$park_code];
		echo "$name - Request for Secondary Employment Approval";
		}
	}
	
echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

//$destination="";
if(@$edit)
	{
	$action="edit.php";
//	if($submit!="Update"){$destination="target='_blank'";}
	}
	else
	{
	$action="add_request.php";
	}

echo "<form method='POST' name='contactForm' action='$action' enctype='multipart/form-data'>";

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";

$skip=array("id","justification","register","response","other_file_1","other_file_2","request");
$text=array("comments","duties");
//$read_only=array("se_dpr","division","tempID","se_dpr","se_dpr","se_dpr");
$drop_down=array("park_code");

// menu.php has the javascript that controls calendars
if($level==1)
	{
	$date_array=array("notify_supervisor"=>'1');
	
// 	if($tempID=="Coffman4471")  // workaround to allow for him to act as PASU
// 		{
// 		$working_title=="Park Superintendent";
// 		$level=2;
// 		}
	if($working_title=="Park Superintendent")
		{
		$date_array['supervisor_approval']='2';
		$date_array['PASU_approval']='3';
		}
	$read_only=array("id","se_dpr","supervisor_approval","PASU_approval","DISU_approval","CHOP_approval","HR_approval","Director_approval","staff_notify","division","tempID","se_dpr","comments");
	}
if($level==2)
	{	$date_array=array("notify_supervisor"=>'1',"supervisor_approval"=>'2',"PASU_approval"=>'3',"DISU_approval"=>'4');	$read_only=array("id","se_dpr","CHOP_approval","HR_approval","Director_approval","staff_notify","division","tempID","se_dpr","comments");
	}
if($level>2)
	{	$date_array=array("notify_supervisor"=>'1',"supervisor_approval"=>'2',"PASU_approval"=>'3',"DISU_approval"=>'4',"CHOP_approval"=>'5',"HR_approval"=>'6',"Director_approval"=>'7',"staff_notify"=>'8',"se_dpr");
	}

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	
$db = mysqli_select_db($connection,$database);

$skip_until_upload=array("notify_supervisor","supervisor_approval","PASU_approval","DISU_approval","CHOP_approval","HR_approval","Director_approval");

IF($ARRAY[0]['request']=="" OR @$submit=="Submit a Request")
	{
	$skip=array_merge($skip,$skip_until_upload);
	}
	else
	{
	// get supervisor
	$get_park=$ARRAY[0]['park_code'];
	$sql="SELECT t1.email as super_email
		from divper.empinfo as t1
		LEFT JOIN divper.emplist as t2 on t1.tempID=t2.tempID
		LEFT JOIN divper.position as t3 on t2.beacon_num=t3.beacon_num
		where t3.working_title like '%superintendent%' and park='$get_park'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
		@extract($row); //echo "s=$super_email";
	}
//echo "<pre>"; print_r($skip); echo "</pre>";	

foreach($ARRAY as $num=>$row)
	{
	foreach($row as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
			if(@$edit=="")
				{
				$value="";
				if($fld=="email"){$value=$pass_email;}
				if($fld=="name"){$value=$name;}
				if($fld=="division"){$value="Div. of Parks and Recreation";}
				if($fld=="position"){$value=$pass_position;}
				if($fld=="location"){$value=$pass_location;}
				if($fld=="park_code"){$value=$pass_park_code;}
				if($fld=="address"){$value=$pass_address;}
				if($fld=="city"){$value=$pass_city;}
				if($fld=="state"){$value="NC";}
				if($fld=="zip"){$value=$pass_zip;}
				if($fld=="tempID"){$value=$tempID;}
				if($fld=="request"){$value=$request;}
				
				if($fld=="se_dpr")
					{
					$sql = "SELECT $fld FROM se_list
					WHERE 1 order by $fld desc limit 1
					"; //echo "$sql"; exit;
					$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
					$row=mysqli_fetch_assoc($result);
					$value=$row[$fld];					$value="SE_".date('Y')."_".str_pad((substr($value,-3)+1),3,0,STR_PAD_LEFT);
					$pass_se_dpr=$value;
					}
				}
								
		if(@in_array($fld,$read_only)){$RO="readonly";}else{$RO="";}
		
		$rename=$fld;
		if($fld=="park_code")
			{
			$rename="4-letter park code or section code";
			$pass_park_code=$value;
			}
		if($fld=="employer")
			{
			$rename="Supplementary Employer";
			}
		if($fld=="business")
			{
			$rename="Nature of employer's business or profession";
			}
		if($fld=="duties")
			{
			$rename="Description of duties to be performed/Requester Comments";
			}
		if($fld=="work_day")
			{
			$rename="Days and hours of employment";
			}
		if($fld=="dates")
			{
			$rename="Anticipated dates of employment";
			}
		if($fld=="comments")
			{
			$rename="comments - (For OPS use only)";
			}
		if($fld=="CHOP_approval")
			{
			$rename="DDoO_approval";
			}
			
		echo " <tr valign='top'><td align='right'>$rename</td>";
		
		if($fld=="se_dpr")
			{$pass_se_dpr=$value;}
			
		
		$item="<input type='text' name='$fld' value=\"$value\" size='32'$RO>";
			
		
					
		if(in_array($fld,$text))
			{
		//	if($value){$d="block";}else{$d="none";}
			$d="block";
		if(@in_array($fld,$read_only)){$RO="readonly";}else{$RO="";}
			$item="<div id=\"$fld\"><a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\">show/hide</a> <font size='-1'></font></div>
		
			<div id=\"fieldDetails[$fld]\" style=\"display: $d\"><br><textarea name='$fld' cols='28' rows='5' $RO>$value</textarea></div>";
			}
							

		if($fld=="park_code")
			{
			$item="<select name='$fld'><option selected=''></option>\n";
			foreach($parkCode as $pc_k=>$pc_v)
				{
				if($pc_v==$pass_park_code){$s="selected";}else{$s="value";}
				$item.="<option $s='$pc_v'>$pc_v</option>\n";
				}
			$item.="</select>";
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
			$subject="$pass_park_code Request for Secondary Employment $pass_se_dpr ";
			
			if($fld=="staff_notify"){}else{$to_address="";}
			if($level>1 AND $fld=="approv_OPS")
				{
				$to_address="denise.williams@ncdenr.gov";
				}
			
			if(!isset($forward)){$forward="";}
			if(!isset($edit)){$edit="";}
				$body="If you are presently logged into the Secondary Employment Approval database then you can go directly to this link to view the request:%0d/second_employ/edit.php?edit=$edit%26submit=edit%0d%0dIf not, then go to this link to log in:%0d/second_employ/index.html%0d%0dContact Tom Howard if you are unable to access the database.";
				$body="If you are presently logged into the Secondary Employment Approval database then you can go directly to this link to view the request:%0d/second_employ/edit.php?edit=$edit%26submit=edit%0d%0dIf not, then go to this link to log in:%0d/second_employ/index.html%0d%0dContact Tom Howard if you are unable to access the database.";
			$email_to="&nbsp;&nbsp;&nbsp;<font color='green'>Email for $forward: </font><a href='mailto:$to_address?subject=$subject&body=$body'>email</a>";
			if($fld=="DISU_approval")
				{
				$var1=$chop_email_array['60033018']; //CHOP
				$var2=$chop_email_array['60033148']; // CHOP OA
				$chop_email=$var1;
				$oa_email=$var2;
				$email_to="&nbsp;&nbsp;&nbsp;<font color='green'>Email for $forward: </font><a href='mailto:$chop_email?cc=$oa_email&subject=$subject&body=$body'>email</a>";
				}
			if($fld=="CHOP_approval")// CHOP_approval
				{
				$email_to="&nbsp;&nbsp;&nbsp;<font color='green'>Email for $forward: </font><a href='mailto:$hr_email?subject=$subject&body=$body'>email</a>";
				}
			if($fld=="HR_approval")
				{
				$var1=$dir_email_array['60032778']; //Director
				$var2=$dir_email_array['60033202']; // Deputy Director
				$dir_email=$var1;
				$dedir_email=$var2;
				$email_to="&nbsp;&nbsp;&nbsp;<font color='green'>Email for $forward: </font><a href='mailto:$dir_email?cc=$dedir_email&subject=$subject&body=$body'>email</a>";
				}
			if($fld=="Director_approval")
				{
				$fn=$ARRAY[$num]['name'];
				$status=$ARRAY[$num]['status'];
				$subject="Secondary Employment Request for $fn";
				$to_address=$ARRAY[$num]['email'];
				$cc=@$super_email;
				$body="Your request is $status.%0d%0dIf you are presently logged into the Secondary Employment Approval database then you can go directly to this link to view the request:%0d/second_employ/edit.php?edit=$edit%26submit=edit%0d%0dIf not, then go to this link to log in:%0d/second_employ/index.html%0d%0dContact Tom Howard if you are unable to access the database.";
				$body="Your request is $status.%0d%0dIf you are presently logged into the Secondary Employment Approval database then you can go directly to this link to view the request:%0d/second_employ/edit.php?edit=$edit%26submit=edit%0d%0dIf not, then go to this link to log in:%0d/second_employ/index.html%0d%0dContact Tom Howard if you are unable to access the database.";
				$email_to=" <a href=\"mailto:$to_address?cc=$cc&subject=$subject&body=$body\">email</a>";
				}
				
			$item="<div><span id=\"$date_field\" class=\"fromdate\">
				<label for=\"year-field\">
				$var_check 
				Year: </label><input id=\"$year_field\" type=\"text\" name=\"$year_field\" value=\"$var_yf\" style=\"width: 4em;\">
				<label for=\"month-field\">Month: </label><input id=\"$month_field\" type=\"text\" name=\"$month_field\" value=\"$var_mf\"style=\"width: 2em;\">
				<label for=\"day-field\">Day: </label><input id=\"$day_field\" type=\"text\" name=\"$day_field\" value=\"$var_df\"style=\"width: 2em;\">
					</span>$email_to</div>";
			}
			
		if($fld=="status")
			{
			if($level<4){$RO=" disabled";}
			$pass_status=$value;
			if($value=="Approved")
				{$radio_app="checked";}else{$radio_app="";}
			if($value=="Not Approved")
				{$radio_not_app="checked";}else{$radio_not_app="";}
			if($value=="Pending")
				{$radio_pending="checked";}else{$radio_pending="";}
			if($value=="Void")
				{$radio_void="checked";}else{$radio_void="";}
			$item="<input type='radio' name='$fld' value=\"Pending\"$RO $radio_pending>Pending <input type='radio' name='$fld' value=\"Approved\"$RO $radio_app><font color='green'>Approved</font> <input type='radio' name='$fld' value=\"Not Approved\"$RO $radio_not_app><font color='red'>Not Approved</font>";
			if($level>3)
				{
				$item.="<input type='radio' name='$fld' value=\"Void\"$RO $radio_void><font color='purple'>Void</font>";
				}
			 
			}
		
		if($fld=="approv_OPS" and $level<3)
			{
			$pass_OPS=$value;
			$notice="<br />Any SE approved by OPS cannot be edited or deleted.<br />Contact the CHOP office for details.";
			}
		if($fld=="notify_supervisor" and $level>1)
			{
			$item="<marquee width='80%' LOOP=1 BEHAVIOR=SLIDE>
			<font color='brown'>User MUST click the Submit/Update button after entering a date.</font>
			</marquee>".$item;
			}
		if($fld=="comments")
			{
			$print="<tr><td><font color='magenta'>Click to produce a Request to print, sign, date, and upload.</font></td><td><input type='submit' name='submit' value='Create Request Form'></td></tr>";
			
			if(@$message!="" OR $ARRAY[$num]['request']!="")
				{
				$file=$ARRAY[$num]['request'];
				$file_link="<a href='$file' target='_blank'>VIEW</a>";
				$print.="<tr><td colspan='2'><font color='red'>Your request has been created. Review for completeness/correctness.</font>
				<br />
				Then sign, date, and upload.</td></tr>";
				}
			$item=$item."</td></tr>".$print."<tr>
			<td align='right'><font color='green'>Upload Signed and Dated Request</font>";
			if(!empty($file_link))
				{
				$item.="<br />&nbsp;&nbsp; $file_link Request";
				}
			$item.="</td>
			<td><input type='file' name='file_upload' size='30'></td></tr>";
			}
		
		
		
		echo "<td>$item</td></tr>";
		
		
		// second table
		if($fld=="duties")
			{
			echo "</table></td><td valign='top'>
			<table cellpadding='3' border='1' bgcolor='aliceblue'>";
			}
					
		}
	}
		
	
	if(@$edit){$action="Update";}else{$action="Submit";}
	
if(!isset($notice)){$notice="";}
if(!isset($pass_OPS)){$pass_OPS="";}
if(!isset($message)){$message="";}

IF($pass_status=="Approved" and $level<2)
	{}
else
	{
	if($pass_OPS=="" OR $pass_OPS=="0000-00-00" OR $level>2)
		{
		echo "<tr><th colspan='3'>$action Sec. Employment Request $notice</th></tr>";
			echo "<tr><td align='center' colspan='3'>
			<input type='submit' name='submit' value='$action'>
			
			$pass_OPS";
			if($action=="Update")
				{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='hidden' name='id' value='$edit'>
				<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'>";
				}
			echo "</td></tr></form>";
		$VAR="final";
		$upload_table="upload_".$VAR;
		$action="upload_".$VAR.".php";
		$display_name=ucwords($VAR);
		echo "<tr><td>Upload approved request.
	<font color='brown'>$display_name</font><br />";
	if(!empty($final_upload_array))
		{
		extract($final_upload_array);
		echo "<a href='$link'>$file_name</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href='edit.php?act=del&edit=$edit' onclick=\"return confirm('Are you sure you want to delete this Document?')\">del</a>";
		}
	
	if(!isset($edit)){$edit="";}
	echo "</td>
	<td><form method='POST' action='$action' enctype='multipart/form-data'>
	<input type='file' name='$VAR'>
	<input type='hidden' name='VAR' value=\"$VAR\">
	<input type='hidden' name='id' value=\"$edit\">
	<input type='hidden' name='pass_se_dpr' value=\"$pass_se_dpr\">
	<input type='submit' name='submit' value=\"Upload\">
	</form></td></tr>";
	if(empty($status)){$status=$ARRAY[0]['status'];}
		if($status=="Approved")
			{
			echo "<tr><td><a href='approved_pdf.php?edit=$edit' target='_blank'>Approval Page</a></td></tr>";
			}
		}
	}
	echo "</table></td></tr>
	";
	echo "</table></html>";

?>