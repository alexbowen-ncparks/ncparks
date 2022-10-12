<?php
//echo "<p>Hello!</p>";


ini_set('display_errors',1);
$database="invasive_species";
$db="invasive_species";
require '../../include/auth.inc';
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION[$database]); echo "</pre>"; // exit;
require '../../include/iConnect.inc';
//require('utilities/main.php');
include $_SERVER['DOCUMENT_ROOT'] . "/invasive_species/header.php";
include $_SERVER['DOCUMENT_ROOT'] . '/invasive_species/sidebar.php';




echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
echo "<main><div>";
echo "<table>";
echo "<tr>
		<td class='head'>
			Welcome to the DPR Invasive Species website.
		</td>
	</tr>";

echo "<tr>
		<td>
			<p>
				<font color='#99cc00' size='+1'>
					Test
				</font>
			</p>
				<p>
					text.......
				</p>
				<p>

					DB: $db <br/>
					Database: $database <br/>
					connection: " . $user . "<br/>

					

				</p>
		</td>
	</tr>";
echo "<tr><td></td></tr>";
echo "</table>";
echo "</div></main>";
include('footer.php');
?>