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

{echo "
<table border='1'>
<tr>";


if($level < '3')

echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	</a>
</th>";
else
echo "<th>
<a href='/budget/home.php'>
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

if($level < '3')
echo "<th>
<a href=''>
<img height='50' width='50' src='/budget/infotrack/icon_photos/target_dart1.png' alt='dartboard bullseye' title='MoneyTargets'></img></a>
</th>";
else
echo "<th>
<a href=''>
<img height='50' width='50' src='/budget/infotrack/icon_photos/target_dart1.png' alt='dartboard bullseye' title='MoneyTargets'></img></a>
</th>";



echo "</tr></table>";
}



?>