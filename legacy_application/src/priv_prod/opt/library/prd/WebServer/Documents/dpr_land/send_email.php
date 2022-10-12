<?php

if(isset($_GET['expires']))
{
$var_id=$_GET['var_id'];
$expires=$_GET['expires'];
// echo "<pre>"; print_r($_GET); echo "</pre>";  exit;
    $to      = ' one or more email addresses.';
//     $to      = 'tom.howard@ncparks.gov';
    $subject = "Lease ID=$var_id will expire on $expires";
    $message = 'Hello from the DPR Land Database';
    $headers = 'From: database.support@ncparks.gov' . "\r\n" .
        'Reply-To: database.support@ncparks.gov' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

//     mail($to, $subject, $message, $headers);

    echo "When activated this would send an email to $to<br />It is just a proof of concept. The real code would automatically send an email at some date/time as determined by the program.<br /><br />";
    
//     echo "Email Sent to $to<br /><br />";
    echo "You may close this tab.";
}

?>