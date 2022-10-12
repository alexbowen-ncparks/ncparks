<?php
extract($_REQUEST);
//  echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
 session_start();
  $db="rtp";
  include("../../include/iConnect.inc");
  $pass_db="rtp";
  mysqli_select_db($connection,$database)       or die ("Couldn't select database $database");
  
 IF($fpassword==""){EXIT;}
 
 
$sql = "SELECT * FROM rtp_users
              WHERE username='$fusername' and password='$fpassword'"; 
      $result = mysqli_query($connection,$sql)
                  or die("Couldn't execute query.");
   //              echo "$sql";exit;
                  
      $num = mysqli_num_rows($result);
      
      if ($num == 1)  // login name was found
      {
         $row=mysqli_fetch_assoc($result); 
         extract($row);
         extract($_REQUEST);
         
         if($password=="password")
         	{
         	include("change_password.php");
         	exit;
         	}
      //      echo "pass_db=$pass_db<pre>"; print_r($row);  print_r($_REQUEST);echo "</pre>"; // exit;
         
           $logname=$fusername;
           $today = date("Y-m-d H:i:s");
//           echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
           $userAddress = $_SERVER['REMOTE_ADDR'];
           $level=$rtp;  //{$pass_db};
           $rtp_level=$rtp;  //{$pass_db};
           $nctc_level=${"nctc"};
           
           echo "d=$pass_db l=$level";
  

$lc_fusername=strtolower($fusername);
$sql = "SELECT score_access, username FROM rts_staff
              WHERE username='$lc_fusername'";  //echo "s=$sql"; exit;
      $result = mysqli_query($connection,$sql)
                  or die("Couldn't execute query.");
	$row=mysqli_fetch_assoc($result);
	@extract($row);
        
        if($rtp_level>0)
        	{
			 $_SESSION[$pass_db]['level'] = $level;
			 $_SESSION[$pass_db]['rtp_level'] = $rtp_level;
		//	 $_SESSION[$pass_db]['nctc_level'] = $nctc_level;
			 $_SESSION[$pass_db]['username'] = $username;
			 $_SESSION[$pass_db]['score_access'] = $score_access;
        	}
         
        if($nctc_level>0)
        	{
        	$get_Lname=substr($lc_fusername,0,-4);
		$sql = "SELECT * FROM nctc_members
			WHERE last_name='$get_Lname'"; //echo "s=$sql"; exit;
			  $result = mysqli_query($connection,$sql)
						  or die("Couldn't execute query. $sql");
			$row=mysqli_fetch_assoc($result);
			extract($row);
			 $_SESSION[$pass_db]['level'] = $level;
		//	 $_SESSION[$pass_db]['rtp_level'] = $rtp_level;
			 $_SESSION[$pass_db]['nctc_level'] = $nctc_level;
			 $_SESSION[$pass_db]['represents'] = $represents;
			 $_SESSION[$pass_db]['username'] = $first_name." ".$last_name;
			 $_SESSION[$pass_db]['member'] = $member;
        	}

if($pass_db=="rtp"){ header("Location: /rtp/home.php");exit;}
   
      echo "<pre>";print_r($_SESSION);echo"</pre>";exit;
      }
        
      elseif ($num == 0)  // login name not found in NRID
      {
      // check divper
      
         unset($do);                                            // 53
 
         $message = "The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
         include("rtp_login_form.php");
         exit;
         }
?>
