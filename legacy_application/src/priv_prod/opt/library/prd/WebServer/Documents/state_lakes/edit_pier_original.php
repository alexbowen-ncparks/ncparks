<?php

session_start();
$level=$_SESSION['state_lakes']['level'];
if($level<3){$pass_park=$_SESSION['state_lakes']['select'];}


$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
       extract($_REQUEST);
   
       if($_POST['submit']=="Delete")
       		{
       		//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
			$sql = "SELECT contacts_id, pier_comment from piers where pier_id='$_POST[pier_id]'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
			$row=mysql_fetch_assoc($result); extract($row);
			
			$sql = "UPDATE contacts set comment=if(comment!='',concat(comment,'\\n pier comment = ','$pier_comment'), 'pier comment = $pier_comment') where id='$contacts_id'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
			
			$sql = "DELETE FROM piers where pier_id='$_POST[pier_id]'";
//echo "$sql"; exit;
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
			
	//		if($pier_comment!=""){$add=" and the following Pier Comment added to the Owner/Agent comments: $pier_comment<br /><br />";}
			
       		echo "Record was successfully deleted$add. You may close this window.";exit;
       		}    
       
       if($_POST['submit']=="Update")
       		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		
       		if($_POST['park']==""){echo "Please specify a park.";exit;}
       		
       		$skip=array("submit","submit","billing_title","billing_last_name","billing_first_name","billing_city","billing_state","billing_add_1");
       	
       		foreach($_POST AS $field=>$value)
       				{
       					if(in_array($field,$skip)){continue;}       					
       					$clause.=$field."='".$value."',";
       				}
       						$id=$_POST['contacts_id'];
       			$clause="set boatstall='$boatstall', non_conforming='$non_conforming',".rtrim($clause,",")." where pier_id='$pier_id'";
			$sql = "Update piers $clause";
//echo "$sql"; exit;
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection"); 
			$clause="";
       				
			$edit=$pier_id;
			$message="Update was successful.<br />Close window when done.";
       		}
       

$t1_fields="t1.park,t1.pier_id,t1.pier_number,t1.contacts_id,t1.fee,t1.pier_payment,t1.check_number,t1.pier_comment,t1.mod_fee_amt,t1.mod_pay_date,t1.pier_mod_check,t1.transfer_fee,t1.trans_pay_date,t1.trans_check,t1.boatstall,t1.non_conforming,t1.pier_type,t1.pier_length,t1.delinq_yrs,t1.lat,t1.lon";

$t2_fields="t2.billing_title,t2.billing_first_name,t2.billing_last_name,t2.billing_city,t2.billing_state,t2.billing_zip";

$sql = "SELECT $t1_fields,$t2_fields
FROM piers as t1
LEFT JOIN contacts as t2 on t1.contacts_id=t2.id
WHERE  t1.pier_id='$edit'
"; //echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result)){$ARRAY[]=$row;}

if(!isset($ARRAY)){echo "$message";exit;}

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

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}

function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=1024,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}
</script></head>
";

echo "<body bgcolor='beige'><form method='POST' name='pierForm'><div align='center'><table><tr><td><table cellpadding='5' border='1' bgcolor='#FFF0F5'>";

$exclude=array("billing_title","billing_first_name","billing_last_name","billing_city","billing_state","billing_zip");

$radio=array("pier_type");
$pier_type_array=array("p"=>"private","c"=>"commercial","s"=>"state/federal");
$checkbox=array("boatstall","non_conforming","pier_mod_y_n","transfer_y_n");

	$readonly=array("pier_id","park","contacts_id");
	foreach($ARRAY as $num=>$row)
		{ 
			foreach($row as $fld=>$value){
				if(in_array($fld,$exclude)){continue;}
				$RO="";
				if(in_array($fld,$readonly)){$RO="readonly";}
				if($fld=="pier_number")
					{
						echo " <tr>
						<td align='center'><b>Pier Number</b></td>
						<td align='center'><font size='+2' color='purple'>$value</font><input type='text' name='$fld' value=\"$value\" size='7'></td>
						</tr>";
						$pier_number=$value;
						continue;
					}
		
				echo " <tr valign='top'><td align='right'>$fld</td>";
				
		$fld_array=$fld;
				$item="<input type='text' name='$fld_array' value=\"$value\" size='37'$RO>$img";
				
				if($fld=="lat"){$lat=$value;}
				if($fld=="lon"){$lon=$value;}
				if($fld=="park"){$park=$value;}
				if($fld=="pier_id"){$pier_id=$value;}
				
				if($fld=="pier_comment"){
					if($value){$d="block";}else{$d="none";}
					$item="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'>$related</font></div>

					<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br><textarea name='$fld_array' cols='55' rows='15'>$value</textarea></div>";
				}
				
				if($fld=="contacts_id")
					{
					if($level>3){$RO="";}
						$item="<input type='text' name='$fld' value=\"$value\" size='4'$RO> <input type='button' value='Pick Owner/Agent' onclick=\"return popitup('pick_owner.php?form=pier&parkcode=$row[park]')\"><br />
							<br />billing_title<br />
						<input type='text' name='billing_title' value=\"$row[billing_title]\" readonly>
							<br />billing_last_name<br />
						<input type='text' name='billing_last_name' value=\"$row[billing_last_name]\" readonly>
							<br />billing_first_name<br />
						<input type='text' name='billing_first_name' value=\"$row[billing_first_name]\" readonly>
							<br />billing_add_1<br />
						<input type='text' name='billing_add_1' value=\"$row[billing_add_1]\" readonly>
							<br />billing_city<br />
						<input type='text' name='billing_city' value=\"$row[billing_city]\" readonly>
							<br />billing_state<br />
						<input type='text' name='billing_state' value=\"$row[billing_state]\" readonly>";
						$bln=$row['billing_last_name'];
						if($bln==""){$bln=$row[billing_title];}
					}
			
			
			if(in_array($fld,$checkbox))
				{
				if($value=="x"){$ck="checked";}else{$ck="";}
				echo "<td><input type='checkbox' name='$fld' value='x' $ck></td></tr>";
				continue;
				}
				
			if($fld=="pier_payment")
				{
			//	$RO="readonly";
				$item="<input type='text' name='$fld' value=\"$value\" size='11' id=\"f_date_c\" $RO><img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";
				}
				
			if(in_array($fld,$radio))
				{	
					$var_array=${$fld."_array"};
					foreach($var_array as $k=>$v)
						{
							{$val=$k;}
								if($value==$k)
									{
									$ck="checked";
									}
							$var_item.="<input type='radio' name='$fld' value='$val' $ck>$v ";
							$ck="";
						}
						$item=$var_item; $var_item="";
				}
			echo "<td>$item</td></tr>";
					
			}
		}

	include("lat_long_defaults.php");
	$lat_lon=${$park};
	$object=$park." [pier_id=".$pier_id."] [pier_num=".$pier_number."] - $bln";
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
	echo "</table>";
	
echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
    });
</script>";

echo "
</td><td align='center'>
	<input type='hidden' name='pier_id' value='$row[pier_id]'>
	<input type='submit' name='submit' value='Update'>
	</td><td>$message
	<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td></tr>";
	echo "</table></td></tr>";
	echo "</table></div></form></body></html>";

?>