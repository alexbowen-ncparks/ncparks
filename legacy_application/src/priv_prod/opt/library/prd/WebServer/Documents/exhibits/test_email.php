<?php
ini_set('display_errors', 1);

// Send email to workers
			
	$to="tom@nature123.net";
	$work_order_number="13_0028";
	$_POST['proj_name']="Test Project";
	$_POST['date_assigned']=date("Y-m-d");
	
	$pass_due_date="2013-04-01";
	list($year,$month,$day)=explode("-",$pass_due_date);
	$due_date=date("D, M j, Y", mktime(0, 0, 0, $month, $day, $year));
	$iCal="Add to iCal: ".date("n-j-Y", mktime(0, 0, 0, $month, $day, $year))." at 5:00 pm";
	
//	$due_date="Next Preventive Appointment: 4-11-2013 at 2:00 pm";
	
	$_POST['routed_to_1']="me";
	$pass_id=34;
	$someone="Another Person";
	
			$subject = 'Assigned Work Order #'.$work_order_number.' - '.$_POST['proj_name'];
			if(!empty($_POST['date_assigned']))
				{$var_da=$_POST['date_assigned'];}
				else
				{$var_da=date("Y-m-d");}
			$message = 'Assigned on '.$var_da.' by '.$_POST['routed_to_1']." to ".$someone."\n\n";
			$message .= 'http://nature123.net/work_order/work_order_form.php?pass_id='.$pass_id;
			$message .= "\n\n".'Due date: '.$due_date;
			
			$message .= "\n\n".$iCal;
			
			$headers = 'From: '.$email_array[$_POST['routed_to_1']] . "\r\n" .
				'Reply-To: '.$email_array[$_POST['routed_to_1']] . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
//echo "$message"; exit;			
ini_set('display_errors', 1);
if(empty($connection_i))
	{
	$db="mns";
	include("../../include/connect_mysqli.inc"); // database connection parameters
	}
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
	$result = mysqli_query($connection_i,$sql);  //echo "$sql";
echo "<br />$message";
?>