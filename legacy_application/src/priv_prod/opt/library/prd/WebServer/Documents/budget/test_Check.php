<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 	<html xmlns="http://www.w3.org/1999/xhtml"> 	<head> 	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 	<title>Untitled Document</title> 	<script> 	function smo_selectRadioValues(value,theElements) {     var formElements = theElements.split(',');	 for(var z=0; z<formElements.length;z++){	  theItem = document.getElementById(formElements[z]);	  if(theItem){	  theInputs = theItem.getElementsByTagName('input');	  for(var y=0; y<theInputs.length; y++){	   if(theInputs[y].type == 'radio'){         theName = theInputs[y].name;         if(theInputs[y].value==value){		   theInputs[y].checked='checked';		 }	    }	  }	  }     }    }    </script> 	</head> 	<body> 	<?phpecho "<form id='anotherForm' action='/'>Yes<input type='radio' value='y' name='answerController' id='yesController' onclick=\"smo_selectRadioValues(this.value,'frm')\"/><input type='radio' value='n' name='answerController' id='noController' onclick=\"smo_selectRadioValues(this.value,'frm')\"/></form><br /><br /><form id='frm' action='/'>";for($i=1;$i<4;$i++){$j++;echo "Yes<input type='radio' value='y' name='a_division_approved[$i][$j]' id='yes'/>No<input type='radio' value='n' name='a_division_approved[$i][$j]' id='no'/>Yes<input type='radio' value='y' name='a_district_approved[$i][$j]' id='yes'/>No<input type='radio' value='n' name='a_district_approved[$i][$j]' id='no'/><br />";}?></form></body> 	</html>