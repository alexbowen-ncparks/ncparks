<?php
 extract($_REQUEST);
 $db="rtp";
// echo "<pre>";print_r($_POST);echo "</pre>";
 if($_POST['submit']=="Change Password")
 	{
 	 include("../../include/iConnect.inc");
 	 $database="natureo3_rtp";
 	 extract($_POST);
 	 mysqli_select_db($connection,$database)       or die ("Couldn't select database $database");
 	 $message_new="There was a difference between the new password and the retyped new password; try again.";
 	 if($npassword0==$npassword1)
		 {
		 $sql = "UPDATE rtp_users
			set password='$npassword0'
				  WHERE username='$ftempID'"; 
			$result = mysqli_query($connection,$sql)
					  or die("Couldn't execute query. $sql");
		echo "Your password has been changed. Login to the database using your new password. <a href='http://nature123.net/rtp/rtp_login_form.php?db=$dbName'>Login</a>";
		exit;
		}
 	}
?>
<html>
<head><title>Change Password</title></head>
<body bgcolor="beige">
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr><td colspan="3" bgcolor="gray" align="center">
  <font color="white" size="+3">
       <b>Change Password</b></font></td></tr>
 <tr>
  <td>
   <form action="change_password.php" method="POST">
  <table border="0" width="100%">
    <?php
      if (isset($message_new))  
           echo "<tr><td colspan='2'><font color='red'><b>$message_new</b></td></tr>";
    ?>
    <tr><td align="right"><b>Your Login is: </b></td>
     <td><font color='red'><?php echo @$fusername ?></font></td></tr>
    <tr><td align="right"><b>Default Password is: </b></td>
     <td><font color='red'>password</font>. Please enter a more secure one.</td></tr>
    <tr><td align="right"><b>New Password</b></td>
     <td><input type="password" name="npassword0" 
         value="" size="20" maxlength="20"></td></tr>
    <tr><td align="right"><b>Retype New Password</b></td>
     <td><input type="password" name="npassword1" 
         value="" 
             size="20" maxlength="20"></td></tr>
    
   
    <tr><td>&nbsp;</td>
     <td align="left">
<?php
echo "
       <input type='hidden' name='dbName' value='$pass_db'>
       <input type='hidden' name='ftempID' value='$fusername'>
       <input type='submit' name='submit' value='Change Password'>";
?>      
       </td>
    </tr>
   </table>
   </form>
  </td>
 </tr>
 <tr><td colspan="3" bgcolor="gray">&nbsp;</td></tr></table>
 <hr><div align="center"><font size="-1">
If you have any login issue, please send an email
to <a href="mailto:tom@nature123.net">tom@nature123.net</a>
</font></div>
</body></html>