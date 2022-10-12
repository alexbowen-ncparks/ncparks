<?php
echo "<html><head><script language='JavaScript'>


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


echo "//-->
</script>";

?>