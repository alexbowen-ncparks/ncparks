<?php
extract($_REQUEST);

echo "<html><head>
<link type=\"text/css\" href=\"../../css/ui-lightness/jquery-ui-1.8.23.custom.css\" rel=\"Stylesheet\" />    
<script type=\"text/javascript\" src=\"../../js/jquery-1.8.0.min.js\"></script>
<script type=\"text/javascript\" src=\"../../js/jquery-ui-1.8.23.custom.min.js\"></script>

<script language='JavaScript'>

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
</script>
</head>
<title>NC DPR Seasonal Employment Database</title>";
include("../css/TDnull.inc");

echo "<body>";
echo "<div align='center'><table border='1' cellpadding='5' align='center'><tr>";

//include("../../include/get_parkcodes.php");
if(!isset($new_request_date)){$new_request_date="";}
echo "<td colspan='8' align='center' bgcolor='purple'><font size='+1' color='white'><b>Form to Request FY Cycle<br />of Seasonal Positions beginning $new_request_date</b></font></td></tr><tr>";

if($level<3)
	{
	
	// ******** Menu 0 *************   Level 1
	$menuArray1=array(
	"HR Home Page"=>"/hr/start.php",
	"Show Positions by Park"=>"/hr/fySeasonal/park_seasonals_fyt.php?file=Show Positions by Park");
	
if($level==2)
	{
	$menuArray1['FY CHOP Report-Dist']="/hr/fySeasonal/seasonal_database_report_fy.php?file=CHOP Report";
	$menuArray1['FY CHOP Report-Reg']="/hr/fySeasonal/seasonal_database_report_fy_reg.php?file=CHOP Report";
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
"Show Positions by Park"=>"/hr/fySeasonal/park_seasonals_fiscal_year.php?file=Show Positions by Park",
"FY Find Position"=>"/hr/fySeasonal/park_seasonals_find_fiscal_year.php?file=Find Position",
"FY Add Position"=>"/hr/fySeasonal/park_seasonals_add_fiscal_year.php?file=Add Position",
"FY OSBM Report"=>"/hr/fySeasonal/park_seasonals_osbm_fiscal_year.php?file=OSBM Report",
"FY OSBM Titles"=>"/hr/fySeasonal/position_justification_fiscal_year.php?file=OSBM Titles",
"FY CHOP Report-Reg"=>"/hr/fySeasonal/seasonal_database_report_fiscal_year_reg.php?file=CHOP Report"
);
// "FY CHOP Report-Dist"=>"/hr/fySeasonal/seasonal_database_report_fiscal_year.php?file=CHOP Report",

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