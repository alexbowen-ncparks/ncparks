<html><head><title>Edit a WAR Activity</title></head><body><?phpini_set('display_errors',1);$database="war";include("../../include/auth.inc"); // used to authenticate usersinclude("../../include/connectROOT.inc"); include_once("../../include/get_parkcodes.php");mysql_select_db($database,$connection);date_default_timezone_set('America/New_York');include_once("menu.php");extract($_REQUEST);$sql = "SELECT * FROM style order by topic";//echo "$sql";$result = mysql_query($sql) or die ("Couldn't execute query. $sql");while ($row=mysql_fetch_row($result)){$idArray[]=$row[0];$topicArray[]=$row[1];}?><?php/* Use the INCLUDE statement to load a Function file*/include ("include/functions.php");echo "<table><tr><td><form name=form> <select name=\"site\" size=\"1\" onChange=\"formHandler(this.form)\">";echo "<option value=''>Style Topics\n";for ($i=0;$i<count($topicArray);$i++){     echo "<option value='style.php?c=1&submit_label=Find&id=$idArray[$i]'>$topicArray[$i]\n";}echo "</select></form></td><td><form name=popupform><input type=button name=choice onClick=\"window.open('tips.php','popuppage','width=750,height=600,top=100,left=500,scrollbars=yes');\" value=\" >> WAR Tips << \"></form></td></tr></table>";echo "<table width='50%' cellpadding='7'><tr><td colspan='2'><font color='green' size='+1'>Please enter any search criteria(um):</font></td></tr><form action='edit.php' method='post'><tr><td><b>Program:</b></td></tr>";  $programArray=array("adm"=>"Administration","con"=>"Design and Development","exh"=>"Exhibits","ie"=>"I&E","ope"=>"Operations","pla"=>"Planning","res"=>"Resource Management","tra"=>"Trails");echo "<tr>";$i=1;while (list($key,$val)=each($programArray)){if($i==5){echo "</tr><tr>";}echo "<td><input type='radio' name='section' value='$key'> $val</td>";$i++;}echo "</tr></table><table cellpadding='7'>    <tr>      <td height='39'><b>Week:</b>  <select name='weekTest'>";$week0 = date('W'); //$week_1 = $week-1; for ($n=0;$n<=53;$n++){$weekList=getWeekNumber($n);if ($n == $week0){echo "<option value='$n' selected>$weekList\n";} ELSE {echo "<option value='$n'>$weekList\n";}}echo "</select></td><td>Ignore Week <input type='checkbox' name='ignore' value='1'></td></tr></table>";?>       <table><tr>       <td width="8%" height="29"><b>Date of Activity:</b></td>      <td colspan="4" height="29">         <input type="text" name="month" size="3" maxlength="2">        Month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year:&nbsp;         <?php $thisYear = date('Y'); $thisMonth = date('M');if ($thisMonth == 1) {        $thisYear = $thisYear-1;         echo "<input type='radio' name='yearRadio' value='$thisYear'>";echo "$thisYear";$thisYear = $thisYear+1;         echo "&nbsp;&nbsp;<input type='radio' name='yearRadio' value='$thisYear'>";echo "$thisYear";        echo "&nbsp;&nbsp;<input type='text' name='yearText' size='4' maxlength='4'>        Enter Any Year <="; echo "$thisYear";}elseif ($thisMonth != 1) {$thisYear = $thisYear;         echo "&nbsp;&nbsp;<input type='radio' name='yearRadio' value='$thisYear' checked>";echo "$thisYear";echo "&nbsp;&nbsp;<input type='text' name='yearText' size='7' maxlength='4'>        Enter Any Year <="; echo "$thisYear";}?> <br>      </td>      <td width="19%" height="29">&nbsp;</td>    </tr>    <tr>       <td width="8%"><b>Park:</b></td>      <td colspan="3" height="39">         <input type="text" name="park" size="8" maxlength="4"> &nbsp;&nbsp;&nbsp; <b>District:</b><select name="dist"><option value=""><option value="EADI">EADI<option value="NODI">NODI<option value="SODI">SODI<option value="WEDI">WEDI</select>    </tr>    <tr>       <td width="8%"><b>Title:</b></td>      <td colspan="5">         <input type="text" name="title" size="80" maxlength="100">      </td>    </tr><tr>       <td width="8%"><b>Body:</b></td>      <td colspan="5">         <input type="text" name="body" size="80" maxlength="100">      </td>    </tr>    <tr>      <br><br><td colspan="5"> </tr>  </table> <table width="50%" cellpadding="7"><tr><td width = "25%"><input type="reset" name="Reset" value="Reset"></td width = "25%"><td width = "25%"><input type="submit" name="Submit" value="Search for Record(s)"></td></form>   </tr></table></form></body></html>