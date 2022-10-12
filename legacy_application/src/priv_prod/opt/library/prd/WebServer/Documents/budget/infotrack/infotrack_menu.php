<?php
//echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table border='1'>";

echo "<tr>";

//echo "filegroup=$filegroup";

{

if($filegroup=='alerts')

{echo "<td><font size='4' class='cartRow'><b><a href='alerts.php'>Alerts</a></b></font></td>";}



if($filegroup!='alerts') 

{echo "<td><font size='4' ><b><a href='alerts.php' >Alerts</a></b></font></td>";}



}



if($filegroup=='messages')

{echo "<td align='center'><font size='4' class='cartRow'><b><a href='messages.php' >Messages</a></b></font></td>";}



if($filegroup!='messages') 

{echo "<td align='center'><font size='4' ><b><a href='messages.php' >Messages</a></b></font></td>";}

if($filegroup=='notes')

{echo "<td align='center'><font size='4' class='cartRow'><b><a href='notes.php?project_note=note_tracker' >Notes</a></b></font></td>";}



if($filegroup!='notes') 

{echo "<td align='center'><font size='4' ><b><a href='notes.php?project_note=note_tracker' >Notes</a></b></font></td>";}


echo "</tr>";

echo "</table>";

//echo "filegroup=$filegroup";





?>







