<?php
/*
if($level < '3')

{echo "<table border='1'><tr>";

echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	</a>
</th>";

echo "<th>
<a href='/budget/infotrack/missions.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/wheelhouse1.png' alt='picture of wheelhouse' title='Wheelhouse'></img>	</a>
</th>";

echo "<th>
<a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits'></img></a>
</th>";

echo "<th>
<a href='/budget/loss_prevent/roles.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/money_safe_copper1.png' alt='picture of money safe' title='Money Safety'></img></a>
</th>";

echo "<th>
<a href='/budget/infotrack/notes.php?project_note=note_tracker'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/message_green1.png' alt='message icon' title='Messages'></img></a>
</th>";

echo "<th>
<a href='/budget/games/multiple_choice/games.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/checkers_board1.png' alt='games icon' title='Games'></img></a>
</th>";

echo "<th>
<a href='/budget/infotrack/position_reports.php?menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img></a>
</th>";



echo "</tr></table>";
}

else
*/

echo "
<table border='1' align='center'>
<tr>";


if($level < '3' or $beacnum=='60032787' or $beacnum=='60032780' or $beacnum=='60032945' or $beacnum=='60092637' or $beacnum=='60033189' or $beacnum=='60033242' )
{
echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	</a>
</th>";
}
else
{
echo "<th>
<a href='/budget/home.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	</a>
</th>";
}

echo "<th>
<a href='/budget/infotrack/missions.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/wheelhouse1.png' alt='picture of wheelhouse' title='Wheelhouse'></img>	</a>
</th>";


echo "<th>
<a href='/budget/admin/crj_updates/bank_deposits.php?add_your_own=y'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits'></img></a>
</th>";


echo "<th>
<a href='/budget/loss_prevent/roles.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/money_safe_copper1.png' alt='picture of money safe' title='Money Safety'></img></a>
</th>";


echo "<th>
<a href='/budget/infotrack/notes.php?project_note=note_tracker'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/message_green1.png' alt='message icon' title='Messages'></img></a>
</th>";
echo "<th>
<a href='/budget/games/multiple_choice/games.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/checkers_board1.png' alt='games icon' title='Games'></img></a>
</th>";

echo "<th>
<a href='/budget/infotrack/position_reports.php?menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img></a>
</th>";

if($level < '3' or $beacnum=='60032787' or $beacnum=='60032780' or $beacnum=='60032945' or $beacnum=='60092637' or $beacnum=='60033189' or $beacnum=='60033242' )
{
echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/target_dart1.png' alt='dartboard bullseye' title='Budget Targets'></img></a>
</th>";
}
else
{
echo "<th>
<a href='/budget/home.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/target_dart1.png' alt='dartboard bullseye' title='Budget Targets'></img></a>
</th>";
}


echo "<th>
<a href='/budget/infotrack/procedures.php?folder=community&menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/compass_blue1.png' alt='compass icon' title='Directions/Procedures'></img></a>
</th>";


echo "<th>
<a href='/budget/infotrack/bright_idea2.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/light_bulb1.png' alt='light bulb icon' title='Bright Ideas'></img></a>
</th>";

$tempid2=substr($tempid,0,-2);
if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}
echo "<th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><font color='green'>$concession_location2<br /> $tempid2</font>
</th>";


echo "</tr></table>";




?>