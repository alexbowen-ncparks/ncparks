<?php
 extract($_REQUEST);
 $dbName="divper";
?>
<html>
<head><title>Login Form</title></head>
<body bgcolor="beige">
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr><td colspan="3" bgcolor="gray" align="center">
  <font color="white" size="+5">
       <b>Login Form</b></font></td></tr>
 <tr>
  <td>
   <form action="dpr_login.php" method="post">
  <table border="0" width="100%">
    <?php
      if (isset($message_new))  
           echo "<tr><td colspan='2'><font color='red'><b>$message_new</b></td></tr>";
    ?>
    <tr><td align="right"><b>Your Login is: </b></td>
     <td><font color='red'><?php echo @$ftempID ?></font></td></tr>
    <tr><td align="right"><b>Default Password is: </b></td>
     <td><font color='red'>password</font>. Please enter a more secure one.</td></tr>
    <tr><td align="right"><b>New Password</b></td>
     <td><input type="password" name="npassword0" 
         value="<?php echo @$npassword0 ?>" 
             size="20" maxlength="20"></td></tr>
    <tr><td align="right"><b>Retype New Password</b></td>
     <td><input type="password" name="npassword1" 
         value="<?php echo @$npassword1 ?>" 
             size="20" maxlength="20"></td></tr>
    
   
    <tr><td>&nbsp;</td>
     <td align="left">
<?php
echo "
       <input type='hidden' name='dbName' value='$dbName'>
       <input type='hidden' name='ftempID' value='$ftempID'>
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
If you have questions, problems and/or suggestions for improvement, please send an email
to <a href="mailto:database.support@ncparks.gov">database.support@ncparks.gov</a>
</font></div>
</body></html>