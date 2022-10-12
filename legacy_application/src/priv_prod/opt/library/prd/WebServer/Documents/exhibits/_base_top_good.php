<?php
session_start();
if ($_SESSION['work_order']['level']<1){header("Location: index.html");exit();}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="expires" content="0">
<meta http-equiv="expires" content="Tue, 14 Mar 2000 12:45:26 GMT">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="../css/images/style.css" type="text/css" />
	<link rel="icon" href="../icon.jpg" type="image/jpg"/>

<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function JumpTo(theMenu){
                var theDestination = theMenu.options[theMenu.selectedIndex].value;
                var temp=document.location.href;
                if (temp.indexOf(theDestination) == -1) {
                        href = window.open(theDestination);
                        }
        }
        
function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

function popitup(url)
{   newwindow=window.open(url,"name","resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1");
        if (window.focus) {newwindow.focus()}
        return false;
}        
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
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
function checkform ( form )
{
  if (form.park.value == "") {
    alert( "Please enter your email address." );
    form.park.focus();
    return false ;
  }
  return true ;
}
// -->
</script>
<style>
div.floating-menu {position:fixed;width:130px;z-index:100;}
div.floating-menu a {display:block;margin:0 0.3em;}
</style>	
	<title>Museum of Natural Sciences</title>
</head>

<?php
//background:#fff4c8;border:1px solid #ffcc00;
if($_SERVER['PHP_SELF']=="/work_order/county_list.php")
	{echo "<body bgcolor='white'>";}else{echo "<body>";}
?>


<div align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td align="center" valign="top" style="width:1024px;height:48px;" class="titletext" bgcolor='#800080'>
     Exhibits & Emerging Media Work Order:
    </td>
  </tr>
  <tr>
  <td align="center" valign="top" style="width:1024px;height:40px;" class="mediumwhitetext" bgcolor='#800080'>
     for exhibits, multimedia, and exhibit related graphics
    </td>
  </tr>
  <tr>
  <td align="center" valign="top" style="width:1024px;height:1px;" class="mediumwhitetext" bgcolor='#800080'>
    </td>
  </tr>
</table>

				</div>
		
		
	<div id="page" align="left">
		<div id="content" align="left">
			<div id="menu" align="left">
				<div align="left" style="width:148px; height:8px;"><img src="/css/images/mnu_topshadow_1.gif" width="148" height="8" alt="mnutopshadow" />
				</div>
				<div id="linksmenu" align="left">
					
<?php
//echo "<div class='floating-menu'>";
echo "<div>";
include("menu.php");
?>
<div align="left" style="width:140px; height:8px;"><img src="/css/images/mnu_bottomshadow.gif" width="148" height="8" alt="mnubottomshadow" /></div>
<?php
echo "</div>";
?>
			</div>
				
			</div>
<div id="contenttext">
			<div class="bodytext" style="padding:2px;">