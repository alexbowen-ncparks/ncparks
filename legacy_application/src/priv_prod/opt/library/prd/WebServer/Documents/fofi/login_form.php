<?php// extract($_REQUEST);//include("../../include/parkcodes.inc");?><html><head><title>Fort Fisher SRA Login Form</title></head><body bgcolor="beige"><body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"><table width="100%" border="0" cellpadding="5" cellspacing="0"> <tr><td colspan="3" bgcolor="gray" align="center">  <font color="white" size="+5">       <b>Login Form</b></font></td></tr> <tr>  <td>   <form action="login.php" method="POST">  <table border="0" width="100%">    <?php      if (isset($message_new))             echo "<tr><td colspan='2'><font color='red'><b>$message_new</b></td></tr>";    ?>    <tr><td align="right"><b>Login</b></td>     <td><input type="text" name="park"                value="<?php echo @$park ?>"                size="20" maxlength="20"></td></tr>    <tr><td align="right"><b>Password</b></td>     <td><input type="password" name="fpassword"          value="<?php echo @$fpassword ?>"              size="20" maxlength="20"></td></tr>           <tr><td>&nbsp;</td>     <td align="center">       <input type="submit" value="Login"></td>    </tr>   </table>   </form>  </td> </tr> <tr><td colspan="3" bgcolor="gray">&nbsp;</td></tr></table> <hr><div align="center"><font size="-1">If you have questions, problems and/or suggestions for improvement, please send an emailto <a href="mailto:tom.howard@ncmail.net">tom.howard@ncdenr.gov</a></font></div></body></html>