
<?php
echo "<table>";
echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input3').focus();
}

function validateForm()
{
var x=document.forms['form3']['input3'].value;
if (x==null || x=='')
  {
  alert('Please enter Comment');
  return false;
  }
 
  
}


</script>


";
//echo "<tr>";
//echo "<table>";
/*
echo "<th align='center'><font size='5' color='brown'><b>Messages</b></font><img height='40' width='40' src='/budget/infotrack/icon_photos/message_green1.png' alt='picture of green check mark'></img></font></th>";
*/
//echo "</table>";
echo "<form method='post' action='/budget/infotrack/date_range_module.php' name='form3' onsubmit='return validateForm()'  >";
//echo "<form method='post' action='' name='form3' onsubmit='return validateForm()'  >";

//echo "<td><input name='location' type='text'  value='$concession_location' autocomplete='off'></td>";
/*
echo "<td align='center'><font size='5' color='brown'><b>Messages</b></font><img height='40' width='40' src='/budget/infotrack/icon_photos/message_green1.png' alt='picture of green check mark'></img></font></td></tr>";
*/




echo "<tr><td><textarea name= 'comment_note' rows='12' cols='35' placeholder='Type Message here' id='input3' ></textarea></td></tr>";            
      
	
	 echo "<tr><td><input type=submit name=submit value=Add_Message>";
	 
	    
	 echo "<input type='hidden' name='tempID' value='$tempID'>";	   
	 echo "<input type='hidden' name='concession_location' value='$concession_location'>";	   
	 echo "<input type='hidden' name='pid' value='$pid'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";

?>