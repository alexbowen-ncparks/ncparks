<?phpinclude("../../../include/authBUDGET.inc");include("css/TDnull.inc");echo "<html><head><script language='JavaScript'><!--function MM_jumpMenu(targ,selObj,restore){ //v3.0  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");  if (restore) selObj.selectedIndex=0;}function confirmLink(){ bConfirm=confirm('Are you sure you want to delete this record?') return (bConfirm);}function toggleDisplay(objectID) {	var inputs=document.getElementsByTagName('div');		for(i = 0; i < inputs.length; i++) {			var object = inputs[i];		state = object.style.display;			if (state == 'block')		object.style.display = 'none';			}			var object = document.getElementById(objectID);	state = object.style.display;	if (state == 'none')		object.style.display = 'block';	else if (state != 'none')		object.style.display = 'none'; }function popitup(url) {        newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=1000,width=750');        if (window.focus) {newwindow.focus()}        return false;}function radio_button_checker(){for (n=0; n<frmTest.length; n++){	if(frmTest[n].type == 'radio'){	var checkRadio=frmTest[n].name;		if(checkRadio=='trans'){			var radio_choice = false;			for (counter = 0; counter < frmTest.trans.length; counter++)				{				if (frmTest.trans[counter].checked)				radio_choice = true;				}			if (!radio_choice)				{				alert(\"Please select the vehicle\'s \"+ checkRadio + \" type.\")				return (false);				}			//	return (true);			}					if(checkRadio=='duty'){			var radio_choice = false;			for (counter = 0; counter < frmTest.duty.length; counter++)				{				if (frmTest.duty[counter].checked)				radio_choice = true;				}			if (!radio_choice)				{				alert(\"Please select the vehicle\'s \"+ checkRadio + \" type.\")				return (false);				}			//	return (true);			}					if(checkRadio=='drive'){			var radio_choice = false;			for (counter = 0; counter < frmTest.drive.length; counter++)				{				if (frmTest.drive[counter].checked)				radio_choice = true;				}			if (!radio_choice)				{				alert(\"Please select the vehicle\'s \" + checkRadio + \" type.\")				return (false);				}			//	return (true);			}					if(checkRadio=='flex'){			var radio_choice = false;			for (counter = 0; counter < frmTest.flex.length; counter++)				{				if (frmTest.flex[counter].checked)				radio_choice = true;				}			if (!radio_choice)				{				alert(\"Please select the vehicle\'s \" + checkRadio + \" type.\")				return (false);				}			//	return (true);			}					if(checkRadio=='emergency'){			var radio_choice = false;			for (counter = 0; counter < frmTest.emergency.length; counter++)				{				if (frmTest.emergency[counter].checked)				radio_choice = true;				}			if (!radio_choice)				{				alert(\"Please select the vehicle\'s \" + checkRadio + \" type.\")				return (false);				}			//	return (true);			}		}	}}//--></script></head><title>NC DPR Warehouse Inventory</title>";?>