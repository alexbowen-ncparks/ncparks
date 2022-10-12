<html>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div align="center">
<table border="0" cellpadding="5" cellspacing="0">
 <tr><td colspan="3" bgcolor="purple" align="center">
  <font color="white" size="+3">
<b>Login Form</b><br>Museum of Natural Sciences</font></td></tr>
 <tr>
  <td width="33%" valign="top">
   <font size="+1"><b>Login for registered users to
   <?php
    extract($_REQUEST);
//    echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
    echo " the <font color='red'>$db</font> database.";
    ?></b></font>
   <p>
   </table>
   <!-- form for customer login -->
   <form action="login_main.php" method="post">
   <table border="0">
    <?php
      if (isset($message))
          echo "<tr><td colspan='5'><font color='red'>$message</font> </td></tr>";
    ?>
    <tr><td></td><td align=right><b>Username</b></td>
     <td><input type="text" name="fusername" size="20" maxsize="20">
     </td><td colspan="2"></td></tr>
    <tr><td></td><td align="right"><b>Password</b></td>
     <td><input type="password" name="fpassword" 
               size="20" maxsize="20"></td><td colspan="2"></td></tr>
    <tr><td align="center" colspan="3">
    
    <?php
    echo "<input type='hidden' name='db' value='$db'>";
    ?>
    
      <br><input type="submit" name="log" value="Enter"></td></tr>
   </table>
   </form>
   </div>
<div align="center"><p>
For initial log-in access to this database, please send an email
to <a href="mailto:christina.cucurullo@naturalsciences.org">christina.cucurullo@naturalsciences.org</A>
</font></p></div>
<div align="center"><font size="-1"><p>
If you have questions, or problems, please send an email
to <a href="mailto:christina.cucurullo@naturalsciences.org">christina.cucurullo@naturalsciences.org</A>
</font></p></div>
</body></html>
