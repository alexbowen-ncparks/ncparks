<?php
extract($_REQUEST);
//include("../../include/authBUDGET.inc");
//include("../../include/connectBUDGET.inc");
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;

echo "<html><head><script language='JavaScript'>

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

function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

";

echo " 

function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=800,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}

function CheckAll()
{
count = document.frm.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm.elements[i].checked == 1)
    	{document.frm.elements[i].checked = 1; }
    else {document.frm.elements[i].checked = 1;}
	}
}
function UncheckAll(){
count = document.frm.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm.elements[i].checked == 1)
    	{document.frm.elements[i].checked = 0; }
    else {document.frm.elements[i].checked = 0;}
	}
}

function CheckAll_id(count)
{
	// cycle thru all checkbox park level ids 
	for(var i=1; i<=count; i++)
		{
		if(document.getElementById('ck'+String(i)).checked == 0)
			{
			document.getElementById('ck'+String(i)).checked=1;
			}
		}
}
function UncheckAll_id(count)
{
	// cycle thru all checkbox park level ids 
	for(var i=1; i<=count; i++)
		{
		if(document.getElementById('ck'+String(i)).checked == 1)
			{
			document.getElementById('ck'+String(i)).checked=0;
			}
		}
}

function checkJustification(count)
	{	
	// cycle thru all textarea ids 
	var j=0;
	for(var i=1; i<=count; i++)
		{
		var boxeschecked=document.getElementById('just'+String(i)).value;
		if(boxeschecked == false && document.frm_0.elements[j].checked == 1)
			{
			alert(\"Please enter a justification.\");
			return false;
			}
		j++;
		}
	}
";

echo "//-->
</script><title>NC DPR Seasonal Employment Database</title>";
include("../css/TDnull.inc");

echo "<body>";
echo "<div align='center'><table border='1' cellpadding='5' align='center'><tr>";

//include("../../include/get_parkcodes.php");
if(!isset($new_request_date)){$new_request_date="";}
echo "<td colspan='8' align='center' bgcolor='purple'><font size='+1' color='white'><b>Form to Request NEXT Cycle<br />of Seasonal Positions beginning $new_request_date</b></font></td></tr><tr>";

if($level<3)
	{
	
	// ******** Menu 0 *************   Level 1
	$menuArray1=array(
	"HR Home Page"=>"/hr/start.php",
	"Show Positions by Park"=>"/hr/bSeasonal/park_seasonals_next.php?file=Show Positions by Park");
	
if($level==2)
	{$menuArray1['Next CHOP Report']="/hr/bSeasonal/seasonal_database_report_next.php?file=CHOP Report";
	}
	
	echo "<td align='center'><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";
	$s="value";
	//if($file==""){$file="Show Positions by Park";}
	foreach($menuArray1 as $k=>$v)
		{
		if(@$file==$k){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$k</option>";
		   }
	   echo "</select></form></td></tr>";
	}

if($level>2){

// ******** Menu 1 *************   Admin References
$menuArray1=array(
"HR Home Page"=>"/hr/start.php",
"Show Positions by Park"=>"/hr/fySeasonal/park_seasonals_fy.php?file=Show Positions by Park",
"Next Find Position"=>"/hr/fySeasonal/park_seasonals_find_fy.php?file=Find Position",
"Next Add Position"=>"/hr/fySeasonal/park_seasonals_add_fy.php?file=Add Position",
"Next OSBM Report"=>"/hr/fySeasonal/park_seasonals_osbm_fy.php?file=OSBM Report",
"Next OSBM Titles"=>"/hr/fySeasonal/position_justification_fy.php?file=OSBM Titles",
"Next CHOP Report"=>"/hr/fySeasonal/seasonal_database_report_fy.php?file=CHOP Report");


echo "<td align='center'><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";
$s="value";
//if($file==""){$file="Show Positions by Park";}
foreach($menuArray1 as $k=>$v)
	{
	if(@$file==$k){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$k</option>";
       }
   echo "</select></form></td></tr>";
}

echo "</table></div>";

?>