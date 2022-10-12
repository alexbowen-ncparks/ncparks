<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>";

$test=$_SERVER['QUERY_STRING'];
IF(strpos($test,"../")>-1)
	{
	header("Location: http://www.fbi.gov");
	exit;
	}
$title="FOFI Permit Database";

session_start();
if(@$_SESSION['FOFI']=="")
	{
	include("/opt/library/prd/WebServer/Documents/inc/_base_top_fofi.php");
	include("login_form.php");
	exit;
	}
	else
	{
	include("/opt/library/prd/WebServer/Documents/inc/_base_top_dpr.php");
	}
?>
	
<div id="page" align="left">
	<div id="content" align="left">
		<div id="menu" align="left">
			<div align="left" style="width:140px; height:8px;"><img src="/inc/css/images/mnu_topshadow.gif" width="143" height="8" alt="mnutopshadow" />
			</div>
			<div id="linksmenu" align="center">
					
<?php
include("fofi_menu.php");
?>
			</div>
			<div align="left" style="width:140px; height:8px;"><img src="/inc/css/images/mnu_bottomshadow.gif" width="143" height="8" alt="mnubottomshadow" />
			</div>
		</div>
		<div id="contenttext">
			<div class="bodytext" style="padding:12px;">
