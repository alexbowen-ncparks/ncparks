<?php
extract($_REQUEST);
echo "<html><head>
<style type='text/css' media=screen>

photo {
position: absolute; 
left: 10px; top: 10px;  
padding: 1em;
}

text {
font-family:Arial;
font-size:7pt;
position: absolute; 
left: 160px; top: 30px;  
padding: 1em;
max-width:210px;
text-align: center
}

sec {
font-family:Arial;
font-size:8pt;
position: absolute; 
left: 190px; top: 150;  
padding: 1em;
}

sig {
font-family:Arial;
font-size:8pt;
position: absolute; 
left: 20px; top: 180;  
padding: 1em;
align: right;
}

dateLine {
font-family:Arial;
font-size:8pt;
position: absolute; 
left: 242px; top: 180;  
padding: 1em;
}

date {
font-family:Arial;
font-size:8pt;
position: absolute; 
left: 292px; top: 180;  
padding: 1em;
}

</style></head><body>";

//$Fname="Piping";
//$Lname="Plover";
$working_title=urldecode($working_title);
$photo="7827.jpg";
$today=date("M d, Y");

echo "<photo><img src='$photo' width='120'></photo>";

echo "<text>This is to certify that<br /><font size='0'><b>$Fname $Lname</b></font><br />whose photograph and signature appear hereon, is an employee of the North Carolina Division of Parks and Recreation, and holds the Title of:<br /><font size='0'><b>$working_title</b></font></text>";

echo "<sec>Signed: _______________________________<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bill Ross, Secretary</sec>";

echo "<sig>_______________________________<br />Employee's Signature</sig>";

echo "<dateLine>Date: ________________________</dateLine>";
echo "<date>$today</date>";

echo "</body></html>";
?>