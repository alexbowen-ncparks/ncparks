<?php

session_start();

//echo "hello_world";


echo "<html>";
echo "<head>";
echo "<title> update_tables_a10</title>";
echo "</head>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=left > <font color=red><i>update_tables_a10</i></font></H1>";

//echo "<H3 ALIGN=center><A href=welcome.php>Return HOME </A></H3>";


echo
"<form method=post action=update_tables_a10_2.php>";
echo "<font size=5>"; 

echo "XTND_Date:";
echo "<input type='text' name='xtnd_date'>";

echo "<input type=submit value=UPDATE>";

echo "</font>";


echo "</form>";
echo "</body>";
echo "</html>";

?>