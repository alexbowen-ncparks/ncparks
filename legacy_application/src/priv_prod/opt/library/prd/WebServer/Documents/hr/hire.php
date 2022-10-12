<?php
$database="hr";
include("../../include/connectROOT.inc"); // database connection parameters
mysql_select_db($database,$connection);
extract($_POST);
extract($_REQUEST);

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
date_default_timezone_set('America/New_York');
// *********** Add Person to a Position *************
IF(@$_POST['submit']=="Update")
	{
	session_start();
		$user=$_SESSION['hr']['tempID'];
		$date=date('Ymd');
		$track=$user."-".$date;
		if(!isset($time_entry)){$time_entry="";}
			$query="UPDATE employ_position SET time_entry='$time_entry', track=concat(track,',','$track','H')
			where id='$id'";
		//	echo "$query";exit;
			$result = mysql_query($query) or die ("Couldn't execute query Update. $query");
				
			header("Location: new_hire.php?id=$position_id&tempID=$tempID&beacon_num=$beacon_num&submit=Find");
	}



// ******* Start Display ********
echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>";
  
include("../css/TDnull.php");

$sql="Select *  From `employ_position` where tempID='$tempID' and parkcode='$parkcode' and beacon_num='$beacon_num'";
 $result = @MYSQL_QUERY($sql,$connection);
// echo "$sql";
$row=@mysql_fetch_assoc($result); 

//echo "<pre>"; print_r($row); echo "</pre>";  //exit;

echo "<table align='center'><tr><td align='center'><h2><font color='purple'>Seasonal Employment Tracking</font></h2></td></tr>";

echo "<tr><td colspan='3' align='center'>Return to Seasonal Employee <a href='http://www.dpr.ncparks.gov/hr/new_hire.php'>Home</a> Page</td></tr>
</table>";


echo "<form action='' method='POST'>";

echo "<table align='center' cellpadding='7'><tr><td colspan='7' align='center'><h2>Assign the Hiring Date.</h2></td></tr>";

$j=0;
$skip=array("id","tempID");

$edit=array("time_entry");


	// ******** Override id *********
	$position_id=$id;
if(!empty($row))	
	{
	foreach($row as $k=>$v)
		{
		$j++;
			$h="";
			if(in_array($k,$skip)){
					${$k}=$v;
					continue;}
			
			
					$inputField=$v;
					
			
			if(in_array($k,$edit))
				{
				if($k=="time_entry"){$k="first day @ work";}
				if($v!="0000-00-00"){$h="First day @ work has been entered.";}
					$inputField="<img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
						onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />&nbsp;<input type='text' name='time_entry' value='$v' size='10' id=\"f_date_c\" READONLY>";
				}
			
			echo "<tr><th align='right'>$k</th><td>$inputField $h</td></tr>";
		}
	}

echo "<tr><td align='center'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='position_id' value='$position_id'>
<input type='hidden' name='tempID' value='$tempID'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
<input type='submit' name='submit' value='Update'>
</td></tr></table></form>

<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
	    });
	</script>
</html>";

?>
