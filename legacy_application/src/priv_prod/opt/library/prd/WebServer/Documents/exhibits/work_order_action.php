<?php
ini_set('display_errors', 1);
if(empty($connection))
	{
	$db="exhibits";
	include("../../include/iConnect.inc"); // database connection parameters
	}
echo "<pre>";print_r($_POST);echo "</pre>";  //exit;
//echo "<pre>";print_r($_FILES);echo "</pre>";  exit;

$test=$_POST['submit'];
@$pass_id=$_REQUEST['pass_id'];
$tempID=$_REQUEST['tempID'];
IF($test=="Submit" OR $test=="Update")
	{
	$error_emp_id="";
//	$error_section="";
//	$error_funding_source="";
	$error_location_comment="";
	$error_component_comment="";
	$clause="";
	$error="";

date_default_timezone_set('America/New_York');
	
//echo "<pre>"; print_r($skip); echo "</pre>";  exit;
if(!empty($_REQUEST['pass_id']))
	{
	$pass_id=$_REQUEST['pass_id'];
	$sql="SELECT project_comments, materials_costs, proj_description, instructions
	 from work_order 
	 where work_order_id='$pass_id'";
	$result = mysqli_query($connection,$sql);  //echo "$sql";
	$row=mysqli_fetch_assoc($result);
	$exist_project_comments=$row['project_comments'];
	$exist_materials_costs=$row['materials_costs'];
	$exist_proj_description=$row['proj_description'];
	$exist_instructions=$row['instructions'];
	}
	$skip=array("email","submit","pass_id","pass_location","category_new","email_assign","proj_description_original","tempID");
if(empty($_POST['work_order_number']))
	{$skip[]="work_order_number";}

//	echo "<pre>"; print_r($skip); echo "</pre>"; // exit;
	foreach($_POST as $key=>$value)
		{
		if(in_array($key,$skip)){continue;}
		
		if(strpos($key,"assigned_to")>-1)
			{
			$exp=explode("*",$value);
			$value=$exp[0];
			$_POST[$key]=$value;
			}
		if(strpos($key,"assigned_to")>-1){continue;}
		if(strpos($key,"time_worked")>-1){continue;}
		if(strpos($key,"send_email")>-1){continue;}
		if(strpos($key,"email_sent")>-1){continue;}
		if(strpos($key,"completed_")>-1){continue;}
		if(strpos($key,"work_done_")>-1){continue;}
		
		if(strpos($key,"routed_to")>-1)
			{
			$exp=explode("*",$value);
			$value=$exp[0];
			$_POST[$key]=$value;
			}
		
		if(is_array($value))
			{
			foreach($value as $k1=>$v1)
				{
// 				$v1=mysql_real_escape_string($v1);
				@$multi_value.=$v1.",";
				}
			$multi_value=rtrim($multi_value,",");
			$clause.=$key."='".$multi_value."',";
			$multi_value="";
			}
			else
			{
	//		if($key=="department" AND $_POST['department_name_new']!="")
	//			{$value=$_POST['department_name_new'];}
	
			if($key=="category")
				{
				$value=$_POST['category'];
				if(@$_POST['category_new']!="") 
					{
					$value=$_POST['category_new'];
					}
				}

			if($key=="park_code")
				{
				$value=$_POST['park_code'];
				}

			if($key=="lat")
				{
				$value=$_POST['lat'];
				}
			if($key=="lon")
				{
				$value=$_POST['lon'];
				}

			if($key=="date_assigned")
				{
				if($_POST['date_assigned'] < date("Y-m-d"))
					{$value=date("Y-m-d");}
				}
			if($key=="due_date")
				{
				if($_POST['due_date'] < date("Y-m-d") AND $test=="Submit")
					{$value=date("Y-m-d");}
				$pass_due_date=$value;
				}

			if($key=="materials_costs")
				{
				$var_temp=substr($tempID,0,-4)."_".date("y-m-d");
				@$comp=strcasecmp($value,$exist_materials_costs);
				if($comp!=0)
					{
					// had to addslashes to $exist_***
		//			echo "v=$value<br /><br />$exist_materials_costs"; exit;
					$exp_mc=explode("~",$value);
					$var_mc=array_pop($exp_mc);
					$test_1=explode("_",$var_mc);
					$test_2=substr($tempID,0,-4);
				//	echo "c=$comp $test_1[0] $test_2"; exit;
					if($test_1[0]!=$test_2 OR $var_mc!=$var_temp)
						{
						$value.="~".$var_temp;
						}
					$time_materials_costs=date("D M j Y @ H:i:s", time());
			//		$clause.="time_materials_costs='<font color='green'>".$tempID." on ".$time_materials_costs."</font>',";
					}
				}
				
			if($key=="instructions")
				{
				$var_temp=substr($tempID,0,-4)."_".date("y-m-d");
				@$comp=strcasecmp($value,$exist_instructions);
				if($comp!=0)
					{
					$exp_mc=explode("~",$value);
					$var_mc=array_pop($exp_mc);
					$test_1=explode("_",$var_mc);
					$test_2=substr($tempID,0,-4);
					if($test_1[0]!=$test_2 OR $var_mc!=$var_temp)
						{
						$value.="~".$var_temp;
						}
					$time_instructions=date("D M j Y @ H:i:s", time());
					$clause.="time_instructions='<b>".$tempID." on ".$time_instructions."</b>',";
					}
				}
			if($key=="project_comments")
				{
				$var_temp=substr($tempID,0,-4)."_".date("y-m-d");
				@$comp=strcasecmp($value,$exist_project_comments);
				if($comp!=0)
					{
					$exp_mc=explode("~",$value);
					$var_mc=array_pop($exp_mc);
					$test_1=explode("_",$var_mc);
					$test_2=substr($tempID,0,-4);
					if($test_1[0]!=$test_2 OR $var_mc!=$var_temp)
						{
						$value.="~".$var_temp;
						}
					$time_project_comments=date("D M j Y @ H:i:s", time());
					$clause.="time_project_comments='<b>".$tempID." on ".$time_project_comments."</b>',";
					}
				}
			if($key=="proj_description")
				{
				$var_temp=substr($tempID,0,-4)."_".date("y-m-d");
				@$comp=strcasecmp($value,$exist_proj_description);
				if($comp!=0)
					{
					$exp_mc=explode("~",$value);
					$var_mc=array_pop($exp_mc);
					$test_1=explode("_",$var_mc);
					$test_2=substr($tempID,0,-4);
					if($test_1[0]!=$test_2 OR $var_mc!=$var_temp)
						{
						$value.="~".$var_temp;
						}
					$time_proj_description=date("D M j Y @ H:i:s", time());
					$clause.="time_proj_description='<b>".$tempID." on ".$time_proj_description."</b>',";
					}
				}
// 			$value=mysqli_real_escape_string($connection,$value);
			$clause.=$key."='".$value."',";
			//${$key}=
			}
		}
//echo "$clause"; exit;
$error="";


	if($_POST['emp_id']=="")
		{$error.="<h3><font color='magenta'>You must enter a State Park employee. Record was NOT entered.</font></h3>";}

	if($_POST['funding']=="")
		{$error.="<h3><font color='magenta'>You must enter a Funding Source. Record was NOT entered.</font></h3>";}

	if($_POST['category']=="" and $_POST['category_new']=="")
		{$error.="<h3><font color='magenta'>You must enter a Category. Record was NOT entered.</font></h3>";}

		
	if($error=="")
		{
		date_default_timezone_set('America/New_York');
		if($test=="Submit")
			{
			$f_year=date("y");
			$sql="SELECT work_order_number from work_order order by work_order_number desc limit 1";
			$result = mysqli_query($connection,$sql);
			$row=mysqli_fetch_assoc($result);
			$won=$row['work_order_number'];
			$var1=explode("_",$won);
			
			if($f_year==$var1[0])
				{
				$year=$var1[0];
				$num=$var1[1]+1;
				}
				else
				{
				$year=$f_year;
				$num=1;
				}
			$new_won=$year."_".str_pad($num,4,"0",STR_PAD_LEFT);
			$clause.="work_order_number='".$new_won."'";
			$pdo=$_POST['proj_description'];
			$clause.=", proj_description_original='".$pdo."'";
			}
		
		$routed_email="";
		$assigned_email="";
		if($test=="Submit")
			{
			$sql="INSERT into work_order set $clause";
			}
		if($test=="Update")
			{
			$clause=rtrim($clause,",");
			if(empty($_POST['additional_img']))
				{
				$clause.=", additional_img=''";
				}
			if(!empty($_POST['routed_to_1']) AND $_POST['routed_on']=="")
				{
				$clause.=", routed_on='".date('Y-m-d')."'";
				$routed_email_1=1;
				}
			if(!empty($_POST['routed_to_2']) AND $_POST['routed_on']=="")
				{
				$clause.=", routed_on='".date('Y-m-d')."'";
				$routed_email_2=1;
				}
			if(!empty($_POST['date_assigned']) AND @$_POST['email_assign']!="")
				{
				$assigned_email=1;
				}
			$sql="UPDATE work_order set $clause where work_order_id='$pass_id'";
			}
		
//	echo "$sql<br />r="; exit;
		
		$message="";
		$pn=stripslashes($_POST['proj_name']);
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)." Q=".$sql);

// Get addresses for Everyone
			$sql="SELECT t1.tempID as emp_id, t1.email 
			from divper.empinfo as t1 
			left join divper.emplist as t2 on t1.tempID=t2.tempID
			where t2.exhibits > 0";
			$result = mysqli_query($connection,$sql);
			while($row=mysqli_fetch_assoc($result))
				{
				if(empty($row['emp_id'])){continue;}
				if(empty($row['email'])){continue;}
				$email_array[$row['emp_id']]=$row['email'];
				}
//echo "<pre>"; print_r($email_array); echo "</pre>";  exit;
// Initial request submission
		if($test=="Submit")
			{
			$pass_id=mysqli_insert_id($connection);
// Requestor
	$to      = $email_array[$_POST['emp_id']];
//	$to = "database.support@ncparks.gov";
    			$subject = 'Work Order #'.$new_won.' - '.$_POST['proj_name'];
    			$message = 'Your work order request has been received. It will be routed to a Project Manager for completion.'."\n\n".'';
    			$track_message=$message;
    			$message .= 'http://www.dpr.ncparks.gov/exhibits/work_order_form.php?pass_id='.$pass_id;
//echo "$to<pre>"; print_r($email_array); echo "</pre>";  //exit;
				
	$from = "sean.higgins@ncparks.gov";
	$to_CC = "sean.higgins@ncparks.gov";
//	$from = "database.support@ncparks.gov";
//	$to_CC = "database.support@ncparks.gov";
    			$headers = 'From: '. $from. "\r\n";
        		$headers .='Cc: '. $to_CC. "\r\n";
        		$headers .= 'Reply-To: '.$from . "\r\n" .
        		'X-Mailer: PHP/' . phpversion();
//		echo "t=$to m=$message $headers"; exit;
    			mail($to, $subject, $message, $headers);
    			
			if(TRUE)
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='TRUE', track_message='$track_message'
				";
				}
				else
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='FALSE', track_message='$track_message'
				";
				}
			$result = mysqli_query($connection,$sql);  //echo "$sql";
			}
			
// multiple recipients
//$to  = 'aidan@example.com' . ', '; // note the comma
//$to .= 'wez@example.com';

	// Update worker hours, etc. ******************************************
		if($test=="Update")
			{
			$num=$_POST['assigned_number'];
			$work_order_number=$_POST['work_order_number'];
			$sql="DELETE FROM work_order_workers where work_order_number='$work_order_number'";
		$result = mysqli_query($connection,$sql);
			// if send_email then segue to email_sent
			for($i=1;$i<=$num;$i++)
				{
				$val_1="";
				$val_2="";
				$val_3="";

				$var_fld_1="assigned_to_".$i;
				$val_1=$_POST[$var_fld_1];
				$exp=explode("*",$val_1);
				$val_1=$exp[0];
				$var_fld_2="time_worked_".$i;
				$val_2=$_POST[$var_fld_2];
				$var_fld_3="time_worked_old_".$i;
				$val_3=$_POST[$var_fld_3];
				$time=$val_2+$val_3;
				$var_fld_4="email_sent_".$i;
				$val_4=$_POST[$var_fld_4];
				$var_fld_5="completed_".$i;
				$val_5=@$_POST[$var_fld_5];
				$var_fld_6="work_done_".$i;
				$val_6=@$_POST[$var_fld_6];
				if(!empty($val_1))
					{
					if($val_5=="x" AND ($val_6=="0000-00-00" or $val_6=="" or $val_2!=""))
						{$timestamp_done=", work_done=NOW()";}
						else
						{$timestamp_done=", work_done='$val_6'";}
					$sql="INSERT into work_order_workers set work_order_number='$work_order_number', emp_id='$val_1', time='$time', email_sent='$val_4', completed='$val_5' $timestamp_done";
				//	echo "$sql<br />6=$val_6 2=$val_2"; exit;
					$result = mysqli_query($connection,$sql);
					}
				}
		//	exit;
			}


		// deal with any uploads
		if(!empty($_FILES))
			{
		//	include("file_upload.php");
			include("file_upload_im.php");
			}

// send any email to Project Manager from Admin
	 $from="sean.higgins@ncparks.gov";
//	 $from="database.support@ncparks.gov";
		if(!empty($_POST['routed_to_1']) AND $routed_email_1==1)
			{
			$routed_to_1=$_POST['routed_to_1'];
		$to      = $email_array[$routed_to_1];
    			$subject = 'Work Order #'.$work_order_number.' - '.$proj_name;
    			$message = 'This request has been routed to '.$_POST['routed_to_1'].' for action.'."\n\n";
    			$track_message=$message;
    			$message .= 'http://www.dpr.ncparks.gov/exhibits/work_order_form.php?pass_id='.$pass_id;
    			$headers = 'From: '.$from."\r\n" .
        		'Reply-To: '.$from."\r\n" .
        		'X-Mailer: PHP/' . phpversion();
//		echo "m=$message<br />$to"; exit;
    			mail($to, $subject, $message, $headers);
    			if(TRUE)
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='TRUE', track_message='$track_message'
				";
				}
				else
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='FALSE', track_message='$track_message'
				";
				}
			$result = mysqli_query($connection,$sql);  //echo "$sql";
			}

// send an email to Associate Project Manager from Admin
		if(!empty($_POST['routed_to_2']) AND $routed_email_2==1)
			{
			$routed_to_2=$_POST['routed_to_2'];
		$to      = $email_array[$routed_to_2];
//		$to      = "database.support@ncparks.gov";
    			$subject = 'Work Order #'.$work_order_number.' - '.$proj_name;
    			$message = 'This request has been routed to '.$_POST['routed_to_2'].' for action.'."\n\n";
    			$track_message=$message;
    			$message .= 'http://www.dpr.ncparks.gov/exhibits/work_order_form.php?pass_id='.$pass_id;
    			$headers = 'From: '.$from."\r\n" .
        		'Reply-To: '.$from."\r\n" .
        		'X-Mailer: PHP/' . phpversion();

    			mail($to, $subject, $message, $headers);
			if(TRUE)
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='TRUE', track_message='$track_message'
				";
				}
				else
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='FALSE', track_message='$track_message'
				";
				}
			$result = mysqli_query($connection,$sql);  //echo "$sql";
			}

	
		//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// Send email to workers
			$no_email="";
		for($i=1;$i<=$_POST['assigned_number'];$i++)
			{
			$v="assigned_to_".$i;
			$vv="send_email_".$i;
			$val1=$_POST[$v];
			$val2=$_POST[$vv];

			if(empty($val1)){continue;}
			if(empty($val2)){continue;}
	$to=$email_array[$val1];
			if(empty($email_array[$val1]))
				{
				$no_email.=$val1."*";
				continue;
				}
				
			$subject = 'Assigned Work Order #'.$work_order_number.' - '.$_POST['proj_name'];
			if(!empty($_POST['date_assigned']))
				{$var_da=$_POST['date_assigned'];}
				else
				{$var_da=date("Y-m-d");}
				
	list($year,$month,$day)=explode("-",$pass_due_date);
	$due_date_email=date("D, M j, Y", mktime(0, 0, 0, $month, $day, $year));
//	$iCal="Add to iCal: ".date("n-j-Y", mktime(0, 0, 0, $month, $day, $year))." at 5:00 pm";
	
			$message = 'Assigned on '.$var_da.' by '.$_POST['routed_to_1']." to ".$_POST[$v]."\n\n";
    			$track_message=$message;
			$message .= 'http://www.dpr.ncparks.gov/exhibits/work_order_form.php?pass_id='.$pass_id;
			$message .= "\n\n".'Due date: '.$due_date_email;
			
//			$message .= "\n\n".$iCal;
			
			$headers = 'From: '.$email_array[$_POST['routed_to_1']] . "\r\n" .
				'Reply-To: '.$email_array[$_POST['routed_to_1']] . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			
			mail($to, $subject, $message, $headers);
			if(TRUE)
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='TRUE', track_message='$track_message'
				";
				}
				else
				{
				$sql="INSERT INTO email_sent
				set sent_to='$to', won='$work_order_number', was_sent='FALSE', track_message='$track_message'
				";
				}
			$result = mysqli_query($connection,$sql);  //echo "$sql";

			$sql="UPDATE work_order_workers set email_sent=NOW()
			WHERE work_order_number='$work_order_number' and emp_id='$val1'";
				$result = mysqli_query($connection,$sql);
			$sql="UPDATE work_order set date_assigned=NOW()
			WHERE work_order_number='$work_order_number' and date_assigned is NULL";
				$result = mysqli_query($connection,$sql);
			}
		//	exit;
		}
		
	if(!empty($error))
		{
		$_REQUEST['proj_description']=str_replace('\\','',$_POST['proj_description']);
		$_REQUEST['location_comment']=str_replace('\\','',$_POST['location_comment']);
		include("work_order_form.php");

		exit;
		}

		@mysqli_free_result($result);
		mysqli_close($connection);
		
		if($test=="Submit")
			{
			header("Location: search.php?submit=Find");
			exit;
			}
//exit;
	header("Location: work_order_form.php?pass_id=$pass_id&no_email=$no_email");
	}
	
?>