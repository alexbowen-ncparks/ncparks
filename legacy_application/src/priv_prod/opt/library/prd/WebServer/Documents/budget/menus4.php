<?php
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

  <head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> 
    <title>MoneyTracker</title>
<link rel='stylesheet' type='text/css' href='/budget/home4.css' />";
echo "<script language='JavaScript'>

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
function add() {
var test = \"transfer\";
var sum = 0;
var valid = true;
var inputs = document.getElementsByTagName( 'input');
for(i =0; i < inputs.length; i++) {
if(inputs[i].name.substr(0,8)==test) {
var str_rep=inputs[i].value.replace(/,/, \"\");
sum += parseFloat(str_rep);}
}

if(valid) {
document.getElementById( 'sum').value = Math.round(sum*100)/100;
}
else{
var a1=sum+test;
alert(a1);
}
}
";

echo " 
function smo_selectRadioValues(value,theElements) {
     var formElements = theElements.split(',');
	 for(var z=0; z<formElements.length;z++){
	  theItem = document.getElementById(formElements[z]);
	  if(theItem){
	  theInputs = theItem.getElementsByTagName('input');
	  for(var y=0; y<theInputs.length; y++){
	   if(theInputs[y].type == 'radio'){
         theName = theInputs[y].name;
         if(theInputs[y].value==value){
		   theInputs[y].checked='checked';
		 }
	    }
	  }
	  }
     }
    }

function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=800,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}
function calc_add() { 
var inp = document.getElementById(\"equip_request_2\").unit_quantity.value 
var func = document.getElementById(\"equip_request_2\").unit_cost.value 
var outp = 0 

outp = (inp - 0)*(func-0) 

document.equip_request_2.requested_amount.value = outp 
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
function CheckAll_0()
{
count = document.frm_0.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm_0.elements[i].checked == 1)
    	{document.frm_0.elements[i].checked = 1; }
    else {document.frm_0.elements[i].checked = 1;}
	}
}
function UncheckAll_0(){
count = document.frm_0.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm_0.elements[i].checked == 1)
    	{document.frm_0.elements[i].checked = 0; }
    else {document.frm_0.elements[i].checked = 0;}
	}
}
</script>
";	
echo "</head>";
echo "
<div>
        <a href='/budget/mymoneycounts.php'>
		<img width='50%' height='20%' src='/budget/nrid_logo.jpg' alt='roaring gap photos'></img>
		</a>
		
</div>";
     
?>	   
	   