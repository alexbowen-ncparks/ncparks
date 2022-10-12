<?php
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
 session_start();
  include("../../include/connectNATURE123.inc");
  $database="natureo3_mns";
  $pass_db=$db;
  $db = mysql_select_db($database,$connection) or die ("Couldn't select database");
  
$fusername = mysql_real_escape_string($fusername);
$fpassword = mysql_real_escape_string($fpassword);
 IF($fpassword==""){EXIT;}
 
 
$sql = "SELECT * FROM personnel
              WHERE emp_id='$fusername' and password='$fpassword'"; 
      $result = mysql_query($sql)
                  or die("Couldn't execute query.");
  //               echo "$sql";exit;
                  
      $num = mysql_num_rows($result);
      
      if ($num == 1)  // login name was found
      {
         $row=mysql_fetch_assoc($result); 
         extract($row);
//echo "<pre>"; print_r($row); echo "</pre>";  exit;
         extract($_REQUEST);
         
         if($fpassword=="password")
         	{
         	include("change_password.php");
         	exit;
         	}
//         echo "<pre>"; print_r($row);  print_r($_REQUEST);echo "</pre>"; // exit;
         
           $logname=$fusername;
       
           $level=${$pass_db};
           
         $_SESSION[$pass_db]['level'] = $level;
         $_SESSION[$pass_db]['group'] = $work_order_group;
        $_SESSION[$pass_db]['first_name'] = $first_name;
        $_SESSION[$pass_db]['last_name'] = $last_name;
         $_SESSION[$pass_db]['email'] = $email;
         $_SESSION[$pass_db]['tempID'] = $emp_id;
//       echo "$pass_db<pre>"; print_r($_SESSION); echo "</pre>";  exit;

if($pass_db=="work_order"){ header("Location: search.php?submit=Find&login=1");exit;}
   
           
      }
        
      elseif ($num == 0)  // login name not found in NRID
      {
      // check divper
      
         unset($do);                                            // 53
 
         $message = "The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
         include("login_form.php");
         exit;
         }
?>
