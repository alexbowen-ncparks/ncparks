<?php
$database="fixed_assets";
include("../../include/auth.inc");
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
extract($_REQUEST);
$level=$_SESSION['fixed_assets']['level'];
$tempID=$_SESSION['fixed_assets']['tempID'];

if($level<3)
	{
	if($_SERVER['PHP_SELF']=="/fixed_assets/change_location.php")
		{
		$allow=array("Law Enforcement Supervisor","Law Enforcement Manager");
		if(!in_array($_SESSION['fixed_assets']['beacon_title'], $allow)){echo "No access."; exit;}
		}
	}
date_default_timezone_set('America/New_York');

if($level<1)
	{
	echo "You do not have access to this database.";
	exit;
	}

if(empty($_REQUEST['rep']))
	{
	echo "<html><head>
	<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
	  <!-- main calendar program -->
	  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
	  <!-- language for the calendar -->
	  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
	  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
	  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>
	  
	<link type=\"text/css\" href=\"../css/ui-lightness/jquery-ui-1.8.23.custom.css\" rel=\"Stylesheet\" />    
	<script type=\"text/javascript\" src=\"../js/jquery-1.8.0.min.js\"></script>
	<script type=\"text/javascript\" src=\"../js/jquery-ui-1.8.23.custom.min.js\"></script>
	
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

	function popitup(url) {
			newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=1000,width=1130');
			if (window.focus) {newwindow.focus()}
			return false;
	}


	function radio_button_checker()
	{
	for (n=0; n<frmTest.length; n++){
		if(frmTest[n].type == 'radio'){

		var checkRadio=frmTest[n].name;
			if(checkRadio=='trans'){
				var radio_choice = false;
				for (counter = 0; counter < frmTest.trans.length; counter++)
					{
					if (frmTest.trans[counter].checked)
					radio_choice = true;
					}
				if (!radio_choice)
					{
					alert(\"Please select the vehicle\'s \"+ checkRadio + \" type.\")
					return (false);
					}
				//	return (true);
				}
			
			if(checkRadio=='duty'){
				var radio_choice = false;
				for (counter = 0; counter < frmTest.duty.length; counter++)
					{
					if (frmTest.duty[counter].checked)
					radio_choice = true;
					}
				if (!radio_choice)
					{
					alert(\"Please select the vehicle\'s \"+ checkRadio + \" type.\")
					return (false);
					}
				//	return (true);
				}
			
			if(checkRadio=='drive'){
				var radio_choice = false;
				for (counter = 0; counter < frmTest.drive.length; counter++)
					{
					if (frmTest.drive[counter].checked)
					radio_choice = true;
					}
				if (!radio_choice)
					{
					alert(\"Please select the vehicle\'s \" + checkRadio + \" type.\")
					return (false);
					}
				//	return (true);
				}
			
			if(checkRadio=='flex'){
				var radio_choice = false;
				for (counter = 0; counter < frmTest.flex.length; counter++)
					{
					if (frmTest.flex[counter].checked)
					radio_choice = true;
					}
				if (!radio_choice)
					{
					alert(\"Please select the vehicle\'s \" + checkRadio + \" type.\")
					return (false);
					}
				//	return (true);
				}
			
			if(checkRadio=='emergency'){
				var radio_choice = false;
				for (counter = 0; counter < frmTest.emergency.length; counter++)
					{
					if (frmTest.emergency[counter].checked)
					radio_choice = true;
					}
				if (!radio_choice)
					{
					alert(\"Please select the vehicle\'s \" + checkRadio + \" type.\")
					return (false);
					}
				//	return (true);
				}
			}
		}
	}
	//-->

	</script><title>Fixed Assets</title>
	</head>
	";

		$menu_array=array("Change of Location Form"=>"menu_fixed_assets.php?form_type=change_location");
	
		if($level>4)
			{
			$menu_array['Change of Location Admin']="menu_fixed_assets.php?form_type=admin_col";
			}
		
	echo "<body bgcolor='beige'><div align='center'>";

	if(!isset($form_type)){$form_type="";}
	if($form_type=="change_location"||$form_type=="")
		{
		echo "<img src='/inc/css/images/dpr_1.jpg'> ";
		}

	$d=date("D, M d, Y");
	$n=date('n'); //$n=1;
	if(empty($year))
		{
		if($n>1){$year=date('Y');}else{$year=date('Y')-1;}
		}

	echo "<table><tr><td><font color='brown'>NC DPR Fixed Assets</font> <select name='form_type'  onChange=\"MM_jumpMenu('parent',this,0)\">
	<option selected=''></option>";
	foreach($menu_array as $k=>$v)
		{
		if($v==$form_type){$s="selected";}else{$s="value";}
				echo "<option $s='$v'>$k</option>";
		}
	echo "</select> ";

	if($form_type=="form_B")
		{
		echo "for <font color='blue'>$year</font></td>";
		}
		else
		{
		echo "<font color='brown'>$d</font></td>";
		}
	echo "</tr></table></div>";
	
	}
$file=$form_type.".php"; // echo "$file";
	if($form_type){include("$file");}
?>