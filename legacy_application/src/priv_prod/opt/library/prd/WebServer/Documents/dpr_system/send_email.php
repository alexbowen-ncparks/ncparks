<?php
$db="dpr_system";
include("../../include/iConnect.inc");
mysqli_select_db($connection, $db);

// Used for testing
// $insert_id=304;
// $location_code="MEMI";
// $database_app="divper";
// $activity="access_permanent";
// $date_create="2022-05-24";
$sql="SELECT notes
		FROM track_time_updates as t1
		where 1 and t1.ticket_id ='$insert_id'"; //echo "$sql";
		$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$notes=$row['notes'];
			}

// echo "$notes"; exit;
// values from time_track_action.php  add section around line 18

if(!empty($insert_id)) // comes from line 31 of time_track_action.php for Add or line 79 if Update
	{$ticket_id=$insert_id;}

// $notes=str_replace(<#mixed search#>, <#mixed replace#>, <#mixed subject#>, <#*[int count]#>);

	$to      = "database.support@ncparks.gov";
// $to      = 'tom.howard@ncparks.gov';
	$subject = "Ticket # $ticket_id $location_code $date_create $activity";

	$email_message = "$client $database_app $activity: /dpr_system/track_time.php?pass_ticket_id=$ticket_id";
	$email_message = "$client $database_app $activity: /dpr_system/track_time.php?pass_ticket_id=$ticket_id";
	$email_message .= "\n"."\n$notes";
	
	$headers = 'From: database.support@ncparks.gov'. "\r\n" .
	'Reply-To: database.support@ncparks.gov'. "\r\n" .
	'X-Mailer: PHP/' . phpversion();
		

if(!empty($to))
	{ mail($to, $subject, $email_message, $headers);}
   

?>