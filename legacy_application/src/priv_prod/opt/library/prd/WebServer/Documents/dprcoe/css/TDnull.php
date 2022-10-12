<STYLE TYPE="text/css">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%}
th
{font-size:90%; vertical-align: bottom}
--> 
</STYLE>

<?php
if(@$setDate==1){echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>";}
?>

<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}

function formHandler(form) {
var windowprops = "height=600,width=1000,location=no,"
+ "scrollbars=yes,menubars=no,toolbars=no,resizable=yes";

var URL = form.site.options[form.site.selectedIndex].value;
popup = window.open(URL,"MenuPopup",windowprops);
}

var newwindow = '';
function MM_jumpNewWindow(selObj,restore){

 var url = selObj.options[selObj.selectedIndex].value; 
 
if (!newwindow.closed && newwindow.location)
	{
		newwindow.location.href = url;
	}
	else
	{
		newwindow=window.open(url,'name','height=700,width=1000,scrollbars=1,resizable=1');
		if (!newwindow.opener) newwindow.opener = self;
	}
	if (window.focus) {newwindow.focus()}
	return false;
}


function CheckAll()
{
count = document.frm.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm.elements[i].checked == 1)
    	{document.frm.elements[i].checked = 0; }
    else {document.frm.elements[i].checked = 1;}
	}
}
function UncheckAll(){
count = document.frm.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm.elements[i].checked == 1)
    	{document.frm.elements[i].checked = 0; }
    else {document.frm.elements[i].checked = 1;}
	}
}

//--></SCRIPT>
</head>