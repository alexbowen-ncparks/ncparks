<?php

//echo "Editing of ramps has not been developed yet.";exit;


$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
       extract($_REQUEST);
       
       if($_POST['submit']=="Delete")
       		{
			$sql = "SELECT contacts_id, ramp_comment from ramp where ramp_id='$_POST[ramp_id]'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
			$row=mysql_fetch_assoc($result); extract($row);
			
			$sql = "UPDATE contacts set comment=if(comment!='',concat(comment,'\\n ramp comment = ','$ramp_comment'), 'ramp comment = $ramp_comment')  where id='$contacts_id'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
			
			$sql = "DELETE FROM ramp where ramp_id='$_POST[ramp_id]'";
//echo "$sql"; exit;
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
       		echo "Record was successfully deleted. You may close this window.";exit;
       		}
       		
       
       if($_POST['submit']=="Update")
       		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip=array("submit","ramp_id","billing_title","billing_last_name","billing_first_name","billing_city","billing_state","billing_add_1");
       	
       		foreach($_POST AS $field=>$value)
       				{
       					if(in_array($field,$skip)){continue;}       					
       					$clause.=$field."='".$value."',";
       				}
       						$id=$_POST['contacts_id'];
       						$ramp_id=$_POST['ramp_id'];
       			$clause="set ".rtrim($clause,",")." where ramp_id='$ramp_id'";
			$sql = "Update ramp $clause";
//echo "$sql"; exit;
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection"); 
			$clause="";
       				
			$edit=$ramp_id;
			$message="Update was successful.<br />Close window when done.";
       		}
       
//$t1_fields="t1.*";
$t1_fields="t1.park,t1.year,t1.ramp_id,t1.contacts_id,t1.ramp_receipt,t1.check_number,t1.fee,t1.ramp_comment,t1.delinq_yrs,t1.ramp_size,t1.pier_number,t1.lat,t1.lon";

$t2_fields="t2.billing_title,t2.billing_first_name,t2.billing_last_name, t2.billing_add_1,t2.billing_city,t2.billing_state,t2.billing_zip";

$sql = "SELECT $t1_fields,$t2_fields
FROM ramp as t1
LEFT JOIN contacts as t2 on t1.contacts_id=t2.id
WHERE  t1.ramp_id='$edit'
"; //echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result)){$ARRAY[]=$row;}

echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>
  
  <script language=\"JavaScript\">

// single item
function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=1024,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}
</script></head>
";

echo "<body bgcolor='beige'><form method='POST' name='rampForm'><div align='center'><table><tr><td><table cellpadding='5' border='1' bgcolor='#FFF0F5'>";

$exclude=array("billing_title","billing_first_name","billing_add_1","billing_last_name","billing_city","billing_state","billing_zip");
	
	$readonly=array("ramp_id","park","contacts_id","year");
	foreach($ARRAY as $num=>$row)
		{ 
			foreach($row as $fld=>$value){
				if(in_array($fld,$exclude)){continue;}
				$RO="";
				if(in_array($fld,$readonly)){$RO="readonly";}
		
				echo " <tr valign='top'><td align='right'>$fld</td>";
				
		$fld_array=$fld;
				$item="<input type='text' name='$fld_array' value=\"$value\" size='37'$RO>";
				
				if($fld=="lat"){$lat=$value;}
				if($fld=="lon"){$lon=$value;}
				if($fld=="park"){$park=$value;}
				if($fld=="pier_number"){$pier_number=$value;}
					
				if($fld=="ramp_id")
					{
					$ramp_id=$value;
					}
					
				if($fld=="ramp_size")
					{
					$item="<textarea name='$fld_array' rows='1' cols='15'>$value</textarea>";
					}
					
				if($fld=="ramp_comment"){
					if($value){$d="block";}else{$d="none";}
					$item="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> toggle &#177</a></div>

					<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br><textarea name='$fld_array' cols='55' rows='15'>$value</textarea></div>";
				}
				
				if($fld=="contacts_id")
					{
					if(@$level>3){$RO="";}
						$item="<table><tr><td><input type='text' name='$fld' value=\"$value\" size='4'$RO> <input type='button' value='Pick Owner/Agent' onclick=\"return popitup('pick_owner.php?form=ramp&parkcode=$row[park]')\"></td></tr>
							<tr><td colspan='2'>billing_title<br />
						<input type='text' name='billing_title' value=\"$row[billing_title]\" size='35' readonly></td></tr>
							<tr><td>billing_last_name<br />
						<input type='text' name='billing_last_name' value=\"$row[billing_last_name]\" readonly></td>
							<td>billing_first_name<br />
						<input type='text' name='billing_first_name' value=\"$row[billing_first_name]\" readonly></td></tr>
							<tr><td colspan='2'>billing_add_1<br />
						<input type='text' name='billing_add_1' value=\"$row[billing_add_1]\" size='35' readonly></td></tr>
							<tr><td>billing_city<br />
						<input type='text' name='billing_city' value=\"$row[billing_city]\" readonly></td>
						<td>billing_state<br />
						<input type='text' name='billing_state' value=\"$row[billing_state]\" size='4' readonly></td></tr></table>";
						$bln=$row['billing_last_name'];
						if($bln==""){$bln=$row['billing_title'];}
					}
				
			if($fld=="ramp_receipt")
				{
			//	$RO="READONLY";
				$item="<input type='text' name='$fld' value=\"$value\" size='11' id=\"f_date_c\" $RO><img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";
				}
				
			echo "<td>$item</td></tr>";
			
			if($fld=="lon"){echo "</table></td><td><table cellpadding='5' border='1'>";}
			
			
			}
		}
	
	include("lat_long_defaults.php");
	$lat_lon=${$park};
	$object=$park." [ramp_id=".$ramp_id."] [pier_num=".$pier_number."] - $bln";
	$zoom=$lat_lon['zoom'];
	echo "<tr>";
	if($lat)
		{
		echo "<td>
		Google Map => <a href='http://maps.google.com/maps?q=$lat,$lon+($object)&iwloc=A&hl=en' target='_blank'>GM </a>
		</td>";
		}
	if($lat=="")
		{
		$lat=$lat_lon['lat'];
		$lon=$lat_lon['lon'];		
		}
	echo "<td>
		<input type='button' value='Map It!' onclick=\"return popitup('lat_long.php?lat=$lat&lon=$lon&zoom=$zoom&object=$object')\">
	</td>";
	echo "</tr>";
	
echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
    });
</script>";

echo "</td>";



echo "<td align='center'>
	<input type='hidden' name='ramp_id' value='$ramp_id'>
	<input type='submit' name='submit' value='Update'>
	</td><td>$message
	<input type='hidden' name='ramp_id' value='$ramp_id'>
	<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td></tr>";
	
	
	echo "</table></div></form></html>";

?>