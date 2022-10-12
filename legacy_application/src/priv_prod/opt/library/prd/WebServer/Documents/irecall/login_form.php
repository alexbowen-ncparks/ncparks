<html>
<head><title>
iRECALL Database</title></head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table border="0" cellpadding="5" cellspacing="0">
 <tr><td colspan="3" bgcolor="gray" align="center">
  <font color="white" size="+3">
<b>Login Form</b>
<h3>iRECALL Database</h3></td></tr>
 <tr>
  <td width="10%" valign="top" colspan='5'>
   <font size="+1"><b>A successful Login will allow you to access this site.</b></font>
   <p>
   </table>
   <!-- form for customer login -->
  
   <table border="0"> <form action="login.php" method="post">
    <?php
    extract($_REQUEST);
      if (isset($message_new))
          echo "<tr><td colspan='5'><font color='red'>$message_new</font> </td></tr>";
          echo "<tr><td colspan='5'><font color='red'>Login for Retired Employees</font> </td></tr>";
    ?>
    <tr><td align="left" colspan='3'><b>Username</b> <input type="text" name="ftempID" size="20" maxsize="20"> Your last name.</td></tr>
    
    <tr><td align="left" valign='top'><b>Password</b> <input type="password" name="fpassword"  size="20" maxsize="20"></td><td width='500'>Last 4 digits of the phone number known to this site. (If this site doesn't have your phone, you will not be able to login. In that case contact John Sharpe at <a href="mailto:jlsharpe@frontier.com">jlsharpe@frontier.com</A> and ask him to update your record with a phone number.)</td></tr>
    <tr><td align="center" colspan="2">
      <br><input type="submit" name="log" value="Enter"></td></tr>
   </form>
   </table>
    <table border="0"> <form action="login.php" method="post">
    <?php
    extract($_REQUEST);
      if (isset($message_new))
          echo "<tr><td colspan='5'><font color='red'>$message_new</font> </td></tr>";
          echo "<tr><td colspan='5'><font color='red'>Login for Current Employees</font> </td></tr>";
    ?>
    <tr><td align="left"><b>Username</b> <input type="text" name="ftempID" size="20" maxsize="20"> Your last name plus last four digits of your SSN.</td></tr>
    
    <tr><td align="left"><b>Password</b> <input type="password" name="fpassword"  size="20" maxsize="20"></td><td width='500'></td></tr>
    <tr><td align="center" colspan="2">
      <br><input type="submit" name="log" value="Enter"></td></tr>
   </form>
   </table>
<div align="center"><font size="-1">
If you have questions, or problems, please send an email
to <a href="mailto:tom.howard@embarqmail.com">tom.howard@embarqmail.com</A>
</font></div>
</body></html>
