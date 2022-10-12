<?php
echo "<hr /><table align='center' cellpadding='5'>";

if($level<3)
	{$parkcode=$_SESSION['le']['select'];}
	else{$parkcode="";}
	
if($level==1 and strpos($_SESSION['position'],"Park Superintendent")>-1)
	{
	echo "<tr><th>Park Superintendent Admin Functions.</th></tr>";
	echo "<tr><th><a href='level.php'>Review</a> PR-63 / DCI submitted for approval.</th></tr>
	";
	}
	
if($level==2)
	{
	echo "<tr><th>DISTRICT Admin Functions.</th></tr>
	<tr><td><a href='level.php'>Review</a> PR-63 / DCI submitted for approval.</td></tr>
	";
	}

if($level==3)
	{
	echo "<tr><th>LE Admin Functions will go here.</th></tr>
	<tr><td><a href='level3.php'>Review</a> PR-63 / DCI submitted for approval.</td></tr>
	";
	}

if($level>3)
	{
	echo "<tr><th>PR-63 / DCI SuperAdmin Functions will go here.</th></tr>
	<tr><td><a href='level.php'>Review</a> submitted PR-63s / DCIs.</td></tr>
	";
	}

$pio_access=array("Howard6319","Nealson7511","Carter5486");
// $pio_access=array("Howard6319");
if(in_array($_SESSION['le']['tempID'], $pio_access))
	{
	echo "<tr><th>PR-63 / PIO.</th></tr>
	<tr><td><a href='pr63_form_pio.php'>PIO</a> dev version Add.</td></tr>
	<tr><td><a href='find_pr63_pio.php'>PIO</a> dev version Find.</td></tr>
	";
	}
echo "</table>";
// echo "<pre>"; print_r($_SESSION); echo "</pre>";

?>