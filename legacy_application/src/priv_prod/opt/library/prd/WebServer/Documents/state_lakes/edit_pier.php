<?php

session_start();
$level=$_SESSION['state_lakes']['level'];
if($level<3){$pass_park=$_SESSION['state_lakes']['select'];}


$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       extract($_REQUEST);


       if(@$_GET['del']=="1" and !empty($img_id))
       		{
		$sql = "SELECT * from pier_image_upload where id='$img_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		$row=mysqli_fetch_assoc($result); 
		extract($row);
		unlink($image_link);
		$sql = "DELETE from pier_image_upload where id='$img_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		}
       if(@$_POST['submit']=="Delete")
       		{
       		//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
			$sql = "SELECT contacts_id, pier_comment from piers where pier_id='$_POST[pier_id]'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
			$row=mysqli_fetch_assoc($result); extract($row);
			
			$sql = "UPDATE contacts set comment=if(comment!='',concat(comment,'\\n pier comment = ','$pier_comment'), 'pier comment = $pier_comment')  where id='$contacts_id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
			
			$sql = "DELETE FROM piers where pier_id='$_POST[pier_id]'";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
			
	//		if($pier_comment!=""){$add=" and the following Pier Comment added to the Owner/Agent comments: $pier_comment<br /><br />";}
			
       		echo "Record was successfully deleted$add. You may close this window.";exit;
       		}    
       
       if(@$_POST['submit']=="Update")
       		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		
if($_POST['park']==""){echo "Please specify a park.";exit;}
       		
       		$skip1=array("year","month","day","submit","billing_title","billing_last_name","billing_first_name","billing_city","billing_state","billing_add_1");
       		$skip2=array("submit","billing_title","billing_last_name","billing_first_name","billing_city","billing_state","billing_add_1");
       	
       		foreach($_POST AS $field=>$value)
       				{
       					if(in_array($field,$skip1)){continue;}
				
					$test=explode("-",$field);
					if(in_array($test[0],$skip1)){continue;}
				    					
       					@$clause.=$field."='".$value."',";
       				}
       						$id=$_POST['contacts_id'];
       						
// menu.php has the javascript that controls calendars - calendar(x)
$date_array=array("pier_payment"=>'1',"mod_pay_date"=>'2',"trans_pay_date"=>'3');
				
			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip2))
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
						
					@$clause.=$temp; $temp="";
					}
				}
			if(!isset($non_conforming)){$non_conforming="";}
			if(!isset($boatstall)){$boatstall="";}
       			$clause="set boatstall='$boatstall', non_conforming='$non_conforming',".rtrim($clause,",")." where pier_id='$pier_id'";
			$sql = "Update piers $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
			$clause="";
       				
			$edit=$pier_id;
			
			if(!empty($_FILES))
				{
// 				echo "<pre>"; print_r($_POST);  print_r($_FILES); echo "</pre>"; // exit;
				include("upload_pier_image.php");
				}
			$message="Update was successful.<br />Close window when done.";
       		}
       

$t1_fields="t1.park,t1.year,t1.pier_id,t1.pier_number,t1.contacts_id,t1.fee,t1.pier_payment,t1.check_number,t1.pier_comment,t1.mod_fee_amt,t1.mod_pay_date,t1.pier_mod_check,t1.transfer_fee,t1.trans_pay_date,t1.trans_check,t1.boatstall,t1.non_conforming,t1.pier_type,t1.pier_width,t1.pier_length,t1.pier_height,t1.delinq_yrs,t1.lat,t1.lon";

$t2_fields="t2.billing_title,t2.billing_first_name,t2.billing_last_name,t2.billing_add_1,t2.billing_city,t2.billing_state,t2.billing_zip";

$t3_fields="
    GROUP_CONCAT(t3.image_name) as 'image_name',
    GROUP_CONCAT(t3.image_link) as 'image_link'";

$sql = "SELECT $t1_fields,$t2_fields, $t3_fields
FROM piers as t1
LEFT JOIN contacts as t2 on t1.contacts_id=t2.id
LEFT JOIN pier_image_upload as t3 on t1.pier_id=t3.pier_id
WHERE  t1.pier_id='$edit'
group by t3.pier_id
"; //echo "$sql";
if($level>4)
	{
// 	echo "$sql";
	}
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(!isset($ARRAY)){echo "$message";exit;}


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
		{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1');
				if (window.focus) {newwindow.focus()}
				return false;
		}
</script>
<script type="text/javascript">
calendar(1);calendar(2);calendar(3);
</script>
</head>

<?php

echo "<body bgcolor='beige'  class=\"yui-skin-sam\"><form method='POST' name='pierForm' enctype='multipart/form-data'><div align='center'><table><tr><td><table cellpadding='5' border='1' bgcolor='#FFF0F5'>";

$exclude=array("billing_title","billing_first_name","billing_add_1","billing_last_name","billing_city","billing_state","billing_zip", "image_name");

$radio=array("pier_type");
$pier_type_array=array("p"=>"private","c"=>"commercial","s"=>"state/federal");
$checkbox=array("boatstall","non_conforming");
$date_array=array("pier_payment"=>'1',"mod_pay_date"=>'2',"trans_pay_date"=>'3');	

	$readonly=array("pier_id","park","contacts_id","year");
	foreach($ARRAY as $num=>$row)
		{
			foreach($row as $fld=>$value)
			{
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
		$display_fld=$fld;
		if($fld=="pier_width" || $fld=="pier_length" || $fld=="pier_height")
			{$display_fld="$fld [in feet]";}
		if($fld=="image_link")
			{$display_fld="Pier Images";}
			
			echo " <tr valign='top'><td align='right'>$display_fld</td>";
				
		$fld_array=$fld;
		if(!isset($img))
			{$img="";}
				$item="<input type='text' name='$fld_array' value=\"$value\" size='37'$RO>$img";
				
				if($fld=="lat"){$lat=$value;}
				if($fld=="lon"){$lon=$value;}
				if($fld=="park"){$park=$value;}
				if($fld=="pier_id"){$pier_id=$value;}
				
				if($fld=="pier_comment")
					{
					if($value){$d="block";}else{$d="none";}
					$id=$row['pier_id'];
					$item="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> toggle &#177</a></div>
					
					<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br><textarea name='$fld_array' cols='55' rows='15'>$value</textarea></div>";
					}
				
				if($fld=="contacts_id")
					{
					if($level>3){$RO="";}
						$item="<table><tr><td><input type='text' name='$fld' value=\"$value\" size='4'$RO> <input type='button' value='Pick Owner/Agent' onclick=\"return popitup('pick_owner.php?form=pier&parkcode=$row[park]')\"></td></tr>
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
			
			
			if(in_array($fld,$checkbox))
				{
				if($value=="x"){$ck="checked";}else{$ck="";}
				echo "<td><input type='checkbox' name='$fld' value='x' $ck></td></tr>";
				continue;
				}
				
			if(array_key_exists($fld,$date_array))
						{
						if($value!="0000-00-00")
							{
							$var_df=explode("-",$value);
							$var_yf=$var_df[0];
							@$var_mf=$var_df[1];
							@$var_df=$var_df[2];
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
							@$var_item.="<input type='radio' name='$fld' value='$val' $ck>$v ";
							$ck="";
						}
						$item=$var_item; $var_item="";
				}
				
			
			if($fld=="image_link")
				{
				$item="";
				if(!empty($value))
					{
// 					echo "$value";
					$exp=explode(",",$value);
					$exp1=explode(",",$row['image_name']);
// 					echo "<pre>"; print_r($exp); echo "</pre>";
					foreach($exp as $k=>$v)
						{
						$exp2=explode("_", $v);
						$var_id=$exp2[3];
						$display_val=$exp1[$k];
						$item.="<a href='$exp[$k]' target='_blank'>View image</a> $display_val";
						
						$item.=" <a href='edit_pier.php?edit=$edit&del=1&img_id=$var_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a><br />";
						}
					}
					else
					{$item="Not uploaded.";}
				
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
	if($level>0)
		{
		echo "<td><input type='file' name='file_upload[]'></td>";
		}
	echo "</tr></table>";
	
if(!isset($message)){$message="";}
echo "
</td><td align='center'>
	<input type='hidden' name='pier_id' value='$row[pier_id]'>
	<input type='submit' name='submit' value='Update'>
	</td><td>$message
	<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td></tr>";
	echo "</table></td></tr>";
	echo "</table></div></form></body></html>";

?>