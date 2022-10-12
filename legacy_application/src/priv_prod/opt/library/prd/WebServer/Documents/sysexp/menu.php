<?php
//  include("../../include/authSYSEXP.inc");
include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");
$database="sysexp";
mysqli_select_db($connection,$database)
               or die ("Couldn't select database.");       
if(empty($_SESSION)){session_start();}
//print_r($_REQUEST);
//print_r($_SESSION); exit;
$logname=$_SESSION['logname'];
$print = "
<div align='center'><font size='-1'>
Report any problems to <a href='mailto:tom.howard@ncmail.net'>tom.howard@ncmail.net</A>
</font></div>";
echo "
<html>
<head>
<title>System Expansion Website</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
</head>
<body bgcolor='#FFFFFF'>

      <form method='post' action='button.php'>
      
<table width='100%' border='1' align='center' height='100%'>
  <tr bgcolor='#CCCCCC' bordercolor='#003333'> 
    <td colspan='4'> 
      <div align='center'><font size='5' color='#006600'><b><font face='Verdana, Arial, Helvetica, sans-serif'>Welcome 
        to the <br> NC Div. of Parks and Recreation
        <br>
        <font color='blue'>System Expansion Website</font></b></font></div>
    </td>
  </tr>  
  <tr bgcolor='#CCCCCC' bordercolor='#003333'> 
    <td colspan='2' align='center'><u>Specific Summaries</u>
           <BR><BR>
           <input type='submit' name='Submit' value='  Archeological Summary  '>
          <BR><BR><input type='submit' name='Submit' value='  Biological Summary  '>
          <BR><BR><input type='submit' name='Submit' value='  Geological Summary  '>
          <BR><BR><input type='submit' name='Submit' value='  Scenic Summary  '>
          <BR><BR><input type='submit' name='Submit' value='  Species Summary  '>
          <BR><BR><input type='submit' name='Submit' value='  Recreation Summary  '>
           </td>
    <td width='44%'> 
        <div align='center'><u>Concatenated Summaries</u>
           <BR><BR>
           <input type='submit' name='Submit' value='  Detailed Summary  '>
     <BR><BR><input type='submit' name='Submit' value='  General Summary  '>
             </p>
        </div>
    </td>
    <td width='27%' align='center'>
          <p>Other Reports Can Be Added<BR>
         <input type='submit' name='Submit' value='  Report ?  '>
       <input type='submit' name='Submit' value='  Report ?  '>
             </p></td>
  </tr><tr><td colspan='4'>$print</td></tr></select>
</table>
      </form>
<div align='center'></div>
</body>
</html>";
?>