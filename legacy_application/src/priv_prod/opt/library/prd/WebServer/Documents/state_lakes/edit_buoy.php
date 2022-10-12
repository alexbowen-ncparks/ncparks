<?php

//echo "Editing of buoys has not been developed yet.";exit;
session_start();
$level=$_SESSION['state_lakes']['level'];

$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
       extract($_REQUEST);
      
       if(@$_POST['submit']=="Delete")
       		{
			$sql = "SELECT contacts_id, buoy_comment from buoy where buoy_id='$_POST[buoy_id]'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
			$row=mysql_fetch_assoc($result); extract($row);
			
			$sql = "UPDATE contacts set comment=if(comment!='',concat(comment,'\\n buoy comment = ','$buoy_comment'), 'buoy comment = $buoy_comment')  where id='$contacts_id'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
		//	exit;
			
			$sql = "DELETE FROM buoy where buoy_id='$_POST[buoy_id]'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
			
			
       		echo "Record was successfully deleted. You may close this window.";exit;
       		}     
       
       if(@$_POST['submit']=="Update")
       		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip1=array("year","month","day","submit","buoy_id","billing_title","billing_last_name","billing_first_name","billing_city","billing_state","billing_add_1");       		$skip2=array("submit","buoy_id","billing_title","billing_last_name","billing_first_name","billing_city","billing_state","billing_add_1");
       	
       		foreach($_POST AS $field=>$value)
       				{
       					if(in_array($field,$skip1)){continue;}
					$test=explode("-",$field);
					if(in_array($test[0],$skip1)){continue;}
					
       					$clause.=$field."='".$value."',";
       				}
       						$id=$_POST['contacts_id'];
       						$buoy_id=$_POST['buoy_id'];
       						       						
// menu.php has the javascript that controls calendars - calendar(x)
$date_array=array("buoy_receipt"=>'1',"app_date"=>'2');

			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip2) OR $v=="")
					{continue;}
				foreach($date_array as $k1=>$v1)
					{
					if($k=="year-field".$v1)
						{
						if($v==""){$temp=$k1."='";}else{$temp=$k1."='".$v."-";}
						}
					if($k=="month-field".$v1)
						{
						if($v==""){$temp.=$v;}else{$temp.=$v."-";}						
						}
					if($k=="day-field".$v1)
						{$temp.=$v."',";}
						
					$clause.=$temp; $temp="";
					}
				}
				
       			$clause="set ".rtrim($clause,",")." where buoy_id='$buoy_id'";
			$sql = "Update buoy $clause";
//echo "$sql"; exit;
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection"); 
			$clause="";
       				
			$edit=$buoy_id;
			$message="Update was successful.<br />Close window when done.";
       		}
       
$t1_fields="t1.park,t1.year,t1.buoy_id,t1.buoy_number,t1.contacts_id,t1.fee,t1.buoy_receipt,t1.check_number,t1.buoy_comment,t1.app_fee,t1.app_date, t1.buoy_app_check,t1.buoy_assoc,t1.buoy_comment,t1.delinq_yrs,t1.check_number,t1.pier_number,t1.lat,t1.lon";

$t2_fields="t2.billing_title,t2.billing_first_name,t2.billing_last_name, t2.billing_add_1,t2.billing_city,t2.billing_state,t2.billing_zip";

$sql = "SELECT $t1_fields,$t2_fields
FROM buoy as t1
LEFT JOIN contacts as t2 on t1.contacts_id=t2.id
WHERE  t1.buoy_id='$edit'
"; //echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result)){$ARRAY[]=$row;}

echo "<html><head>";
?>

<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/button/assets/skins/sam/button.css" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/container/assets/skins/sam/container.css" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/calendar/assets/skins/sam/calendar.css" />
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/yuiloader/yuiloader-min.js"></script>

<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/dom/dom-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/event/event-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/dragdrop/dragdrop-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/element/element-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/button/button-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/container/container-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/calendar/calendar-min.js"></script>



<script type="text/javascript">
function calendar(calendarID)
{
		var Event = YAHOO.util.Event,
			Dom = YAHOO.util.Dom;


		Event.onDOMReady(function () {
	
			window["oCalendarMenu"+calendarID];
			var oCalendarMenu2;
	
			window["onButtonClick"+calendarID] = function () {
				
				// Create a Calendar instance and render it into the body 
				// element of the Overlay.
	
				window["oCalendar"+calendarID] = new YAHOO.widget.Calendar("buttoncalendar"+calendarID, window["oCalendarMenu"+calendarID].body.id);

				//get the values from the form fields for the FROM calendar and use these to set the selected date and the page date properties of the calendar
				
				window["month"+calendarID]=Dom.get("month-field"+calendarID).value;
				window["day"+calendarID]=Dom.get("day-field"+calendarID).value;	
				window["year"+calendarID]=Dom.get("year-field"+calendarID).value;
					if (window["year"+calendarID] && window["month"+calendarID] && window["day"+calendarID]){			
						window["oCalendar"+calendarID].cfg.setProperty('selected', window["month"+calendarID]+"/"+window["day"+calendarID]+"/"+window["year"+calendarID]);
						window["oCalendar"+calendarID].cfg.setProperty('pagedate', new Date(window["month"+calendarID]+"/"+window["day"+calendarID]+"/"+window["year"+calendarID]), true); 
					}
					
				//render the from calendar	
					window["oCalendar"+calendarID].render();
				
	
				// Subscribe to the Calendar instance's "select" event to 
				// update the month, day, year form fields when the user
				// selects a date.
	
					window["oCalendar"+calendarID].selectEvent.subscribe(function (p_sType, p_aArgs) {
	
					var aDate;
	
					if (p_aArgs) {
							
						aDate = p_aArgs[0][0];
						
						//This modification is done to cater calendar out from yui to give always the leading zeros for months and days, in case they dont have
						var month = ''+aDate[1]+''; //convert month into a string
						var day = ''+aDate[2]+'';	//converty day into a string
						var year = ''+aDate[0]+'';	//converty year into a string 
						
						if (1 === month.length) {month = '0' + month;} //embed the preceding 0 if month is of 1 digit
						if (1 === day.length) {day = '0' + day;} //emebed the preceding 0 if day is of 1 digit

						
						Dom.get("month-field"+calendarID).value = month;
						Dom.get("day-field"+calendarID).value = day;
						Dom.get("year-field"+calendarID).value = year;
	
					}
					
					window["oCalendarMenu"+calendarID].hide();
				
				});
	
	
				// Pressing the Esc key will hide the Calendar Menu and send focus back to 
				// its parent Button
	
				Event.on(window["oCalendarMenu"+calendarID].element, "keydown", function (p_oEvent) {
				
					if (Event.getCharCode(p_oEvent) === 27) {
						window["oCalendarMenu"+calendarID].hide();
						this.focus();
					}
				
				}, null, this);
				
				
				window["focusDay"+calendarID] = function () {

					window["oCalendarTBody"+calendarID] = Dom.get("buttoncalendar"+calendarID).tBodies[0],
						window["aElements"+calendarID] = window["oCalendarTBody"+calendarID].getElementsByTagName("a"),
						window["oAnchor"+calendarID];

					
					if (window["aElements"+calendarID].length > 0) {
					
						Dom.batch(window["aElements"+calendarID], function (element) {
						
							if (Dom.hasClass(element.parentNode, "today"+calendarID)) {
								window["oAnchor"+calendarID] = element;
							}
						
						});
						
						
						if (!window["oAnchor"+calendarID]) {
							window["oAnchor"+calendarID] = window["aElements"+calendarID+"[0]"];
						}


						// Focus the anchor element using a timer since Calendar will try 
						// to set focus to its next button by default
						
						YAHOO.lang.later(0, window["oAnchor"+calendarID], function () {
							try {
								window["oAnchor"+calendarID].focus();
							}
							catch(e) {}
						});
					
					}
					
				};


				// Set focus to either the current day, or first day of the month in 
				// the Calendar	when it is made visible or the month changes
	
				window["oCalendarMenu"+calendarID].subscribe("show", window["focusDay"+calendarID]);
				window["oCalendar"+calendarID].renderEvent.subscribe(window["focusDay"+calendarID], window["oCalendar"+calendarID], true);
	

				// Give the Calendar an initial focus
				
				window["focusDay"+calendarID].call(window["oCalendar"+calendarID]);
	
	
				// Re-align the CalendarMenu to the Button to ensure that it is in the correct
				// position when it is initial made visible
				
				window["oCalendarMenu"+calendarID].align();
				
	
				// Unsubscribe from the "click" event so that this code is 
				// only executed once
	
				this.unsubscribe("click", window["onButtonClick"+calendarID]);
			
			};
			// Create an Overlay instance to house the Calendar instance
			window["oCalendarMenu"+calendarID] = new YAHOO.widget.Overlay("calendarmenu"+calendarID, { visible: false });
			// Create a Button instance of type "menu"
			window["oButton"+calendarID] = new YAHOO.widget.Button({ 
												type: "menu", 
												id: "calendarpicker", 
												//label: "Choose A Date", 
												menu: window["oCalendarMenu"+calendarID], 
												container: "datefields"+calendarID });
	
			window["oButton"+calendarID].on("appendTo", function () {
	
				// Create an empty body element for the Overlay instance in order 
				// to reserve space to render the Calendar instance into.
		
				window["oCalendarMenu"+calendarID].setBody("&#32;");
				window["oCalendarMenu"+calendarID].body.id = "calendarcontainer"+calendarID;
			
			});

			// Add a "click" event listener that will render the Overlay, and 
			// instantiate the Calendar the first time the Button instance is 
			// clicked.
			window["oButton"+calendarID].on("click", window["onButtonClick"+calendarID]);
		});
	}
	
function toggleDisplay(objectID)
	{
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
</script>
<script type="text/javascript">
calendar(1);calendar(2);calendar(3);
</script>
</head>

<?php


echo "<body bgcolor='beige'  class=\"yui-skin-sam\"><form method='POST' name='buoyForm'><div align='center'><table><tr><td><table cellpadding='5' border='1' bgcolor='#FFF0F5'>";

$exclude=array("billing_title","billing_first_name","billing_last_name", "billing_add_1","billing_city","billing_state","billing_zip");
	
	$readonly=array("buoy_id","park","contacts_id","year");
$date_array=array("buoy_receipt"=>'1',"app_date"=>'2');

	foreach($ARRAY as $num=>$row)
		{ 
			foreach($row as $fld=>$value){
				if(in_array($fld,$exclude)){continue;}
				$RO="";
				if(in_array($fld,$readonly)){$RO="readonly";}
				if($fld=="buoy_id")
					{
					$buoy_id=$value;
					}
				if($fld=="buoy_number")
					{
						echo " <tr>
						<td align='center'><b>buoy Number</b></td>
						<td align='center'><font size='+2' color='purple'>$value</font><input type='text' name='$fld' value=\"$value\" size='7'></td>
						</tr>";
						continue;
					}
		
				echo " <tr valign='top'><td align='right'>$fld</td>";
				
		$fld_array=$fld;
				$item="<input type='text' name='$fld_array' value=\"$value\" size='37'$RO>";//$img
				
				if($fld=="lat"){$lat=$value;}
				if($fld=="lon"){$lon=$value;}
				if($fld=="park"){$park=$value;}
				
				if($fld=="buoy_comment")
					{
						if($value){$d="block";}else{$d="none";}
						$item="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> toggle &#177</a></div>
	
						<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br><textarea name='$fld_array' cols='55' rows='15'>$value</textarea></div>";
					}
				
				if($fld=="contacts_id")
					{
					if($level>3){$RO="";}
						$item="<table><tr><td><input type='text' name='$fld' value=\"$value\" size='4'$RO> <input type='button' value='Pick Owner/Agent' onclick=\"return popitup('pick_owner.php?form=buoy&parkcode=$row[park]')\"></td></tr>
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
				
			if(array_key_exists($fld,$date_array))
						{
						if($value!="0000-00-00")
							{
							$var_df=explode("-",$value);
							$var_yf=$var_df[0];
							$var_mf=@$var_df[1];
							$var_df=@$var_df[2];
							}
							else
							{
							$var_yf="";
							$var_mf="";
							$var_df="";
							}
							
						$i=$date_array[$fld];
						$date_field="datefields".$i;
						$year_field="year-field".$i;
						$month_field="month-field".$i;
						$day_field="day-field".$i;
						if(!isset($email_to)){$email_to="";}
						$item="<div><span id=\"$date_field\" class=\"fromdate\">
							<label for=\"year-field\">Year: </label><input id=\"$year_field\" type=\"text\" name=\"$year_field\" value=\"$var_yf\" style=\"width: 4em;\">
							<label for=\"month-field\">Month: </label><input id=\"$month_field\" type=\"text\" name=\"$month_field\" value=\"$var_mf\"style=\"width: 2em;\">
							<label for=\"day-field\">Day: </label><input id=\"$day_field\" type=\"text\" name=\"$day_field\" value=\"$var_df\"style=\"width: 2em;\">
			         			</span>$email_to</div>";
						}
						
			echo "<td>$item</td></tr>";
			
			if($fld=="lake_zip"){echo "</table></td><td><table cellpadding='5' border='1'>";}
			
			
			}
		}
	
	echo "</table>";

if(!isset($message)){$message="";}
echo "
</td><td align='center'>
	<input type='hidden' name='buoy_id' value='$buoy_id'>
	<input type='submit' name='submit' value='Update'>
	</td><td>$message
	<input type='hidden' name='buoy_id' value='$edit'>
	<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td></tr>";
	
	include("lat_long_defaults.php");
	$lat_lon=${$park};
	if(!isset($pier_number)){$pier_number="";}
	$object=$park." [buoy_id=".$buoy_id."] [pier_num=".$pier_number."] - $bln";
	$zoom=$lat_lon['zoom'];
	echo "<tr>";
	if(!empty($lat))
		{
		echo "<td>
		Google Map => <a href='http://maps.google.com/maps?f=q&hl=en&geocode=&q=http://$domain/nrid/google_earth/$googleFile&z=16' target='_blank'>GM </a>
		</td>";
		}
	if(@$lat=="")
		{
		$lat=$lat_lon['lat'];
		$lon=$lat_lon['lon'];		
		}
	echo "<td>
		<input type='button' value='Map It!' onclick=\"return popitup('lat_long.php?lat=$lat&lon=$lon&zoom=$zoom&object=$object')\">
	</td>";
	echo "</tr>";
			
	echo "</table></div></form>
	<script language=\"JavaScript\" type=\"text/javascript\">
 var frmvalidator = new Validator(\"buoyForm\");
 frmvalidator.addValidation(\"buoy_number\",\"req\",\"Please enter a buoy number.\");
 
</script>
</html>";

?>