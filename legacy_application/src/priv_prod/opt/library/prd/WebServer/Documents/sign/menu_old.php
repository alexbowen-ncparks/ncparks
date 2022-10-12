<?php
if(!isset($_SESSION)){session_start();}
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

extract($_REQUEST);
@$level=$_SESSION['sign']['level'];
@$tempID=$_SESSION['sign']['tempID'];

if(@$level<3)
	{
	@$pass_park=$_SESSION['sign']['select'];
	}

if(@$level<1)
	{
	echo "You must be logged into the Sign Database to use it.<br /><br />Login <a href='/sign/'>here</a>."; exit;
	}


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

<?php

echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar-setup.js\"></script>
  
  <script language='JavaScript'>
  
function scrollWindow()
  {
  window.scrollTo(0,1000)
  }
  
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}

function toggleDisplay(objectID)
	{
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++)
		{
		
		var object = inputs[i];
		state = object.style.display;
			if (state == 'block')
		object.style.display = 'none';	
		}
		
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
	}

function toggleDiv(objectID)
	{	
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
	}
function popitup(url) {
        newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=950');
        if (window.focus) {newwindow.focus()}
        return false;
}

function checkRadio (frmName, rbGroupName) { 
 var radios = document[frmName].elements[rbGroupName]; 
 for (var i=0; i <radios.length; i++) { 
  if (radios[i].checked) { 
   return true; 
  } 
 } 
 return false; 
} 

function valFrm() { 
		 if (!checkRadio(\"frm1\",\"matrix1_content[0]\")) 
  		alert(\"Please select a value for row 1\"); 
		 if (!checkRadio(\"frm1\",\"matrix1_content[1]\")) 
  		alert(\"Please select a value for row 2\"); 
		 if (!checkRadio(\"frm1\",\"matrix1_content[2]\")) 
  		alert(\"Please select a value for row 3\"); 
} 
//-->
</script>";
?>

<script type="text/javascript">function calendar(calendarID) {
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
	}</script>
<script type="text/javascript">
calendar(1);calendar(2);calendar(3);calendar(4);calendar(5);calendar(6);calendar(7);calendar(8);
</script>
</head>

<?php
if(!isset($tab)){$tab="";}
echo "<title>$tab DPR Sign Request</title>";
@include("../css/TDnull.php");
	
//	echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<body><div align='center'>";

if($_SERVER['PHP_SELF']=="/sign/menu.php")
	{//<img src='images/clne.jpg'>
	echo "<font color='brown'>NC DPR Sign Requisition / Special Order Website<br /><img src='images/trails.jpg'><img src='images/auth_vehicle.jpg'><img src='images/swim.jpg'><img src='images/camp.jpg'><img src='images/park_lot.jpg'><br />Welcome</font><br />";
	}

$color_array=array("Track a Sign Request"=>"lightgreen","Sign Forms/Guidelines/Appendix"=>"yellow","Instructions"=>"#C6E2FF","Submit a Sign Request"=>"#FFE4C4","Submit a Sign Request - TEST"=>"#00FFFF");

$path="/sign/";

$menu_array['Track a Sign Request']=$path."track.php";

$menu_array['Submit a Sign Request']=$path."add_request_1.php";


if($level>3)
	{
//	$menu_array['Submit a Sign Request - TEST']=$path."add_request_1.php";
	}

$menu_array['Sign Forms/Guidelines/Appendix']="/find/forum.php?forumID=139,189&submit=Go";

$menu_array['Instructions']="/find/forum.php?forumID=291&submit=Go";


if($level>3)
	{
	$menu_array['Admin Functions']=$path."admin.php";
	}

if($level>3)
	{
	$menu_array['Portal']="../portal.php?database=sign";
	}
	
echo "<table>";
foreach($menu_array as $k=>$v)
	{
		@$color=$color_array[$k];
		if($k=="Sign Forms/Guidelines/Appendix" || $k=="Instructions" ||$k=="Portal")
		{
		$v=htmlentities($v);
		echo "<td><FORM method='POST' action=\"$v\" target=\"_blank\">
<INPUT type=submit value=\"$k\" style=\"background-color:$color\"></FORM></td>";}
		else
		{$target="";
		echo "<td><form action='$v' $target>
		<input type='submit' name='submit' value='$k'  style=\"background-color:$color\"></form></td>";
		}
	}
echo "</tr></table>";

?>