<?php

echo "<br />";  echo "<table><tr><th>Step2: Cash Receipts Journal- Enter Dates and DepositID     </th></tr></table><br />"; 
 /* 2022-07-01: ccooper - change for FYR rollover */
$fyear='2223';
 
 echo "<form  method='post' autocomplete='off' action='bank_deposits_menu_cc_test.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Fyear</font></th><th><font color='brown'>Deposit Dates</font><br />example:June1-June6<br >Enter: 06010606</th><th><font color='brown'>DepositID-Controllers</font></th></tr>";
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='f_year' type='text' size='5' id='f_year' value='$fyear' ></td>
             <td><input name='deposit_dates' type='text' size='20' id='deposit_dates'></td> 
             <td><input name='deposit_id' type='text' size='20' id='deposit_id'></td> 
             <td><input type=submit name=record_insert submit value=add></td>
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	  
echo "<input type='hidden' name='step' value='3'>";
echo "</form>";	


?>