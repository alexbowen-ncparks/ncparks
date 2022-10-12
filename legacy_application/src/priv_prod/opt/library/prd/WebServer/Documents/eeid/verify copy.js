<script Language="JavaScript">

function validRequired(formField,fieldLabel)
{
	var result = true;
	
	if (formField.value == "")
	{
		alert('Please enter a value for the "' + fieldLabel +'" field.');
		formField.focus();
		result = false;
	}
	
	return result;
}


function validRequired2(formField1,formField2,fieldLabel)
{
	var result = true;
	
	if ((formField1.value == "") and (formField2.value == ""))
	{
		alert('Please enter a value for the "' + fieldLabel1 +'" field.');
		formField.focus();
		result = false;
	}
	
	return result;
}

function allDigits(str)
{
	return inValidCharSet(str,"0123456789");
}

function inValidCharSet(str,charset)
{
	var result = true;

	// Note: doesn't use regular expressions to avoid early Mac browser bugs	
	for (var i=0;i<str.length;i++)
		if (charset.indexOf(str.substr(i,1))<0)
		{
			result = false;
			break;
		}
	
	return result;
}

function validNum(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		if (!allDigits(formField.value))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}


function validInt(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		var num = parseInt(formField.value,10);
 		if (isNaN(num))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}


function validDate(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		var elems = formField.value.split("-");
 		
 		result = (elems.length == 3); // should be three components
 		
 		if (result)
 		{
 			var year = parseInt(elems[0],10); // convert text to number base 10
  			var month = parseInt(elems[1],10);
 			var day = parseInt(elems[2],10);
 			
//   returns true for period 2004-7-1 to 2005-6-30	 
			result = (allDigits(elems[2]) && (day > 0) && (day < 32)) &&
			 		(allDigits(elems[1]) && (month > 6) && (month < 13) && (year == 2004) || allDigits(elems[1]) && (month > 0) && (month < 7) && (year == 2005))
&&					allDigits(elems[0]) && (elems[0].length == 4);
 		}
 		
  		if (!result)
 		{
 			alert('Please enter a date in the format YYYY-MM-DD for the "' + fieldLabel +'" field. Also check to make sure the date is in the proper range for this Fiscal Year.');
			formField.focus();		
		}
	} 
	
	return result;
}

function validateForm(theForm)
{
	// Customize these calls for your form

	// Start ------->
	if (!validDate(theForm.dateprogram,"Date of Program",true))
		return false;
		
	if (!validRequired2(theForm.presenter,theForm.presenterX,"Presented by"))
		return false;
	if (!validRequired2(theForm.progtitle,theForm.progtitleX,"Title of Program"))
		return false;

	if (!validRequired(theForm.county,"County"))
		return false;

	if (!validNum(theForm.category,"Category",true))
		return false;
	if (!validNum(theForm.timegiven,"Times Given",true))
		return false;
	if (!validNum(theForm.attend,"Attend",true))
		return false;
	// <--------- End
	
	return true;
}
</script>